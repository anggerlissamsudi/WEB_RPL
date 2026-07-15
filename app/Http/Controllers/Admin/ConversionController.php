<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Course;
use App\Models\Conversion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ConversionController extends Controller
{
    public function show(Registration $registration)
    {
        $courses = $registration->curriculum 
            ? $registration->curriculum->courses()->orderBy('semester')->get() 
            : collect();

        $conversions = $registration->conversions->keyBy('course_id');

        $existingConversions = $conversions->pluck('is_recognized', 'course_id')->toArray();

        return view('admin.conversion.show', compact(
            'registration', 
            'courses', 
            'conversions', 
            'existingConversions'
        ));
    }

    public function store(Request $request, Registration $registration)
    {
        if (!$request->has('course_ids')) {
            return redirect()->back()->with('error', 'Silakan tentukan pilihan konversi untuk mata kuliah.');
        }

        try {
            DB::beginTransaction(); 

            Conversion::where('registration_id', $registration->id)->delete();

            foreach ($request->course_ids as $courseId => $value) {
                Conversion::create([
                    'registration_id'  => $registration->id,
                    'course_id'        => $courseId,
                    'is_recognized'    => ($value == 'ya'), 
                    'assessment_score' => $request->assessments[$courseId] ?? null,
                    'description'      => $request->descriptions[$courseId] ?? null,
                ]);
            }

            if ($request->input('action') === 'save_and_print') {
                $registration->status = 'converted';
                $registration->save(); 

                DB::commit(); 

                $courses = Course::where('curriculum_id', $registration->curriculum_id)
                                ->orderBy('semester')
                                ->get();

                $conversions = Conversion::where('registration_id', $registration->id)->get()->keyBy('course_id'); 
                
                $summary = [];
                $totalAccepted = 0;
                $totalRequired = 0;

                for ($i = 1; $i <= 7; $i++) {
                    $semCourses = $courses->where('semester', $i);
                    $accepted = 0;
                    $required = 0;

                    foreach ($semCourses as $course) {
                        $conv = $conversions[$course->id] ?? null;
                        if ($conv && $conv->is_recognized) {
                            $accepted += $course->credits;
                        } else {
                            $required += $course->credits;
                        }
                    }
                    $summary[$i] = ['accepted' => $accepted, 'required' => $required];
                    $totalAccepted += $accepted;
                    $totalRequired += $required;
                }

                $pdf = Pdf::loadView('admin.conversion.pdf', compact(
                    'registration', 'courses', 'conversions', 'summary', 'totalAccepted', 'totalRequired'
                ))->setPaper('a4', 'portrait');

                return $pdf->download('FORM_RPL_A_'.$registration->name.'.pdf');
            }

            $registration->status = 'draft_converted';
            $registration->save(); 

            DB::commit(); 

            return redirect()->back()->with('success', 'Draf hasil konversi berhasil disimpan (Belum diterbitkan ke mahasiswa).');

        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function exportPdf(Registration $registration)
    {
        $courses = Course::where('curriculum_id', $registration->curriculum_id)
                        ->orderBy('semester')
                        ->get();

        $conversions = Conversion::where('registration_id', $registration->id)
                                ->get()
                                ->keyBy('course_id'); 
        
        $summary = [];
        $totalAccepted = 0;
        $totalRequired = 0;

        for ($i = 1; $i <= 7; $i++) {
            $semCourses = $courses->where('semester', $i);
            $accepted = 0;
            $required = 0;

            foreach ($semCourses as $course) {
                $conv = $conversions[$course->id] ?? null;
                if ($conv && $conv->is_recognized) {
                    $accepted += $course->credits;
                } else {
                    $required += $course->credits;
                }
            }
            $summary[$i] = ['accepted' => $accepted, 'required' => $required];
            $totalAccepted += $accepted;
            $totalRequired += $required;
        }

        $pdf = Pdf::loadView('admin.conversion.pdf', compact(
            'registration', 'courses', 'conversions', 'summary', 'totalAccepted', 'totalRequired'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('FORM_RPL_A_'.$registration->name.'.pdf');
    }
}