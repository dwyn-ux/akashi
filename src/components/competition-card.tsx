import Link from "next/link";
import Image from "next/image";
import { ArrowRight } from "lucide-react";
import { COMPETITION_STATUS_LABELS } from "@/lib/constants";

export function StatusBadge({ status }: { status: string }) {
  const styles: Record<string, string> = {
    DRAFT: "bg-ink/[0.06] text-ink/50",
    SOON: "bg-gold/20 text-[#8a6a00]",
    OPEN: "bg-cyanx/10 text-cyanx",
    CLOSED: "bg-mist text-brand",
    DONE: "bg-ink/[0.06] text-ink/45",
    PENDING: "bg-gold/20 text-[#8a6a00]",
    VERIFIED: "bg-cyanx/10 text-cyanx",
    REJECTED: "bg-red-100 text-red-600",
    LOLOS: "bg-sky/15 text-sky-600",
    FINAL: "bg-mist text-brand",
    SELESAI: "bg-ink/[0.06] text-ink/45",
  };
  return (
    <span
      className={`inline-block rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider ${styles[status] ?? "bg-ink/10"}`}
    >
      {COMPETITION_STATUS_LABELS[status] ?? status}
    </span>
  );
}

export type CompCardData = {
  slug: string;
  name: string;
  category: string;
  level: string;
};

export function categoryLabel(cat: string): string {
  switch (cat) {
    case "Akademik":
      return "Akademik";
    case "Religi":
      return "Qur'ani";
    case "Bahasa":
      return "Bahasa";
    case "Seni":
      return "Kreativitas";
    default:
      return cat;
  }
}

/** Kartu lomba modern: foto + nomor + hover lift + arrow. */
export function CompetitionCard({
  c,
  index,
  image,
}: {
  c: CompCardData;
  index: number;
  image?: string | null;
}) {
  return (
    <Link
      href={`/lomba/${c.slug}`}
      className="group block overflow-hidden rounded-[14px] border border-ink/[0.07] bg-white transition-all duration-300 hover:-translate-y-1 hover:border-brand/30 hover:shadow-[0_16px_40px_-12px_rgba(91,33,182,0.18)]"
    >
      <div className="img-zoom relative aspect-[4/3] overflow-hidden bg-mist">
        {image ? (
          <Image
            src={image}
            alt={c.name}
            fill
            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
            className="object-cover"
          />
        ) : (
          <span
            aria-hidden
            className="grid h-full place-items-center bg-gradient-to-br from-mist to-lavender font-display text-5xl font-extrabold text-brand/20"
          >
            {String(index).padStart(2, "0")}
          </span>
        )}
        <span className="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 font-display text-[11px] font-extrabold text-brand backdrop-blur">
          {String(index).padStart(2, "0")}
        </span>
      </div>
      <div className="p-4">
        <h3 className="font-display text-[17px] font-bold leading-snug text-ink transition-colors group-hover:text-brand">
          {c.name}
        </h3>
        <p className="mt-1 text-[11px] font-bold uppercase tracking-[0.14em] text-cyanx">
          {categoryLabel(c.category)} · {c.level}
        </p>
        <span className="mt-3 inline-flex items-center gap-1.5 text-[13px] font-bold text-ink/40 transition-colors group-hover:text-brand">
          Lihat detail
          <ArrowRight size={14} className="transition-transform duration-300 group-hover:translate-x-1" />
        </span>
      </div>
    </Link>
  );
}
