<?php

use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Author\AuthorPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\User\UserSettingController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// ---------------------------
// LOGIN, REGISTER AND LOGOUT
// ---------------------------
Route::middleware(['guest'])
    ->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    });
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ---------------------------
// PUBLIC PAGES
// ---------------------------
Route::get('/home', [RouteController::class, 'home'])->name('home');
Route::post('/home', [RouteController::class, 'store'])->name('store');
Route::get('/about', [RouteController::class, 'about'])->name('about');
Route::get('/about/{user}', [RouteController::class, 'show']);
Route::get('/contact', [RouteController::class, 'contact']);
Route::post('/contact', [MessageController::class, 'store'])->name('contact.store');

// ---------------------------
// ARTICLES FOR ALL USERS
// ---------------------------
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/posts/comments/{comment}', [CommentController::class, 'delete'])->name('comments.delete');
Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');

// ---------------------------
// MESSAGE FOR ADMIN
// ---------------------------
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin,admin'])->name('message.')
    ->group(function () {
    Route::get('/message', [MessageController::class, 'index'])->name('index');
    Route::delete('/message/destroy-all', [MessageController::class, 'destroyAll'])->name('destroyAll');
    Route::get('/message/{message:email}', [MessageController::class, 'show'])->name('show');
    Route::delete('/message/{message:email}', [MessageController::class, 'destroy'])->name('destroy');
    Route::patch('/message/{message:email}/read', [MessageController::class, 'markAsRead'])->name('read');
});

// ---------------------------
// CRUD FOR ADMIN
// ---------------------------
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin,admin'])->name('admin.posts.')
    ->group(function () {
        Route::get('/posts', [AdminPostController::class, 'adminIndex'])->name('index');
        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('create');
        Route::post('/posts', [AdminPostController::class, 'store'])->name('store');
        Route::get('/posts/{post}', [AdminPostController::class, 'adminShow'])->name('show');
        Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('edit');
        Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('update');
        Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('destroy');
    });

// ---------------------------
// CRUD FOR AUTHOR
// ---------------------------
Route::prefix('author')
    ->middleware(['auth', 'role:author'])->name('author.posts.')
    ->group(function () {
        Route::get('/posts', [AuthorPostController::class, 'index'])->name('index');
        Route::get('/posts/create', [AuthorPostController::class, 'create'])->name('create');
        Route::post('/posts', [AuthorPostController::class, 'store'])->name('store');
        Route::get('/posts/{post:slug}', [AuthorPostController::class, 'show'])->name('show');
        Route::get('/posts/{post:slug}/edit', [AuthorPostController::class, 'edit'])->name('edit');
        Route::put('/posts/{post:slug}', [AuthorPostController::class, 'update'])->name('update');
        Route::delete('/posts/{post:slug}', [AuthorPostController::class, 'destroy'])->name('destroy');
    });

// ---------------------------
// SETTING FOR ADMIN
// ---------------------------
Route::prefix('admin/setting')
    ->middleware(['auth', 'role:superadmin,admin'])->name('admin.setting.')
    ->group(function () {

        // Profile
        Route::get('/profile', [SettingController::class, 'profileIndex'])->name('profile.index');
        Route::post('/profile', [SettingController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/photo', [SettingController::class, 'updateProfilePhoto'])->name('photo.update');
        Route::delete('/profile/photo', [SettingController::class, 'deleteProfilePhoto'])->name('photo.delete');
        Route::post('/password', [SettingController::class, 'updatePassword'])->name('password.update');

        // Users
        Route::get('/users', [SettingController::class, 'usersIndex'])->name('users.index');
        Route::post('/users', [SettingController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{user}', [SettingController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [SettingController::class, 'destroyUser'])->name('users.destroy');
        Route::delete('/users/{user}/photo', [SettingController::class, 'deleteUserPhoto'])->name('users.photo.delete');

        // Categories
        Route::get('/categories', [SettingController::class, 'categoriesIndex'])->name('categories.index');
        Route::post('/categories', [SettingController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{category}', [SettingController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [SettingController::class, 'destroyCategory'])->name('categories.destroy');

        // App / CRUD Options
        Route::get('/app', [SettingController::class, 'appSettingIndex'])->name('app.index');
        Route::post('/app', [SettingController::class, 'updateApp'])->name('app.update');
    });

// ---------------------------
// SETTING FOR USER
// ---------------------------
Route::prefix('user')
    ->middleware(['auth'])->name('user.')
    ->group(function () {
        // Profil dan Pengaturan
        Route::get('/profile', [UserSettingController::class, 'profile'])->name('profile');
        Route::get('/setting', [UserSettingController::class, 'edit'])->name('setting');

        // Update foto profil
        Route::put('/setting/photo', [UserSettingController::class, 'updateProfilePhoto'])->name('photo.update');

        // Hapus foto profil
        Route::delete('/setting/photo', [UserSettingController::class, 'deleteProfilePhoto'])->name('photo.delete');

        // Update data akun (nama, username, email, password)
        Route::put('/setting', [UserSettingController::class, 'update'])->name('setting.update');
    });

// ---------------------------
// LIKE AND LIBRARY FOR USER
// ---------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/library', [LibraryController::class, 'likesIndex'])->name('library.likes');
});
