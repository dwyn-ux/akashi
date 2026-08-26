import { revalidatePath } from "next/cache";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";
const input =
  "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

const SLUGS = [
  ["juknis", "Juknis Lomba", "Petunjuk teknis lomba. Tampil di /juknis."],
  ["dokumentasi", "Dokumentasi", "Dokumentasi & liputan kegiatan. Tampil di /dokumentasi."],
] as const;

export default async function AdminJuknisPage() {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const pages = await db.infoPage.findMany();
  const byslug = Object.fromEntries(pages.map((p) => [p.slug, p]));

  async function save(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    const slug = String(formData.get("slug") || "");
    if (!SLUGS.some(([s]) => s === slug)) return;
    const title = String(formData.get("title") || "").trim();
    const body = String(formData.get("body") || "");
    if (!title) return;
    await db.infoPage.upsert({
      where: { slug },
      update: { title, body },
      create: { slug, title, body },
    });
    revalidatePath("/admin/juknis");
    revalidatePath(`/${slug}`);
  }

  return (
    <>
      <h1 className="mb-1 text-2xl font-extrabold text-slate-800">Juknis &amp; Dokumentasi</h1>
      <p className="mb-6 text-sm text-slate-400">
        Edit konten halaman info. Tulis biasa (enter = baris baru).
      </p>

      <div className="grid gap-5 lg:grid-cols-2">
        {SLUGS.map(([slug, defaultTitle, hint]) => {
          const page = byslug[slug];
          return (
            <form key={slug} action={save} className="space-y-3 rounded-2xl border bg-white p-5 shadow-sm">
              <input type="hidden" name="slug" value={slug} />
              <div>
                <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Judul</label>
                <input name="title" defaultValue={page?.title ?? defaultTitle} className={input} required />
              </div>
              <div>
                <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Isi</label>
                <textarea name="body" rows={14} defaultValue={page?.body ?? ""} className={`${input} font-mono text-[13px] leading-relaxed`} />
              </div>
              <div className="flex items-center justify-between gap-3">
                <p className="text-xs text-slate-400">{hint}</p>
                <button className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-5 py-2.5 text-sm font-bold text-white">
                  Simpan
                </button>
              </div>
            </form>
          );
        })}
      </div>
    </>
  );
}
