<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\RecordsActivity;

class Post extends Model
{
    use HasFactory, RecordsActivity;

    // Asegúrate de tener 'user_id' y 'is_published' si los usas
    protected $fillable = [
        'title',
        'content',
        'user_id', // Asume que tienes esta columna para 'posts.edit.own'
        'is_published', // Asume que tienes esta columna booleana/timestamp para 'posts.publish'
    ];

    protected $casts = [
        'is_published' => 'boolean', // Importante para la lógica
    ];

    // Relación BelongsTo con User (autor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación ManyToMany con Category
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Relación ManyToMany con Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relación HasMany con Comment
    public function comments()
    {
        // Ordenar comentarios por fecha de creación, por ejemplo
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }
}
