<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curriculum extends Model
{
    protected $fillable = ['academic_year_id', 'program_study_id', 'code', 'name', 'is_active'];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function programStudy() 
    {
        return $this->belongsTo(ProgramStudy::class, 'program_study_id');
    }
}
