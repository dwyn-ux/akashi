<?php

namespace App\Http\Controllers\Admin;

use App\Models\Registration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController
{
    public function registrations(Request $request): StreamedResponse
    {
        $query = Registration::with(['participant', 'competition']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($competitionId = $request->input('competition_id')) {
            $query->where('competition_id', $competitionId);
        }

        $registrations = $query->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="pendaftaran-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($registrations) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No', 'No. Registrasi', 'Nama', 'NISN', 'Lomba',
                'Sekolah', 'Kelas', 'WhatsApp', 'Email',
                'Tanggal Daftar', 'Status', 'Pembayaran',
            ]);

            foreach ($registrations as $i => $reg) {
                fputcsv($handle, [
                    $i + 1,
                    $reg->reg_number,
                    $reg->participant->full_name ?? '-',
                    $reg->participant->nisn ?? '-',
                    $reg->competition->name ?? '-',
                    $reg->participant->school ?? '-',
                    $reg->participant->grade_class ?? '-',
                    $reg->participant->whatsapp ?? '-',
                    $reg->participant->email ?? '-',
                    $reg->created_at->format('d-m-Y H:i'),
                    $reg->status,
                    $reg->payment_status ?? 'NONE',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
