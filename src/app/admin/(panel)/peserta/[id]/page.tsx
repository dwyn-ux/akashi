import Link from "next/link";
import { notFound } from "next/navigation";
import { ArrowLeft, Trash2 } from "lucide-react";
import { db } from "@/lib/db";
import {
  REGISTRATION_STATUSES,
  REGISTRATION_STATUS_LABELS,
  formatRupiah,
} from "@/lib/constants";
import { requireRole } from "../../../auth-actions";
import { updateRegistration, deleteRegistration } from "../actions";

export const dynamic = "force-dynamic";

export default async function DetailPesertaPage({
  params,
}: PageProps<"/admin/peserta/[id]">) {
  const session = await requireRole();
  const { id } = await params;
  const r = await db.registration.findUnique({
    where: { id },
    include: { participant: true, competition: true, documents: true, members: { orderBy: { id: "asc" } } },
  });
  if (!r) notFound();
  const p = r.participant;
  const input =
    "w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-violet-500";

  return (
    <>
      <div className="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
          <Link href="/admin/peserta" className="mb-1 inline-flex items-center gap-1 text-sm font-semibold text-violet-700 hover:underline">
            <ArrowLeft size={14} /> Kembali
          </Link>
          <h1 className="text-2xl font-extrabold text-slate-800">{p.fullName}</h1>
          <p className="font-mono text-sm font-bold text-cyan-700">{r.regNumber}</p>
        </div>
        <StatusBadgeBig status={r.status} />
      </div>

      <div className="grid gap-4 lg:grid-cols-3">
        <Card title="Data Peserta" className="lg:col-span-2">
          <dl className="grid gap-x-6 sm:grid-cols-2">
            <Row k="NISN" v={p.nisn} />
            <Row k="Jenis Kelamin" v={p.gender === "L" ? "Laki-laki" : "Perempuan"} />
            <Row k="Tempat/Tgl Lahir" v={`${p.birthPlace}, ${new Date(p.birthDate).toLocaleDateString("id-ID")}`} />
            <Row k="Sekolah" v={p.school} />
            <Row k="Kelas" v={p.gradeClass} />
            <Row k="Alamat" v={p.address} />
            <Row k="WhatsApp" v={p.whatsapp} />
            <Row k="Email" v={p.email || "-"} />
            <Row k="Pendamping" v={`${p.guardian} (${p.guardianRel})`} />
            <Row k="WhatsApp Pendamping" v={p.guardianWa} />
          </dl>
        </Card>

        <Card title="Lomba">
          <Row k="Nama" v={r.competition.name} />
          <Row k="Kategori" v={r.competition.category} />
          <Row
            k="Format"
            v={r.competition.teamSize > 1 ? `Regu ${r.competition.teamSize} orang` : "Individu"}
          />
          <Row k="Biaya" v={formatRupiah(r.competition.fee)} />
          <Row
            k="Daftar"
            v={new Date(r.createdAt).toLocaleString("id-ID", { dateStyle: "medium", timeStyle: "short" })}
          />
        </Card>

        {r.members.length > 0 && (
          <Card title={`Anggota Regu (${r.members.length + 1}/${(r.competition.teamSize || 1)})`} className="lg:col-span-3">
            <div className="overflow-x-auto">
              <table className="w-full text-left text-sm">
                <thead>
                  <tr className="text-xs uppercase text-slate-400">
                    <th className="py-2 pr-4">#</th>
                    <th className="py-2 pr-4">Nama</th>
                    <th className="py-2 pr-4">NISN</th>
                    <th className="py-2 pr-4">L/P</th>
                    <th className="py-2 pr-4">Tempat/Tgl Lahir</th>
                    <th className="py-2 pr-4">Sekolah</th>
                    <th className="py-2">Kelas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr className="border-t border-slate-100 font-semibold text-slate-700">
                    <td className="py-2 pr-4">1</td>
                    <td className="py-2 pr-4">{p.fullName} (Ketua)</td>
                    <td className="py-2 pr-4">{p.nisn}</td>
                    <td className="py-2 pr-4">{p.gender}</td>
                    <td className="py-2 pr-4">{p.birthPlace}, {new Date(p.birthDate).toLocaleDateString("id-ID")}</td>
                    <td className="py-2 pr-4">{p.school}</td>
                    <td className="py-2">{p.gradeClass}</td>
                  </tr>
                  {r.members.map((m, i) => (
                    <tr key={m.id} className="border-t border-slate-100 text-slate-600">
                      <td className="py-2 pr-4">{i + 2}</td>
                      <td className="py-2 pr-4">{m.fullName}</td>
                      <td className="py-2 pr-4">{m.nisn}</td>
                      <td className="py-2 pr-4">{m.gender}</td>
                      <td className="py-2 pr-4">{m.birthPlace}, {new Date(m.birthDate).toLocaleDateString("id-ID")}</td>
                      <td className="py-2 pr-4">{m.school}</td>
                      <td className="py-2">{m.gradeClass}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
            <a
              href={`/kartu/${r.regNumber}`}
              target="_blank"
              rel="noopener noreferrer"
              className="mt-3 inline-block rounded-lg border border-violet-200 px-3 py-1.5 text-xs font-bold text-violet-700 hover:bg-violet-50"
            >
              Buka Kartu Peserta ↗
            </a>
          </Card>
        )}

        {r.documents.length > 0 && (
          <Card title="Dokumen Peserta">
            <ul className="space-y-2 text-sm">
              {r.documents.map((d) => (
                <li key={d.id} className="flex items-center justify-between gap-3">
                  <span className="font-medium text-slate-600">{d.docType}</span>
                  <a
                    href={`/api/admin/docs/${d.id}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="rounded-lg border border-violet-200 px-3 py-1.5 text-xs font-bold text-violet-700 hover:bg-violet-50"
                  >
                    Lihat: {d.fileName}
                  </a>
                </li>
              ))}
            </ul>
          </Card>
        )}

        <Card title="Kelola Status" className="lg:col-span-3">
          <form action={updateRegistration} className="flex flex-wrap items-end gap-3">
            <input type="hidden" name="id" value={r.id} />
            <div className="min-w-[180px] flex-1">
              <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Status</label>
              <select name="status" defaultValue={r.status} className={input}>
                {REGISTRATION_STATUSES.map((s) => (
                  <option key={s} value={s}>{REGISTRATION_STATUS_LABELS[s]}</option>
                ))}
              </select>
            </div>
            <div className="min-w-[150px]">
              <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Pembayaran</label>
              <select name="paymentStatus" defaultValue={r.paymentStatus} className={input}>
                <option value="NONE">Tidak ada biaya</option>
                <option value="UNPAID">Belum lunas</option>
                <option value="PAID">Lunas</option>
              </select>
            </div>
            <div className="min-w-[220px] flex-[2]">
              <label className="mb-1 block text-xs font-bold uppercase text-slate-400">Catatan (terlihat peserta)</label>
              <input name="adminNote" defaultValue={r.adminNote ?? ""} className={input} />
            </div>
            <button className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-6 py-2.5 text-sm font-bold text-white transition hover:opacity-90">
              Simpan Perubahan
            </button>
          </form>

          {session.role !== "OPERATOR" && (
            <form
              action={deleteRegistration}
              className="mt-4 border-t pt-4"
              onSubmit={(e) => {
                if (!confirm("Hapus data peserta ini secara permanen?")) e.preventDefault();
              }}
            >
              <input type="hidden" name="id" value={r.id} />
              <input type="hidden" name="confirm" value="1" />
              <button className="flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-bold text-red-600 transition hover:bg-red-100">
                <Trash2 size={15} /> Hapus Data Peserta
              </button>
            </form>
          )}
        </Card>
      </div>
    </>
  );
}

const badgeStyles: Record<string, string> = {
  PENDING: "bg-amber-100 text-amber-700",
  VERIFIED: "bg-emerald-100 text-emerald-700",
  REJECTED: "bg-red-100 text-red-700",
  LOLOS: "bg-cyan-100 text-cyan-700",
  FINAL: "bg-violet-100 text-violet-700",
  SELESAI: "bg-slate-200 text-slate-600",
};

function StatusBadgeBig({ status }: { status: string }) {
  return (
    <span className={`rounded-full px-4 py-1.5 text-sm font-bold ${badgeStyles[status]}`}>
      {REGISTRATION_STATUS_LABELS[status] ?? status}
    </span>
  );
}

function Card({
  title,
  children,
  className = "",
}: {
  title: string;
  children: React.ReactNode;
  className?: string;
}) {
  return (
    <section className={`rounded-2xl border bg-white p-5 shadow-sm ${className}`}>
      <h2 className="mb-4 font-bold text-slate-700">{title}</h2>
      {children}
    </section>
  );
}

function Row({ k, v }: { k: string; v: string }) {
  return (
    <div className="border-b border-slate-50 py-1.5 last:border-0">
      <dt className="text-xs font-medium text-slate-400">{k}</dt>
      <dd className="text-sm font-semibold text-slate-700">{v}</dd>
    </div>
  );
}
