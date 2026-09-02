<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Competition;
use Illuminate\Http\Request;

class JuaraController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['winners', 'competition'])
            ->whereHas('winners')
            ->latest('year')
            ->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('winners', function ($wq) use ($search) {
                        $wq->where('participant_name', 'like', "%{$search}%");
                    });
            });
        }

        $juaras = $query->paginate(15);
        $lombas = Competition::all();

        return view('admin.juara.index', compact('juaras', 'lombas'));
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

        return redirect()->route('admin.juara.index')->with('success', 'Juara berhasil ditambahkan.');
    }

    public function edit(Announcement $juara)
    {
        $juara->load('winners');
        $lombas = Competition::all();

        return view('admin.juara.edit', compact('juara', 'lombas'));
    }

    public function update(Request $request, Announcement $juara)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2100',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'competition_id' => 'nullable|exists:competitions,id',
            'published' => 'boolean',
        ]);

        $validated['published'] = $request->boolean('published');

        $juara->update($validated);

        // Sync winners
        if ($request->has('winners')) {
            $juara->winners()->delete();
            foreach ($request->input('winners', []) as $winner) {
                if (! empty($winner['participant_name'])) {
                    $juara->winners()->create([
                        'place' => $winner['place'] ?? 1,
                        'participant_name' => $winner['participant_name'],
                        'school' => $winner['school'] ?? '',
                        'note' => $winner['note'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.juara.index')->with('success', 'Juara berhasil diperbarui.');
    }

    public function destroy(Announcement $juara)
    {
        $juara->delete();

        return redirect()->route('admin.juara.index')->with('success', 'Juara berhasil dihapus.');
    }
}
