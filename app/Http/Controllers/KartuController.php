<?php

namespace App\Http\Controllers;

use App\Models\Registration;

class KartuController extends Controller
{
    public function show(string $regNumber)
    {
        $registration = Registration::with(['participant', 'competition', 'members'])
            ->where('reg_number', $regNumber)
            ->firstOrFail();

        return view('kartu.show', compact('registration'));
    }
}
