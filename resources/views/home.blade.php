@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- HERO — Editorial Scrapbook Composition --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-navy">
    {{-- Paper noise texture overlay --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.04]" aria-hidden="true">
        <img src="{{ asset('asset/textures/paper-noise.svg') }}" alt="" class="w-full h-full object-cover" style="mix-blend-mode: overlay;">
    </div>

    {{-- Grid paper pattern --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.03]" aria-hidden="true">
        <img src="{{ asset('asset/textures/grid-paper.svg') }}" alt="" class="w-full h-full object-cover" style="background-repeat: repeat;">
    </div>

    {{-- Scattered doodles in background --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <img src="{{ asset('asset/doodles/star.svg') }}" alt="" class="absolute top-[10%] right-[6%] w-14 h-14 opacity-20 rotate-12 anim-wiggle">
        <img src="{{ asset('asset/doodles/circle.svg') }}" alt="" class="absolute bottom-[18%] left-[4%] w-12 h-12 opacity-15 -rotate-6">
        <img src="{{ asset('asset/doodles/arrow.svg') }}" alt="" class="absolute top-[40%] left-[2%] w-24 h-10 opacity-10" style="transform: rotate(-10deg);">
        <img src="{{ asset('asset/doodles/scribble.svg') }}" alt="" class="absolute bottom-[10%] right-[8%] w-40 h-12 opacity-10 rotate-3">
        <img src="{{ asset('asset/doodles/crown.svg') }}" alt="" class="absolute top-[15%] left-[15%] w-16 h-12 opacity-10 -rotate-6">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="grid lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            {{-- LEFT: Paper sheet with headline --}}
            <div class="lg:col-span-7 relative anim-fade-left">
                {{-- Tape pieces — real SVG --}}
                <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-4 left-4 sm:left-10 w-24 h-7 z-10 opacity-80" style="transform: rotate(-2deg);" aria-hidden="true">
                <img src="{{ asset('asset/ui/tape-paper.svg') }}" alt="" class="absolute -top-3 right-12 sm:right-20 w-20 h-6 z-10 opacity-70" style="transform: rotate(3deg);" aria-hidden="true">

                {{-- Main paper sheet --}}
                <div class="paper-sheet p-6 sm:p-8 lg:p-10 relative" style="transform: rotate(-0.5deg);">
                    {{-- Registration stamp — real SVG --}}
                    <div class="absolute top-2 right-2 sm:top-3 sm:right-3 w-28 sm:w-32 hidden sm:block anim-stamp delay-3">
                        <img src="{{ asset('asset/ui/stamp-open.svg') }}" alt="Pendaftaran Dibuka" class="w-full h-auto">
                    </div>

                    {{-- Eyebrow --}}
                    <div class="flex items-center gap-2 mb-4">
                        <span class="inline-block w-2 h-2 bg-orange rounded-full anim-wiggle"></span>
                        <span class="text-[11px] font-bold tracking-[0.2em] uppercase text-navy/50">Kompetisi Pelajar 2026</span>
                    </div>

                    {{-- Main headline — using real logo as brand reference --}}
                    <h1 class="font-marker leading-[0.9] text-navy">
                        <span class="block text-[42px] sm:text-[56px] lg:text-[72px] text-navy">Ajang Kreasi</span>
                        <span class="block text-[42px] sm:text-[56px] lg:text-[72px] text-orange" style="transform: rotate(-0.5deg);">Ashidiq 2026</span>
                    </h1>

                    {{-- Subheadline with brush stroke underline --}}
                    <div class="mt-4 relative inline-block">
                        <p class="text-lg sm:text-xl font-bold text-navy/80" style="font-family: 'Caveat', cursive; font-size: 1.4em;">
                            Tunjukkan Bakatmu, Raih Prestasimu!
                        </p>
                        <img src="{{ asset('asset/ui/brush-purple.svg') }}" alt="" class="absolute -bottom-2 left-0 w-full h-4 opacity-20" aria-hidden="true">
                    </div>

                    {{-- Description --}}
                    <p class="mt-4 text-sm leading-relaxed text-navy/60 max-w-[50ch]">
                        Kompetisi dan festival untuk siswa SMP Muhammadiyah Unggulan Ashidiq. Saatnya generasi muda unjuk kreativitas, kompetensi dan sportivitas menuju masa depan yang lebih baik.
                    </p>

                    {{-- Event meta --}}
                    <div class="mt-5 flex flex-wrap items-center gap-3 text-sm">
                        <span class="inline-flex items-center gap-2 border-2 border-navy/15 bg-yellow-light px-3 py-1.5 text-xs font-bold text-navy/70" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                            <svg class="w-3.5 h-3.5 text-orange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            16 September 2026
                        </span>
                        <span class="inline-flex items-center gap-2 border-2 border-navy/15 bg-yellow-light px-3 py-1.5 text-xs font-bold text-navy/70" style="border-radius: 15px 225px 15px 255px / 225px 15px 255px 15px;">
                            <svg class="w-3.5 h-3.5 text-orange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            SMP Muhammadiyah Unggulan Ashidiq
                        </span>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="mt-7 flex flex-wrap gap-3">
                        @if($finished)
                            <a href="{{ route('juara.index') }}" class="cta-button cta-button-white text-sm">
                                Lihat Para Juara
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L6 6m0 0l6 6m-6-6v12"/></svg>
                            </a>
                            <a href="{{ route('juknis.show') }}" class="inline-flex h-12 items-center justify-center gap-2 border-2 border-navy bg-navy text-white px-5 text-sm font-bold hover:bg-navy-light transition-colors" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                Lihat Juknis
                            </a>
                        @else
                            <a href="{{ route('daftar.index') }}" class="cta-button text-sm">
                                Daftar Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.964-3.072c.087.55.149 1.115.149 1.706v.474a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25v-.474c0-.59.062-1.155.149-1.706A6.375 6.375 0 014 19.235z"/></svg>
                            </a>
                            <a href="{{ route('juknis.show') }}" class="inline-flex h-12 items-center justify-center gap-2 border-2 border-white bg-white text-primary-900 px-5 text-sm font-bold hover:bg-white/90 transition-colors" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                Lihat Juknis
                            </a>
                        @endif
                    </div>

                    {{-- Small decorative label --}}
                    <div class="mt-5 flex items-center gap-2">
                        <div class="w-8 h-px bg-navy/15"></div>
                        <span class="text-[10px] font-bold tracking-[0.15em] uppercase text-navy/30">SMP Muhammadiyah Unggulan Ashidiq</span>
                        <div class="w-8 h-px bg-navy/15"></div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Championship Poster + Countdown --}}
            <div class="lg:col-span-5 space-y-5 anim-fade-right delay-2">

                {{-- Championship Poster — taped to the page --}}
                <div class="relative">
                    {{-- Tape pieces — real SVG --}}
                    <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-3 left-4 w-20 h-6 z-10 opacity-80" style="transform: rotate(2deg);" aria-hidden="true">
                    <img src="{{ asset('asset/ui/tape-paper.svg') }}" alt="" class="absolute -top-3 right-6 w-16 h-5 z-10 opacity-70" style="transform: rotate(-3deg);" aria-hidden="true">

                    <div class="paper-sheet-lined p-6 text-center relative" style="transform: rotate(0.75deg);">
                        {{-- Trophy illustration — real SVG --}}
                        <div class="relative inline-block mb-4">
                            <img src="{{ asset('asset/illustrations/trophy.svg') }}" alt="Trophy" class="w-20 h-24 sm:w-24 sm:h-28 mx-auto">
                            {{-- Decorative stars --}}
                            <img src="{{ asset('asset/doodles/star.svg') }}" alt="" class="absolute -top-3 -left-3 w-6 h-6 rotate-[15deg]" aria-hidden="true">
                            <img src="{{ asset('asset/doodles/star.svg') }}" alt="" class="absolute -bottom-1 -right-4 w-5 h-5 opacity-60 -rotate-[10deg]" aria-hidden="true">
                        </div>

                        <h3 class="font-marker text-2xl sm:text-3xl text-navy tracking-wide">CHAMPIONSHIP</h3>
                        <p class="text-[11px] font-bold tracking-[0.2em] uppercase text-navy/50 mt-1">AKASHI 2026</p>

                        <div class="mt-3 inline-flex items-center gap-1.5 bg-yellow-light border-2 border-navy/10 px-3 py-1 text-[11px] font-bold text-navy/70" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                            Prestasi · Sportivitas · Kreativitas
                        </div>

                        {{-- Doodle underline — real SVG --}}
                        <img src="{{ asset('asset/doodles/scribble.svg') }}" alt="" class="absolute bottom-2 left-1/2 -translate-x-1/2 w-36 h-6 opacity-25" aria-hidden="true">
                    </div>
                </div>

                {{-- Countdown — notebook strip --}}
                @if(!$finished && ($settings['event_date'] ?? null))
                <div class="relative">
                    {{-- Tape — real SVG --}}
                    <img src="{{ asset('asset/ui/tape-paper.svg') }}" alt="" class="absolute -top-3 left-1/2 -translate-x-1/2 w-16 h-5 z-10 opacity-70" style="transform: translateX(-50%) rotate(-1deg);" aria-hidden="true">

                    <div class="paper-sheet-grid p-5" style="transform: rotate(-0.5deg);">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <span class="font-marker text-lg text-navy tracking-wide">Hitung Mundur</span>
                            <span class="inline-flex items-center gap-1.5 bg-green-light border-2 border-green/30 px-2.5 py-1 text-[10px] font-bold text-navy/70 uppercase tracking-wide" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                                <span class="w-1.5 h-1.5 bg-green rounded-full"></span>
                                Pendaftaran Dibuka
                            </span>
                        </div>

                        <div id="countdown" class="grid grid-cols-4 gap-2">
                            <div class="text-center p-2 border-2 border-navy/10 bg-white" style="border-radius: 4px;">
                                <div id="cd-days" class="font-marker text-2xl sm:text-3xl leading-none text-navy">00</div>
                                <div class="text-[9px] font-bold tracking-[0.15em] uppercase text-navy/40 mt-1">Hari</div>
                            </div>
                            <div class="text-center p-2 border-2 border-navy/10 bg-white" style="border-radius: 4px;">
                                <div id="cd-hours" class="font-marker text-2xl sm:text-3xl leading-none text-navy">00</div>
                                <div class="text-[9px] font-bold tracking-[0.15em] uppercase text-navy/40 mt-1">Jam</div>
                            </div>
                            <div class="text-center p-2 border-2 border-navy/10 bg-white" style="border-radius: 4px;">
                                <div id="cd-minutes" class="font-marker text-2xl sm:text-3xl leading-none text-navy">00</div>
                                <div class="text-[9px] font-bold tracking-[0.15em] uppercase text-navy/40 mt-1">Menit</div>
                            </div>
                            <div class="text-center p-2 border-2 border-navy/10 bg-white" style="border-radius: 4px;">
                                <div id="cd-seconds" class="font-marker text-2xl sm:text-3xl leading-none text-navy">00</div>
                                <div class="text-[9px] font-bold tracking-[0.15em] uppercase text-navy/40 mt-1">Detik</div>
                            </div>
                        </div>

                        <div class="mt-3 text-center text-[11px] font-bold text-navy/40 tracking-wide">16 September – 30 September 2026</div>

                        {{-- Arrow doodle — real SVG --}}
                        <img src="{{ asset('asset/doodles/arrow.svg') }}" alt="" class="absolute -bottom-5 right-3 w-10 h-6 opacity-25 rotate-[30deg]" aria-hidden="true">
                    </div>
                </div>
                @else
                <div class="paper-sheet p-5 flex items-center justify-between" style="transform: rotate(0.3deg);">
                    <div>
                        <div class="font-marker text-lg text-navy">Pendaftaran Dibuka</div>
                        <div class="text-xs font-semibold text-navy/50 mt-0.5">16 September – 30 September 2026</div>
                    </div>
                    <a href="{{ route('daftar.index') }}" class="cta-button text-xs py-2 px-4">Daftar →</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Bottom torn edge --}}
    <div class="h-4 bg-paper relative" style="clip-path: polygon(0 100%, 100% 100%, 100% 0%, 98% 50%, 96% 10%, 94% 60%, 92% 20%, 90% 70%, 88% 30%, 86% 80%, 84% 15%, 82% 65%, 80% 25%, 78% 75%, 76% 10%, 74% 60%, 72% 30%, 70% 80%, 68% 15%, 66% 65%, 64% 25%, 62% 75%, 60% 10%, 58% 60%, 56% 30%, 54% 80%, 52% 15%, 50% 65%, 48% 25%, 46% 75%, 44% 10%, 42% 60%, 40% 30%, 38% 80%, 36% 15%, 34% 65%, 32% 25%, 30% 75%, 28% 10%, 26% 60%, 24% 30%, 22% 80%, 20% 15%, 18% 65%, 16% 25%, 14% 75%, 12% 10%, 10% 60%, 8% 30%, 6% 80%, 4% 15%, 2% 65%, 0% 0%);"></div>
</section>


{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- STATS STRIP — Editorial Information Band --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="bg-editorial-navy relative overflow-hidden">
    {{-- Dot pattern texture --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.06]" aria-hidden="true">
        <img src="{{ asset('asset/textures/dots.svg') }}" alt="" class="w-full h-full object-cover">
    </div>

    <div class="relative max-w-7xl mx-auto">
        <div class="stats-strip text-white">
            <div class="relative anim-fade-up delay-1">
                <div class="mb-2">
                    <img src="{{ asset('asset/illustrations/participants.svg') }}" alt="" class="w-12 h-10 mx-auto" aria-hidden="true">
                </div>
                <div class="font-marker text-2xl sm:text-3xl">1000+</div>
                <div class="text-[10px] sm:text-[11px] font-bold tracking-[0.1em] uppercase text-white/50 mt-1">Peserta Siap Berkompetisi</div>
            </div>

            <div class="relative anim-fade-up delay-2">
                <div class="mb-2">
                    <img src="{{ asset('asset/illustrations/trophy.svg') }}" alt="" class="w-10 h-12 mx-auto" aria-hidden="true">
                </div>
                <div class="font-marker text-2xl sm:text-3xl">20+</div>
                <div class="text-[10px] sm:text-[11px] font-bold tracking-[0.1em] uppercase text-white/50 mt-1">Cabang Lomba Menantang</div>
            </div>

            <div class="relative anim-fade-up delay-3">
                <div class="mb-2">
                    <img src="{{ asset('asset/illustrations/gift.svg') }}" alt="" class="w-10 h-10 mx-auto" aria-hidden="true">
                </div>
                <div class="font-marker text-2xl sm:text-3xl">Hadiah</div>
                <div class="text-[10px] sm:text-[11px] font-bold tracking-[0.1em] uppercase text-white/50 mt-1">Menarik Untuk Juara</div>
            </div>

            <div class="relative anim-fade-up delay-4">
                <div class="mb-2">
                    <img src="{{ asset('asset/illustrations/shield.svg') }}" alt="" class="w-10 h-12 mx-auto" aria-hidden="true">
                </div>
                <div class="font-marker text-2xl sm:text-3xl">Fair Play</div>
                <div class="text-[10px] sm:text-[11px] font-bold tracking-[0.1em] uppercase text-white/50 mt-1">Sportivitas Terjaga</div>
            </div>
        </div>
    </div>
</section>


@if(!$finished)

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- KENAPA IKUT — Scattered Cards --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-18 bg-paper relative">
    {{-- Paper noise texture --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.03]" aria-hidden="true">
        <img src="{{ asset('asset/textures/paper-noise.svg') }}" alt="" class="w-full h-full object-cover" style="mix-blend-mode: multiply;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section header — editorial --}}
        <div class="max-w-2xl mb-10">
            <div class="sticker sticker-orange mb-3 inline-block anim-fade-up">
                <img src="{{ asset('asset/doodles/star.svg') }}" alt="" class="w-3 h-3 inline-block -mt-0.5" aria-hidden="true">
                Kenapa Ikut?
            </div>
            <h2 class="font-marker text-3xl sm:text-4xl text-navy leading-tight">Empat Alasan Untuk Tampil dan Bersinar</h2>
            <p class="mt-3 text-sm leading-relaxed text-navy/60 max-w-[50ch]">Jangan lewatkan kesempatan untuk mengembangkan potensi dan meraih prestasi terbaikmu!</p>
        </div>

        {{-- Cards — slightly scattered, different rotations --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="paper-sheet p-5 relative anim-fade-up delay-1" style="transform: rotate(-1deg);">
                <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-3 right-2 w-12 h-4 opacity-60 rotate-[3deg]" aria-hidden="true">
                <div class="w-11 h-11 bg-orange/10 border-2 border-orange/20 flex items-center justify-center mb-3" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                    <svg class="w-5 h-5 text-orange" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                </div>
                <h3 class="font-bold text-sm text-navy">Kembangkan Potensi</h3>
                <p class="mt-1.5 text-xs leading-relaxed text-navy/55">Asah bakat dan kreativitasmu dengan kompetisi yang menantang.</p>
                <img src="{{ asset('asset/doodles/scribble.svg') }}" alt="" class="absolute bottom-2 left-2 w-8 h-3 opacity-20" aria-hidden="true">
            </div>

            <div class="paper-sheet p-5 relative anim-fade-up delay-2" style="transform: rotate(0.5deg);">
                <img src="{{ asset('asset/ui/tape-paper.svg') }}" alt="" class="absolute -top-3 left-2 w-12 h-4 opacity-50 rotate-[-2deg]" aria-hidden="true">
                <div class="w-11 h-11 bg-yellow-light border-2 border-yellow/30 flex items-center justify-center mb-3" style="border-radius: 15px 225px 15px 255px / 225px 15px 255px 15px;">
                    <img src="{{ asset('asset/illustrations/medal.svg') }}" alt="" class="w-6 h-7" aria-hidden="true">
                </div>
                <h3 class="font-bold text-sm text-navy">Raih Prestasi</h3>
                <p class="mt-1.5 text-xs leading-relaxed text-navy/55">Menjadi yang terbaik dan mendapatkan pengakuan.</p>
                <img src="{{ asset('asset/doodles/star.svg') }}" alt="" class="absolute bottom-2 right-2 w-5 h-5 opacity-15" aria-hidden="true">
            </div>

            <div class="paper-sheet p-5 relative anim-fade-up delay-3" style="transform: rotate(-0.75deg);">
                <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-3 right-3 w-12 h-4 opacity-60 rotate-[1deg]" aria-hidden="true">
                <div class="w-11 h-11 bg-orange/10 border-2 border-orange/20 flex items-center justify-center mb-3" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                    <img src="{{ asset('asset/illustrations/participants.svg') }}" alt="" class="w-7 h-5" aria-hidden="true">
                </div>
                <h3 class="font-bold text-sm text-navy">Bangun Relasi</h3>
                <p class="mt-1.5 text-xs leading-relaxed text-navy/55">Kenalan dan bertukar inspirasi dengan peserta dari sekolah lain.</p>
            </div>

            <div class="paper-sheet p-5 relative anim-fade-up delay-4" style="transform: rotate(1deg);">
                <img src="{{ asset('asset/ui/tape-paper.svg') }}" alt="" class="absolute -top-3 left-3 w-12 h-4 opacity-50 rotate-[-3deg]" aria-hidden="true">
                <div class="w-11 h-11 bg-yellow-light border-2 border-yellow/30 flex items-center justify-center mb-3" style="border-radius: 15px 225px 15px 255px / 225px 15px 255px 15px;">
                    <img src="{{ asset('asset/illustrations/shield.svg') }}" alt="" class="w-6 h-7" aria-hidden="true">
                </div>
                <h3 class="font-bold text-sm text-navy">Pengalaman Berharga</h3>
                <p class="mt-1.5 text-xs leading-relaxed text-navy/55">Tumbuh lebih percaya diri dan siap menghadapi tantangan masa depan.</p>
                <img src="{{ asset('asset/doodles/circle.svg') }}" alt="" class="absolute bottom-2 left-3 w-5 h-5 opacity-10" aria-hidden="true">
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- LOMBA — Editorial Grid --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@if($competitions->count())
<section class="py-14 sm:py-18 bg-paper relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <div class="sticker sticker-navy mb-3 inline-block">Lomba</div>
                <h2 class="font-marker text-3xl sm:text-4xl text-navy">Pilih Lomba Favoritmu</h2>
                <p class="text-sm text-navy/55 mt-2">Pilih lomba yang paling kamu minati.</p>
            </div>
            <a href="{{ route('lomba.index') }}" class="editorial-link text-sm font-bold text-navy/70 hidden sm:inline-flex">Lihat Semua →</a>
        </div>

        @php $all = $competitions->take(6); $featuredLomba = $all->first(); $rest = $all->slice(1); @endphp
        <div class="grid lg:grid-cols-3 gap-5">
            {{-- Featured --}}
            @if($featuredLomba)
            <a href="{{ route('lomba.show', $featuredLomba->slug) }}" class="group lg:row-span-2 flex flex-col overflow-hidden paper-sheet relative anim-fade-up" style="transform: rotate(-0.5deg);">
                <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-3 left-6 w-16 h-5 z-10 opacity-70 rotate-[-2deg]" aria-hidden="true">
                <div class="h-44 lg:h-[220px] bg-orange/5 relative overflow-hidden flex items-center justify-center border-b-2 border-navy/5">
                    @if($featuredLomba->cover_url)
                        <img src="{{ asset('storage/' . $featuredLomba->cover_url) }}" alt="{{ $featuredLomba->name }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                    @else
                        <img src="{{ asset('asset/illustrations/trophy.svg') }}" alt="" class="w-14 h-16 opacity-15" aria-hidden="true">
                    @endif
                    <span class="absolute top-3 right-3 inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide {{ $featuredLomba->status === 'OPEN' ? 'bg-green text-navy' : 'bg-navy/10 text-navy/50' }}" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">{{ $featuredLomba->status === 'OPEN' ? 'Buka' : 'Tutup' }}</span>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="inline-flex w-fit bg-yellow-light border border-yellow/30 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-navy/60">{{ $featuredLomba->category }}</span>
                    <h3 class="font-bold text-base leading-tight mt-2 text-navy group-hover:text-orange transition-colors">{{ $featuredLomba->name }}</h3>
                    <p class="text-xs text-navy/50 line-clamp-2 mt-1.5 flex-1 leading-relaxed">{{ $featuredLomba->description }}</p>
                    <span class="text-sm font-bold text-orange mt-4 inline-flex items-center gap-1 group-hover:underline underline-offset-4">Lihat Detail →</span>
                </div>
            </a>
            @endif

            {{-- Rest 2x2 + 1 --}}
            <div class="lg:col-span-2 grid sm:grid-cols-2 gap-5">
                @foreach($rest as $lomba)
                <a href="{{ route('lomba.show', $lomba->slug) }}" class="group flex flex-col overflow-hidden paper-sheet relative anim-fade-up" style="transform: rotate({{ $loop->index % 2 === 0 ? '0.3' : '-0.4' }}deg);">
                    <div class="h-28 bg-orange/5 relative overflow-hidden flex items-center justify-center border-b-2 border-navy/5">
                        @if($lomba->cover_url)
                            <img src="{{ asset('storage/' . $lomba->cover_url) }}" alt="{{ $lomba->name }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                        @else
                            <img src="{{ asset('asset/illustrations/trophy.svg') }}" alt="" class="w-10 h-12 opacity-15" aria-hidden="true">
                        @endif
                        <span class="absolute top-2 right-2 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide {{ $lomba->status === 'OPEN' ? 'bg-green text-navy' : 'bg-navy/10 text-navy/50' }}" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">{{ $lomba->status === 'OPEN' ? 'Buka' : 'Tutup' }}</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <span class="inline-flex w-fit bg-yellow-light border border-yellow/30 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-navy/60">{{ $lomba->category }}</span>
                        <h3 class="font-bold text-sm leading-tight mt-2 text-navy group-hover:text-orange transition-colors line-clamp-1">{{ $lomba->name }}</h3>
                        <p class="text-xs text-navy/50 line-clamp-2 mt-1 flex-1 leading-relaxed">{{ $lomba->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="sm:hidden mt-5">
            <a href="{{ route('lomba.index') }}" class="inline-flex w-full justify-center h-11 items-center border-2 border-navy/20 text-sm font-bold text-navy/70 hover:bg-navy/5 transition-colors" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">Lihat Semua Lomba</a>
        </div>
    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- HADIAH — Editorial Podium --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@php
    $featured = $competitions->firstWhere('slug', 'olimpiade-ipas') ?? $competitions->first();
    $formatPrizeParts = fn($raw) => $raw ? array_filter(array_map('trim', explode('+', $raw))) : [];
    $prizes = [2 => $formatPrizeParts($featured->prize_2 ?? null), 1 => $formatPrizeParts($featured->prize_1 ?? null), 3 => $formatPrizeParts($featured->prize_3 ?? null)];
    $isPrizeRp = fn($part) => str_starts_with(trim($part), 'Rp');
@endphp
@if($featured && ($featured->prize_1 || $featured->prize_2 || $featured->prize_3))
<section class="py-14 sm:py-18 bg-paper relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tape decoration --}}
        <div class="relative inline-block mb-6">
            <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-3 left-2 w-20 h-6 z-10 opacity-70 rotate-[-2deg]" aria-hidden="true">
            <div class="paper-sheet p-6 sm:p-8 relative" style="transform: rotate(-0.3deg);">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <div>
                        <h2 class="font-marker text-3xl text-navy">Hadiah Pemenang</h2>
                        <p class="text-sm text-navy/55 mt-1">{{ $featured->name }} — podium hadiah.</p>
                    </div>
                    <span class="sticker sticker-yellow">Total Jutaan Rupiah</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end max-w-4xl mx-auto">
                    @foreach([2,1,3] as $place)
                        @php
                            $parts = $prizes[$place] ?? [];
                            if (empty($parts)) continue;
                            $cfg = [
                                1=>['order'=>'order-1 sm:order-2','bg'=>'bg-yellow-light','border'=>'border-yellow/40','iconBg'=>'bg-orange','money'=>'text-orange','label'=>'JUARA 1','icon'=>'trophy'],
                                2=>['order'=>'order-2 sm:order-1','bg'=>'bg-white','border'=>'border-navy/15','iconBg'=>'bg-navy/20','money'=>'text-navy/70','label'=>'JUARA 2','icon'=>'medal'],
                                3=>['order'=>'order-3','bg'=>'bg-white','border'=>'border-orange/20','iconBg'=>'bg-orange/70','money'=>'text-orange/80','label'=>'JUARA 3','icon'=>'crown'],
                            ][$place];
                        @endphp
                        <div class="order-{{ $place === 1 ? '1 sm:order-2' : ($place === 2 ? '2 sm:order-1' : '3') }} {{ $cfg['bg'] }} border-2 {{ $cfg['border'] }} p-5 text-center {{ $place===1 ? 'sm:-translate-y-2' : '' }}" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                            <div class="w-12 h-12 {{ $cfg['iconBg'] }} flex items-center justify-center mx-auto mb-3" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                                @if($cfg['icon'] === 'trophy')
                                    <img src="{{ asset('asset/illustrations/trophy.svg') }}" alt="" class="w-8 h-9" aria-hidden="true">
                                @elseif($cfg['icon'] === 'medal')
                                    <img src="{{ asset('asset/illustrations/medal.svg') }}" alt="" class="w-7 h-8" aria-hidden="true">
                                @else
                                    <img src="{{ asset('asset/doodles/crown.svg') }}" alt="" class="w-7 h-5" aria-hidden="true">
                                @endif
                            </div>
                            <div class="font-marker text-lg text-navy mb-2">{{ $cfg['label'] }}</div>
                            <div class="space-y-1.5">
                                @foreach($parts as $part)
                                    @if($isPrizeRp($part))
                                        <div class="text-lg font-bold {{ $cfg['money'] }}">{{ $part }}</div>
                                    @else
                                        <span class="inline-flex items-center bg-yellow-light border border-yellow/30 px-2.5 py-1 text-xs font-bold text-navy/60">{{ $part }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($featured->prize_extra)
                    <p class="text-center mt-6">
                        <span class="sticker sticker-orange text-[11px]">
                            Bonus: {{ $featured->prize_extra }}
                        </span>
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- JADWAL + KEGIATAN — Two-column editorial --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-18 bg-paper relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-6">
        {{-- Jadwal --}}
        <div class="paper-sheet relative" style="transform: rotate(-0.3deg);">
            <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-3 left-4 w-16 h-5 z-10 opacity-70 rotate-[-2deg]" aria-hidden="true">
            <div class="p-5 border-b-2 border-navy/5">
                <h2 class="font-marker text-2xl text-navy">Jadwal Penting</h2>
                <p class="text-xs text-navy/50 mt-1">Linimasa AKASHI 2026</p>
            </div>
            <div class="p-5">
                @if($schedules->count())
                <div class="relative pl-6 border-l-2 border-dashed border-navy/15">
                    @foreach($schedules as $jadwal)
                    <div class="relative pb-6 last:pb-0">
                        <span class="absolute -left-[27px] top-1 w-3 h-3 bg-orange border-2 border-paper" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;"></span>
                        <div class="text-[11px] font-bold text-orange uppercase tracking-wide">{{ $jadwal->date->translatedFormat('d F Y') }}</div>
                        <div class="font-bold text-sm mt-0.5 text-navy">{{ $jadwal->title }}</div>
                        @if($jadwal->note)<div class="text-xs text-navy/50 mt-1 leading-relaxed">{{ $jadwal->note }}</div>@endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-navy/45">Belum ada jadwal.</p>
                @endif
            </div>
        </div>

        {{-- Kegiatan --}}
        <div class="paper-sheet relative" style="transform: rotate(0.4deg);">
            <img src="{{ asset('asset/ui/tape-paper.svg') }}" alt="" class="absolute -top-3 right-6 w-16 h-5 z-10 opacity-60 rotate-[2deg]" aria-hidden="true">
            <div class="p-5 border-b-2 border-navy/5 flex items-center justify-between">
                <div>
                    <h2 class="font-marker text-2xl text-navy">Kegiatan Seru</h2>
                    <p class="text-xs text-navy/50 mt-1">Selain lomba, ada ini!</p>
                </div>
            </div>
            <div class="p-5 grid gap-3">
                @php
                    $activityIcons = [
                        'Gelar Karya' => ['bg' => 'bg-purple/10', 'color' => 'text-purple', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>', 'src' => 'lucide:palette'],
                        'Talkshow' => ['bg' => 'bg-orange/10', 'color' => 'text-orange', 'icon' => '<path d="M12 5v16"/><path d="M20.001 19A2 2 0 0022 17V5a2 2 0 00-1.999-2L16 3.002A5 5 0 0012 5a5 5 0 00-4-2H4a2 2 0 00-2 2v12a2 2 0 001.999 2H8a5 5 0 014 2 5 5 0 014-2z"/>', 'src' => 'lucide:book-open'],
                        'Bazar' => ['bg' => 'bg-yellow-light', 'color' => 'text-gold-700', 'icon' => '<path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5"/><path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244"/><path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05"/>', 'src' => 'lucide:store'],
                        'Dolanan' => ['bg' => 'bg-green-light', 'color' => 'text-green', 'icon' => '<rect width="12" height="12" x="2" y="10" rx="2" ry="2"/><path d="m17.92 14 3.5-3.5a2.24 2.24 0 0 0 0-3l-5-4.92a2.24 2.24 0 0 0-3 0L10 6"/><path d="M6 18h.01"/><path d="M10 14h.01"/><path d="M15 6h.01"/><path d="M18 9h.01"/>', 'src' => 'lucide:dices'],
                        'Membatik' => ['bg' => 'bg-orange/10', 'color' => 'text-orange', 'icon' => '<path d="m11 10 3 3"/><path d="M6.5 21A3.5 3.5 0 1 0 3 17.5a2.62 2.62 0 0 1-.708 1.792A1 1 0 0 0 3 21z"/><path d="M9.969 17.031 21.378 5.624a1 1 0 0 0-3.002-3.002L6.967 14.031"/>', 'src' => 'lucide:brush'],
                    ];
                    $getActivityStyle = function($name) use ($activityIcons) {
                        foreach ($activityIcons as $key => $style) {
                            if (str_contains($name, $key)) return $style;
                        }
                        return ['bg' => 'bg-orange/10', 'color' => 'text-orange', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>'];
                    };
                @endphp
                @forelse($activities as $kegiatan)
                @php $style = $getActivityStyle($kegiatan->name); @endphp
                <div class="flex gap-3 p-3 hover:bg-navy/[0.02] transition-colors group" style="border: 2px solid transparent; border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                    <div class="w-11 h-11 {{ $style['bg'] }} flex-shrink-0 flex items-center justify-center overflow-hidden" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                        @if($kegiatan->image_url)
                            <img src="{{ $kegiatan->image_url }}" alt="{{ $kegiatan->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-[22px] h-[22px] {{ $style['color'] }}" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                {!! $style['icon'] !!}
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="font-bold text-sm leading-tight truncate group-hover:text-orange transition-colors">{{ $kegiatan->name }}</div>
                        @if($kegiatan->description)<div class="text-xs text-navy/50 line-clamp-2 mt-0.5 leading-relaxed">{{ $kegiatan->description }}</div>@endif
                        <div class="text-[11px] text-navy/40 mt-1 flex items-center gap-2 font-semibold">
                            @if($kegiatan->date)<span>{{ $kegiatan->date->translatedFormat('d M Y') }}</span>@endif
                            @if($kegiatan->location)<span>· {{ $kegiatan->location }}</span>@endif
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-navy/45">Belum ada kegiatan.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- FAQ — Editorial Accordion --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@if($faqs->count())
<section class="py-14 sm:py-18 bg-paper relative">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <div class="sticker sticker-navy mb-3 inline-block">FAQ</div>
            <h2 class="font-marker text-3xl text-navy">Pertanyaan yang Sering Ditanyakan</h2>
        </div>
        <div class="space-y-3">
            @foreach($faqs as $i => $faq)
            <div class="faq-item paper-sheet" style="transform: rotate({{ $loop->index % 2 === 0 ? '-0.2' : '0.3' }}deg);">
                <button onclick="toggleFaq({{ $i }})" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left hover:bg-navy/[0.02] transition-colors">
                    <span class="font-bold text-sm text-navy pr-2">{{ $faq->question }}</span>
                    <svg id="faq-icon-{{ $i }}" class="w-4 h-4 text-navy/40 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div id="faq-content-{{ $i }}" class="hidden px-5 pb-4 text-sm text-navy/60 leading-relaxed">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- CTA — Full-width editorial banner --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-18 relative overflow-hidden bg-editorial-navy">
    {{-- Grid pattern --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.04]" aria-hidden="true">
        <img src="{{ asset('asset/textures/grid-paper.svg') }}" alt="" class="w-full h-full object-cover">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        {{-- Tape piece --}}
        <div class="inline-block relative mb-6">
            <img src="{{ asset('asset/ui/tape-paper.svg') }}" alt="" class="absolute -top-3 left-1/2 -translate-x-1/2 w-20 h-6 z-10 opacity-60" style="transform: translateX(-50%) rotate(-1deg);" aria-hidden="true">
            <div class="paper-sheet px-8 py-4 text-center" style="transform: rotate(-0.5deg);">
                <h2 class="font-marker text-3xl sm:text-4xl text-navy">Siap Tampil?</h2>
            </div>
        </div>
        <p class="text-white/60 text-sm max-w-md mx-auto mt-2 leading-relaxed">Daftarkan dirimu sekarang dan jadilah bagian dari AKASHI 2026!</p>
        <div class="mt-8">
            <a href="{{ route('daftar.index') }}" class="cta-button cta-button-white text-base">
                Daftar Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.964-3.072c.087.55.149 1.115.149 1.706v.474a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25v-.474c0-.59.062-1.155.149-1.706A6.375 6.375 0 014 19.235z"/></svg>
            </a>
        </div>

        {{-- Decorative doodles --}}
        <img src="{{ asset('asset/doodles/star.svg') }}" alt="" class="absolute top-8 left-8 w-8 h-8 opacity-15 rotate-[15deg] hidden lg:block" aria-hidden="true">
        <img src="{{ asset('asset/doodles/circle.svg') }}" alt="" class="absolute bottom-8 right-12 w-6 h-6 opacity-10 -rotate-[20deg] hidden lg:block" aria-hidden="true">
        <img src="{{ asset('asset/doodles/scribble.svg') }}" alt="" class="absolute bottom-4 left-[15%] w-24 h-6 opacity-10 hidden lg:block" aria-hidden="true">
    </div>
</section>

@else

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- FINISHED STATE --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@if(isset($announcements) && $announcements->count())
<section class="py-14 sm:py-18 bg-paper relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <div class="sticker sticker-orange mb-3 inline-block">Juara</div>
            <h2 class="font-marker text-3xl sm:text-4xl text-navy">Para Juara</h2>
            <p class="text-sm text-navy/55 mt-2">Selamat kepada seluruh pemenang!</p>
        </div>

        @foreach($announcements as $pengumuman)
        <div class="paper-sheet p-6 mb-6 relative" style="transform: rotate({{ $loop->index % 2 === 0 ? '-0.3' : '0.2' }}deg);">
            <img src="{{ asset('asset/ui/tape-yellow.svg') }}" alt="" class="absolute -top-3 left-6 w-16 h-5 z-10 opacity-70 rotate-[-2deg]" aria-hidden="true">
            <h3 class="font-bold text-navy">{{ $pengumuman->title }}</h3>
            @if($pengumuman->competition)<div class="text-sm text-navy/50">{{ $pengumuman->competition->name }}</div>@endif

            @if($pengumuman->winners->count())
            <div class="grid sm:grid-cols-3 gap-4 mt-6 max-w-3xl mx-auto items-end">
                @php $s=$pengumuman->winners->where('place',2)->first(); $g=$pengumuman->winners->where('place',1)->first(); $b=$pengumuman->winners->where('place',3)->first(); @endphp

                @if($s)
                <div class="paper-sheet p-5 text-center order-2 sm:order-1" style="transform: rotate(0.5deg);">
                    <div class="w-10 h-10 bg-navy/20 flex items-center justify-center mx-auto" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                        <img src="{{ asset('asset/illustrations/medal.svg') }}" alt="" class="w-7 h-8" aria-hidden="true">
                    </div>
                    <div class="font-marker text-base text-navy mt-2">Juara 2</div>
                    <div class="font-bold text-sm text-navy mt-1">{{ $s->participant_name }}</div>
                    <div class="text-xs text-navy/50">{{ $s->school }}</div>
                </div>
                @endif

                @if($g)
                <div class="bg-yellow-light border-2 border-yellow/40 p-5 text-center order-1 sm:order-2 sm:-translate-y-2" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                    <div class="w-12 h-12 bg-orange flex items-center justify-center mx-auto text-white" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                        <img src="{{ asset('asset/illustrations/trophy.svg') }}" alt="" class="w-8 h-9" aria-hidden="true">
                    </div>
                    <div class="sticker sticker-orange text-[9px] mt-2 mb-1">Juara 1</div>
                    <div class="font-bold text-sm text-navy">{{ $g->participant_name }}</div>
                    <div class="text-xs text-navy/50">{{ $g->school }}</div>
                </div>
                @endif

                @if($b)
                <div class="paper-sheet p-5 text-center order-3" style="transform: rotate(-0.5deg);">
                    <div class="w-10 h-10 bg-orange/70 flex items-center justify-center mx-auto text-white" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                        <img src="{{ asset('asset/doodles/crown.svg') }}" alt="" class="w-6 h-4" aria-hidden="true">
                    </div>
                    <div class="font-marker text-base text-navy mt-2">Juara 3</div>
                    <div class="font-bold text-sm text-navy mt-1">{{ $b->participant_name }}</div>
                    <div class="text-xs text-navy/50">{{ $b->school }}</div>
                </div>
                @endif
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
    var raw='{{ addslashes($settings["event_date"] ?? "") }}';
    var target;
    // Try ISO first, then common formats
    target = new Date(raw + 'T23:59:59').getTime();
    if(isNaN(target)) target = new Date(raw).getTime();
    if(isNaN(target)) return; // no valid date, countdown stays at 00
    function upd(){
        var d=target-Date.now();
        if(d<=0){
            ['cd-days','cd-hours','cd-minutes','cd-seconds'].forEach(function(id){
                var el=document.getElementById(id);
                if(el) el.textContent='00';
            });
            return;
        }
        var daysEl=document.getElementById('cd-days');
        var hoursEl=document.getElementById('cd-hours');
        var minEl=document.getElementById('cd-minutes');
        var secEl=document.getElementById('cd-seconds');
        if(daysEl) daysEl.textContent=String(Math.floor(d/86400000)).padStart(2,'0');
        if(hoursEl) hoursEl.textContent=String(Math.floor(d%86400000/3600000)).padStart(2,'0');
        if(minEl) minEl.textContent=String(Math.floor(d%3600000/60000)).padStart(2,'0');
        if(secEl) secEl.textContent=String(Math.floor(d%60000/1000)).padStart(2,'0');
    }
    upd(); setInterval(upd,1000);
})();
</script>
@endif
<script>
function toggleFaq(i){
    var c=document.getElementById('faq-content-'+i), ic=document.getElementById('faq-icon-'+i);
    var isHidden=c.classList.contains('hidden');
    var allContents=document.querySelectorAll('[id^="faq-content-"]');
    var allIcons=document.querySelectorAll('[id^="faq-icon-"]');
    for(var j=0;j<allContents.length;j++) allContents[j].classList.add('hidden');
    for(var j=0;j<allIcons.length;j++) allIcons[j].style.transform='';
    if(isHidden){ c.classList.remove('hidden'); ic.style.transform='rotate(180deg)'; }
}
</script>
@endpush
