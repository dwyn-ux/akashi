import Link from "next/link";
import { Download, Search } from "lucide-react";
import { db } from "@/lib/db";
import {
  REGISTRATION_STATUSES,
  REGISTRATION_STATUS_LABELS,
} from "@/lib/constants";
import { requireRole } from "../../auth-actions";
import { StatusBadge } from "@/components/competition-card";

export const dynamic = "force-dynamic";
const PER_PAGE = 20;

export default async function PesertaPage({
  searchParams,
}: PageProps<"/admin/peserta">) {
  await requireRole();
  const sp = await searchParams;
  const q = typeof sp.q === "string" ? sp.q.trim() : "";
  const status = typeof sp.status === "string" ? sp.status : "";
  const competitionId = typeof sp.competitionId === "string" ? sp.competitionId : "";
  const school = typeof sp.school === "string" ? sp.school.trim() : "";
  const page = Math.max(1, Number(sp.page) || 1);

  const where = {
    AND: [
      status ? { status } : {},
      competitionId ? { competitionId } : {},
      school ? { participant: { school: { contains: school } } } : {},
      q
        ? {
            OR: [
              { regNumber: { contains: q } },
              { participant: { fullName: { contains: q } } },
            ],
          }
        : {},
    ],
  };

  const [total, regs, comps] = await Promise.all([
    db.registration.count({ where }),
    db.registration.findMany({
      where,
      orderBy: { createdAt: "desc" },
      skip: (page - 1) * PER_PAGE,
      take: PER_PAGE,
      include: {
        participant: { select: { fullName: true, school: true, whatsapp: true } },
        competition: { select: { name: true } },
      },
    }),
    db.competition.findMany({ orderBy: { name: "asc" }, select: { id: true, name: true } }),
  ]);

  const pages = Math.max(1, Math.ceil(total / PER_PAGE));
  const qs = (p: number) => {
    const params = new URLSearchParams();
    if (q) params.set("q", q);
    if (status) params.set("status", status);
    if (competitionId) params.set("competitionId", competitionId);
    if (school) params.set("school", school);
    params.set("page", String(p));
    return `/admin/peserta?${params}`;
  };
  const input =
    "rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

  return (
    <>
      <div className="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 className="text-2xl font-extrabold text-slate-800">Kelola Peserta</h1>
        <a
          href={`/api/admin/export?${new URLSearchParams({ ...(q && { q }), ...(status && { status }), ...(competitionId && { competitionId }) })}`}
          className="flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100"
        >
          <Download size={15} /> Export CSV
        </a>
      </div>

      <form className="mb-4 flex flex-wrap items-center gap-2">
        <div className="relative flex-1 min-w-[200px]">
          <Search size={15} className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
          <input name="q" defaultValue={q} placeholder="Cari nama / nomor pendaftaran..." className={`${input} w-full pl-9`} />
        </div>
        <input name="school" defaultValue={school} placeholder="Filter sekolah" className={input} />
        <select name="competitionId" defaultValue={competitionId} className={input}>
          <option value="">Semua Lomba</option>
          {comps.map((c) => (
            <option key={c.id} value={c.id}>{c.name}</option>
          ))}
        </select>
        <select name="status" defaultValue={status} className={input}>
          <option value="">Semua Status</option>
          {REGISTRATION_STATUSES.map((s) => (
            <option key={s} value={s}>{REGISTRATION_STATUS_LABELS[s]}</option>
          ))}
        </select>
        <button className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-5 py-2 text-sm font-bold text-white">
          Filter
        </button>
      </form>

      <div className="overflow-x-auto rounded-2xl border bg-white shadow-sm">
        <table className="w-full min-w-[860px] text-left text-sm">
          <thead className="border-b bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr>
              <th className="px-4 py-3">No. Pendaftaran</th>
              <th className="px-4 py-3">Nama</th>
              <th className="px-4 py-3">Sekolah</th>
              <th className="px-4 py-3">Lomba</th>
              <th className="px-4 py-3">Status</th>
              <th className="px-4 py-3">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            {regs.map((r) => (
              <tr key={r.id} className="border-b last:border-0 hover:bg-slate-50/60">
                <td className="px-4 py-3 font-mono text-xs font-bold text-violet-700">{r.regNumber}</td>
                <td className="px-4 py-3">
                  <Link href={`/admin/peserta/${r.id}`} className="font-semibold text-slate-700 hover:text-violet-700 hover:underline">
                    {r.participant.fullName}
                  </Link>
                  <p className="text-xs text-slate-400">{r.participant.whatsapp}</p>
                </td>
                <td className="px-4 py-3 text-slate-500">{r.participant.school}</td>
                <td className="px-4 py-3 text-slate-500">{r.competition.name}</td>
                <td className="px-4 py-3"><StatusBadge status={r.status} /></td>
                <td className="px-4 py-3 text-xs text-slate-400">
                  {new Date(r.createdAt).toLocaleDateString("id-ID")}
                </td>
              </tr>
            ))}
            {regs.length === 0 && (
              <tr><td colSpan={6} className="px-4 py-10 text-center text-slate-300">Tidak ada data peserta.</td></tr>
            )}
          </tbody>
        </table>
      </div>

      {pages > 1 && (
        <div className="mt-4 flex justify-center gap-1.5">
          {Array.from({ length: Math.min(pages, 10) }, (_, i) => i + 1).map((p) => (
            <Link
              key={p}
              href={qs(p)}
              className={`rounded-lg px-3.5 py-1.5 text-sm font-semibold ${
                p === page ? "bg-violet-600 text-white" : "border bg-white text-slate-600 hover:bg-violet-50"
              }`}
            >
              {p}
            </Link>
          ))}
        </div>
      )}
    </>
  );
}
