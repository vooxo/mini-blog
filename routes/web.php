<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Authenticated
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])
        ->name('posts.comments.destroy');

});

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::post('posts/{post}/comments', [CommentController::class, 'store'])
    ->name('posts.comments.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
