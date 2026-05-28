<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $user = \App\Models\User::find($userId);

        $registration = $user ? $user->registration : null;

        if (!$registration) {
            return redirect()->route('pendaftaran.index');
        }

        return view('student.dashboard', compact('registration'));
    }
}