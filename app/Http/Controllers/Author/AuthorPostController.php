<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthorPostController extends Controller
{
    /**
     * Daftar post milik author yang sedang login
     */
    public function index(Request $request)
    {
        $query = Post::with('category')
            ->where('author_id', auth()->id());

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        // Filter status (klik kolom Status)
        if ($request->filled('status') && in_array($request->status, ['draft', 'published'])) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at'); // default created_at
        $direction = $request->get('direction', 'desc'); // default terbaru dulu
        if (! in_array($sort, ['title', 'created_at'])) {
            $sort = 'created_at';
        }
        if (! in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $posts = $query->orderBy($sort, $direction)->paginate(10)->withQueryString();

        $categories = Category::all();

        return view('author.posts.index', compact('posts', 'categories'));
    }

    /**
     * Tampilkan form create
     */
    public function create()
    {
        return view('author.posts.create', [
            'title' => 'Create New Post',
            'categories' => Category::all(),
        ]);
    }

    /**
     * Simpan post baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['author_id'] = Auth::id();
        $validated['slug'] = generate_unique_slug($validated['title'], 'posts');
        $validated['status'] = $request->input('status', 'draft'); // default draft kalau kosong

        // simpan foto ke storage
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('posts', 'public');
        } else {
            $validated['photo'] = null;
        }

        try {
            $validated['status'] = $request->input('status', 'draft'); // default draft kalau kosong

            Post::create($validated);

            return redirect()->route('author.posts.index')->with(
                'success',
                $validated['status'] === 'published'
                    ? 'Post published successfully.'
                    : 'Post saved as draft.'
            );
        } catch (\Exception $e) {
            return redirect()->route('author.posts.index')->with('error', 'Failed to save post!');
        }
    }

    /**
     * Detail post (khusus post milik author)
     */
    public function show(Post $post)
    {
        $this->authorizePost($post);

        return view('author.posts.show', [
            'title' => 'Post Detail',
            'post' => $post,
        ]);
    }

    /**
     * Form edit post
     */
    public function edit(Post $post)
    {
        $this->authorizePost($post);

        return view('author.posts.edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update post
     */
    public function update(Request $request, Post $post)
    {
        $this->authorizePost($post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validated['slug'] !== $post->slug) {
            $validated['slug'] = generate_unique_slug($validated['slug'], 'posts', $post->id);
        } else {
            $validated['slug'] = generate_unique_slug(\Str::slug($validated['title']), 'posts', $post->id);
        }

        // ambil status dari tombol yang diklik (default tetap published kalau ga ada)
        $validated['status'] = $request->input('status', 'published');

        // kalau upload baru, hapus lama
        if ($request->hasFile('photo')) {
            if ($post->photo && Storage::disk('public')->exists($post->photo)) {
                Storage::disk('public')->delete($post->photo);
            }
            $validated['photo'] = $request->file('photo')->store('posts', 'public');
        } else {
            unset($validated['photo']); // jangan timpa kalau gak upload
        }

        try {
            $post->update($validated);

            return redirect()
                ->route('author.posts.index')
                ->with('success', $validated['status'] === 'draft'
                    ? 'Post saved as Draft.'
                    : 'Post published successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('author.posts.index')
                ->with('error', 'Failed to update post!');
        }
    }

    /**
     * Hapus post
     */
    public function destroy(Post $post)
    {
        $this->authorizePost($post);

        if ($post->photo && Storage::disk('public')->exists($post->photo)) {
            Storage::disk('public')->delete($post->photo);
        }

        try {
            $post->delete();

            return redirect()->route('author.posts.index')->with('success', 'Post deleted.');
        } catch (\Exception $e) {
            return redirect()->route('author.posts.index')->with('error', 'Failed to delete post!');
        }
    }

    /**
     * Cek apakah post milik author yang sedang login
     */
    protected function authorizePost(Post $post)
    {
        if ($post->author_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
