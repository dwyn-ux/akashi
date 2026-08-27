<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('schedules')->insert([
            [
                'title' => 'Pendaftaran dibuka',
                'date' => '2026-09-01 00:00:00',
            ],
            [
                'title' => 'Pelaksanaan AKASHI 2026',
                'date' => '2026-09-16 07:00:00',
            ],
        ]);
    }
}
