<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function toggle(User $user, Request $request)
    {
        $authUser = Auth::user();

        // tidak bisa follow diri sendiri
        if ($authUser->id === $user->id) {
            return back();
        }

        DB::beginTransaction();

        try {
            $follow = Follow::where('follower_id', $authUser->id)
                ->where('following_id', $user->id)
                ->first();

            if ($follow) {
                // sudah follow → UNFOLLOW (hapus)
                $follow->delete();
                $message = 'Berhenti mengikuti ' . $user->username;
            } else {
                // belum follow → langsung mengikuti (tidak ada pending)
                Follow::create([
                    'follower_id'  => $authUser->id,
                    'following_id' => $user->id,
                    'status'       => 'accepted',
                ]);

                $message = 'Sekarang kamu mengikuti ' . $user->username;
            }


            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses follow.');
        }

        return back()->with('success', $message);
    }
}
