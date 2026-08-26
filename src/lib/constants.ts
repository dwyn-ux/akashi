export const COMPETITION_STATUSES = [
  "DRAFT",
  "SOON",
  "OPEN",
  "CLOSED",
  "DONE",
] as const;

export const COMPETITION_STATUS_LABELS: Record<string, string> = {
  DRAFT: "Draft",
  SOON: "Akan Dibuka",
  OPEN: "Pendaftaran Dibuka",
  CLOSED: "Pendaftaran Ditutup",
  DONE: "Selesai",
};

export const REGISTRATION_STATUSES = [
  "PENDING",
  "VERIFIED",
  "REJECTED",
  "LOLOS",
  "FINAL",
  "SELESAI",
] as const;

export const REGISTRATION_STATUS_LABELS: Record<string, string> = {
  PENDING: "Menunggu Verifikasi",
  VERIFIED: "Terverifikasi",
  REJECTED: "Ditolak",
  LOLOS: "Lolos Administrasi",
  FINAL: "Peserta Final",
  SELESAI: "Selesai",
};

export function splitLines(s?: string | null): string[] {
  if (!s) return [];
  return s
    .split(/\r?\n/)
    .map((l) => l.trim())
    .filter(Boolean);
}

export function formatRupiah(n: number): string {
  if (!n) return "Gratis";
  return "Rp " + n.toLocaleString("id-ID");
}

export async function getSettings(): Promise<Record<string, string>> {
  const { db } = await import("./db");
  const rows = await db.setting.findMany();
  const defaults: Record<string, string> = {
    event_name: "AKASHI 2026",
    event_full_name: "Ajang Kreasi Ashidiq",
    school_name: "SMP Muhammadiyah Unggulan Ashidiq",
    tagline: "Bangun Generasi Qur'ani",
    event_date: "2026-09-16T07:00:00+07:00",
    registration_open_date: "2026-09-01T00:00:00+07:00",
    location: "",
    whatsapp: "6281277570669",
    whatsapp_label: "0812-7757-0669 (Ust. Nur Wahyudi)",
    instagram: "",
    email: "",
    address: "",
    footer_text:
      "\u00a9 2026 AKASHI \u2014 Ajang Kreasi Ashidiq \u2022 SMP Muhammadiyah Unggulan Ashidiq",
  };
  for (const r of rows) defaults[r.key] = r.value;
  return defaults;
}
