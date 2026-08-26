import { mkdir, writeFile } from "fs/promises";
import path from "path";

const IMAGE_EXT = ["png", "jpg", "jpeg", "webp", "svg", "ico"] as const;
const MAX_LOGO_BYTES = 1 * 1024 * 1024;

// ponytail: simpan ke public/uploads (dev OK); di Vercel ganti ke Blob/S3
// karena filesystem read-only di production.
export async function saveImageUpload(
  file: File,
  prefix: string
): Promise<{ ok: true; url: string } | { ok: false; error: string }> {
  if (!(file instanceof File) || file.size === 0) return { ok: false, error: "File tidak ada." };
  if (file.size > MAX_LOGO_BYTES) return { ok: false, error: "Maksimal 1MB." };
  const ext = (file.name.match(/\.(\w+)$/) || [])[1]?.toLowerCase();
  if (!ext || !(IMAGE_EXT as readonly string[]).includes(ext))
    return { ok: false, error: "Format harus PNG/JPG/WEBP/SVG/ICO." };
  const safeExt = ext === "jpeg" ? "jpg" : ext;
  const dir = path.join(process.cwd(), "public", "uploads");
  await mkdir(dir, { recursive: true });
  const name = `${prefix}-${Date.now()}.${safeExt}`;
  await writeFile(path.join(dir, name), Buffer.from(await file.arrayBuffer()));
  return { ok: true, url: `/uploads/${name}` };
}

export async function saveSetting(key: string, value: string) {
  const { db } = await import("./db");
  await db.setting.upsert({ where: { key }, update: { value }, create: { key, value } });
}
