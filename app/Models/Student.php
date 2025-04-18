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
        'group_id',
        'sub_group_id',
        'level_id',  // Add this line

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
        return $this->belongsTo(User::class, 'user_id');
    }
    // Correct relationship name
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
    public function group()
    {
        return $this->belongsTo(Groups::class);
    }

    public function sub_group()
    {
        return $this->belongsTo(SubGroups::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function assignment_submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }


    public function grades()
    {
        return $this->hasMany(Grades::class);
    }
}
