import type { Metadata } from "next";
import { getSettings } from "@/lib/constants";
import { db } from "@/lib/db";

export const metadata: Metadata = {
  title: "Syarat & Ketentuan",
  description: "Syarat dan ketentuan mengikuti lomba AKASHI 2026.",
};

export const dynamic = "force-dynamic";

export default async function SyaratPage() {
  const s = await getSettings();
  const comps = await db.competition.findMany({
    where: { status: { not: "DRAFT" } },
    orderBy: { name: "asc" },
    select: { name: true, requirements: true, rules: true, requiredDocs: true },
  });

  return (
    <main className="bg-cream">
      <section className="border-b border-ink/10 bg-white">
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-plum-soft">Ketentuan</p>
          <h1 className="mt-3 font-display text-4xl font-semibold text-plum md:text-5xl">
            Syarat &amp; Ketentuan
          </h1>
        </div>
      </section>

      <section className="mx-auto max-w-3xl px-5 py-14 md:py-20">
        <ol className="space-y-4 border-y border-ink/10 py-6 text-[15px] leading-relaxed text-ink/70">
          {[
            `Pendaftaran ${s.event_name} dibuka mulai ${new Date(s.registration_open_date).toLocaleDateString("id-ID", { day: "numeric", month: "long", year: "numeric" })} melalui formulir online di website ini.`,
            "Peserta wajib mengisi data dengan benar — nomor pendaftaran digunakan untuk verifikasi.",
            "Peserta adalah siswa-siswi tingkat SD sesuai jenjang masing-masing lomba.",
            "Satu peserta boleh mendaftar lebih dari satu lomba selama jadwal tidak bentrok.",
            "Keputusan panitia bersifat final dan tidak dapat diganggu gugat.",
          ].map((t) => (
            <li key={t.slice(0, 24)} className="flex gap-3">
              <span aria-hidden>—</span>
              {t}
            </li>
          ))}
        </ol>

        <h2 className="mt-14 font-display text-2xl font-semibold text-plum">Syarat per Lomba</h2>
        <div className="mt-6 space-y-0">
          {comps.map((c) => {
            const hasDetail = c.requirements || c.rules || c.requiredDocs;
            return (
              <details key={c.name} className="group border-t border-ink/10 last:border-b">
                <summary className="flex cursor-pointer list-none items-center justify-between gap-4 py-4 [&::-webkit-details-marker]:hidden">
                  <span className="font-semibold text-ink transition-colors group-open:text-plum">{c.name}</span>
                  <span
                    aria-hidden
                    className={`shrink-0 font-display text-xl leading-none transition-transform duration-300 group-open:rotate-45 ${
                      hasDetail ? "text-teal" : "text-ink/20"
                    }`}
                  >
                    +
                  </span>
                </summary>
                <div className="space-y-1.5 pb-5 pr-8 text-sm leading-relaxed text-ink/60">
                  {c.requirements && (
                    <p>
                      <strong className="text-plum">Syarat:</strong>{" "}
                      {c.requirements.replaceAll("\n", "; ")}
                    </p>
                  )}
                  {c.rules && (
                    <p>
                      <strong className="text-plum">Ketentuan:</strong> {c.rules.replaceAll("\n", "; ")}
                    </p>
                  )}
                  {c.requiredDocs && (
                    <p>
                      <strong className="text-plum">Dokumen:</strong>{" "}
                      {c.requiredDocs.replaceAll("\n", "; ")}
                    </p>
                  )}
                  {!hasDetail && <p>Belum ada syarat khusus.</p>}
                </div>
              </details>
            );
          })}
        </div>
      </section>
    </main>
  );
}
