@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>
    <p class="text-sm text-gray-500 mt-1">Konfigurasi tampilan dan informasi website</p>
</div>

<form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Logo & Favicon -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Logo & Ikon</h3>
            <div class="space-y-5">
                <!-- Site Logo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Situs</label>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden border">
                            @if(!empty($settings['site_logo']))
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="w-full h-full object-contain" id="logoPreview">
                            @else
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/></svg>
                            @endif
                        </div>
                        <input type="file" name="site_logo" accept="image/*" onchange="previewImage(this, 'logoPreview')"
                               class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer">
                    </div>
                </div>
                <!-- Favicon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border">
                            @if(!empty($settings['favicon']))
                                <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon" class="w-full h-full object-contain" id="faviconPreview">
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25A2.25 2.25 0 018.25 10.5H6A2.25 2.25 0 013.75 8.25V6z"/></svg>
                            @endif
                        </div>
                        <input type="file" name="favicon" accept="image/*" onchange="previewImage(this, 'faviconPreview')"
                               class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer">
                    </div>
                </div>
                <!-- School Logo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Sekolah</label>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden border">
                            @if(!empty($settings['school_logo']))
                                <img src="{{ asset('storage/' . $settings['school_logo']) }}" alt="School Logo" class="w-full h-full object-contain" id="schoolLogoPreview">
                            @else
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>
                            @endif
                        </div>
                        <input type="file" name="school_logo" accept="image/*" onchange="previewImage(this, 'schoolLogoPreview')"
                               class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Color & Identitas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Warna & Identitas</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warna Utama</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="primary_color" value="{{ $settings['primary_color'] ?? '#5b21b6' }}"
                               class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer">
                        <input type="text" name="primary_color_hex" value="{{ $settings['primary_color'] ?? '#5b21b6' }}"
                               class="w-28 px-3 py-2 border border-gray-300 rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Acara <span class="text-red-500">*</span></label>
                    <input type="text" name="event_name" value="{{ old('event_name', $settings['event_name'] ?? $settings['site_name'] ?? 'AKASHI 2026') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Acara Lengkap</label>
                    <input type="text" name="event_full_name" value="{{ old('event_full_name', $settings['event_full_name'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $settings['school_name'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $settings['tagline'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Acara</label>
                    <input type="text" name="event_date" value="{{ old('event_date', $settings['event_date'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="15-16 Maret 2026">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $settings['location'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                </div>
            </div>
        </div>

        <!-- Kontak -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Kontak & Media Sosial</h3>
            <p class="text-xs text-gray-500 mb-4">Isi semua channel yang aktif. Kosongkan yang tidak dipakai.</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (nomor, format intl)</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none font-mono" placeholder="6281234567890">
                    <p class="text-xs text-gray-400 mt-1">Contoh: <code>6281234567890</code> (62 + nomor, tanpa + / spasi)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram (username)</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $settings['instagram'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="akashi.ashidiq">
                    <p class="text-xs text-gray-400 mt-1">Username saja, tanpa <code>@</code>. Contoh: <code>akashi.ashidiq</code></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                            placeholder="panitia@akashi.sch.id">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                              placeholder="Purworejo, Jurangjero, Ngawen, Gunungkidul, D.I. Yogyakarta">{{ old('address', $settings['address'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Media Sosial URL -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">URL Media Sosial</h3>
            <p class="text-xs text-gray-500 mb-4">Link channel tambahan. Kosongkan jika tidak ada.</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                            placeholder="https://www.youtube.com/@akashi">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">TikTok URL</label>
                    <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                            placeholder="https://www.tiktok.com/@akashi.ashidiq">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                            placeholder="https://facebook.com/akashi.ashidiq">
                </div>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Google Maps Embed</h3>
            <p class="text-xs text-gray-500 mb-4">Cara embed: buka Google Maps → cari lokasi → klik "Share" → "Embed a map" → salin HTML <code>&lt;iframe&gt;</code> dan paste di sini.</p>
            <textarea name="google_maps_embed" rows="5"
                      class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none font-mono"
                      placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'>{{ old('google_maps_embed', $settings['google_maps_embed'] ?? '') }}</textarea>
            <p class="text-xs text-gray-400 mt-2">Jika dikosongkan, akan muncul tombol "Buka di Google Maps" yang mengarah ke pencarian alamat.</p>
        </div>

        <!-- Footer Text -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Footer</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Footer (tambahan di copyright)</label>
                <input type="text" name="footer_text" value="{{ old('footer_text', $settings['footer_text'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none"
                        placeholder="Diselenggarakan oleh...">
            </div>
        </div>

        <!-- Rekening Bank -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Rekening Pembayaran</h3>
            <p class="text-sm text-gray-500 mb-4">Informasi rekening untuk pembayaran biaya pendaftaran lomba.</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $settings['bank_name'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="contoh: BRI, BCA, Mandiri">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $settings['account_number'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="1234567890">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Atas Nama</label>
                    <input type="text" name="account_holder" value="{{ old('account_holder', $settings['account_holder'] ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Nama pemilik rekening">
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <p class="text-sm text-gray-500">Semua perubahan akan disimpan ke database.</p>
                <button type="submit" class="bg-primary hover:bg-purple-800 text-white font-semibold px-8 py-2.5 rounded-xl transition text-sm shadow-sm">
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
