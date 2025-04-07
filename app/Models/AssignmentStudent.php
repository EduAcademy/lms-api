<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentStudent extends Model
{
    use HasFactory;

    protected $table = 'assignment_students';

    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission_link',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
