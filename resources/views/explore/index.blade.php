@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold text-slate-800">
            Explore
        </h1>
        <p class="text-xs text-slate-500">
            Jelajahi postingan dari seluruh pengguna Sepik2
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-4">
        @if ($posts->count() === 0)
            <div class="py-12 text-center text-slate-500 text-sm">
                Belum ada postingan untuk dieksplor.
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                @foreach ($posts as $post)
                    @php
                        $media = $post->media->sortBy('position')->first();
                    @endphp

                    @if ($media)
                        <a href="{{ route('posts.show', $post) }}"
                           class="block relative group aspect-square rounded-2xl overflow-hidden
                                  bg-white ring-1 ring-slate-200 shadow-sm
                                  hover:ring-2 hover:ring-pink-400 hover:shadow-md
                                  transition-all duration-200 ease-out">
                            @if ($media->media_type === 'image')
                                <img src="{{ asset('storage/' . $media->file_path) }}"
                                     alt="Post"
                                     class="w-full h-full object-cover group-hover:scale-110
                                            transition-transform duration-300 ease-out">
                            @else
                                <video class="w-full h-full object-cover">
                                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                                </video>
                                <div class="absolute top-2 left-2 bg-black/80 text-white text-[10px] px-2 py-1 rounded-full">
                                    Video
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100
                                        flex items-center justify-center text-[11px] md:text-xs text-white font-semibold
                                        transition-opacity duration-200">
                                <span class="flex items-center mr-3">
                                    ♥ <span class="ml-1">{{ $post->like_count }}</span>
                                </span>
                                <span class="flex items-center">
                                    💬 <span class="ml-1">{{ $post->comment_count }}</span>
                                </span>
                            </div>

                            <div class="absolute bottom-1 left-1 right-1 flex justify-between items-center
                                        px-2 py-1 text-[10px] text-white bg-gradient-to-t from-black/60 to-transparent">
                                <span class="truncate max-w-[60%]">
                                    {{ '@' . $post->user->username }}
                                </span>
                                @if ($post->location)
                                    <span class="truncate max-w-[40%] text-[9px] text-slate-100">
                                        {{ $post->location }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
