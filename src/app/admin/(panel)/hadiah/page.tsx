import { revalidatePath } from "next/cache";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";
const input =
  "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

export default async function AdminHadiahPage() {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const comps = await db.competition.findMany({ orderBy: { name: "asc" } });

  async function save(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    const id = String(formData.get("id"));
    const g = (k: string) => String(formData.get(k) || "") || null;
    await db.competition.update({
      where: { id },
      data: { prize1: g("prize1"), prize2: g("prize2"), prize3: g("prize3"), prizeExtra: g("prizeExtra") },
    });
    revalidatePath("/admin/hadiah");
    revalidatePath("/lomba");
  }

  return (
    <>
      <h1 className="mb-1 text-2xl font-extrabold text-slate-800">Kelola Hadiah</h1>
      <p className="mb-6 text-sm text-slate-400">
        Ubah hadiah per lomba. Perubahan langsung tampil di website.
      </p>

      <div className="space-y-4">
        {comps.map((c) => (
          <form key={c.id} action={save} className="rounded-2xl border bg-white p-5 shadow-sm">
            <input type="hidden" name="id" value={c.id} />
            <div className="mb-4 flex items-center justify-between">
              <h2 className="font-bold text-violet-800">{c.name}</h2>
              <button className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-5 py-2 text-xs font-bold text-white">
                Simpan
              </button>
            </div>
            <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
              {[["prize1", "Juara 1"], ["prize2", "Juara 2"], ["prize3", "Juara 3"], ["prizeExtra", "Hadiah Tambahan"]].map(
                ([field, label]) => (
                  <div key={field}>
                    <label className="mb-1 block text-xs font-bold uppercase text-slate-400">{label}</label>
                    <input name={field} defaultValue={(c as Record<string, unknown>)[field] as string ?? ""} placeholder="Rp X + Trophy + Sertifikat" className={input} />
                  </div>
                )
              )}
            </div>
          </form>
        ))}
        {comps.length === 0 && (
          <p className="rounded-2xl border bg-white p-8 text-center text-slate-300">Belum ada lomba.</p>
        )}
      </div>
    </>
  );
}
