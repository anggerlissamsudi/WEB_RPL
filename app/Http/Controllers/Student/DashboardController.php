<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::find(Auth::id());
        
        $registration = $user ? $user->registration : null;

        $courses = collect();
        $conversions = collect();

        if ($registration) {
            $courses = $registration->curriculum 
                ? $registration->curriculum->courses()->orderBy('semester')->get() 
                : collect();

            $conversions = $registration->conversions->keyBy('course_id');
        }

        return view('student.dashboard', compact('registration', 'courses', 'conversions'));
    }
}