<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'year_code',
        'year_name',
        'is_active',];

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'academic_year_id');
    }
}
