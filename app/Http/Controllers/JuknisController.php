<?php

namespace App\Http\Controllers;

use App\Models\InfoPage;

class JuknisController extends Controller
{
    public function show(string $slug)
    {
        $page = InfoPage::where('slug', $slug)->firstOrFail();

        return view('juknis.show', compact('page'));
    }
}
