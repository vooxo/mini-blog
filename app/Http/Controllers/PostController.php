<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostRequest;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('posts/Index', [
            'posts' => Post::query()->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->validated());

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Response
    {
        return Inertia::render('posts/Show', [
            'post' => $post->load('comments')
                ->load('comments.user')
                ->load('user')
        ]);
    }
    /**
     * Show the edit form
     */
    public function edit(Post $post): Response
    {
        return Inertia::render('posts/Edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}
