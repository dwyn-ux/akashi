import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { db } from "@/lib/db";
import { Reveal } from "@/components/reveal";

export const dynamic = "force-dynamic";

const PAGES: Record<string, { title: string; desc: string }> = {
  juknis: {
    title: "Juknis",
    desc: "Petunjuk teknis pelaksanaan lomba AKASHI.",
  },
  dokumentasi: {
    title: "Dokumentasi",
    desc: "Dokumentasi & liputan kegiatan AKASHI.",
  },
};

export async function generateMetadata({
  params,
}: PageProps<"/[info]">): Promise<Metadata> {
  const { info } = await params;
  const meta = PAGES[info];
  return meta ? { title: meta.title, description: meta.desc } : {};
}

export default async function InfoPage({ params }: PageProps<"/[info]">) {
  const { info } = await params;
  const meta = PAGES[info];
  if (!meta) notFound();
  const page = await db.infoPage.findUnique({ where: { slug: info } });

  return (
    <main className="bg-paper">
      <section className="border-b border-ink/[0.06] bg-white">
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="flex items-center gap-3 font-display text-xs font-extrabold uppercase tracking-[0.26em] text-cyanx">
              <span className="h-px w-8 bg-cyanx" /> Informasi
            </p>
            <h1 className="mt-4 font-display text-4xl font-extrabold uppercase leading-[1.0] tracking-tight text-ink md:text-6xl">
              {page?.title ?? meta.title}
              <span className="text-brand">.</span>
            </h1>
            <p className="mt-5 max-w-md text-[15px] leading-relaxed text-ink/55">{meta.desc}</p>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
        <Reveal>
          {page?.body ? (
            <article className="max-w-3xl whitespace-pre-line rounded-[18px] border border-ink/[0.07] bg-white p-7 text-[15px] leading-relaxed text-ink/75 shadow-[0_2px_20px_rgba(17,24,39,0.04)] md:p-10">
              {page.body}
            </article>
          ) : (
            <p className="max-w-3xl rounded-[18px] border border-dashed border-ink/10 bg-white py-16 text-center font-display text-lg font-bold text-ink/35">
              Konten belum tersedia. Pantau terus halaman ini.
            </p>
          )}
          <div className="mt-6 flex gap-4 text-sm">
            {Object.entries(PAGES).map(([slug, m]) => (
              <Link
                key={slug}
                href={`/${slug}`}
                className={`font-extrabold hover:underline ${
                  slug === info ? "text-brand" : "text-ink/40"
                }`}
              >
                {m.title}
              </Link>
            ))}
          </div>
        </Reveal>
      </section>
    </main>
  );
}
