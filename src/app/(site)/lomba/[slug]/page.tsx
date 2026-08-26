import Link from "next/link";
import type { Metadata } from "next";
import Image from "next/image";
import { notFound } from "next/navigation";
import { db } from "@/lib/db";
import { splitLines, formatRupiah, COMPETITION_STATUS_LABELS } from "@/lib/constants";
import { compImage } from "@/lib/assets";

export const dynamic = "force-dynamic";

async function getComp(slug: string) {
  return db.competition.findUnique({ where: { slug } });
}

export async function generateMetadata({
  params,
}: PageProps<"/lomba/[slug]">): Promise<Metadata> {
  const { slug } = await params;
  const c = await getComp(slug);
  if (!c) return {};
  return { title: c.name, description: c.description.slice(0, 150) };
}

export default async function DetailLombaPage({
  params,
}: PageProps<"/lomba/[slug]">) {
  const { slug } = await params;
  const c = await getComp(slug);
  if (!c || c.status === "DRAFT") notFound();

  const requirements = splitLines(c.requirements);
  const rules = splitLines(c.rules);
  const docs = splitLines(c.requiredDocs);
  const img = compImage(c.slug);

  return (
    <main className="bg-cream">
      {/* header detail */}
      <section className="border-b border-ink/10 bg-white">
        <div className="mx-auto max-w-[1240px] px-5 py-10 md:px-12 md:py-14">
          <Link href="/lomba" className="text-[13px] font-bold text-plum hover:underline">
            &larr; Semua lomba
          </Link>
          <div className="mt-6 grid gap-8 md:grid-cols-12 md:items-center">
            <div className="md:col-span-7">
              <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-teal">
                {c.category} &middot; Jenjang {c.level}
                {c.gradeClass ? ` · Kelas ${c.gradeClass}` : ""}
              </p>
              <h1 className="mt-3 font-display text-4xl font-semibold leading-tight text-plum md:text-5xl">
                {c.name}
              </h1>
              <p className="mt-4 max-w-xl text-[15px] leading-relaxed text-ink/65">{c.description}</p>
              <dl className="mt-6 flex flex-wrap gap-x-8 gap-y-2 text-sm">
                <Meta k="Biaya" v={formatRupiah(c.fee)} />
                <Meta k="Kuota" v={`${c.quota} peserta`} />
                {c.scheduleText && <Meta k="Jadwal" v={c.scheduleText} />}
                {c.duration && <Meta k="Durasi" v={c.duration} />}
              </dl>
            </div>
            {img && (
              <div className="img-zoom overflow-hidden rounded-[14px] md:col-span-5" style={{ borderRadius: "0 14px 14px 14px" }}>
                <Image
                  src={img}
                  alt={`Ilustrasi ${c.name}`}
                  width={720}
                  height={480}
                  priority
                  sizes="(max-width: 768px) 100vw, 40vw"
                  className="h-auto w-full object-cover"
                />
              </div>
            )}
          </div>
        </div>
      </section>

      {/* isi */}
      <section className="mx-auto grid max-w-[1240px] gap-10 px-5 py-12 md:grid-cols-12 md:gap-12 md:px-12 md:py-16">
        <div className="space-y-10 md:col-span-7">
          <Block n="01" title="Informasi">
            <dl className="grid gap-x-8 sm:grid-cols-2">
              <Row k="Jenjang" v={c.level} />
              <Row k="Kelas" v={c.gradeClass ?? "Semua kelas"} />
              <Row
                k="Rentang usia"
                v={c.minAge || c.maxAge ? `${c.minAge ?? "-"} – ${c.maxAge ?? "-"} tahun` : "Sesuai jenjang"}
              />
              <Row k="Lokasi" v={c.location ?? "Akan diumumkan"} />
              <Row k="Jadwal" v={c.scheduleText ?? "Akan diumumkan"} />
              {c.contactPerson && <Row k="Contact person" v={c.contactPerson} />}
            </dl>
          </Block>

          <Block n="02" title="Hadiah">
            <div className="space-y-3">
              {[["Juara 1", c.prize1], ["Juara 2", c.prize2], ["Juara 3", c.prize3]].map(
                ([tier, prize]) =>
                  prize ? (
                    <div key={tier} className="flex items-baseline gap-4 border-t border-ink/10 pt-3 first:border-0 first:pt-0">
                      <span className="w-20 shrink-0 font-display text-sm font-semibold text-teal">{tier}</span>
                      <span className="text-[15px] font-semibold text-ink">{prize}</span>
                    </div>
                  ) : null
              )}
              {c.prizeExtra && (
                <p className="border-t border-ink/10 pt-3 text-sm text-ink/60">+ {c.prizeExtra}</p>
              )}
            </div>
          </Block>

          {requirements.length > 0 && (
            <Block n="03" title="Syarat Peserta">
              <ListEditorial items={requirements} />
            </Block>
          )}

          {rules.length > 0 && (
            <Block n={requirements.length > 0 ? "04" : "03"} title="Ketentuan Lomba">
              <ListEditorial items={rules} ordered />
            </Block>
          )}

          {docs.length > 0 && (
            <Block n={requirements.length + rules.length > 0 ? "05" : "03"} title="Dokumen Wajib">
              <ListEditorial items={docs} />
              <p className="mt-3 text-xs text-ink/45">
                Dokumen diunggah saat mengisi formulir pendaftaran.
              </p>
            </Block>
          )}
        </div>

        {/* panel pendaftaran */}
        <aside className="md:col-span-5">
          <div className="sticky top-24 rounded-[14px] bg-plum p-7 text-white md:p-8">
            <p className="font-display text-3xl font-semibold">{formatRupiah(c.fee)}</p>
            <p className="mt-1 text-sm text-white/60">
              {c.quota > 0 ? `Kuota ${c.quota} peserta` : "Kuota terbatas"} · {COMPETITION_STATUS_LABELS[c.status] ?? c.status}
            </p>
            <div className="mt-6 space-y-3">
              {c.status === "OPEN" ? (
                <>
                  <Link
                    href={`/daftar?lomba=${c.slug}`}
                    className="block rounded-[8px] bg-white py-3.5 text-center text-sm font-bold text-plum transition-colors hover:bg-cream"
                  >
                    Daftar Lomba Ini
                  </Link>
                  <p className="text-center text-xs text-white/50">
                    Simpan nomor pendaftaran untuk mengecek status.
                  </p>
                </>
              ) : (
                <p className="rounded-[8px] border border-white/20 py-3 text-center text-sm font-semibold text-white/70">
                  Pendaftaran belum dibuka
                </p>
              )}
              <Link
                href="/cek-pendaftaran"
                className="block text-center text-xs font-bold uppercase tracking-wide text-gold hover:underline"
              >
                Sudah mendaftar? Cek status
              </Link>
            </div>
          </div>
        </aside>
      </section>
    </main>
  );
}

function Meta({ k, v }: { k: string; v: string }) {
  return (
    <div>
      <dt className="text-[10px] font-bold uppercase tracking-[0.18em] text-ink/40">{k}</dt>
      <dd className="font-semibold text-ink">{v}</dd>
    </div>
  );
}

function Block({ n, title, children }: { n: string; title: string; children: React.ReactNode }) {
  return (
    <section>
      <h2 className="flex items-baseline gap-3">
        <span className="font-display text-sm font-semibold tracking-widest text-teal tabular-nums">{n}</span>
        <span className="font-display text-2xl font-semibold text-plum">{title}</span>
      </h2>
      <div className="mt-5">{children}</div>
    </section>
  );
}

function Row({ k, v }: { k: string; v: string }) {
  return (
    <div className="border-t border-ink/10 py-2.5">
      <dt className="text-[10px] font-bold uppercase tracking-[0.16em] text-ink/40">{k}</dt>
      <dd className="text-[15px] font-medium text-ink">{v}</dd>
    </div>
  );
}

function ListEditorial({ items, ordered }: { items: string[]; ordered?: boolean }) {
  return (
    <ul className="space-y-2">
      {items.map((item, i) => (
        <li key={i} className="flex gap-3 text-[15px] leading-relaxed text-ink/75">
          <span className="shrink-0 font-display text-sm font-semibold text-plum/60 tabular-nums">
            {ordered ? `${String(i + 1).padStart(2, "0")}.` : "—"}
          </span>
          {item}
        </li>
      ))}
    </ul>
  );
}
