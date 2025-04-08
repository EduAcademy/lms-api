<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmission extends Model
{
    //
    use HasFactory;

    protected $table = 'assignment_submissions';
    protected $fillable = [
        'data',
        'file_url',
        'assignment_status_id',
        'assignment_id',
        'student_id',
    ];

    public function assignment_status()
    {
        return $this->belongsTo(AssignmentStatus::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
