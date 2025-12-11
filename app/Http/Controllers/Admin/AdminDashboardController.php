<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalPosts = Post::count();
        $totalAdmins = User::where('role', 'admin')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalPosts', 'totalAdmins'));
    }
}
