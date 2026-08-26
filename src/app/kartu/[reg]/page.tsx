import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import type { Metadata } from "next";
import { db } from "@/lib/db";
import { getSettings, formatRupiah } from "@/lib/constants";
import { PrintButton } from "./print-button";

export const metadata: Metadata = {
  title: "Kartu Peserta",
  robots: { index: false },
};

export const dynamic = "force-dynamic";

// ponytail: unduh = print-to-PDF browser; PDF server-side (pdf-lib) nanti
// kalau panitia butuh arsip otomatis.
export default async function KartuPesertaPage({
  params,
}: PageProps<"/kartu/[reg]">) {
  const { reg } = await params;
  const regNumber = decodeURIComponent(reg).toUpperCase();
  const [r, s] = await Promise.all([
    db.registration.findUnique({
      where: { regNumber },
      include: {
        participant: true,
        competition: true,
        members: { orderBy: { id: "asc" } },
      },
    }),
    getSettings(),
  ]);
  if (!r) notFound();

  const p = r.participant;
  const teamSize = Math.max(1, r.competition.teamSize || 1);
  const eventDate = new Date(s.event_date).toLocaleDateString("id-ID", {
    weekday: "long",
    day: "numeric",
    month: "long",
    year: "numeric",
  });

  return (
    <main className="min-h-screen bg-slate-100 py-10 print:bg-white print:py-0">
      <style>{`
        @media print {
          .no-print { display: none !important; }
          .kartu { box-shadow: none !important; margin: 0 !important; border-radius: 0 !important; width: 100% !important; max-width: none !important; }
          body { background: white !important; }
        }
      `}</style>

      <div className="no-print mx-auto mb-6 flex max-w-[760px] items-center justify-between px-4">
        <Link href="/" className="text-sm font-bold text-brand hover:underline">
          &larr; Beranda
        </Link>
        <PrintButton />
      </div>

      <article className="kartu mx-auto max-w-[760px] overflow-hidden rounded-[18px] border border-ink/10 bg-white shadow-[0_20px_60px_-20px_rgba(17,24,39,0.3)]">
        {/* kop */}
        <header className="flex items-center gap-4 border-b-[3px] border-brand bg-gradient-to-r from-mist via-white to-white px-8 py-5">
          {s.site_logo_url && (
            <Image src={s.site_logo_url} alt="Logo" width={56} height={56} className="size-14 object-contain" />
          )}
          <div className="min-w-0 flex-1">
            <p className="font-display text-xl font-extrabold uppercase tracking-tight text-ink">
              Kartu Peserta {s.event_name}
            </p>
            <p className="text-xs font-semibold text-ink/50">
              {s.event_full_name} • {s.school_name}
            </p>
          </div>
          <span className="rounded-full bg-gold px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-widest text-ink">
            {r.status === "VERIFIED" ? "Terverifikasi" : "Belum Verifikasi"}
          </span>
        </header>

        <div className="grid gap-6 px-8 py-6 sm:grid-cols-[1fr_auto]">
          <div>
            <p className="text-[10px] font-extrabold uppercase tracking-[0.22em] text-ink/40">Nomor Pendaftaran</p>
            <p className="select-all font-display text-2xl font-extrabold tracking-wide text-brand">
              {r.regNumber}
            </p>
          </div>
          <div className="sm:text-right">
            <p className="text-[10px] font-extrabold uppercase tracking-[0.22em] text-ink/40">Terdaftar</p>
            <p className="text-sm font-bold text-ink/70">
              {new Date(r.createdAt).toLocaleDateString("id-ID", { day: "numeric", month: "short", year: "numeric" })}
            </p>
          </div>
        </div>

        {/* biodata */}
        <section className="border-t border-ink/[0.07] px-8 py-5">
          <h2 className="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-cyanx">Data Peserta</h2>
          <dl className="grid gap-x-8 gap-y-2 sm:grid-cols-2">
            <Row k="Nama Lengkap" v={p.fullName} strong />
            <Row k="NISN" v={p.nisn} />
            <Row k="Jenis Kelamin" v={p.gender === "L" ? "Laki-laki" : "Perempuan"} />
            <Row k="Tempat/Tgl Lahir" v={`${p.birthPlace}, ${new Date(p.birthDate).toLocaleDateString("id-ID")}`} />
            <Row k="Asal Sekolah" v={p.school} />
            <Row k="Kelas" v={p.gradeClass} />
            <Row k="WhatsApp" v={p.whatsapp} />
            <Row k="Pendamping" v={`${p.guardian} (${p.guardianRel}) — ${p.guardianWa}`} />
          </dl>
        </section>

        {r.members.length > 0 && (
          <section className="border-t border-ink/[0.07] px-8 py-5">
            <h2 className="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-cyanx">
              Anggota Regu ({r.members.length + 1}/{teamSize})
            </h2>
            <ol className="space-y-1.5">
              <li className="text-sm"><strong>{p.fullName}</strong> — Ketua</li>
              {r.members.map((m, i) => (
                <li key={m.id} className="text-sm text-ink/70">
                  {i + 2}. <strong className="text-ink">{m.fullName}</strong> — {m.school}, kelas {m.gradeClass}
                </li>
              ))}
            </ol>
          </section>
        )}

        {/* lomba */}
        <section className="border-t border-ink/[0.07] bg-paper px-8 py-5">
          <h2 className="mb-3 text-xs font-extrabold uppercase tracking-[0.2em] text-cyanx">Lomba yang Diikuti</h2>
          <dl className="grid gap-x-8 gap-y-2 sm:grid-cols-2">
            <Row k="Nama Lomba" v={r.competition.name} strong />
            <Row k="Kategori / Jenjang" v={`${r.competition.category} • ${r.competition.level}`} />
            <Row k="Format" v={teamSize > 1 ? `Regu ${teamSize} orang` : "Individu"} />
            <Row k="Biaya" v={formatRupiah(r.competition.fee)} />
            <Row k="Jadwal" v={r.competition.scheduleText || eventDate} />
            <Row k="Lokasi" v={r.competition.location || s.location || s.school_name} />
          </dl>
        </section>

        <footer className="border-t border-ink/[0.07] px-8 py-4">
          <p className="text-center text-[11px] leading-relaxed text-ink/45">
            Wajib dibawa (cetak/HP) pada hari-H dan hadir 30 menit sebelum lomba dimulai.<br />
            Info: {s.whatsapp_label} • Status: /cek-pendaftaran
          </p>
        </footer>
      </article>

      <p className="no-print mx-auto mt-4 max-w-[760px] px-4 text-center text-xs text-slate-400">
        Tekan tombol Cetak lalu pilih &ldquo;Save as PDF&rdquo; untuk mengunduh kartu ini.
      </p>
    </main>
  );
}

function Row({ k, v, strong }: { k: string; v: string; strong?: boolean }) {
  return (
    <div>
      <dt className="text-[10px] font-bold uppercase tracking-wider text-ink/40">{k}</dt>
      <dd className={`text-sm ${strong ? "font-display text-base font-extrabold text-ink" : "font-semibold text-ink/75"}`}>
        {v}
      </dd>
    </div>
  );
}
