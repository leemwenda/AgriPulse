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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag_number')->unique();
            $table->string('breed');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('color')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'sold', 'deceased'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
