@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Pengumuman</h1>
    <p class="text-sm text-gray-500 mt-1">Perbarui data pengumuman & pemenang</p>
</div>

<form method="POST" action="{{ route('admin.pengumuman.update', $announcement) }}">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengumuman</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                <input type="number" name="year" value="{{ old('year', $announcement->year) }}" required min="2020" max="2030"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                @error('year') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lomba (opsional)</label>
                <select name="competition_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                    <option value="">Umum / Semua</option>
                    @foreach($lombas as $l)
                        <option value="{{ $l->id }}" {{ old('competition_id', $announcement->competition_id) == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-3">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="published" value="1" {{ old('published', $announcement->published) ? 'checked' : '' }} id="pub" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="pub" class="text-sm text-gray-700">Terbitkan</label>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                <textarea name="body" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('body', $announcement->body) }}</textarea>
            </div>
        </div>
    </div>

    <!-- Winners -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pemenang</h3>
            <button type="button" onclick="addWinner()" class="text-sm text-primary font-semibold hover:underline">+ Tambah Pemenang</button>
        </div>
        <div id="winners-container" class="space-y-4">
            @if($announcement->winners->count())
                @foreach($announcement->winners as $i => $winner)
                <div class="winner-row grid grid-cols-1 md:grid-cols-4 gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200 relative">
                    <button type="button" onclick="this.closest('.winner-row').remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-600 text-xs">✕ Hapus</button>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Juara</label>
                        <select name="winners[{{ $i }}][place]" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                            @foreach([1,2,3,4,5] as $p)
                                <option value="{{ $p }}" {{ $winner->place == $p ? 'selected' : '' }}>Juara {{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama</label>
                        <input type="text" name="winners[{{ $i }}][participant_name]" value="{{ $winner->participant_name }}" placeholder="Nama peserta"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Sekolah</label>
                        <input type="text" name="winners[{{ $i }}][school]" value="{{ $winner->school }}" placeholder="Asal sekolah"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Catatan</label>
                        <input type="text" name="winners[{{ $i }}][note]" value="{{ $winner->note }}" placeholder="Opsional"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Submit -->
    <div class="flex items-center gap-4">
        <button type="submit" class="bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition shadow-sm">
            Simpan Perubahan
        </button>
        <a href="{{ route('admin.pengumuman.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
let winnerIndex = {{ $announcement->winners->count() }};

function addWinner() {
    const container = document.getElementById('winners-container');
    const html = `
    <div class="winner-row grid grid-cols-1 md:grid-cols-4 gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200 relative">
        <button type="button" onclick="this.closest('.winner-row').remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-600 text-xs">✕ Hapus</button>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Juara</label>
            <select name="winners[${winnerIndex}][place]" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                <option value="1">Juara 1</option>
                <option value="2">Juara 2</option>
                <option value="3">Juara 3</option>
                <option value="4">Juara 4</option>
                <option value="5">Juara 5</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Nama</label>
            <input type="text" name="winners[${winnerIndex}][participant_name]" placeholder="Nama peserta"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Sekolah</label>
            <input type="text" name="winners[${winnerIndex}][school]" placeholder="Asal sekolah"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Catatan</label>
            <input type="text" name="winners[${winnerIndex}][note]" placeholder="Opsional"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    winnerIndex++;
}
</script>
@endpush
