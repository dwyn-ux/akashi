<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kartu Peserta — {{ $registration->reg_number }}</title>
<style>
    @page { margin: 20px 25px; size: A4; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, Helvetica, sans-serif; font-size: 11px; color: #1f2937; }
    .header { background: #5425D8; color: #fff; padding: 14px 20px; }
    .header-row { display: flex; align-items: center; gap: 12px; }
    .header-logo { width: 48px; height: 48px; border-radius: 8px; object-fit: contain; background: rgba(255,255,255,0.15); }
    .header-logo-placeholder { width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; color: #fff; }
    .header-title { font-size: 16px; font-weight: bold; }
    .header-sub { font-size: 9px; color: #c4b5fd; margin-top: 2px; }
    .reg-box { background: #ecfdf5; border: 1px solid #a7f3d0; text-align: center; padding: 12px; }
    .reg-label { font-size: 8px; color: #047857; letter-spacing: 2px; text-transform: uppercase; font-weight: bold; }
    .reg-number { font-size: 20px; font-weight: bold; color: #5425D8; letter-spacing: 1px; margin-top: 4px; }
    .section { padding: 10px 16px; }
    .section-title { font-size: 9px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1.5px; font-weight: bold; margin-bottom: 8px; }
    .row { display: table; width: 100%; padding: 4px 0; }
    .row-label { display: table-cell; width: 45%; color: #6b7280; font-size: 10px; }
    .row-value { display: table-cell; width: 55%; text-align: right; font-weight: 600; color: #11152F; font-size: 10px; }
    .divider { border-top: 1px solid #e5e7eb; margin: 0 16px; }
    .info-box { background: #F1EEFF; border: 1px solid #ddd6fe; border-radius: 8px; padding: 10px 14px; margin: 10px 16px; }
    .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center; padding: 10px; font-size: 8px; color: #9ca3af; }
</style>
</head>
<body>

<div class="header">
    <div class="header-row">
        @if(!empty($logoBase64))
            <img src="{{ $logoBase64 }}" class="header-logo" alt="Logo">
        @else
            <div class="header-logo-placeholder">A</div>
        @endif
        <div>
            <div class="header-title">{{ $settings['event_name'] ?? 'AKASHI 2026' }}</div>
            <div class="header-sub">Ajang Kreasi Ashidiq &bull; {{ $settings['school_name'] ?? 'SMP Muhammadiyah Unggulan Ashidiq' }}</div>
        </div>
    </div>
</div>

<div class="reg-box">
    <div class="reg-label">Nomor Registrasi</div>
    <div class="reg-number">{{ $registration->reg_number }}</div>
</div>

<div class="section">
    <div class="section-title">Biodata Peserta</div>
    <div class="row"><span class="row-label">Nama</span><span class="row-value">{{ $registration->participant->full_name ?? '-' }}</span></div>
    <div class="row"><span class="row-label">NISN</span><span class="row-value">{{ $registration->participant->nisn ?? '-' }}</span></div>
    <div class="row"><span class="row-label">Jenis Kelamin</span><span class="row-value">{{ $registration->participant->gender ?? '-' }}</span></div>
    <div class="row"><span class="row-label">Tempat, Tanggal Lahir</span><span class="row-value">{{ $registration->participant->birth_place ?? '-' }}, {{ $registration->participant->birth_date ? \Carbon\Carbon::parse($registration->participant->birth_date)->translatedFormat('d F Y') : '-' }}</span></div>
    <div class="row"><span class="row-label">Sekolah</span><span class="row-value">{{ $registration->participant->school ?? '-' }}</span></div>
    <div class="row"><span class="row-label">Kelas</span><span class="row-value">{{ $registration->participant->grade_class ?? '-' }}</span></div>
    <div class="row"><span class="row-label">WhatsApp</span><span class="row-value">{{ $registration->participant->whatsapp ?? '-' }}</span></div>
    @if($registration->participant->guardian)
    <div class="row"><span class="row-label">Pendamping</span><span class="row-value">{{ $registration->participant->guardian }} ({{ $registration->participant->guardian_rel }})</span></div>
    @endif
</div>

<div class="divider"></div>

<div class="info-box">
    <div class="section-title">Informasi Lomba</div>
    <div class="row"><span class="row-label">Lomba</span><span class="row-value">{{ $registration->competition->name ?? '-' }}</span></div>
    <div class="row"><span class="row-label">Kategori</span><span class="row-value">{{ $registration->competition->category ?? '-' }}</span></div>
    @if($registration->competition)
    <div class="row"><span class="row-label">Format</span><span class="row-value">{{ ($registration->competition->team_size ?? 1) > 1 ? 'Regu ' . $registration->competition->team_size . ' Orang' : 'Individu' }}</span></div>
    @endif
    @if($registration->competition && $registration->competition->fee)
    <div class="row"><span class="row-label">Biaya</span><span class="row-value">Rp {{ number_format($registration->competition->fee, 0, ',', '.') }}</span></div>
    @endif
    @if($registration->competition && $registration->competition->location)
    <div class="row"><span class="row-label">Lokasi</span><span class="row-value">{{ $registration->competition->location }}</span></div>
    @endif
    @if($registration->competition && $registration->competition->schedule_text)
    <div class="row"><span class="row-label">Jadwal</span><span class="row-value">{{ $registration->competition->schedule_text }}</span></div>
    @endif
</div>

<div class="footer">
    Wajib dibawa pada hari-H &bull; Tunjukkan kartu ini di meja registrasi<br>
    Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}
</div>

</body>
</html>
