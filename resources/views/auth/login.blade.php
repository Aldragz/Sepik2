@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Login Sepik2</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Email atau Username</label>
            <input type="text" name="login" value="{{ old('login') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('login') border-red-500 @enderror">
            @error('login')
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

        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-sm">Ingat saya</label>
        </div>

        <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 rounded">
            Login
        </button>

        <p class="mt-4 text-center text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar</a>
        </p>
    </form>
</div>
@endsection
