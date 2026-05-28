<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $years = AcademicYear::orderBy('year_code', 'desc')->get();
        return view('admin.academic_year.index', compact('years'));
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
        $request->validate([
            'year_code' => 'required|unique:academic_years,year_code|max:10',
        ]);

        AcademicYear::create($request->all());
        return redirect()->back()->with('success', 'Tahun Akademik berhasil ditambah.');
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
    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'year_code' => 'required|max:10|unique:academic_years,year_code,'.$academicYear->id,
        ]);

        $academicYear->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $year = \App\Models\AcademicYear::findOrFail($id);
            if (!$year->is_active) {
                \App\Models\AcademicYear::where('is_active', true)->update(['is_active' => false]);
                
                $year->is_active = true;
                $message = "Tahun Akademik {$year->year_code} sekarang menjadi periode AKTIF.";
            } else {
                // Jika ingin menonaktifkan
                $year->is_active = false;
                $message = "Tahun Akademik {$year->year_code} berhasil dinonaktifkan.";
            }

            $year->save();

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
