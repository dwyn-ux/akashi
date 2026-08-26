/**
 * Self-check alur pendaftaran: jalankan `npx tsx tests/registration.check.ts`
 * Menguji validasi, nomor pendaftaran unik, simpan dokumen, lalu bersihkan data uji.
 */
import { rm } from "fs/promises";
import path from "path";
import { existsSync } from "fs";
import { db } from "../src/lib/db";
import { submitRegistration } from "../src/app/(site)/daftar/actions";

async function main() {
  const comp = await db.competition.findUniqueOrThrow({
    where: { slug: "cerdas-cermat-agama" },
  });
  if (!comp.requiredDocs) throw new Error("seed CCA harus punya requiredDocs");

  const base: Record<string, string> = {
    competitionId: comp.id,
    fullName: "Tester Check",
    nisn: "0123456789",
    gender: "P",
    birthPlace: "Bandung",
    birthDate: "2015-05-01",
    school: "SD Uji Coba",
    gradeClass: "5B",
    address: "Jl. Testing No. 1",
    whatsapp: "081298765432",
    guardian: "Wali Tester",
    guardianRel: "Ibu",
    guardianWa: "081298765433",
  };

  // 1. validasi gagal: NISN salah
  const bad = new FormData();
  for (const [k, v] of Object.entries(base)) bad.set(k, k === "nisn" ? "123" : v);
  const r1 = await submitRegistration(null, bad);
  if (r1.ok || !r1.errors.nisn) throw new Error("validasi NISN tidak jalan");

  // 2. sukses tanpa dokumen -> ditolak karena dokumen wajib
  const nodoc = new FormData();
  for (const [k, v] of Object.entries(base)) nodoc.set(k, v);
  const r2 = await submitRegistration(null, nodoc);
  if (r2.ok || !r2.general?.includes("wajib diupload"))
    throw new Error("dokumen wajib tidak divalidasi");

  // 3. sukses lengkap dengan dokumen
  const ok = new FormData();
  for (const [k, v] of Object.entries(base)) ok.set(k, v);
  const docs = ["Kartu Pelajar", "Pas Foto 3x4", "Surat Rekomendasi Sekolah"];
  docs.forEach((d, i) => {
    ok.set(`doc_${i}`, new File([new Uint8Array([1, 2, 3])], `${d}.pdf`, { type: "application/pdf" }));
  });
  const r3 = await submitRegistration(null, ok);
  if (!r3.ok) throw new Error("pendaftaran valid gagal: " + JSON.stringify(r3));
  if (!/^AKS-\d{4}-\d{5}$/.test(r3.regNumber)) throw new Error("format nomor pendaftaran salah");

  const reg = await db.registration.findUniqueOrThrow({
    where: { regNumber: r3.regNumber },
    include: { documents: true },
  });
  if (reg.documents.length !== docs.length) throw new Error("jumlah dokumen tidak cocok");
  const filePath = path.join(process.cwd(), reg.documents[0].filePath);
  if (!existsSync(filePath)) throw new Error("file dokumen tidak tersimpan");
  if (reg.paymentStatus !== (comp.fee > 0 ? "UNPAID" : "NONE"))
    throw new Error("status pembayaran salah");

  // cleanup
  await db.registration.delete({ where: { id: reg.id } });
  await db.participant.delete({ where: { id: reg.participantId } });
  await rm(path.join(process.cwd(), "uploads", reg.id), { recursive: true });

  console.log("ALL CHECKS PASSED:", r3.regNumber);
}

main()
  .catch((e) => {
    console.error("CHECK FAILED:", e.message);
    process.exit(1);
  })
  .finally(() => db.$disconnect());
