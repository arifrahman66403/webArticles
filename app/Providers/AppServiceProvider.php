<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
     * Policy mappings for the application.
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // For count unread message in sidebar admin
        View::composer('components.sidebaradmin', function ($view) {
            $unreadCount = Message::where('is_read', false)->count();
            $view->with('unreadCount', $unreadCount);
        });

        // Route model binding standar pakai username
        Route::bind('user', function ($value) {
            return User::where('username', $value)->firstOrFail();
        });

        Model::preventLazyLoading(true);
    }
}
