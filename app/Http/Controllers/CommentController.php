<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
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
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back();
    }
}
