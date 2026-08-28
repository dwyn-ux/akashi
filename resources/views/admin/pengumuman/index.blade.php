@extends('layouts.admin')

@section('title', 'Pengumuman & Pemenang')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengumuman & Pemenang</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola pengumuman resmi dan data pemenang</p>
</div>

<!-- Add Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Pengumuman</h3>
    <form method="POST" action="{{ route('admin.pengumuman.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                <input type="number" name="year" value="{{ old('year', date('Y')) }}" required min="2020" max="2030"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lomba (opsional)</label>
                <select name="competition_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                    <option value="">Umum / Semua</option>
                    @foreach($lombas ?? [] as $l)
                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-3">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="published" value="1" {{ old('published') ? 'checked' : '' }} id="pub" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="pub" class="text-sm text-gray-700">Terbitkan</label>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                <textarea name="body" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('body') }}</textarea>
            </div>
        </div>
        <button type="submit" class="bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">Simpan</button>
    </form>
</div>

<!-- List -->
<div class="space-y-4">
    @forelse($pengumumans ?? [] as $pengumuman)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 text-xs rounded-full bg-purple-100 text-primary font-semibold">{{ $pengumuman->year }}</span>
                        @if($pengumuman->published)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Diterbitkan</span>
                        @else
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">Draft</span>
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-800">{{ $pengumuman->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $pengumuman->body }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.pengumuman.destroy', $pengumuman) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.367m1.022 0a3 3 0 01-2.742-2.582l-.018-.044m-1.022 0a3 3 0 00-2.742 2.582l-.018.044m-9.478 0H21"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Winner Rows -->
            @if(isset($pengumuman->winners) && $pengumuman->winners->count())
            <div class="mt-4 pt-4 border-t border-gray-100">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Pemenang</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Juara</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Nama</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Sekolah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pengumuman->winners as $winner)
                            <tr>
                                <td class="px-3 py-2">
                                    @if($winner->place == 1)
                                        <span class="text-yellow-500 font-bold">Juara 1</span>
                                    @elseif($winner->place == 2)
                                        <span class="text-gray-400 font-bold">Juara 2</span>
                                    @elseif($winner->place == 3)
                                        <span class="text-orange-400 font-bold">Juara 3</span>
                                    @else
                                        <span class="text-gray-500">Juara {{ $winner->place }}</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-gray-800">{{ $winner->name }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $winner->school ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
        Belum ada pengumuman.
    </div>
    @endforelse
</div>
@endsection
