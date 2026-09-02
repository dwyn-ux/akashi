<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\JuaraController as AdminJuaraController;
use App\Http\Controllers\Admin\JuknisController as AdminJuknisController;
use App\Http\Controllers\Admin\KopSuratController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CekController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JuaraController;
use App\Http\Controllers\JuknisController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\KartuPdfController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\PengumumanController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lomba', [LombaController::class, 'index'])->name('lomba.index');
Route::get('/lomba/{slug}', [LombaController::class, 'show'])->name('lomba.show');
Route::get('/daftar', [DaftarController::class, 'index'])->name('daftar.index');
Route::post('/daftar', [DaftarController::class, 'store'])->name('daftar.store');
Route::get('/cek-pendaftaran', [CekController::class, 'index'])->name('cek-pendaftaran');
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/juara', [JuaraController::class, 'index'])->name('juara.index');
Route::get('/juknis', fn () => app(JuknisController::class)->show('juknis'))->name('juknis.show');
Route::get('/dokumentasi', fn () => app(JuknisController::class)->show('dokumentasi'))->name('dokumentasi.show');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::get('/kartu/{regNumber}', [KartuController::class, 'show'])->name('kartu.show');
Route::get('/kartu/{regNumber}/pdf', [KartuPdfController::class, 'show'])->name('kartu.pdf');

Route::get('/admin', fn () => redirect('/admin/login'));

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
});

// Admin authenticated routes (admin middleware)
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/lomba', CompetitionController::class)->parameters(['lomba' => 'competition'])->names('admin.lomba');

    Route::get('/peserta', [ParticipantController::class, 'index'])->name('admin.peserta.index');
    Route::get('/peserta/{participant}', [ParticipantController::class, 'show'])->name('admin.peserta.show');
    Route::patch('/peserta/{participant}/status', [ParticipantController::class, 'updateStatus'])->name('admin.peserta.update-status');
    Route::delete('/peserta/{participant}', [ParticipantController::class, 'destroy'])->name('admin.peserta.destroy');

    Route::get('/pendaftaran', [RegistrationController::class, 'index'])->name('admin.registrations.index');
    Route::get('/pendaftaran/{registration}', [RegistrationController::class, 'show'])->name('admin.registrations.show');
    Route::patch('/pendaftaran/{registration}', [RegistrationController::class, 'update'])->name('admin.registrations.update');
    Route::delete('/pendaftaran/{registration}', [RegistrationController::class, 'destroy'])->name('admin.registrations.destroy');

    Route::get('/jadwal', [ScheduleController::class, 'index'])->name('admin.jadwal.index');
    Route::post('/jadwal', [ScheduleController::class, 'store'])->name('admin.jadwal.store');
    Route::patch('/jadwal/{schedule}', [ScheduleController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/jadwal/{schedule}', [ScheduleController::class, 'destroy'])->name('admin.jadwal.destroy');

    Route::get('/kegiatan', [ActivityController::class, 'index'])->name('admin.kegiatan.index');
    Route::post('/kegiatan', [ActivityController::class, 'store'])->name('admin.kegiatan.store');
    Route::patch('/kegiatan/{activity}', [ActivityController::class, 'update'])->name('admin.kegiatan.update');
    Route::delete('/kegiatan/{activity}', [ActivityController::class, 'destroy'])->name('admin.kegiatan.destroy');

    Route::get('/juara', [AdminJuaraController::class, 'index'])->name('admin.juara.index');
    Route::post('/juara', [AdminJuaraController::class, 'store'])->name('admin.juara.store');
    Route::get('/juara/{juara}/edit', [AdminJuaraController::class, 'edit'])->name('admin.juara.edit');
    Route::put('/juara/{juara}', [AdminJuaraController::class, 'update'])->name('admin.juara.update');
    Route::delete('/juara/{juara}', [AdminJuaraController::class, 'destroy'])->name('admin.juara.destroy');

    Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('admin.pengumuman.index');
    Route::post('/pengumuman', [AnnouncementController::class, 'store'])->name('admin.pengumuman.store');
    Route::get('/pengumuman/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('admin.pengumuman.edit');
    Route::put('/pengumuman/{announcement}', [AnnouncementController::class, 'update'])->name('admin.pengumuman.update');
    Route::patch('/pengumuman/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('admin.pengumuman.toggle');
    Route::delete('/pengumuman/{announcement}', [AnnouncementController::class, 'destroy'])->name('admin.pengumuman.destroy');

    Route::get('/faq', [FaqController::class, 'index'])->name('admin.faq.index');
    Route::post('/faq', [FaqController::class, 'store'])->name('admin.faq.store');
    Route::delete('/faq/{faq}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');

    Route::get('/juknis', [AdminJuknisController::class, 'index'])->name('admin.juknis.index');
    Route::put('/juknis', [AdminJuknisController::class, 'update'])->name('admin.juknis.update');
    Route::get('/export/pendaftaran', [ExportController::class, 'registrations'])->name('admin.export.pendaftaran');
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('admin.pengaturan.index');
    Route::patch('/pengaturan', [SettingController::class, 'update'])->name('admin.pengaturan.update');
    Route::get('/kop-surat', [KopSuratController::class, 'index'])->name('admin.kop-surat.index');
});
