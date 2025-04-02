<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'sender_id',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receivers(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            NotificationReceiver::class,
            'notification_id',
            'id',
            'id',
            'receiver_id'
        );
    }
}
