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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('registration_number')->unique();
            
            $table->foreignId('program_study_id')->constrained();
            $table->foreignId('academic_year_id')->constrained();
            $table->foreignId('curriculum_id')->constrained();
            
            $table->string('name');
            $table->string('birth_place_date')->nullable(); 
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->default('Indonesia');
            $table->text('address');
            $table->string('email');
            $table->string('phone');
            $table->string('school_name')->nullable();
            $table->year('graduation_year')->nullable();
            $table->string('nik', 16);
            $table->string('kk', 16);
            
            $table->string('file_ktp');
            $table->string('file_kk');
            $table->string('file_ijazah_sma');
            $table->string('file_sertifikat'); 
            $table->string('file_ijazah_d3')->nullable();  
            
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
