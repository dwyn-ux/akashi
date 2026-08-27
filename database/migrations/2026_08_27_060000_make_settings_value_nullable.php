<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: make value nullable to allow empty settings without 1048 error
        // SQLite already allows it via text, but ensure compat
        try {
            DB::statement('ALTER TABLE settings MODIFY `value` TEXT NULL');
        } catch (\Throwable $e) {
            // fallback for SQLite or already nullable
            try {
                DB::statement('ALTER TABLE settings ALTER COLUMN value DROP NOT NULL');
            } catch (\Throwable $e2) {
                // ignore if already nullable
            }
        }
    }

    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE settings MODIFY `value` TEXT NOT NULL');
        } catch (\Throwable $e) {
        }
    }
};
