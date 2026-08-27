@extends('layouts.admin')

@section('title', 'Data Peserta')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Peserta</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola peserta AKASHI 2026</p>
    </div>
    <form method="GET" action="{{ route('admin.peserta.index') }}" class="flex items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/NISN/sekolah..."
               class="px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
        <button type="submit" class="px-4 py-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold rounded-xl transition">Cari</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">NISN</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Sekolah</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">WhatsApp</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($participants ?? [] as $i => $peserta)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $peserta->full_name }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $peserta->nisn }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $peserta->school ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $peserta->grade_class ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $peserta->whatsapp ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if(($peserta->status ?? '') === 'terverifikasi')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Terverifikasi</span>
                        @elseif(($peserta->status ?? '') === 'pending')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Menunggu</span>
                        @elseif(($peserta->status ?? '') === 'ditolak')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Ditolak</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">{{ ucfirst($peserta->status ?? 'baru') }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.peserta.show', $peserta) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-xs font-semibold hover:bg-primary/20 transition">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center text-gray-400">Belum ada peserta terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(isset($participants) && $participants->hasPages())
<div class="mt-4">{{ $participants->links() }}</div>
@endif
@endsection
