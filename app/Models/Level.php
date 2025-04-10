<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'level_number'
    ];

    // Relationships
    public function sp_courses()
    {
        return $this->hasMany(StudyPlanCourse::class);
    }

    // Correct relationship name
    public function Student()
    {
        return $this->hasMany(Student::class);
    }
}
