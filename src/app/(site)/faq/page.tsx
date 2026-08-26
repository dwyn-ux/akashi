import type { Metadata } from "next";
import Link from "next/link";
import { db } from "@/lib/db";
import { Reveal } from "@/components/reveal";

export const metadata: Metadata = {
  title: "FAQ",
  description: "Pertanyaan yang sering diajukan seputar AKASHI 2026.",
};
export const dynamic = "force-dynamic";

export default async function FaqPage() {
  const faqs = await db.faq.findMany({ orderBy: { order: "asc" } });
  return (
    <main className="bg-cream">
      <section className="border-b border-ink/10 bg-white">
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-plum-soft">FAQ</p>
            <h1 className="mt-3 font-display text-4xl font-semibold text-plum md:text-5xl">
              Sering Ditanyakan
            </h1>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto max-w-3xl px-5 py-14 md:py-20">
        {faqs.map((f, i) => (
          <Reveal key={f.id} delay={i * 40}>
            <details className="group border-t border-ink/10 last:border-b">
              <summary className="flex cursor-pointer list-none items-start justify-between gap-4 py-5 [&::-webkit-details-marker]:hidden">
                <span className="font-display text-lg font-semibold leading-snug text-ink transition-colors group-open:text-plum">
                  {f.question}
                </span>
                <span
                  aria-hidden
                  className="mt-0.5 shrink-0 font-display text-2xl leading-none text-teal transition-transform duration-300 group-open:rotate-45"
                >
                  +
                </span>
              </summary>
              <p className="pb-6 pr-10 text-[15px] leading-relaxed text-ink/60">{f.answer}</p>
            </details>
          </Reveal>
        ))}
        {faqs.length === 0 && (
          <p className="py-16 text-center text-ink/40">Belum ada pertanyaan umum.</p>
        )}
        <p className="mt-10 text-sm text-ink/50">
          Masih ada yang ingin ditanyakan?{" "}
          <Link href="/kontak" className="font-bold text-plum hover:underline">
            Hubungi panitia &rarr;
          </Link>
        </p>
      </section>
    </main>
  );
}
