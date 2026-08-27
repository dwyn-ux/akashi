<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class CekController extends Controller
{
    public function index(Request $request)
    {
        $registration = null;

        if ($regNumber = $request->input('reg_number')) {
            $registration = Registration::with(['participant', 'competition'])
                ->where('reg_number', $regNumber)
                ->first();
        }

        return view('cek.index', compact('registration'));
    }
}
