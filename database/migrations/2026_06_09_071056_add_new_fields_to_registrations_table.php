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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('mother_name')->nullable()->after('name');
            
            // KOREKSI: Buat nullable() dulu agar data lama tidak error saat migrasi berjalan
            $table->string('nisn', 10)->nullable()->after('mother_name');
            
            $table->string('birth_certificate')->nullable()->after('nisn');
        });

        // Tambahkan indeks unik secara terpisah setelah kolomnya tercipta
        // Catatan: Indeks unik di MySQL mengizinkan banyak nilai NULL, jadi data lama aman!
        Schema::table('registrations', function (Blueprint $table) {
            $table->unique('nisn');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique(['registrations_nisn_unique']);
            $table->dropColumn(['mother_name', 'nisn', 'birth_certificate']);
        });
    }
};
