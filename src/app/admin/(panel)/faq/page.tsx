import { revalidatePath } from "next/cache";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";
const input =
  "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

export default async function AdminFaqPage() {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const items = await db.faq.findMany({ orderBy: { order: "asc" } });

  async function add(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    const question = String(formData.get("question") || "").trim();
    const answer = String(formData.get("answer") || "").trim();
    if (!question || !answer) return;
    await db.faq.create({ data: { question, answer, order: items.length + 100 } });
    revalidatePath("/admin/faq");
    revalidatePath("/faq");
    revalidatePath("/");
  }
  async function del(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN", "ADMIN"]);
    await db.faq.delete({ where: { id: String(formData.get("id")) } }).catch(() => {});
    revalidatePath("/admin/faq");
    revalidatePath("/faq");
    revalidatePath("/");
  }

  return (
    <>
      <h1 className="mb-6 text-2xl font-extrabold text-slate-800">Kelola FAQ</h1>

      <form action={add} className="mb-6 space-y-3 rounded-2xl border bg-white p-5 shadow-sm">
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Pertanyaan *</label>
          <input name="question" required className={input} />
        </div>
        <div>
          <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Jawaban *</label>
          <textarea name="answer" rows={2} required className={input} />
        </div>
        <button className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-5 py-2.5 text-sm font-bold text-white">
          Tambah FAQ
        </button>
      </form>

      <ul className="space-y-2">
        {items.map((f) => (
          <li key={f.id} className="flex items-start justify-between gap-4 rounded-2xl border bg-white p-4 shadow-sm">
            <div>
              <p className="font-semibold text-slate-700">{f.question}</p>
              <p className="mt-0.5 text-sm text-slate-400">{f.answer}</p>
            </div>
            <form action={del}>
              <input type="hidden" name="id" value={f.id} />
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
