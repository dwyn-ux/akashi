<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuPdfController extends Controller
{
    public function show(string $regNumber)
    {
        $registration = Registration::with(['participant', 'competition'])
            ->where('reg_number', $regNumber)
            ->firstOrFail();

        $pdf = Pdf::loadView('kartu.pdf', compact('registration'));

        return $pdf->download('kartu-'.$regNumber.'.pdf');
    }
}
