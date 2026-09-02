@extends('layouts.public')

@section('title', $page->title)

@section('content')

<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-3 mb-6">
            <a href="{{ route('juknis.show') }}" class="px-4 py-2 text-sm font-medium rounded-xl transition {{ request()->routeIs('juknis.*') ? 'bg-white text-primary-900' : 'bg-white/10 text-purple-200 hover:bg-white/20' }}">Juknis</a>
            <a href="{{ route('dokumentasi.show') }}" class="px-4 py-2 text-sm font-medium rounded-xl transition {{ request()->routeIs('dokumentasi.*') ? 'bg-white text-primary-900' : 'bg-white/10 text-purple-200 hover:bg-white/20' }}">Dokumentasi</a>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold">{{ $page->title }}</h1>
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($page->body)
        {{-- Clickable card that opens popup --}}
        <button onclick="openJuknis()" class="w-full text-left bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg hover:border-primary/20 transition-all cursor-pointer group">
            <div class="p-6 sm:p-8">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <h3 class="font-bold text-primary-900 group-hover:text-primary-700 transition-colors">{{ $page->title }}</h3>
                        </div>
                        <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">{!! Str::limit(strip_tags($page->body), 200) !!}</p>
                        <div class="mt-3 flex items-center gap-2">
                            <span class="text-xs font-semibold text-primary bg-primary/5 px-2.5 py-1 rounded-lg">Klik untuk membuka dokumen lengkap</span>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-primary shrink-0 mt-1 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </div>
            </div>
        </button>

        {{-- Hidden content for popup --}}
        <div id="juknis-content" class="hidden">{!! $page->body !!}</div>

        @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-md border border-gray-100">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            <h3 class="text-xl font-bold text-gray-400 mb-2">Belum Ada Dokumen</h3>
            <p class="text-gray-400 text-sm">Dokumen juknis akan segera dipublish.</p>
        </div>
        @endif

    </div>
</section>

{{-- Juknis Modal --}}
<div id="juknis-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeJuknis()"></div>
    <div class="relative flex items-start justify-center min-h-screen p-4 pt-[5vh]">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                <h3 class="font-bold text-primary-900">{{ $page->title }}</h3>
                <button onclick="closeJuknis()" class="p-2 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 sm:p-8 overflow-y-auto flex-1 prose prose-gray max-w-none
                        prose-headings:text-primary-900 prose-headings:font-bold
                        prose-p:text-gray-700 prose-p:leading-relaxed
                        prose-li:text-gray-700
                        prose-strong:text-gray-800
                        prose-table:border prose-table:border-gray-200
                        prose-th:bg-gray-50 prose-th:text-sm prose-th:font-semibold
                        prose-td:text-sm
                        prose-img:rounded-lg prose-img:shadow-sm" id="juknis-modal-body">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openJuknis() {
    var content = document.getElementById('juknis-content');
    document.getElementById('juknis-modal-body').innerHTML = content.innerHTML;
    document.getElementById('juknis-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeJuknis() {
    document.getElementById('juknis-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeJuknis();
});
</script>
@endpush
