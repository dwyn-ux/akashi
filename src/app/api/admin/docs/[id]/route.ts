import { NextRequest } from "next/server";
import { readFile } from "fs/promises";
import path from "path";
import { db } from "@/lib/db";
import { getSession } from "@/lib/auth";

const MIME: Record<string, string> = {
  pdf: "application/pdf",
  jpg: "image/jpeg",
  png: "image/png",
};

export async function GET(
  _req: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  const session = await getSession();
  if (!session) return new Response("Unauthorized", { status: 401 });

  const { id } = await params;
  const doc = await db.registrationDocument.findUnique({ where: { id } });
  if (!doc) return new Response("Not found", { status: 404 });

  // ponytail: baca disk lokal; deploy Vercel -> ganti ke Blob signed URL
  const full = path.join(process.cwd(), doc.filePath);
  try {
    const data = await readFile(full);
    const ext = (doc.fileName.split(".").pop() || "").toLowerCase();
    return new Response(new Uint8Array(data), {
      headers: {
        "Content-Type": MIME[ext] ?? "application/octet-stream",
        "Content-Disposition": `inline; filename="${doc.fileName}"`,
      },
    });
  } catch {
    return new Response("File tidak ditemukan", { status: 404 });
  }
}
