<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class);
Route::apiResource('posts.comments', CommentController::class)
    ->scoped(['comment' => 'post']);
