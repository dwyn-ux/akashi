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
        @if($page->content_file_path)
        <p class="text-purple-300 text-sm mt-2">Dokumen diperbarui: {{ $page->updated_at->translatedFormat('d F Y, H:i') }}</p>
        @endif
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            {{-- Document Header --}}\n            <div class="bg-gray-50 border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dokumen</span>
                </div>
                <span class="text-[10px] text-gray-400">Hanya tampilan — tidak dapat didownload</span>
            </div>

            {{-- Document Content --}}\n            <div class="p-6 sm:p-8 lg:p-10 prose prose-gray max-w-none
                        prose-headings:text-primary-900 prose-headings:font-bold
                        prose-p:text-gray-700 prose-p:leading-relaxed
                        prose-li:text-gray-700
                        prose-strong:text-gray-800
                        prose-table:border prose-table:border-gray-200
                        prose-th:bg-gray-50 prose-th:text-sm prose-th:font-semibold
                        prose-td:text-sm
                        prose-img:rounded-lg prose-img:shadow-sm">
                @if($page->body)
                    {!! $page->body !!}
                @else
                    <p class="text-gray-400 italic text-center py-12">Belum ada konten dokumen. Admin dapat mengupload file .docx dari panel admin.</p>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
