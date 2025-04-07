<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    //
    use HasFactory;
    protected $table = 'instructors';
    protected $fillable = [
        'uuid',
        'professional_title',
        'about_me',
        'social_links',
        'user_id',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function course_materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }


    public function assignment_statuses()
    {
        return $this->hasMany(AssignmentStatus::class);
    }


    public function sub_groups()
    {
        return $this->hasMany(SubGroups::class);
    }

    public function spc_instructors()
    {
        return $this->hasMany(StudyPlanCourseInstructor::class);
    }

    public function spci_sub_groups()
    {
        return $this->hasMany(StudyPlanCourseInstructorSubGroup::class);
    }


    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
