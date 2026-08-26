import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { ArrowRight } from "lucide-react";
import { db } from "@/lib/db";
import { CompetitionCard, categoryLabel } from "@/components/competition-card";
import { Reveal } from "@/components/reveal";
import { compImage, eventImage } from "@/lib/assets";

export const metadata: Metadata = {
  title: "Daftar Lomba",
  description: "Semua kompetisi AKASHI 2026 untuk siswa tingkat SD.",
};

export const dynamic = "force-dynamic";

const GROUPS = ["Akademik", "Religi", "Bahasa", "Seni"] as const;

export default async function LombaPage() {
  const competitions = await db.competition.findMany({
    where: { status: { not: "DRAFT" } },
    orderBy: { name: "asc" },
  });
  const feature = competitions.find((c) => c.slug === "olimpiade-ipas") ?? null;
  const rest = competitions.filter((c) => c.id !== feature?.id);

  return (
    <main className="bg-paper">
      {/* header */}
      <section className="relative overflow-hidden border-b border-ink/[0.06] bg-white">
        <div aria-hidden className="dots absolute right-10 top-8 hidden h-32 w-32 text-brand/15 md:block" />
        <div className="mx-auto grid max-w-[1240px] gap-8 px-5 py-12 md:grid-cols-12 md:items-center md:px-12 md:py-16">
          <div className="md:col-span-7">
            <Reveal>
              <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
                <span className="h-px w-8 bg-cyanx" /> Semua Lomba
              </p>
              <h1 className="mt-4 font-display text-4xl font-extrabold uppercase leading-[1.0] tracking-tight text-ink md:text-6xl">
                Temukan
                <br />
                Lombam<span className="text-brand">u.</span>
              </h1>
              <p className="mt-5 max-w-md text-[15px] leading-relaxed text-ink/55">
                Dari olimpiade sampai video pendek — pilih panggung yang paling
                kamu. Kuota terbatas per lomba.
              </p>
            </Reveal>
          </div>
          <div className="hidden md:col-span-5 md:block">
            <Reveal delay={100}>
              <div className="img-zoom relative overflow-hidden rounded-[18px] shadow-[0_20px_50px_-20px_rgba(17,24,39,0.3)]">
                <Image
                  src={eventImage("hero-membaca.jpg")}
                  alt="Siswa menyiapkan diri mengikuti lomba"
                  width={640}
                  height={400}
                  priority
                  sizes="35vw"
                  className="h-auto w-full object-cover"
                />
              </div>
            </Reveal>
          </div>
        </div>
      </section>

      {/* grid per kategori */}
      <section className="mx-auto max-w-[1240px] px-5 pb-20 pt-12 md:px-12 md:pb-28">
        {competitions.length === 0 && (
          <p className="py-16 text-center font-display text-lg font-bold text-ink/35">
            Belum ada lomba yang dibuka.
          </p>
        )}
        {GROUPS.map((g) => {
          const items = rest.filter((c) => c.category === g);
          if (items.length === 0 && feature?.category !== g) return null;
          return (
            <div key={g} className="mt-14 first:mt-2">
              <Reveal>
                <div className="mb-6 flex items-center gap-4">
                  <span className="rounded-full bg-brand px-4 py-1.5 font-display text-xs font-extrabold uppercase tracking-[0.18em] text-white">
                    {categoryLabel(g)}
                  </span>
                  <span className="h-px flex-1 bg-ink/10" />
                  <span className="font-display text-sm font-bold text-ink/30 tabular-nums">
                    {(feature?.category === g ? items.length + 1 : items.length)
                      .toString()
                      .padStart(2, "0")}
                  </span>
                </div>
              </Reveal>
              <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                {items.map((c, i) => (
                  <CompetitionCard key={c.id} c={c} index={i + 1} image={compImage(c.slug)} />
                ))}
              </div>
            </div>
          );
        })}

        {/* featured */}
        {feature && (
          <Reveal className="mt-16">
            <article className="grid overflow-hidden rounded-[20px] bg-paper ring-1 ring-ink/[0.08] lg:grid-cols-2">
              <div className="img-zoom relative min-h-[260px] lg:min-h-[360px]" style={{ borderRadius: 0 }}>
                {compImage(feature.slug) && (
                  <Image
                    src={compImage(feature.slug)!}
                    alt={`Suasana ${feature.name}`}
                    fill
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    className="object-cover"
                  />
                )}
              </div>
              <div className="flex flex-col justify-center gap-4 p-8 md:p-12">
                <p className="inline-flex w-fit items-center gap-2 rounded-full bg-gold px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.22em] text-ink">
                  ★ Lomba Unggulan
                </p>
                <h2 className="font-display text-3xl font-extrabold uppercase leading-tight text-ink md:text-4xl">
                  {feature.name}
                </h2>
                <p className="max-w-md text-[15px] leading-relaxed text-ink/60 line-clamp-3">
                  {feature.description}
                </p>
                <Link
                  href={`/lomba/${feature.slug}`}
                  className="group mt-2 inline-flex w-fit items-center gap-2 rounded-[10px] bg-brand px-6 py-3.5 text-sm font-extrabold text-white transition-colors hover:bg-electric"
                >
                  Lihat Detail
                  <ArrowRight size={15} className="transition-transform group-hover:translate-x-1" />
                </Link>
              </div>
            </article>
          </Reveal>
        )}
      </section>
    </main>
  );
}
