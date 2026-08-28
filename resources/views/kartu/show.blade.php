@extends('layouts.public')

@section('title', 'Kartu Peserta — ' . $registration->reg_number)

@section('content')

@if(session('success'))
<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-2xl p-6 text-center print:hidden">
        <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-semibold text-lg mb-1">{{ session('success') }}</p>
        <p class="text-sm text-green-600">Dialog cetak akan muncul secara otomatis...</p>
    </div>
</div>
@endif

<section class="py-8 sm:py-12 print:py-0">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Print Button --}}
        <div class="mb-6 flex items-center justify-between print:hidden">
            <a href="{{ route('cek-pendaftaran') }}" class="inline-flex items-center gap-2 text-sm text-primary-900 font-semibold hover:text-accent-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                Kembali
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('kartu.pdf', $registration->reg_number) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-accent-500 text-white text-sm font-semibold rounded-xl hover:bg-accent-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Unduh PDF
                </a>
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-900 text-white text-sm font-semibold rounded-xl hover:bg-primary-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.75 12h.008v.008h-.008V12zm-3 0h.008v.008h-.008V12z"/></svg>
                    Cetak
                </button>
            </div>
        </div>

        {{-- Card --}}
        <div id="kartu-peserta" class="bg-white rounded-3xl overflow-hidden shadow-2xl border border-gray-200 print:shadow-none print:rounded-none print:border-0">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-primary-900 to-primary-800 px-6 py-5 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-accent-400 rounded-full blur-2xl"></div>
                </div>
                <div class="relative flex items-center gap-3">
                    @if(!empty($settings['site_logo']))
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['event_name'] ?? 'AKASHI' }}" class="w-11 h-11 rounded-xl object-contain bg-white/10">
                    @else
                        <div class="w-11 h-11 bg-accent-500 rounded-xl flex items-center justify-center font-extrabold text-lg">A</div>
                    @endif
                    <div>
                        <div class="font-bold text-lg leading-tight">{{ $settings['event_name'] ?? 'AKASHI 2026' }}</div>
                        <div class="text-purple-300 text-xs">Ajang Kreasi Ashidiq &bull; {{ $settings['school_name'] ?? 'SMP Muhammadiyah Unggulan Ashidiq' }}</div>
                    </div>
                </div>
            </div>

            {{-- Reg Number --}}
            <div class="bg-accent-50 px-6 py-4 text-center border-b border-accent-100">
                <div class="text-[11px] text-accent-700 font-semibold uppercase tracking-widest mb-1">Nomor Registrasi</div>
                <div class="text-2xl sm:text-3xl font-extrabold text-primary-900 tracking-wider">{{ $registration->reg_number }}</div>
            </div>

            <div class="px-6 py-5 space-y-5">

                {{-- Biodata --}}
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Biodata Peserta</h3>
                    <div class="space-y-2.5">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Nama</span>
                            <span class="font-semibold text-primary-900">{{ $registration->participant->full_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">NISN</span>
                            <span class="font-medium text-gray-800">{{ $registration->participant->nisn ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jenis Kelamin</span>
                            <span class="font-medium text-gray-800">{{ $registration->participant->gender ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tempat, Tanggal Lahir</span>
                            <span class="font-medium text-gray-800 text-right">{{ $registration->participant->birth_place ?? '-' }}, {{ $registration->participant->birth_date ? \Carbon\Carbon::parse($registration->participant->birth_date)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Sekolah</span>
                            <span class="font-medium text-gray-800">{{ $registration->participant->school ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Kelas</span>
                            <span class="font-medium text-gray-800">{{ $registration->participant->grade_class ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">WhatsApp</span>
                            <span class="font-medium text-gray-800">{{ $registration->participant->whatsapp ?? '-' }}</span>
                        </div>
                        @if($registration->participant->guardian)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Pendamping</span>
                            <span class="font-medium text-gray-800">{{ $registration->participant->guardian }} ({{ $registration->participant->guardian_rel }})</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Team Members --}}
                @if($registration->members->count())
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Anggota Regu</h3>
                    <div class="space-y-2">
                        @foreach($registration->members as $member)
                        <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                            <div class="font-semibold text-primary-900 text-sm">{{ $member->full_name }}</div>
                            <div class="text-xs text-gray-500">NISN: {{ $member->nisn }} &bull; {{ $member->grade_class }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Competition Info --}}
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Informasi Lomba</h3>
                    <div class="bg-primary-50 rounded-xl px-4 py-3 border border-primary-100 space-y-1.5">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Lomba</span>
                            <span class="font-semibold text-primary-900">{{ $registration->competition->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-medium text-gray-800">{{ $registration->competition->category ?? '-' }}</span>
                        </div>
                        @if($registration->competition)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Format</span>
                            <span class="font-medium text-gray-800">{{ ($registration->competition->team_size ?? 1) > 1 ? 'Regu ' . $registration->competition->team_size . ' Orang' : 'Individu' }}</span>
                        </div>
                        @endif
                        @if($registration->competition && $registration->competition->fee)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Biaya</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($registration->competition->fee, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if($registration->competition && $registration->competition->schedule_text)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jadwal</span>
                            <span class="font-medium text-gray-800 text-right">{{ $registration->competition->schedule_text }}</span>
                        </div>
                        @endif
                        @if($registration->competition && $registration->competition->location)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Lokasi</span>
                            <span class="font-medium text-gray-800">{{ $registration->competition->location }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 font-medium">Wajib dibawa pada hari-H &bull; Tunjukkan kartu ini di meja registrasi</p>
                <p class="text-[10px] text-gray-300 mt-1">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    @media print {
        body { background: white !important; }
        #main-header, footer, .print\:hidden, nav, button { display: none !important; }
        .print\:py-0 { padding-top: 0 !important; padding-bottom: 0 !important; }
        .print\:shadow-none { box-shadow: none !important; }
        .print\:rounded-none { border-radius: 0 !important; }
        .print\:border-0 { border: none !important; }
        #kartu-peserta { break-inside: avoid; }
    }
</style>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            window.print();
        }, 1500);
    });
</script>
@endif
@endpush
