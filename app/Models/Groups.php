<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Groups extends Model
{
    //
    use HasFactory;


    protected $fillable = [
        'name'
    ];

    // do you hear me
    public function studentCourseInstructorsGroups()
    {
        return $this->hasMany(StudentCourseInstructorGroup::class);
    }

    public function sub_groups()
    {
        return $this->hasMany(SubGroups::class);
    }
}
