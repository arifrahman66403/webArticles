<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $user = auth()->user();

        // kalau sudah like jangan dobel
        if (!$post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
        }

        return back()->with('success', 'Post liked!');
    }

    public function unlike(Post $post)
    {
        $user = auth()->user();

        $post->likes()->where('user_id', $user->id)->delete();

        return back()->with('success', 'Post unliked!');
    }
}
