<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category')->default('Akademik');
            $table->string('level')->default('SD');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('min_age')->nullable();
            $table->unsignedTinyInteger('max_age')->nullable();
            $table->string('grade_class')->nullable();
            $table->unsignedInteger('quota')->default(0);
            $table->unsignedInteger('fee')->default(0);
            $table->string('location')->nullable();
            $table->string('schedule_text')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->default('DRAFT')->index();
            $table->string('cover_url')->nullable();
            $table->unsignedTinyInteger('team_size')->default(1);
            $table->string('prize_1')->nullable();
            $table->string('prize_2')->nullable();
            $table->string('prize_3')->nullable();
            $table->string('prize_extra')->nullable();
            $table->text('requirements')->nullable();
            $table->text('rules')->nullable();
            $table->text('required_docs')->nullable();
            $table->string('contact_person')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
