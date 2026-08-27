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
        ];

        DB::table('settings')->insert($settings);
    }
}
