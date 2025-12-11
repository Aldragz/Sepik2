@extends('layouts.app')

@section('content')
<!-- @if (session('success'))
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
@endif -->

@if (session('error'))
    <div class="mb-4 bg-red-100 text-red-800 px-4 py-2 rounded">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Kolom kanan: GLOBAL FEED --}}
    <div class="md:col-span-2 space-y-4">
        @forelse ($posts as $post)
            @php
                $alreadyLiked = $post->likes->where('user_id', auth()->id())->count() > 0;
            @endphp

            <div class="bg-white rounded-lg shadow overflow-hidden">
                {{-- Header post --}}
                <div class="px-4 py-3 flex items-center gap-3">
                <a href="{{ route('profile.show', $post->user) }}"
                class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center">
                    @if ($post->user->avatar)
                        <img src="{{ asset('storage/' . $post->user->avatar) }}"
                            alt="Avatar"
                            class="w-full h-full object-cover">
                    @else
                        <span class="text-sm font-semibold text-gray-600">
                            {{ strtoupper(substr($post->user->username, 0, 1)) }}
                        </span>
                    @endif
                </a>
                <div>
                    <p class="text-sm font-semibold">
                        <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                            {{ $post->user->username }}
                        </a>
                    </p>
                    @if ($post->location)
                        <p class="text-xs text-gray-500">{{ $post->location }}</p>
                    @endif
                </div>
            </div>


                {{-- Media utama --}}
                @if ($post->media->count())
                    @php $firstMedia = $post->media->sortBy('position')->first(); @endphp
                    <div class="bg-black flex justify-center items-center max-h-[450px] overflow-hidden">
                        @if ($firstMedia->media_type === 'image')
                            <img src="{{ asset('storage/' . $firstMedia->file_path) }}"
                                 alt="Post image"
                                 class="max-h-[450px] w-auto">
                        @else
                            <video controls class="max-h-[450px] w-auto">
                                <source src="{{ asset('storage/' . $firstMedia->file_path) }}" type="video/mp4">
                                Browser kamu tidak mendukung video.
                            </video>
                        @endif
                    </div>
                @endif

                {{-- Interaksi --}}
                <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-4">
                    <button type="button"
                            class="like-button text-sm font-semibold {{ $alreadyLiked ? 'text-pink-500' : 'text-gray-700' }}"
                            data-url="{{ route('posts.like', $post) }}"
                            data-liked="{{ $alreadyLiked ? '1' : '0' }}"
                            data-post-id="{{ $post->id }}">
                        {{ $alreadyLiked ? '♥ Unlike' : '♡ Like' }}
                    </button>

                    <span class="text-sm text-gray-600">
                        <span class="like-count" data-post-id="{{ $post->id }}">
                            {{ $post->like_count }}
                        </span>
                        likes · {{ $post->comment_count }} comments
                    </span>
                </div>


                {{-- Caption --}}
                <div class="px-4 pt-3 pb-1">
                    @if ($post->caption)
                        <p class="text-sm">
                            <span class="font-semibold mr-1">
                                <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                                    {{ $post->user->username }}
                                </a>
                            </span>
                            {{ $post->caption }}
                        </p>
                    @endif

                    <p class="text-xs text-gray-400 mt-2">
                        {{ $post->created_at->diffForHumans() }}
                    </p>
                </div>

                {{-- Komentar --}}
                <div class="px-4 pb-3">
                    @php
                        $comments = $post->comments->sortByDesc('created_at')->take(3);
                    @endphp

                    @foreach ($comments as $comment)
                        <div class="mt-2 text-sm">
                            <span class="font-semibold mr-1">
                                <a href="{{ route('profile.show', $comment->user) }}" class="hover:underline">
                                    {{ $comment->user->username }}
                                </a>
                            </span>
                            {{ $comment->content }}
                        </div>
                    @endforeach

                    @if ($post->comments->count() > 3)
                        <p class="text-xs text-gray-500 mt-1">
                            Lihat semua {{ $post->comments->count() }} komentar (nanti bisa kita buat halaman detail).
                        </p>
                    @endif

                    {{-- Form tambah komentar --}}
                    <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mt-3">
                        @csrf
                        <div class="flex items-center gap-2">
                            <input type="text" name="content"
                                   class="flex-1 border rounded px-3 py-1.5 text-sm @error('content') border-red-500 @enderror"
                                   placeholder="Tulis komentar...">
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
        @empty
            <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500 text-sm">
                Timeline-mu masih kosong.
                <br>
                Coba ikuti beberapa akun di
                <a href="{{ route('explore') }}" class="text-pink-500 font-semibold hover:underline">
                    halaman Explore
                </a>
                atau buat postingan pertama kamu!
            </div>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function () {
            const url = this.dataset.url;
            const postId = this.dataset.postId;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}) // body kosong, hanya butuh POST
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                // update tombol
                const liked = data.liked;
                this.dataset.liked = liked ? '1' : '0';
                this.textContent = liked ? '♥ Unlike' : '♡ Like';

                this.classList.toggle('text-pink-500', liked);
                this.classList.toggle('text-gray-700', !liked);

                // update like count
                const countSpan = document.querySelector(
                    '.like-count[data-post-id="' + postId + '"]'
                );
                if (countSpan) {
                    countSpan.textContent = data.like_count;
                }
            })
            .catch(err => {
                console.error(err);
            });
        });
    });
});
</script>
@endpush

@endsection
