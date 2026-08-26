"use server";

import { z } from "zod";
import { mkdir, writeFile } from "fs/promises";
import path from "path";
import { db } from "@/lib/db";
import { splitLines } from "@/lib/constants";

const waRegex = /^(\+?62|0)[2-9]\d{7,12}$/;

export const registrationSchema = z.object({
  competitionId: z.string().min(1, "Lomba harus dipilih"),
  fullName: z.string().min(3, "Nama lengkap wajib diisi"),
  nisn: z.string().regex(/^\d{10}$/, "NISN harus 10 digit angka"),
  gender: z.enum(["L", "P"], { message: "Jenis kelamin harus dipilih" }),
  birthPlace: z.string().min(1, "Tempat lahir wajib diisi"),
  birthDate: z.string().min(1, "Tanggal lahir wajib diisi").refine((s) => !isNaN(Date.parse(s)), "Tanggal lahir tidak valid"),
  school: z.string().min(3, "Asal sekolah wajib diisi"),
  gradeClass: z.string().min(1, "Kelas wajib diisi"),
  address: z.string().min(5, "Alamat wajib diisi"),
  whatsapp: z.string().regex(waRegex, "Nomor WhatsApp tidak valid (contoh: 081234567890)"),
  email: z.string().email("Email tidak valid").optional().or(z.literal("")),
  guardian: z.string().min(3, "Nama pendamping wajib diisi"),
  guardianRel: z.string().min(1, "Hubungan pendamping wajib diisi"),
  guardianWa: z.string().regex(waRegex, "Nomor WhatsApp pendamping tidak valid"),
});

export type RegistrationInput = z.infer<typeof registrationSchema>;

async function generateRegNumber(): Promise<string> {
  const year = new Date().getFullYear();
  for (let attempt = 0; attempt < 5; attempt++) {
    const count = await db.registration.count();
    const num = `AKS-${year}-${String(count + 1 + attempt).padStart(5, "0")}`;
    const exists = await db.registration.findUnique({ where: { regNumber: num } });
    if (!exists) return num;
  }
  return `AKS-${year}-${Date.now()}`; // ponytail: fallback ekstrem; race jarang, tetap unik
}

export type RegistrationResult =
  | { ok: true; regNumber: string }
  | { ok: false; errors: Record<string, string>; general?: string };

export async function submitRegistration(
  _prev: RegistrationResult | null,
  formData: FormData
): Promise<RegistrationResult> {
  const raw = Object.fromEntries(formData.entries());
  const parsed = registrationSchema.safeParse(raw);
  if (!parsed.success) {
    const errors: Record<string, string> = {};
    for (const issue of parsed.error.issues)
      errors[String(issue.path[0])] ??= issue.message;
    return { ok: false, errors };
  }
  const d = parsed.data;

  try {
    const comp = await db.competition.findUnique({ where: { id: d.competitionId } });
    if (!comp || comp.status !== "OPEN")
      return { ok: false, errors: {}, general: "Lomba tidak tersedia atau pendaftaran sudah ditutup." };

    if (comp.quota > 0) {
      const taken = await db.registration.count({ where: { competitionId: comp.id, status: { not: "REJECTED" } } });
      if (taken >= comp.quota)
        return { ok: false, errors: {}, general: "Maaf, kuota lomba ini sudah penuh." };
    }

    const regNumber = await generateRegNumber();
    const participant = await db.participant.create({
      data: {
        fullName: d.fullName,
        nisn: d.nisn,
        gender: d.gender,
        birthPlace: d.birthPlace,
        birthDate: new Date(d.birthDate),
        school: d.school,
        gradeClass: d.gradeClass,
        address: d.address,
        whatsapp: d.whatsapp,
        email: d.email || null,
        guardian: d.guardian,
        guardianRel: d.guardianRel,
        guardianWa: d.guardianWa,
      },
    });
    const registration = await db.registration.create({
      data: {
        regNumber,
        participantId: participant.id,
        competitionId: comp.id,
        extraChoice: (raw.extraChoice as string) || null,
        paymentStatus: comp.fee > 0 ? "UNPAID" : "NONE",
      },
    });

    // anggota regu 2..teamSize
    const teamSize = Math.max(1, comp.teamSize || 1);
    for (let m = 2; m <= teamSize; m++) {
      const fullName = String(raw[`m${m}_fullName`] || "").trim();
      const nisn = String(raw[`m${m}_nisn`] || "").trim();
      const gender = String(raw[`m${m}_gender`] || "").trim();
      const birthPlace = String(raw[`m${m}_birthPlace`] || "").trim();
      const birthDate = String(raw[`m${m}_birthDate`] || "").trim();
      const school = String(raw[`m${m}_school`] || "").trim() || d.school;
      const gradeClass = String(raw[`m${m}_gradeClass`] || "").trim();
      if (!fullName && !nisn) {
        return { ok: false, errors: {}, general: `Data anggota ${m} wajib diisi (regu ${teamSize} orang).` };
      }
      if (!fullName || !/^\d{10}$/.test(nisn) || !["L", "P"].includes(gender) || !birthPlace || !birthDate || isNaN(Date.parse(birthDate)) || !gradeClass) {
        return { ok: false, errors: {}, general: `Data anggota ${m} belum lengkap/valid (nama, NISN 10 digit, jenis kelamin, tempat & tanggal lahir, kelas).` };
      }
      await db.registrationMember.create({
        data: {
          registrationId: registration.id,
          fullName,
          nisn,
          gender,
          birthPlace,
          birthDate: new Date(birthDate),
          school,
          gradeClass,
        },
      });
    }

    const requiredDocs = splitLines(comp.requiredDocs);
    if (requiredDocs.length > 0) {
      // ponytail: simpan ke disk lokal (dev OK); di Vercel ganti ke Vercel Blob/S3
      const dir = path.join(process.cwd(), "uploads", registration.id);
      await mkdir(dir, { recursive: true });
      for (let i = 0; i < requiredDocs.length; i++) {
        const file = formData.get(`doc_${i}`);
        if (!(file instanceof File) || file.size === 0)
          return { ok: false, errors: {}, general: `Dokumen "${requiredDocs[i]}" wajib diupload.` };
        if (file.size > 2 * 1024 * 1024)
          return { ok: false, errors: {}, general: `File "${requiredDocs[i]}" melebihi 2MB.` };
        const ext = (file.name.match(/\.(pdf|jpe?g|png)$/i) || [])[1]?.toLowerCase();
        if (!ext)
          return { ok: false, errors: {}, general: `File "${requiredDocs[i]}" harus PDF/JPG/PNG.` };
        const safeExt = ext === "jpeg" ? "jpg" : ext;
        const fileName = `${requiredDocs[i].replace(/[^\w-]+/g, "_")}.${safeExt}`;
        await writeFile(path.join(dir, fileName), Buffer.from(await file.arrayBuffer()));
        await db.registrationDocument.create({
          data: { registrationId: registration.id, docType: requiredDocs[i], fileName, filePath: path.join("uploads", registration.id, fileName) },
        });
      }
    }

    return { ok: true, regNumber };
  } catch (e) {
    console.error(e);
    return { ok: false, errors: {}, general: "Terjadi kesalahan. Silakan coba lagi." };
  }
}
