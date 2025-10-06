<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    /**
     * Menampilkan daftar postingan
     */
    public function adminIndex(Request $request)
    {
        // mulai query builder, eager load relasi
        $q = Post::query()->with(['author','category']);

        // search text (title/body)
        if ($search = $request->input('search')) {
            $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $setting = Setting::firstOrCreate(['id' => 1]);

        // mapping/validasi kolom order
        $allowedColumns = ['created_at', 'updated_at', 'title', 'author'];
        $orderBy = in_array($setting->default_order_by, $allowedColumns) ? $setting->default_order_by : 'created_at';
        $orderDir = in_array($setting->default_order_dir, ['asc','desc']) ? $setting->default_order_dir : 'desc';

        // handle special case 'author' (urut berdasarkan users.name)
        if ($orderBy === 'author') {
            // lakukan left join ke tabel users, jangan lupa select posts.*
            $q->leftJoin('users', 'users.id', '=', 'posts.author_id')
            ->select('posts.*')
            ->orderBy('users.name', $orderDir);
        } else {
            $q->orderBy($orderBy, $orderDir);
        }

        // apply app-wide filters dari setting
        if ($setting->filter_author_id) {
            $q->where('author_id', $setting->filter_author_id);
        }
        if ($setting->filter_category_id) {
            $q->where('category_id', $setting->filter_category_id);
        }

        $posts = $q->paginate($setting->posts_per_page)->withQueryString();

        $authors = User::whereIn('role', ['superadmin', 'admin', 'author'])->get();
        $categories = Category::all();

        return view('posts.index', [
            'title' => 'All Posts',
            'posts' => $posts,
            'setting' => $setting,
            'authors' => $authors,
            'categories' => $categories,
        ]);
    }

    /**
     * Tampilkan form create
     */
    public function create()
    {
        return view('posts.create', [
            'title' => 'Create New Post',
            'categories' => Category::all(),
            'authors' => User::whereIn('role', ['superadmin', 'admin', 'author'])->get(), // kirim user yang role-nya admin atau author
        ]);
    }

    /**
     * Tampilkan detail post untuk admin
     */
    public function adminShow(Post $post)
    {
        return view('posts.show', [
            'title' => 'Post Detail',
            'post' => $post
        ]);
    }

    /**
     * Simpan post baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'body' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ganti dari url ke upload file
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:users,id'
        ]);

        $validated['slug'] = generate_unique_slug($validated['slug'], 'posts');
        $validated['status'] = $request->input('status', 'draft'); // default draft kalau kosong

        // kalau ada file photo, simpan ke storage/posts
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('posts', 'public');
            $validated['photo'] = $path; // otomatis "posts/namafile.jpg"
        }

        try {
            Post::create($validated);
            return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.posts.index')->with('error', 'Failed to save post!');
        }
    }

    /**
     * Form edit post
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'categories' => Category::all(),
            'authors' => User::whereIn('role', ['superadmin', 'admin', 'author'])->get(), // kirim user yang role-nya admin atau author
        ]);
    }

    /**
     * Update post
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:users,id'
        ]);

        // slug kalau mau diubah
        if ($validated['slug'] !== $post->slug) {
            $validated['slug'] = generate_unique_slug($validated['slug'], 'posts', $post->id);
        } else {
            $validated['slug'] = generate_unique_slug(\Str::slug($validated['title']), 'posts', $post->id);
        }

        $validated['status'] = $request->input('status', 'published');

        // kalau ada file baru, hapus lama & simpan baru
        if ($request->hasFile('photo')) {
            if ($post->photo && Storage::disk('public')->exists($post->photo)) {
                Storage::disk('public')->delete($post->photo);
            }
            $path = $request->file('photo')->store('posts', 'public');
            $validated['photo'] = $path;
        }

        try {
            $post->update($validated);
            return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
        } catch (\Exception $e) {
            return redirect()->route('admin.posts.index')->with('error', 'Failed to update post!');
        }
    }

    /**
     * Hapus post
     */
    public function destroy(Post $post)
    {
        try {
            // hapus file di storage kalau ada
            if ($post->photo && Storage::disk('public')->exists($post->photo)) {
                Storage::disk('public')->delete($post->photo);
            }

            $post->delete();
            return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
        } catch (\Exception $e) {
            return redirect()->route('admin.posts.index')->with('error', 'Failed to delete post!');
        }
    }
}
