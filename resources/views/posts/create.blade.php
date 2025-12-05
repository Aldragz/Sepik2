@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Buat Postingan Baru</h1>

    @if ($errors->has('general'))
        <div class="mb-3 text-sm text-red-600">
            {{ $errors->first('general') }}
        </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Caption (opsional)</label>
            <textarea name="caption" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm @error('caption') border-red-500 @enderror">{{ old('caption') }}</textarea>
            @error('caption')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Lokasi (opsional)</label>
            <input type="text" name="location" value="{{ old('location') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('location') border-red-500 @enderror">
            @error('location')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Media (foto/video) <span class="text-red-500">*</span>
            </label>
            <input type="file" name="media[]" multiple
                   class="w-full text-sm @error('media') border border-red-500 @enderror @error('media.*') border border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">
                Bisa pilih lebih dari satu file. Format: jpg, jpeg, png, webp, mp4, mov.
            </p>
            @error('media')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
            @error('media.*')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 rounded">
            Posting
        </button>
    </form>
</div>
@endsection
