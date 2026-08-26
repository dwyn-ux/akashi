import type { Metadata } from "next";
import { db } from "@/lib/db";
import { splitLines } from "@/lib/constants";
import { RegistrationForm } from "./registration-form";
import { Reveal } from "@/components/reveal";

export const metadata: Metadata = {
  title: "Pendaftaran",
  description: "Formulir pendaftaran online lomba AKASHI 2026.",
};

export const dynamic = "force-dynamic";

export default async function DaftarPage({
  searchParams,
}: PageProps<"/daftar">) {
  const { lomba } = await searchParams;
  const slug = typeof lomba === "string" ? lomba : undefined;
  const rows = await db.competition.findMany({
    where: { status: "OPEN" },
    orderBy: { name: "asc" },
    select: { id: true, name: true, slug: true, requiredDocs: true, teamSize: true },
  });
  const competitions = rows.map((c) => ({
    id: c.id,
    name: c.name,
    slug: c.slug,
    requiredDocs: splitLines(c.requiredDocs),
    teamSize: c.teamSize,
  }));

  return (
    <main className="bg-cream">
      <section className="border-b border-ink/10 bg-white">
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-plum-soft">Pendaftaran</p>
            <h1 className="mt-3 font-display text-4xl font-semibold leading-tight text-plum md:text-5xl">
              Amankan Tempatmu
            </h1>
            <p className="mt-4 max-w-md text-[15px] text-ink/60">
              Isi data dengan lengkap dan benar. Nomor pendaftaran muncul setelah
              formulir terkirim — simpan baik-baik untuk cek status.
            </p>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto max-w-3xl px-5 py-12 md:py-16">
        {competitions.length > 0 ? (
          <RegistrationForm competitions={competitions} defaultSlug={slug} />
        ) : (
          <p className="rounded-[12px] bg-lavender/60 p-8 text-center font-display text-lg text-plum">
            Belum ada lomba yang membuka pendaftaran. Pantau halaman Lomba untuk
            info terbaru.
          </p>
        )}
      </section>
    </main>
  );
}
