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
<body class="bg-background text-foreground antialiased">
    {{-- Subtle texture overlay for white sections --}}
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden" aria-hidden="true">
        <svg class="absolute top-[8%] left-[4%] w-32 h-32 text-primary/[0.04]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6.084 10H4.5A2.5 2.5 0 0 1 2 7.5V5a1 1 0 0 1 1-1h3"/><path d="M17.916 10H19.5A2.5 2.5 0 0 0 22 7.5V5a1 1 0 0 0-1-1h-3"/><path d="M4 22h16"/><path d="M10 14.66V17a1 1 0 0 1-1 1 2 2 0 0 0-2 2v2"/><path d="M14 14.66V17a1 1 0 0 0 1 1 2 2 0 0 1 2 2v2"/></svg>
        <svg class="absolute top-[22%] right-[6%] w-20 h-20 text-gold/[0.06] rotate-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="12" cy="8" r="6"/><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/></svg>
        <svg class="absolute top-[45%] left-[2%] w-24 h-24 text-primary/[0.03] -rotate-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg>
        <svg class="absolute bottom-[18%] right-[3%] w-28 h-28 text-primary/[0.035] rotate-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M6 13a6 6 0 0 0 12 0V-2a2 2 0 0 1 .49 0"/><circle cx="12" cy="8" r="6"/><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/></svg>
    </div>

    {{-- HEADER — clean premium, white, thin border, no shadow, spacious --}}
    <header class="sticky top-0 z-50 bg-white border-b border-border">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-[68px] lg:h-[72px]">
                {{-- Logo left --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                    @if(!empty($settings['site_logo']))
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['event_name'] ?? 'AKASHI' }}" class="w-10 h-10 rounded-lg object-contain">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white font-extrabold text-[15px] tracking-tight">A</div>
                    @endif
                    <div class="hidden sm:block leading-none">
                        <div class="font-extrabold text-[17px] tracking-tight text-navy">AKASHI <span class="text-primary">2026</span></div>
                        <div class="text-[11px] font-medium tracking-[0.14em] text-muted-foreground uppercase">Ajang Kreasi Ashidiq</div>
                    </div>
                </a>

                {{-- Nav center --}}
                <nav class="hidden lg:flex items-center gap-1.5">
                    <a href="{{ route('lomba.index') }}" class="px-3.5 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('lomba.*') ? 'text-primary bg-primary-50' : 'text-muted-foreground hover:text-foreground hover:bg-muted' }}">Lomba</a>
                    <a href="{{ route('juknis.show') }}" class="px-3.5 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('juknis.*') ? 'text-primary bg-primary-50' : 'text-muted-foreground hover:text-foreground hover:bg-muted' }}">Juknis</a>
                    <a href="{{ route('pengumuman.index') }}" class="px-3.5 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('pengumuman.*') ? 'text-primary bg-primary-50' : 'text-muted-foreground hover:text-foreground hover:bg-muted' }}">Pengumuman</a>
                    <a href="{{ route('juara.index') }}" class="px-3.5 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('juara.*') ? 'text-primary bg-primary-50' : 'text-muted-foreground hover:text-foreground hover:bg-muted' }}">Juara</a>
                    <a href="{{ route('kontak.index') }}" class="px-3.5 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('kontak.*') ? 'text-primary bg-primary-50' : 'text-muted-foreground hover:text-foreground hover:bg-muted' }}">Kontak</a>
                </nav>

                {{-- CTA right --}}
                <div class="flex items-center gap-2.5">
                    @if(!request()->routeIs('kartu.*'))
                        @if(!($finished ?? false))
                            <a href="{{ route('admin.login') }}" class="hidden sm:inline-flex h-9 px-4 items-center justify-center rounded-md border border-border bg-white text-sm font-medium text-foreground hover:bg-muted transition-colors">Masuk</a>
                            <a href="{{ route('daftar.index') }}" class="inline-flex h-9 px-5 items-center justify-center rounded-md bg-primary text-primary-foreground text-sm font-medium hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring transition-colors">
                                Daftar Sekarang
                                <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L6 6m0 0l6 6m-6-6v12a2.25 2.25 0 002.25 2.25h9A2.25 2.25 0 0019.5 18V6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('juara.index') }}" class="hidden sm:inline-flex h-9 px-4 items-center justify-center rounded-md border border-border bg-white text-sm font-medium hover:bg-muted transition-colors">Juara</a>
                            <a href="{{ route('pengumuman.index') }}" class="inline-flex h-9 px-5 items-center justify-center rounded-md bg-primary text-primary-foreground text-sm font-medium hover:bg-primary/90 transition-colors">Pengumuman</a>
                        @endif
                    @endif
                    <button onclick="toggleMobileMenu()" class="lg:hidden w-9 h-9 inline-flex items-center justify-center rounded-md border border-border bg-white hover:bg-muted transition-colors" aria-label="Menu">
                        <svg id="menu-icon-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        <svg id="menu-icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden lg:hidden border-t border-border bg-white">
            <div class="max-w-6xl mx-auto px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-md hover:bg-muted transition-colors">Beranda <span class="text-muted-foreground">→</span></a>
                <a href="{{ route('lomba.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-md hover:bg-muted transition-colors">Lomba</a>
                <a href="{{ route('juknis.show') }}" class="block px-3 py-2.5 text-sm font-medium rounded-md hover:bg-muted transition-colors">Juknis</a>
                <a href="{{ route('pengumuman.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-md hover:bg-muted transition-colors">Pengumuman</a>
                <a href="{{ route('juara.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-md hover:bg-muted transition-colors">Juara</a>
                <a href="{{ route('kontak.index') }}" class="block px-3 py-2.5 text-sm font-medium rounded-md hover:bg-muted transition-colors">Kontak</a>
                @if(!request()->routeIs('kartu.*'))
                <div class="pt-2 grid grid-cols-2 gap-2">
                    <a href="{{ route('admin.login') }}" class="h-10 inline-flex items-center justify-center rounded-md border border-border bg-white text-sm font-medium">Masuk</a>
                    @if(!($finished ?? false))
                        <a href="{{ route('daftar.index') }}" class="h-10 inline-flex items-center justify-center rounded-md bg-primary text-primary-foreground text-sm font-medium">Daftar Sekarang</a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </header>

    {{-- MAIN --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER — white/dark navy, clean --}}
    <footer class="mt-16 border-t border-border bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        @if(!empty($settings['site_logo']))
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['event_name'] ?? 'AKASHI' }}" class="w-9 h-9 rounded-lg object-contain">
                        @else
                            <div class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center text-white font-extrabold text-sm">A</div>
                        @endif
                        <span class="font-extrabold tracking-tight text-navy">AKASHI <span class="text-primary">2026</span></span>
                    </a>
                    <p class="text-sm text-muted-foreground leading-relaxed mt-3 max-w-[28ch]">Ajang Kreasi Ashidiq — kompetisi dan festival untuk siswa SMP Muhammadiyah Unggulan Ashidiq.</p>
                </div>
                <div>
                    <h3 class="text-xs font-semibold tracking-widest uppercase text-muted-foreground mb-3">Navigasi</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('lomba.index') }}" class="text-muted-foreground hover:text-primary transition-colors">Lomba</a></li>
                        <li><a href="{{ route('juknis.show') }}" class="text-muted-foreground hover:text-primary transition-colors">Juknis</a></li>
                        <li><a href="{{ route('pengumuman.index') }}" class="text-muted-foreground hover:text-primary transition-colors">Pengumuman</a></li>
                        <li><a href="{{ route('juara.index') }}" class="text-muted-foreground hover:text-primary transition-colors">Juara</a></li>
                        <li><a href="{{ route('kontak.index') }}" class="text-muted-foreground hover:text-primary transition-colors">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold tracking-widest uppercase text-muted-foreground mb-3">Kontak</h3>
                    <ul class="space-y-2 text-sm">
                        @if($settings['whatsapp_number'] ?? null)
                        <li><a href="https://wa.me/{{ $settings['whatsapp_number'] }}" target="_blank" class="text-muted-foreground hover:text-primary transition-colors">WhatsApp</a></li>
                        @endif
                        <li><a href="https://instagram.com/{{ ltrim($settings['instagram'] ?? 'akashi.ashidiq', '@') }}" target="_blank" class="text-muted-foreground hover:text-primary transition-colors">Instagram</a></li>
                        @if($settings['email'] ?? null)
                        <li><a href="mailto:{{ $settings['email'] }}" class="text-muted-foreground hover:text-primary transition-colors">{{ $settings['email'] }}</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold tracking-widest uppercase text-muted-foreground mb-3">Alamat</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">{{ $settings['address'] ?? 'SMP Muhammadiyah Unggulan Ashidiq' }}</p>
                </div>
            </div>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-border pt-6">
                <p class="text-xs text-muted-foreground">&copy; {{ date('Y') }} AKASHI — Ajang Kreasi Ashidiq · SMP Muhammadiyah Unggulan Ashidiq</p>
                <a href="{{ route('cek-pendaftaran') }}" class="text-xs font-medium text-primary hover:underline underline-offset-4">Cek Pendaftaran →</a>
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
    </script>
    @stack('scripts')
</body>
</html>
