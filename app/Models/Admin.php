<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    //
    use HasFactory;
    protected $table = 'admins';
    protected $fillable = [
        'uuid',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
