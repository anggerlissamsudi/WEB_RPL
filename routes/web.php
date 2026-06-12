<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\PublicRegistrationController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ConversionController;
use App\Http\Controllers\Admin\ProgramStudyController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController; 
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Umum / Calon Mahasiswa)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Jalur Pendaftaran Calon Mahasiswa Sisi Public (Bisa diakses setelah login/auth)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/daftar', [PublicRegistrationController::class, 'index'])->name('pendaftaran.index');
    Route::post('/daftar/proses', [PublicRegistrationController::class, 'store'])->name('pendaftaran.store');
    Route::put('/daftar/update/{id}', [PublicRegistrationController::class, 'update'])->name('pendaftaran.update'); // Penambahan Rute Update Berkas
    
    // Dashboard Ringkasan Utama Khusus Sisi Mahasiswa (Menggantikan view bawaan Breeze)
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Diproteksi Auth & Verified)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Master Data - Tahun Akademik (Academic Years)
    Route::resource('academic-years', AcademicYearController::class);
    Route::patch('/academic-years/{id}/toggle', [AcademicYearController::class, 'toggleStatus'])->name('admin.academic-years.toggle');

    // Master Data - Kurikulum (Curricula)
    Route::resource('curricula', CurriculumController::class);
    Route::patch('/curricula/{curriculum}/toggle', [CurriculumController::class, 'toggleStatus'])->name('admin.curricula.toggle-status');

    // Master Data - Mata Kuliah (Courses)
    Route::get('curricula/{curriculum}/courses', [CourseController::class, 'index'])->name('curricula.courses.index');
    Route::post('curricula/{curriculum}/courses', [CourseController::class, 'store'])->name('curricula.courses.store'); 
    Route::put('curricula/{curriculum}/courses/{course}', [CourseController::class, 'update'])->name('curricula.courses.update');
    Route::delete('curricula/{curriculum}/courses/{course}', [CourseController::class, 'destroy'])->name('curricula.courses.destroy');
    
    // Master Data - Program Studi (Program Studies)
    Route::resource('program-studies', ProgramStudyController::class);

    /* | Pendaftaran (Registrations) Sisi Admin
    | URUTAN PENTING: Create diletakkan sebelum rute dengan ID {registration}
    */
    Route::get('registrations', [RegistrationController::class, 'index'])->name('admin.registrations.index');
    Route::get('registrations/create', [RegistrationController::class, 'create'])->name('admin.registrations.create');
    Route::post('registrations', [RegistrationController::class, 'store'])->name('admin.registrations.store');
    
    // Rute Manajemen Data Berdasarkan ID Pendaftar
    Route::get('registrations/{registration}', [RegistrationController::class, 'show'])->name('admin.registrations.show');
    Route::get('registrations/{registration}/edit', [RegistrationController::class, 'edit'])->name('admin.registrations.edit');
    Route::put('registrations/{registration}', [RegistrationController::class, 'update'])->name('admin.registrations.update');
    Route::delete('registrations/{registration}', [RegistrationController::class, 'destroy'])->name('admin.registrations.destroy');
    
    // Fitur Manajemen Konversi Nilai & Cetak PDF yang Baru Kita Sempurnakan
    Route::get('registrations/{registration}/conversion', [ConversionController::class, 'show'])->name('admin.registrations.conversion');
    Route::post('registrations/{registration}/conversion', [ConversionController::class, 'store'])->name('admin.conversions.store');
    Route::get('registrations/{registration}/conversion/pdf', [ConversionController::class, 'exportPdf'])->name('admin.registrations.pdf');

});

/*
|--------------------------------------------------------------------------
| User Profile Routes (Breeze Defaults)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memuat Sistem Autentikasi Breeze (Login, Register, Lupa Password, Reset Link)
require __DIR__.'/auth.php';