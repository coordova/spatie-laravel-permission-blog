<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Mutador para generar slug automáticamente al crear/actualizar nombre
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    // Relación ManyToMany con Post
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
