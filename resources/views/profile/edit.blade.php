@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-semibold mb-4">Edit Profil</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Avatar --}}
        <div class="mb-4 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                        alt="Avatar"
                        class="w-full h-full object-cover">
                @else
                    <span class="text-xl font-semibold">
                        {{ strtoupper(substr($user->username, 0, 1)) }}
                    </span>
                @endif
            </div>

            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Avatar (opsional)</label>
                <input type="file" name="avatar" class="text-sm">
                <p class="text-xs text-gray-500 mt-1">
                    Format: jpg, jpeg, png, webp. Maks 2MB.
                </p>
                @error('avatar')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                @if ($user->avatar)
                    <label class="inline-flex items-center mt-2">
                        <input type="checkbox" name="remove_avatar" value="1" class="mr-2">
                        <span class="text-xs text-gray-600">Hapus avatar saat ini</span>
                    </label>
                @endif
            </div>
        </div>


        {{-- Nama --}}
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bio --}}
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Bio</label>
            <textarea name="bio" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Maks 160 karakter.</p>
            @error('bio')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Website --}}
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Website</label>
            <input type="text" name="website" value="{{ old('website', $user->website) }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('website') border-red-500 @enderror"
                   placeholder="https://example.com">
            @error('website')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Nomor HP</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('phone') border-red-500 @enderror">
            @error('phone')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gender --}}
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Gender</label>
            <select name="gender"
                    class="w-full border rounded px-3 py-2 text-sm @error('gender') border-red-500 @enderror">
                <option value="">Pilih...</option>
                <option value="male"   @selected(old('gender', $user->gender) === 'male')>Laki-laki</option>
                <option value="female" @selected(old('gender', $user->gender) === 'female')>Perempuan</option>
                <option value="other"  @selected(old('gender', $user->gender) === 'other')>Lainnya</option>
            </select>
            @error('gender')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('profile.show', $user) }}"
               class="text-sm text-gray-500 hover:underline">
                Batal
            </a>

            <button type="submit"
                    class="bg-pink-500 hover:bg-pink-600 text-white font-semibold text-sm px-5 py-2 rounded">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
