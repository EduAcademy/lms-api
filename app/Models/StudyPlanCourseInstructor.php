<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlanCourseInstructor extends Model
{
    use HasFactory;

    protected $table = 'spc_instructor';

    protected $fillable = [
        'study_plan_courses_id',
        'group_id',
        'instructor_id'
    ];

    // Relationships
    public function studyPlanCourse()
    {
        return $this->belongsTo(StudyPlanCourse::class, 'study_plan_courses_id');
    }

    public function group()
    {
        return $this->belongsTo(Groups::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function subGroups()
    {
        return $this->hasMany(StudyPlanCourseInstructorSubGroup::class, 'study_plan_course_instructors_id');
    }
}
