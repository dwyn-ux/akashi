@extends('layouts.admin')

@section('title', $competition->name)

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('admin.lomba.index') }}" class="text-sm text-primary hover:text-purple-700 font-medium">&larr; Kembali ke Daftar Lomba</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $competition->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $competition->slug }} &bull; {{ $competition->category }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.lomba.edit', $competition) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold rounded-xl transition">
            Edit
        </a>
        <form method="POST" action="{{ route('admin.lomba.destroy', $competition) }}" onsubmit="return confirm('Hapus lomba ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition">
                Hapus
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Lomba -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Lomba</h3>
            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">Kategori</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->category ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Level</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->level ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Status</dt>
                    <dd class="mt-1">
                        @if($competition->status === 'OPEN')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Dibuka</span>
                        @elseif($competition->status === 'CLOSED')
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Ditutup</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">{{ $competition->status }}</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-500">Team Size</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->team_size ?? 1 }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Kuota</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->quota ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Biaya</dt>
                    <dd class="font-medium text-gray-800 mt-1">Rp {{ number_format($competition->fee ?? 0, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Lokasi</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->location ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Jadwal</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->schedule_text ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Durasi</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->duration ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Kelas</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->grade_class ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        @if($competition->description)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi</h3>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $competition->description }}</p>
        </div>
        @endif

        @if($competition->requirements)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Persyaratan</h3>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $competition->requirements }}</p>
        </div>
        @endif

        @if($competition->rules)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Aturan</h3>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $competition->rules }}</p>
        </div>
        @endif

        <!-- Pendaftar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendaftar ({{ $competition->registrations->count() }})</h3>
            @if($competition->registrations->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">No. Registrasi</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Nama</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($competition->registrations as $reg)
                        <tr>
                            <td class="px-3 py-2 font-mono text-xs text-gray-700">{{ $reg->reg_number }}</td>
                            <td class="px-3 py-2 text-gray-800">{{ $reg->participant->full_name ?? '-' }}</td>
                            <td class="px-3 py-2">
                                @if($reg->status === 'VERIFIED')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Terverifikasi</span>
                                @elseif($reg->status === 'PENDING')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Menunggu</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">{{ $reg->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-sm text-gray-400 text-center py-4">Belum ada pendaftar untuk lomba ini.</p>
            @endif
        </div>
    </div>

    <!-- Right Column: Hadiah + Kontak -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Hadiah</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Juara 1</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->prize_1 ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Juara 2</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->prize_2 ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Juara 3</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->prize_3 ?? '-' }}</dd>
                </div>
                @if($competition->prize_extra)
                <div>
                    <dt class="text-gray-500">Hadiah Tambahan</dt>
                    <dd class="font-medium text-gray-800 mt-1">{{ $competition->prize_extra }}</dd>
                </div>
                @endif
            </dl>
        </div>

        @if($competition->contact_person)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Contact Person</h3>
            <p class="text-sm text-gray-600">{{ $competition->contact_person }}</p>
        </div>
        @endif

        @if($competition->required_docs)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Dokumen Wajib</h3>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $competition->required_docs }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
