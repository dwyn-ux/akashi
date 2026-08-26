import { revalidatePath } from "next/cache";
import { z } from "zod";
import { Trash2 } from "lucide-react";
import { db } from "@/lib/db";
import { hashPassword } from "@/lib/auth";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";

const ROLES = ["SUPER_ADMIN", "ADMIN", "OPERATOR"] as const;

const userSchema = z.object({
  name: z.string().min(2, "Nama minimal 2 karakter"),
  email: z.string().email("Email tidak valid"),
  password: z.string().min(8, "Password minimal 8 karakter"),
  role: z.enum(ROLES),
});

export default async function AdminPenggunaPage() {
  const session = await requireRole(["SUPER_ADMIN"]);
  const users = await db.user.findMany({ orderBy: { createdAt: "asc" } });

  async function add(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN"]);
    const parsed = userSchema.safeParse(Object.fromEntries(formData));
    if (!parsed.success) return;
    await db.user.create({
      data: { ...parsed.data, email: parsed.data.email.toLowerCase(), passwordHash: hashPassword(parsed.data.password) },
    }).catch(() => {});
    revalidatePath("/admin/pengguna");
  }

  async function del(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN"]);
    const id = String(formData.get("id"));
    if (id === session.id) return;
    await db.user.delete({ where: { id } }).catch(() => {});
    revalidatePath("/admin/pengguna");
  }

  const input =
    "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

  return (
    <>
      <h1 className="mb-1 text-2xl font-extrabold text-slate-800">Pengguna Admin</h1>
      <p className="mb-6 text-sm text-slate-400">
        Kelola akun panitia. SUPER_ADMIN: akses penuh &bull; ADMIN: kelola lomba &amp; peserta &bull; OPERATOR: lihat &amp; verifikasi peserta.
      </p>

      <form action={add} className="mb-6 grid gap-3 rounded-2xl border bg-white p-5 shadow-sm sm:grid-cols-2 lg:grid-cols-5">
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Nama *</label>
          <input name="name" required className={input} />
        </div>
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Email *</label>
          <input name="email" type="email" required className={input} />
        </div>
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Password * (min. 8)</label>
          <input name="password" type="password" minLength={8} required className={input} />
        </div>
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Role</label>
          <select name="role" defaultValue="ADMIN" className={input}>
            {ROLES.map((r) => (
              <option key={r} value={r}>{r}</option>
            ))}
          </select>
        </div>
        <button className="self-end rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-5 py-2.5 text-sm font-bold text-white">
          Tambah
        </button>
      </form>

      <ul className="space-y-2">
        {users.map((u) => (
          <li key={u.id} className="flex items-center justify-between gap-4 rounded-2xl border bg-white p-4 shadow-sm">
            <div>
              <p className="font-semibold text-slate-700">
                {u.name}
                {u.id === session.id && <span className="ml-2 text-xs font-bold text-violet-600">(Anda)</span>}
              </p>
              <p className="text-sm text-slate-400">{u.email}</p>
            </div>
            <span className={`rounded-full px-3 py-1 text-xs font-bold ${
              u.role === "SUPER_ADMIN" ? "bg-violet-100 text-violet-700" : u.role === "ADMIN" ? "bg-cyan-100 text-cyan-700" : "bg-slate-100 text-slate-600"
            }`}>
              {u.role}
            </span>
            {u.id !== session.id && (
              <form action={del}>
                <input type="hidden" name="id" value={u.id} />
                <button className="rounded-lg border border-red-200 p-2 text-red-500 hover:bg-red-50" title="Hapus">
                  <Trash2 size={15} />
                </button>
              </form>
            )}
          </li>
        ))}
      </ul>
    </>
  );
}
