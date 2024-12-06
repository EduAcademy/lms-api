<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyPlan extends Model
{
    //
    use HasFactory;

    protected $table = 'studyplans';
    protected $fillable = [
        'studyplan_no', 'level', 'semester', 'issued_at', 'department_id',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
