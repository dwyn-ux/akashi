<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'content' => 'nullable|string',
            'content_html' => 'nullable|string',
            'docx_file' => 'nullable|file|max:10240|mimes:docx,doc',
        ]);

        $type = $validated['type'];
        $updateData = ['title' => ucfirst($type)];

        // Handle docx file upload (converted to HTML on client via mammoth.js)
        if ($request->hasFile('docx_file')) {
            $file = $request->file('docx_file');
            $path = $file->store('juknis', 'public');
            $updateData['content_file_path'] = $path;
        }

        // Use HTML content from mammoth.js conversion, fallback to plain content
        $htmlContent = $validated['content_html'] ?? $validated['content'] ?? '';
        $updateData['body'] = $htmlContent;

        InfoPage::updateOrCreate(
            ['slug' => $type],
            $updateData
        );

        return back()->with('success', ucfirst($type) . ' berhasil diperbarui.');
    }
}
