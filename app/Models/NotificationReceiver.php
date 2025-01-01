<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReceiver extends Model
{
    use HasFactory;

    protected $table = 'notification_receivers';

    protected $fillable = [
        'notification_id',
        'receiver_id'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    // Relationships
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
