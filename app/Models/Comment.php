<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id', 'post_id'];

    // Relación BelongsTo con User (autor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación BelongsTo con Post (al que pertenece)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
