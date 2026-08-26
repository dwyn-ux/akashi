"use server";

import { redirect } from "next/navigation";
import { z } from "zod";
import { db } from "@/lib/db";
import { createSession, destroySession, getSession, verifyPassword } from "@/lib/auth";

export async function loginAction(
  _prev: string | null,
  formData: FormData
): Promise<string | null> {
  const parsed = z
    .object({
      email: z.string().email("Email tidak valid"),
      password: z.string().min(6, "Password minimal 6 karakter"),
    })
    .safeParse(Object.fromEntries(formData));
  if (!parsed.success) return parsed.error.issues[0].message;

  const user = await db.user.findUnique({ where: { email: parsed.data.email.toLowerCase() } });
  if (!user || !verifyPassword(parsed.data.password, user.passwordHash))
    return "Email atau password salah.";

  await createSession({ id: user.id, email: user.email, name: user.name, role: user.role });
  redirect("/admin/dashboard");
}

export async function logoutAction() {
  await destroySession();
  redirect("/admin/login");
}

export async function requireRole(roles?: string[]) {
  const session = await getSession();
  if (!session) redirect("/admin/login");
  if (roles && !roles.includes(session.role)) redirect("/admin/dashboard");
  return session;
}
