@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-slate-800">
            Pencarian
        </h1>

        @if ($query !== '')
            <p class="text-sm text-slate-500">
                Hasil untuk: <span class="font-semibold">"{{ $query }}"</span>
            </p>
        @endif
    </div>

    @if ($query === '')
        <div class="bg-white rounded-xl shadow p-6 text-center text-slate-500 text-sm">
            Ketik sesuatu di kotak pencarian di atas untuk mencari pengguna atau lokasi.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Kolom kiri: user --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-xl shadow p-4">
                    <h2 class="text-xs font-semibold text-gray-500 tracking-wide uppercase mb-3">
                        Pengguna
                    </h2>

                    @forelse ($users as $u)
                        <a href="{{ route('profile.show', $u) }}"
                           class="flex items-center gap-3 py-2 px-2 rounded-lg hover:bg-slate-50 transition">
                            <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-xs font-semibold text-slate-700">
                                @if ($u->avatar)
                                    <img src="{{ asset('storage/' . $u->avatar) }}"
                                        alt="Avatar"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-semibold text-slate-700">
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
                    @empty
                        <p class="text-xs text-slate-500">
                            Tidak ada pengguna yang cocok.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Kolom kanan: post --}}
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow p-4">
                    <h2 class="text-xs font-semibold text-gray-500 tracking-wide uppercase mb-3">
                        Postingan
                    </h2>

                    @if ($posts->count() === 0)
                        <p class="text-sm text-slate-500">
                            Tidak ada postingan yang cocok.
                        </p>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
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
                                            <div class="absolute top-2 left-2 bg-black/80 text-white text-xs px-2 py-1 rounded-full">
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
        </div>
    @endif
</div>
@endsection
