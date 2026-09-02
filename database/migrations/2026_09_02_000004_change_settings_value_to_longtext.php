<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE settings MODIFY value LONGTEXT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE settings ALTER COLUMN value TYPE TEXT');
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE settings MODIFY value TEXT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE settings ALTER COLUMN value TYPE VARCHAR(65535)');
        }
    }
};
