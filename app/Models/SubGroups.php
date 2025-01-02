<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubGroups extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'groups_id',
        'instructor_id',
    ];


    public function group()
    {
        return $this->belongsTo(Groups::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function spci_sub_groups()
    {
        return $this->hasMany(StudyPlanCourseInstructorSubGroup::class);
    }
}
