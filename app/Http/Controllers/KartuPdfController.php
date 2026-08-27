<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class KartuPdfController extends Controller
{
    public function show(string $regNumber)
    {
        $registration = Registration::with(['participant', 'competition', 'members'])
            ->where('reg_number', $regNumber)
            ->firstOrFail();

        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Embed logo as base64 for DomPDF (can't load external URLs)
        $logoBase64 = null;
        if (!empty($settings['site_logo'])) {
            $path = public_path('storage/' . $settings['site_logo']);
            if (File::exists($path)) {
                $data = file_get_contents($path);
                $mime = File::mimeType($path);
                $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($data);
            }
        }

        $pdf = Pdf::loadView('kartu.pdf', compact('registration', 'settings', 'logoBase64'));

        return $pdf->download('kartu-' . $regNumber . '.pdf');
    }
}
