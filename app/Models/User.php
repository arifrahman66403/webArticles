<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'profile_photo',
        'username',
        'email',
        'role',
        'password',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // relasi ke post
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    // route model binding menggunakan username
    public function getRouteKeyName()
    {
        return 'username';
    }

    // accessor role alias
    public function getAliasRoleAttribute(): string
    {
        if (in_array($this->role, ['admin', 'superadmin'])) {
            return 'Author';
        }

        return ucfirst($this->role);
    }

    // method untuk cek role
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAuthor(): bool
    {
        return $this->role === 'author';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // relasi ke like
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // relasi ke post yang dilike
    public function likedPosts()
    {
        return $this->belongsToMany(\App\Models\Post::class, 'likes');
    }

    // accessor profile photo
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/'.$this->profile_photo);
        }
        // List warna background (Tailwind palette misalnya)
        $colors = [
            '4F46E5', // Indigo
            '2563EB', // Blue
            '16A34A', // Green
            'DC2626', // Red
            'D97706', // Amber
            '9333EA', // Purple
            '0891B2', // Cyan
            'EA580C', // Orange
        ];
        // Ambil warna berdasarkan hash user_id supaya konsisten
        $colorIndex = crc32($this->id.$this->name) % count($colors);
        $bgColor = $colors[$colorIndex];

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name)
            ."&background={$bgColor}&color=fff&bold=true";
    }
}
