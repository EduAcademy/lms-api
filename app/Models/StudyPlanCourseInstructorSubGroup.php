<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlanCourseInstructorSubGroup extends Model
{
    use HasFactory;

    protected $table = 'spc_instructor_sub';

    protected $fillable = [
        'study_plan_course_instructors_id',
        'sub_group_id',
        'instructor_id'
    ];

    // Relationships
    public function studyPlanCourseInstructor()
    {
        return $this->belongsTo(StudyPlanCourseInstructor::class, 'study_plan_course_instructors_id');
    }

    public function subGroup()
    {
        return $this->belongsTo(SubGroups::class, 'sub_group_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
