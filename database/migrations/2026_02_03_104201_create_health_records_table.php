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
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained()->onDelete('cascade');
            $table->date('record_date');
            $table->string('condition');
            $table->text('treatment')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('vaccination')->nullable();
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
        Schema::dropIfExists('health_records');
    }
};
