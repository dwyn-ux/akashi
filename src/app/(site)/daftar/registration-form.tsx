"use client";

import Link from "next/link";
import { useActionState, useState } from "react";
import { submitRegistration, type RegistrationResult } from "./actions";

const inputCls =
  "w-full rounded-[10px] border border-ink/15 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-plum focus:ring-2 focus:ring-lavender";

export function RegistrationForm({
  competitions,
  defaultSlug,
}: {
  competitions: { id: string; name: string; slug: string; requiredDocs: string[]; teamSize: number }[];
  defaultSlug?: string;
}) {
  const [state, action, pending] = useActionState<RegistrationResult | null, FormData>(
    submitRegistration,
    null
  );
  const defaultId = competitions.find((c) => c.slug === defaultSlug)?.id;
  const [selectedId, setSelectedId] = useState(defaultId ?? "");
  const selected = competitions.find((c) => c.id === selectedId);
  const requiredDocs = selected?.requiredDocs ?? [];
  const teamSize = Math.max(1, selected?.teamSize || 1);

  if (state?.ok) return <Success regNumber={state.regNumber} />;

  const err = (f: string) => state?.errors?.[f];

  return (
    <form action={action} className="space-y-10">
      <Section title="-- Pilih Lomba --">
        <div>
          <label className="mb-1 block text-sm font-semibold text-slate-600">Lomba *</label>
          <select
            name="competitionId"
            value={selectedId}
            onChange={(e) => setSelectedId(e.target.value)}
            className={inputCls}
            required
          >
            <option value="" disabled>
              -- Pilih Lomba --
            </option>
            {competitions.map((c) => (
              <option key={c.id} value={c.id}>
                {c.name}
              </option>
            ))}
          </select>
          {err("competitionId") && <Err msg={err("competitionId")} />}
        </div>
        {requiredDocs.length > 0 && (
          <div className="sm:col-span-2">
            <label className="mb-1 block text-sm font-semibold text-slate-600">
              Dokumen Wajib (PDF/JPG/PNG, maks. 2MB per file)
            </label>
            <div className="space-y-2">
              {requiredDocs.map((doc, i) => (
                <div key={doc} className="flex items-center gap-3">
                  <span className="w-40 shrink-0 text-xs font-bold uppercase tracking-wide text-cyan-700">
                    {doc}
                  </span>
                  <input
                    type="file"
                    name={`doc_${i}`}
                    accept=".pdf,.jpg,.jpeg,.png"
                    required
                    className="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-lavender file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-plum"
                  />
                </div>
              ))}
            </div>
          </div>
        )}
      </Section>

      <Section title={teamSize > 1 ? "Data Peserta — Ketua Regu" : "Data Peserta"}>
        <Grid>
          <Field label="Nama Lengkap *" error={err("fullName")}>
            <input name="fullName" className={inputCls} required />
          </Field>
          <Field label="NISN (10 digit) *" error={err("nisn")}>
            <input name="nisn" inputMode="numeric" maxLength={10} pattern="\d{10}" className={inputCls} required />
          </Field>
          <Field label="Jenis Kelamin *" error={err("gender")}>
            <select name="gender" className={inputCls} required defaultValue="">
              <option value="" disabled>-- Pilih --</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </Field>
          <Field label="Tempat Lahir *" error={err("birthPlace")}>
            <input name="birthPlace" className={inputCls} required />
          </Field>
          <Field label="Tanggal Lahir *" error={err("birthDate")}>
            <input type="date" name="birthDate" className={inputCls} required />
          </Field>
          <Field label="Asal Sekolah *" error={err("school")}>
            <input name="school" className={inputCls} required />
          </Field>
          <Field label="Kelas *" error={err("gradeClass")}>
            <input name="gradeClass" placeholder="contoh: 5A" className={inputCls} required />
          </Field>
          <Field label="Nomor WhatsApp *" error={err("whatsapp")}>
            <input name="whatsapp" placeholder="08xxxxxxxxxx" className={inputCls} required />
          </Field>
          <Field label="Email" error={err("email")} full>
            <input type="email" name="email" className={inputCls} />
          </Field>
          <Field label="Alamat Rumah *" error={err("address")} full>
            <textarea name="address" rows={2} className={inputCls} required />
          </Field>
        </Grid>
      </Section>

      {teamSize > 1 &&
        Array.from({ length: teamSize - 1 }, (_, i) => i + 2).map((m) => (
          <Section key={m} title={`Anggota Regu ${m} (regu ${teamSize} orang)`}>
            <Grid>
              <Field label="Nama Lengkap *" error={err(`m${m}_fullName`)}>
                <input name={`m${m}_fullName`} className={inputCls} required />
              </Field>
              <Field label="NISN (10 digit) *" error={err(`m${m}_nisn`)}>
                <input name={`m${m}_nisn`} inputMode="numeric" maxLength={10} pattern="\d{10}" className={inputCls} required />
              </Field>
              <Field label="Jenis Kelamin *" error={err(`m${m}_gender`)}>
                <select name={`m${m}_gender`} className={inputCls} required defaultValue="">
                  <option value="" disabled>-- Pilih --</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </Field>
              <Field label="Tempat Lahir *" error={err(`m${m}_birthPlace`)}>
                <input name={`m${m}_birthPlace`} className={inputCls} required />
              </Field>
              <Field label="Tanggal Lahir *" error={err(`m${m}_birthDate`)}>
                <input type="date" name={`m${m}_birthDate`} className={inputCls} required />
              </Field>
              <Field label="Asal Sekolah *" error={err(`m${m}_school`)}>
                <input name={`m${m}_school`} className={inputCls} required />
              </Field>
              <Field label="Kelas *" error={err(`m${m}_gradeClass`)}>
                <input name={`m${m}_gradeClass`} placeholder="contoh: 5A" className={inputCls} required />
              </Field>
            </Grid>
          </Section>
        ))}

      <Section title="Data Orang Tua / Guru Pendamping">
        <Grid>
          <Field label="Nama Pendamping *" error={err("guardian")}>
            <input name="guardian" className={inputCls} required />
          </Field>
          <Field label="Hubungan dengan Peserta *" error={err("guardianRel")}>
            <input name="guardianRel" placeholder="Orang tua / Guru / Wali" className={inputCls} required />
          </Field>
          <Field label="WhatsApp Pendamping *" error={err("guardianWa")}>
            <input name="guardianWa" placeholder="08xxxxxxxxxx" className={inputCls} required />
          </Field>
        </Grid>
      </Section>

      {state?.general && (
        <p className="rounded-[10px] bg-red-50 p-3 text-sm font-medium text-red-600">{state.general}</p>
      )}

      <button
        type="submit"
        disabled={pending}
        className="w-full rounded-[10px] bg-plum py-3.5 font-bold text-white transition hover:opacity-90 disabled:opacity-50"
      >
        {pending ? "Mendaftarkan..." : "Daftar Sekarang"}
      </button>
    </form>
  );
}

function Success({ regNumber }: { regNumber: string }) {
  const waText = encodeURIComponent(
    `Halo, pendaftaran AKASHI 2026 berhasil.\n\nNomor pendaftaran:\n${regNumber}\n\nSilakan simpan nomor pendaftaran untuk mengecek status.`
  );
  return (
    <div className="rounded-[14px] border border-teal/25 bg-teal/10 p-8 text-center">
      <p className="text-2xl font-extrabold text-teal">Pendaftaran Berhasil!</p>
      <p className="mt-3 text-slate-600">Nomor pendaftaran Anda:</p>
      <p className="mt-1 select-all rounded-[10px] bg-white px-4 py-3 font-display text-3xl font-bold tracking-wider text-plum shadow-sm">
        {regNumber}
      </p>
      <p className="mx-auto mt-4 max-w-md text-sm text-slate-500">
        Simpan nomor ini untuk mengecek status pendaftaran di halaman{" "}
        <Link href="/cek-pendaftaran" className="font-semibold text-plum underline">
          Cek Pendaftaran
        </Link>
        .
      </p>
      <div className="mt-5 flex flex-wrap items-center justify-center gap-3">
        <a
          href={`/kartu/${regNumber}/pdf`}
          className="inline-block rounded-[10px] bg-plum px-6 py-2.5 font-semibold text-white transition hover:opacity-90"
        >
          Unduh Kartu Peserta (PDF)
        </a>
        <a
          href={`/kartu/${regNumber}`}
          className="text-sm font-semibold text-plum underline"
        >
          Lihat kartu di browser
        </a>
        <a
          href={`https://wa.me/?text=${waText}`}
          target="_blank"
          rel="noopener noreferrer"
          className="inline-block rounded-[10px] bg-teal px-6 py-2.5 font-semibold text-white transition hover:bg-teal/85"
        >
          Simpan via WhatsApp
        </a>
      </div>
    </div>
  );
}

function Section({ title, children }: { title: string; children: React.ReactNode }) {
  return (
    <fieldset className="rounded-[12px] border border-ink/10 bg-white p-5">
      <legend className="px-2 text-base font-extrabold text-plum">{title}</legend>
      {children}
    </fieldset>
  );
}

function Grid({ children }: { children: React.ReactNode }) {
  return <div className="grid gap-4 sm:grid-cols-2">{children}</div>;
}

function Field({
  label,
  error,
  children,
  full,
}: {
  label: string;
  error?: string;
  children: React.ReactNode;
  full?: boolean;
}) {
  return (
    <div className={full ? "sm:col-span-2" : ""}>
      <label className="mb-1 block text-sm font-semibold text-slate-600">{label}</label>
      {children}
      {error && <Err msg={error} />}
    </div>
  );
}

function Err({ msg }: { msg?: string }) {
  return msg ? <p className="mt-1 text-xs font-semibold text-red-600">{msg}</p> : null;
}
