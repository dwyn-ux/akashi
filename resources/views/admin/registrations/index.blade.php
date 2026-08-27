@extends('layouts.admin')

@section('title', 'Data Pendaftaran')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Pendaftaran</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola seluruh pendaftaran peserta</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.export.pendaftaran', request()->only(['status', 'competition_id'])) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Export CSV
        </a>
        <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()"
                    class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white">
                <option value="">Semua Status</option>
                @foreach(['PENDING', 'VERIFIED', 'REJECTED'] as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. registrasi/nama..."
                   class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            <button type="submit" class="px-4 py-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold rounded-xl transition">Cari</button>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">No. Registrasi</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama Peserta</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Lomba</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($registrations ?? [] as $i => $reg)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500">{{ ($registrations->currentPage() - 1) * $registrations->perPage() + $i + 1 }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $reg->reg_number }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $reg->participant->full_name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $reg->competition->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($reg->status === 'VERIFIED')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Terverifikasi</span>
                        @elseif($reg->status === 'PENDING')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Menunggu</span>
                        @elseif($reg->status === 'REJECTED')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Ditolak</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">{{ $reg->status }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs">{{ $reg->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.registrations.show', $reg) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-xs font-semibold hover:bg-primary/20 transition">
                                Detail
                            </a>
                            <form method="POST" action="{{ route('admin.registrations.destroy', $reg) }}" onsubmit="return confirm('Hapus registrasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.367m1.022 0a3 3 0 01-2.742-2.582l-.018-.044m-1.022 0a3 3 0 00-2.742 2.582l-.018.044m-9.478 0H21"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(isset($registrations) && $registrations->hasPages())
<div class="mt-4">{{ $registrations->links() }}</div>
@endif
@endsection
