<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DaftarController extends Controller
{
    public function index()
    {
        $competitions = Competition::where('status', 'OPEN')->get();
        $bankName = Setting::where('key', 'bank_name')->value('value') ?? '';
        $accountNumber = Setting::where('key', 'account_number')->value('value') ?? '';
        $accountHolder = Setting::where('key', 'account_holder')->value('value') ?? '';

        return view('daftar.index', compact('competitions', 'bankName', 'accountNumber', 'accountHolder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'full_name' => 'required|string|max:255',
            'nisn' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'school' => 'required|string|max:255',
            'grade_class' => 'required|string|max:255',
            'address' => 'required|string',
            'whatsapp' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'guardian' => 'required|string|max:255',
            'guardian_rel' => 'required|string|max:255',
            'guardian_wa' => 'required|string|max:255',
            'extra_choice' => 'nullable|string|max:255',
            'members' => 'nullable|array',
            'members.*.full_name' => 'required_with:members|string|max:255',
            'members.*.nisn' => 'required_with:members|string|max:255',
            'members.*.gender' => 'required_with:members|string|in:Laki-laki,Perempuan',
            'members.*.birth_place' => 'required_with:members|string|max:255',
            'members.*.birth_date' => 'required_with:members|date',
            'members.*.school' => 'required_with:members|string|max:255',
            'members.*.grade_class' => 'required_with:members|string|max:255',
            'docs' => 'nullable|array',
            'docs.*' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'payment_proof' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        $competition = Competition::findOrFail($validated['competition_id']);

        $participant = Participant::create([
            'nisn' => $validated['nisn'],
            'full_name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'school' => $validated['school'],
            'grade_class' => $validated['grade_class'],
            'address' => $validated['address'],
            'whatsapp' => $validated['whatsapp'],
            'email' => $validated['email'] ?? null,
            'guardian' => $validated['guardian'],
            'guardian_rel' => $validated['guardian_rel'],
            'guardian_wa' => $validated['guardian_wa'],
        ]);

        $nextId = (Registration::max('id') ?? 0) + 1;
        $regNumber = 'AKS-2026-'.str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $registration = Registration::create([
            'reg_number' => $regNumber,
            'status' => 'PENDING',
            'payment_status' => 'NONE',
            'extra_choice' => $validated['extra_choice'] ?? null,
            'participant_id' => $participant->id,
            'competition_id' => $competition->id,
        ]);

        if (! empty($validated['members'])) {
            foreach ($validated['members'] as $member) {
                $registration->members()->create([
                    'full_name' => $member['full_name'],
                    'nisn' => $member['nisn'],
                    'gender' => $member['gender'],
                    'birth_place' => $member['birth_place'],
                    'birth_date' => $member['birth_date'],
                    'school' => $member['school'],
                    'grade_class' => $member['grade_class'],
                ]);
            }
        }

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments/'.$registration->id, 'public');
            $registration->update(['payment_proof_path' => $path]);
        }

        // Handle document uploads
        if ($request->hasFile('docs')) {
            foreach ($request->file('docs') as $idx => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('registrations/'.$registration->id, 'public');
                    $registration->documents()->create([
                        'doc_type' => 'dokumen_'.($idx + 1),
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('kartu.show', $regNumber)->with('success', 'Pendaftaran berhasil! Nomor registrasi: '.$regNumber);
    }
}
