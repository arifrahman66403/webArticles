<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Policies\UserPolicy;
use App\Models\Message;
use App\Models\User;

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
