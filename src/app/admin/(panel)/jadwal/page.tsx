import { revalidatePath } from "next/cache";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";
const input =
  "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

export default async function AdminJadwalPage() {
  await requireRole();
  const items = await db.schedule.findMany({ orderBy: { date: "asc" } });

  async function add(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    const title = String(formData.get("title") || "").trim();
    const date = formData.get("date");
    if (!title || !date) return;
    await db.schedule.create({ data: { title, date: new Date(String(date)) } });
    revalidatePath("/admin/jadwal");
    revalidatePath("/jadwal");
  }
  async function del(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    await db.schedule.delete({ where: { id: String(formData.get("id")) } }).catch(() => {});
    revalidatePath("/admin/jadwal");
    revalidatePath("/jadwal");
  }

  return (
    <>
      <h1 className="mb-6 text-2xl font-extrabold text-slate-800">Kelola Jadwal</h1>

      <form action={add} className="mb-6 flex flex-wrap items-end gap-3 rounded-2xl border bg-white p-5 shadow-sm">
        <div className="min-w-[240px] flex-[2]">
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Judul</label>
          <input name="title" required placeholder="contoh: Pengumuman pemenang" className={input} />
        </div>
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Tanggal</label>
          <input type="datetime-local" name="date" required className={input} />
        </div>
        <button className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-5 py-2.5 text-sm font-bold text-white">
          Tambah
        </button>
      </form>

      <ul className="space-y-2">
        {items.map((s) => (
          <li key={s.id} className="flex items-center justify-between gap-4 rounded-2xl border bg-white p-4 shadow-sm">
            <div>
              <p className="text-xs font-bold text-cyan-700">
                {new Date(s.date).toLocaleString("id-ID", { dateStyle: "full", timeStyle: "short" })}
              </p>
              <p className="font-semibold text-slate-700">{s.title}</p>
            </div>
            <form action={del}>
              <input type="hidden" name="id" value={s.id} />
              <button className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-50">
                Hapus
              </button>
            </form>
          </li>
        ))}
        {items.length === 0 && (
          <li className="rounded-2xl border bg-white p-8 text-center text-slate-300">Belum ada jadwal.</li>
        )}
      </ul>
    </>
  );
}
