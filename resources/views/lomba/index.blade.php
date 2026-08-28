@extends('layouts.public')

@section('title', 'Lomba')

@section('content')

{{-- HERO --}}
<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4">Temukan Lombamu</h1>
        <p class="text-purple-300 max-w-lg mx-auto">Pilih dari berbagai kompetisi yang tersedia. Tunjukkan bakat dan kemampuanmu!</p>
    </div>
</section>

{{-- LOMBA GRID --}}
<section class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
            $categories = $competitions->groupBy('category');
            $categoryOrder = ['Akademik', 'Religi', 'Bahasa', 'Seni'];
            $sortedCategories = $categories->sortBy(fn($v, $k) => array_search($k, $categoryOrder) !== false ? array_search($k, $categoryOrder) : 99);
        @endphp

        @forelse($sortedCategories as $category => $lombas)
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-8 bg-accent-500 rounded-full"></div>
                <h2 class="text-2xl font-extrabold text-primary-900">{{ $category }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($lombas as $lomba)
                <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    {{-- Cover --}}
                    <div class="h-40 bg-gradient-to-br from-primary-900 to-primary-700 flex items-center justify-center relative overflow-hidden">
                        @if($lomba->cover_url)
                            <img src="{{ asset('storage/' . $lomba->cover_url) }}" alt="{{ $lomba->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.015 6.015 0 01-1.77.658H13.5m5.02-.432a6.015 6.015 0 01-1.77-.658m0 0a6.015 6.015 0 01-2.48-5.228"/></svg>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full
                                {{ $lomba->status === 'OPEN' ? 'bg-green-500 text-white' : ($lomba->status === 'CLOSED' ? 'bg-gray-500/80 text-white' : 'bg-yellow-500 text-white') }}">
                                {{ $lomba->status === 'OPEN' ? 'Pendaftaran Buka' : ($lomba->status === 'CLOSED' ? 'Ditutup' : 'Draf') }}
                            </span>
                        </div>
                        @if($lomba->team_size > 1)
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-white/20 text-white backdrop-blur-sm">
                                Regu {{ $lomba->team_size }} Orang
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        <span class="inline-block self-start px-2.5 py-1 text-[11px] font-semibold bg-accent-100 text-accent-700 rounded-lg mb-2">{{ $lomba->category }}</span>
                        <h3 class="font-bold text-primary-900 text-lg mb-1">{{ $lomba->name }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">{{ $lomba->description }}</p>

                        {{-- Meta --}}
                        <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                            @if($lomba->quota)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                Kuota: {{ $lomba->quota }}
                            </span>
                            @endif
                            @if($lomba->fee !== null)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $lomba->fee > 0 ? 'Rp ' . number_format($lomba->fee, 0, ',', '.') : 'Gratis' }}
                            </span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3">
                            <a href="{{ route('lomba.show', $lomba->slug) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-900 text-white text-sm font-semibold rounded-xl hover:bg-primary-800 transition">
                                Lihat Detail
                            </a>
                            @if($lomba->status === 'OPEN' && !$finished)
                            <a href="{{ route('daftar.index') }}?lomba={{ $lomba->slug }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-accent-500 text-white text-sm font-semibold rounded-xl hover:bg-accent-600 transition">
                                Daftar
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.015 6.015 0 01-1.77.658H13.5m5.02-.432a6.015 6.015 0 01-1.77-.658m0 0a6.015 6.015 0 01-2.48-5.228"/></svg>
            <h3 class="text-xl font-bold text-gray-400 mb-2">Belum Ada Lomba</h3>
            <p class="text-gray-400 text-sm">Lomba akan segera diumumkan. Pantau terus!</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($competitions->hasPages())
        <div class="mt-12">
            {{ $competitions->links() }}
        </div>
        @endif
    </div>
</section>

@endsection
