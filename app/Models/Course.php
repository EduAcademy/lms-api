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
        'group_hours',
        'sub_group_hours',
    ];

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function sp_courses()
    {
        return $this->hasMany(StudyPlanCourse::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }


    public function grades()
    {
        return $this->hasMany(Grades::class);
    }
}
