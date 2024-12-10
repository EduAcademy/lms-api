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
        'study_plan_no',
        'level',
        'semester',
        'issued_at',
        'department_id',
        'course_id',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
