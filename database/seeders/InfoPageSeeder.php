<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoPageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('info_pages')->insert([
            [
                'slug' => 'juknis',
                'title' => 'Juknis Lomba',
                'body' => '<ol>
<li>Peserta adalah siswa SD/MI kelas 4, 5, dan 6 yang sedang aktif pada tahun ajaran 2026/2027.</li>
<li>Setiap peserta wajib membawa kartu pelajar atau surat keterangan aktif dari sekolah asal.</li>
<li>Peserta harus hadir di lokasi lomba minimal 30 menit sebelum jadwal dimulai.</li>
<li>Panitia berhak mendiskualifikasi peserta yang melakukan kecurangan selama perlombaan.</li>
<li>Keputusan dewan juri bersifat mutlak dan tidak dapat diganggu gugat.</li>
<li>Peserta lomba beregu harus terdiri dari siswa dari sekolah yang sama.</li>
<li>Panitia tidak bertanggung jawab atas kehilangan atau kerusakan barang bawaan peserta.</li>
</ol>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'dokumentasi',
                'title' => 'Dokumentasi',
                'body' => '<p>Dokumentasi kegiatan AKASHI 2026 akan tersedia di halaman ini setelah pelaksanaan event. Nantikan foto-foto dan video menarik dari seluruh rangkaian kegiatan.</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
