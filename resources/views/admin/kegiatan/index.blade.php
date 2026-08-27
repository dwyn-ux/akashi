@extends('layouts.admin')

@section('title', 'Kegiatan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kegiatan</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola daftar kegiatan acara</p>
</div>

<!-- Add Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Kegiatan</h3>
    <form method="POST" action="{{ route('admin.kegiatan.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ old('date') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary hover:bg-purple-800 text-white text-sm font-semibold py-2.5 rounded-xl transition">Tambah</button>
            </div>
        </div>
    </form>
</div>

<!-- List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama Kegiatan</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Lokasi</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kegiatans ?? [] as $i => $kegiatan)
                <tr class="hover:bg-gray-50 transition" id="row-{{ $kegiatan->id }}">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">
                        <span class="view-mode">{{ $kegiatan->name }}</span>
                        <form method="POST" action="{{ route('admin.kegiatan.update', $kegiatan) }}" class="edit-mode hidden">
                            @csrf @method('PATCH')
                            <input type="text" name="name" value="{{ $kegiatan->name }}" required class="w-full px-2 py-1 border border-primary rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                        </form>
                    </td>
                    <td class="px-4 py-3 text-gray-700">
                        <span class="view-mode">{{ $kegiatan->date ? $kegiatan->date->format('d M Y') : '-' }}</span>
                        <form method="POST" action="{{ route('admin.kegiatan.update', $kegiatan) }}" class="edit-mode hidden">
                            @csrf @method('PATCH')
                            <input type="hidden" name="name" value="{{ $kegiatan->name }}">
                            <input type="date" name="date" value="{{ $kegiatan->date ? $kegiatan->date->format('Y-m-d') : '' }}" class="w-full px-2 py-1 border border-primary rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                        </form>
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        <span class="view-mode">{{ $kegiatan->location ?? '-' }}</span>
                        <form method="POST" action="{{ route('admin.kegiatan.update', $kegiatan) }}" class="edit-mode hidden">
                            @csrf @method('PATCH')
                            <input type="hidden" name="name" value="{{ $kegiatan->name }}">
                            <input type="text" name="location" value="{{ $kegiatan->location }}" class="w-full px-2 py-1 border border-primary rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="view-mode flex items-center justify-end gap-1">
                            <button onclick="toggleEdit({{ $kegiatan->id }})" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.065a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.kegiatan.destroy', $kegiatan) }}" onsubmit="return confirm('Hapus kegiatan ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.367m1.022 0a3 3 0 01-2.742-2.582l-.018-.044m-1.022 0a3 3 0 00-2.742 2.582l-.018.044m-9.478 0H21"/></svg>
                                </button>
                            </form>
                        </div>
                        <div class="edit-mode hidden flex items-center justify-end gap-1">
                            <button onclick="submitEdit({{ $kegiatan->id }})" class="px-3 py-1.5 bg-primary hover:bg-purple-800 text-white text-xs font-semibold rounded-lg transition">Simpan</button>
                            <button onclick="toggleEdit({{ $kegiatan->id }})" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition">Batal</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada kegiatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function toggleEdit(id){
    const row=document.getElementById('row-'+id);
    row.querySelectorAll('.view-mode').forEach(el=>el.classList.toggle('hidden'));
    row.querySelectorAll('.edit-mode').forEach(el=>el.classList.toggle('hidden'));
}
function submitEdit(id){
    const row=document.getElementById('row-'+id);
    const forms=row.querySelectorAll('.edit-mode');
    // Collect values from inline inputs into one form submission
    const name=row.querySelector('.edit-mode input[name="name"]:not([type="hidden"])')?.value || row.querySelector('input[name="name"][type="hidden"]')?.value;
    const date=row.querySelector('input[name="date"][type="date"]')?.value || '';
    const location=row.querySelector('input[name="location"]')?.value || '';
    // Use the first form and inject all fields
    const form=forms[0];
    // Ensure all fields are in this form
    let html='<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="PATCH">';
    html+=`<input type="hidden" name="name" value="${name.replace(/"/g,'&quot;')}">`;
    html+=`<input type="hidden" name="date" value="${date}">`;
    html+=`<input type="hidden" name="location" value="${location.replace(/"/g,'&quot;')}">`;
    const tmp=document.createElement('form');
    tmp.method='POST'; tmp.action=form.action; tmp.innerHTML=html; tmp.style.display='none';
    document.body.appendChild(tmp); tmp.submit();
}
</script>
@endpush
@endsection
