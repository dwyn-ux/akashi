<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class PengumumanController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('winners')
            ->where('published', true)
            ->latest('year')
            ->latest()
            ->paginate(10);

        return view('pengumuman.index', compact('announcements'));
    }
}
