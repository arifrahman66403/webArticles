<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class RouteController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function home()
    {
        return view('home', [
            'title' => 'Home',
            'authors' => User::whereIn('role', ['superadmin', 'admin', 'author'])->get(), // kirim user yang role-nya admin atau author
            'post_count' => Post::count(),
            'user_count' => User::count(),
            'author_count' => User::whereIn('role', ['superadmin', 'author', 'admin'])->count(),
            'category_count' => Category::count(),
            'posts' => Post::orderBy('updated_at', 'desc')->take(5)->get(),
        ]);
    }

    public function about()
    {
        return view('about', [
            'title' => 'About',
            'users' => User::whereIn('role', ['superadmin', 'admin', 'author'])->get(), // kirim user yang role-nya admin atau author
            'category' => Category::find(1)->name,
            'email' => User::find(1)->email,
        ]);
    }

    public function show(User $user)
    {
        // hanya superadmin, admmin, dan author yang boleh ditampilkan
        if (! in_array($user->role, ['superadmin', 'admin', 'author'])) {
            abort(403, 'mau lihat profile siapa tu?'); // biar gak bisa diintip lewat URL
        }

        return view('aboutuser', [
            'title' => 'Author Detail',
            'user' => $user,
            'total_posts' => Post::where('author_id', $user->id)
                ->where('status', 'published')
                ->count(),

            'total_likes' => \DB::table('likes')
                ->join('posts', 'likes.post_id', '=', 'posts.id')
                ->where('posts.author_id', $user->id)
                ->count(),
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Contact',
            'contacts' => [
                [
                    'name' => User::find(1)->name,
                    'email' => User::find(1)->email,
                    'phone' => '+62813-7113-9471',
                    'location' => 'Siak, Riau, Indonesia',
                    'bio' => 'Saya adalah seorang pengembang web yang berfokus pada pengembangan aplikasi Laravel.',
                    'link' => '@incubatormen',
                ],
            ],
        ]);
    }
}
