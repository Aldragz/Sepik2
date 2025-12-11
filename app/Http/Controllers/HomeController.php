<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ambil semua user yang diikuti
        $followingIds = Follow::where('follower_id', $user->id)
            ->pluck('following_id')
            ->toArray();

        // selalu termasuk diri sendiri
        $userIds = array_unique(array_merge($followingIds, [$user->id]));

        // ambil post hanya dari user-user tersebut
        $posts = Post::with(['user', 'media', 'likes', 'comments'])
            ->whereIn('user_id', $userIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('home', [
            'user'  => $user,
            'posts' => $posts,
        ]);
    }
}
