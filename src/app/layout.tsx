import type { Metadata } from "next";
import { Plus_Jakarta_Sans, Sora } from "next/font/google";
import { getSettings } from "@/lib/constants";
import "./globals.css";

const jakarta = Plus_Jakarta_Sans({
  variable: "--font-jakarta",
  subsets: ["latin"],
});

const sora = Sora({
  variable: "--font-sora",
  subsets: ["latin"],
  weight: ["400", "600", "700", "800"],
});

export async function generateMetadata(): Promise<Metadata> {
  const s = await getSettings();
  return {
    title: {
      default: "AKASHI 2026 — Ajang Kreasi Ashidiq",
      template: "%s | AKASHI 2026",
    },
    description:
      "Portal resmi AKASHI 2026 (Ajang Kreasi Ashidiq) — kompetisi dan kegiatan kreatif untuk siswa SD dari SMP Muhammadiyah Unggulan Ashidiq. Daftar online sekarang!",
    ...(s.favicon_url ? { icons: { icon: s.favicon_url } } : {}),
  };
}

export default async function RootLayout({ children }: LayoutProps<"/">) {
  const s = await getSettings();
  const primary = /^#[0-9a-fA-F]{6}$/.test(s.color_primary || "") ? s.color_primary : "";
  return (
    <html
      lang="id"
      className={`${jakarta.variable} ${sora.variable} h-full antialiased`}
    >
      <body className="min-h-full flex flex-col">
        {primary && (
          <style>{`:root{--color-brand:${primary};--color-electric:color-mix(in srgb,${primary} 78%,white);--color-brand-deep:color-mix(in srgb,${primary} 72%,black);}`}</style>
        )}
        {children}
      </body>
    </html>
  );
}
