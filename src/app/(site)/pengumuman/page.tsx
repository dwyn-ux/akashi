import type { Metadata } from "next";
import Link from "next/link";
import { db } from "@/lib/db";
import { Reveal } from "@/components/reveal";

export const metadata: Metadata = {
  title: "Pengumuman",
  description: "Pengumuman resmi dan hasil lomba AKASHI 2026.",
};

export const dynamic = "force-dynamic";

const MEDAL = ["🥇", "🥈", "🥉"];

export default async function PengumumanPage() {
  const items = await db.announcement.findMany({
    where: { published: true },
    orderBy: [{ year: "desc" }, { createdAt: "desc" }],
    include: { winners: { orderBy: { place: "asc" } } },
  });

  return (
    <main className="bg-paper">
      <section className="border-b border-ink/[0.06] bg-white">
        <div aria-hidden className="dots absolute right-10 top-8 hidden h-32 w-32 text-brand/15 md:block" />
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
              <span className="h-px w-8 bg-cyanx" /> Info Terbaru
            </p>
            <h1 className="mt-4 font-display text-4xl font-extrabold uppercase leading-[1.0] tracking-tight text-ink md:text-6xl">
              Pengumum<span className="text-brand">an.</span>
            </h1>
            <p className="mt-5 max-w-md text-[15px] leading-relaxed text-ink/55">
              Hasil lomba, juara 1–3, dan informasi resmi panitia AKASHI.
            </p>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto max-w-[1240px] space-y-6 px-5 py-12 md:px-12 md:py-16">
        {items.length === 0 && (
          <p className="rounded-[18px] border border-dashed border-ink/10 bg-white py-16 text-center font-display text-lg font-bold text-ink/35">
            Belum ada pengumuman. Pantau terus halaman ini.
          </p>
        )}
        {items.map((a, i) => (
          <Reveal key={a.id} delay={Math.min(i * 60, 180)}>
            <article className="overflow-hidden rounded-[18px] border border-ink/[0.07] bg-white shadow-[0_2px_20px_rgba(17,24,39,0.04)]">
              <div className="flex flex-wrap items-center gap-3 border-b border-ink/[0.06] px-6 py-4 md:px-8">
                <span className="rounded-full bg-brand px-3 py-1 font-display text-xs font-extrabold text-white">
                  {a.year}
                </span>
                <h2 className="font-display text-lg font-extrabold text-ink">{a.title}</h2>
              </div>
              <div className="px-6 py-5 md:px-8">
                {a.body && <p className="max-w-2xl text-[15px] leading-relaxed text-ink/60">{a.body}</p>}
                {a.winners.length > 0 && (
                  <div className={`grid gap-3 ${a.winners.length > 1 ? "sm:grid-cols-3" : "sm:max-w-sm"}`}>
                    {a.winners.map((w) => (
                      <div
                        key={w.id}
                        className={`rounded-[12px] p-4 ${
                          w.place === 1
                            ? "bg-gradient-to-br from-gold/25 to-gold/5 ring-1 ring-gold/40"
                            : "bg-paper ring-1 ring-ink/[0.06]"
                        }`}
                      >
                        <p className="text-xl" aria-label={`Juara ${w.place}`}>{MEDAL[w.place - 1]}</p>
                        <p className="mt-1 text-[10px] font-extrabold uppercase tracking-[0.2em] text-ink/40">
                          Juara {w.place}
                        </p>
                        <p className="font-display text-base font-extrabold leading-snug text-ink">
                          {w.participantName}
                        </p>
                        {w.school && <p className="mt-0.5 text-xs font-semibold text-ink/45">{w.school}</p>}
                        {w.note && <p className="mt-1 text-xs text-ink/40">{w.note}</p>}
                      </div>
                    ))}
                  </div>
                )}
              </div>
            </article>
          </Reveal>
        ))}

        <Reveal>
          <p className="pt-4 text-sm text-ink/50">
            Lihat rekap seluruh juara di{" "}
            <Link href="/juara" className="font-extrabold text-brand hover:underline">
              halaman Juara
            </Link>
            .
          </p>
        </Reveal>
      </section>
    </main>
  );
}
