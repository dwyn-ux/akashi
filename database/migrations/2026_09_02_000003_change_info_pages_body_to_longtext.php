<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE info_pages MODIFY body LONGTEXT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE info_pages ALTER COLUMN body TYPE TEXT');
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE info_pages MODIFY body TEXT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE info_pages ALTER COLUMN body TYPE VARCHAR(65535)');
        }
    }
};
