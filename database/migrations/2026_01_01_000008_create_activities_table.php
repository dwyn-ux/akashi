<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('time_text')->nullable();
            $table->string('location')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
