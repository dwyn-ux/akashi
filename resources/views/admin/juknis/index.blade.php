@extends('layouts.admin')

@section('title', 'Juknis & Dokumentasi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Juknis & Dokumentasi</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola panduan teknis dan dokumentasi acara</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Juknis -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Juknis (Petunjuk Teknis)</h3>
        <form method="POST" action="{{ route('admin.juknis.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="juknis">
            <div>
                <textarea name="content" rows="16"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none font-mono">{{ old('content', $juknis ?? '') }}</textarea>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs text-gray-400">Terakhir diperbarui: {{ $juknisUpdatedAt ?? '-' }}</p>
                <button type="submit" class="bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                    Simpan Juknis
                </button>
            </div>
        </form>
    </div>

    <!-- Dokumentasi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumentasi</h3>
        <form method="POST" action="{{ route('admin.juknis.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="dokumentasi">
            <div>
                <textarea name="content" rows="16"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none font-mono">{{ old('content', $dokumentasi ?? '') }}</textarea>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs text-gray-400">Terakhir diperbarui: {{ $dokumentasiUpdatedAt ?? '-' }}</p>
                <button type="submit" class="bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                    Simpan Dokumentasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
