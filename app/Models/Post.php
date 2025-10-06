<?php

namespace App\Models;

use App\Models\User;
use App\Models\Like;
use App\Models\CommentPost;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'body', 'photo', 'category_id', 'author_id', 'status'];

    protected $with = ['author', 'category'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('authorOnly', function (Builder $builder) {
            $builder->whereHas('author', function ($q) {
            $q->whereIn('role', ['superadmin', 'admin', 'author']); // admin dan author yang bisa menampilkan post
            });
        });
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where(function($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('body', 'like', '%' . $filters['search'] . '%');
            });
        }

        if ($filters['category'] ?? false) {
            $query->whereHas('category', function($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        if ($filters['author'] ?? false) {
            $query->whereHas('author', function($q) use ($filters) {
                $q->where('username', $filters['author']);
            });
        }
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id')
            ->with(['user', 'replyToUser', 'replies']);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Kalau sudah ada photo (URL / storage)
            return Str::startsWith($this->photo, ['http://', 'https://'])
                ? $this->photo
                : asset('storage/' . $this->photo);
        }

        // Kalau null → generate dummy picsum
        return "https://picsum.photos/seed/{$this->id}/640/480";
    }

    public $timestamps = true;
}
// App\Models\Post::create([
// 'title' => 'Judul Artikel 1',
// 'author' => 'Arif Rahman Hakim',
// 'slug' => 'judul-artikel-1',
// 'body' => 'Lorem ipsum dolor sit amet']);