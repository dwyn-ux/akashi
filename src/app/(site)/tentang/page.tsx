import type { Metadata } from "next";
import Image from "next/image";
import { getSettings } from "@/lib/constants";
import { eventImage } from "@/lib/assets";
import { Reveal } from "@/components/reveal";

export const metadata: Metadata = {
  title: "Tentang",
  description: "Tentang AKASHI 2026 — Ajang Kreasi Ashidiq.",
};

export default async function TentangPage() {
  const s = await getSettings();
  return (
    <main className="bg-cream">
      <section className="border-b border-ink/10 bg-white">
        <div className="mx-auto grid max-w-[1240px] gap-8 px-5 py-12 md:grid-cols-12 md:items-center md:px-12 md:py-16">
          <div className="md:col-span-7">
            <Reveal>
              <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-plum-soft">Tentang</p>
              <h1 className="mt-3 font-display text-4xl font-semibold leading-tight text-plum md:text-5xl">
                {s.event_name}
              </h1>
              <p className="mt-3 font-display text-xl text-ink/65">{s.event_full_name}</p>
            </Reveal>
          </div>
          <div className="hidden md:col-span-5 md:block">
            <div className="img-zoom overflow-hidden rounded-[14px]" style={{ borderRadius: "0 14px 14px 14px" }}>
              <Image
                src={eventImage("tentang-guru.jpg")}
                alt="Suasana belajar di sekolah"
                width={640}
                height={420}
                priority
                sizes="35vw"
                className="h-auto w-full object-cover"
              />
            </div>
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-3xl px-5 py-14 md:py-20">
        <Reveal>
          <p className="font-display text-2xl leading-snug text-ink md:text-[28px] md:leading-[1.4]">
            Dengan tagline &ldquo;{s.tagline}&rdquo;, AKASHI hadir untuk
            menumbuhkan semangat belajar, kreativitas, dan nilai-nilai Islami.
          </p>
        </Reveal>
        <Reveal delay={80}>
          <div className="mt-8 space-y-5 text-[15px] leading-relaxed text-ink/65">
            <p>
              AKASHI adalah ajang tahunan yang diselenggarakan oleh{" "}
              <strong className="text-ink">{s.school_name}</strong> untuk siswa-siswi
              tingkat SD. Dalam satu hari penuh, peserta mengikuti belasan lomba —
              dari olimpiade sains hingga seni baca Al-Qur&rsquo;an — diselingi
              gelar karya, talkshow penulis, bazar buku, dan permainan tradisional.
            </p>
            <p>
              Lebih dari kompetisi, AKASHI adalah perayaan: bahwa setiap anak punya
              bakat yang layak dipanggungkan, dan setiap usaha layak dirayakan.
            </p>
          </div>
        </Reveal>
        <Reveal delay={140}>
          <dl className="mt-10 grid gap-6 border-t-2 border-plum/20 pt-6 sm:grid-cols-2">
            <div>
              <dt className="text-[11px] font-bold uppercase tracking-[0.22em] text-teal">Tanggal</dt>
              <dd className="mt-1 font-display text-xl font-semibold text-plum">
                {new Date(s.event_date).toLocaleDateString("id-ID", {
                  day: "numeric",
                  month: "long",
                  year: "numeric",
                })}
              </dd>
            </div>
            <div>
              <dt className="text-[11px] font-bold uppercase tracking-[0.22em] text-teal">Lokasi</dt>
              <dd className="mt-1 font-display text-xl font-semibold text-plum">
                {s.location || s.school_name}
              </dd>
            </div>
          </dl>
        </Reveal>
      </section>
    </main>
  );
}
