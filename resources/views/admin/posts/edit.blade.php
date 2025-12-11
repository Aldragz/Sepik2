@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Edit Caption Postingan</h1>

<div class="bg-white shadow-sm rounded-xl p-5">
    <div class="mb-4">
        <img src="{{ asset('storage/'.$post->media_path) }}"
             class="w-48 h-48 object-cover rounded-lg border">
    </div>

    <form method="POST" action="{{ route('admin.posts.update', $post->id) }}">
        @csrf
        @method('PUT')

        <label class="text-sm font-medium text-slate-700 mb-1 block">Caption</label>

        <textarea name="caption" rows="4"
                  class="w-full p-3 border rounded-lg bg-slate-50 focus:ring-pink-400 focus:bg-white">
            {{ $post->caption }}
        </textarea>

        <div class="mt-4 flex gap-3">
            <button
                class="px-4 py-2 bg-pink-500 text-white rounded-full text-sm hover:bg-pink-600 transition">
                Simpan Perubahan
            </button>

            <a href="{{ route('admin.posts.index') }}"
               class="px-4 py-2 border rounded-full text-sm text-slate-600 hover:bg-slate-50">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
