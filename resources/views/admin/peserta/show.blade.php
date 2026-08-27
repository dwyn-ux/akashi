@extends('layouts.admin')

@section('title', 'Detail Peserta: ' . ($participant->full_name ?? ''))

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('admin.peserta.index') }}" class="text-sm text-primary hover:text-purple-700 font-medium">&larr; Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Peserta</h1>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Biodata -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Biodata Peserta</h3>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-gray-500">Nama Lengkap</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->full_name ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">NISN</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->nisn ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Jenis Kelamin</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->gender ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Tempat, Tanggal Lahir</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->birth_place ?? '-' }}, {{ $participant->birth_date ? \Carbon\Carbon::parse($participant->birth_date)->translatedFormat('d F Y') : '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Sekolah</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->school ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Kelas</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->grade_class ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Alamat</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->address ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">WhatsApp</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->whatsapp ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Email</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->email ?? '-' }}</dd>
            </div>
            @if($participant->guardian)
            <div class="flex justify-between">
                <dt class="text-gray-500">Pendamping</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->guardian }} ({{ $participant->guardian_rel }})</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">WA Pendamping</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $participant->guardian_wa }}</dd>
            </div>
            @endif
        </dl>
    </div>

    <!-- Registrasi -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Registrasi</h3>
            @if($participant->registrations->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">No. Registrasi</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Lomba</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Status</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Tanggal</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($participant->registrations as $reg)
                        <tr>
                            <td class="px-3 py-2 font-mono text-xs text-gray-700">{{ $reg->reg_number }}</td>
                            <td class="px-3 py-2 text-gray-800">{{ $reg->competition->name ?? '-' }}</td>
                            <td class="px-3 py-2">
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
                            <td class="px-3 py-2 text-gray-600 text-xs">{{ $reg->created_at->format('d M Y') }}</td>
                            <td class="px-3 py-2">
                                <a href="{{ route('admin.registrations.show', $reg) }}" class="text-xs text-primary hover:text-purple-700 font-semibold">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-sm text-gray-400 text-center py-4">Belum ada registrasi.</p>
            @endif
        </div>

        <!-- Status Update -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Status</h3>
            <form method="POST" action="{{ route('admin.peserta.update-status', $participant) }}">
                @csrf
                @method('PATCH')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            @foreach(['baru', 'pending', 'terverifikasi', 'ditolak'] as $st)
                                <option value="{{ $st }}" {{ ($participant->status ?? 'baru') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-primary hover:bg-purple-800 text-white font-semibold py-2.5 px-6 rounded-xl transition text-sm">
                        Simpan Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
            <h3 class="text-lg font-semibold text-red-600 mb-2">Zona Berbahaya</h3>
            <p class="text-sm text-gray-500 mb-4">Menghapus data peserta tidak dapat dibatalkan.</p>
            <form method="POST" action="{{ route('admin.peserta.destroy', $participant) }}" onsubmit="return confirm('Yakin ingin menghapus peserta ini? Data tidak dapat dikembalikan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-6 rounded-xl transition text-sm">
                    Hapus Peserta
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
