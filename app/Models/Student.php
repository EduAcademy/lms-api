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
        'uuid', 'department_id','studyplan_id',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function studyplan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // , 'study_plan_id', 'group_id',
}
