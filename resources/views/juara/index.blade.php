@extends('layouts.public')

@section('title', 'Para Juara')

@section('content')

<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">Para Juara</h1>
        <p class="text-purple-300">Selamat kepada seluruh pemenang AKASHI!</p>
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
            $grouped = $announcements->groupBy('year');
        @endphp

        @forelse($grouped as $year => $items)
        <div class="mb-14">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-yellow-400 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <h2 class="text-3xl font-extrabold text-primary-900">Tahun {{ $year }}</h2>
            </div>

            @foreach($items as $item)
            <div class="mb-8 last:mb-0">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-6 bg-accent-500 rounded-full"></div>
                    <h3 class="font-bold text-primary-900 text-lg">{{ $item->title }}</h3>
                    @if($item->competition)
                    <span class="px-2.5 py-1 text-[11px] font-semibold bg-accent-100 text-accent-700 rounded-lg">{{ $item->competition->name }}</span>
                    @endif
                </div>

                @if($item->body)
                <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line mb-4 ml-3">{{ $item->body }}</div>
                @endif

                @if($item->winners->count())
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 ml-3">
                    @php
                        $silver = $item->winners->where('place', 2)->first();
                        $gold = $item->winners->where('place', 1)->first();
                        $bronze = $item->winners->where('place', 3)->first();
                    @endphp
                    @if($silver)
                    <div class="bg-white rounded-xl p-5 border border-slate-200 text-center order-2 sm:order-1 shadow-sm">
                        <div class="w-12 h-12 bg-slate-400 rounded-xl flex items-center justify-center mx-auto mb-3 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6.084 10H4.5A2.5 2.5 0 0 1 2 7.5V5a1 1 0 0 1 1-1h3"/><path d="M17.916 10H19.5A2.5 2.5 0 0 0 22 7.5V5a1 1 0 0 0-1-1h-3"/><path d="M4 22h16"/><path d="M10 14.66V17a1 1 0 0 1-1 1 2 2 0 0 0-2 2v2"/><path d="M14 14.66V17a1 1 0 0 0 1 1 2 2 0 0 1 2 2v2"/></svg>
                        </div>
                        <div class="text-xs font-bold tracking-widest text-muted-foreground mb-1">JUARA 2</div>
                        <div class="font-semibold mb-0.5">{{ $silver->participant_name }}</div>
                        <div class="text-sm text-muted-foreground">{{ $silver->school }}</div>
                        @if($silver->note)<div class="text-xs text-muted-foreground mt-1">{{ $silver->note }}</div>@endif
                    </div>
                    @endif
                    @if($gold)
                    <div class="bg-gradient-to-b from-amber-50 to-white rounded-xl p-5 border-2 border-amber-200 text-center order-1 sm:order-2 sm:-translate-y-2 shadow-md">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center mx-auto mb-3 text-white shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg>
                        </div>
                        <div class="text-xs font-bold tracking-widest text-amber-700 mb-1">JUARA 1</div>
                        <div class="font-semibold text-lg mb-0.5">{{ $gold->participant_name }}</div>
                        <div class="text-sm text-muted-foreground">{{ $gold->school }}</div>
                        @if($gold->note)<div class="text-xs text-muted-foreground mt-1">{{ $gold->note }}</div>@endif
                    </div>
                    @endif
                    @if($bronze)
                    <div class="bg-white rounded-xl p-5 border border-orange-200 text-center order-3 shadow-sm">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mx-auto mb-3 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/></svg>
                        </div>
                        <div class="text-xs font-bold tracking-widest text-muted-foreground mb-1">JUARA 3</div>
                        <div class="font-semibold mb-0.5">{{ $bronze->participant_name }}</div>
                        <div class="text-sm text-muted-foreground">{{ $bronze->school }}</div>
                        @if($bronze->note)<div class="text-xs text-muted-foreground mt-1">{{ $bronze->note }}</div>@endif
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @empty
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.015 6.015 0 01-1.77.658H13.5m5.02-.432a6.015 6.015 0 01-1.77-.658m0 0a6.015 6.015 0 01-2.48-5.228"/></svg>
            <h3 class="text-xl font-bold text-gray-400 mb-2">Belum Ada Juara</h3>
            <p class="text-gray-400 text-sm">Pengumuman juara akan segera dipublish.</p>
        </div>
        @endforelse
    </div>
</section>

@endsection
