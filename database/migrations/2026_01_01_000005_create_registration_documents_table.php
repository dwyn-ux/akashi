<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->string('doc_type');
            $table->string('file_name');
            $table->text('file_path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_documents');
    }
};
