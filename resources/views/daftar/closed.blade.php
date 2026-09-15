@extends('layouts.public')

@section('title', $settings['closed_title'] ?? 'Pendaftaran Ditutup')

@section('content')
<section class="py-16 sm:py-24">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-white rounded-2xl p-8 sm:p-10 shadow-md border border-gray-100">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-primary-900 mb-3">{{ $settings['closed_title'] ?? 'Pendaftaran Telah Ditutup' }}</h1>
            <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $settings['closed_message'] ?? 'Terima kasih atas antusiasme seluruh peserta.' }}</p>
            <p class="inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 px-4 py-2 text-sm font-bold text-yellow-700 rounded-xl">
                Sampai jumpa di {{ $settings['next_event_label'] ?? 'AKASHI 2027' }}!
            </p>
            <div class="mt-6">
                <a href="{{ route('cek-pendaftaran') }}" class="text-primary-900 font-semibold text-sm hover:text-accent-600 transition underline underline-offset-4">Cek Status Pendaftaran</a>
            </div>
        </div>
    </div>
</section>
@endsection
