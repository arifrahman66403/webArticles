<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
                $q->whereIn('role', ['superadmin', 'admin', 'author']); // superadmin, admin, dan author yang hanya bisa menampilkan post
            });
        });
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where(function ($q) use ($filters) {
            $q->where('title', 'like', '%'.$filters['search'].'%')
                ->orWhere('body', 'like', '%'.$filters['search'].'%')
                ->orWhereHas('category', function ($query) use ($filters) {
                $query->where('name', 'like', '%'.$filters['search'].'%');
                });
            });
        }

        if ($filters['category'] ?? false) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        if ($filters['author'] ?? false) {
            $query->whereHas('author', function ($q) use ($filters) {
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

    public function getCommentsCountAttribute()
    {
        return $this->comments()
            ->withCount('replies')
            ->get()
            ->sum(fn ($c) => 1 + $c->replies_count);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Kalau sudah ada photo (URL / storage)
            return Str::startsWith($this->photo, ['http://', 'https://'])
                ? $this->photo
                : asset('storage/'.$this->photo);
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
