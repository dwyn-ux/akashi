<?php

namespace App\Http\Controllers;

use App\Models\Competition;

class LombaController extends Controller
{
    public function index()
    {
        $competitions = Competition::whereIn('status', ['OPEN', 'CLOSED'])->latest()->paginate(12);

        return view('lomba.index', compact('competitions'));
    }

    public function show(string $slug)
    {
        $competition = Competition::where('slug', $slug)->firstOrFail();

        return view('lomba.show', compact('competition'));
    }
}
