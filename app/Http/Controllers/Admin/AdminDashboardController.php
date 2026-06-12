<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $pendingCount = Registration::where('status', 'pending')->count();

        $convertedCount = Registration::where('status', 'converted')->count();

        $yearlyStats = Registration::select('academic_year_id', DB::raw('count(*) as total'))
            ->groupBy('academic_year_id')
            ->with('academicYear')
            ->get();

        $chartLabels = [];
        $chartData = [];

        foreach ($yearlyStats as $stat) {
            $chartLabels[] = $stat->academicYear ? $stat->academicYear->year_name : 'Tahun Tidak Diketahui';
            $chartData[] = $stat->total;
        }

        $convertedByYear = AcademicYear::withCount(['registrations as total_converted' => function($query) {
            $query->where('status', 'converted');
        }])->orderBy('year_code', 'desc')->get();

        return view('admin.dashboard', compact(
            'pendingCount', 
            'convertedCount', 
            'chartLabels', 
            'chartData', 
            'convertedByYear'
        ));
    }
}