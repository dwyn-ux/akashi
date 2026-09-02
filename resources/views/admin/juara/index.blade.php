@extends('layouts.admin')

@section('title', 'Data Juara')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Juara</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola pemenang lomba AKASHI 2026</p>
    </div>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold rounded-xl transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Juara
    </button>
</div>

<form method="GET" action="{{ route('admin.juara.index') }}" class="flex items-center gap-2 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama juara/lomba..."
           class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none flex-1 max-w-xs">
    <button type="submit" class="px-4 py-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold rounded-xl transition">Cari</button>
</form>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Tahun</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Judul</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Lomba</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Juara</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($juaras as $i => $juara)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500">{{ ($juaras->currentPage() - 1) * $juaras->perPage() + $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $juara->year }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $juara->title }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $juara->competition->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1">
                            @foreach($juara->winners->sortBy('place') as $winner)
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full
                                    {{ $winner->place === 1 ? 'bg-yellow-100 text-yellow-700' : ($winner->place === 2 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-700') }}">
                                    J{{ $winner->place }}: {{ Str::limit($winner->participant_name, 15) }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        @if($juara->published)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">Publish</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">Draft</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.juara.edit', $juara) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-xs font-semibold hover:bg-primary/20 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.juara.destroy', $juara) }}" onsubmit="return confirm('Hapus juara ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.367m1.022 0a3 3 0 01-2.742-2.582l-.018-.044m-1.022 0a3 3 0 00-2.742 2.582l-.018.044m-9.478 0H21"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada data juara.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($juaras->hasPages())
<div class="mt-4">{{ $juaras->links() }}</div>
@endif

{{-- Add Modal --}}
<div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('addModal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <h3 class="font-bold text-gray-800">Tambah Juara</h3>
            <button onclick="document.getElementById('addModal').classList.add('hidden')" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.juara.store') }}" class="p-6 space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="year" value="{{ date('Y') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lomba</label>
                    <select name="competition_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        <option value="">— Pilih Lomba —</option>
                        @foreach($lombas as $lomba)
                        <option value="{{ $lomba->id }}">{{ $lomba->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="contoh: Juara Olimpiade IPAS 2026"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="body" rows="2" placeholder="Catatan opsional..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none"></textarea>
            </div>

            {{-- Winners --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-medium text-gray-700">Daftar Juara</label>
                    <button type="button" onclick="addWinner('add')" class="text-xs text-primary font-semibold hover:underline">+ Tambah Juara</button>
                </div>
                <div id="add-winners" class="space-y-3">
                    <div class="winner-row grid grid-cols-12 gap-2 items-end">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-medium text-gray-500 mb-1">Juara</label>
                            <select name="winners[0][place]" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none">
                                <option value="1">Juara 1</option>
                                <option value="2">Juara 2</option>
                                <option value="3">Juara 3</option>
                            </select>
                        </div>
                        <div class="col-span-4">
                            <label class="block text-[10px] font-medium text-gray-500 mb-1">Nama <span class="text-red-500">*</span></label>
                            <input type="text" name="winners[0][participant_name]" required class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Nama peserta">
                        </div>
                        <div class="col-span-4">
                            <label class="block text-[10px] font-medium text-gray-500 mb-1">Sekolah</label>
                            <input type="text" name="winners[0][school]" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Asal sekolah">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-medium text-gray-500 mb-1">Note</label>
                            <input type="text" name="winners[0][note]" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Opsional">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="published" value="1" id="published-add" checked class="rounded border-gray-300 text-primary focus:ring-primary">
                <label for="published-add" class="text-sm text-gray-700">Publish</label>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Batal</button>
                <button type="submit" class="px-6 py-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold rounded-xl transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let winnerCount = 1;
function addWinner(prefix) {
    const container = document.getElementById(prefix + '-winners');
    const row = document.createElement('div');
    row.className = 'winner-row grid grid-cols-12 gap-2 items-end';
    row.innerHTML = `
        <div class="col-span-2">
            <select name="winners[${winnerCount}][place]" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none">
                <option value="1">Juara 1</option>
                <option value="2">Juara 2</option>
                <option value="3">Juara 3</option>
            </select>
        </div>
        <div class="col-span-4">
            <input type="text" name="winners[${winnerCount}][participant_name]" required class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Nama peserta">
        </div>
        <div class="col-span-4">
            <input type="text" name="winners[${winnerCount}][school]" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Asal sekolah">
        </div>
        <div class="col-span-1">
            <input type="text" name="winners[${winnerCount}][note]" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Note">
        </div>
        <div class="col-span-1">
            <button type="button" onclick="this.closest('.winner-row').remove()" class="w-full px-2 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs transition">✕</button>
        </div>
    `;
    container.appendChild(row);
    winnerCount++;
}
</script>
@endpush
