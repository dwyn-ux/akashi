<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activities')->insert([
            ['name' => 'Gelar Karya'],
            ['name' => 'Talkshow Bersama Penulis Buku'],
            ['name' => 'Bazar Buku'],
            ['name' => 'Edukasi Dolanan Tradisional'],
            ['name' => 'Edukasi Membatik'],
        ]);
    }
}
