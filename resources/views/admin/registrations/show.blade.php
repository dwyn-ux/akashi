@extends('layouts.admin')

@section('title', 'Detail Pendaftaran: ' . ($registration->reg_number ?? ''))

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.registrations.index') }}" class="text-sm text-primary hover:text-purple-700 font-medium">&larr; Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Pendaftaran</h1>
    <p class="text-sm text-gray-500 mt-1">{{ $registration->reg_number }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Biodata -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Biodata Peserta</h3>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-gray-500">Nama Lengkap</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->full_name ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">NISN</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->nisn ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Jenis Kelamin</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->gender ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">TTL</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->birth_place ?? '-' }}, {{ $registration->participant->birth_date ? \Carbon\Carbon::parse($registration->participant->birth_date)->translatedFormat('d F Y') : '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Sekolah</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->school ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Kelas</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->grade_class ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">WhatsApp</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->whatsapp ?? '-' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Email</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->email ?? '-' }}</dd>
            </div>
            @if($registration->participant->guardian)
            <div class="flex justify-between">
                <dt class="text-gray-500">Pendamping</dt>
                <dd class="font-medium text-gray-800 text-right">{{ $registration->participant->guardian }} ({{ $registration->participant->guardian_rel }})</dd>
            </div>
            @endif
        </dl>
    </div>

    <!-- Info Lomba + Anggota -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Info Lomba</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Lomba</dt>
                    <dd class="font-medium text-gray-800 text-right">{{ $registration->competition->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kategori</dt>
                    <dd class="font-medium text-gray-800 text-right">{{ $registration->competition->category ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Biaya</dt>
                    <dd class="font-medium text-gray-800 text-right">Rp {{ number_format($registration->competition->fee ?? 0, 0, ',', '.') }}</dd>
                </div>
                @if($registration->extra_choice)
                <div class="flex justify-between">
                    <dt class="text-gray-500">Pilihan Tambahan</dt>
                    <dd class="font-medium text-gray-800 text-right">{{ $registration->extra_choice }}</dd>
                </div>
                @endif
            </dl>
        </div>

        @if($registration->members->count())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Anggota Regu</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">#</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Nama</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">NISN</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Kelas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($registration->members as $j => $member)
                        <tr>
                            <td class="px-3 py-2 text-gray-500">{{ $j + 1 }}</td>
                            <td class="px-3 py-2 text-gray-800">{{ $member->full_name }}</td>
                            <td class="px-3 py-2 text-gray-700">{{ $member->nisn }}</td>
                            <td class="px-3 py-2 text-gray-700">{{ $member->grade_class ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Status Update -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Status</h3>
            <form method="POST" action="{{ route('admin.registrations.update', $registration) }}">
                @csrf
                @method('PATCH')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            @foreach(['PENDING', 'VERIFIED', 'REJECTED'] as $st)
                                <option value="{{ $st }}" {{ $registration->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                        <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            @foreach(['NONE', 'UNPAID', 'PAID'] as $ps)
                                <option value="{{ $ps }}" {{ ($registration->payment_status ?? 'NONE') === $ps ? 'selected' : '' }}>{{ $ps }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin</label>
                        <textarea name="admin_note" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('admin_note', $registration->admin_note ?? '') }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-purple-800 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                        Simpan Status
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
            <h3 class="text-lg font-semibold text-red-600 mb-2">Zona Berbahaya</h3>
            <p class="text-sm text-gray-500 mb-4">Menghapus registrasi tidak dapat dibatalkan.</p>
            <form method="POST" action="{{ route('admin.registrations.destroy', $registration) }}" onsubmit="return confirm('Yakin ingin menghapus registrasi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                    Hapus Registrasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
