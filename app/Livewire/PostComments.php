<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostComments extends Component
{
    public Post $post;
    public $body = '';
    public $parentId = null;
    public $replyTo = null;

    protected $listeners = ['set-reply' => 'setReply'];

    public function setReply($data)
    {
        $this->parentId = $data['parentId'];
        $this->replyTo  = $data['replyTo'];
    }

    protected $rules = [
        'body' => 'required|string|max:500',
        'parentId' => 'nullable|exists:comments,id',
        'replyTo' => 'nullable|exists:users,id',
    ];

    public function addComment()
    {
        $this->validate();

        $parentId = $this->parentId;

        // maksimal 2 level (reply ke reply tetap parent root)
        if ($parentId) {
            $parentComment = Comment::find($parentId);
            if ($parentComment && $parentComment->parent_id) {
                $parentId = $parentComment->parent_id;
            }
        }

        Comment::create([
            'post_id'   => $this->post->id,
            'user_id'   => Auth::id(),
            'parent_id' => $parentId,
            'reply_to'  => $this->replyTo,
            'body'      => $this->body,
        ]);

        $this->reset(['body', 'parentId', 'replyTo']);
        $this->dispatch('flash-message', type: 'success', message: 'Comment added!');
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // hapus reply biar gak orphan
        $comment->replies()->delete();
        $comment->delete();

        $this->dispatch('flash-message', type: 'success', message: 'Comment deleted!');
    }

    public function render()
    {
        return view('livewire.post-comments', [
            'comments' => $this->post->comments()->with('user', 'replies.user')->get(),
        ]);
    }
}
