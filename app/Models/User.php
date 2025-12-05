<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable; // bisa dipakai kalau mau fitur Notification bawaan

class User extends Authenticatable
{
    use HasFactory;
    // use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'website',
        'phone',
        'gender',
        'avatar',
        'is_private',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_private' => 'boolean',
        'password' => 'hashed',
    ];

    // ========== RELASI ==========

    // Post yang dibuat user
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Story yang dibuat user
    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    // Follower (orang yang mengikuti user ini)
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    // Following (orang yang diikuti user ini)
    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    // Like post yang dilakukan user ini
    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    // Komentar yang dibuat user ini
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Like komentar
    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    // DM: pesan yang user kirim
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // DM: semua percakapan yang diikuti user
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot(['joined_at', 'left_at']);
    }

    // Story view (story yang dia lihat)
    public function storyViews()
    {
        return $this->hasMany(StoryView::class);
    }

    // Notifikasi yang diterima user (custom)
    public function userNotifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Post yang disimpan user (saved)
    public function savedPosts()
    {
        return $this->hasMany(SavedPost::class);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

}
