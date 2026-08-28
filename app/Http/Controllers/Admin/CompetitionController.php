<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::latest()->paginate(15);
        $lombas = $competitions;

        return view('admin.lomba.index', compact('competitions', 'lombas'));
    }

    public function create()
    {
        return view('admin.lomba.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'grade_class' => 'nullable|string|max:255',
            'quota' => 'nullable|integer|min:0',
            'fee' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'schedule_text' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'status' => 'required|string|in:DRAFT,OPEN,CLOSED',
            'cover_url' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
            'team_size' => 'nullable|integer|min:1',
            'prize_1' => 'nullable|string|max:255',
            'prize_2' => 'nullable|string|max:255',
            'prize_3' => 'nullable|string|max:255',
            'prize_extra' => 'nullable|string|max:255',
            'requirements' => 'nullable|string',
            'rules' => 'nullable|string',
            'required_docs' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('competitions', 'public');
            $validated['cover_url'] = $path;
        }
        unset($validated['cover_image']);

        $validated['slug'] = Str::slug($validated['name']);

        Competition::create($validated);

        return redirect()->route('admin.lomba.index')->with('success', 'Kompetisi berhasil ditambahkan.');
    }

    public function show(Competition $competition)
    {
        $competition->load('registrations.participant');
        $lomba = $competition;

        return view('admin.lomba.show', compact('competition', 'lomba'));
    }

    public function edit(Competition $competition)
    {
        $lomba = $competition;

        return view('admin.lomba.edit', compact('competition', 'lomba'));
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'grade_class' => 'nullable|string|max:255',
            'quota' => 'nullable|integer|min:0',
            'fee' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'schedule_text' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'status' => 'required|string|in:DRAFT,OPEN,CLOSED',
            'cover_url' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
            'team_size' => 'nullable|integer|min:1',
            'prize_1' => 'nullable|string|max:255',
            'prize_2' => 'nullable|string|max:255',
            'prize_3' => 'nullable|string|max:255',
            'prize_extra' => 'nullable|string|max:255',
            'requirements' => 'nullable|string',
            'rules' => 'nullable|string',
            'required_docs' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($competition->cover_url && File::exists(public_path('storage/' . $competition->cover_url))) {
                File::delete(public_path('storage/' . $competition->cover_url));
            }
            $path = $request->file('cover_image')->store('competitions', 'public');
            $validated['cover_url'] = $path;
        }
        unset($validated['cover_image']);

        $validated['slug'] = Str::slug($validated['name']);

        $competition->update($validated);

        return redirect()->route('admin.lomba.index')->with('success', 'Kompetisi berhasil diperbarui.');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return redirect()->route('admin.lomba.index')->with('success', 'Kompetisi berhasil dihapus.');
    }
}
