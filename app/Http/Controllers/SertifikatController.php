<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function show(string $regNumber)
    {
        $registration = Registration::with(['participant', 'competition'])
            ->where('reg_number', $regNumber)
            ->firstOrFail();

        if ($registration->certificate_path && Storage::disk('public')->exists($registration->certificate_path)) {
            return Storage::disk('public')->download($registration->certificate_path, 'sertifikat-'.$regNumber.'.'.pathinfo($registration->certificate_path, PATHINFO_EXTENSION));
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $mode = $settings['certificate_mode'] ?? 'global';

        $templatePath = null;
        $layout = $this->parseLayout($settings['certificate_layout'] ?? null);
        if ($mode === 'per_lomba' && $registration->competition) {
            if (! empty($registration->competition->certificate_template)) {
                $templatePath = $registration->competition->certificate_template;
            }
            $layout = $this->parseLayout($registration->competition->certificate_layout) + $layout;
        }
        if (! $templatePath && ! empty($settings['certificate_template'])) {
            $templatePath = $settings['certificate_template'];
        }

        $bgBase64 = null;
        if ($templatePath) {
            $full = public_path('storage/'.$templatePath);
            if (File::exists($full)) {
                $bgBase64 = 'data:'.File::mimeType($full).';base64,'.base64_encode(file_get_contents($full));
            }
        }

        $replace = [
            '{nama}' => $registration->participant->full_name ?? '-',
            '{lomba}' => $registration->competition->name ?? '-',
            '{kategori}' => $registration->competition->category ?? '-',
            '{sekolah}' => $registration->participant->school ?? '-',
            '{nomor}' => $registration->reg_number,
        ];
        $title = strtr($settings['certificate_title'] ?? 'Sertifikat Penghargaan', $replace);
        $body = strtr($settings['certificate_body'] ?? 'Diberikan dengan bangga kepada {nama} atas partisipasi pada lomba {lomba} ({kategori})', $replace);
        $texts = [
            'title' => $title,
            'name' => $replace['{nama}'],
            'body' => $body,
            'meta' => $replace['{nomor}'].' • '.$replace['{sekolah}'],
        ];

        $pdf = Pdf::loadView('sertifikat.pdf', compact('registration', 'settings', 'bgBase64', 'layout', 'texts'))->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-'.$regNumber.'.pdf');
    }

    private function parseLayout(?string $raw): array
    {
        if (! $raw) {
            return [];
        }
        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }
}
