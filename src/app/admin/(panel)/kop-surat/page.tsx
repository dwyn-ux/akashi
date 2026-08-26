import { getSettings } from "@/lib/constants";
import { requireRole } from "../../auth-actions";
import { PrintButton } from "./print-button";

export const dynamic = "force-dynamic";

export default async function KopSuratPage() {
  await requireRole(["SUPER_ADMIN", "ADMIN"]);
  const s = await getSettings();
  const year = new Date(s.event_date).getFullYear();

  return (
    <>
      <style>{`
        @media print {
          .no-print { display: none !important; }
          body { background: white !important; }
          .sheet { box-shadow: none !important; margin: 0 !important; border: none !important; }
        }
      `}</style>

      <div className="no-print mb-6 flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-extrabold text-slate-800">Kop Surat</h1>
          <p className="text-sm text-slate-400">Cetak langsung atau simpan sebagai PDF.</p>
        </div>
        <PrintButton />
      </div>

      <div className="sheet mx-auto max-w-[794px] rounded-lg border bg-white p-10 shadow-sm">
        <table className="w-full border-collapse">
          <tbody>
            <tr>
              <td className="w-[110px] align-middle pr-4">
                {s.school_logo_url ? (
                  // eslint-disable-next-line @next/next/no-img-element
                  <img src={s.school_logo_url} alt="Logo Sekolah" className="h-[90px] w-[90px] object-contain" />
                ) : null}
              </td>
              <td className="align-middle text-center">
                <p className="text-lg font-bold uppercase leading-snug tracking-wide text-slate-900">
                  {s.school_name}
                </p>
                {s.address && <p className="text-sm text-slate-700">{s.address}</p>}
                <p className="text-sm text-slate-700">
                  {[s.email && `Email: ${s.email}`, s.instagram && `IG: @${s.instagram.replace("@", "")}`, s.whatsapp_label && `Telp/WA: ${s.whatsapp_label}`]
                    .filter(Boolean)
                    .join("  •  ")}
                </p>
              </td>
              <td className="w-[110px] align-middle pl-4 text-right">
                {s.site_logo_url ? (
                  // eslint-disable-next-line @next/next/no-img-element
                  <img src={s.site_logo_url} alt="Logo Event" className="ml-auto h-[90px] w-[90px] object-contain" />
                ) : null}
              </td>
            </tr>
          </tbody>
        </table>
        <div className="mt-3 border-b-[3px] border-slate-900" />
        <div className="mt-1 border-b border-slate-900" />

        <div className="min-h-[400px] pt-8">
          <p className="text-center font-bold uppercase underline text-slate-900">Lembar Pengesahan / Surat Resmi</p>
          <p className="mt-2 text-center text-sm text-slate-600">
            {s.event_full_name || s.event_name} — Tahun {year}
          </p>
          <div className="mt-16 space-y-6 text-sm leading-7 text-slate-800">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </div>
          <div className="mt-24 flex justify-end">
            <div className="text-center text-sm text-slate-800">
              <p>{s.location || "Sekretariat"}</p>
              <p className="mt-16 font-bold underline">Sekretaris Panitia</p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
