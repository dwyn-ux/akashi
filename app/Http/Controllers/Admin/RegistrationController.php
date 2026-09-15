<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
            'certificate' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'remove_certificate' => 'nullable|boolean',
        ]);

        if ($request->boolean('remove_certificate') && $registration->certificate_path) {
            Storage::disk('public')->delete($registration->certificate_path);
            $registration->certificate_path = null;
        }

        if ($request->hasFile('certificate')) {
            if ($registration->certificate_path) {
                Storage::disk('public')->delete($registration->certificate_path);
            }
            $registration->certificate_path = $request->file('certificate')->store('certificates/'.$registration->id, 'public');
        }

        unset($validated['certificate'], $validated['remove_certificate']);
        $registration->update($validated);

        return back()->with('success', 'Registrasi berhasil diperbarui.');
    }

    public function bulkCertificates(Request $request, Competition $competition)
    {
        $request->validate(['zip' => 'required|file|max:51200|mimes:zip']);

        $zip = new ZipArchive;
        if ($zip->open($request->file('zip')->getRealPath()) !== true) {
            return back()->with('error', 'File ZIP tidak dapat dibuka.');
        }

        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        $regs = Registration::where('competition_id', $competition->id)->get()->keyBy(fn ($r) => strtolower($r->reg_number));
        $ok = 0;
        $fail = [];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if (str_ends_with($name, '/')) {
                continue;
            }
            $base = basename($name);
            $ext = strtolower(pathinfo($base, PATHINFO_EXTENSION));
            $key = strtolower(pathinfo($base, PATHINFO_FILENAME));
            if (! in_array($ext, $allowed, true)) {
                $fail[] = $base.' (format tidak didukung)';

                continue;
            }
            if (! isset($regs[$key])) {
                $fail[] = $base.' (nomor registrasi tidak cocok)';

                continue;
            }
            $reg = $regs[$key];
            $stream = $zip->getStream($name);
            if (! $stream) {
                $fail[] = $base.' (gagal dibaca)';

                continue;
            }
            if ($reg->certificate_path) {
                Storage::disk('public')->delete($reg->certificate_path);
            }
            $path = 'certificates/'.$reg->id.'/'.preg_replace('/[^A-Za-z0-9._-]/', '_', $base);
            Storage::disk('public')->put($path, stream_get_contents($stream));
            fclose($stream);
            $reg->update(['certificate_path' => $path]);
            $ok++;
        }
        $zip->close();

        $msg = "Sertifikat bulk: {$ok} berhasil.";
        if ($fail) {
            $msg .= ' Gagal: '.implode(', ', array_slice($fail, 0, 10)).(count($fail) > 10 ? ' (+'.(count($fail) - 10).' lainnya)' : '');
        }

        return back()->with($ok ? 'success' : 'error', $msg);
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('success', 'Registrasi berhasil dihapus.');
    }
}
