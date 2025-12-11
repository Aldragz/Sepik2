@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Tambah Admin Baru</h1>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-lg">
    <form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf

        <div class="mb-3">
            <label class="text-sm font-semibold">Nama</label>
            <input type="text" name="name"
                class="w-full border rounded px-3 py-2 text-sm @error('name') border-red-500 @enderror"
                value="{{ old('name') }}">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="text-sm font-semibold">Username</label>
            <input type="text" name="username"
                class="w-full border rounded px-3 py-2 text-sm @error('username') border-red-500 @enderror"
                value="{{ old('username') }}">
            @error('username') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="text-sm font-semibold">Email</label>
            <input type="email" name="email"
                class="w-full border rounded px-3 py-2 text-sm @error('email') border-red-500 @enderror"
                value="{{ old('email') }}">
            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="text-sm font-semibold">Password</label>
            <input type="password" name="password"
                class="w-full border rounded px-3 py-2 text-sm @error('password') border-red-500 @enderror">
            @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
            class="px-4 py-2 bg-pink-500 text-white text-sm rounded-lg hover:bg-pink-600">
            Buat Admin
        </button>
    </form>
</div>
@endsection
