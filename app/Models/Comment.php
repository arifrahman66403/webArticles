<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'reply_to',
        'body',
    ];

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relasi ke User (author comment)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke parent comment
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relasi ke replies (anak komentar)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }

    // Kalau mau tahu user yang di-reply (opsional)
    public function replyToUser()
    {
        return $this->belongsTo(User::class, 'reply_to');
    }
}