import { NextRequest } from "next/server";
import { db } from "@/lib/db";
import { getSession } from "@/lib/auth";
import { REGISTRATION_STATUS_LABELS, splitLines } from "@/lib/constants";

function csvEscape(v: string | number) {
  const s = String(v ?? "");
  return /[",\n;]/.test(s) ? `"${s.replaceAll('"', '""')}"` : s;
}

export async function GET(req: NextRequest) {
  const session = await getSession();
  if (!session || session.role === "OPERATOR")
    return new Response("Unauthorized", { status: 401 });

  const sp = req.nextUrl.searchParams;
  const q = sp.get("q")?.trim() || "";
  const status = sp.get("status") || "";
  const competitionId = sp.get("competitionId") || "";

  const regs = await db.registration.findMany({
    where: {
      AND: [
        status ? { status } : {},
        competitionId ? { competitionId } : {},
        q
          ? {
              OR: [
                { regNumber: { contains: q } },
                { participant: { fullName: { contains: q } } },
              ],
            }
          : {},
      ],
    },
    orderBy: { createdAt: "asc" },
    include: {
      participant: true,
      competition: { select: { name: true, requiredDocs: true, teamSize: true } },
      members: { orderBy: { id: "asc" } },
    },
  });

  // ponytail: CSV (bisa dibuka Excel); xlsx native skip sampai diminta eksplisit
  const header = [
    "No",
    "Nomor Pendaftaran",
    "Nama",
    "Lomba",
    "Sekolah",
    "Kelas",
    "WhatsApp",
    "Email",
    "Tanggal Daftar",
    "Status",
    "Status Verifikasi",
    "Dokumen Wajib",
    "Catatan Admin",
    "Format",
    "Anggota Regu",
  ];
  const lines = [header.map(csvEscape).join(",")];
  regs.forEach((r, i) => {
    const docs = splitLines(r.competition.requiredDocs).join("; ");
    const members = r.members.map((m) => m.fullName).join("; ");
    lines.push(
      [
        i + 1,
        r.regNumber,
        r.participant.fullName,
        r.competition.name,
        r.participant.school,
        r.participant.gradeClass,
        r.participant.whatsapp,
        r.participant.email ?? "",
        new Date(r.createdAt).toLocaleString("id-ID"),
        REGISTRATION_STATUS_LABELS[r.status] ?? r.status,
        r.status === "PENDING" ? "Belum diverifikasi" : r.status === "REJECTED" ? "Ditolak" : "Terverifikasi panitia",
        docs,
        r.adminNote ?? "",
        (r.competition.teamSize || 1) > 1 ? `Regu ${r.competition.teamSize} orang` : "Individu",
        members,
      ]
        .map(csvEscape)
        .join(",")
    );
  });

  return new Response("\uFEFF" + lines.join("\r\n"), {
    headers: {
      "Content-Type": "text/csv; charset=utf-8",
      "Content-Disposition": `attachment; filename="peserta-akashi-${new Date().toISOString().slice(0, 10)}.csv"`,
    },
  });
}
