"use client";

import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { useEffect, useState } from "react";
import { ArrowUpRight } from "lucide-react";

const links = [
  ["/lomba", "Lomba"],
  ["/jadwal", "Jadwal"],
  ["/kegiatan", "Kegiatan"],
  ["/juknis", "Juknis"],
  ["/pengumuman", "Pengumuman"],
  ["/juara", "Juara"],
  ["/faq", "FAQ"],
  ["/kontak", "Kontak"],
];

export function SiteHeader({
  finished = false,
  logoUrl,
}: {
  finished?: boolean;
  logoUrl?: string;
}) {
  const [open, setOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const pathname = usePathname();

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 8);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <header
      className={`sticky top-0 z-40 transition-all duration-300 ${
        scrolled
          ? "border-b border-ink/[0.06] bg-white/85 shadow-[0_1px_24px_rgba(17,24,39,0.06)] backdrop-blur-lg"
          : "border-b border-transparent bg-paper"
      }`}
    >
      <div className="mx-auto flex h-[72px] max-w-[1240px] items-center justify-between gap-4 px-5 md:px-12">
        <Link href="/" className="flex shrink-0 items-center gap-2" aria-label="Beranda AKASHI 2026">
          {logoUrl ? (
            <Image src={logoUrl} alt="Logo AKASHI" width={36} height={36} className="size-9 object-contain" />
          ) : (
            <span className="grid size-9 place-items-center rounded-[10px] bg-brand font-display text-lg font-extrabold text-white">
              A
            </span>
          )}
          <span className="font-display text-[17px] font-extrabold tracking-tight text-ink">
            AKASHI
            <sup className="ml-1 rounded-[6px] bg-cyanx/10 px-1.5 py-0.5 text-[10px] font-bold text-cyanx">
              2026
            </sup>
          </span>
        </Link>

        <nav className="hidden items-center gap-0.5 lg:flex" aria-label="Navigasi utama">
          {links.map(([href, label]) => (
            <Link
              key={href}
              href={href}
              className={`rounded-[8px] px-3 py-2 text-[13.5px] font-semibold transition-colors ${
                pathname === href ? "bg-mist text-brand" : "text-ink/60 hover:bg-ink/[0.04] hover:text-ink"
              }`}
            >
              {label}
            </Link>
          ))}
          {!finished && (
            <Link
              href="/daftar"
              className="group ml-2 inline-flex items-center gap-1.5 rounded-[10px] bg-brand px-4 py-2.5 text-[13.5px] font-bold text-white transition-colors hover:bg-electric"
            >
              Daftar Sekarang
              <ArrowUpRight size={15} className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
            </Link>
          )}
        </nav>

        <button
          className="grid size-11 place-items-center rounded-[10px] text-ink lg:hidden"
          onClick={() => setOpen(!open)}
          aria-label={open ? "Tutup menu" : "Buka menu"}
          aria-expanded={open}
        >
          <span className="relative block w-5">
            <span className={`absolute left-0 block h-[2px] w-5 rounded-full bg-current transition-all ${open ? "top-2 rotate-45" : "top-0"}`} />
            <span className={`absolute left-0 top-2 block h-[2px] w-5 rounded-full bg-current transition-opacity ${open ? "opacity-0" : ""}`} />
            <span className={`absolute left-0 block h-[2px] w-5 rounded-full bg-current transition-all ${open ? "top-2 -rotate-45" : "top-4"}`} />
          </span>
        </button>
      </div>

      {open && (
        <nav className="border-t border-ink/5 bg-white px-5 pb-5 pt-1 lg:hidden" aria-label="Navigasi mobile">
          {[...links, ...(!finished ? [["/daftar", "Daftar Sekarang"]] : [])].map(([href, label]) => (
            <Link
              key={href}
              href={href}
              onClick={() => setOpen(false)}
              className={`block border-b border-ink/5 py-4 text-[16px] font-bold ${
                href === "/daftar" ? "mt-2 rounded-[10px] bg-brand px-4 text-white" : "text-ink/80"
              }`}
            >
              {label}
            </Link>
          ))}
        </nav>
      )}
    </header>
  );
}
