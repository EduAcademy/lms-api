<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmission extends Model
{
    //
    use HasFactory;

    protected $table = 'assignmentsubmissions';
    protected $fillable = [
        'data', 'file_url', 'assignmentstatus_id',
    ];

    public function assignmentstatus()
    {
        return $this->belongsTo(AssignmentStatus::class);
    }
}
