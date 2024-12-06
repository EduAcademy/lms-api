<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CourseMaterial extends Model
{
    //
    use HasFactory;

    protected $table = 'coursematerials';
    protected $fillable = [
        'name', 'type', 'url', 'course_id', 'instructor_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
    
}
