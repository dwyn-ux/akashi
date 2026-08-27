<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('announcements')->cascadeOnDelete()->index();
            $table->unsignedTinyInteger('place')->index();
            $table->string('participant_name');
            $table->string('school');
            $table->text('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
