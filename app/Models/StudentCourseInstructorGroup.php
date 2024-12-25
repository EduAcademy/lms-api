<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentCourseInstructorGroup extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'student_id',
        'instructor_id',
        'course_id',
        'theoretical_groups_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function theoreticalGroup()
    {
        return $this->belongsTo(TheoreticalGroups::class);
    }
}
