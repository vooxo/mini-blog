<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $post->comments()->create([
            'comment' => $request->comment,
            'post_id' => $post->id,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        if (Gate::denies('destroy-comment', $comment)) {
            abort(403);
        }

        $comment->delete();

        return back();
    }
}
