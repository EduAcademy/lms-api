<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    //
    protected $table = 'instructors';
    protected $fillable = [
        'uuid', 'professional_title', 'about_me', 'social_links',
    ];
}
