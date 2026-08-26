import type { MetadataRoute } from "next";
import { db } from "@/lib/db";

const base = process.env.NEXT_PUBLIC_BASE_URL || "http://localhost:3000";

export default async function sitemap(): Promise<MetadataRoute.Sitemap> {
  const staticRoutes = ["", "/lomba", "/jadwal", "/kegiatan", "/pengumuman", "/juara", "/faq", "/kontak", "/tentang", "/daftar", "/cek-pendaftaran"];
  const comps = await db.competition.findMany({
    where: { status: { not: "DRAFT" } },
    select: { slug: true, createdAt: true },
  });
  return [
    ...staticRoutes.map((r) => ({ url: `${base}${r}`, lastModified: new Date() })),
    ...comps.map((c) => ({
      url: `${base}/lomba/${c.slug}`,
      lastModified: c.createdAt,
    })),
  ];
}
