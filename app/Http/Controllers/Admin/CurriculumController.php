<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = \App\Models\Curriculum::query();

        if (request()->filled('prodi')) {
            $query->where('program_study_id', request()->prodi);
        }

        $curricula = $query->with(['academicYear', 'programStudy'])->get();
        $years = \App\Models\AcademicYear::all();
        $programStudies = \App\Models\ProgramStudy::all();

        return view('admin.curriculum.index', compact('curricula', 'years', 'programStudies'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'academic_year_id' => 'required|exists:academic_years,id',
        'program_study_id' => 'required|exists:program_studies,id',
        'code'             => 'required|unique:curricula,code',
        'name'             => 'required|string|max:255', 
    ]);

        $validated['is_active'] = false;

        \App\Models\Curriculum::create($validated);
        return redirect()->back()->with('success', 'Kurikulum berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curriculum $curriculum)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'code' => 'required|max:20|unique:curricula,code,' . $curriculum->id,
            'name' => 'required|string|max:255',
        ]);

        $curriculum->update($request->all());

        return redirect()->back()->with('success', 'Kurikulum berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum)
    {
        $curriculum->delete();
        return redirect()->back()->with('success', 'Kurikulum berhasil dihapus.');
    }

    public function activate($id)
    {
        $targetCurriculum = Curriculum::findOrFail($id);

        Curriculum::where('name', 'LIKE', '%' . $targetCurriculum->name . '%')
                ->update(['is_active' => false]);

        $targetCurriculum->update(['is_active' => true]);

        return back()->with('success', 'Kurikulum ' . $targetCurriculum->name . ' sekarang menjadi kurikulum aktif.');
    }

    public function toggleStatus(Curriculum $curriculum)
    {
        if (!$curriculum->is_active) {
            Curriculum::where('program_study_id', $curriculum->program_study_id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
                
            $curriculum->is_active = true;
            
            $prodiName = $curriculum->programStudy ? $curriculum->programStudy->name : $curriculum->program_study_id;
            $message = "Kurikulum {$curriculum->name} untuk prodi {$prodiName} sekarang AKTIF.";
        } else {
            $curriculum->is_active = false;
            $message = "Kurikulum {$curriculum->name} DINONAKTIFKAN.";
        }

        $curriculum->save();
        return back()->with('success', $message);
    }
}