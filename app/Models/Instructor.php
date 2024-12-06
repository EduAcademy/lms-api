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
        'uuid', 'professional_title', 'about_me', 'social_links',
    ];

    public function coursematerials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
