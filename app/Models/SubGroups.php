<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubGroups extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'group_id',
        'instructor_id',
    ];


    public function group(): BelongsTo
    {
        return $this
            ->belongsTo(Groups::class)
            ->withDefault(Groups::default());
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class)->withDefault();
    }

    public function students()
    {
        return $this->hasMany(Student::class)->chaperone();
    }

    public function spci_sub_groups()
    {
        return $this->hasMany(StudyPlanCourseInstructorSubGroup::class);
    }
}
