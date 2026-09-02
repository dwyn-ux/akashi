<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('info_pages', function (Blueprint $table) {
            $table->text('content_file_path')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('info_pages', function (Blueprint $table) {
            $table->dropColumn('content_file_path');
        });
    }
};
