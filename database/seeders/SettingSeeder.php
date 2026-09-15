<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'event_name', 'value' => 'AKASHI 2026'],
            ['key' => 'event_full_name', 'value' => 'Ajang Kreasi Ashidiq'],
            ['key' => 'school_name', 'value' => 'SMP Muhammadiyah Unggulan Ashidiq'],
            ['key' => 'tagline', 'value' => 'Bangun Generasi Qur\'ani'],
            ['key' => 'event_date', 'value' => '2026-09-16T07:00:00+07:00'],
            ['key' => 'registration_open_date', 'value' => '2026-09-01T00:00:00+07:00'],
            ['key' => 'location', 'value' => ''],
            ['key' => 'whatsapp', 'value' => '6281277570669'],
            ['key' => 'whatsapp_label', 'value' => '0812-7757-0669 (Ust. Nur Wahyudi)'],
            ['key' => 'instagram', 'value' => ''],
            ['key' => 'email', 'value' => ''],
            ['key' => 'address', 'value' => ''],
            ['key' => 'footer_text', 'value' => '© 2026 AKASHI — Ajang Kreasi Ashidiq • SMP Muhammadiyah Unggulan Ashidiq'],
            ['key' => 'registration_status', 'value' => 'OPEN'],
            ['key' => 'countdown_target', 'value' => '2026-09-16T07:00:00+07:00'],
            ['key' => 'closed_title', 'value' => 'Pendaftaran Telah Ditutup'],
            ['key' => 'closed_message', 'value' => 'Terima kasih atas antusiasme seluruh peserta AKASHI 2026. Sampai jumpa di kegiatan kami berikutnya!'],
            ['key' => 'next_event_label', 'value' => 'AKASHI 2027'],
            ['key' => 'certificate_mode', 'value' => 'global'],
            ['key' => 'certificate_title', 'value' => 'Sertifikat Penghargaan'],
            ['key' => 'certificate_body', 'value' => 'Diberikan dengan bangga kepada {nama} atas partisipasi pada lomba {lomba} ({kategori})'],
            ['key' => 'certificate_layout', 'value' => '{"title":{"x":50,"y":20,"size":38,"align":"center","color":"#14253D","visible":true},"name":{"x":50,"y":46,"size":30,"align":"center","color":"#5B2BE0","visible":true},"body":{"x":50,"y":60,"size":13,"align":"center","color":"#4B5563","visible":true},"meta":{"x":50,"y":88,"size":10,"align":"center","color":"#9CA3AF","visible":true}}'],
        ];

        DB::table('settings')->insert($settings);
    }
}
