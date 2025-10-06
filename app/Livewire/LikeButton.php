<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class LikeButton extends Component
{
    public Post $post;

    public bool $liked = false;

    public int $likesCount = 0;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->likesCount = $post->likes()->count();

        if (auth()->check()) {
            $this->liked = $post->likes()->where('user_id', auth()->id())->exists();
        }
    }

    public function toggleLike()
    {
        if (! auth()->check()) {
            return; // user belum login
        }

        if ($this->liked) {
            // unlike
            $this->post->likes()->where('user_id', auth()->id())->delete();
            $this->likesCount--;
            $this->liked = false;
            $this->dispatch('notify',
                title: 'Success',
                message: 'Post unliked!'
            );
        } else {
            // like
            $this->post->likes()->create([
                'user_id' => auth()->id(),
            ]);
            $this->likesCount++;
            $this->liked = true;
            $this->dispatch('notify',
                title: 'Success',
                message: 'Post liked!'
            );
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
