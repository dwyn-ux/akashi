<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoPage;
use Illuminate\Http\Request;

class InfoPageController extends Controller
{
    public function index()
    {
        $infoPages = InfoPage::all();

        return view('admin.info-pages.index', compact('infoPages'));
    }

    public function update(Request $request, string $slug)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
        ]);

        InfoPage::updateOrCreate(
            ['slug' => $slug],
            $validated
        );

        return back()->with('success', 'Halaman info berhasil diperbarui.');
    }
}
