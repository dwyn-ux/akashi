<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('school', 'like', "%{$search}%");
            });
        }

        $participants = $query->latest()->paginate(15);

        return view('admin.peserta.index', compact('participants'));
    }

    public function show(Participant $participant)
    {
        $participant->load('registrations.competition');

        return view('admin.peserta.show', compact('participant'));
    }

    public function updateStatus(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $participant->update(['status' => $validated['status']]);

        return back()->with('success', 'Status peserta berhasil diperbarui.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil dihapus.');
    }
}
