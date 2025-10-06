<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Halaman publik untuk semua pengunjung
     */
    public function index()
    {
        $author = User::firstWhere('username', request('author'));
        $category = Category::firstWhere('slug', request('category'));
        $search = request('search');

        // digunakan untuk mengambil semua post berdasarkan created_at atau tanggal pembuatan
        $posts = Post::where('status', 'published')->latest()->filter(request(['search', 'category', 'author']))
            ->paginate(12)->withQueryString();

        // digunakan untuk mengambil semua post secara acak
        // $posts = Post::where('status', 'published')->inRandomOrder()->filter(request(['search', 'category', 'author']))
        //     ->paginate(12)->withQueryString();

        // digunakan untuk mengambil semua post berdasarkan updated_at atau tanggal perbaruan
        // $posts = Post::where('status', 'published')->orderBy('updated_at', 'desc')->filter(request(['search', 'category', 'author']))
        //     ->paginate(12)->withQueryString();

        if ($search && $author) {
            $title = 'Found '.$posts->total().' results for: "'.Str::limit($search, 30).'" from '.$author->name;
        } elseif ($search && $category) {
            $title = 'Found '.$posts->total().' results for: "'.Str::limit($search, 30).'" in Category: '.$category->name;
        } elseif ($search) {
            $title = 'Found '.$posts->total().' results for: "'.Str::limit($search, 50).'"';
        } elseif ($author) {
            $title = 'Total '.$author->posts->count().' Articles by: '.$author->name;
        } elseif ($category) {
            $title = 'Articles in Category: '.$category->name;
        } else {
            $title = 'All Articles';
        }

        return view('posts', [
            'title' => $title,
            'posts' => $posts,
        ]);
    }

    /**
     * Halaman detail post
     */
    public function show(Post $post)
    {
        // Cegah akses post selain published
        if ($post->status !== 'published') {
            abort(404);
        }

        // Eager load komentar dan relasi-relasinya secara langsung saat mengambil post
        $post->load([
            'comments' => function ($query) {
                $query->whereNull('parent_id') // cuma ambil root comments
                    ->latest();
            },
            'comments.user', // eager load user untuk komentar utama
            'comments.replyToUser', // eager load user yang di-reply untuk komentar utama
            'comments.replies.user', // eager load user untuk balasan komentar
            'comments.replies.replyToUser', // eager load user yang di-reply untuk balasan komentar
        ]);

        // Ambil post lain yang terkait, efisien dalam satu query
        $otherPosts = Post::where('status', 'published') // hanya tampilkan published
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->limit(12)
            ->get();

        return view('post', [
            'title' => 'Post Detail',
            'post' => $post,
            // Cukup kirimkan satu variabel yang sudah berisi komentar yang di-eager load
            'other' => $otherPosts,
        ]);
    }
}
