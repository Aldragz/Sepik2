@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Kelola Semua Postingan</h1>

<div class="bg-white shadow-sm rounded-xl p-4">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b bg-slate-50 text-slate-600">
                <th class="p-3 text-left">Media</th>
                <th class="p-3 text-left">User</th>
                <th class="p-3 text-left">Caption</th>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
            <tr class="border-b hover:bg-slate-50">
                <td class="p-3">
                    @php
                        $media = $post->media->first(); // ambil 1 media pertama
                    @endphp

                    @if ($media)
                        @if ($media->media_type === 'image')
                            <img src="{{ asset('storage/' . $media->file_path) }}"
                                class="w-16 h-16 object-cover rounded-lg border">
                        @else
                            <video class="w-16 h-16 rounded-lg border" muted>
                                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                            </video>
                        @endif
                    @else
                        <span class="text-xs text-gray-400">Tidak ada media</span>
                    @endif
                </td>

                <td class="p-3">
                    <p class="font-semibold">{{ $post->user->username }}</p>
                    <p class="text-xs text-slate-500">{{ $post->user->email }}</p>
                </td>

                <td class="p-3 text-slate-700">
                    {{ Str::limit($post->caption, 50) }}
                </td>

                <td class="p-3 text-slate-600">
                    {{ $post->created_at->format('d M Y') }}
                </td>

                <td class="p-3">
                    <a href="{{ route('admin.posts.edit', $post->id) }}"
                       class="px-3 py-1 text-xs rounded-full border border-indigo-300 text-indigo-600 hover:bg-indigo-50">
                        Edit Caption
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
