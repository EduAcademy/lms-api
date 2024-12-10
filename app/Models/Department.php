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
        'name', 'shortName', 'description',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function studyplans()
    {
        return $this->hasMany(StudyPlan::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}