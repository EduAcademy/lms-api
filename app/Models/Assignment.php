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
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }


    public function status()
    {
        return $this->hasOne(AssignmentStatus::class);
    }
}
