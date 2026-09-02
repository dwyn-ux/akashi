@php
    $size = $size ?? 'w-20 h-20';
@endphp

@if(!empty($settings['site_logo']))
    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="{{ $settings['event_name'] ?? 'AKASHI' }}" class="{{ $size }} mx-auto mb-5 object-contain">
@else
    <img src="{{ asset('asset/brand/akashi-mark.svg') }}" alt="AKASHI 2026" class="{{ $size }} mx-auto mb-5">
@endif
