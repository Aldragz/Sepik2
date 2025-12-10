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
            <span>
                <strong>{{ $posts->total() }}</strong> postingan
            </span>

            <button type="button"
                    onclick="openFollowModal('followers')"
                    class="focus:outline-none">
                <strong class="underline underline-offset-2 cursor-pointer hover:text-pink-500">
                    {{ $followersCount }}
                </strong>
                <span> pengikut</span>
            </button>

            <button type="button"
                    onclick="openFollowModal('following')"
                    class="focus:outline-none">
                <strong class="underline underline-offset-2 cursor-pointer hover:text-pink-500">
                    {{ $followingCount }}
                </strong>
                <span> mengikuti</span>
            </button>
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

{{-- MODAL PENGIKUT --}}
<div id="followersModal"
     class="fixed inset-0 z-40 hidden bg-black/40">
    <div class="mx-4 md:mx-auto max-w-md bg-white rounded-xl shadow-xl mt-24 md:mt-32 overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
            <h3 class="text-sm font-semibold text-slate-800">
                Pengikut ({{ $followersCount }})
            </h3>
            <button type="button"
                    onclick="closeFollowModal('followers')"
                    class="text-slate-400 hover:text-slate-600 text-lg leading-none">
                ×
            </button>
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse ($followers as $follow)
                @php $u = $follow->follower; @endphp
                @if ($u)
                    <a href="{{ route('profile.show', $u) }}"
                       class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition">
                        <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex items-center justify-center">
                            @if ($u->avatar)
                                <img src="{{ asset('storage/' . $u->avatar) }}"
                                     alt="Avatar"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-semibold text-slate-600">
                                    {{ strtoupper(substr($u->username, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $u->username }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $u->name }}
                            </p>
                        </div>
                    </a>
                @endif
            @empty
                <p class="px-4 py-4 text-xs text-slate-500">
                    Belum ada yang mengikuti akun ini.
                </p>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL MENGIKUTI --}}
<div id="followingModal"
     class="fixed inset-0 z-40 hidden bg-black/40">
    <div class="mx-4 md:mx-auto max-w-md bg-white rounded-xl shadow-xl mt-24 md:mt-32 overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
            <h3 class="text-sm font-semibold text-slate-800">
                Mengikuti ({{ $followingCount }})
            </h3>
            <button type="button"
                    onclick="closeFollowModal('following')"
                    class="text-slate-400 hover:text-slate-600 text-lg leading-none">
                ×
            </button>
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse ($following as $follow)
                @php $u = $follow->following; @endphp
                @if ($u)
                    <a href="{{ route('profile.show', $u) }}"
                       class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition">
                        <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex items-center justify-center">
                            @if ($u->avatar)
                                <img src="{{ asset('storage/' . $u->avatar) }}"
                                     alt="Avatar"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-semibold text-slate-600">
                                    {{ strtoupper(substr($u->username, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $u->username }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $u->name }}
                            </p>
                        </div>
                    </a>
                @endif
            @empty
                <p class="px-4 py-4 text-xs text-slate-500">
                    Akun ini belum mengikuti siapa pun.
                </p>
            @endforelse
        </div>
    </div>
</div>
@push('scripts')
<script>
    function openFollowModal(type) {
        const id = type === 'followers' ? 'followersModal' : 'followingModal';
        const el = document.getElementById(id);
        if (!el) return;

        el.classList.remove('hidden');
    }

    function closeFollowModal(type) {
        const id = type === 'followers' ? 'followersModal' : 'followingModal';
        const el = document.getElementById(id);
        if (!el) return;

        el.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        ['followersModal', 'followingModal'].forEach(function (id) {
            const el = document.getElementById(id);
            if (!el) return;

            // klik background (area gelap) untuk menutup
            el.addEventListener('click', function (e) {
                if (e.target === el) {
                    el.classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush

@endsection
