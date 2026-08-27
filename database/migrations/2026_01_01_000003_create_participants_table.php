<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->string('full_name')->index();
            $table->string('gender');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('school')->index();
            $table->string('grade_class');
            $table->text('address');
            $table->string('whatsapp');
            $table->string('email')->nullable();
            $table->string('guardian');
            $table->string('guardian_rel');
            $table->string('guardian_wa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
