<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\AcademicYear;

class RegistrationController extends Controller
{
    public function index()
    {
        $query = \App\Models\Registration::query();

        if (request()->filled('search')) {
            $query->where('name', 'like', '%' . request()->search . '%');
        }

        if (request()->filled('prodi')) {
            $query->where('program_study_id', request()->prodi);
        }

        if (request()->filled('tahun')) {
            $query->where('academic_year_id', request()->tahun);
        }

        if (request()->filled('status')) {
            $query->where('status', request()->status);
        }

        $registrations = $query->with(['programStudy', 'academicYear'])
                            ->latest()
                            ->paginate(10)
                            ->withQueryString();

        $programStudies = \App\Models\ProgramStudy::all();
        $years = \App\Models\AcademicYear::orderBy('year_code', 'desc')->get();

        return view('admin.registrations.index', compact('registrations', 'years', 'programStudies'));
    }

    public function show(Registration $registration)
    {
        $registration->load('programStudy');
        
        return view('admin.registrations.show', compact('registration'));
    }

    //Admin CRUD Data Pendaftar
    public function create()
    {
        $programStudies = \App\Models\ProgramStudy::all();
        return view('pendaftaran', compact('programStudies'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'program_study_id' => 'required|exists:program_studies,id',
            'nik' => 'required|numeric|digits:16',
            'kk' => 'required|numeric|digits:16',
            'address' => 'required',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'file_ijazah_sma' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ];

        $validated = $request->validate($rules);

        $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();
        if (!$activeYear) {
            return redirect()->back()->withInput()->with('error', 'Gagal: Tidak ada Tahun Akademik yang berstatus AKTIF.');
        }

        $activeCurriculum = \App\Models\Curriculum::where('is_active', true)
            ->where('program_study_id', $request->program_study_id) 
            ->first();

        if (!$activeCurriculum) {
            $prodiName = \App\Models\ProgramStudy::find($request->program_study_id)->name;
            return redirect()->back()->withInput()->with('error', 'Gagal: Kurikulum aktif untuk prodi ' . $prodiName . ' tidak ditemukan.');
        }

        $validated['academic_year_id'] = $activeYear->id;
        $validated['program_study_id'] = $request->program_study_id; 
        $validated['curriculum_id']    = $activeCurriculum->id;
        
        $validated['registration_number'] = 'REG-' . date('Ymd') . '-' . rand(1000, 9999);
        $validated['status'] = 'pending';

        // File Upload
        if ($request->hasFile('file_ktp')) {
            $validated['file_ktp'] = $request->file('file_ktp')->store('pendaftaran/ktp', 'public');
        }
        if ($request->hasFile('file_ijazah_sma')) {
            $validated['file_ijazah_sma'] = $request->file('file_ijazah_sma')->store('pendaftaran/ijazah', 'public');
        }
        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('pendaftaran/sertifikat', 'public');
        }

        \App\Models\Registration::create($validated);

        return redirect()->route('admin.registrations.index')->with('success', 'Pendaftaran berhasil disimpan otomatis berdasarkan Periode Aktif.');
        
    }

    public function edit(Registration $registration)
    {
        $academicYears = \App\Models\AcademicYear::orderBy('year_code', 'desc')->get();
        return view('admin.registrations.edit', compact('registration', 'academicYears'));
    }

    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'program_study' => 'required',
            'nik' => 'required|numeric|digits:16',
            'kk' => 'required|numeric|digits:16',
            'address' => 'required',
            'mother_name' => 'required|string|max:255',
            'nisn' => 'required|numeric|digits:10|unique:registrations,nisn,' . $registration->id,
        ]);

        if ($request->hasFile('birth_certificate')) {
            $request->validate(['birth_certificate' => 'file|mimes:pdf,jpg,png|max:2048']);
            if ($registration->birth_certificate) {
                \Storage::disk('public')->delete($registration->birth_certificate);
            }
            $validated['birth_certificate'] = $request->file('birth_certificate')->store('pendaftaran/akta', 'public');
        }

        $registration->update($validated);

        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    public function destroy(Registration $registration)
    {
        // Hapus file fisik jika ada sebelum menghapus data di database
        if ($registration->file_ktp) \Storage::disk('public')->delete($registration->file_ktp);
        
        $registration->delete();
        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }
}
