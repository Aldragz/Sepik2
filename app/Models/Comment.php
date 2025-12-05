<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'like_count',
    ];

    protected $casts = [
        'like_count' => 'integer',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Komentar induk (jika ini adalah reply)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Reply-reply dari komentar ini
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Like di komentar ini
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
