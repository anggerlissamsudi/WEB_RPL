<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Curriculum $curriculum)
    {
        $courses = $curriculum->courses()->orderBy('semester')->get();
        return view('admin.course.index', compact('curriculum', 'courses'));
    }

    public function store(Request $request, Curriculum $curriculum)
    {
        $request->validate([
            'course_code' => 'required',
            'course_name' => 'required',
            'credits' => 'required|numeric',
            'semester' => 'required|numeric',
        ]);

       #$curriculum->courses()->create($request->all());
       $curriculum->courses()->create($request->all());

        return redirect()->back()->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function update(Request $request, Curriculum $curriculum, Course $course)
    {
        $request->validate([
            'course_code' => 'required',
            'course_name' => 'required',
            'credits' => 'required|numeric',
            'semester' => 'required|numeric',
        ]);

        $course->update($request->all());

        return redirect()->back()->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(Curriculum $curriculum, Course $course)
    {
        $course->delete();
        return redirect()->back()->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
