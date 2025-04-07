<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    //
    protected $table = 'absence';
    protected $fillable = [
        'course_id',
        'group_id',
        'student_id',
        'instructor_id',
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function group()
    {
        return $this->belongsTo(Groups::class);
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
