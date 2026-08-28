@php $lomba = $lomba ?? null; @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Fields -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Informasi Dasar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lomba <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $lomba->name ?? '') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $lomba->slug ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Otomatis dari nama">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach(['Akademik', 'Religi', 'Bahasa', 'Seni', 'Olimpiade', 'Olahraga', 'Teknologi', 'Lainnya'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $lomba->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                    <select name="level" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        <option value="">Pilih Level</option>
                        @foreach(['SD', 'Sekolah', 'Kabupaten', 'Provinsi', 'Nasional'] as $lvl)
                            <option value="{{ $lvl }}" {{ old('level', $lomba->level ?? '') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('description', $lomba->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Peserta & Kuota -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Peserta & Kuota</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Umur</label>
                    <input type="number" name="min_age" value="{{ old('min_age', $lomba->min_age ?? '') }}" min="0" max="99"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Umur</label>
                    <input type="number" name="max_age" value="{{ old('max_age', $lomba->max_age ?? '') }}" min="0" max="99"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <input type="text" name="grade_class" value="{{ old('grade_class', $lomba->grade_class ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="7-9 / 10-12">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota <span class="text-red-500">*</span></label>
                    <input type="number" name="quota" value="{{ old('quota', $lomba->quota ?? '') }}" min="1" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Biaya (Rp)</label>
                    <input type="number" name="fee" value="{{ old('fee', $lomba->fee ?? '0') }}" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Tim</label>
                    <input type="number" name="team_size" value="{{ old('team_size', $lomba->team_size ?? '1') }}" min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                        <option value="DRAFT" {{ old('status', $lomba->status ?? 'DRAFT') === 'DRAFT' ? 'selected' : '' }}>Draft</option>
                        <option value="OPEN" {{ old('status', $lomba->status ?? '') === 'OPEN' ? 'selected' : '' }}>Dibuka</option>
                        <option value="CLOSED" {{ old('status', $lomba->status ?? '') === 'CLOSED' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $lomba->location ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
            </div>
        </div>

        <!-- Jadwal & Kontak -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal & Kontak</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Jadwal</label>
                    <input type="text" name="schedule_text" value="{{ old('schedule_text', $lomba->schedule_text ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Contoh: 15-16 Maret 2026">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>
                    <input type="number" name="duration" value="{{ old('duration', $lomba->duration ?? '') }}" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', $lomba->contact_person ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Nama - No. HP">
                </div>
            </div>
        </div>

        <!-- Syarat & Aturan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Syarat & Aturan</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Persyaratan</label>
                    <textarea name="requirements" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('requirements', $lomba->requirements ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Aturan</label>
                    <textarea name="rules" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('rules', $lomba->rules ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen yang Diperlukan</label>
                    <textarea name="required_docs" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('required_docs', $lomba->required_docs ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        <!-- Hadiah -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Hadiah</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Juara 1</label>
                    <input type="text" name="prize_1" value="{{ old('prize_1', $lomba->prize_1 ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Juara 2</label>
                    <input type="text" name="prize_2" value="{{ old('prize_2', $lomba->prize_2 ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Juara 3</label>
                    <input type="text" name="prize_3" value="{{ old('prize_3', $lomba->prize_3 ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hadiah Tambahan</label>
                    <input type="text" name="prize_extra" value="{{ old('prize_extra', $lomba->prize_extra ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
            </div>
        </div>

        <!-- Gambar Sampul -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Gambar Sampul</h3>
            <div>
                @if(!empty($lomba->cover_url))
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $lomba->cover_url) }}" alt="Cover" class="w-full h-40 object-cover rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-400 mt-1">Gambar saat ini</p>
                    </div>
                @endif
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar Baru</label>
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>
            </div>
        </div>

        <!-- Submit -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <button type="submit" class="w-full bg-primary hover:bg-purple-800 text-white font-semibold py-2.5 rounded-xl transition text-sm shadow-sm">
                {{ $lomba ? 'Simpan Perubahan' : 'Buat Lomba' }}
            </button>
            <a href="{{ route('admin.lomba.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700 mt-3 transition">Batal</a>
        </div>
    </div>
</div>
