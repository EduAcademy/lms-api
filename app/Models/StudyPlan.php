<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyPlan extends Model
{
    //
    use HasFactory;

    protected $table = 'study_plans';
    protected $fillable = [
        'name',
        'number',
        'start_date'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function sp_courses()
    {
        return $this->hasMany(StudyPlanCourse::class);
    }


}
