"use server";

import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";
import { z } from "zod";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";

function slugify(s: string) {
  return s
    .toLowerCase()
    .replace(/[^a-z0-9\s-]/g, "")
    .trim()
    .replace(/\s+/g, "-");
}

const compSchema = z.object({
  name: z.string().min(3, "Nama lomba minimal 3 karakter"),
  slug: z.string().optional(),
  category: z.string().min(1, "Kategori wajib diisi"),
  level: z.string().min(1, "Jenjang wajib diisi"),
  description: z.string().min(1, "Deskripsi wajib diisi"),
  minAge: z.coerce.number().int("Usia tidak valid").min(0).max(30).optional(),
  maxAge: z.coerce.number().int("Usia tidak valid").min(0).max(30).optional(),
  gradeClass: z.string().optional(),
  quota: z.coerce.number().int("Kuota tidak valid").min(0, "Kuota tidak boleh negatif"),
  teamSize: z.coerce.number().int("Jumlah peserta tidak valid").min(1).max(10),
  fee: z.coerce.number().int("Biaya tidak valid").min(0),
  location: z.string().optional(),
  scheduleText: z.string().optional(),
  duration: z.string().optional(),
  status: z.enum(["DRAFT", "SOON", "OPEN", "CLOSED", "DONE"]),
  prize1: z.string().optional(),
  prize2: z.string().optional(),
  prize3: z.string().optional(),
  prizeExtra: z.string().optional(),
  requirements: z.string().optional(),
  rules: z.string().optional(),
  requiredDocs: z.string().optional(),
  contactPerson: z.string().optional(),
});

export type CompFormState = { ok?: boolean; errors?: Record<string, string>; general?: string };

export async function saveCompetition(
  _prev: CompFormState | null,
  formData: FormData
): Promise<CompFormState> {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const raw = Object.fromEntries(formData.entries());
  for (const k of ["minAge", "maxAge"])
    if (!raw[k]) delete raw[k];
  if (!raw.teamSize) raw.teamSize = "1";
  const parsed = compSchema.safeParse(raw);
  if (!parsed.success) {
    const errors: Record<string, string> = {};
    for (const i of parsed.error.issues) errors[String(i.path[0])] ??= i.message;
    return { errors };
  }
  const d = parsed.data;
  const slug = slugify(d.slug || d.name);
  const data = { ...d, slug };

  try {
    if (raw.id) {
      await db.competition.update({ where: { id: String(raw.id) }, data });
    } else {
      await db.competition.create({ data });
    }
  } catch (e: unknown) {
    if (String(e).includes("slug"))
      return { errors: { name: "Slug sudah dipakai lomba lain. Ubah nama atau slug." } };
    throw e;
  }
  revalidatePath("/admin/lomba");
  revalidatePath("/lomba");
  redirect("/admin/lomba");
}

export async function deleteCompetition(id: string) {
  await requireRole(["SUPER_ADMIN"]);
  await db.competition.delete({ where: { id } }).catch(() => {});
  revalidatePath("/admin/lomba");
  revalidatePath("/lomba");
}
