<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlanCourseInstructor extends Model
{
    use HasFactory;

    protected $table = 'spc_instructor';

    protected $fillable = [
        'study_plan_course_id',
        'group_id',
        'instructor_id'
    ];

    // Relationships
    public function sp_course()
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

    public function spci_sub_groups()
    {
        return $this->hasMany(StudyPlanCourseInstructorSubGroup::class, 'study_plan_course_instructors_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
