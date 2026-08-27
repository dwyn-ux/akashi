@extends('layouts.admin')

@section('title', 'Jadwal Kegiatan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Jadwal Kegiatan</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola jadwal seluruh rangkaian acara</p>
</div>

<!-- Add Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Jadwal</h3>
    <form method="POST" action="{{ route('admin.jadwal.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="date" value="{{ old('date') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <input type="text" name="note" value="{{ old('note') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary hover:bg-purple-800 text-white text-sm font-semibold py-2.5 rounded-xl transition">Tambah</button>
            </div>
        </div>
        @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
    </form>
</div>

<!-- List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Tanggal & Waktu</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Judul</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Keterangan</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($jadwals ?? [] as $i => $jadwal)
                <tr class="hover:bg-gray-50 transition" id="jrow-{{ $jadwal->id }}">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 text-gray-700 font-medium">
                        <span class="jview">{{ $jadwal->date ? $jadwal->date->format('d M Y, H:i') : '-' }}</span>
                        <div class="jedit hidden"><input type="datetime-local" id="jdate-{{ $jadwal->id }}" value="{{ $jadwal->date ? $jadwal->date->format('Y-m-d\TH:i') : '' }}" class="w-full px-2 py-1 border border-primary rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none"></div>
                    </td>
                    <td class="px-4 py-3 text-gray-800">
                        <span class="jview">{{ $jadwal->title }}</span>
                        <div class="jedit hidden"><input type="text" id="jtitle-{{ $jadwal->id }}" value="{{ $jadwal->title }}" class="w-full px-2 py-1 border border-primary rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none"></div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        <span class="jview">{{ $jadwal->note ?? '-' }}</span>
                        <div class="jedit hidden"><input type="text" id="jnote-{{ $jadwal->id }}" value="{{ $jadwal->note }}" class="w-full px-2 py-1 border border-primary rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none"></div>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="jview flex items-center justify-end gap-1">
                            <button onclick="toggleJadwal({{ $jadwal->id }})" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.065a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.jadwal.destroy', $jadwal) }}" onsubmit="return confirm('Hapus jadwal ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.367m1.022 0a3 3 0 01-2.742-2.582l-.018-.044m-1.022 0a3 3 0 00-2.742 2.582l-.018.044m-9.478 0H21"/></svg>
                                </button>
                            </form>
                        </div>
                        <div class="jedit hidden flex items-center justify-end gap-1">
                            <button onclick="saveJadwal({{ $jadwal->id }})" class="px-3 py-1.5 bg-primary hover:bg-purple-800 text-white text-xs font-semibold rounded-lg transition">Simpan</button>
                            <button onclick="toggleJadwal({{ $jadwal->id }})" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition">Batal</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada jadwal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function toggleJadwal(id){
    const row=document.getElementById('jrow-'+id);
    row.querySelectorAll('.jview').forEach(el=>el.classList.toggle('hidden'));
    row.querySelectorAll('.jedit').forEach(el=>el.classList.toggle('hidden'));
}
function saveJadwal(id){
    const title=document.getElementById('jtitle-'+id).value;
    const date=document.getElementById('jdate-'+id).value;
    const note=document.getElementById('jnote-'+id).value;
    const form=document.createElement('form');
    form.method='POST'; form.action='/admin/jadwal/'+id; form.style.display='none';
    form.innerHTML=`<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="PATCH"><input type="hidden" name="title" value="${title.replace(/"/g,'&quot;')}"><input type="hidden" name="date" value="${date}"><input type="hidden" name="note" value="${note.replace(/"/g,'&quot;')}">`;
    document.body.appendChild(form); form.submit();
}
</script>
@endpush
@endsection
