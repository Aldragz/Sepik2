@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Daftar Sepik2</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('username') border-red-500 @enderror">
            @error('username')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('email') border-red-500 @enderror">
            @error('email')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2 text-sm @error('password') border-red-500 @enderror">
            @error('password')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 rounded">
            Daftar
        </button>

        <p class="mt-4 text-center text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </form>
</div>
@endsection
