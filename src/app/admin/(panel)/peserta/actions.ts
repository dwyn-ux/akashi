"use server";

import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";

export async function updateRegistration(formData: FormData) {
  await requireRole();
  const id = String(formData.get("id"));
  const status = String(formData.get("status") || "");
  const paymentStatus = String(formData.get("paymentStatus") || "");
  const adminNote = String(formData.get("adminNote") || "") || null;
  const VALID = ["PENDING", "VERIFIED", "REJECTED", "LOLOS", "FINAL", "SELESAI"];
  if (!VALID.includes(status)) return;
  await db.registration.update({
    where: { id },
    data: { status, paymentStatus, adminNote },
  });
  revalidatePath(`/admin/peserta/${id}`);
  revalidatePath("/admin/peserta");
}

export async function deleteRegistration(formData: FormData) {
  const session = await requireRole(["SUPER_ADMIN", "ADMIN"]);
  if (session.role === "ADMIN" && !formData.get("confirm")) return;
  const id = String(formData.get("id"));
  await db.registration.delete({ where: { id } });
  revalidatePath("/admin/peserta");
  redirect("/admin/peserta");
}
