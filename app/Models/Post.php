<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'location',
        'like_count',
        'comment_count',
    ];

    protected $casts = [
        'like_count' => 'integer',
        'comment_count' => 'integer',
    ];

    // Pemilik post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Media-media (foto/video) dalam post
    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    // Like di post ini
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    // Komentar di post ini
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Hashtag yang terkait dengan post
    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'post_hashtag')
            ->withPivot('created_at');
    }

    // Relasi ke SavedPost
    public function savedPosts()
    {
        return $this->hasMany(SavedPost::class);
    }

    // User yang menyimpan post ini
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_posts')
            ->withPivot('created_at');
    }

    // Jika dipakai di DM (message_type=post)
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
