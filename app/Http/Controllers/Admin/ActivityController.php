<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->paginate(15);
        $kegiatans = $activities;

        return view('admin.kegiatan.index', compact('activities', 'kegiatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'time_text' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        Activity::create($validated);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'time_text' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $activity->update($validated);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
