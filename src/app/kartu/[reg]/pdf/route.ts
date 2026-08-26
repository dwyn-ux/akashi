import { NextRequest } from "next/server";
import { readFile } from "fs/promises";
import path from "path";
import { PDFDocument, StandardFonts, rgb, type PDFFont } from "pdf-lib";
import { db } from "@/lib/db";
import { formatRupiah, getSettings } from "@/lib/constants";

const INK = rgb(0.07, 0.09, 0.15);
const MUTED = rgb(0.42, 0.45, 0.5);
const BRAND = rgb(0.357, 0.129, 0.714); // #5b21b6
const PAPER = rgb(0.972, 0.98, 0.988);

// ponytail: kartu PDF digambar manual (pdf-lib) — layout fix A4; kalau desain
// makin kompleks, baru pertimbangkan @react-pdf/renderer.
export async function GET(
  _req: NextRequest,
  { params }: { params: Promise<{ reg: string }> }
) {
  const { reg } = await params;
  const regNumber = decodeURIComponent(reg).toUpperCase();
  const [r, s] = await Promise.all([
    db.registration.findUnique({
      where: { regNumber },
      include: {
        participant: true,
        competition: true,
        members: { orderBy: { id: "asc" } },
      },
    }),
    getSettings(),
  ]);
  if (!r) return new Response("Kartu tidak ditemukan", { status: 404 });

  const pdf = await PDFDocument.create();
  const page = pdf.addPage([595, 842]); // A4 portrait
  const font = await pdf.embedFont(StandardFonts.Helvetica);
  const bold = await pdf.embedFont(StandardFonts.HelveticaBold);
  const W = 595;

  let y = 0;
  const text = (
    str: string,
    x: number,
    yy: number,
    size = 10,
    f: PDFFont = font,
    color = INK
  ) => page.drawText(str, { x, y: yy, size, font: f, color });

  const fit = (str: string, maxW: number, size: number, f: PDFFont = font) => {
    let out = str;
    while (out.length > 1 && f.widthOfTextAtSize(out, size) > maxW)
      out = out.slice(0, -2) + "…";
    return out;
  };

  // ===== kop ungu =====
  page.drawRectangle({ x: 0, y: 752, width: W, height: 90, color: BRAND });
  try {
    if (s.site_logo_url && /\.(png|jpe?g)$/i.test(s.site_logo_url)) {
      const bytes = await readFile(path.join(process.cwd(), "public", s.site_logo_url));
      const img = /\.jpe?g$/i.test(s.site_logo_url)
        ? await pdf.embedJpg(bytes)
        : await pdf.embedPng(bytes);
      page.drawImage(img, { x: 40, y: 764, height: 66, width: (img.width / img.height) * 66 });
    }
  } catch {
    /* logo opsional */
  }
  text("KARTU PESERTA", 120, 800, 20, bold, rgb(1, 1, 1));
  text(`${s.event_name} — ${s.event_full_name}`, 120, 782, 9, font, rgb(0.85, 0.85, 1));
  text(fit(s.school_name, 430, 8), 120, 768, 8, font, rgb(0.75, 0.75, 1));

  // nomor pendaftaran
  text("NOMOR PENDAFTARAN", 40, 720, 8, font, MUTED);
  text(r.regNumber, 40, 700, 18, bold, BRAND);
  const st = r.status === "REJECTED" ? "DITOLAK" : r.status === "PENDING" ? "MENUNGGU VERIFIKASI" : "TERVERIFIKASI PANITIA";
  text(`Status: ${st}`, W - 40 - bold.widthOfTextAtSize(`Status: ${st}`, 9), 724, 9, bold);

  const p = r.participant;
  const teamSize = Math.max(1, r.competition.teamSize || 1);
  const fmtDate = (d: Date) => d.toLocaleDateString("id-ID", { day: "numeric", month: "long", year: "numeric" });

  const sectionTitle = (label: string) => {
    y -= 26;
    text(label, 40, y, 9, bold, rgb(0.02, 0.71, 0.83));
    y -= 4;
    page.drawLine({ start: { x: 40, y }, end: { x: W - 40, y }, thickness: 0.5, color: PAPER });
  };
  const kvRow = (rows: [string, string][], yy: number, colW = 257) => {
    rows.forEach(([k, v], i) => {
      const x = 40 + i * colW;
      text(k.toUpperCase(), x, yy, 6.5, font, MUTED);
      text(fit(v, colW - 14, 10, bold), x, yy - 13, 10, bold, INK);
    });
  };

  // ===== data peserta =====
  sectionTitle("DATA PESERTA");
  y -= 16;
  kvRow([["Nama Lengkap", p.fullName], ["NISN", p.nisn]], (y -= 30));
  kvRow([["Jenis Kelamin", p.gender === "L" ? "Laki-laki" : "Perempuan"], ["Tempat/Tgl Lahir", `${p.birthPlace}, ${fmtDate(p.birthDate)}`]], (y -= 30));
  kvRow([["Asal Sekolah", p.school], ["Kelas", p.gradeClass]], (y -= 30));
  kvRow([["WhatsApp", p.whatsapp], ["Email", p.email || "-"]], (y -= 30));
  kvRow([["Pendamping", `${p.guardian} (${p.guardianRel})`], ["WA Pendamping", p.guardianWa]], (y -= 30));

  // ===== anggota regu =====
  if (r.members.length > 0) {
    sectionTitle(`ANGGOTA REGU (${r.members.length + 1}/${teamSize})`);
    y -= 4;
    text(`1. ${p.fullName} — Ketua`, 40, (y -= 15), 10, bold);
    r.members.forEach((m, i) => {
      text(fit(`${i + 2}. ${m.fullName} — ${m.school}, kelas ${m.gradeClass}`, 515, 10), 40, (y -= 15), 10, font);
    });
  }

  // ===== lomba =====
  sectionTitle("LOMBA YANG DIIKUTI");
  kvRow([["Nama Lomba", r.competition.name], ["Kategori / Jenjang", `${r.competition.category} • ${r.competition.level}`]], (y -= 30));
  kvRow(
    [
      ["Format", teamSize > 1 ? `Regu ${teamSize} orang` : "Individu"],
      ["Biaya", formatRupiah(r.competition.fee)],
    ],
    (y -= 30)
  );
  kvRow(
    [
      ["Jadwal", r.competition.scheduleText || `${s.location || ""}`],
      ["Lokasi", r.competition.location || s.location || s.school_name],
    ],
    (y -= 30)
  );
  text(`Tanggal Event: ${fmtDate(new Date(s.event_date))}`, 40, (y -= 30), 10, bold);

  // ===== footer =====
  page.drawRectangle({ x: 0, y: 0, width: W, height: 64, color: PAPER });
  text(
    "Wajib dibawa (cetak/HP) pada hari-H dan hadir 30 menit sebelum lomba dimulai.",
    40,
    38,
    8.5,
    font,
    MUTED
  );
  text(
    `Info: ${s.whatsapp_label}  •  Cek status: /cek-pendaftaran`,
    40,
    24,
    8.5,
    font,
    MUTED
  );

  const bytes = await pdf.save();
  return new Response(Buffer.from(bytes), {
    headers: {
      "Content-Type": "application/pdf",
      "Content-Disposition": `attachment; filename="Kartu-Peserta-${r.regNumber}.pdf"`,
      "Cache-Control": "no-store",
    },
  });
}
