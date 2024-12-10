<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'departments';
    protected $fillable = [
        'name',
        'short_name',
        'description',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function study_plans()
    {
        return $this->hasMany(StudyPlan::class);
    }
}
