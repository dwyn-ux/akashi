@extends('layouts.public')

@section('title', 'Pengumuman')

@section('content')

<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">Pengumuman</h1>
        <p class="text-purple-300">Informasi dan pengumuman terkini seputar AKASHI 2026.</p>
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
            $grouped = $announcements->groupBy('year');
        @endphp

        @forelse($grouped as $year => $items)
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-primary-900 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-lg">{{ $year }}</span>
                </div>
                <h2 class="text-2xl font-extrabold text-primary-900">{{ $year }}</h2>
            </div>

            <div class="space-y-6">
                @foreach($items as $item)
                <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <h3 class="font-bold text-primary-900 text-lg">{{ $item->title }}</h3>
                            @if($item->competition)
                            <span class="px-3 py-1 text-xs font-semibold bg-accent-100 text-accent-700 rounded-lg whitespace-nowrap">{{ $item->competition->name }}</span>
                            @endif
                        </div>
                        <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $item->body }}</div>
                    </div>

                    {{-- Winners --}}
                    @if($item->winners->count())
                    <div class="px-6 sm:px-8 pb-6 sm:pb-8">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Pemenang</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @php
                                $silver = $item->winners->where('place', 2)->first();
                                $gold = $item->winners->where('place', 1)->first();
                                $bronze = $item->winners->where('place', 3)->first();
                            @endphp
                            @if($silver)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-center order-2 sm:order-1">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <span class="text-white font-bold">2</span>
                                </div>
                                <div class="font-bold text-primary-900 text-sm">{{ $silver->participant_name }}</div>
                                <div class="text-xs text-gray-500">{{ $silver->school }}</div>
                                @if($silver->note)<div class="text-xs text-gray-400 mt-1">{{ $silver->note }}</div>@endif
                            </div>
                            @endif
                            @if($gold)
                            <div class="bg-yellow-50 rounded-xl p-4 border-2 border-yellow-300 text-center order-1 sm:order-2 transform sm:-translate-y-1">
                                <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <span class="text-white font-bold">1</span>
                                </div>
                                <div class="font-bold text-primary-900">{{ $gold->participant_name }}</div>
                                <div class="text-xs text-gray-500">{{ $gold->school }}</div>
                                @if($gold->note)<div class="text-xs text-gray-400 mt-1">{{ $gold->note }}</div>@endif
                            </div>
                            @endif
                            @if($bronze)
                            <div class="bg-orange-50 rounded-xl p-4 border border-orange-200 text-center order-3">
                                <div class="w-10 h-10 bg-orange-400 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <span class="text-white font-bold">3</span>
                                </div>
                                <div class="font-bold text-primary-900 text-sm">{{ $bronze->participant_name }}</div>
                                <div class="text-xs text-gray-500">{{ $bronze->school }}</div>
                                @if($bronze->note)<div class="text-xs text-gray-400 mt-1">{{ $bronze->note }}</div>@endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38a.75.75 0 01-.993-.452 7.347 7.347 0 01-1.099-2.426m0 0a6.173 6.173 0 01-1.099-2.426.75.75 0 00-.993-.452l-.657.38c-.523.3-.71.96-.463 1.511.401.89.732 1.82.985 2.783m0 0A3.75 3.75 0 1112 8.25c1.092 0 2.112.36 2.922.975M12 8.25c.69 0 1.355.118 1.977.334"/></svg>
            <h3 class="text-xl font-bold text-gray-400 mb-2">Belum Ada Pengumuman</h3>
            <p class="text-gray-400 text-sm">Pengumuman akan segera dipublish.</p>
        </div>
        @endforelse

        @if($announcements->hasPages())
        <div class="mt-12">
            {{ $announcements->links() }}
        </div>
        @endif
    </div>
</section>

@endsection
