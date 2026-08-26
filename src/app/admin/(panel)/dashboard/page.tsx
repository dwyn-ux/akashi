import Link from "next/link";
import { db } from "@/lib/db";
import { REGISTRATION_STATUS_LABELS } from "@/lib/constants";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";

export default async function DashboardPage() {
  await requireRole();

  const [
    totalLomba,
    totalPeserta,
    today,
    verified,
    pending,
    rejected,
    perDay,
    perComp,
    perSchool,
    recent,
  ] = await Promise.all([
    db.competition.count(),
    db.registration.count(),
    db.registration.count({
      where: { createdAt: { gte: new Date(new Date().setHours(0, 0, 0, 0)) } },
    }),
    db.registration.count({ where: { status: "VERIFIED" } }),
    db.registration.count({ where: { status: "PENDING" } }),
    db.registration.count({ where: { status: "REJECTED" } }),
    db.$queryRaw<{ d: Date; n: number }[]>`
      SELECT date(createdAt) as d, COUNT(*) as n
      FROM Registration
      WHERE createdAt >= datetime('now', '-13 days')
      GROUP BY date(createdAt) ORDER BY d`,
    db.registration.groupBy({
      by: ["competitionId"],
      _count: true,
      orderBy: { _count: { competitionId: "desc" } },
      take: 8,
    }),
    db.participant.groupBy({
      by: ["school"],
      _count: true,
      orderBy: { _count: { school: "desc" } },
      take: 8,
    }),
    db.registration.findMany({
      orderBy: { createdAt: "desc" },
      take: 5,
      include: { participant: { select: { fullName: true } }, competition: { select: { name: true } } },
    }),
  ]);

  const comps = await db.competition.findMany({
    where: { id: { in: perComp.map((c) => c.competitionId) } },
    select: { id: true, name: true },
  });
  const compName = (id: string) => comps.find((c) => c.id === id)?.name ?? id;

  // isi hari kosong 14 hari terakhir
  const days: { label: string; n: number }[] = [];
  const map = new Map(perDay.map((r) => [String(r.d).slice(0, 10), r.n]));
  for (let i = 13; i >= 0; i--) {
    const d = new Date();
    d.setDate(d.getDate() - i);
    const key = d.toISOString().slice(0, 10);
    days.push({ label: String(d.getDate()), n: map.get(key) ?? 0 });
  }
  const maxDay = Math.max(1, ...days.map((d) => d.n));
  const maxComp = Math.max(1, ...perComp.map((c) => c._count));

  return (
    <>
      <h1 className="mb-6 text-2xl font-extrabold text-slate-800">Dashboard</h1>

      <div className="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
        <Stat label="Total Lomba" value={totalLomba} color="violet" />
        <Stat label="Total Peserta" value={totalPeserta} color="cyan" />
        <Stat label="Daftar Hari Ini" value={today} color="emerald" />
        <Stat label="Terverifikasi" value={verified} color="emerald" />
        <Stat label="Menunggu Verifikasi" value={pending} color="amber" />
        <Stat label="Ditolak" value={rejected} color="red" />
      </div>

      <div className="mt-6 grid gap-4 lg:grid-cols-2">
        <Card title="Pendaftar 14 Hari Terakhir">
          <div className="flex h-40 items-end gap-1.5">
            {days.map((d, i) => (
              <div key={i} className="group flex flex-1 flex-col items-center gap-1">
                <div
                  className="w-full rounded-t-md bg-gradient-to-t from-violet-600 to-cyan-400 transition group-hover:opacity-80"
                  style={{ height: `${Math.max(4, (d.n / maxDay) * 100)}%` }}
                  title={`${d.n} pendaftar`}
                />
                <span className="text-[10px] text-slate-400">{d.label}</span>
              </div>
            ))}
          </div>
        </Card>

        <Card title="Pendaftar Berdasarkan Lomba">
          {perComp.length === 0 ? (
            <Empty />
          ) : (
            <div className="space-y-2.5">
              {perComp.map((c) => (
                <div key={c.competitionId}>
                  <div className="mb-0.5 flex justify-between text-xs font-medium">
                    <span className="truncate text-slate-600">{compName(c.competitionId)}</span>
                    <span className="text-slate-400">{c._count}</span>
                  </div>
                  <div className="h-2 rounded-full bg-slate-100">
                    <div
                      className="h-full rounded-full bg-gradient-to-r from-violet-500 to-cyan-400"
                      style={{ width: `${(c._count / maxComp) * 100}%` }}
                    />
                  </div>
                </div>
              ))}
            </div>
          )}
        </Card>

        <Card title="Pendaftar Berdasarkan Sekolah">
          {perSchool.length === 0 ? (
            <Empty />
          ) : (
            <ul className="space-y-1.5 text-sm">
              {perSchool.map((s) => (
                <li key={s.school} className="flex justify-between border-b border-slate-50 py-1 last:border-0">
                  <span className="truncate text-slate-600">{s.school}</span>
                  <span className="font-bold text-violet-700">{s._count}</span>
                </li>
              ))}
            </ul>
          )}
        </Card>

        <Card title="Pendaftaran Terbaru">
          {recent.length === 0 ? (
            <Empty />
          ) : (
            <ul className="space-y-2 text-sm">
              {recent.map((r) => (
                <li key={r.id}>
                  <Link href={`/admin/peserta/${r.id}`} className="block rounded-lg p-2 transition hover:bg-violet-50">
                    <span className="font-semibold text-slate-700">{r.participant.fullName}</span>
                    <span className="text-slate-400"> — {r.competition.name}</span>
                    <span className="float-right rounded-full bg-violet-100 px-2 py-0.5 text-[10px] font-bold text-violet-700">
                      {REGISTRATION_STATUS_LABELS[r.status] ?? r.status}
                    </span>
                  </Link>
                </li>
              ))}
            </ul>
          )}
        </Card>
      </div>
    </>
  );
}

const colors: Record<string, string> = {
  violet: "from-violet-500 to-purple-600",
  cyan: "from-cyan-500 to-teal-500",
  emerald: "from-emerald-500 to-green-600",
  amber: "from-amber-500 to-orange-500",
  red: "from-red-500 to-rose-600",
};

function Stat({ label, value, color }: { label: string; value: number; color: string }) {
  return (
    <div className={`rounded-2xl bg-gradient-to-br ${colors[color]} p-4 text-white shadow-sm`}>
      <p className="text-2xl font-extrabold">{value}</p>
      <p className="mt-0.5 text-xs font-medium opacity-90">{label}</p>
    </div>
  );
}

function Card({ title, children }: { title: string; children: React.ReactNode }) {
  return (
    <section className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <h2 className="mb-4 font-bold text-slate-700">{title}</h2>
      {children}
    </section>
  );
}

function Empty() {
  return <p className="py-8 text-center text-sm text-slate-300">Belum ada data.</p>;
}
