@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

{{-- HERO — contained 2-kolom, tidak full-bleed --}}
<section class="py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="rounded-[2rem] bg-gradient-to-br from-primary-950 via-primary-900 to-violet-800 text-white overflow-hidden relative">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-20 -right-20 w-80 h-80 bg-accent-400 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-fuchsia-400 rounded-full blur-3xl"></div>
            </div>
            <div class="relative grid lg:grid-cols-[1.15fr_0.85fr] gap-8 p-7 sm:p-10 lg:p-12 items-center">
                {{-- Copy --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-xs font-medium text-accent-200 mb-5">
                        <span class="w-2 h-2 bg-accent-400 rounded-full animate-pulse"></span>
                        @if($finished) AKASHI 2026 · Telah Selesai @else AKASHI 2026 · Edisi Perdana @endif
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold tracking-tight leading-[1.1]">
                        Ajang Kreasi<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-300 to-cyan-200">Ashidiq 2026</span>
                    </h1>
                    <p class="text-sm sm:text-[15px] text-violet-200 mt-4 leading-relaxed max-w-[46ch]">
                        {{ $settings['site_description'] ?? 'Kompetisi dan festival untuk siswa SMP Muhammadiyah Unggulan Ashidiq. Tunjukkan bakatmu, raih prestasimu!' }}
                    </p>
                    <div class="flex flex-wrap items-center gap-2 mt-5 text-xs">
                        @if($settings['event_date'] ?? null)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/10 text-violet-100">
                            <svg class="w-3.5 h-3.5 text-accent-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            {{ \Carbon\Carbon::parse($settings['event_date'])->translatedFormat('d F Y') }}
                        </span>
                        @endif
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/10 text-violet-100">
                            <svg class="w-3.5 h-3.5 text-accent-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            SMP Muhammadiyah Unggulan Ashidiq
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-3 mt-7">
                        @if($finished)
                            <a href="{{ route('juara.index') }}" class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-md bg-white text-primary-900 text-sm font-medium shadow hover:bg-white/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-white transition-colors">
                                Lihat Para Juara
                            </a>
                            <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-md border border-white/20 bg-white/10 text-white text-sm font-medium hover:bg-white/15 backdrop-blur transition-colors">Pengumuman</a>
                        @else
                            <a href="{{ route('daftar.index') }}" class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-md bg-white text-primary-900 text-sm font-medium shadow hover:bg-white/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-white transition-colors">
                                Daftar Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L6 6m0 0l6 6m-6-6v12a2.25 2.25 0 002.25 2.25h9A2.25 2.25 0 0019.5 18V6"/></svg>
                            </a>
                            <a href="{{ route('lomba.index') }}" class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-md border border-white/20 bg-white/10 text-white text-sm font-medium hover:bg-white/15 backdrop-blur transition-colors">Jelajahi Lomba</a>
                        @endif
                    </div>
                </div>

                {{-- Visual / Countdown card --}}
                <div class="lg:pl-2">
                    @if(!$finished && ($settings['event_date'] ?? null))
                    <div class="rounded-2xl bg-white text-foreground border shadow-xl p-6">
                        <div class="text-xs font-semibold tracking-widest text-muted-foreground uppercase mb-4">Hitung Mundur</div>
                        <div id="countdown" class="grid grid-cols-4 gap-3">
                            <div class="rounded-xl bg-primary text-primary-foreground p-3 text-center">
                                <div id="cd-days" class="text-2xl font-bold leading-none">00</div>
                                <div class="text-[10px] tracking-widest opacity-80 mt-1">HARI</div>
                            </div>
                            <div class="rounded-xl bg-primary text-primary-foreground p-3 text-center">
                                <div id="cd-hours" class="text-2xl font-bold leading-none">00</div>
                                <div class="text-[10px] tracking-widest opacity-80 mt-1">JAM</div>
                            </div>
                            <div class="rounded-xl bg-primary text-primary-foreground p-3 text-center">
                                <div id="cd-minutes" class="text-2xl font-bold leading-none">00</div>
                                <div class="text-[10px] tracking-widest opacity-80 mt-1">MENIT</div>
                            </div>
                            <div class="rounded-xl bg-primary text-primary-foreground p-3 text-center">
                                <div id="cd-seconds" class="text-2xl font-bold leading-none">00</div>
                                <div class="text-[10px] tracking-widest opacity-80 mt-1">DETIK</div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-xs text-muted-foreground">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            Pendaftaran masih dibuka
                            <a href="{{ route('daftar.index') }}" class="ml-auto text-primary font-medium hover:underline">Daftar →</a>
                        </div>
                    </div>
                    @else
                    <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur p-6">
                        <div class="w-12 h-12 rounded-xl bg-white text-primary-900 flex items-center justify-center font-extrabold">A</div>
                        <h3 class="text-white font-semibold mt-4">AKASHI 2026</h3>
                        <p class="text-sm text-violet-200 mt-1">Festival kreasi, kompetisi, dan gelar karya. Lihat para juara atau pengumuman terbaru.</p>
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('juara.index') }}" class="h-9 px-4 rounded-md bg-white text-primary-900 text-sm font-medium inline-flex items-center">Juara</a>
                            <a href="{{ route('pengumuman.index') }}" class="h-9 px-4 rounded-md border border-white/20 text-white text-sm font-medium inline-flex items-center">Pengumuman</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if(!$finished)

{{-- KENAPA IKUT — 4 cards, contained --}}
<section class="py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold tracking-tight">Kenapa Ikut AKASHI?</h2>
                <p class="text-sm text-muted-foreground mt-1">Empat alasan untuk tampil dan bersinar.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php $features = [
                ['Berani Mencoba','Langkah pertama menuju prestasi.','M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z','bg-violet-100 text-violet-700'],
                ['Berkarya','Wadah berekspresi tanpa batas.','M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z','bg-cyan-100 text-cyan-700'],
                ['Bersaing','Uji kemampuan secara sportif.','M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871','bg-violet-100 text-violet-700'],
                ['Bersinar','Bersinar di panggung prestasi.','M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z','bg-cyan-100 text-cyan-700'],
            ]; @endphp
            @foreach($features as [$title,$desc,$d,$badge])
            <div class="rounded-xl border bg-card text-card-foreground shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="w-9 h-9 rounded-lg {{ $badge }} flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}"/></svg>
                </div>
                <h3 class="font-medium text-sm">{{ $title }}</h3>
                <p class="text-sm text-muted-foreground leading-relaxed mt-1">{{ $desc }}</p>
            </div>
            @endforeach
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
            <a href="{{ route('lomba.show', $featuredLomba->slug) }}" class="group lg:row-span-2 flex flex-col overflow-hidden rounded-xl border bg-card shadow-sm hover:shadow-md hover:border-primary/20 transition-all">
                <div class="h-44 lg:h-[220px] bg-gradient-to-br from-primary-900 to-violet-700 relative overflow-hidden flex items-center justify-center">
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
                <a href="{{ route('lomba.show', $lomba->slug) }}" class="group flex flex-col overflow-hidden rounded-xl border bg-card shadow-sm hover:shadow-md hover:border-primary/20 transition-all">
                    <div class="h-28 bg-gradient-to-br from-primary-900/90 to-violet-700/90 relative overflow-hidden flex items-center justify-center">
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
        <div class="rounded-2xl border bg-card shadow-sm p-6 sm:p-8">
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
                        'Gelar Karya' => ['bg' => 'bg-violet-100', 'color' => 'text-violet-600', 'icon' => '<path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z"/><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>', 'src' => 'lucide:palette'],
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
        <div class="rounded-2xl border bg-primary text-primary-foreground p-7 sm:p-10 text-center relative overflow-hidden">
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
