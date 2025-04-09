<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Groups extends Model
{
    //
    use HasFactory, Searchable;


    protected $fillable = [
        'name',
        'department_id'
    ];

    public function sub_groups()
    {
        return $this->hasMany(SubGroups::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function spc_instructors()
    {
        return $this->hasMany(StudyPlanCourseInstructor::class);
    }


    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function grades()
    {
        return $this->hasMany(Grades::class);
    }
}
