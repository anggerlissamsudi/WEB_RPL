<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_id', 
        'course_id', 
        'is_recognized',
        'assessment_score', 
        'description'
    ];

    /**
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'program_study_id');
    }
}