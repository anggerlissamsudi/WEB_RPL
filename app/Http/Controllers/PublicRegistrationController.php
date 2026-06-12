<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\ProgramStudy;
use App\Models\AcademicYear;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicRegistrationController extends Controller
{
    public function index()
    {
        $programStudies = ProgramStudy::all();
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $registration = $user->registration;

        if ($registration && $registration->status === 'converted') {
            return redirect()->route('dashboard')->with('error', 'Data Anda sudah disetujui dan dikonversi oleh admin, data tidak dapat diubah lagi.');
        }

        return view('pendaftaran', compact('programStudies', 'registration'));
    }    
    
    public function store(Request $request)
    {
        // 1. Definisikan Aturan Validasi Mutlak (Wajib File Saat Daftar Baru)
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'program_study_id' => 'required|exists:program_studies,id',
            'nik' => 'required|numeric|digits:16',
            'kk' => 'required|numeric|digits:16',
            'address' => 'required',
            'mother_name' => 'required|string|max:255',
            'nisn' => 'required|numeric|digits:10|unique:registrations,nisn',

            'birth_certificate' => 'required|file|mimes:pdf,jpg,png|max:10240', 
            'file_ktp' => 'required|file|mimes:pdf,jpg,png|max:10240',
            'file_ijazah_sma' => 'required|file|mimes:pdf,jpg,png|max:10240',
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,png|max:10240',
            'file_ijazah_d3' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'file_kk' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ];

        // Validasi awal
        $validated = $request->validate($rules);

        // Cari Tahun Akademik & Kurikulum Aktif
        $activeYear = AcademicYear::where('is_active', true)->first();
        if (!$activeYear) {
            return redirect()->back()->withInput()->with('error', 'Gagal: Tidak ada Tahun Akademik (Periode) yang aktif saat ini.');
        }

        $activeCurriculum = Curriculum::where('program_study_id', $request->program_study_id)
            ->where('is_active', true)
            ->first();

        if (!$activeCurriculum) {
            $prodiName = ProgramStudy::find($request->program_study_id)->name;
            return redirect()->back()->withInput()->with('error', 'Gagal: Kurikulum aktif untuk prodi ' . $prodiName . ' tidak ditemukan.');
        }

        // 3. Susun Array Data Bersih Untuk Disimpan ke Database
        // Ini mencegah file temporer XAMPP bocor masuk ke query database
        $dataToSave = [
            $validated['user_id']          = Auth::id(),
            $validated['academic_year_id'] = $activeYear->id,
            $validated['program_study_id'] = $request->program_study_id,
            $validated['curriculum_id']    = $activeCurriculum->id,
            $validated['mother_name']      = $request->mother_name,
            $validated['nisn']             = $request->nisn,
            $validated['registration_number'] = 'REG-' . date('Ymd') . '-' . rand(1000, 9999),
            $validated['status'] = 'pending',
        ];

        // 4. Proses File Upload yang Benar dan Valid
        if ($request->hasFile('file_ktp')) {
            $validated['file_ktp'] = $request->file('file_ktp')->store('pendaftaran/ktp', 'public');
        }
        
        // PASTIKAN BLOK INI ADA: Memproses file KK fisik
        if ($request->hasFile('file_kk')) {
            $validated['file_kk'] = $request->file('file_kk')->store('pendaftaran/kk', 'public');
        }
        
        if ($request->hasFile('file_ijazah_sma')) {
            $validated['file_ijazah_sma'] = $request->file('file_ijazah_sma')->store('pendaftaran/ijazah', 'public');
        }
        
        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('pendaftaran/sertifikat', 'public');
        }
        
        if ($request->hasFile('file_ijazah_d3')) {
            $validated['file_ijazah_d3'] = $request->file('file_ijazah_d3')->store('pendaftaran/ijazah_d3', 'public');
        }

        // KOREKSI UTAMA AKTA: Gunakan key array validated, bukan langsung request file temp!
        if ($request->hasFile('birth_certificate')) {
            $validated['birth_certificate'] = $request->file('birth_certificate')->store('pendaftaran/akta', 'public');
        }

        // 5. Simpan (Mass Assignment)
        \App\Models\Registration::create($validated);

        return redirect()->back()->with('success', 'Pendaftaran Anda berhasil dikirim! Silakan tunggu konfirmasi Admin.');
    }

    public function update(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        if ($registration->status === 'converted') {
            return redirect()->route('dashboard')->with('error', 'Data sudah dikonversi dan dikunci oleh admin.');
        }

        $rules = [
            'birth_place_date' => 'required|string|max:255',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'marital_status' => 'required|in:Belum Kawin,Sudah Kawin',
            'school_name' => 'required|string|max:255',
            'phone' => 'required',
            'graduation_year' => 'required|digits:4',
            'nationality' => 'required|string',
            'program_study_id' => 'required|exists:program_studies,id',
            'nik' => 'required|numeric|digits:16',
            'kk' => 'required|numeric|digits:16',
            'address' => 'required',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'file_ijazah_sma' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'file_ijazah_d3' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ];

        $validated = $request->validate($rules);

        if ($registration->program_study_id != $request->program_study_id) {
            $activeCurriculum = Curriculum::where('is_active', true)
                ->where('program_study_id', $request->program_study_id)
                ->first();

            if (!$activeCurriculum) {
                $prodiName = ProgramStudy::find($request->program_study_id)->name;
                return redirect()->back()->withInput()->with('error', 'Gagal: Kurikulum aktif untuk prodi ' . $prodiName . ' tidak ditemukan.');
            }
            $validated['curriculum_id'] = $activeCurriculum->id;
        }

        $fileFields = ['file_ktp', 'file_kk', 'file_ijazah_sma', 'file_sertifikat', 'file_ijazah_d3'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($registration->$field) {
                    Storage::disk('public')->delete($registration->$field);
                }
                $validated[$field] = $request->file($field)->store('pendaftaran/' . str_replace('file_', '', $field), 'public');
            }
        }

        try {
            $registration->update($validated);
            return redirect()->route('dashboard')->with('success', 'Data pendaftaran Anda berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}