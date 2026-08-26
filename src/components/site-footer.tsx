import Link from "next/link";

export function SiteFooter({ settings }: { settings: Record<string, string> }) {
  return (
    <footer className="mt-auto bg-ink text-white/60">
      <div className="mx-auto max-w-[1240px] px-5 pt-14 md:px-12">
        <div className="grid gap-10 pb-12 md:grid-cols-12">
          <div className="md:col-span-5">
            <p className="font-display text-xl font-extrabold tracking-tight text-white">
              AKASHI
              <sup className="ml-1 rounded-[6px] bg-cyanx px-1.5 py-0.5 align-super text-[10px] font-bold text-white">
                2026
              </sup>
            </p>
            <p className="mt-2 text-sm text-white/50">{settings.event_full_name}</p>
            <p className="mt-4 max-w-xs text-sm leading-relaxed text-white/45">
              Diselenggarakan oleh {settings.school_name}.
              {settings.address ? ` ${settings.address}` : ""}
            </p>
          </div>
          <nav className="md:col-span-3" aria-label="Navigasi footer">
            <p className="mb-4 text-[10px] font-bold uppercase tracking-[0.24em] text-cyanx">Jelajahi</p>
            <ul className="space-y-2.5 text-sm font-medium">
              {[
                ["/lomba", "Lomba"],
                ["/jadwal", "Jadwal"],
                ["/kegiatan", "Kegiatan"],
                ["/juknis", "Juknis"],
                ["/dokumentasi", "Dokumentasi"],
                ["/pengumuman", "Pengumuman"],
                ["/juara", "Juara"],
                ["/faq", "FAQ"],
                ["/kontak", "Kontak"],
                ["/cek-pendaftaran", "Cek Pendaftaran"],
              ].map(([h, l]) => (
                <li key={h}>
                  <Link href={h} className="transition-colors hover:text-white">
                    {l}
                  </Link>
                </li>
              ))}
            </ul>
          </nav>
          <div className="md:col-span-4">
            <p className="mb-4 text-[10px] font-bold uppercase tracking-[0.24em] text-cyanx">Terhubung</p>
            <ul className="space-y-2.5 text-sm font-medium">
              <li>
                <a href={`https://wa.me/${settings.whatsapp}`} target="_blank" rel="noopener noreferrer" className="transition-colors hover:text-white">
                  WhatsApp — {settings.whatsapp_label}
                </a>
              </li>
              {settings.instagram && (
                <li>
                  <a href={`https://instagram.com/${settings.instagram.replace("@", "")}`} target="_blank" rel="noopener noreferrer" className="transition-colors hover:text-white">
                    Instagram
                  </a>
                </li>
              )}
              {settings.email && (
                <li>
                  <a href={`mailto:${settings.email}`} className="transition-colors hover:text-white">
                    Email
                  </a>
                </li>
              )}
            </ul>
          </div>
        </div>

        {/* watermark raksasa */}
        <p
          aria-hidden
          className="pointer-events-none select-none text-center font-display text-[18vw] font-extrabold leading-[0.8] tracking-tight text-white/[0.04] md:text-[11rem]"
        >
          AKASHI
        </p>
      </div>

      <div className="border-t border-white/[0.06]">
        <div className="mx-auto flex max-w-[1240px] flex-wrap items-center justify-between gap-2 px-5 py-5 text-xs text-white/35 md:px-12">
          <p>{settings.footer_text}</p>
          <p className="font-bold uppercase tracking-[0.18em]">Belajar · Berkarya · Berkompetisi</p>
        </div>
      </div>
    </footer>
  );
}
