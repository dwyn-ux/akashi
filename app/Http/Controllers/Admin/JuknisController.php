<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoPage;
use Illuminate\Http\Request;

class JuknisController extends Controller
{
    public function index()
    {
        $juknis = InfoPage::where('slug', 'juknis')->first();
        $dokumentasi = InfoPage::where('slug', 'dokumentasi')->first();

        return view('admin.juknis.index', compact('juknis', 'dokumentasi'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:juknis,dokumentasi',
            'content' => 'required|string',
        ]);

        InfoPage::updateOrCreate(
            ['slug' => $validated['type']],
            ['title' => ucfirst($validated['type']), 'content' => $validated['content']]
        );

        return back()->with('success', ucfirst($validated['type']) . ' berhasil diperbarui.');
    }
}
