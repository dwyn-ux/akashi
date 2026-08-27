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
        <div class="bg-white rounded-2xl p-6 sm:p-8 lg:p-10 shadow-md border border-gray-100">
            <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $page->body }}</div>
        </div>
    </div>
</section>

@endsection
