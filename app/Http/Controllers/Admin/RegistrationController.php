<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['participant', 'competition']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reg_number', 'like', "%{$search}%")
                    ->orWhereHas('participant', function ($pq) use ($search) {
                        $pq->where('full_name', 'like', "%{$search}%");
                    });
            });
        }

        $registrations = $query->latest()->paginate(15);

        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        $registration->load(['participant', 'competition', 'documents', 'members']);

        return view('admin.registrations.show', compact('registration'));
    }

    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:PENDING,VERIFIED,REJECTED',
            'payment_status' => 'nullable|string|in:NONE,UNPAID,PAID',
            'admin_note' => 'nullable|string',
        ]);

        $registration->update($validated);

        return back()->with('success', 'Registrasi berhasil diperbarui.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('success', 'Registrasi berhasil dihapus.');
    }
}
