<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        if ($q === '') {
            // kalau kosong, kirim view tanpa hasil
            return view('search.index', [
                'query' => '',
                'users' => collect(),
                'posts' => collect(),
            ]);
        }

        // cari user: username atau nama mengandung query
        $users = User::where(function ($query) use ($q) {
                $query->where('username', 'like', '%' . $q . '%')
                      ->orWhere('name', 'like', '%' . $q . '%');
            })
            ->orderBy('username')
            ->limit(10)
            ->get();

        // cari post: caption atau lokasi mengandung query
        $posts = Post::with(['user', 'media'])
    ->where('location', 'like', '%' . $q . '%')
    ->orderBy('created_at', 'desc')
    ->paginate(12)
    ->appends(['q' => $q]);

        return view('search.index', [
            'query' => $q,
            'users' => $users,
            'posts' => $posts,
        ]);
    }
}
