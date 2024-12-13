<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sleep extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'day',
        'bed_time',
        'wake_time',
        'sieste',
        'cycles_completed',
        'morning_form',
        'sport',
        'sleep_hour',
        'remaining_minutes',
        'comment',
    ];

    // Relation avec un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
