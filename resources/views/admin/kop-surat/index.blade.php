@extends('layouts.admin')

@section('title', 'Kop Surat')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kop Surat</h1>
        <p class="text-sm text-gray-500 mt-1">Pratinjau dan cetak kop surat resmi</p>
    </div>
    <button onclick="window.print()" class="inline-flex items-center gap-2 bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm print:hidden">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/>
        </svg>
        Cetak
    </button>
</div>

<!-- Print Preview -->
<div id="printArea" class="bg-white rounded-xl shadow-sm border border-gray-100 mx-auto" style="max-width: 800px;">
    <div class="p-10">

        <!-- Header Section -->
        <div class="kop-header flex items-center justify-between pb-4" style="border-bottom: 3px double #5b21b6;">

            <!-- School Logo Left -->
            <div class="flex-shrink-0">
                @if(!empty($settings['school_logo']))
                    <img src="{{ asset('storage/' . $settings['school_logo']) }}" alt="Logo Sekolah" class="w-20 h-20 object-contain">
                @else
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center border border-gray-200">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Center: School Name + Address -->
            <div class="text-center px-4">
                <h2 class="font-bold text-lg uppercase tracking-wide" style="color: #5b21b6;">
                    {{ $settings['school_name'] ?? 'NAMA SEKOLAH' }}
                </h2>
                <p class="text-xs text-gray-600 mt-0.5">{{ $settings['address'] ?? 'Alamat Sekolah' }}</p>
                <p class="text-xs text-gray-600">
                    Telp: {{ $settings['whatsapp'] ?? '-' }} | Email: {{ $settings['email'] ?? '-' }}
                </p>
            </div>

            <!-- Event Logo Right -->
            <div class="flex-shrink-0">
                @if(!empty($settings['site_logo']))
                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo Event" class="w-20 h-20 object-contain">
                @else
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-purple-700 rounded-xl flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        A
                    </div>
                @endif
            </div>
        </div>

        <!-- Blank Content Area -->
        <div class="mt-8 min-h-[500px]">
            <p class="text-gray-400 text-sm italic">Area konten surat akan muncul di sini...</p>
        </div>

        <!-- Bottom border on print -->
        <div class="mt-8 pt-4" style="border-top: 3px double #5b21b6;"></div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printArea, #printArea * {
            visibility: visible;
        }
        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            border: none;
        }
        .print\:hidden {
            display: none !important;
        }
    }
</style>
@endpush
