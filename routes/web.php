<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManagementController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        
        Route::get('/admins', [AdminManagementController::class, 'index'])
        ->name('admins.index');


        // Kelola User
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users');

        // Hapus User
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.delete');

        Route::get('/admins/create', [AdminManagementController::class, 'create'])
            ->name('admins.create');

        Route::post('/admins', [AdminManagementController::class, 'store'])
            ->name('admins.store');

        Route::delete('/admins/{admin}', [AdminManagementController::class, 'destroy'])
        ->name('admins.delete');

    });


// AUTH
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::get('/admin/posts/{id}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/admin/posts/{id}', [AdminPostController::class, 'update'])->name('admin.posts.update');
});


Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/explore', [ExploreController::class, 'index'])->name('explore');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Like / Unlike post (toggle)
    Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])
        ->name('posts.like');

    // Tambah komentar ke post
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('posts.comments.store');
    
    // PROFILE
    Route::get('/profile/{user}', [ProfileController::class, 'show'])
        ->name('profile.show');

        // FOLLOW / UNFOLLOW
    Route::post('/profile/{user}/follow', [FollowController::class, 'toggle'])
        ->name('profile.follow');
    
    // Edit profil (punya sendiri)
    Route::get('/settings/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::post('/settings/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // DETAIL POST
    Route::get('/p/{post}', [PostController::class, 'show'])->name('posts.show');

});
