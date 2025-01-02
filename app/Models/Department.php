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
}
