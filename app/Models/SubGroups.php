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


    public function theoretical_group()
    {
        return $this->belongsTo(Groups::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
