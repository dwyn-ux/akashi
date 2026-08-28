@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

{{-- HERO — Clean Competition, white dominant, 2-col --}}
<section class="bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-14 lg:py-16">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">
            {{-- LEFT --}}
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-primary/15 bg-primary-50 px-3 py-1 text-xs font-semibold tracking-wide text-primary">
                    <span class="w-1.5 h-1.5 rounded-full bg-gold"></span>
                    Kompetisi Pelajar 2026 — SMP Muhammadiyah Unggulan Ashidiq
                </div>

                <h1 class="mt-5 font-extrabold tracking-tight leading-[0.95] text-navy">
                    <span class="block text-3xl sm:text-4xl lg:text-[44px]">Ajang Kreasi</span>
                    <span class="block text-3xl sm:text-4xl lg:text-[44px] text-primary">Ashidiq 2026</span>
                </h1>

                <p class="mt-3 text-base font-semibold text-navy">Tunjukkan Bakatmu, Raih Prestasimu!</p>

                <p class="mt-3 text-sm leading-relaxed text-muted-foreground max-w-[52ch]">
                    Kompetisi dan festival untuk siswa SMP Muhammadiyah Unggulan Ashidiq. Saatnya generasi muda unjuk kreativitas, kompetensi dan sportivitas menuju masa depan yang lebih baik.
                </p>

                <div class="mt-5 flex flex-wrap items-center gap-3 text-sm">
                    <span class="inline-flex items-center gap-2 rounded-full border border-border bg-white px-3 py-1.5 text-xs font-medium text-foreground">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        16 September 2026
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full border border-border bg-white px-3 py-1.5 text-xs font-medium text-foreground">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        SMP Muhammadiyah Unggulan Ashidiq
                    </span>
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    @if($finished)
                        <a href="{{ route('juara.index') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-primary px-5 text-sm font-semibold text-primary-foreground hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring transition-colors">
                            Lihat Para Juara
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L6 6m0 0l6 6m-6-6v12a2.25 2.25 0 002.25 2.25h9A2.25 2.25 0 0019.5 18V6"/></svg>
                        </a>
                        <a href="{{ route('juknis.show') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-border bg-white px-5 text-sm font-medium hover:bg-muted transition-colors">Lihat Juknis</a>
                    @else
                        <a href="{{ route('daftar.index') }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-primary px-6 text-sm font-semibold text-primary-foreground hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring transition-colors">
                            Daftar Sekarang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L6 6m0 0l6 6m-6-6v12"/></svg>
                        </a>
                        <a href="{{ route('juknis.show') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-border bg-white px-5 text-sm font-medium hover:bg-muted transition-colors">Lihat Juknis</a>
                    @endif
                </div>
            </div>

            {{-- RIGHT — trophy visual + countdown --}}
            <div class="lg:pl-6">
                {{-- Trophy visual — clean flat editorial --}}
                <div class="relative rounded-xl border border-border bg-white p-6 sm:p-8 overflow-hidden">
                    {{-- subtle bg texture inside card --}}
                    <div class="absolute inset-0 pointer-events-none">
                        <svg class="absolute -top-6 -right-6 w-24 h-24 text-primary/[0.06]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6.084 10H4.5A2.5 2.5 0 0 1 2 7.5V5a1 1 0 0 1 1-1h3"/><path d="M17.916 10H19.5A2.5 2.5 0 0 0 22 7.5V5a1 1 0 0 0-1-1h-3"/><path d="M4 22h16"/><path d="M10 14.66V17a1 1 0 0 1-1 1 2 2 0 0 0-2 2v2"/><path d="M14 14.66V17a1 1 0 0 0 1 1 2 2 0 0 1 2 2v2"/></svg>
                        <svg class="absolute -bottom-4 -left-4 w-20 h-20 text-gold/[0.08]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="12" cy="8" r="6"/><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/></svg>
                    </div>
                    <div class="relative flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-xl bg-primary-50 border border-primary/10 flex items-center justify-center">
                            <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <span class="w-6 h-px bg-gold/40"></span>
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/></svg>
                            <span class="w-6 h-px bg-gold/40"></span>
                        </div>
                        <h3 class="mt-2 font-extrabold tracking-tight text-navy">Championship</h3>
                        <p class="text-xs font-medium tracking-widest uppercase text-muted-foreground">AKASHI 2026</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-gold-50 border border-gold-100 px-3 py-1 text-xs font-semibold text-gold-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-gold"></span>
                            Prestasi · Sportivitas · Kreativitas
                        </div>
                    </div>
                </div>

                {{-- Countdown — white, thin purple border, no shadow --}}
                @if(!$finished && ($settings['event_date'] ?? null))
                <div class="mt-4 rounded-xl border border-primary/20 bg-white p-4">
                    <div class="flex items-center justify-between gap-3 mb-3">
                        <span class="text-xs font-semibold tracking-widest uppercase text-primary">Hitung Mundur</span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 border border-green-200 px-2.5 py-1 text-xs font-medium text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Pendaftaran Dibuka
                        </span>
                    </div>
                    <div id="countdown" class="grid grid-cols-4 gap-2">
                        <div class="rounded-lg border border-primary/15 bg-white p-2.5 text-center">
                            <div id="cd-days" class="text-xl font-extrabold leading-none text-navy">00</div>
                            <div class="text-[10px] font-semibold tracking-widest text-muted-foreground mt-1">HARI</div>
                        </div>
                        <div class="rounded-lg border border-primary/15 bg-white p-2.5 text-center">
                            <div id="cd-hours" class="text-xl font-extrabold leading-none text-navy">00</div>
                            <div class="text-[10px] font-semibold tracking-widest text-muted-foreground mt-1">JAM</div>
                        </div>
                        <div class="rounded-lg border border-primary/15 bg-white p-2.5 text-center">
                            <div id="cd-minutes" class="text-xl font-extrabold leading-none text-navy">00</div>
                            <div class="text-[10px] font-semibold tracking-widest text-muted-foreground mt-1">MENIT</div>
                        </div>
                        <div class="rounded-lg border border-primary/15 bg-white p-2.5 text-center">
                            <div id="cd-seconds" class="text-xl font-extrabold leading-none text-navy">00</div>
                            <div class="text-[10px] font-semibold tracking-widest text-muted-foreground mt-1">DETIK</div>
                        </div>
                    </div>
                    <div class="mt-3 text-center text-xs text-muted-foreground">16 September – 30 September 2026</div>
                </div>
                @else
                <div class="mt-4 rounded-xl border border-border bg-white p-4 flex items-center justify-between">
                    <div>
                        <div class="text-sm font-semibold text-navy">Pendaftaran Dibuka</div>
                        <div class="text-xs text-muted-foreground">16 September – 30 September 2026</div>
                    </div>
                    <a href="{{ route('daftar.index') }}" class="h-9 px-4 inline-flex items-center justify-center rounded-md bg-primary text-primary-foreground text-sm font-medium">Daftar →</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>


{{-- STATS — horizontal, white/off-white, thin separators, no heavy shadow --}}
<section class="border-y border-border bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-y lg:divide-y-0 lg:divide-x divide-border">
            <div class="flex items-center gap-4 py-6 lg:py-8 px-2 lg:px-6">
                <div class="w-10 h-10 rounded-lg bg-primary-50 border border-primary/10 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128V21a2.25 2.25 0 002.25 2.25h3.75"/><circle cx="10" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-2a4 4 0 014-4h.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/></svg>
                </div>
                <div>
                    <div class="text-xl font-extrabold tracking-tight text-navy">1000+</div>
                    <div class="text-xs font-medium text-muted-foreground">Peserta Siap Berkompetisi</div>
                </div>
            </div>
            <div class="flex items-center gap-4 py-6 lg:py-8 px-2 lg:px-6">
                <div class="w-10 h-10 rounded-lg bg-gold-50 border border-gold-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75a3 3 0 01-3-3h15a3 3 0 01-3 3m-9 0v-3.375c0-.621-.503-1.125-1.125-1.125H3.375c-.621 0-1.125.503-1.125 1.125v3.375M3.75 21h.008v.008H3.75V21zm0-3.75h.008v.008H3.75V17.25zM20.25 21h.008v.008H20.25V21zm0-3.75h.008v.008H20.25V17.25z"/></svg>
                </div>
                <div>
                    <div class="text-xl font-extrabold tracking-tight text-navy">20+</div>
                    <div class="text-xs font-medium text-muted-foreground">Cabang Lomba Menantang</div>
                </div>
            </div>
            <div class="flex items-center gap-4 py-6 lg:py-8 px-2 lg:px-6">
                <div class="w-10 h-10 rounded-lg bg-primary-50 border border-primary/10 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                </div>
                <div>
                    <div class="text-sm font-bold tracking-tight text-navy">Hadiah Menarik</div>
                    <div class="text-xs font-medium text-muted-foreground">Untuk Juara</div>
                </div>
            </div>
            <div class="flex items-center gap-4 py-6 lg:py-8 px-2 lg:px-6">
                <div class="w-10 h-10 rounded-lg bg-white border border-border flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-navy" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <div>
                    <div class="text-sm font-bold tracking-tight text-navy">Fair Play</div>
                    <div class="text-xs font-medium text-muted-foreground">Sportivitas Terjaga</div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!$finished)

{{-- KENAPA IKUT — eyebrow, heading, subheading, 4 cards clean --}}
<section class="py-12 sm:py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="max-w-2xl">
            <div class="text-xs font-semibold tracking-[0.18em] uppercase text-primary">KENAPA IKUT AKASHI?</div>
            <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold tracking-tight text-navy">Empat Alasan Untuk Tampil dan Bersinar</h2>
            <p class="mt-3 text-sm leading-relaxed text-muted-foreground">Jangan lewatkan kesempatan untuk mengembangkan potensi dan meraih prestasi terbaikmu!</p>
        </div>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-xl border bg-white p-5">
                <div class="w-10 h-10 rounded-lg border bg-primary-50 border-primary/10 flex items-center justify-center text-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                </div>
                <h3 class="mt-4 font-semibold text-sm text-navy">Kembangkan Potensi</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-muted-foreground">Asah bakat dan kreativitasmu dengan kompetisi yang menantang.</p>
            </div>
            <div class="rounded-xl border bg-white p-5">
                <div class="w-10 h-10 rounded-lg border bg-gold-50 border-gold-100 flex items-center justify-center text-gold-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg>
                </div>
                <h3 class="mt-4 font-semibold text-sm text-navy">Raih Prestasi</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-muted-foreground">Menjadi yang terbaik dan mendapatkan pengakuan.</p>
            </div>
            <div class="rounded-xl border bg-white p-5">
                <div class="w-10 h-10 rounded-lg border bg-primary-50 border-primary/10 flex items-center justify-center text-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                </div>
                <h3 class="mt-4 font-semibold text-sm text-navy">Bangun Relasi</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-muted-foreground">Kenalan dan bertukar inspirasi dengan peserta dari sekolah lain.</p>
            </div>
            <div class="rounded-xl border bg-white p-5">
                <div class="w-10 h-10 rounded-lg border bg-gold-50 border-gold-100 flex items-center justify-center text-gold-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75a3 3 0 01-3-3h15a3 3 0 01-3 3m-9 0v-3.375c0-.621-.503-1.125-1.125-1.125H3.375c-.621 0-1.125.503-1.125 1.125v3.375M3.75 21h.008v.008H3.75V21zm0-3.75h.008v.008H3.75V17.25zM20.25 21h.008v.008H20.25V21zm0-3.75h.008v.008H20.25V17.25z"/></svg>
                </div>
                <h3 class="mt-4 font-semibold text-sm text-navy">Pengalaman Berharga</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-muted-foreground">Tumbuh lebih percaya diri dan siap menghadapi tantangan masa depan.</p>
            </div>
        </div>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 sm:px-6"><div class="h-px bg-border"></div></div>


{{-- LOMBA — bento: featured + grid --}}
@if($competitions->count())
<section class="py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold tracking-tight">Lomba</h2>
                <p class="text-sm text-muted-foreground mt-1">Pilih lomba yang paling kamu minati.</p>
            </div>
            <a href="{{ route('lomba.index') }}" class="hidden sm:inline-flex h-9 px-4 rounded-md border bg-background text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-colors">Lihat Semua</a>
        </div>

        @php $all = $competitions->take(6); $featuredLomba = $all->first(); $rest = $all->slice(1); @endphp
        <div class="grid lg:grid-cols-3 gap-4">
            {{-- Featured --}}
            @if($featuredLomba)
            <a href="{{ route('lomba.show', $featuredLomba->slug) }}" class="group lg:row-span-2 flex flex-col overflow-hidden rounded-xl border bg-card shadow-sm hover:border-primary/20 hover:border-primary/20 transition-all">
                <div class="h-44 lg:h-[220px] bg-primary-50 relative overflow-hidden flex items-center justify-center">
                    @if($featuredLomba->cover_url)
                        <img src="{{ $featuredLomba->cover_url }}" alt="{{ $featuredLomba->name }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                    @else
                        <svg class="w-14 h-14 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871"/></svg>
                    @endif
                    <span class="absolute top-3 right-3 inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $featuredLomba->status === 'OPEN' ? 'bg-green-500 text-white' : 'bg-muted text-muted-foreground' }}">{{ $featuredLomba->status === 'OPEN' ? 'Buka' : 'Tutup' }}</span>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="inline-flex w-fit rounded-md bg-secondary px-2 py-1 text-[11px] font-medium text-secondary-foreground">{{ $featuredLomba->category }}</span>
                    <h3 class="font-semibold leading-tight mt-2 group-hover:text-primary transition-colors">{{ $featuredLomba->name }}</h3>
                    <p class="text-sm text-muted-foreground line-clamp-2 mt-1 flex-1">{{ $featuredLomba->description }}</p>
                    <span class="text-sm font-medium text-primary mt-4 inline-flex items-center gap-1 group-hover:underline underline-offset-4">Lihat Detail →</span>
                </div>
            </a>
            @endif
            {{-- Rest 2x2 + 1 --}}
            <div class="lg:col-span-2 grid sm:grid-cols-2 gap-4">
                @foreach($rest as $lomba)
                <a href="{{ route('lomba.show', $lomba->slug) }}" class="group flex flex-col overflow-hidden rounded-xl border bg-card shadow-sm hover:border-primary/20 hover:border-primary/20 transition-all">
                    <div class="h-28 bg-primary-50 relative overflow-hidden flex items-center justify-center">
                        @if($lomba->cover_url)
                            <img src="{{ $lomba->cover_url }}" alt="{{ $lomba->name }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                        @else
                            <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3"/></svg>
                        @endif
                        <span class="absolute top-2 right-2 rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $lomba->status === 'OPEN' ? 'bg-green-500 text-white' : 'bg-muted text-muted-foreground' }}">{{ $lomba->status === 'OPEN' ? 'Buka' : 'Tutup' }}</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <span class="inline-flex w-fit rounded-md bg-secondary px-2 py-0.5 text-[10px] font-medium text-secondary-foreground">{{ $lomba->category }}</span>
                        <h3 class="font-medium text-sm leading-tight mt-2 group-hover:text-primary transition-colors line-clamp-1">{{ $lomba->name }}</h3>
                        <p class="text-xs text-muted-foreground line-clamp-2 mt-1 flex-1">{{ $lomba->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        <div class="sm:hidden mt-4">
            <a href="{{ route('lomba.index') }}" class="inline-flex w-full justify-center h-10 items-center rounded-md border bg-background text-sm font-medium">Lihat Semua Lomba</a>
        </div>
    </div>
</section>
@endif

<div class="max-w-6xl mx-auto px-4 sm:px-6"><div class="h-px bg-border"></div></div>

{{-- HADIAH — podium contained --}}
@php
    $featured = $competitions->firstWhere('slug', 'olimpiade-ipas') ?? $competitions->first();
    $formatPrizeParts = fn($raw) => $raw ? array_filter(array_map('trim', explode('+', $raw))) : [];
    $prizes = [2 => $formatPrizeParts($featured->prize_2 ?? null), 1 => $formatPrizeParts($featured->prize_1 ?? null), 3 => $formatPrizeParts($featured->prize_3 ?? null)];
    $isPrizeRp = fn($part) => str_starts_with(trim($part), 'Rp');
@endphp
@if($featured && ($featured->prize_1 || $featured->prize_2 || $featured->prize_3))
<section class="py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="rounded-xl border bg-card shadow-sm p-6 sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold tracking-tight">Hadiah Pemenang</h2>
                    <p class="text-sm text-muted-foreground mt-1">{{ $featured->name }} — podium hadiah.</p>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 text-amber-700 px-3 py-1 text-xs font-semibold">Total Jutaan Rupiah</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end max-w-4xl mx-auto">
                @foreach([2,1,3] as $place)
                    @php
                        $parts = $prizes[$place] ?? [];
                        if (empty($parts)) continue;
                        $cfg = [
                            1=>['order'=>'order-1 sm:order-2','bg'=>'bg-gradient-to-b from-amber-50 to-white','border'=>'border-amber-200','iconBg'=>'bg-amber-500','money'=>'text-amber-700','label'=>'JUARA 1','icon'=>'<path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/>'],
                            2=>['order'=>'order-2 sm:order-1','bg'=>'bg-card','border'=>'border-slate-200','iconBg'=>'bg-slate-400','money'=>'text-slate-700','label'=>'JUARA 2','icon'=>'<path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6.084 10H4.5A2.5 2.5 0 0 1 2 7.5V5a1 1 0 0 1 1-1h3"/><path d="M17.916 10H19.5A2.5 2.5 0 0 0 22 7.5V5a1 1 0 0 0-1-1h-3"/><path d="M4 22h16"/><path d="M10 14.66V17a1 1 0 0 1-1 1 2 2 0 0 0-2 2v2"/><path d="M14 14.66V17a1 1 0 0 0 1 1 2 2 0 0 1 2 2v2"/>'],
                            3=>['order'=>'order-3','bg'=>'bg-card','border'=>'border-orange-200','iconBg'=>'bg-orange-500','money'=>'text-orange-700','label'=>'JUARA 3','icon'=>'<path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/>'],
                        ][$place];
                    @endphp
                    <div class="order-{{ $place === 1 ? '1 sm:order-2' : ($place === 2 ? '2 sm:order-1' : '3') }} {{ $cfg['bg'] }} rounded-xl border {{ $cfg['border'] }} p-5 text-center {{ $place===1 ? 'sm:-translate-y-2 shadow-md' : 'shadow-sm' }}">
                        {{-- Lucide (ISC, lucide.dev): crown / trophy / award --}}
                        <div class="w-12 h-12 {{ $cfg['iconBg'] }} rounded-xl flex items-center justify-center mx-auto mb-3 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                {!! $cfg['icon'] !!}
                            </svg>
                        </div>
                        <div class="text-[11px] font-bold tracking-widest text-muted-foreground mb-2">{{ $cfg['label'] }}</div>
                        <div class="space-y-1.5">
                            @foreach($parts as $part)
                                @if($isPrizeRp($part))
                                    <div class="text-lg font-bold {{ $cfg['money'] }}">{{ $part }}</div>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-secondary px-2.5 py-1 text-xs font-medium text-secondary-foreground">{{ $part }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            @if($featured->prize_extra)
                <p class="text-center mt-6"><span class="inline-flex items-center rounded-full bg-primary text-primary-foreground px-3 py-1 text-xs font-medium">🎁 Bonus: {{ $featured->prize_extra }}</span></p>
            @endif
        </div>
    </div>
</section>
@endif

<div class="max-w-6xl mx-auto px-4 sm:px-6"><div class="h-px bg-border"></div></div>

{{-- JADWAL + KEGIATAN — 2 kolom shadcn --}}
<section class="py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-6">
        {{-- Jadwal --}}
        <div class="rounded-xl border bg-card shadow-sm">
            <div class="p-5 border-b">
                <h2 class="font-semibold tracking-tight">Jadwal Penting</h2>
                <p class="text-sm text-muted-foreground">Linimasa AKASHI 2026</p>
            </div>
            <div class="p-5">
                @if($schedules->count())
                <div class="relative pl-6 border-l">
                    @foreach($schedules as $jadwal)
                    <div class="relative pb-6 last:pb-0">
                        <span class="absolute -left-[25px] top-1 w-3 h-3 rounded-full bg-primary ring-4 ring-background"></span>
                        <div class="text-xs font-medium text-primary">{{ $jadwal->date->translatedFormat('d F Y') }}</div>
                        <div class="font-medium text-sm mt-0.5">{{ $jadwal->title }}</div>
                        @if($jadwal->note)<div class="text-sm text-muted-foreground mt-1">{{ $jadwal->note }}</div>@endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-muted-foreground">Belum ada jadwal.</p>
                @endif
            </div>
        </div>

        {{-- Kegiatan --}}
        <div class="rounded-xl border bg-card shadow-sm">
            <div class="p-5 border-b flex items-center justify-between">
                <div>
                    <h2 class="font-semibold tracking-tight">Kegiatan Seru</h2>
                    <p class="text-sm text-muted-foreground">Selain lomba, ada ini!</p>
                </div>
            </div>
            <div class="p-5 grid gap-3">
                @php
                    $activityIcons = [
                        'Gelar Karya' => ['bg' => 'bg-violet-100', 'color' => 'text-violet-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>', 'src' => 'lucide:palette'],
                        'Talkshow' => ['bg' => 'bg-cyan-100', 'color' => 'text-cyan-600', 'icon' => '<path d="M12 5v16"/><path d="M20.001 19A2 2 0 0022 17V5a2 2 0 00-1.999-2L16 3.002A5 5 0 0012 5a5 5 0 00-4-2H4a2 2 0 00-2 2v12a2 2 0 001.999 2H8a5 5 0 014 2 5 5 0 014-2z"/>', 'src' => 'lucide:book-open'],
                        'Bazar' => ['bg' => 'bg-amber-100', 'color' => 'text-amber-600', 'icon' => '<path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5"/><path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244"/><path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05"/>', 'src' => 'lucide:store'],
                        'Dolanan' => ['bg' => 'bg-emerald-100', 'color' => 'text-emerald-600', 'icon' => '<rect width="12" height="12" x="2" y="10" rx="2" ry="2"/><path d="m17.92 14 3.5-3.5a2.24 2.24 0 0 0 0-3l-5-4.92a2.24 2.24 0 0 0-3 0L10 6"/><path d="M6 18h.01"/><path d="M10 14h.01"/><path d="M15 6h.01"/><path d="M18 9h.01"/>', 'src' => 'lucide:dices'],
                        'Membatik' => ['bg' => 'bg-orange-100', 'color' => 'text-orange-600', 'icon' => '<path d="m11 10 3 3"/><path d="M6.5 21A3.5 3.5 0 1 0 3 17.5a2.62 2.62 0 0 1-.708 1.792A1 1 0 0 0 3 21z"/><path d="M9.969 17.031 21.378 5.624a1 1 0 0 0-3.002-3.002L6.967 14.031"/>', 'src' => 'lucide:brush'],
                    ];
                    $getActivityStyle = function($name) use ($activityIcons) {
                        foreach ($activityIcons as $key => $style) {
                            if (str_contains($name, $key)) return $style;
                        }
                        return ['bg' => 'bg-primary-100', 'color' => 'text-primary-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>'];
                    };
                @endphp
                @forelse($activities as $kegiatan)
                @php $style = $getActivityStyle($kegiatan->name); @endphp
                <div class="flex gap-3 rounded-lg border p-3 hover:bg-muted/50 transition-colors group">
                    <div class="w-11 h-11 rounded-xl {{ $style['bg'] }} flex-shrink-0 flex items-center justify-center overflow-hidden">
                        @if($kegiatan->image_url)
                            <img src="{{ $kegiatan->image_url }}" alt="{{ $kegiatan->name }}" class="w-full h-full object-cover">
                        @else
                            {{-- Lucide icons (ISC, lucide.dev) --}}
                            <svg class="w-[22px] h-[22px] {{ $style['color'] }}" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                {!! $style['icon'] !!}
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="font-medium text-sm leading-tight truncate group-hover:text-primary transition-colors">{{ $kegiatan->name }}</div>
                        @if($kegiatan->description)<div class="text-xs text-muted-foreground line-clamp-2 mt-0.5">{{ $kegiatan->description }}</div>@endif
                        <div class="text-xs text-muted-foreground mt-1 flex items-center gap-2">
                            @if($kegiatan->date)<span>{{ $kegiatan->date->translatedFormat('d M Y') }}</span>@endif
                            @if($kegiatan->location)<span>· {{ $kegiatan->location }}</span>@endif
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-muted-foreground">Belum ada kegiatan.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 sm:px-6"><div class="h-px bg-border"></div></div>

{{-- FAQ — shadcn Accordion (single open) --}}
@if($faqs->count())
<section class="py-10 sm:py-14">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold tracking-tight">FAQ</h2>
            <p class="text-sm text-muted-foreground mt-1">Pertanyaan yang sering ditanyakan</p>
        </div>
        <div class="rounded-xl border bg-card divide-y">
            @foreach($faqs as $i => $faq)
            <div class="faq-item">
                <button onclick="toggleFaq({{ $i }})" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left hover:bg-muted/50 transition-colors">
                    <span class="font-medium text-sm pr-2">{{ $faq->question }}</span>
                    <svg id="faq-icon-{{ $i }}" class="w-4 h-4 text-muted-foreground shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div id="faq-content-{{ $i }}" class="hidden px-5 pb-4 text-sm text-muted-foreground leading-relaxed">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA — contained card --}}
<section class="pb-10 sm:pb-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="rounded-xl border bg-primary text-primary-foreground p-7 sm:p-10 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            </div>
            <div class="relative">
                <h2 class="text-2xl font-semibold tracking-tight">Siap Tampil?</h2>
                <p class="text-sm text-primary-foreground/80 mt-2 max-w-md mx-auto">Daftarkan dirimu sekarang dan jadilah bagian dari AKASHI 2026!</p>
                <a href="{{ route('daftar.index') }}" class="mt-6 inline-flex h-10 items-center justify-center rounded-md bg-white px-6 text-sm font-medium text-primary shadow hover:bg-white/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-white transition-colors">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

@else

{{-- FINISHED STATE --}}
@if(isset($announcements) && $announcements->count())
<section class="py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-semibold tracking-tight">Para Juara</h2>
            <p class="text-sm text-muted-foreground mt-1">Selamat kepada seluruh pemenang!</p>
        </div>
        @foreach($announcements as $pengumuman)
        <div class="rounded-xl border bg-card shadow-sm p-6 mb-6">
            <h3 class="font-medium">{{ $pengumuman->title }}</h3>
            @if($pengumuman->competition)<div class="text-sm text-muted-foreground">{{ $pengumuman->competition->name }}</div>@endif
            @if($pengumuman->winners->count())
            <div class="grid sm:grid-cols-3 gap-4 mt-6 max-w-3xl mx-auto items-end">
                @php $s=$pengumuman->winners->where('place',2)->first(); $g=$pengumuman->winners->where('place',1)->first(); $b=$pengumuman->winners->where('place',3)->first(); @endphp
                @if($s)<div class="rounded-xl border bg-card p-5 text-center order-2 sm:order-1 shadow-sm"><div class="w-10 h-10 bg-slate-400 rounded-xl flex items-center justify-center mx-auto text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6.084 10H4.5A2.5 2.5 0 0 1 2 7.5V5a1 1 0 0 1 1-1h3"/><path d="M17.916 10H19.5A2.5 2.5 0 0 0 22 7.5V5a1 1 0 0 0-1-1h-3"/><path d="M4 22h16"/><path d="M10 14.66V17a1 1 0 0 1-1 1 2 2 0 0 0-2 2v2"/><path d="M14 14.66V17a1 1 0 0 0 1 1 2 2 0 0 1 2 2v2"/></svg></div><div class="font-medium text-sm mt-2">{{ $s->participant_name }}</div><div class="text-xs text-muted-foreground">{{ $s->school }}</div></div>@endif
                @if($g)<div class="rounded-xl border-2 border-amber-200 bg-amber-50 p-5 text-center order-1 sm:order-2 sm:-translate-y-2 shadow-md"><div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center mx-auto text-white shadow-sm"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg></div><div class="font-medium text-sm mt-2">{{ $g->participant_name }}</div><div class="text-xs text-muted-foreground">{{ $g->school }}</div></div>@endif
                @if($b)<div class="rounded-xl border bg-card p-5 text-center order-3 shadow-sm"><div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center mx-auto text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/></svg></div><div class="font-medium text-sm mt-2">{{ $b->participant_name }}</div><div class="text-xs text-muted-foreground">{{ $b->school }}</div></div>@endif
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif

@endif

@endsection

@push('scripts')
@if(!$finished && ($settings['event_date'] ?? null))
<script>
(function(){
    const target=new Date('{{ $settings["event_date"] }}T23:59:59').getTime();
    function upd(){
        const d=target-Date.now();
        if(d<=0){['cd-days','cd-hours','cd-minutes','cd-seconds'].forEach(id=>document.getElementById(id).textContent='00');return;}
        document.getElementById('cd-days').textContent=String(Math.floor(d/86400000)).padStart(2,'0');
        document.getElementById('cd-hours').textContent=String(Math.floor(d%86400000/3600000)).padStart(2,'0');
        document.getElementById('cd-minutes').textContent=String(Math.floor(d%3600000/60000)).padStart(2,'0');
        document.getElementById('cd-seconds').textContent=String(Math.floor(d%60000/1000)).padStart(2,'0');
    }
    upd(); setInterval(upd,1000);
})();
</script>
@endif
<script>
function toggleFaq(i){
    const c=document.getElementById('faq-content-'+i), ic=document.getElementById('faq-icon-'+i);
    const isHidden=c.classList.contains('hidden');
    document.querySelectorAll('[id^="faq-content-"]').forEach(el=>el.classList.add('hidden'));
    document.querySelectorAll('[id^="faq-icon-"]').forEach(el=>el.style.transform='');
    if(isHidden){ c.classList.remove('hidden'); ic.style.transform='rotate(180deg)'; }
}
</script>
@endpush
