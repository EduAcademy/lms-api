<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    //
    use HasFactory;

    protected $table = 'assignments';
    protected $fillable = [
        'title',
        'instructions',
        'due_date',
        'instructor_id',
        'study_plan_course_instructor_id',
        'study_plan_course_instructor_sub_group_id'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function spc_instructor()
    {
        return $this->belongsTo(StudyPlanCourseInstructor::class);
    }

    public function spci_sub_group()
    {
        return $this->belongsTo(StudyPlanCourseInstructorSubGroup::class);
    }

    public function assignment_submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
