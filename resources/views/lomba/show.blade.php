@extends('layouts.public')

@section('title', $competition->name)

@section('content')

{{-- HERO --}}
<section class="bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('lomba.index') }}" class="inline-flex items-center gap-2 text-purple-300 hover:text-white text-sm mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Kembali ke Daftar Lomba
        </a>
        <div class="flex items-center gap-3 mb-4">
            <span class="px-3 py-1 text-xs font-semibold bg-accent-500/20 text-accent-300 rounded-lg">{{ $competition->category }}</span>
            @if($competition->level)
            <span class="px-3 py-1 text-xs font-semibold bg-white/10 text-purple-200 rounded-lg">{{ $competition->level }}</span>
            @endif
            <span class="px-3 py-1 text-xs font-semibold rounded-lg
                {{ $competition->status === 'OPEN' ? 'bg-green-500/20 text-green-300' : 'bg-gray-500/20 text-gray-300' }}">
                {{ $competition->status === 'OPEN' ? 'Pendaftaran Buka' : ($competition->status === 'CLOSED' ? 'Ditutup' : 'Draf') }}
            </span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4">{{ $competition->name }}</h1>
        @if($competition->description)
        <p class="text-purple-200 text-lg leading-relaxed max-w-2xl">{{ $competition->description }}</p>
        @endif
    </div>
</section>

<section class="py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Info Ringkas --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @if($competition->team_size)
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <div class="text-xs text-gray-400 mb-1">Tim</div>
                        <div class="font-bold text-primary-900">{{ $competition->team_size > 1 ? $competition->team_size . ' Orang' : 'Individu' }}</div>
                    </div>
                    @endif
                    @if($competition->quota)
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <div class="text-xs text-gray-400 mb-1">Kuota</div>
                        <div class="font-bold text-primary-900">{{ $competition->quota }}</div>
                    </div>
                    @endif
                    @if($competition->duration)
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <div class="text-xs text-gray-400 mb-1">Durasi</div>
                        <div class="font-bold text-primary-900">{{ $competition->duration }}</div>
                    </div>
                    @endif
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                        <div class="text-xs text-gray-400 mb-1">Biaya</div>
                        <div class="font-bold text-primary-900">{{ $competition->fee > 0 ? 'Rp ' . number_format($competition->fee, 0, ',', '.') : 'Gratis' }}</div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                @if($competition->description)
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100">
                    <h2 class="text-xl font-extrabold text-primary-900 mb-4">Deskripsi</h2>
                    <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $competition->description }}</div>
                </div>
                @endif

                {{-- Persyaratan --}}
                @if($competition->requirements)
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100">
                    <h2 class="text-xl font-extrabold text-primary-900 mb-4">Persyaratan</h2>
                    <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $competition->requirements }}</div>
                </div>
                @endif

                {{-- Aturan --}}
                @if($competition->rules)
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100">
                    <h2 class="text-xl font-extrabold text-primary-900 mb-4">Aturan</h2>
                    <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $competition->rules }}</div>
                </div>
                @endif

                {{-- Hadiah --}}
                @php
                    $parsePrize = fn($raw) => array_filter(array_map('trim', explode('+', $raw ?? '')));
                    $isRp = fn($part) => str_starts_with(trim($part), 'Rp');
                @endphp
                @if($competition->prize_1 || $competition->prize_2 || $competition->prize_3)
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        {{-- Lucide crown (ISC, lucide.dev) --}}
                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-extrabold text-primary-900">Hadiah Pemenang</h2>
                            <p class="text-xs text-gray-400">Penghargaan untuk juara terbaik</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                        @foreach([2 => ['bg' => 'bg-white', 'border' => 'border-slate-200', 'shadow' => 'shadow-md', 'iconBg' => 'bg-slate-400', 'money' => 'text-slate-700', 'label' => 'JUARA 2', 'icon' => '<path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6.084 10H4.5A2.5 2.5 0 0 1 2 7.5V5a1 1 0 0 1 1-1h3"/><path d="M17.916 10H19.5A2.5 2.5 0 0 0 22 7.5V5a1 1 0 0 0-1-1h-3"/><path d="M4 22h16"/><path d="M10 14.66V17a1 1 0 0 1-1 1 2 2 0 0 0-2 2v2"/><path d="M14 14.66V17a1 1 0 0 0 1 1 2 2 0 0 1 2 2v2"/>'], 1 => ['bg' => 'bg-gradient-to-b from-yellow-50 to-white', 'border' => 'border-amber-200', 'shadow' => 'shadow-xl shadow-amber-100', 'iconBg' => 'bg-gradient-to-br from-yellow-400 to-amber-500', 'money' => 'text-amber-600', 'label' => 'JUARA 1', 'icon' => '<path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/>'], 3 => ['bg' => 'bg-white', 'border' => 'border-orange-200', 'shadow' => 'shadow-md', 'iconBg' => 'bg-gradient-to-br from-orange-400 to-amber-600', 'money' => 'text-orange-600', 'label' => 'JUARA 3', 'icon' => '<path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/>']] as $place => $cfg)
                            @php $raw = $competition->{'prize_'.$place}; $parts = $parsePrize($raw); @endphp
                            @if(!empty($parts))
                            <div class="{{ $cfg['bg'] }} rounded-2xl p-5 text-center border-2 {{ $cfg['border'] }} {{ $cfg['shadow'] }} {{ $place === 1 ? 'sm:-translate-y-2 sm:scale-[1.03] order-1 sm:order-2' : ($place === 2 ? 'order-2 sm:order-1' : 'order-3') }} relative overflow-hidden">
                                @if($place === 1)
                                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-300"></div>
                                @endif
                                <div class="w-12 h-12 {{ $cfg['iconBg'] }} rounded-xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                        {!! $cfg['icon'] !!}
                                    </svg>
                                </div>
                                <div class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold tracking-widest text-white {{ $cfg['labelColor'] ?? ($place===1?'bg-amber-500':($place===2?'bg-slate-400':'bg-orange-500')) }} mb-3">{{ $cfg['label'] }}</div>
                                <div class="space-y-2">
                                    @foreach($parts as $part)
                                        @if($isRp($part))
                                            <div class="text-lg font-extrabold {{ $cfg['money'] }} tracking-tight">{{ $part }}</div>
                                        @else
                                            <div class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary-50 border border-primary-100 rounded-full text-xs font-semibold text-primary-700">
                                                @if($part === 'Trophy')
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871"/></svg>
                                                @else
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m-6 12.75h7.5m-7.5 3H12"/></svg>
                                                @endif
                                                {{ $part }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @if($competition->prize_extra)
                    <div class="mt-5 flex justify-center">
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-900 text-white rounded-full text-xs font-semibold">
                            🎁 Bonus: {{ $competition->prize_extra }}
                        </span>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- CTA --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 sticky top-24">
                    @if($competition->status === 'OPEN' && !($finished ?? false))
                    <a href="{{ route('daftar.index') }}?lomba={{ $competition->slug }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-accent-500 text-white font-semibold rounded-xl hover:bg-accent-600 transition shadow-lg shadow-accent-500/25">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Daftar Sekarang
                    </a>
                    @elseif($competition->status === 'CLOSED' || ($finished ?? false))
                    <div class="text-center py-4">
                        <span class="text-gray-500 font-medium">Pendaftaran Ditutup</span>
                    </div>
                    @endif

                    <div class="mt-6 space-y-4">
                        @if($competition->location)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-primary-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Lokasi</div>
                                <div class="text-sm font-medium text-primary-900">{{ $competition->location }}</div>
                            </div>
                        </div>
                        @endif
                        @if($competition->schedule_text)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-accent-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-accent-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Jadwal</div>
                                <div class="text-sm font-medium text-primary-900">{{ $competition->schedule_text }}</div>
                            </div>
                        </div>
                        @endif
                        @if($competition->contact_person)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Contact Person</div>
                                <div class="text-sm font-medium text-primary-900">{{ $competition->contact_person }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
