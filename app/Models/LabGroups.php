<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabGroups extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name', 'theoretical_groups_id', 'instructor_id',
    ];

    
    public function theoretical_group()
    {
        return $this->belongsTo(TheoreticalGroups::class);
    }
    
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
