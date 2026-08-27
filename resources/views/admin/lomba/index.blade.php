@extends('layouts.admin')

@section('title', 'Data Lomba')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Lomba</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua kompetisi AKASHI 2026</p>
    </div>
    <a href="{{ route('admin.lomba.create') }}"
       class="inline-flex items-center gap-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Tambah Lomba
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Kategori</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Team Size</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Kuota</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($lombas ?? [] as $i => $lomba)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $lomba->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-primary">{{ $lomba->category }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($lomba->status === 'OPEN')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Dibuka</span>
                        @elseif($lomba->status === 'DRAFT')
                            <span class="px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-700">Draft</span>
                        @elseif($lomba->status === 'CLOSED')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Ditutup</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">{{ $lomba->status }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-700">{{ $lomba->team_size }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $lomba->quota }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.lomba.edit', $lomba) }}" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.065a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.lomba.destroy', $lomba) }}" onsubmit="return confirm('Hapus lomba ini?')">
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
                    <td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada lomba. Klik "Tambah Lomba" untuk membuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(isset($lombas) && $lombas->hasPages())
<div class="mt-4">
    {{ $lombas->links() }}
</div>
@endif
@endsection
