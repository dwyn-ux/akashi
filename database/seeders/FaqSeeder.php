<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('faqs')->insert([
            [
                'question' => 'Siapa yang bisa mengikuti AKASHI 2026?',
                'answer' => 'AKASHI 2026 terbuka untuk seluruh siswa SD/MI kelas 4, 5, dan 6 di Indonesia.',
                'order' => 1,
            ],
            [
                'question' => 'Bagaimana cara mendaftar?',
                'answer' => 'Pendaftaran dilakukan secara online melalui website resmi AKASHI 2026. Pilih lomba yang diinginkan, lengkapi data diri, dan unggah dokumen yang diperlukan.',
                'order' => 2,
            ],
            [
                'question' => 'Apakah ada biaya pendaftaran?',
                'answer' => 'Tidak ada biaya pendaftaran. Seluruh kegiatan AKASHI 2026 tidak dipungut biaya apapun.',
                'order' => 3,
            ],
            [
                'question' => 'Apakah boleh mendaftar lebih dari satu lomba?',
                'answer' => 'Ya, peserta boleh mendaftar lebih dari satu lomba selama jadwal pelaksanaannya tidak bentrok.',
                'order' => 4,
            ],
            [
                'question' => 'Kapan pelaksanaan AKASHI 2026?',
                'answer' => 'Pelaksanaan AKASHI 2026 akan dilaksanakan pada tanggal 16 September 2026 di SMP Muhammadiyah Unggulan Ashidiq.',
                'order' => 5,
            ],
            [
                'question' => 'Dokumen apa saja yang harus disiapkan?',
                'answer' => 'Dokumen yang diperlukan meliputi: kartu pelajar, surat izin dari orang tua/wali, dan pas foto terbaru. Setiap lomba mungkin memiliki persyaratan dokumen tambahan.',
                'order' => 6,
            ],
            [
                'question' => 'Bagaimana jika ada pertanyaan lebih lanjut?',
                'answer' => 'Hubungi panitia melalui WhatsApp di 0812-7757-0669 (Ust. Nur Wahyudi) untuk informasi lebih lanjut.',
                'order' => 7,
            ],
        ]);
    }
}
