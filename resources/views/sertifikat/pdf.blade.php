<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat — {{ $registration->reg_number }}</title>
<style>
    @page { margin: 0; size: A4 landscape; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, Helvetica, sans-serif; color: #14253D; width: 297mm; height: 210mm; position: relative; }
    .bg { position: absolute; left: 0; top: 0; width: 297mm; height: 210mm; }
    .frame { border: 12px double #5B2BE0; margin: 24px; padding: 48px 56px; text-align: center; height: 545px; }
    .eyebrow { font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: #5B2BE0; font-weight: bold; }
    .title-old { font-size: 40px; font-weight: bold; margin-top: 10px; color: #14253D; }
    .name-old { font-size: 30px; font-weight: bold; margin-top: 22px; color: #5B2BE0; }
    .detail { font-size: 13px; color: #4b5563; margin-top: 10px; }
    .meta-old { font-size: 10px; color: #9ca3af; margin-top: 26px; }
    .ov { position: absolute; width: 267mm; }
</style>
</head>
<body>
@if(!empty($bgBase64))
    <img src="{{ $bgBase64 }}" class="bg" alt="">
    @foreach(['title', 'name', 'body', 'meta'] as $key)
        @php $f = $layout[$key] ?? null; @endphp
        @if($f && ($f['visible'] ?? true) !== false)
            <div class="ov" style="left: {{ ($f['x'] ?? 50) / 100 * 297 }}mm; top: {{ ($f['y'] ?? 50) / 100 * 210 }}mm; transform: translate({{ ($f['align'] ?? 'center') === 'center' ? '-50%,-50%' : ((($f['align'] ?? 'center') === 'right') ? '-100%,-50%' : '0,-50%') }}); text-align: {{ $f['align'] ?? 'center' }}; font-size: {{ $f['size'] ?? 13 }}pt; color: {{ $f['color'] ?? '#14253D' }}; font-weight: {{ in_array($key, ['title', 'name']) ? 'bold' : 'normal' }};">{{ $texts[$key] ?? '' }}</div>
        @endif
    @endforeach
@else
    <div class="frame">
        <div class="eyebrow">{{ $settings['event_name'] ?? 'AKASHI 2026' }} &bull; {{ $settings['school_name'] ?? 'SMP Muhammadiyah Unggulan Ashidiq' }}</div>
        <div class="title-old">{{ $texts['title'] ?? 'Sertifikat Penghargaan' }}</div>
        <div class="detail">{{ $texts['body'] ?? '' }}</div>
        <div class="name-old">{{ $texts['name'] ?? '-' }}</div>
        <div class="meta-old">{{ $texts['meta'] ?? '' }}</div>
    </div>
@endif
</body>
</html>
