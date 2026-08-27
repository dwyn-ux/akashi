<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete()->index();
            $table->string('full_name');
            $table->string('nisn');
            $table->string('gender');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('school');
            $table->string('grade_class');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_members');
    }
};
