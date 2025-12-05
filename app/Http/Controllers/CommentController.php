<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        $request->validate([
            'content'   => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        DB::beginTransaction();

        try {
            Comment::create([
                'post_id'   => $post->id,
                'user_id'   => Auth::id(),
                'parent_id' => $request->parent_id,
                'content'   => $request->content,
                'like_count'=> 0,
            ]);

            $post->increment('comment_count');

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengirim komentar.')
                         ->withInput();
        }

        return back();
    }
}
