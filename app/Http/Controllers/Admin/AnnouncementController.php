<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('winners')->latest()->paginate(15);
        $pengumumans = $announcements;
        $lombas = \App\Models\Competition::all();

        return view('admin.pengumuman.index', compact('announcements', 'pengumumans', 'lombas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2100',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'competition_id' => 'nullable|exists:competitions,id',
            'published' => 'boolean',
        ]);

        $validated['published'] = $request->boolean('published');

        $announcement = Announcement::create($validated);

        if ($request->has('winners')) {
            foreach ($request->input('winners', []) as $winner) {
                if (! empty($winner['participant_name'])) {
                    $announcement->winners()->create([
                        'place' => $winner['place'] ?? 1,
                        'participant_name' => $winner['participant_name'],
                        'school' => $winner['school'] ?? '',
                        'note' => $winner['note'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['published' => ! $announcement->published]);

        return back()->with('success', 'Status publikasi berhasil diubah.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
