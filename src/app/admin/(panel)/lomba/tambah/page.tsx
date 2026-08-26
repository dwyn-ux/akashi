import { CompetitionForm } from "../competition-form";
import { requireRole } from "../../../auth-actions";

export default async function TambahLombaPage() {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  return (
    <>
      <h1 className="mb-6 text-2xl font-extrabold text-slate-800">Tambah Lomba</h1>
      <CompetitionForm />
    </>
  );
}
