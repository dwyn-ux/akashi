@extends('layouts.admin')

@section('title', 'Juknis & Dokumentasi')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Juknis & Dokumentasi</h1>
    <p class="text-sm text-gray-500 mt-1">Upload dokumen .docx untuk ditampilkan sebagai panduan teknis</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Juknis -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Juknis (Petunjuk Teknis)</h3>

        @if($juknis && $juknis->content_file_path)
        <div class="mb-4 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-green-800">Dokumen sudah diupload</p>
                    <p class="text-xs text-green-600">Terakhir diperbarui: {{ $juknis->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <a href="{{ asset('storage/' . $juknis->content_file_path) }}" target="_blank"
               class="text-xs font-semibold text-green-700 hover:underline">Lihat Docx →</a>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.juknis.update') }}" enctype="multipart/form-data" id="juknis-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="juknis">
            <input type="hidden" name="content_html" id="juknis-html">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen (.docx)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary transition-colors"
                     id="juknis-dropzone" ondragover="event.preventDefault(); this.classList.add('border-primary', 'bg-primary/5')"
                     ondragleave="this.classList.remove('border-primary', 'bg-primary/5')"
                     ondrop="event.preventDefault(); this.classList.remove('border-primary', 'bg-primary/5'); handleDocxFile(this, event.dataTransfer.files[0], 'juknis')">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                    <p class="text-sm text-gray-500">Drag & drop .docx atau <label class="text-primary font-semibold cursor-pointer hover:underline"><input type="file" name="docx_file" accept=".docx,.doc" class="hidden" onchange="handleDocxFile(this.closest('div'), this.files[0], 'juknis')"> pilih file</label></p>
                    <p class="text-xs text-gray-400 mt-1">Maks 10MB</p>
                </div>
                <div id="juknis-filename" class="hidden mt-2 text-sm text-primary font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span></span>
                </div>
            </div>

            {{-- Preview --}}\n            <div id="juknis-preview" class="hidden mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                <div class="border border-gray-200 rounded-xl p-4 max-h-64 overflow-y-auto text-sm text-gray-600" id="juknis-preview-content"></div>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                    Simpan Juknis
                </button>
            </div>
        </form>
    </div>

    <!-- Dokumentasi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumentasi</h3>

        @if($dokumentasi && $dokumentasi->content_file_path)
        <div class="mb-4 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-green-800">Dokumen sudah diupload</p>
                    <p class="text-xs text-green-600">Terakhir diperbarui: {{ $dokumentasi->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <a href="{{ asset('storage/' . $dokumentasi->content_file_path) }}" target="_blank"
               class="text-xs font-semibold text-green-700 hover:underline">Lihat Docx →</a>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.juknis.update') }}" enctype="multipart/form-data" id="dokumentasi-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="dokumentasi">
            <input type="hidden" name="content_html" id="dokumentasi-html">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen (.docx)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary transition-colors"
                     id="dokumentasi-dropzone" ondragover="event.preventDefault(); this.classList.add('border-primary', 'bg-primary/5')"
                     ondragleave="this.classList.remove('border-primary', 'bg-primary/5')"
                     ondrop="event.preventDefault(); this.classList.remove('border-primary', 'bg-primary/5'); handleDocxFile(this, event.dataTransfer.files[0], 'dokumentasi')">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                    <p class="text-sm text-gray-500">Drag & drop .docx atau <label class="text-primary font-semibold cursor-pointer hover:underline"><input type="file" name="docx_file" accept=".docx,.doc" class="hidden" onchange="handleDocxFile(this.closest('div'), this.files[0], 'dokumentasi')"> pilih file</label></p>
                    <p class="text-xs text-gray-400 mt-1">Maks 10MB</p>
                </div>
                <div id="dokumentasi-filename" class="hidden mt-2 text-sm text-primary font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span></span>
                </div>
            </div>

            <div id="dokumentasi-preview" class="hidden mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                <div class="border border-gray-200 rounded-xl p-4 max-h-64 overflow-y-auto text-sm text-gray-600" id="dokumentasi-preview-content"></div>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                    Simpan Dokumentasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.8.0/mammoth.browser.min.js"></script>
<script>
function handleDocxFile(dropzone, file, type) {
    if (!file) return;
    if (!file.name.match(/\.docx?$/i)) {
        alert('Hanya file .docx atau .doc yang diterima.');
        return;
    }

    // Show filename
    var filenameEl = document.getElementById(type + '-filename');
    filenameEl.classList.remove('hidden');
    filenameEl.querySelector('span').textContent = file.name;

    // Read and convert with mammoth
    var reader = new FileReader();
    reader.onload = function(e) {
        var arrayBuffer = e.target.result;
        mammoth.convertToHtml({arrayBuffer: arrayBuffer})
            .then(function(result) {
                document.getElementById(type + '-html').value = result.value;
                var preview = document.getElementById(type + '-preview');
                var previewContent = document.getElementById(type + '-preview-content');
                preview.classList.remove('hidden');
                previewContent.innerHTML = result.value;
                if (result.messages.length > 0) {
                    console.log('Mammoth messages:', result.messages);
                }
            })
            .catch(function(err) {
                console.error('Error converting docx:', err);
                alert('Gagal membaca file docx. Pastikan file tidak corrupt.');
            });
    };
    reader.readAsArrayBuffer(file);
}
</script>
@endpush
