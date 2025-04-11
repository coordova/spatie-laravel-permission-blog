<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id', 'ip_address', 'event', 'description', 'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function subject()
    {
        return $this->morphTo(); // Relación con cualquier modelo
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
