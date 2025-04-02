<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'departments';
    protected $fillable = [
        'name',
        'short_name',
        'description',
    ];

    // public function __construct(Department $department)
    // {
    //     $this->department = $department;
    // }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function sp_courses()
    {
        return $this->hasMany(StudyPlanCourse::class);
    }

    public function groups()
    {
        return $this->hasMany(Groups::class);
    }

    public function levels()
    {
        return $this->hasManyThrough(
            Level::class,
            StudyPlanCourse::class,
            'department_id', // Foreign key on study_plan_courses
            'id',           // Foreign key on levels
            'id',           // Local key on departments
            'level_id'      // Local key on study_plan_courses
        )->distinct();
    }
}
