@extends('layouts.public')

@section('title', 'Kontak')

@section('content')

<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">Kontak Kami</h1>
        <p class="text-purple-300">Hubungi kami untuk informasi lebih lanjut seputar AKASHI 2026.</p>
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- WhatsApp --}}
            <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 text-center hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </div>
                <h3 class="font-bold text-primary-900 mb-1">WhatsApp</h3>
                <p class="text-gray-500 text-sm mb-4">Hubungi kami via WhatsApp</p>
                @if($settings['whatsapp_number'] ?? null)
                <a href="https://wa.me/{{ $settings['whatsapp_number'] }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-500 text-white text-sm font-semibold rounded-xl hover:bg-green-600 transition">
                    Chat Sekarang
                </a>
                @else
                <span class="text-gray-400 text-sm">Belum tersedia</span>
                @endif
            </div>

            {{-- Instagram --}}
            <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 text-center hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </div>
                <h3 class="font-bold text-primary-900 mb-1">Instagram</h3>
                <p class="text-gray-500 text-sm mb-4">Follow kami di Instagram</p>
                <a href="https://instagram.com/{{ ltrim($settings['instagram'] ?? 'akashi.ashidiq', '@') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm font-semibold rounded-xl hover:from-pink-600 hover:to-purple-600 transition">
                    Follow
                </a>
            </div>

            {{-- Email --}}
            <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 text-center hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-accent-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-accent-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                </div>
                <h3 class="font-bold text-primary-900 mb-1">Email</h3>
                <p class="text-gray-500 text-sm mb-4">Kirim pertanyaan via email</p>
                @if($settings['email'] ?? null)
                <a href="mailto:{{ $settings['email'] }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-accent-500 text-white text-sm font-semibold rounded-xl hover:bg-accent-600 transition">
                    Kirim Email
                </a>
                @else
                <span class="text-gray-400 text-sm">Belum tersedia</span>
                @endif
            </div>
        </div>

        {{-- Address --}}
        <div class="mt-10 bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-primary-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-primary-900 mb-1">Alamat Sekolah</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $settings['address'] ?? 'SMP Muhammadiyah Unggulan Ashidiq' }}</p>
                </div>
            </div>
            <div class="mt-6 bg-gray-100 rounded-xl overflow-hidden h-64 flex items-center justify-center">
                <div class="text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                    <p class="text-sm">Peta Lokasi</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
