<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'type',
        'data',
        'read_at',
        'created_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // Penerima notifikasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Aktor (yang melakukan aksi)
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
