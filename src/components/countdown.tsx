"use client";

import { useEffect, useState } from "react";

function pad(n: number) {
  return String(Math.max(0, n)).padStart(2, "0");
}

/** Strip hitung mundur horizontal — band gelap di bawah hero. */
export function CountdownStrip({ target }: { target: string }) {
  const [now, setNow] = useState<number | null>(null);
  useEffect(() => {
    const tick = setTimeout(() => setNow(Date.now()), 0);
    const t = setInterval(() => setNow(Date.now()), 1000);
    return () => {
      clearTimeout(tick);
      clearInterval(t);
    };
  }, []);

  let units: [number, string][] = [];
  let done = false;
  if (now !== null) {
    const diff = new Date(target).getTime() - now;
    if (diff <= 0) done = true;
    else
      units = [
        [Math.floor(diff / 86400000), "Hari"],
        [Math.floor(diff / 3600000) % 24, "Jam"],
        [Math.floor(diff / 60000) % 60, "Menit"],
        [Math.floor(diff / 1000) % 60, "Detik"],
      ];
  }
  const shown: [string, string][] =
    now === null
      ? [["00", "Hari"], ["00", "Jam"], ["00", "Menit"], ["00", "Detik"]]
      : units.map(([v, l]) => [pad(v), l] as [string, string]);

  return (
    <section aria-label="Hitung mundur menuju acara" className="bg-brand-deep text-white">
      <div className="mx-auto flex max-w-[1240px] flex-wrap items-center justify-between gap-x-8 gap-y-4 px-5 py-6 md:px-12">
        <p className="text-[11px] font-bold uppercase tracking-[0.26em] text-white/50">
          Menuju Akashi <span className="text-gold">2026</span>
        </p>
        {done ? (
          <p className="font-display text-lg font-bold text-gold">Acara sedang berlangsung!</p>
        ) : (
          <div className="flex items-baseline gap-5 tabular-nums sm:gap-7">
            {shown.map(([v, label], i) => (
              <span key={label} className="flex items-baseline gap-2">
                <span className="font-display text-3xl font-extrabold leading-none sm:text-4xl">
                  {v}
                </span>
                <span className="text-[10px] font-bold uppercase tracking-[0.18em] text-white/50">
                  {label}
                </span>
                {i < 3 && <span aria-hidden className="ml-3 hidden text-white/20 sm:inline">/</span>}
              </span>
            ))}
          </div>
        )}
      </div>
    </section>
  );
}
