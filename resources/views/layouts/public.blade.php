<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AKASHI 2026') — Ajang Kreasi Ashidiq</title>
    <meta name="description" content="{{ $settings['site_description'] ?? 'Ajang Kreasi Ashidiq 2026 — Lomba, Festival, dan Kompetisi untuk Siswa SMP Muhammadiyah Unggulan Ashidiq' }}">
    @yield('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    {{-- HEADER --}}
    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 bg-primary-900 rounded-xl flex items-center justify-center text-white font-extrabold text-sm group-hover:scale-105 transition-transform">
                        A
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-primary-900 font-bold text-lg tracking-tight">AKASHI</span>
                        <span class="text-accent-500 font-bold text-lg"> 2026</span>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('lomba.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-900 rounded-lg hover:bg-primary-50 transition {{ request()->routeIs('lomba.*') ? 'text-primary-900 bg-primary-50' : '' }}">Lomba</a>
                    <a href="{{ route('juknis.show') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-900 rounded-lg hover:bg-primary-50 transition">Juknis</a>
                    <a href="{{ route('pengumuman.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-900 rounded-lg hover:bg-primary-50 transition {{ request()->routeIs('pengumuman.*') ? 'text-primary-900 bg-primary-50' : '' }}">Pengumuman</a>
                    <a href="{{ route('juara.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-900 rounded-lg hover:bg-primary-50 transition {{ request()->routeIs('juara.*') ? 'text-primary-900 bg-primary-50' : '' }}">Juara</a>
                    <a href="{{ route('kontak.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-900 rounded-lg hover:bg-primary-50 transition {{ request()->routeIs('kontak.*') ? 'text-primary-900 bg-primary-50' : '' }}">Kontak</a>
                </nav>

                {{-- CTA + Hamburger --}}
                <div class="flex items-center gap-3">
                    @if(!($finished ?? false))
                        <a href="{{ route('daftar.index') }}" class="hidden sm:inline-flex items-center justify-center gap-2 h-10 px-5 bg-primary text-primary-foreground text-sm font-medium rounded-md shadow hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Daftar Sekarang
                        </a>
                    @endif
                    <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition" aria-label="Menu">
                        <svg id="menu-icon-open" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        <svg id="menu-icon-close" class="w-6 h-6 text-gray-700 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-xl">
            <div class="max-w-6xl mx-auto px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-900 rounded-xl transition">Beranda</a>
                <a href="{{ route('lomba.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-900 rounded-xl transition">Lomba</a>
                <a href="{{ route('juknis.show') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-900 rounded-xl transition">Juknis</a>
                <a href="{{ route('pengumuman.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-900 rounded-xl transition">Pengumuman</a>
                <a href="{{ route('juara.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-900 rounded-xl transition">Juara</a>
                <a href="{{ route('kontak.index') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-900 rounded-xl transition">Kontak</a>
                @if(!($finished ?? false))
                    <a href="{{ route('daftar.index') }}" class="block px-4 py-3 text-sm font-semibold text-white bg-primary-900 hover:bg-primary-800 rounded-xl transition text-center mt-3">Daftar Sekarang</a>
                @endif
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="pt-16 lg:pt-18">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-primary-950 text-white mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div class="lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 bg-accent-500 rounded-xl flex items-center justify-center text-white font-extrabold text-sm">A</div>
                        <div>
                            <span class="text-white font-bold text-lg">AKASHI</span>
                            <span class="text-accent-400 font-bold text-lg"> 2026</span>
                        </div>
                    </a>
                    <p class="text-purple-300 text-sm leading-relaxed">Ajang Kreasi Ashidiq — Kompetisi dan Festival untuk Siswa SMP Muhammadiyah Unggulan Ashidiq.</p>
                </div>

                {{-- Navigation --}}
                <div>
                    <h3 class="font-semibold text-sm uppercase tracking-wider text-accent-400 mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('lomba.index') }}" class="text-purple-300 hover:text-white text-sm transition">Lomba</a></li>
                        <li><a href="{{ route('juknis.show') }}" class="text-purple-300 hover:text-white text-sm transition">Juknis</a></li>
                        <li><a href="{{ route('pengumuman.index') }}" class="text-purple-300 hover:text-white text-sm transition">Pengumuman</a></li>
                        <li><a href="{{ route('juara.index') }}" class="text-purple-300 hover:text-white text-sm transition">Juara</a></li>
                        <li><a href="{{ route('kontak.index') }}" class="text-purple-300 hover:text-white text-sm transition">Kontak</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h3 class="font-semibold text-sm uppercase tracking-wider text-accent-400 mb-4">Kontak</h3>
                    <ul class="space-y-3">
                        @if($settings['whatsapp_number'] ?? null)
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </div>
                            <a href="https://wa.me/{{ $settings['whatsapp_number'] }}" target="_blank" class="text-purple-300 hover:text-white text-sm transition">WhatsApp</a>
                        </li>
                        @endif
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-pink-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                            <a href="https://instagram.com/{{ ltrim($settings['instagram'] ?? 'akashi.ashidiq', '@') }}" target="_blank" class="text-purple-300 hover:text-white text-sm transition">Instagram</a>
                        </li>
                        @if($settings['email'] ?? null)
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-accent-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-accent-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </div>
                            <a href="mailto:{{ $settings['email'] }}" class="text-purple-300 hover:text-white text-sm transition">{{ $settings['email'] }}</a>
                        </li>
                        @endif
                    </ul>
                </div>

                {{-- Address --}}
                <div>
                    <h3 class="font-semibold text-sm uppercase tracking-wider text-accent-400 mb-4">Alamat</h3>
                    <p class="text-purple-300 text-sm leading-relaxed">{{ $settings['address'] ?? 'SMP Muhammadiyah Unggulan Ashidiq' }}</p>
                    <div class="mt-4 bg-primary-900/50 rounded-xl overflow-hidden h-32 flex items-center justify-center">
                        <span class="text-purple-500 text-sm">Peta Lokasi</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-primary-800 mt-10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-purple-400 text-sm">&copy; {{ date('Y') }} AKASHI — Ajang Kreasi Ashidiq &bull; SMP Muhammadiyah Unggulan Ashidiq</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('cek-pendaftaran') }}" class="text-purple-400 hover:text-white text-sm transition">Cek Pendaftaran</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        }

        // Sticky header shadow
        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            if (window.scrollY > 10) {
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('shadow-lg');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
