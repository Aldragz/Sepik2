<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    // Menampilkan semua postingan user
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    // Form edit caption
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    // Update caption
    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required|max:500'
        ]);

        $post = Post::findOrFail($id);
        $post->caption = $request->caption;
        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Caption berhasil diperbarui!');
    }
}
