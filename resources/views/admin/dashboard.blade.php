@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-xs text-slate-500 uppercase mb-1">Total User</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-xs text-slate-500 uppercase mb-1">Total Post</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalPosts }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <p class="text-xs text-slate-500 uppercase mb-1">Admin</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalAdmins }}</p>
        </div>
    </div>
</div>
@endsection
