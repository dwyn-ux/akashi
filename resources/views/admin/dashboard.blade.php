@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-sm text-gray-500 mt-1">Selamat datang di panel admin AKASHI 2026</p>
</div>

<!-- Primary Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Lomba</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalLomba ?? 0 }}</p>
            </div>
            <div class="w-11 h-11 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.015 6.015 0 01-1.77.658H13.5m5.02-.432a6.015 6.015 0 01-1.77-.658m0 0a6.015 6.015 0 01-2.48-5.228"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Peserta</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPeserta ?? 0 }}</p>
            </div>
            <div class="w-11 h-11 bg-cyan-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pendaftaran Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendaftaranHariIni ?? 0 }}</p>
            </div>
            <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Terverifikasi</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $terverifikasi ?? 0 }}</p>
            </div>
            <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-yellow-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $menungguVerifikasi ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Ditolak</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $ditolak ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
