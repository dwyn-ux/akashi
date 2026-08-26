import { notFound } from "next/navigation";
import { db } from "@/lib/db";
import { requireRole } from "../../../auth-actions";
import { CompetitionForm } from "../competition-form";

export const dynamic = "force-dynamic";

export default async function EditLombaPage({
  params,
}: PageProps<"/admin/lomba/[id]">) {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const { id } = await params;
  const comp = await db.competition.findUnique({ where: { id } });
  if (!comp) notFound();
  return (
    <>
      <h1 className="mb-6 text-2xl font-extrabold text-slate-800">Edit Lomba: {comp.name}</h1>
      <CompetitionForm comp={comp as unknown as Record<string, unknown> & { id: string }} />
    </>
  );
}
