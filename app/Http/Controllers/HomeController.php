<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // GLOBAL FEED: semua post dari semua user
        $posts = Post::with([
                'user',
                'media',
                'likes',            // untuk cek sudah like atau belum
                'comments.user',    // komentar + usernya
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('home', compact('user', 'posts'));
    }
}
