<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentStatus extends Model
{
    //
    use HasFactory;

    protected $table = 'assignment_status';
    protected $fillable = [
        'name',
        'description',
        'instructor_id',
    ];

    //assignment_id

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function assignment_submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
