<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;

class ProgramStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = ProgramStudy::all();
        return view('admin.prodi.index', compact('prodis'));
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
            'code' => 'required|unique:program_studies,code|max:10',
            'name' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
        ]);

        ProgramStudy::create($validated);

        return redirect()->route('program-studies.index')->with('success', 'Program Studi berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(ProgramStudy $programStudy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudy $programStudy)
    {
        return view('admin.prodi.edit', compact('programStudy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramStudy $programStudy)
    {
        $validated = $request->validate([
            'code' => 'required|max:10|unique:program_studies,code,' . $programStudy->id,
            'name' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'is_active' => 'required|boolean'
        ]);

        $programStudy->update($validated);

        return redirect()->route('program-studies.index')->with('success', 'Data Prodi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudy $programStudy)
    {
        $programStudy->delete();
        return redirect()->route('program-studies.index')->with('success', 'Program Studi telah dihapus.');
    }
}
