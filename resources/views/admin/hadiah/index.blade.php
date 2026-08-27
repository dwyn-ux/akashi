@extends('layouts.admin')

@section('title', 'Hadiah & Penghargaan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Hadiah & Penghargaan</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola informasi hadiah pemenang</p>
</div>

<!-- Add Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Hadiah</h3>
    <form method="POST" action="{{ route('admin.hadiah.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lomba <span class="text-red-500">*</span></label>
                <select name="lomba_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                    <option value="">Pilih Lomba</option>
                    @foreach($lombas ?? [] as $l)
                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Juara <span class="text-red-500">*</span></label>
                <select name="place" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                    <option value="1">Juara 1</option>
                    <option value="2">Juara 2</option>
                    <option value="3">Juara 3</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemenang <span class="text-red-500">*</span></label>
                <input type="text" name="winner_name" value="{{ old('winner_name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary hover:bg-purple-800 text-white text-sm font-semibold py-2.5 rounded-xl transition">Tambah</button>
            </div>
        </div>
    </form>
</div>

<!-- List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Lomba</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Juara</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Sekolah</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($hadiahs ?? [] as $i => $hadiah)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 text-gray-800">{{ $hadiah->lomba->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($hadiah->place == 1)
                            <span class="text-yellow-500 font-bold">Juara 1</span>
                        @elseif($hadiah->place == 2)
                            <span class="text-gray-400 font-bold">Juara 2</span>
                        @else
                            <span class="text-orange-400 font-bold">Juara 3</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-800 font-medium">{{ $hadiah->winner_name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $hadiah->school ?? '-' }}</td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('admin.hadiah.destroy', $hadiah) }}" onsubmit="return confirm('Hapus data hadiah ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.367m1.022 0a3 3 0 01-2.742-2.582l-.018-.044m-1.022 0a3 3 0 00-2.742 2.582l-.018.044m-9.478 0H21"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400">Belum ada data hadiah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
