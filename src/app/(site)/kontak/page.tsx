import type { Metadata } from "next";
import { getSettings } from "@/lib/constants";
import { Reveal } from "@/components/reveal";

export const metadata: Metadata = {
  title: "Kontak",
  description: "Hubungi panitia AKASHI 2026 — SMP Muhammadiyah Unggulan Ashidiq.",
};

export default async function KontakPage() {
  const s = await getSettings();
  return (
    <main className="bg-cream">
      <section className="border-b border-ink/10 bg-white">
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-plum-soft">Kontak</p>
            <h1 className="mt-3 font-display text-4xl font-semibold text-plum md:text-5xl">
              Ngobrol dengan Panitia
            </h1>
            <p className="mt-4 max-w-md text-[15px] text-ink/60">
              Ada pertanyaan seputar lomba atau pendaftaran? Jangan sungkan.
            </p>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto max-w-4xl px-5 py-14 md:py-20">
        <dl className="divide-y divide-ink/10 border-y border-ink/10">
          <ContactRow label="WhatsApp Panitia" value={s.whatsapp_label}>
            <a
              href={`https://wa.me/${s.whatsapp}`}
              target="_blank"
              rel="noopener noreferrer"
              className="rounded-[8px] bg-plum px-5 py-2.5 text-sm font-bold text-white transition-colors hover:bg-plum-soft"
            >
              Chat Sekarang
            </a>
          </ContactRow>
          {s.instagram && (
            <ContactRow label="Instagram" value={s.instagram}>
              <a
                href={`https://instagram.com/${s.instagram.replace("@", "")}`}
                target="_blank"
                rel="noopener noreferrer"
                className="text-sm font-bold text-plum hover:underline"
              >
                Lihat profil &rarr;
              </a>
            </ContactRow>
          )}
          {s.email && (
            <ContactRow label="Email" value={s.email}>
              <a href={`mailto:${s.email}`} className="text-sm font-bold text-plum hover:underline">
                Kirim email &rarr;
              </a>
            </ContactRow>
          )}
          {s.address && (
            <ContactRow label="Alamat" value={s.address} />
          )}
        </dl>
      </section>
    </main>
  );
}

function ContactRow({
  label,
  value,
  children,
}: {
  label: string;
  value: string;
  children?: React.ReactNode;
}) {
  return (
    <Reveal>
      <div className="grid items-center gap-3 py-6 sm:grid-cols-12">
        <dt className="text-[11px] font-bold uppercase tracking-[0.22em] text-teal sm:col-span-3">
          {label}
        </dt>
        <dd className="font-display text-xl text-ink sm:col-span-6">{value}</dd>
        <div className="sm:col-span-3 sm:text-right">{children}</div>
      </div>
    </Reveal>
  );
}
