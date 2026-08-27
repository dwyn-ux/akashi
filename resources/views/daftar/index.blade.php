@extends('layouts.public')

@section('title', 'Daftar Lomba')

@section('content')

<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-12 sm:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">Pendaftaran Lomba</h1>
        <p class="text-purple-300">Isi data diri dengan lengkap dan benar.</p>
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 text-green-700 rounded-2xl p-6 text-center">
            <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="font-semibold text-lg mb-1">{{ session('success') }}</p>
            <a href="{{ route('cek-pendaftaran') }}" class="text-primary-900 font-semibold text-sm underline">Cek Status Pendaftaran</a>
        </div>
        @endif

        <form method="POST" action="{{ route('daftar.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Pilih Lomba --}}
            <div class="bg-card rounded-xl border shadow-sm p-6 sm:p-8">
                <h2 class="text-lg font-extrabold text-foreground mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-primary text-primary-foreground rounded-md flex items-center justify-center text-sm font-bold">1</span>
                    Pilih Lomba
                </h2>
                <div>
                    <label for="competition_id" class="block text-sm font-medium text-foreground mb-2">Lomba <span class="text-destructive">*</span></label>
                    <select name="competition_id" id="competition_id" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required onchange="handleLombaChange(this)">
                        <option value="">— Pilih Lomba —</option>
                        @foreach($competitions as $lomba)
                        <option value="{{ $lomba->id }}" data-team-size="{{ $lomba->team_size }}" data-required-docs="{{ $lomba->required_docs ?? '' }}" {{ old('competition_id') == $lomba->id ? 'selected' : '' }}>
                            {{ $lomba->name }} ({{ $lomba->category }}){{ $lomba->fee > 0 ? ' — Rp ' . number_format($lomba->fee, 0, ',', '.') : ' — Gratis' }}
                        </option>
                        @endforeach
                    </select>
                    @error('competition_id')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Data Peserta (Ketua) --}}
            <div class="bg-card rounded-xl border shadow-sm p-6 sm:p-8">
                <h2 class="text-lg font-extrabold text-foreground mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-primary text-primary-foreground rounded-md flex items-center justify-center text-sm font-bold">2</span>
                    Data Peserta (Ketua)
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-foreground mb-1">Nama Lengkap <span class="text-destructive">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('full_name')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">NISN <span class="text-destructive">*</span></label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('nisn')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">Jenis Kelamin <span class="text-destructive">*</span></label>
                        <select name="gender" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                            <option value="">— Pilih —</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">Tempat Lahir <span class="text-destructive">*</span></label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('birth_place')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">Tanggal Lahir <span class="text-destructive">*</span></label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('birth_date')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">Asal Sekolah <span class="text-destructive">*</span></label>
                        <input type="text" name="school" value="{{ old('school', 'SMP Muhammadiyah Unggulan Ashidiq') }}" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('school')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">Kelas <span class="text-destructive">*</span></label>
                        <input type="text" name="grade_class" value="{{ old('grade_class') }}" placeholder="contoh: 8A" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('grade_class')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">WhatsApp <span class="text-destructive">*</span></label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxx" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('whatsapp')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors">
                        @error('email')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-foreground mb-1">Alamat <span class="text-destructive">*</span></label>
                        <textarea name="address" rows="2" class="flex min-h-[80px] w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>{{ old('address') }}</textarea>
                        @error('address')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Anggota Regu --}}
            <div id="members-section" class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100 hidden">
                <h2 class="text-lg font-extrabold text-foreground mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-primary text-primary-foreground rounded-md flex items-center justify-center text-sm font-bold">3</span>
                    Anggota Regu
                </h2>
                <div id="members-fields" class="space-y-6">
                </div>
            </div>

            {{-- Dokumen --}}
            <div id="docs-section" class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100 hidden">
                <h2 class="text-lg font-extrabold text-primary-900 mb-2 flex items-center gap-2">
                    <span class="w-8 h-8 bg-primary text-primary-foreground rounded-md flex items-center justify-center text-sm font-bold">4</span>
                    Dokumen
                </h2>
                <p class="text-sm text-gray-500 mb-6">Unggah dokumen yang diperlukan.</p>
                <div id="docs-fields" class="space-y-4">
                </div>
            </div>

            {{-- Data Orang Tua/Pendamping --}}
            <div class="bg-card rounded-xl border shadow-sm p-6 sm:p-8">
                <h2 class="text-lg font-extrabold text-foreground mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-primary text-primary-foreground rounded-md flex items-center justify-center text-sm font-bold" id="step-docs">4</span>
                    Data Orang Tua / Pendamping
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-foreground mb-1">Nama <span class="text-destructive">*</span></label>
                        <input type="text" name="guardian" value="{{ old('guardian') }}" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('guardian')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">Hubungan <span class="text-destructive">*</span></label>
                        <input type="text" name="guardian_rel" value="{{ old('guardian_rel') }}" placeholder="contoh: Ayah" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('guardian_rel')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-1">WhatsApp <span class="text-destructive">*</span></label>
                        <input type="text" name="guardian_wa" value="{{ old('guardian_wa') }}" placeholder="08xxx" class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-0 focus:bg-background transition-colors" required>
                        @error('guardian_wa')<p class="text-destructive text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('lomba.index') }}" class="px-6 py-3 text-sm font-medium text-gray-600 hover:text-primary-900 transition">Batal</a>
                <button type="submit" class="px-8 py-3 bg-primary-900 text-white font-semibold rounded-xl hover:bg-primary-800 transition shadow-lg shadow-primary-900/25">
                    Kirim Pendaftaran
                </button>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
const competitions = @json($competitions);

function handleLombaChange(select) {
    const id = select.value;
    const lomba = competitions.find(c => c.id == id);
    const membersSection = document.getElementById('members-section');
    const membersFields = document.getElementById('members-fields');
    const docsSection = document.getElementById('docs-section');
    const docsFields = document.getElementById('docs-fields');

    membersFields.innerHTML = '';
    docsFields.innerHTML = '';

    if (!lomba) {
        membersSection.classList.add('hidden');
        docsSection.classList.add('hidden');
        return;
    }

    // Members
    const teamSize = lomba.team_size || 1;
    if (teamSize > 1) {
        membersSection.classList.remove('hidden');
        let html = '';
        for (let i = 2; i <= teamSize; i++) {
            html += `
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                <h3 class="font-semibold text-primary-900 mb-4 text-sm">Anggota ${i}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Lengkap <span class="text-destructive">*</span></label>
                        <input type="text" name="members[${i-2}][full_name]" class="flex h-9 w-full rounded-md border border-input bg-muted px-3 py-1.5 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:bg-background transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">NISN <span class="text-destructive">*</span></label>
                        <input type="text" name="members[${i-2}][nisn]" class="flex h-9 w-full rounded-md border border-input bg-muted px-3 py-1.5 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:bg-background transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Kelamin <span class="text-destructive">*</span></label>
                        <select name="members[${i-2}][gender]" class="flex h-9 w-full rounded-md border border-input bg-muted px-3 py-1.5 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:bg-background transition-colors" required>
                            <option value="">— Pilih —</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tempat Lahir <span class="text-destructive">*</span></label>
                        <input type="text" name="members[${i-2}][birth_place]" class="flex h-9 w-full rounded-md border border-input bg-muted px-3 py-1.5 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:bg-background transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Lahir <span class="text-destructive">*</span></label>
                        <input type="date" name="members[${i-2}][birth_date]" class="flex h-9 w-full rounded-md border border-input bg-muted px-3 py-1.5 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:bg-background transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Asal Sekolah <span class="text-destructive">*</span></label>
                        <input type="text" name="members[${i-2}][school]" value="SMP Muhammadiyah Unggulan Ashidiq" class="flex h-9 w-full rounded-md border border-input bg-muted px-3 py-1.5 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:bg-background transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kelas <span class="text-destructive">*</span></label>
                        <input type="text" name="members[${i-2}][grade_class]" class="flex h-9 w-full rounded-md border border-input bg-muted px-3 py-1.5 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus:bg-background transition-colors" required>
                    </div>
                </div>
            </div>`;
        }
        membersFields.innerHTML = html;
    } else {
        membersSection.classList.add('hidden');
    }

    // Documents
    const requiredDocs = lomba.required_docs;
    if (requiredDocs && requiredDocs.trim() !== '') {
        docsSection.classList.remove('hidden');
        const docs = requiredDocs.split(',').map(d => d.trim()).filter(d => d);
        let html = '';
        docs.forEach((doc, idx) => {
            html += `
            <div>
                <label class="block text-sm font-medium text-foreground mb-1">${doc}</label>
                <input type="file" name="docs[${idx}]" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            </div>`;
        });
        docsFields.innerHTML = html;
    } else {
        docsSection.classList.add('hidden');
    }

    // Update step numbers
    const hasMembers = teamSize > 1;
    const hasDocs = requiredDocs && requiredDocs.trim() !== '';
    let step = 3;
    if (hasMembers) {
        document.querySelectorAll('#members-section .font-bold')[0].textContent = step++;
    }
    if (hasDocs) {
        document.getElementById('step-docs').textContent = step;
    } else {
        document.getElementById('step-docs').textContent = step;
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('competition_id');
    if (select.value) handleLombaChange(select);
});
</script>
@endpush
