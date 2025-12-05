<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption'      => ['nullable', 'string'],
            'location'     => ['nullable', 'string', 'max:255'],
            'media'        => ['required', 'array', 'min:1'],
            'media.*'      => ['file', 'mimes:jpg,jpeg,png,webp,mp4,mov', 'max:20480'], // max 20MB per file
        ]);

        DB::beginTransaction();

        try {
            $post = Post::create([
                'user_id'       => Auth::id(),
                'caption'       => $request->caption,
                'location'      => $request->location,
                'like_count'    => 0,
                'comment_count' => 0,
            ]);

            $position = 1;

            foreach ($request->file('media') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());

                $mediaType = in_array($extension, ['mp4', 'mov']) ? 'video' : 'image';

                // simpan ke storage/app/public/posts
                $path = $file->store('posts', 'public');

                PostMedia::create([
                    'post_id'        => $post->id,
                    'media_type'     => $mediaType,
                    'file_path'      => $path,
                    'thumbnail_path' => null,   // nanti bisa diisi kalau mau generate thumbnail
                    'position'       => $position++,
                ]);
            }

            DB::commit();

            return redirect()->route('home')->with('success', 'Postingan berhasil dibuat!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'general' => 'Terjadi kesalahan saat menyimpan postingan.',
            ]);
        }
    }

    public function show(Post $post)
    {
        $post->load([
            'user',
            'media',
            'likes',
            'comments.user',
        ]);

        $alreadyLiked = $post->likes->where('user_id', Auth::id())->count() > 0;

        return view('posts.show', compact('post', 'alreadyLiked'));
    }
}
