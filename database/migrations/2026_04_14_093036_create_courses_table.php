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
        Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('curriculum_id')->constrained()->onDelete('cascade');
        $table->string('course_code'); // Kode MK
        $table->string('course_name'); // Nama MK
        $table->integer('credits');    // SKS
        $table->integer('semester');   // Semester (1-8)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
