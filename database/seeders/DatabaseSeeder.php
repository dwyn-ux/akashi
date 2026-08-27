<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            CompetitionSeeder::class,
            ScheduleSeeder::class,
            ActivitySeeder::class,
            FaqSeeder::class,
            InfoPageSeeder::class,
        ]);
    }
}
