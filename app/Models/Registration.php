<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'registration_number', 
        'academic_year_id',
        'program_study_id',    
        'curriculum_id',  
        'name',
        'birth_place_date', 
        'gender',           
        'marital_status', 
        'address', 
        'email',
        'school_name', 
        'phone',
        'graduation_year',  
        'nationality', 
        'nik', 
        'kk', 
        'mother_name',       // Selesai ditambahkan
        'nisn',       
        'referral',       // Selesai ditambahkan
        'birth_certificate', // Selesai ditambahkan
        'file_ktp', 
        'file_kk', 
        'file_ijazah_sma', 
        'file_sertifikat', 
        'file_ijazah_d3',
        'status',
    ];
    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'conversions')
                    ->withPivot('assessment_score', 'description');
    }
    
    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class, 'program_study_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
