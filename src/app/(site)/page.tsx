import Link from "next/link";
import Image from "next/image";
import { ArrowRight, ArrowUpRight, MapPin, Sparkles } from "lucide-react";
import { db } from "@/lib/db";
import { getSettings } from "@/lib/constants";
import { isEventFinished } from "@/lib/event-state";
import { CompetitionCard, categoryLabel } from "@/components/competition-card";
import { CountdownStrip } from "@/components/countdown";
import { Reveal } from "@/components/reveal";
import { compImage, eventImage, activityImage } from "@/lib/assets";

export const dynamic = "force-dynamic";

const WHY = [
  ["BERANI", "MENCOBA.", "Panggung pertama sering kali yang paling berarti."],
  ["BERANI", "BERKARYA.", "Ide di kepala jadi karya yang dilihat banyak orang."],
  ["BERANI", "BERSAING.", "Uji kemampuan melawan perwakilan sekolah lain."],
  ["BERANI", "BERSINAR.", "Juara atau bukan — karyamu tetap dipamerkan."],
] as const;

const MEDAL = ["🥇", "🥈", "🥉"];

async function getLatestPodium() {
  const latest = await db.announcement.findFirst({
    where: { published: true, winners: { some: {} } },
    orderBy: [{ year: "desc" }, { createdAt: "desc" }],
    select: { year: true },
  });
  if (!latest) return [null, []] as const;
  const items = await db.announcement.findMany({
    where: { published: true, year: latest.year, winners: { some: {} } },
    orderBy: { createdAt: "asc" },
    include: { winners: { orderBy: { place: "asc" }, take: 3 } },
  });
  return [latest.year, items] as const;
}

export default async function HomePage() {
  const settings = await getSettings();
  const [competitions, activities, schedules, faqs] = await Promise.all([
    db.competition.findMany({ where: { status: { not: "DRAFT" } }, orderBy: { name: "asc" } }),
    db.activity.findMany({ orderBy: { name: "asc" }, take: 5 }),
    db.schedule.findMany({ orderBy: { date: "asc" }, take: 4 }),
    db.faq.findMany({ orderBy: { order: "asc" }, take: 5 }),
  ]);

  const finished = isEventFinished(settings.event_date);
  const [latestYear, podium] = finished
    ? await getLatestPodium()
    : [null, []];


  const feature = competitions.find((c) => c.slug === "olimpiade-ipas") ?? competitions[0];
  const rest = competitions.filter((c) => c.id !== feature?.id);
  const eventDate = new Date(settings.event_date);
  const tgl = eventDate.toLocaleDateString("id-ID", {
    day: "numeric",
    month: "long",
    year: "numeric",
  }).toUpperCase();
  const openCount = competitions.filter((c) => c.status === "OPEN").length;

  return (
    <main>
      {/* ================= HERO ================= */}
      <section className="relative overflow-hidden bg-paper">
        <div aria-hidden className="dots absolute left-1/2 top-16 hidden h-40 w-40 text-brand/15 lg:block" />
        <div
          aria-hidden
          className="absolute -right-24 -top-24 size-72 rounded-full border-[22px] border-cyanx/[0.08]"
        />
        <div className="mx-auto grid max-w-[1240px] gap-12 px-5 pb-16 pt-10 md:px-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:gap-8 lg:pb-24 lg:pt-14">
          {/* kiri */}
          <div className="relative z-10">
            <Reveal>
              <span className="inline-flex items-center gap-2 rounded-full border border-brand/20 bg-white px-3.5 py-1.5 text-[11px] font-bold uppercase tracking-[0.18em] text-brand shadow-sm">
                <Sparkles size={13} className="text-gold" />
                {finished ? "Edisi 2026 Telah Selesai" : "AKASHI 2026 · Edisi Perdana"}
              </span>
            </Reveal>
            <Reveal delay={70}>
              <h1 className="mt-6 font-display text-[52px] font-extrabold uppercase leading-[0.92] tracking-tight text-ink sm:text-[76px] lg:text-[88px]">
                Ajang
                <br />
                Kreasi
                <br />
                <span className="bg-gradient-to-r from-brand to-electric bg-clip-text text-transparent">
                  Ashidiq
                </span>
              </h1>
            </Reveal>
            <Reveal delay={140}>
              <p className="mt-6 max-w-md text-base leading-relaxed text-ink/60">
                Panggung besar untuk siswa SD:{" "}
                <strong className="font-bold text-ink">berani mencoba</strong>,{" "}
                <strong className="font-bold text-ink">berkompetisi</strong>, dan
                menunjukkan karya terbaik — dalam semangat{" "}
                <em className="not-italic font-bold text-cyanx">
                  &ldquo;{settings.tagline}&rdquo;
                </em>
              </p>
            </Reveal>
            <Reveal delay={190}>
              <div className="mt-7 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm font-bold text-ink/75">
                <span className="rounded-full bg-gold px-3 py-1.5 tracking-wide">{tgl}</span>
                <span className="flex items-center gap-1.5">
                  <MapPin size={15} className="text-brand" />
                  {settings.location || settings.school_name}
                </span>
              </div>
            </Reveal>
            <Reveal delay={240}>
              <div className="mt-9 flex flex-col gap-3 sm:flex-row">
                {finished ? (
                  <>
                    <Link
                      href="/juara"
                      className="group inline-flex items-center justify-center gap-2 rounded-[10px] bg-brand px-7 py-4 text-sm font-extrabold text-white shadow-[0_10px_30px_-8px_rgba(91,33,182,0.5)] transition-all hover:bg-electric"
                    >
                      Lihat Para Juara
                      <ArrowRight size={16} className="transition-transform group-hover:translate-x-1" />
                    </Link>
                    <Link
                      href="/pengumuman"
                      className="inline-flex items-center justify-center gap-2 rounded-[10px] border-2 border-ink/10 bg-white px-7 py-4 text-sm font-extrabold text-ink transition-colors hover:border-brand hover:text-brand"
                    >
                      Pengumuman
                    </Link>
                  </>
                ) : (
                  <>
                    <Link
                      href="/daftar"
                      className="group inline-flex items-center justify-center gap-2 rounded-[10px] bg-brand px-7 py-4 text-sm font-extrabold text-white shadow-[0_10px_30px_-8px_rgba(91,33,182,0.5)] transition-all hover:bg-electric hover:shadow-[0_14px_34px_-8px_rgba(124,58,237,0.55)]"
                    >
                      Daftar Sekarang
                      <ArrowRight size={16} className="transition-transform group-hover:translate-x-1" />
                    </Link>
                    <Link
                      href="#lomba"
                      className="inline-flex items-center justify-center gap-2 rounded-[10px] border-2 border-ink/10 bg-white px-7 py-4 text-sm font-extrabold text-ink transition-colors hover:border-brand hover:text-brand"
                    >
                      Jelajahi Lomba
                    </Link>
                  </>
                )}
              </div>
            </Reveal>
          </div>

          {/* kanan — kolase poster */}
          <Reveal delay={150} className="relative z-10">
            <div className="relative mx-auto max-w-[520px]">
              {/* angka raksasa */}
              <p
                aria-hidden
                className="pointer-events-none absolute -top-14 right-0 select-none font-display text-[150px] font-extrabold leading-none tracking-tighter text-mist lg:text-[190px]"
              >
                26
              </p>
              {/* foto utama */}
              <div className="img-zoom relative overflow-hidden rounded-[18px] shadow-[0_24px_60px_-20px_rgba(17,24,39,0.35)]">
                <Image
                  src={eventImage("hero-siswa.jpg")}
                  alt="Siswa-siswi antusias mengikuti kegiatan sekolah"
                  width={880}
                  height={1100}
                  priority
                  sizes="(max-width: 1024px) 90vw, 42vw"
                  className="h-auto w-full object-cover"
                />
              </div>
              {/* foto overlap */}
              <div className="img-zoom absolute -bottom-10 -left-4 w-[44%] overflow-hidden rounded-[14px] border-4 border-paper bg-white shadow-xl sm:-left-10">
                <Image
                  src={eventImage("hero-membaca.jpg")}
                  alt="Siswa membaca buku"
                  width={480}
                  height={380}
                  sizes="(max-width: 1024px) 38vw, 17vw"
                  className="h-auto w-full object-cover"
                />
              </div>
              {/* floating chip */}
              <div className="absolute -right-2 top-10 flex items-center gap-2 rounded-[12px] bg-white px-4 py-3 shadow-[0_12px_30px_-8px_rgba(17,24,39,0.25)] sm:-right-6">
                <span className="grid size-9 place-items-center rounded-[9px] bg-cyanx/10 font-display text-lg font-extrabold text-cyanx">
                  +
                </span>
                <span>
                  <span className="block font-display text-lg font-extrabold leading-none text-ink">
                    {competitions.length}
                  </span>
                  <span className="block text-[10px] font-bold uppercase tracking-wider text-ink/45">
                    Lomba SD
                  </span>
                </span>
              </div>
              {/* badge bawah */}
              <div className="absolute -bottom-5 right-6 rounded-full bg-gold px-4 py-2 font-display text-xs font-extrabold uppercase tracking-wider text-ink shadow-lg">
                {tgl.split(" ").slice(0, 2).join(" ")} · Simpan Tanggalnya!
              </div>
            </div>
          </Reveal>
        </div>
      </section>

      {finished ? (
        podium.length > 0 ? (
          <section className="bg-white">
            <div className="mx-auto max-w-[1240px] px-5 py-16 md:px-12 md:py-20">
              <Reveal>
                <div className="flex flex-wrap items-end justify-between gap-5">
                  <div>
                    <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
                      <span className="h-px w-8 bg-cyanx" /> Hasil {latestYear}
                    </p>
                    <h2 className="mt-4 font-display text-3xl font-extrabold uppercase leading-tight tracking-tight text-ink md:text-5xl">
                      Para Juara<br />
                      <span className="text-brand">Tahun Ini.</span>
                    </h2>
                  </div>
                  <Link
                    href="/juara"
                    className="group inline-flex items-center gap-2 rounded-[10px] border-2 border-ink/10 bg-white px-5 py-3 text-sm font-extrabold transition-colors hover:border-brand hover:text-brand"
                  >
                    Semua Juara
                    <ArrowUpRight size={15} className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                  </Link>
                </div>
              </Reveal>
              <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                {podium.map((a, i) => (
                  <Reveal key={a.id} delay={(i % 3) * 60}>
                    <article className="h-full rounded-[16px] border border-ink/[0.07] bg-paper p-5">
                      <h3 className="font-display text-sm font-extrabold uppercase tracking-wide text-brand-deep">
                        {a.title}
                      </h3>
                      <ol className="mt-3 space-y-2.5">
                        {a.winners.map((w) => (
                          <li key={w.id} className="flex items-center gap-2.5 text-sm">
                            <span aria-label={`Juara ${w.place}`}>{MEDAL[w.place - 1]}</span>
                            <span className="min-w-0">
                              <span className="block truncate font-bold leading-snug text-ink">{w.participantName}</span>
                              {w.school && <span className="block truncate text-xs text-ink/45">{w.school}</span>}
                            </span>
                          </li>
                        ))}
                      </ol>
                    </article>
                  </Reveal>
                ))}
              </div>
            </div>
          </section>
        ) : null
      ) : (
        <CountdownStrip target={settings.event_date} />
      )}

      {/* ================= INTRO + STATISTIK ================= */}
      <section className="bg-white">
        <div className="mx-auto grid max-w-[1240px] gap-10 px-5 py-16 md:grid-cols-12 md:items-end md:px-12 md:py-20">
          <Reveal className="md:col-span-7">
            <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
              <span className="h-px w-8 bg-cyanx" /> 01 · Akashi 2026
            </p>
            <h2 className="mt-4 font-display text-3xl font-extrabold leading-tight tracking-tight text-ink md:text-[40px]">
              Tempat siswa berani mencoba, berkompetisi,{" "}
              <span className="text-brand">dan menunjukkan karya.</span>
            </h2>
            <p className="mt-4 max-w-lg text-[15px] leading-relaxed text-ink/55">
              Satu hari penuh karya di {settings.school_name} — belasan lomba,
              panggung apresiasi, dan kegiatan seru untuk semua pengunjung.
            </p>
          </Reveal>
          <div className="md:col-span-5">
            <div className="grid grid-cols-3 divide-x divide-ink/10">
              {[
                [`${competitions.length}+`, "Lomba"],
                [`${activities.length}+`, "Kegiatan"],
                ["1", "Hari Penuh Karya"],
              ].map(([n, l]) => (
                <Reveal key={l} delay={80}>
                  <div className="px-3 text-center sm:px-5">
                    <p className="bg-gradient-to-br from-brand to-electric bg-clip-text font-display text-4xl font-extrabold text-transparent sm:text-5xl">
                      {n}
                    </p>
                    <p className="mt-1 text-[10px] font-bold uppercase tracking-[0.14em] text-ink/45">
                      {l}
                    </p>
                  </div>
                </Reveal>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ================= LOMBA ================= */}
      <section id="lomba" className="scroll-mt-16 bg-paper py-16 md:py-24">
        <div className="mx-auto max-w-[1240px] px-5 md:px-12">
          <Reveal>
            <div className="flex flex-wrap items-end justify-between gap-5">
              <h2 className="max-w-md font-display text-3xl font-extrabold uppercase leading-[1.02] tracking-tight text-ink md:text-5xl">
                Pilih
                <br />
                Panggung<span className="text-cyanx">mu.</span>
              </h2>
              <Link
                href="/lomba"
                className="group inline-flex items-center gap-2 rounded-[10px] border-2 border-ink/10 bg-white px-5 py-3 text-sm font-extrabold transition-colors hover:border-brand hover:text-brand"
              >
                Lihat Semua Lomba
                <ArrowUpRight size={15} className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
              </Link>
            </div>
          </Reveal>

          <div className="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            {rest.slice(0, 8).map((c, i) => (
              <Reveal key={c.id} delay={(i % 4) * 60}>
                <CompetitionCard c={c} index={i + 1} image={compImage(c.slug)} />
              </Reveal>
            ))}
          </div>
          {rest.length > 8 && (
            <p className="mt-8 text-center text-sm font-semibold text-ink/50">
              +{rest.length - 8} lomba lainnya menanti —{" "}
              <Link href="/lomba" className="font-extrabold text-brand hover:underline">
                lihat semua
              </Link>
            </p>
          )}

          {/* FEATURED */}
          {feature && (
            <Reveal className="mt-16">
              <article className="grid overflow-hidden rounded-[20px] bg-brand-deep text-white lg:grid-cols-2">
                <div className="order-2 flex flex-col justify-center gap-5 p-8 md:p-12 lg:order-1">
                  <p className="inline-flex w-fit items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.22em] text-gold">
                    ★ Lomba Unggulan
                  </p>
                  <h3 className="font-display text-3xl font-extrabold uppercase leading-tight md:text-4xl">
                    {feature.name}
                  </h3>
                  <p className="max-w-md text-[15px] leading-relaxed text-white/65">
                    &ldquo;Uji kemampuanmu. Buktikan yang terbaik.&rdquo; Kompetisi
                    sains terpadu paling dinantikan — kuota cepat habis.
                  </p>
                  <div className="flex flex-wrap gap-2">
                    {[feature.level, categoryLabel(feature.category), `${feature.quota} Kuota`].map(
                      (b) => (
                        <span
                          key={b}
                          className="rounded-full border border-white/20 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-white/80"
                        >
                          {b}
                        </span>
                      )
                    )}
                  </div>
                  <div className="mt-2 flex flex-wrap gap-3">
                    <Link
                      href={`/lomba/${feature.slug}`}
                      className="group inline-flex items-center gap-2 rounded-[10px] bg-white px-6 py-3.5 text-sm font-extrabold text-brand-deep transition-colors hover:bg-gold hover:text-ink"
                    >
                      Lihat Detail
                      <ArrowRight size={15} className="transition-transform group-hover:translate-x-1" />
                    </Link>
                    {!finished && openCount > 0 && (
                      <Link
                        href={`/daftar?lomba=${feature.slug}`}
                        className="inline-flex items-center rounded-[10px] border-2 border-white/25 px-6 py-3.5 text-sm font-extrabold transition-colors hover:bg-white/10"
                      >
                        Langsung Daftar
                      </Link>
                    )}
                  </div>
                </div>
                <div className="img-zoom relative min-h-[280px] lg:order-2 lg:min-h-[420px]">
                  {compImage(feature.slug) && (
                    <Image
                      src={compImage(feature.slug)!}
                      alt={`Suasana ${feature.name}`}
                      fill
                      sizes="(max-width: 1024px) 100vw, 50vw"
                      className="object-cover"
                    />
                  )}
                  <div aria-hidden className="absolute inset-0 bg-gradient-to-r from-transparent to-brand-deep/20" />
                </div>
              </article>
            </Reveal>
          )}
        </div>
      </section>

      {/* ================= HADIAH ================= */}
      {feature?.prize1 && (
        <section className="bg-white py-16 md:py-24">
          <div className="mx-auto grid max-w-[1240px] gap-12 px-5 md:grid-cols-12 md:px-12">
            <Reveal className="md:col-span-5">
              <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
                <span className="h-px w-8 bg-cyanx" /> 03 · Hadiah
              </p>
              <h2 className="mt-4 font-display text-3xl font-extrabold uppercase leading-[1.02] tracking-tight text-ink md:text-5xl">
                Hadiah
                <br />
                Untuk Para
                <br />
                <span className="text-brand">Juara.</span>
              </h2>
              <p className="mt-4 max-w-xs text-[15px] leading-relaxed text-ink/55">
                Piala, hadiah uang, dan sertifikat. Plus doorprize kejutan untuk
                pengunjung.
              </p>
              <p className="mt-4 inline-block rounded-[8px] bg-gold/25 px-3 py-1.5 text-xs font-bold text-ink/70">
                Nominal tiap lomba dapat berbeda — cek detail lomba.
              </p>
            </Reveal>
            <div className="md:col-span-7">
              {[
                ["Juara 1", feature.prize1, true],
                ["Juara 2", feature.prize2, false],
                ["Juara 3", feature.prize3, false],
              ].map(([tier, prize, top], i) =>
                prize ? (
                  <Reveal key={tier as string} delay={i * 80}>
                    <div
                      className={`mb-3 flex flex-wrap items-center justify-between gap-4 rounded-[14px] border p-5 transition-colors md:p-6 ${
                        top
                          ? "border-brand/25 bg-gradient-to-r from-mist to-transparent"
                          : "border-ink/[0.07] bg-paper"
                      }`}
                    >
                      <div className="flex items-center gap-4">
                        <span
                          className={`grid size-12 place-items-center rounded-full font-display text-lg font-extrabold ${
                            top ? "bg-gold text-ink" : "bg-mist text-brand"
                          }`}
                        >
                          {i + 1}
                        </span>
                        <div>
                          <p className="text-[10px] font-extrabold uppercase tracking-[0.22em] text-ink/40">
                            {tier}
                          </p>
                          <p className="font-display text-lg font-bold text-ink md:text-xl">{prize}</p>
                        </div>
                      </div>
                    </div>
                  </Reveal>
                ) : null
              )}
              {feature.prizeExtra && (
                <p className="mt-2 text-sm font-semibold text-ink/50">+ {feature.prizeExtra}</p>
              )}
            </div>
          </div>
        </section>
      )}

      {/* ================= TIMELINE ================= */}
      <section className="bg-paper py-16 md:py-24">
        <div className="mx-auto grid max-w-[1240px] gap-10 px-5 md:grid-cols-12 md:px-12">
          <Reveal className="md:col-span-4">
            <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
              <span className="h-px w-8 bg-cyanx" /> 04 · Timeline
            </p>
            <h2 className="mt-4 font-display text-3xl font-extrabold uppercase tracking-tight text-ink md:text-4xl">
              Catat
              <br />
              Tanggalnya.
            </h2>
          </Reveal>
          <div className="md:col-span-7 md:col-start-6">
            {schedules.map((s, i) => {
              const d = new Date(s.date);
              return (
                <Reveal key={s.id} delay={i * 70}>
                  <div className="flex items-baseline gap-6 border-t border-ink/10 py-6 last:border-b">
                    <p className="shrink-0 font-display text-2xl font-extrabold text-brand tabular-nums">
                      {d.toLocaleDateString("id-ID", { day: "2-digit", month: "short" }).toUpperCase()}
                    </p>
                    <div className="relative flex-1 pl-6 before:absolute before:left-0 before:top-1.5 before:h-[calc(100%-8px)] before:w-0.5 before:bg-gradient-to-b before:from-cyanx before:to-brand/20">
                      <span className="absolute -left-[3px] top-1.5 size-2 rounded-full bg-cyanx" />
                      <p className="font-display text-lg font-bold text-ink">{s.title}</p>
                      {s.note && <p className="mt-0.5 text-sm text-ink/50">{s.note}</p>}
                    </div>
                  </div>
                </Reveal>
              );
            })}
            <Reveal>
              <Link href="/jadwal" className="mt-5 inline-block text-sm font-extrabold text-brand hover:underline">
                Jadwal lengkap &rarr;
              </Link>
            </Reveal>
          </div>
        </div>
      </section>

      {/* ================= KEGIATAN ================= */}
      <section className="bg-white py-16 md:py-24">
        <div className="mx-auto max-w-[1240px] px-5 md:px-12">
          <Reveal>
            <div className="flex flex-wrap items-end justify-between gap-5">
              <h2 className="max-w-md font-display text-3xl font-extrabold uppercase leading-[1.02] tracking-tight text-ink md:text-5xl">
                Bukan Cuma
                <br />
                Lomba<span className="text-cyanx">.</span>
              </h2>
              <Link href="/kegiatan" className="text-sm font-extrabold text-brand hover:underline">
                Semua kegiatan &rarr;
              </Link>
            </div>
          </Reveal>
          <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:grid-rows-2">
            {activities.map((a, idx) => {
              const img = activityImage(a.name);
              const big = idx === 0;
              return (
                <Reveal key={a.id} delay={(idx % 4) * 60} className={big ? "sm:col-span-2 lg:row-span-2" : ""}>
                  <figure
                    className={`img-zoom group relative h-full min-h-[180px] overflow-hidden rounded-[14px] bg-mist ${
                      big ? "min-h-[280px] lg:min-h-full" : ""
                    }`}
                  >
                    {img ? (
                      <Image
                        src={img}
                        alt={a.name}
                        fill
                        sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                        className="object-cover"
                      />
                    ) : null}
                    <figcaption className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink/85 via-ink/40 to-transparent p-5 pt-14">
                      <p className={`font-display font-extrabold text-white ${big ? "text-2xl" : "text-base"}`}>
                        {a.name}
                      </p>
                      {big && a.description && (
                        <p className="mt-1 max-w-sm text-sm text-white/70 line-clamp-2">{a.description}</p>
                      )}
                    </figcaption>
                  </figure>
                </Reveal>
              );
            })}
          </div>
        </div>
      </section>

      {/* ================= WHY JOIN ================= */}
      <section className="overflow-hidden bg-brand-deep py-20 text-white md:py-28">
        <div className="mx-auto max-w-[1240px] px-5 md:px-12">
          <Reveal>
            <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-gold">
              <span className="h-px w-8 bg-gold" /> 06 · Kenapa Ikut
            </p>
          </Reveal>
          <dl className="mt-10 space-y-2">
            {WHY.map(([a, b, desc], i) => (
              <Reveal key={b} delay={i * 60}>
                <div
                  className="group flex flex-wrap items-baseline justify-between gap-x-8 gap-y-2 border-t border-white/10 py-6 transition-colors last:border-b hover:bg-white/[0.04]"
                  style={{ paddingLeft: `${i * 3}%` }}
                >
                  <dt className="font-display text-[34px] font-extrabold uppercase leading-none tracking-tight md:text-[56px]">
                    <span className="text-white">{a}</span>{" "}
                    <span className="text-transparent [-webkit-text-stroke:1.5px_rgba(255,255,255,0.85)]">
                      {b}
                    </span>
                  </dt>
                  <dd className="max-w-xs text-sm leading-relaxed text-white/50">{desc}</dd>
                </div>
              </Reveal>
            ))}
          </dl>
        </div>
      </section>

      {/* ================= FAQ ================= */}
      {faqs.length > 0 && (
        <section className="bg-paper py-16 md:py-24">
          <div className="mx-auto grid max-w-[1240px] gap-10 px-5 md:grid-cols-12 md:px-12">
            <Reveal className="md:col-span-4">
              <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
                <span className="h-px w-8 bg-cyanx" /> 07 · FAQ
              </p>
              <h2 className="mt-4 font-display text-3xl font-extrabold uppercase tracking-tight text-ink md:text-4xl">
                Sering<br />Ditanyakan.
              </h2>
            </Reveal>
            <div className="md:col-span-7 md:col-start-6">
              {faqs.map((f) => (
                <details key={f.id} className="group border-t border-ink/10 last:border-b">
                  <summary className="flex cursor-pointer list-none items-center justify-between gap-4 py-5 [&::-webkit-details-marker]:hidden">
                    <span className="font-display text-[15.5px] font-bold text-ink transition-colors group-open:text-brand">
                      {f.question}
                    </span>
                    <span
                      aria-hidden
                      className="grid size-8 shrink-0 place-items-center rounded-full bg-mist font-display text-lg font-bold text-brand transition-transform duration-300 group-open:rotate-45 group-open:bg-brand group-open:text-white"
                    >
                      +
                    </span>
                  </summary>
                  <p className="pb-6 pr-10 text-[15px] leading-relaxed text-ink/55">{f.answer}</p>
                </details>
              ))}
            </div>
          </div>
        </section>
      )}

      {/* ================= CTA ================= */}
      <section className="relative overflow-hidden bg-brand text-white">
        <div aria-hidden className="dots absolute bottom-10 right-10 hidden h-36 w-36 text-white/15 lg:block" />
        <div className="pointer-events-none absolute -right-8 top-1/2 hidden -translate-y-1/2 opacity-[0.14] lg:block">
          <Image
            src={eventImage("hero-siswa.jpg")}
            alt=""
            width={480}
            height={600}
            aria-hidden
            className="object-cover"
            style={{
              maskImage: "linear-gradient(200deg, black 30%, transparent 72%)",
              WebkitMaskImage: "linear-gradient(200deg, black 30%, transparent 72%)",
            }}
          />
        </div>
        <div className="relative mx-auto max-w-[1240px] px-5 py-20 md:px-12 md:py-28">
          {finished ? (
            <>
              <Reveal>
                <h2 className="font-display text-[56px] font-extrabold uppercase leading-[0.95] tracking-tight md:text-[84px]">
                  Terima<br />
                  <span className="text-gold">Kasih!</span>
                </h2>
              </Reveal>
              <Reveal delay={90}>
                <p className="mt-6 max-w-lg text-sm font-bold uppercase tracking-[0.24em] text-white/60">
                  {settings.event_name} telah berakhir — sampai jumpa di edisi berikutnya.
                </p>
              </Reveal>
              <Reveal delay={150}>
                <div className="mt-9 flex flex-wrap gap-3">
                  <Link
                    href="/juara"
                    className="group inline-flex items-center gap-2.5 rounded-[10px] bg-white px-8 py-[16px] text-base font-extrabold text-brand shadow-[0_16px_40px_-10px_rgba(0,0,0,0.4)] transition-all hover:-translate-y-0.5 hover:bg-gold hover:text-ink"
                  >
                    LIHAT JUARA
                    <ArrowRight size={17} className="transition-transform group-hover:translate-x-1" />
                  </Link>
                  <Link
                    href="/kegiatan"
                    className="inline-flex items-center rounded-[10px] border-2 border-white/25 px-8 py-[16px] text-base font-extrabold transition-colors hover:bg-white/10"
                  >
                    KEGIATAN SEBELUMNYA
                  </Link>
                </div>
              </Reveal>
            </>
          ) : (
            <>
              <Reveal>
                <h2 className="font-display text-[56px] font-extrabold uppercase leading-[0.95] tracking-tight md:text-[84px]">
                  Siap
                  <br />
                  <span className="text-gold">Tampil?</span>
                </h2>
              </Reveal>
              <Reveal delay={90}>
                <p className="mt-6 text-sm font-bold uppercase tracking-[0.24em] text-white/60">
                  {settings.event_name} — {tgl}
                </p>
              </Reveal>
              <Reveal delay={150}>
                <Link
                  href="/daftar"
                  className="group mt-9 inline-flex items-center gap-2.5 rounded-[10px] bg-white px-9 py-[18px] text-base font-extrabold text-brand shadow-[0_16px_40px_-10px_rgba(0,0,0,0.4)] transition-all hover:-translate-y-0.5 hover:bg-gold hover:text-ink"
                >
                  DAFTAR SEKARANG
                  <ArrowRight size={17} className="transition-transform group-hover:translate-x-1" />
                </Link>
              </Reveal>
            </>
          )}
        </div>
      </section>
    </main>
  );
}
