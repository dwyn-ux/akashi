import type { Metadata } from "next";
import { db } from "@/lib/db";
import {
  REGISTRATION_STATUS_LABELS,
  splitLines,
} from "@/lib/constants";

export const metadata: Metadata = {
  title: "Cek Pendaftaran",
  description: "Cek status pendaftaran lomba AKASHI 2026 dengan nomor pendaftaran Anda.",
};

export const dynamic = "force-dynamic";

async function findReg(regNumber: string, contact: string) {
  const num = regNumber.trim().toUpperCase();
  const reg = await db.registration.findUnique({
    where: { regNumber: num },
    include: { participant: true, competition: true },
  });
  if (!reg) return null;
  const c = contact.trim().toLowerCase();
  const waOk = reg.participant.whatsapp.replace(/\D/g, "").includes(contact.replace(/\D/g, ""));
  const emailOk = !!c && (reg.participant.email ?? "").toLowerCase() === c;
  if (!waOk && !emailOk) return "contact-mismatch" as const;
  return reg;
}

export default async function CekPendaftaranPage({
  searchParams,
}: PageProps<"/cek-pendaftaran">) {
  const sp = await searchParams;
  const regNumber = typeof sp.reg === "string" ? sp.reg : "";
  const contact = typeof sp.contact === "string" ? sp.contact : "";

  let result = null;
  let error: string | null = null;
  if (regNumber || contact) {
    if (!regNumber || !contact) {
      error = "Nomor pendaftaran dan nomor WhatsApp/email wajib diisi.";
    } else {
      const r = await findReg(regNumber, contact);
      if (!r) error = "Data tidak ditemukan. Periksa kembali nomor pendaftaran dan kontak Anda.";
      else if (r === "contact-mismatch")
        error = "Kontak tidak cocok dengan data pendaftaran.";
      else result = r;
    }
  }

  const inputCls =
    "w-full rounded-[10px] border border-ink/15 bg-white px-4 py-2.5 text-sm outline-none focus:border-plum focus:ring-2 focus:ring-lavender";

  return (
    <main className="mx-auto max-w-2xl px-4 py-12">
      <h1 className="text-3xl font-extrabold text-slate-800">Cek Pendaftaran</h1>
      <p className="mt-2 text-slate-500">
        Masukkan nomor pendaftaran beserta WhatsApp/email yang terdaftar.
      </p>

      <form method="GET" className="mt-6 space-y-4 rounded-[12px] border border-ink/10 bg-white p-5 shadow-sm">
        <div>
          <label className="mb-1 block text-sm font-semibold text-slate-600">Nomor Pendaftaran</label>
          <input
            name="reg"
            defaultValue={regNumber}
            placeholder="AKS-2026-00001"
            className={`${inputCls} font-mono uppercase`}
            required
          />
        </div>
        <div>
          <label className="mb-1 block text-sm font-semibold text-slate-600">WhatsApp / Email</label>
          <input name="contact" defaultValue={contact} placeholder="08xxxxxxxxxx" className={inputCls} required />
        </div>
        <button className="w-full rounded-[10px] bg-plum py-3 font-bold text-white transition-colors hover:bg-plum-soft">
          Cek Status
        </button>
      </form>

      {error && (
        <p className="mt-4 rounded-[10px] bg-red-50 p-3 text-center text-sm font-medium text-red-600">{error}</p>
      )}

      {result && (
        <div className="mt-6 rounded-[12px] border border-ink/10 bg-white p-6 shadow-sm">
          <h2 className="font-extrabold text-plum">Detail Pendaftaran</h2>
          <dl className="mt-3 space-y-1.5 text-sm">
            <Row k="Nama Peserta" v={result.participant.fullName} />
            <Row k="Sekolah" v={result.participant.school} />
            <Row k="Lomba" v={result.competition.name} />
            <Row k="Nomor Pendaftaran" v={result.regNumber} />
            <Row
              k="Tanggal Daftar"
              v={new Date(result.createdAt).toLocaleDateString("id-ID", {
                day: "numeric",
                month: "long",
                year: "numeric",
              })}
            />
            <Row
              k="Status Pembayaran"
              v={
                result.paymentStatus === "NONE"
                  ? "Tidak ada biaya"
                  : result.paymentStatus === "PAID"
                    ? "Lunas"
                    : "Belum lunas"
              }
            />
            <Row k="Status Verifikasi" v={REGISTRATION_STATUS_LABELS[result.status] ?? result.status} />
          </dl>
          {result.adminNote && (
            <p className="mt-4 rounded-[10px] bg-amber-50 p-3 text-sm text-amber-800">
              <span className="font-bold">Catatan panitia:</span> {result.adminNote}
            </p>
          )}
          {splitLines(result.competition.requiredDocs).length > 0 && (
            <p className="mt-3 text-xs text-slate-400">
              Dokumen wajib lomba ini akan diverifikasi panitia saat administrasi.
            </p>
          )}
        </div>
      )}
    </main>
  );
}

function Row({ k, v }: { k: string; v: string }) {
  return (
    <div className="flex justify-between gap-4 border-b border-slate-50 py-1 last:border-0">
      <dt className="shrink-0 font-medium text-slate-400">{k}</dt>
      <dd className="text-right font-semibold text-slate-700">{v}</dd>
    </div>
  );
}
