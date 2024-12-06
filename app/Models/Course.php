<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    //
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'name', 'description', 'course_code', 'course_hours', 'type', 'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function coursematerials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

}
