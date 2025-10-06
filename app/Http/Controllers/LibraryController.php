<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function likesIndex()
    {
        $user = auth()->user();

        // ambil semua posts yang dilike user ini
        $likedPosts = $user->likedPosts()->where('status', 'published')->latest()->get();

        return view('library.likes', compact('likedPosts'));
    }
}
