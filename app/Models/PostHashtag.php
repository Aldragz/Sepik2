<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHashtag extends Model
{
    use HasFactory;

    protected $table = 'post_hashtag';

    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'post_id',
        'hashtag_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function hashtag()
    {
        return $this->belongsTo(Hashtag::class);
    }
}
