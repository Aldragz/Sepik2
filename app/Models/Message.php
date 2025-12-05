<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message_type',
        'body',
        'media_path',
        'post_id',
        'story_id',
        'created_at',
        'read_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
