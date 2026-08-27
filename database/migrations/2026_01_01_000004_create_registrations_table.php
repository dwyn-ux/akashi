<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reg_number')->unique();
            $table->string('status')->default('PENDING')->index();
            $table->string('payment_status')->default('NONE');
            $table->text('admin_note')->nullable();
            $table->string('extra_choice')->nullable();
            $table->foreignId('participant_id')->constrained('participants')->cascadeOnDelete();
            $table->foreignId('competition_id')->constrained('competitions')->cascadeOnDelete()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
