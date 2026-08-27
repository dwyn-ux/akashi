<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Participant;
use App\Models\Registration;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLomba = Competition::count();
        $totalPeserta = Participant::count();
        $pendaftaranHariIni = Registration::whereDate('created_at', Carbon::today())->count();
        $terverifikasi = Registration::where('status', 'VERIFIED')->count();
        $menungguVerifikasi = Registration::where('status', 'PENDING')->count();
        $ditolak = Registration::where('status', 'REJECTED')->count();

        return view('admin.dashboard', compact(
            'totalLomba', 'totalPeserta', 'pendaftaranHariIni',
            'terverifikasi', 'menungguVerifikasi', 'ditolak'
        ));
    }
}
