<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';
    protected $fillable = [
        'uuid', 'department_id',
    ];

    // , 'study_plan_id', 'group_id',
}
