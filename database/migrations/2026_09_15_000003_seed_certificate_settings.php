<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'certificate_mode' => 'global',
            'certificate_title' => 'Sertifikat Penghargaan',
            'certificate_body' => 'Diberikan dengan bangga kepada {nama} atas partisipasi pada lomba {lomba} ({kategori})',
            'certificate_layout' => '{"title":{"x":50,"y":20,"size":38,"align":"center","color":"#14253D","visible":true},"name":{"x":50,"y":46,"size":30,"align":"center","color":"#5B2BE0","visible":true},"body":{"x":50,"y":60,"size":13,"align":"center","color":"#4B5563","visible":true},"meta":{"x":50,"y":88,"size":10,"align":"center","color":"#9CA3AF","visible":true}}',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('settings')->updateOrInsert(['key' => $key], ['value' => $value]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['certificate_mode', 'certificate_title', 'certificate_body', 'certificate_layout'])->delete();
    }
};
