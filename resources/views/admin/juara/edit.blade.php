@extends('layouts.admin')

@section('title', 'Edit Juara: ' . ($juara->title ?? ''))

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.juara.index') }}" class="text-sm text-primary hover:text-purple-700 font-medium">&larr; Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Juara</h1>
</div>

<form method="POST" action="{{ route('admin.juara.update', $juara) }}" class="max-w-3xl space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Info Juara</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                <input type="number" name="year" value="{{ old('year', $juara->year) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lomba</label>
                <select name="competition_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                    <option value="">— Pilih Lomba —</option>
                    @foreach($lombas as $lomba)
                    <option value="{{ $lomba->id }}" {{ old('competition_id', $juara->competition_id) == $lomba->id ? 'selected' : '' }}>{{ $lomba->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $juara->title) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="body" rows="2"
                      class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('body', $juara->body) }}</textarea>
        </div>
        <div class="mt-4 flex items-center gap-2">
            <input type="checkbox" name="published" value="1" {{ old('published', $juara->published) ? 'checked' : '' }} class="rounded border-gray-300 text-primary focus:ring-primary">
            <label class="text-sm text-gray-700">Publish</label>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Juara</h3>
            <button type="button" onclick="addWinner('edit')" class="text-xs text-primary font-semibold hover:underline">+ Tambah Juara</button>
        </div>
        <div id="edit-winners" class="space-y-3">
            @foreach($juara->winners->sortBy('place') as $i => $winner)
            <div class="winner-row grid grid-cols-12 gap-2 items-end">
                <div class="col-span-2">
                    <select name="winners[{{ $i }}][place]" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none">
                        <option value="1" {{ $winner->place == 1 ? 'selected' : '' }}>Juara 1</option>
                        <option value="2" {{ $winner->place == 2 ? 'selected' : '' }}>Juara 2</option>
                        <option value="3" {{ $winner->place == 3 ? 'selected' : '' }}>Juara 3</option>
                    </select>
                </div>
                <div class="col-span-4">
                    <input type="text" name="winners[{{ $i }}][participant_name]" value="{{ $winner->participant_name }}" required class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Nama peserta">
                </div>
                <div class="col-span-4">
                    <input type="text" name="winners[{{ $i }}][school]" value="{{ $winner->school }}" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Asal sekolah">
                </div>
                <div class="col-span-1">
                    <input type="text" name="winners[{{ $i }}][note]" value="{{ $winner->note }}" class="w-full px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none" placeholder="Note">
                </div>
                <div class="col-span-1">
                    <button type="button" onclick="this.closest('.winner-row').remove()" class="w-full px-2 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs transition">✕</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.juara.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Batal</a>
        <button type="submit" class="px-6 py-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold rounded-xl transition">Simpan Perubahan</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
let winnerCount = {{ $juara->winners->count() }};
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
