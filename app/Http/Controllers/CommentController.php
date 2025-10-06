<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id',
            'reply_to'  => 'nullable|exists:users,id',
        ]);

        $parentId = $request->input('parent_id');
        $replyTo  = $request->input('reply_to');

        // Maksimal 2 level (reply ke reply tetap parent root)
        if ($parentId) {
            $parentComment = Comment::find($parentId);
            if ($parentComment && $parentComment->parent_id) {
                $parentId = $parentComment->parent_id;
            }
        }

        Comment::create([
            'post_id'   => $post->id,
            'user_id'   => auth()->id(),
            'parent_id' => $parentId,
            'reply_to'  => $replyTo,
            'body'      => $request->body,
        ]);

        return back()->with('success', 'Comment added!');
    }

    public function delete(Comment $comment)
    {
        $this->authorizeCommentOwner($comment);

        // hapus reply juga biar gak orphan
        $comment->replies()->delete();
        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }

    protected function authorizeCommentOwner(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
