<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['curriculum_id', 'course_code', 'course_name', 'credits', 'semester'];
}
