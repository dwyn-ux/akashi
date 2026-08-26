import Link from "next/link";
import { Plus, Pencil, Trash2 } from "lucide-react";
import { db } from "@/lib/db";
import { requireRole } from "../../auth-actions";
import { deleteCompetition } from "./actions";
import { StatusBadge } from "@/components/competition-card";

export const dynamic = "force-dynamic";

export default async function AdminLombaPage() {
  const session = await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const comps = await db.competition.findMany({
    orderBy: { name: "asc" },
    include: { _count: { select: { registrations: true } } },
  });

  return (
    <>
      <div className="mb-6 flex items-center justify-between">
        <h1 className="text-2xl font-extrabold text-slate-800">Kelola Lomba</h1>
        <Link
          href="/admin/lomba/tambah"
          className="flex items-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-4 py-2.5 text-sm font-bold text-white transition hover:opacity-90"
        >
          <Plus size={16} /> Tambah Lomba
        </Link>
      </div>

      <div className="overflow-x-auto rounded-2xl border bg-white shadow-sm">
        <table className="w-full min-w-[720px] text-left text-sm">
          <thead className="border-b bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr>
              <th className="px-4 py-3">Nama</th>
              <th className="px-4 py-3">Kategori</th>
              <th className="px-4 py-3">Status</th>
              <th className="px-4 py-3">Kuota</th>
              <th className="px-4 py-3">Peserta</th>
              <th className="px-4 py-3">Aksi</th>
            </tr>
          </thead>
          <tbody>
            {comps.map((c) => (
              <tr key={c.id} className="border-b last:border-0 hover:bg-slate-50/60">
                <td className="px-4 py-3 font-semibold text-slate-700">{c.name}</td>
                <td className="px-4 py-3 text-slate-500">{c.category}</td>
                <td className="px-4 py-3"><StatusBadge status={c.status} /></td>
                <td className="px-4 py-3 text-slate-500">{c.quota}</td>
                <td className="px-4 py-3 font-bold text-violet-700">{c._count.registrations}</td>
                <td className="px-4 py-3">
                  <div className="flex items-center gap-2">
                    <Link
                      href={`/admin/lomba/${c.id}`}
                      className="rounded-lg border border-violet-200 p-2 text-violet-600 transition hover:bg-violet-50"
                      title="Edit"
                    >
                      <Pencil size={14} />
                    </Link>
                    {session.role === "SUPER_ADMIN" && (
                      <form
                        action={async () => {
                          "use server";
                          await deleteCompetition(c.id);
                        }}
                      >
                        <button
                          className="rounded-lg border border-red-200 p-2 text-red-500 transition hover:bg-red-50"
                          title="Hapus"
                        >
                          <Trash2 size={14} />
                        </button>
                      </form>
                    )}
                  </div>
                </td>
              </tr>
            ))}
            {comps.length === 0 && (
              <tr>
                <td colSpan={6} className="px-4 py-10 text-center text-slate-300">
                  Belum ada lomba. Klik &ldquo;Tambah Lomba&rdquo;.
                </td>
              </tr>
            )}
          </tbody>
        </table>
      </div>
    </>
  );
}
