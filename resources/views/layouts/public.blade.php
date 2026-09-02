<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AKASHI 2026') — Ajang Kreasi Ashidiq</title>
    <link rel="icon" type="image/x-icon" href="{{ !empty($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('favicon.ico') }}">
    <meta name="description" content="{{ $settings['site_description'] ?? 'Ajang Kreasi Ashidiq 2026 — Lomba, Festival, dan Kompetisi untuk Siswa SMP Muhammadiyah Unggulan Ashidiq' }}">
    @yield('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-paper text-navy antialiased" style="overflow-x: clip; overflow-y: auto !important; -webkit-overflow-scrolling: touch;">

    {{-- NAVBAR — editorial, confident, no SaaS feel --}}
    <header class="sticky top-0 z-50 bg-navy">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[80px] lg:h-[88px]">
                {{-- Logo left — editorial type --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0 overflow-hidden h-[80px] lg:h-[88px]">
                    @if(!empty($settings['site_logo']))
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['event_name'] ?? 'AKASHI' }}" class="w-20 h-20 object-contain shrink-0">
                    @else
                        <img src="{{ asset('asset/brand/akashi-mark.svg') }}" alt="AKASHI 2026" class="w-20 h-20 shrink-0">
                    @endif
                </a>

                {{-- Nav center — editorial spacing --}}
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('lomba.index') }}" class="px-3 py-2 text-[13px] font-semibold tracking-wide uppercase transition-colors {{ request()->routeIs('lomba.*') ? 'text-orange' : 'text-white/70 hover:text-white' }}">Lomba</a>
                    <a href="{{ route('juknis.show') }}" class="px-3 py-2 text-[13px] font-semibold tracking-wide uppercase transition-colors {{ request()->routeIs('juknis.*') ? 'text-orange' : 'text-white/70 hover:text-white' }}">Juknis</a>
                    <a href="{{ route('pengumuman.index') }}" class="px-3 py-2 text-[13px] font-semibold tracking-wide uppercase transition-colors {{ request()->routeIs('pengumuman.*') ? 'text-orange' : 'text-white/70 hover:text-white' }}">Pengumuman</a>
                    <a href="{{ route('juara.index') }}" class="px-3 py-2 text-[13px] font-semibold tracking-wide uppercase transition-colors {{ request()->routeIs('juara.*') ? 'text-orange' : 'text-white/70 hover:text-white' }}">Juara</a>
                    <a href="{{ route('kontak.index') }}" class="px-3 py-2 text-[13px] font-semibold tracking-wide uppercase transition-colors {{ request()->routeIs('kontak.*') ? 'text-orange' : 'text-white/70 hover:text-white' }}">Kontak</a>
                </nav>

                {{-- CTA right --}}
                <div class="flex items-center gap-2">
                    @if(!request()->routeIs('kartu.*'))
                        @if(!($finished ?? false))
                            <a href="{{ route('admin.login') }}" class="hidden sm:inline-flex h-8 px-3 items-center gap-1.5 text-[13px] font-semibold text-white/60 hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                                Masuk
                            </a>
                            <a href="{{ route('daftar.index') }}" class="inline-flex h-9 px-5 items-center justify-center bg-orange text-white font-bold text-[13px] uppercase tracking-wide hover:bg-orange-dark transition-colors" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">
                                Daftar
                                <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L6 6m0 0l6 6m-6-6v12"/></svg>
                            </a>
                        @else
                            <a href="{{ route('juara.index') }}" class="hidden sm:inline-flex h-8 px-3 items-center gap-1.5 text-[13px] font-semibold text-white/60 hover:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.192 6.192 0 002.46 3.793M7.73 9.728c-.75-.94-1.232-2.025-1.232-3.228 0-2.25 1.243-3.858 2.958-4.213m11.322 0a4.778 4.778 0 00-1.79-1.04M16.5 18.75c-1.075 0-2.057-.375-2.756-1.063M16.5 18.75c-.97 0-1.846-.4-2.5-1.04"/></svg>
                                Juara
                            </a>
                            <a href="{{ route('pengumuman.index') }}" class="inline-flex h-9 px-5 items-center justify-center bg-orange text-white font-bold text-[13px] uppercase tracking-wide transition-colors" style="border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;">Pengumuman</a>
                        @endif
                    @endif
                    <button onclick="toggleMobileMenu()" class="lg:hidden w-9 h-9 inline-flex items-center justify-center text-white/70 hover:text-white transition-colors" aria-label="Menu">
                        <svg id="menu-icon-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        <svg id="menu-icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden lg:hidden border-t border-white/10 bg-navy">
            <div class="max-w-7xl mx-auto px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center justify-between px-3 py-2.5 text-sm font-semibold text-white/80 hover:text-white rounded transition-colors">Beranda <span class="text-white/40">→</span></a>
                <a href="{{ route('lomba.index') }}" class="block px-3 py-2.5 text-sm font-semibold text-white/80 hover:text-white rounded transition-colors">Lomba</a>
                <a href="{{ route('juknis.show') }}" class="block px-3 py-2.5 text-sm font-semibold text-white/80 hover:text-white rounded transition-colors">Juknis</a>
                <a href="{{ route('pengumuman.index') }}" class="block px-3 py-2.5 text-sm font-semibold text-white/80 hover:text-white rounded transition-colors">Pengumuman</a>
                <a href="{{ route('juara.index') }}" class="block px-3 py-2.5 text-sm font-semibold text-white/80 hover:text-white rounded transition-colors">Juara</a>
                <a href="{{ route('kontak.index') }}" class="block px-3 py-2.5 text-sm font-semibold text-white/80 hover:text-white rounded transition-colors">Kontak</a>
                @if(!request()->routeIs('kartu.*'))
                <div class="pt-2 grid grid-cols-2 gap-2">
                    <a href="{{ route('admin.login') }}" class="h-10 inline-flex items-center justify-center border border-white/20 text-white/70 text-sm font-semibold rounded">Masuk</a>
                    @if(!($finished ?? false))
                        <a href="{{ route('daftar.index') }}" class="h-10 inline-flex items-center justify-center bg-orange text-white text-sm font-bold uppercase rounded">Daftar Sekarang</a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </header>

    {{-- MAIN --}}
    <main class="relative">
        @yield('content')
    </main>

    {{-- FOOTER — editorial, dark navy --}}
    <footer class="bg-navy text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        @if(!empty($settings['site_logo']))
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['event_name'] ?? 'AKASHI' }}" class="w-18 h-18 object-contain">
                        @else
                            <img src="{{ asset('asset/brand/akashi-mark.svg') }}" alt="AKASHI 2026" class="w-18 h-18">
                        @endif
                    </a>
                    <p class="text-sm text-white/50 leading-relaxed mt-3 max-w-[28ch]">Ajang Kreasi Ashidiq — kompetisi dan festival untuk siswa SMP Muhammadiyah Unggulan Ashidiq.</p>
                </div>
                <div>
                    <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase text-white/40 mb-4">Navigasi</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('lomba.index') }}" class="text-white/60 hover:text-orange transition-colors">Lomba</a></li>
                        <li><a href="{{ route('juknis.show') }}" class="text-white/60 hover:text-orange transition-colors">Juknis</a></li>
                        <li><a href="{{ route('pengumuman.index') }}" class="text-white/60 hover:text-orange transition-colors">Pengumuman</a></li>
                        <li><a href="{{ route('juara.index') }}" class="text-white/60 hover:text-orange transition-colors">Juara</a></li>
                        <li><a href="{{ route('kontak.index') }}" class="text-white/60 hover:text-orange transition-colors">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase text-white/40 mb-4">Kontak</h3>
                    <ul class="space-y-2.5 text-sm">
                        @php
                            $waFooter = preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '');
                            $igFooter = ltrim($settings['instagram'] ?? 'akashi.ashidiq', '@');
                        @endphp
                        @if($waFooter)
                        <li><a href="https://wa.me/{{ $waFooter }}" target="_blank" rel="noopener" class="text-white/60 hover:text-orange transition-colors">WhatsApp</a></li>
                        @endif
                        <li><a href="https://instagram.com/{{ $igFooter }}" target="_blank" rel="noopener" class="text-white/60 hover:text-orange transition-colors">Instagram</a></li>
                        @if(!empty($settings['youtube_url']))
                        <li><a href="{{ $settings['youtube_url'] }}" target="_blank" rel="noopener" class="text-white/60 hover:text-orange transition-colors">YouTube</a></li>
                        @endif
                        @if(!empty($settings['tiktok_url']))
                        <li><a href="{{ $settings['tiktok_url'] }}" target="_blank" rel="noopener" class="text-white/60 hover:text-orange transition-colors">TikTok</a></li>
                        @endif
                        @if(!empty($settings['facebook_url']))
                        <li><a href="{{ $settings['facebook_url'] }}" target="_blank" rel="noopener" class="text-white/60 hover:text-orange transition-colors">Facebook</a></li>
                        @endif
                        @if(!empty($settings['email']))
                        <li><a href="mailto:{{ $settings['email'] }}" class="text-white/60 hover:text-orange transition-colors">{{ $settings['email'] }}</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase text-white/40 mb-4">Alamat</h3>
                    <p class="text-sm text-white/50 leading-relaxed">{{ $settings['address'] ?? 'SMP Muhammadiyah Unggulan Ashidiq' }}</p>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-white/30">&copy; {{ date('Y') }} AKASHI — Ajang Kreasi Ashidiq · SMP Muhammadiyah Unggulan Ashidiq</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('cek-pendaftaran') }}" class="text-xs font-semibold text-orange hover:underline underline-offset-4">Cek Pendaftaran →</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const m = document.getElementById('mobile-menu');
            const o = document.getElementById('menu-icon-open');
            const c = document.getElementById('menu-icon-close');
            m.classList.toggle('hidden');
            o.classList.toggle('hidden');
            c.classList.toggle('hidden');
        }
        // Safety: release body scroll lock on ESC and when no visible modal.
        (function () {
            const visibleModal = () => document.querySelector('.fixed.inset-0:not(.hidden)');
            const releaseLock = () => {
                if (!visibleModal()) {
                    document.body.style.overflow = '';
                    document.body.style.position = '';
                    document.body.style.height = '';
                    document.documentElement.style.overflow = '';
                }
            };
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') releaseLock();
            });
            window.addEventListener('pageshow', releaseLock);
            window.addEventListener('popstate', releaseLock);
            // Watch any modal being hidden and release scroll lock if none remain.
            new MutationObserver(releaseLock).observe(document.documentElement, { childList: true, subtree: true, attributes: true, attributeFilter: ['class', 'style'] });
            // Final hard fallback: any touch/click on the body area outside modals clears inline overflow.
            document.addEventListener('touchstart', function (e) {
                if (!e.target.closest('.fixed.inset-0')) releaseLock();
            }, { passive: true });
        })();
    </script>
    @stack('scripts')
</body>
</html>
