import { revalidatePath } from "next/cache";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";
const input =
  "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

export default async function AdminKegiatanPage() {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const items = await db.activity.findMany({ orderBy: { name: "asc" } });

  async function add(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    const name = String(formData.get("name") || "").trim();
    if (!name) return;
    const date = String(formData.get("date") || "");
    await db.activity.create({
      data: {
        name,
        description: String(formData.get("description") || ""),
        timeText: String(formData.get("timeText") || "") || null,
        location: String(formData.get("location") || "") || null,
        date: date ? new Date(date) : null,
      },
    });
    revalidatePath("/admin/kegiatan");
    revalidatePath("/kegiatan");
  }
  async function del(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    await db.activity.delete({ where: { id: String(formData.get("id")) } }).catch(() => {});
    revalidatePath("/admin/kegiatan");
    revalidatePath("/kegiatan");
  }

  return (
    <>
      <h1 className="mb-6 text-2xl font-extrabold text-slate-800">Kelola Kegiatan</h1>

      <form action={add} className="mb-6 grid gap-3 rounded-2xl border bg-white p-5 shadow-sm sm:grid-cols-2 lg:grid-cols-5">
        <div className="lg:col-span-2">
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Nama Kegiatan *</label>
          <input name="name" required className={input} />
        </div>
        <div className="lg:col-span-3">
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Deskripsi</label>
          <input name="description" className={input} />
        </div>
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Tanggal</label>
          <input type="date" name="date" className={input} />
        </div>
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Waktu</label>
          <input name="timeText" placeholder="08.00 - selesai" className={input} />
        </div>
        <div className="lg:col-span-2">
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Lokasi</label>
          <input name="location" className={input} />
        </div>
        <button className="self-end rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-5 py-2.5 text-sm font-bold text-white lg:col-span-1">
          Tambah
        </button>
      </form>

      <ul className="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        {items.map((a) => (
          <li key={a.id} className="flex flex-col rounded-2xl border bg-white p-4 shadow-sm">
            <p className="font-bold text-slate-700">{a.name}</p>
            <p className="mt-0.5 flex-1 text-sm text-slate-400">{a.description}</p>
            <form action={del} className="mt-3 self-end">
              <input type="hidden" name="id" value={a.id} />
              <button className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-50">
                Hapus
              </button>
            </form>
          </li>
        ))}
      </ul>
    </>
  );
}
