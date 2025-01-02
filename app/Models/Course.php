<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    //
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'name',
        'description',
        'course_code',
        'course_hours',
        'type',
    ];

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function sp_courses()
    {
        return $this->hasMany(StudyPlanCourse::class);
    }
}
