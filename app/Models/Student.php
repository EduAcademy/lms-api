<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    //
    use HasFactory;
    protected $table = 'students';
    protected $fillable = [
        'uuid',
        'department_id',
        'study_plan_id',
        'user_id',
    ];
    /**
     * The department that the student belongs to
     *
     * @return BelongsTo
     */


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function study_plan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentCourseInstructors()
    {
        return $this->hasMany(StudentCourseInstructor::class);
    }
}
