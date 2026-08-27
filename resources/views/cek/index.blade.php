@extends('layouts.public')

@section('title', 'Cek Pendaftaran')

@section('content')

<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-12 sm:py-16">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">Cek Pendaftaran</h1>
        <p class="text-purple-300">Masukkan nomor registrasi untuk melihat status pendaftaran.</p>
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Search Form --}}
        <form method="GET" action="{{ route('cek-pendaftaran') }}" class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100 mb-8">
            <label for="reg_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Registrasi</label>
            <div class="flex gap-3">
                <input type="text" name="reg_number" id="reg_number" value="{{ request('reg_number') }}" placeholder="REG-XXX-000-0000" class="flex-1 rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 text-sm" required>
                <button type="submit" class="px-6 py-2.5 bg-primary-900 text-white font-semibold rounded-xl hover:bg-primary-800 transition text-sm whitespace-nowrap">
                    Cek
                </button>
            </div>
        </form>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-2xl p-5 text-center">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        {{-- Results --}}
        @if(request('reg_number'))
            @if($registration)
            <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100">
                <div class="bg-primary-900 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-accent-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <div class="text-white font-bold">Pendaftaran Ditemukan</div>
                            <div class="text-purple-300 text-sm">{{ $registration->reg_number }}</div>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Nama Peserta</div>
                            <div class="font-semibold text-primary-900">{{ $registration->participant->full_name ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Lomba</div>
                            <div class="font-semibold text-primary-900">{{ $registration->competition->name ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Status</div>
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                {{ $registration->status === 'VERIFIED' ? 'bg-green-100 text-green-700' : ($registration->status === 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $registration->status }}
                            </span>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Tanggal Daftar</div>
                            <div class="text-sm text-gray-700">{{ $registration->created_at->translatedFormat('d F Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <a href="{{ route('kartu.show', $registration->reg_number) }}" class="text-primary-900 font-semibold text-sm hover:text-accent-600 transition inline-flex items-center gap-1">
                        Lihat Kartu Peserta
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <h3 class="text-lg font-bold text-gray-400 mb-2">Tidak Ditemukan</h3>
                <p class="text-gray-400 text-sm">Nomor registrasi <strong>{{ request('reg_number') }}</strong> tidak ditemukan. Pastikan nomor sudah benar.</p>
            </div>
            @endif
        @endif
    </div>
</section>

@endsection
