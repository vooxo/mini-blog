<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('posts', PostController::class);
Route::resource('posts.comments', CommentController::class)
    ->scoped(['comment' => 'post'])
    ->only(['store', 'destroy']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
