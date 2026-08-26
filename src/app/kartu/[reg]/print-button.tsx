"use client";

export function PrintButton() {
  return (
    <div className="flex gap-2">
      <button
        onClick={() => window.print()}
        className="rounded-[10px] border-2 border-ink/10 bg-white px-5 py-2.5 text-sm font-bold text-ink transition hover:border-brand hover:text-brand"
      >
        Cetak
      </button>
      <a
        href="pdf"
        className="rounded-[10px] bg-brand px-6 py-2.5 text-sm font-bold text-white transition hover:bg-electric"
      >
        Unduh PDF
      </a>
    </div>
  );
}
