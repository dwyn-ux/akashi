import { revalidatePath } from "next/cache";
import { db } from "@/lib/db";
import { getSettings } from "@/lib/constants";
import { saveImageUpload, saveSetting } from "@/lib/uploads";
import { requireRole } from "../../auth-actions";

export const dynamic = "force-dynamic";
const input =
  "w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:border-violet-500";

const fields: [string, string, string?][] = [
  ["event_name", "Nama Event"],
  ["event_full_name", "Nama Lengkap Event"],
  ["school_name", "Nama Sekolah"],
  ["tagline", "Tagline"],
  ["event_date", "Tanggal Event", "datetime-local"],
  ["registration_open_date", "Pendaftaran Dibuka", "date"],
  ["location", "Lokasi"],
  ["whatsapp", "Nomor WhatsApp (format 62xxx)"],
  ["whatsapp_label", "Label WhatsApp (tampil di web)"],
  ["instagram", "Instagram (username)"],
  ["email", "Email"],
  ["address", "Alamat Sekolah (untuk kop surat)"],
  ["footer_text", "Teks Footer"],
  ["color_primary", "Warna Primer (tema website)", "color"],
];

const LOGOS: [string, string, string][] = [
  ["site_logo_url", "Logo Event (logo web & header)", "Dipakai sebagai logo website."],
  ["favicon_url", "Favicon", "Ikon kecil di tab browser. Disarankan PNG/ICO persegi."],
  ["school_logo_url", "Logo SMP (kop surat)", "Khusus kop surat resmi sekolah."],
];

export default async function AdminPengaturanPage() {
  await requireRole(["SUPER_ADMIN"]);
  const settings = await getSettings();

  async function save(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN"]);
    for (const [key] of fields) {
      const value = formData.get(key);
      if (value !== null && String(value) !== "")
        await db.setting.upsert({ where: { key }, update: { value: String(value) }, create: { key, value: String(value) } });
    }
    revalidatePath("/", "layout");
  }

  async function uploadLogo(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN"]);
    const key = String(formData.get("key") || "");
    if (!LOGOS.some(([k]) => k === key)) return;
    const file = formData.get("file");
    if (!(file instanceof File) || file.size === 0) return;
    const res = await saveImageUpload(file, key.replace("_url", ""));
    if (!res.ok) return;
    await saveSetting(key, res.url);
    revalidatePath("/admin/pengaturan");
    revalidatePath("/", "layout");
  }

  async function removeLogo(formData: FormData) {
    "use server";
    await requireRole(["SUPER_ADMIN"]);
    const key = String(formData.get("key") || "");
    if (!LOGOS.some(([k]) => k === key)) return;
    await db.setting.delete({ where: { key } }).catch(() => {});
    revalidatePath("/admin/pengaturan");
    revalidatePath("/", "layout");
  }

  async function resetColor() {
    "use server";
    await requireRole(["SUPER_ADMIN"]);
    await db.setting.delete({ where: { key: "color_primary" } }).catch(() => {});
    revalidatePath("/admin/pengaturan");
    revalidatePath("/", "layout");
  }

  return (
    <>
      <h1 className="mb-1 text-2xl font-extrabold text-slate-800">Pengaturan</h1>
      <p className="mb-6 text-sm text-slate-400">
        Informasi event, kontak, logo, dan kop surat. Perubahan langsung tampil di seluruh website.
      </p>

      {/* Logo */}
      <div className="mb-6 grid max-w-3xl gap-4 sm:grid-cols-3">
        {LOGOS.map(([key, label, hint]) => {
          const url = settings[key];
          return (
            <div key={key} className="rounded-2xl border bg-white p-4 shadow-sm">
              <p className="text-xs font-bold uppercase text-slate-400">{label}</p>
              <div className="my-3 grid h-24 place-items-center rounded-xl bg-slate-50">
                {url ? (
                  // eslint-disable-next-line @next/next/no-img-element
                  <img src={url} alt={label} className="max-h-20 max-w-full object-contain" />
                ) : (
                  <span className="text-xs text-slate-300">Belum ada</span>
                )}
              </div>
              <form action={uploadLogo} className="space-y-2">
                <input type="hidden" name="key" value={key} />
                <input type="file" name="file" accept="image/png,image/jpeg,image/webp,image/svg+xml,image/x-icon" required
                  className="w-full text-xs file:mr-2 file:rounded-lg file:border-0 file:bg-violet-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-violet-700" />
                <p className="text-[11px] text-slate-400">{hint}</p>
                <div className="flex gap-2">
                  <button className="rounded-lg bg-gradient-to-r from-violet-600 to-cyan-500 px-3 py-1.5 text-xs font-bold text-white">Upload</button>
                </div>
              </form>
              {url && (
                <form action={removeLogo} className="mt-2">
                  <input type="hidden" name="key" value={key} />
                  <button className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-50">Hapus</button>
                </form>
              )}
            </div>
          );
        })}
      </div>

      <form action={save} className="max-w-3xl space-y-4 rounded-2xl border bg-white p-6 shadow-sm">
        <div className="grid gap-4 sm:grid-cols-2">
          {fields.map(([key, label, type]) => (
            <div key={key} className={key === "footer_text" || key === "address" ? "sm:col-span-2" : ""}>
              <label className="mb-1 block text-xs font-bold uppercase text-slate-400">{label}</label>
              {type === "datetime-local" ? (
                <input type="datetime-local" name={key} defaultValue={toLocalInput(settings[key])} className={input} />
              ) : type === "date" ? (
                <input type="date" name={key} defaultValue={(settings[key] || "").slice(0, 10)} className={input} />
              ) : type === "color" ? (
                <div className="flex items-center gap-2">
                  <input type="color" name={key} defaultValue={settings[key] || "#5b21b6"} className="h-10 w-16 cursor-pointer rounded-lg border border-slate-200 bg-white p-1" />
                  <span className="text-xs text-slate-400">Warna utama tombol, judul & aksen. Turunan (gelap/terang) otomatis.</span>
                </div>
              ) : (
                <input name={key} defaultValue={settings[key] ?? ""} className={input} />
              )}
            </div>
          ))}
        </div>
        <button className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-8 py-3 font-bold text-white transition hover:opacity-90">
          Simpan Pengaturan
        </button>
      </form>

      {settings.color_primary && (
        <form action={resetColor} className="mt-3 max-w-3xl">
          <button className="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-50">
            Reset Warna Bawaan
          </button>
        </form>
      )}

      <div className="mt-6 max-w-3xl rounded-2xl border border-violet-100 bg-violet-50 p-5">
        <p className="font-bold text-slate-700">Kop Surat</p>
        <p className="mt-1 text-sm text-slate-500">
          Gunakan Logo SMP + identitas di atas untuk mencetak kop surat resmi.
        </p>
        <a href="/admin/kop-surat" target="_blank"
          className="mt-3 inline-block rounded-lg bg-white px-4 py-2 text-xs font-bold text-violet-700 shadow-sm hover:bg-violet-100">
          Buka Kop Surat ↗
        </a>
      </div>
    </>
  );
}

function toLocalInput(iso: string): string {
  const d = new Date(iso);
  if (isNaN(d.getTime())) return "";
  const off = d.getTimezoneOffset();
  return new Date(d.getTime() - off * 60000).toISOString().slice(0, 16);
}
