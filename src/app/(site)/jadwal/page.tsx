import type { Metadata } from "next";
import { db } from "@/lib/db";
import { Reveal } from "@/components/reveal";

export const metadata: Metadata = { title: "Agenda" };
export const dynamic = "force-dynamic";

export default async function JadwalPage() {
  const schedules = await db.schedule.findMany({ orderBy: { date: "asc" } });
  return (
    <main className="bg-cream">
      <section className="border-b border-ink/10 bg-white">
        <div className="mx-auto max-w-[1240px] px-5 py-12 md:px-12 md:py-16">
          <Reveal>
            <p className="text-[11px] font-bold uppercase tracking-[0.24em] text-plum-soft">Agenda</p>
            <h1 className="mt-3 font-display text-4xl font-semibold text-plum md:text-5xl">
              Catat Tanggalnya
            </h1>
          </Reveal>
        </div>
      </section>

      <section className="mx-auto max-w-3xl px-5 py-14 md:py-20">
        <ol>
          {schedules.map((s, i) => {
            const d = new Date(s.date);
            return (
              <Reveal key={s.id} delay={i * 60}>
                <li className="flex gap-6 border-t border-ink/10 py-6 last:border-b">
                  <div className="w-24 shrink-0 text-right">
                    <p className="font-display text-3xl font-semibold leading-none text-plum tabular-nums">
                      {String(d.getDate()).padStart(2, "0")}
                    </p>
                    <p className="mt-1 text-[11px] font-bold uppercase tracking-[0.18em] text-teal">
                      {d.toLocaleDateString("id-ID", { month: "short", year: "numeric" })}
                    </p>
                  </div>
                  <div className="relative flex-1 pl-7 before:absolute before:left-0 before:top-1.5 before:h-[calc(100%-8px)] before:w-px before:bg-plum/25">
                    <span className="absolute -left-[3.5px] top-1.5 size-2 rounded-full bg-teal" />
                    <p className="pt-0.5 font-display text-xl font-semibold text-ink">{s.title}</p>
                    <p className="mt-1 text-xs uppercase tracking-wide text-ink/45">
                      {d.toLocaleDateString("id-ID", { weekday: "long" })} ·{" "}
                      {d.toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit" })} WIB
                    </p>
                    {s.note && <p className="mt-2 text-sm text-ink/55">{s.note}</p>}
                  </div>
                </li>
              </Reveal>
            );
          })}
        </ol>
        {schedules.length === 0 && (
          <p className="py-16 text-center text-ink/40">Jadwal akan segera diumumkan.</p>
        )}
      </section>
    </main>
  );
}
