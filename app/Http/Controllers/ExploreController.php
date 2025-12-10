<?php

namespace App\Http\Controllers;

use App\Models\Post;

class ExploreController extends Controller
{
    public function index()
    {
        // Explore: semua post dari semua user
        // Diurutkan kombinasi like terbanyak + terbaru
        $posts = Post::with(['user', 'media'])
            ->whereHas('media') // hanya post yang punya media
            ->orderByDesc('like_count')
            ->orderByDesc('created_at')
            ->paginate(18);

        return view('explore.index', compact('posts'));
    }
}
