<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('breeding', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained()->onDelete('cascade');
            $table->date('service_date');
            $table->date('expected_birth_date')->nullable();
            $table->date('actual_birth_date')->nullable();
            $table->string('bull_name')->nullable();
            $table->enum('pregnancy_status', ['pending', 'pregnant', 'gave_birth', 'failed'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breeding');
    }
};
