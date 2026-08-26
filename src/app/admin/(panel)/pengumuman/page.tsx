import { revalidatePath } from "next/cache";
import { db } from "@/lib/db";
import { getSettings } from "@/lib/constants";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";
const input =
  "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

const MEDAL = ["🥇", "🥈", "🥉"];

export default async function AdminPengumumanPage() {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const [items, comps, settings] = await Promise.all([
    db.announcement.findMany({
      orderBy: [{ year: "desc" }, { createdAt: "desc" }],
      include: { winners: { orderBy: { place: "asc" } } },
    }),
    db.competition.findMany({ orderBy: { name: "asc" }, select: { id: true, name: true } }),
    getSettings(),
  ]);
  const defaultYear = new Date(settings.event_date).getFullYear() || new Date().getFullYear();

  async function add(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    const year = parseInt(String(formData.get("year")), 10);
    const compId = String(formData.get("competitionId") || "");
    const title = String(formData.get("title") || "").trim();
    const body = String(formData.get("body") || "").trim();
    if (!title || isNaN(year)) return;
    const a = await db.announcement.create({
      data: {
        year,
        title,
        body,
        competitionId: compId || null,
        published: formData.get("published") === "on",
      },
    });
    for (const place of [1, 2, 3]) {
      const participantName = String(formData.get(`name${place}`) || "").trim();
      const school = String(formData.get(`school${place}`) || "").trim();
      if (!participantName) continue;
      await db.winner.create({
        data: { announcementId: a.id, place, participantName, school },
      });
    }
    revalidatePath("/admin/pengumuman");
    revalidatePath("/pengumuman");
    revalidatePath("/juara");
    revalidatePath("/");
  }

  async function toggle(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    const id = String(formData.get("id"));
    const item = await db.announcement.findUnique({ where: { id } });
    if (item)
      await db.announcement.update({ where: { id }, data: { published: !item.published } });
    revalidatePath("/admin/pengumuman");
    revalidatePath("/pengumuman");
    revalidatePath("/juara");
    revalidatePath("/");
  }

  async function del(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    await db.announcement.delete({ where: { id: String(formData.get("id")) } }).catch(() => {});
    revalidatePath("/admin/pengumuman");
    revalidatePath("/pengumuman");
    revalidatePath("/juara");
    revalidatePath("/");
  }

  return (
    <>
      <h1 className="mb-1 text-2xl font-extrabold text-slate-800">Pengumuman Lomba</h1>
      <p className="mb-6 text-sm text-slate-400">
        Umumkan hasil per lomba (juara 1–3) atau teks custom. Tampil di halaman Pengumuman, halaman Juara, dan landing page setelah event selesai.
      </p>

      <form action={add} className="mb-8 space-y-4 rounded-2xl border bg-white p-5 shadow-sm">
        <div className="grid gap-4 sm:grid-cols-[1fr_1fr_120px]">
          <div>
            <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Lomba *</label>
            <select name="competitionId" className={input} defaultValue="">
              <option value="">— Umum / custom —</option>
              {comps.map((c) => (
                <option key={c.id} value={c.id}>{c.name}</option>
              ))}
            </select>
          </div>
          <div>
            <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Judul Pengumuman *</label>
            <input name="title" required placeholder="Contoh: Hasil Olimpiade IPAS" className={input} />
          </div>
          <div>
            <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Tahun *</label>
            <input name="year" type="number" defaultValue={defaultYear} required className={input} />
          </div>
        </div>

        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">
            Catatan / Teks Custom (opsional — kosongkan jika hanya juara)
          </label>
          <textarea name="body" rows={2} placeholder="Contoh: Terima kasih atas partisipasi seluruh peserta." className={input} />
        </div>

        <div className="grid gap-4 sm:grid-cols-3">
          {[1, 2, 3].map((p) => (
            <div key={p} className="rounded-xl border border-dashed p-3">
              <p className="mb-2 text-xs font-extrabold uppercase tracking-wider text-amber-500">{MEDAL[p - 1]} Juara {p}</p>
              <input name={`name${p}`} placeholder={`Nama peserta juara ${p}`} className={`${input} mb-2`} />
              <input name={`school${p}`} placeholder="Asal sekolah" className={input} />
            </div>
          ))}
        </div>

        <div className="flex items-center gap-4">
          <label className="flex items-center gap-2 text-sm font-semibold text-slate-600">
            <input type="checkbox" name="published" defaultChecked className="size-4 accent-violet-600" />
            Langsung tayang
          </label>
          <button className="ml-auto rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-6 py-2.5 text-sm font-bold text-white">
            Tambah Pengumuman
          </button>
        </div>
      </form>

      <ul className="space-y-3">
        {items.length === 0 && (
          <li className="rounded-2xl border border-dashed p-10 text-center text-sm text-slate-400">
            Belum ada pengumuman.
          </li>
        )}
        {items.map((a) => (
          <li key={a.id} className="rounded-2xl border bg-white p-4 shadow-sm">
            <div className="flex flex-wrap items-center gap-3">
              <span className="rounded-full bg-violet-100 px-3 py-1 text-xs font-extrabold text-violet-700">{a.year}</span>
              <p className="font-bold text-slate-700">{a.title}</p>
              {!a.published && (
                <span className="rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-500">Draft</span>
              )}
              <div className="ml-auto flex gap-2">
                <form action={toggle}>
                  <input type="hidden" name="id" value={a.id} />
                  <button className="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    {a.published ? "Jadikan Draft" : "Tayangkan"}
                  </button>
                </form>
                <form action={del}>
                  <input type="hidden" name="id" value={a.id} />
                  <button className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-50">
                    Hapus
                  </button>
                </form>
              </div>
            </div>
            {a.body && <p className="mt-2 text-sm text-slate-500">{a.body}</p>}
            {a.winners.length > 0 && (
              <ol className="mt-3 grid gap-2 sm:grid-cols-3">
                {a.winners.map((w) => (
                  <li key={w.id} className="rounded-xl bg-slate-50 px-3 py-2 text-sm">
                    <span className="mr-1">{MEDAL[w.place - 1]}</span>
                    <span className="font-bold text-slate-700">{w.participantName}</span>
                    {w.school && <span className="block text-xs text-slate-400">{w.school}</span>}
                  </li>
                ))}
              </ol>
            )}
          </li>
        ))}
      </ul>
    </>
  );
}
