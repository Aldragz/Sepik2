<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'posts_count',
        'created_at',
    ];

    protected $casts = [
        'posts_count' => 'integer',
        'created_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_hashtag')
            ->withPivot('created_at');
    }
}
