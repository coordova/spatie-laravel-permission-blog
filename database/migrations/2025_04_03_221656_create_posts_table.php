<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // BigInt Unsigned Primary Key Auto-Increment

            // Foreign key para el autor (User)
            // constrained() asume que la tabla es 'users' y la columna 'id'
            // cascadeOnDelete() elimina los posts si se elimina el usuario autor
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Foreign key para la categoría (Category)
//            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            $table->string('title'); // Título del post
            $table->longText('content'); // Contenido del post (longText para textos largos)
            $table->boolean('is_published')->default(false); // Estado de publicación
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
