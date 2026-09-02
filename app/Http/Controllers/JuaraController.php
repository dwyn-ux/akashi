<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class JuaraController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['winners', 'competition'])
            ->where('published', true)
            ->whereHas('winners')
            ->latest('year')
            ->latest()
            ->get();

        return view('juara.index', compact('announcements'));
    }
}
