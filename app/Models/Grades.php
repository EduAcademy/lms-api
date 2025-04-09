<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    //
    protected $table = 'grades';
    protected $fillable = [
        'course_id',
        'group_id',
        'student_id',
        'instructor_id',
        'sub_group_id',
        'grade',
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function group()
    {
        return $this->belongsTo(Groups::class);
    }

    public function subGroup()
    {
        return $this->belongsTo(SubGroups::class);
    }


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
