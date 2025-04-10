<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\TagPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
    }
}
