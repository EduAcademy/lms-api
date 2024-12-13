<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadedFiles extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'file_name', 'file_hash', 'file_size', 'last_modified',
    ];
    
}
