<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostLikeController extends Controller
{
    public function toggle(Post $post, Request $request)
    {
        $userId = Auth::id();
        $liked = false;

        DB::beginTransaction();

        try {
            $existing = PostLike::where('post_id', $post->id)
                ->where('user_id', $userId)
                ->first();

            if ($existing) {
                // UNLIKE
                $existing->delete();
                $post->decrement('like_count');
                $liked = false;
            } else {
                // LIKE
                PostLike::create([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                ]);

                $post->increment('like_count');
                $liked = true;
            }

            $post->refresh(); // ambil like_count terbaru

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Failed'], 500);
            }

            return back()->with('error', 'Gagal memproses like.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'liked'      => $liked,
                'like_count' => $post->like_count,
            ]);
        }

        // fallback kalau non-AJAX
        return back();
    }
}
