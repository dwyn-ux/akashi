"use client";

import { useActionState, useState } from "react";
import Link from "next/link";
import { saveCompetition, type CompFormState } from "./actions";
import { COMPETITION_STATUSES, COMPETITION_STATUS_LABELS, splitLines } from "@/lib/constants";

const input =
  "w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-100";
const label = "mb-1 block text-xs font-bold uppercase tracking-wide text-slate-500";

export function CompetitionForm({
  comp,
}: {
  comp?: Record<string, unknown> & { id: string };
}) {
  const [state, action, pending] = useActionState<CompFormState | null, FormData>(
    saveCompetition,
    null
  );
  const err = (f: string) => state?.errors?.[f];
  const v = (k: string) => (comp?.[k] == null ? "" : String(comp[k]));

  const initialDocs = splitLines(v("requiredDocs"));
  const [useDocs, setUseDocs] = useState(initialDocs.length > 0);
  const [docs, setDocs] = useState<string[]>(initialDocs.length > 0 ? initialDocs : [""]);
  const setDoc = (i: number, val: string) => setDocs((d) => d.map((x, j) => (j === i ? val : x)));

  return (
    <form action={action} className="space-y-5">
      {comp && <input type="hidden" name="id" value={comp.id} />}

      <div className="grid gap-4 rounded-2xl border bg-white p-5 sm:grid-cols-2">
        <div>
          <label className={label}>Nama Lomba *</label>
          <input name="name" defaultValue={v("name")} className={input} required />
          {err("name") && <p className="mt-1 text-xs text-red-500">{err("name")}</p>}
        </div>
        <div>
          <label className={label}>Slug (opsional, otomatis dari nama)</label>
          <input name="slug" defaultValue={v("slug")} placeholder="otomatis" className={input} />
        </div>
        <div>
          <label className={label}>Kategori *</label>
          <input name="category" defaultValue={v("category") || "Akademik"} className={input} required />
        </div>
        <div>
          <label className={label}>Jenjang *</label>
          <input name="level" defaultValue={v("level") || "SD"} className={input} required />
        </div>
        <div className="sm:col-span-2">
          <label className={label}>Deskripsi *</label>
          <textarea name="description" defaultValue={v("description")} rows={3} className={input} required />
          {err("description") && <p className="mt-1 text-xs text-red-500">{err("description")}</p>}
        </div>
      </div>

      <div className="grid gap-4 rounded-2xl border bg-white p-5 sm:grid-cols-2 lg:grid-cols-4">
        <div>
          <label className={label}>Usia Minimum</label>
          <input type="number" name="minAge" defaultValue={v("minAge")} min={0} max={30} className={input} />
        </div>
        <div>
          <label className={label}>Usia Maksimum</label>
          <input type="number" name="maxAge" defaultValue={v("maxAge")} min={0} max={30} className={input} />
        </div>
        <div>
          <label className={label}>Kelas</label>
          <input name="gradeClass" defaultValue={v("gradeClass")} placeholder="contoh: 4-6" className={input} />
        </div>
        <div>
          <label className={label}>Kuota *</label>
          <input type="number" name="quota" defaultValue={v("quota") || "0"} min={0} className={input} required />
          {err("quota") && <p className="mt-1 text-xs text-red-500">{err("quota")}</p>}
        </div>
        <div>
          <label className={label}>Jumlah Peserta / Regu *</label>
          <input type="number" name="teamSize" defaultValue={v("teamSize") || "1"} min={1} max={10} className={input} required />
          <p className="mt-1 text-[11px] text-slate-400">1 = individu. Contoh: CCA regu 3 orang → pendaftar mengisi 3 data peserta.</p>
          {err("teamSize") && <p className="mt-1 text-xs text-red-500">{err("teamSize")}</p>}
        </div>
        <div>
          <label className={label}>Biaya Pendaftaran (Rp) *</label>
          <input type="number" name="fee" defaultValue={v("fee") || "0"} min={0} className={input} required />
        </div>
        <div>
          <label className={label}>Status Pendaftaran</label>
          <select name="status" defaultValue={v("status") || "DRAFT"} className={input}>
            {COMPETITION_STATUSES.map((s) => (
              <option key={s} value={s}>
                {COMPETITION_STATUS_LABELS[s]}
              </option>
            ))}
          </select>
        </div>
        <div>
          <label className={label}>Lokasi</label>
          <input name="location" defaultValue={v("location")} className={input} />
        </div>
        <div>
          <label className={label}>Jadwal</label>
          <input name="scheduleText" defaultValue={v("scheduleText")} placeholder="16 Sep 2026, 08.00" className={input} />
        </div>
        <div>
          <label className={label}>Durasi</label>
          <input name="duration" defaultValue={v("duration")} placeholder="90 menit" className={input} />
        </div>
        <div>
          <label className={label}>Contact Person</label>
          <input name="contactPerson" defaultValue={v("contactPerson")} className={input} />
        </div>
      </div>

      <div className="grid gap-4 rounded-2xl border bg-white p-5 sm:grid-cols-2">
        <Field label="Hadiah Juara 1"><input name="prize1" defaultValue={v("prize1")} className={input} /></Field>
        <Field label="Hadiah Juara 2"><input name="prize2" defaultValue={v("prize2")} className={input} /></Field>
        <Field label="Hadiah Juara 3"><input name="prize3" defaultValue={v("prize3")} className={input} /></Field>
        <Field label="Hadiah Tambahan"><input name="prizeExtra" defaultValue={v("prizeExtra")} className={input} /></Field>
        <Field label="Syarat Peserta (satu per baris)"><textarea name="requirements" defaultValue={v("requirements")} rows={3} className={input} /></Field>
        <Field label="Ketentuan Lomba (satu per baris)"><textarea name="rules" defaultValue={v("rules")} rows={3} className={input} /></Field>
        <div className="sm:col-span-2">
          <label className="flex items-center gap-2 text-sm font-bold text-slate-600">
            <input
              type="checkbox"
              checked={useDocs}
              onChange={(e) => setUseDocs(e.target.checked)}
              className="size-4 accent-violet-600"
            />
            Lomba ini butuh dokumen upload
          </label>
          {useDocs && (
            <div className="mt-3 space-y-2 rounded-xl border border-dashed border-slate-200 p-3">
              <p className="text-xs font-bold uppercase tracking-wide text-slate-400">Dokumen yang diminta dari peserta:</p>
              {docs.map((d, i) => (
                <div key={i} className="flex items-center gap-2">
                  <input
                    value={d}
                    onChange={(e) => setDoc(i, e.target.value)}
                    placeholder={`Nama dokumen ${i + 1} (misal: Kartu Pelajar)`}
                    className={input}
                  />
                  <button
                    type="button"
                    onClick={() => setDocs((arr) => arr.filter((_, j) => j !== i))}
                    className="rounded-lg border border-red-200 px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-50"
                    aria-label="Hapus dokumen"
                  >
                    ×
                  </button>
                </div>
              ))}
              <button
                type="button"
                onClick={() => setDocs((arr) => [...arr, ""])}
                className="rounded-lg bg-violet-50 px-3 py-1.5 text-xs font-bold text-violet-700 hover:bg-violet-100"
              >
                + Tambah Dokumen
              </button>
            </div>
          )}
          {/* selalu terkirim: kosong saat toggle off → dokumen dihapus */}
          <input type="hidden" name="requiredDocs" value={useDocs ? docs.filter((d) => d.trim()).join("\n") : ""} />
        </div>
      </div>

      {state?.general && (
        <p className="rounded-xl bg-red-50 p-3 text-sm font-medium text-red-600">{state.general}</p>
      )}

      <div className="flex gap-3">
        <button
          disabled={pending}
          className="rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 px-8 py-3 font-bold text-white transition hover:opacity-90 disabled:opacity-50"
        >
          {pending ? "Menyimpan..." : "Simpan"}
        </button>
        <Link
          href="/admin/lomba"
          className="rounded-xl border px-6 py-3 font-semibold text-slate-500 hover:bg-slate-50"
        >
          Batal
        </Link>
      </div>
    </form>
  );
}

function Field({ label: l, children }: { label: string; children: React.ReactNode }) {
  return (
    <div>
      <label className={label}>{l}</label>
      {children}
    </div>
  );
}
