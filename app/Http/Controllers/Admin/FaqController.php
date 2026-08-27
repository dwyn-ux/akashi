<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->paginate(15);

        return view('admin.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
