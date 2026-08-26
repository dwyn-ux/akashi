import type { Metadata } from "next";
import Link from "next/link";
import { db } from "@/lib/db";
import { Reveal } from "@/components/reveal";

export const metadata: Metadata = {
  title: "Juara",
  description: "Para juara lomba AKASHI per tahun — Ajang Kreasi Ashidiq.",
};

export const dynamic = "force-dynamic";

export default async function JuaraPage() {
  const items = await db.announcement.findMany({
    where: { published: true, winners: { some: {} } },
    orderBy: [{ year: "desc" }, { createdAt: "desc" }],
    include: { winners: { orderBy: { place: "asc" } } },
  });
  const years = [...new Set(items.map((a) => a.year))];

  return (
    <main className="bg-paper">
      {/* hero */}
      <section className="border-b border-ink/[0.06] bg-white">
        <div aria-hidden className="dots absolute right-10 top-8 hidden h-32 w-32 text-brand/15 md:block" />
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
              <span className="h-px w-8 bg-cyanx" /> Hall of Fame
            </p>
            <h1 className="mt-4 font-display text-4xl font-extrabold uppercase leading-[1.0] tracking-tight text-ink md:text-6xl">
              Para
              <br />
              Juar<span className="text-brand">a.</span>
            </h1>
            <p className="mt-5 max-w-md text-[15px] leading-relaxed text-ink/55">
              Rekap para pemenang AKASHI tiap tahun. Nama kalian tercatat di sini selamanya.
            </p>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
        {years.length === 0 && (
          <p className="rounded-[18px] border border-dashed border-ink/10 bg-white py-16 text-center font-display text-lg font-bold text-ink/35">
            Daftar juara akan diumumkan setelah acara berakhir.
          </p>
        )}
        {years.map((year) => (
          <div key={year} className="mb-16 last:mb-0">
            <Reveal>
              <div className="mb-6 flex items-center gap-4">
                <span className="rounded-full bg-gradient-to-r from-brand to-electric px-5 py-2 font-display text-lg font-extrabold text-white">
                  {year}
                </span>
                <span className="h-px flex-1 bg-ink/10" />
              </div>
            </Reveal>
            <div className="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
              {items
                .filter((a) => a.year === year)
                .map((a, i) => (
                  <Reveal key={a.id} delay={Math.min(i * 60, 180)}>
                    <article className="h-full overflow-hidden rounded-[18px] border border-ink/[0.07] bg-white shadow-[0_2px_20px_rgba(17,24,39,0.04)]">
                      <h2 className="border-b border-ink/[0.06] bg-mist/40 px-6 py-4 font-display text-base font-extrabold uppercase tracking-wide text-brand-deep">
                        {a.title}
                      </h2>
                      <ol className="divide-y divide-ink/[0.05] px-6">
                        {a.winners.map((w) => (
                          <li key={w.id} className="flex items-center gap-3 py-3.5">
                            <span
                              className={`grid size-9 shrink-0 place-items-center rounded-full font-display text-sm font-extrabold ${
                                w.place === 1
                                  ? "bg-gold text-ink shadow-[0_4px_12px_rgba(250,204,21,0.5)]"
                                  : w.place === 2
                                    ? "bg-slate-200 text-slate-600"
                                    : "bg-amber-100 text-amber-700"
                              }`}
                              aria-label={`Juara ${w.place}`}
                            >
                              {w.place}
                            </span>
                            <div className="min-w-0">
                              <p className="truncate font-bold leading-snug text-ink">{w.participantName}</p>
                              {w.school && <p className="truncate text-xs text-ink/45">{w.school}</p>}
                            </div>
                          </li>
                        ))}
                      </ol>
                      {a.body && <p className="px-6 pb-5 text-sm leading-relaxed text-ink/50">{a.body}</p>}
                    </article>
                  </Reveal>
                ))}
            </div>
          </div>
        ))}

        {items.length > 0 && (
          <Reveal>
            <p className="pt-6 text-sm text-ink/50">
              Pengumuman lengkap ada di{" "}
              <Link href="/pengumuman" className="font-extrabold text-brand hover:underline">
                halaman Pengumuman
              </Link>
              .
            </p>
          </Reveal>
        )}
      </section>
    </main>
  );
}
