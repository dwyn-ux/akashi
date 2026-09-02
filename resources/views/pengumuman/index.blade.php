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

            <div class="space-y-4">
                @foreach($items as $item)
                <button onclick="openPengumuman({{ $item->id }})" class="w-full text-left bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg hover:border-primary/20 transition-all cursor-pointer group">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="font-bold text-primary-900 group-hover:text-primary-700 transition-colors">{{ $item->title }}</h3>
                                    @if($item->competition)
                                    <span class="px-2.5 py-0.5 text-[10px] font-semibold bg-accent-100 text-accent-700 rounded-lg whitespace-nowrap">{{ $item->competition->name }}</span>
                                    @endif
                                </div>
                                <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($item->body), 150) }}</p>
                                @if($item->winners->count())
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-lg">{{ $item->winners->count() }} Pemenang</span>
                                </div>
                                @endif
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-primary shrink-0 mt-1 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </div>
                    </div>
                </button>

                {{-- Hidden modal data --}}
                <div id="pengumuman-data-{{ $item->id }}" class="hidden"
                     data-title="{{ addslashes($item->title) }}"
                     data-body="{{ addslashes($item->body) }}"
                     data-competition="{{ addslashes($item->competition->name ?? '') }}">
                    @if($item->winners->count())
                    @php
                        $silver = $item->winners->where('place', 2)->first();
                        $gold = $item->winners->where('place', 1)->first();
                        $bronze = $item->winners->where('place', 3)->first();
                    @endphp
                    <div id="pengumuman-winners-{{ $item->id }}">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 max-w-2xl mx-auto items-end">
                            @if($silver)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-center order-2 sm:order-1">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mx-auto mb-2"><span class="text-white font-bold">2</span></div>
                                <div class="font-bold text-primary-900 text-sm">{{ $silver->participant_name }}</div>
                                <div class="text-xs text-gray-500">{{ $silver->school }}</div>
                                @if($silver->note)<div class="text-xs text-gray-400 mt-1">{{ $silver->note }}</div>@endif
                            </div>
                            @endif
                            @if($gold)
                            <div class="bg-yellow-50 rounded-xl p-4 border-2 border-yellow-300 text-center order-1 sm:order-2 transform sm:-translate-y-1">
                                <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center mx-auto mb-2"><span class="text-white font-bold">1</span></div>
                                <div class="font-bold text-primary-900">{{ $gold->participant_name }}</div>
                                <div class="text-xs text-gray-500">{{ $gold->school }}</div>
                                @if($gold->note)<div class="text-xs text-gray-400 mt-1">{{ $gold->note }}</div>@endif
                            </div>
                            @endif
                            @if($bronze)
                            <div class="bg-orange-50 rounded-xl p-4 border border-orange-200 text-center order-3">
                                <div class="w-10 h-10 bg-orange-400 rounded-full flex items-center justify-center mx-auto mb-2"><span class="text-white font-bold">3</span></div>
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

{{-- Modal Pengumuman --}}
<div id="pengumuman-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closePengumuman()"></div>
    <div class="relative flex items-start justify-center min-h-screen p-4 pt-[5vh]">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-2 min-w-0">
                    <h3 id="modal-title" class="font-bold text-primary-900 truncate"></h3>
                    <span id="modal-competition" class="hidden px-2.5 py-0.5 text-[10px] font-semibold bg-accent-100 text-accent-700 rounded-lg whitespace-nowrap"></span>
                </div>
                <button onclick="closePengumuman()" class="shrink-0 p-2 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 sm:p-8 overflow-y-auto flex-1">
                <div id="modal-body" class="text-gray-600 text-sm leading-relaxed whitespace-pre-line"></div>
                <div id="modal-winners"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openPengumuman(id) {
    var data = document.getElementById('pengumuman-data-' + id);
    if (!data) return;
    document.getElementById('modal-title').textContent = data.dataset.title;
    document.getElementById('modal-body').textContent = data.dataset.body;
    var comp = document.getElementById('modal-competition');
    if (data.dataset.competition) {
        comp.textContent = data.dataset.competition;
        comp.classList.remove('hidden');
    } else {
        comp.classList.add('hidden');
    }
    var winnersEl = document.getElementById('pengumuman-winners-' + id);
    document.getElementById('modal-winners').innerHTML = winnersEl ? winnersEl.innerHTML : '';
    document.getElementById('pengumuman-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closePengumuman() {
    document.getElementById('pengumuman-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePengumuman();
});
</script>
@endpush
