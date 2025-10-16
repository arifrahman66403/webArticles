<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    public $postId;
    public $newComment = '';
    public $replyBodies = [];
    public $comments;

    protected $listeners = ['refreshComments' => 'loadComments'];

    public function mount($post)
    {
        $this->postId = is_object($post) ? $post->id : $post;
        $this->loadComments();
    }

    public function getPostProperty()
    {
        return Post::find($this->postId);
    }

    public function loadComments()
    {
        $this->comments = Comment::with(['user', 'replies.user', 'replyToUser'])
            ->where('post_id', $this->postId)
            ->whereNull('parent_id')
            ->latest()
            ->get();
    }

    public function postComment($parentId = null, $replyTo = null)
    {
        $body = $parentId
            ? trim($this->replyBodies[$parentId] ?? '')
            : trim($this->newComment);

        if ($body === '') return;

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'body' => $body,
            'parent_id' => $parentId,
            'reply_to' => $replyTo,
        ]);

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

        if ($comment && $comment->user_id === Auth::id()) {
            $comment->delete();
            $this->loadComments();
        }
    }

    public function render()
    {
        return view('livewire.comments');
    }
}
