@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-center gap-6">
        <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center">
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}"
                    alt="Avatar"
                    class="w-full h-full object-cover">
            @else
                <span class="text-3xl font-semibold text-gray-600">
                    {{ strtoupper(substr($user->username, 0, 1)) }}
                </span>
            @endif
        </div>


        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-4 mb-2">
                <h1 class="text-2xl font-semibold">{{ $user->username }}</h1>

                @if ($isOwnProfile)
                    <a href="{{ route('profile.edit') }}"
                    class="px-4 py-1.5 text-sm rounded bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold">
                        Edit Profil
                    </a>
                @else
                    <form method="POST" action="{{ route('profile.follow', $user) }}">
                        @csrf
                        @php
                            $isFollowing = $followRelation !== null;
                        @endphp

                        @if ($isFollowing)
                            <button type="submit"
                                    class="px-4 py-1.5 text-sm rounded bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold">
                                Mengikuti
                            </button>
                        @else
                            <button type="submit"
                                    class="px-4 py-1.5 text-sm rounded bg-pink-500 hover:bg-pink-600 text-white font-semibold">
                                Ikuti
                            </button>
                        @endif
                    </form>
                @endif
            </div>

            <div class="flex items-center gap-6 text-sm">
                <span><strong>{{ $posts->total() }}</strong> postingan</span>
                <span><strong>{{ $followersCount }}</strong> pengikut</span>
                <span><strong>{{ $followingCount }}</strong> mengikuti</span>
            </div>

            <div class="mt-3">
                <p class="font-semibold text-sm">{{ $user->name }}</p>
                @if ($user->bio)
                    <p class="text-sm text-gray-700 mt-1">{{ $user->bio }}</p>
                @endif
                @if ($user->website)
                    <a href="{{ $user->website }}" target="_blank" class="text-sm text-blue-500">
                        {{ $user->website }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>


{{-- Grid postingan --}}
<div class="bg-white rounded-xl shadow p-5">
    @if ($posts->count() === 0)
        <div class="py-12 text-center text-gray-500">
            Belum ada postingan.
        </div>
    @else
        <h2 class="text-xs font-semibold text-gray-500 tracking-wide uppercase mb-4">
            Postingan
        </h2>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($posts as $post)
                @php
                    $media = $post->media->sortBy('position')->first();
                @endphp

                @if ($media)
                    <a href="{{ route('posts.show', $post) }}"
                       class="block relative group aspect-square rounded-2xl overflow-hidden
                              bg-white ring-2 ring-gray-200 shadow-md
                              hover:ring-4 hover:ring-pink-400 hover:shadow-lg
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
                            <div class="absolute top-2 left-2 bg-black/80 text-white text-xs px-2 py-1 rounded-full">
                                Video
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100
                                    flex items-center justify-center text-xs md:text-sm text-white font-semibold
                                    transition-opacity duration-200">
                            <span class="flex items-center mr-4">
                                ♥ <span class="ml-1">{{ $post->like_count }}</span>
                            </span>
                            <span class="flex items-center">
                                💬 <span class="ml-1">{{ $post->comment_count }}</span>
                            </span>
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

@endsection
