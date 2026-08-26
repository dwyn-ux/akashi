import { existsSync } from "fs";
import path from "path";

const PUB = path.join(process.cwd(), "public");

export function compImage(slug: string): string | null {
  const p = path.join(PUB, "assets", "competitions", `${slug}.jpg`);
  return existsSync(p) ? `/assets/competitions/${slug}.jpg` : null;
}

export function eventImage(file: string): string {
  return `/assets/events/${file}`;
}

const ACT_MAP: [RegExp, string][] = [
  [/gelar/i, "/assets/activities/gelar-karya.jpg"],
  [/talkshow|penulis/i, "/assets/activities/talkshow.jpg"],
  [/bazar|buku/i, "/assets/activities/bazar-buku.jpg"],
  [/dolanan|tradisional/i, "/assets/activities/dolanan-tradisional.jpg"],
  [/batik/i, "/assets/activities/membatik.jpg"],
];

export function activityImage(name: string): string | null {
  for (const [re, img] of ACT_MAP) if (re.test(name)) return img;
  return null;
}
