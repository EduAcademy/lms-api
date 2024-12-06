<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentStatus extends Model
{
    //
    use HasFactory;

    protected $table = 'assignmentstatus';
    protected $fillable = [
        'name', 'description', 'instructor_id',
    ];

    //assignment_id

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    // public function assignment()
    // {
    //     return $this->belongsTo(Assignment::class);
    // }

    public function assignmentsubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
