<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlanCourse extends Model
{
    use HasFactory;

    protected $table = 'study_plan_courses';

    protected $fillable = [
        'study_plan_id',
        'department_id',
        'course_id',
        'level_id',
        'semester'
    ];

    protected $casts = [
        'prerequisites' => 'array',
        'is_required' => 'boolean'
    ];

    // Relationships
    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function instructors()
    {
        return $this->hasMany(StudyPlanCourseInstructor::class, 'study_plan_course_id');
    }
}
