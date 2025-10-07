<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    public $post;
    public $comments;
    public $newComment = '';
    public $replyBodies = [];

    public function mount($post)
    {
        $this->post = $post;
        $this->loadComments();
    }

    public function loadComments()
    {
        $this->comments = $this->post->comments()
            ->with(['user', 'replies.user', 'replyToUser'])
            ->whereNull('parent_id')
            ->latest()
            ->get();
    }

    public function postComment($parentId = null, $replyTo = null)
    {
        $body = $parentId
            ? ($this->replyBodies[$parentId] ?? '')
            : $this->newComment;

        if (trim($body) === '') return;

        Comment::create([
            'post_id'   => $this->post->id,
            'user_id'   => auth()->id(),
            'body'      => $body,
            'parent_id' => $parentId,
            'reply_to'  => $replyTo,
        ]);

        // Reset input-nya
        if ($parentId) {
            $this->replyBodies[$parentId] = '';
        } else {
            $this->newComment = '';
        }

        $this->loadComments();
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if ($comment && $comment->user_id === auth()->id()) {
            $comment->delete();
        }

        $this->loadComments();
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
