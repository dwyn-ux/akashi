import type { Metadata } from "next";
import Image from "next/image";
import { db } from "@/lib/db";
import { Reveal } from "@/components/reveal";
import { activityImage } from "@/lib/assets";

export const metadata: Metadata = {
  title: "Kegiatan",
  description: "Kegiatan pendukung AKASHI 2026: gelar karya, talkshow, bazar buku, dan lainnya.",
};
export const dynamic = "force-dynamic";

const SPANS = [
  "sm:col-span-2 lg:col-span-3",
  "lg:col-span-2",
  "lg:col-span-2",
  "",
  "",
];

export default async function KegiatanPage() {
  const activities = await db.activity.findMany({ orderBy: { name: "asc" } });
  const total = activities.length;

  return (
    <main className="bg-white">
      <section className="border-b border-ink/10 bg-lavender/40">
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-plum-soft">Kegiatan</p>
            <h1 className="mt-3 max-w-lg font-display text-4xl font-semibold leading-tight text-plum md:text-5xl">
              Lebih dari Sekadar Lomba
            </h1>
            <p className="mt-4 max-w-md text-[15px] text-ink/60">
              Satu hari penuh kegiatan untuk semua — peserta, pendamping, dan pengunjung.
            </p>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto grid max-w-[1240px] gap-5 px-5 py-14 sm:grid-cols-2 md:px-12 lg:grid-cols-5 lg:grid-rows-2">
        {activities.map((a, i) => {
          const img = activityImage(a.name);
          // pola asimetris: sel besar di kiri atas, sisanya mengalir
          const span = total <= 5 ? SPANS[i % SPANS.length] : "";
          const tall = span.includes("lg:col-span-3") || i === 0;
          return (
            <Reveal key={a.id} delay={i * 50} className={span}>
              <figure
                className={`img-zoom group relative h-full min-h-[210px] overflow-hidden rounded-[12px] bg-lavender ${
                  tall ? "min-h-[260px]" : ""
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
                <figcaption className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink/85 to-transparent p-5 pt-12">
                  <p className={`font-display font-semibold text-white ${tall ? "text-2xl" : "text-lg"}`}>
                    {a.name}
                  </p>
                  {a.description && (
                    <p className="mt-1 line-clamp-2 text-sm text-white/75">{a.description}</p>
                  )}
                  {(a.date || a.location) && (
                    <p className="mt-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gold">
                      {[
                        a.date &&
                          new Date(a.date).toLocaleDateString("id-ID", {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                          }),
                        a.timeText,
                        a.location,
                      ]
                        .filter(Boolean)
                        .join(" · ")}
                    </p>
                  )}
                </figcaption>
              </figure>
            </Reveal>
          );
        })}
      </section>
      {total === 0 && (
        <p className="py-16 text-center text-ink/40">Kegiatan akan segera diumumkan.</p>
      )}
    </main>
  );
}
