<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $authUser = Auth::user();

        $isOwnProfile = $authUser->id === $user->id;

        // Hitung followers & following
        $followersCount = Follow::where('following_id', $user->id)->count();
        $followingCount = Follow::where('follower_id', $user->id)->count();

        // status follow antara authUser dan $user
        $followRelation = null;
        if (! $isOwnProfile) {
            $followRelation = Follow::where('follower_id', $authUser->id)
                ->where('following_id', $user->id)
                ->first(); // bisa null / pending / accepted
        }

        // Post grid user ini
        $posts = Post::with('media')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('profile.show', [
            'user'           => $user,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'posts'          => $posts,
            'isOwnProfile'   => $isOwnProfile,
            'followRelation' => $followRelation,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'bio'     => ['nullable', 'string', 'max:160'],
            'website' => ['nullable', 'url', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'gender'  => ['nullable', 'in:male,female,other'],
            'avatar'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'website.url' => 'Format URL tidak valid (harus diawali http:// atau https://).',
        ]);

        // HAPUS AVATAR JIKA DIMINTA
        if ($request->boolean('remove_avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
        }

        // UPLOAD / GANTI AVATAR
        if ($request->hasFile('avatar')) {
            // hapus avatar lama kalau ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name    = $request->name;
        $user->bio     = $request->bio;
        $user->website = $request->website;
        $user->phone   = $request->phone;
        $user->gender  = $request->gender;

        $user->save();

        return redirect()
            ->route('profile.show', $user)
            ->with('success', 'Profil berhasil diperbarui.');
    }

}
