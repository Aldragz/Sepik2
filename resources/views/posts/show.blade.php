@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- tombol back kecil --}}
    <div class="mb-3">
        <a href="{{ route('home') }}"
        class="text-xs text-gray-500 hover:text-gray-700"
        onclick="event.preventDefault(); if (window.history.length > 1) { window.history.back(); } else { window.location.href='{{ route('home') }}'; }">
            ← Kembali
        </a>
    </div>


    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-5">
            {{-- Media besar --}}
            <div class="md:col-span-3 bg-black flex items-center justify-center">
                @php
                    $media = $post->media->sortBy('position')->first();
                @endphp

                @if ($media)
                    @if ($media->media_type === 'image')
                        <img src="{{ asset('storage/' . $media->file_path) }}"
                             alt="Post image"
                             class="max-h-[600px] w-full md:w-auto object-contain">
                    @else
                        <video controls class="max-h-[600px] w-full md:w-auto">
                            <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                            Browser kamu tidak mendukung video.
                        </video>
                    @endif
                @endif
            </div>

            {{-- CAPTION --}}
<div class="px-4 py-3 border-b border-gray-100">
    @if ($post->caption)
        <div class="bg-slate-50 rounded-lg px-3 py-2 text-sm">
            <a href="{{ route('profile.show', $post->user) }}"
               class="font-semibold mr-1 hover:underline">
                {{ $post->user->username }}
            </a>
            {{ $post->caption }}

            <div class="text-[11px] text-gray-400 mt-1">
                {{ $post->created_at->diffForHumans() }}
                @if (auth()->id() === $post->user_id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus postingan ini?')"
                                class="text-xs text-red-600 hover:text-red-800 font-semibold">
                            Hapus Postingan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @else
        <p class="text-xs text-gray-400">
            Tidak ada caption untuk postingan ini.
        </p>
    @endif
</div>

{{-- KOMENTAR --}}
<div class="flex-1 px-4 py-3 overflow-y-auto max-h-80 border-b border-gray-100">
    <p class="text-xs font-semibold text-gray-500 tracking-wide uppercase mb-2">
        Komentar
    </p>

    @forelse ($post->comments->sortBy('created_at') as $comment)
        <div class="mb-2 text-sm">
            <a href="{{ route('profile.show', $comment->user) }}"
               class="font-semibold mr-1 hover:underline">
                {{ $comment->user->username }}
            </a>
            {{ $comment->content }}
            <div class="text-[11px] text-gray-400 mt-1">
                {{ $comment->created_at->diffForHumans() }}
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-400">
            Belum ada komentar. Jadilah yang pertama!
        </p>
    @endforelse
</div>


                {{-- like + info --}}
                <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-4">
                    <form method="POST" action="{{ route('posts.like', $post) }}">
                        @csrf
                        <button type="submit"
                                class="text-sm font-semibold
                                {{ $alreadyLiked ? 'text-pink-500' : 'text-gray-700' }}">
                            {{ $alreadyLiked ? '♥ Unlike' : '♡ Like' }}
                        </button>
                    </form>

                    <span class="text-sm text-gray-600">
                        {{ $post->like_count }} likes · {{ $post->comment_count }} comments
                    </span>
                </div>

                {{-- form komentar --}}
                <div class="px-4 py-3">
                    <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                        @csrf
                        <div class="flex items-center gap-2">
                            <input type="text" name="content"
                                   class="flex-1 border rounded px-3 py-2 text-sm @error('content') border-red-500 @enderror"
                                   placeholder="Tambahkan komentar...">
                            <button type="submit"
                                    class="text-sm text-pink-500 font-semibold">
                                Kirim
                            </button>
                        </div>
                        @error('content')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
