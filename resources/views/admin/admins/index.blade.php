@extends('layouts.app')

@section('content')
<div class="max-w-4xl">

    <h1 class="text-xl font-semibold text-slate-800 mb-4">Kelola Admin</h1>

    <a href="{{ route('admin.admins.create') }}"
        class="inline-flex items-center px-3 py-2 mb-4 rounded-lg text-sm font-medium
               bg-pink-500 text-white hover:bg-pink-600 transition">
        ➕ Tambah Admin Baru
    </a>

    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-slate-200">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-slate-500">#</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-slate-500">Nama</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-slate-500">Email</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-slate-500">Dibuat</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-slate-500">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($admins as $admin)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 font-medium text-slate-800">{{ $admin->name }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $admin->email }}</td>
                        <td class="py-3 px-4 text-slate-600">
                            {{ $admin->created_at->format('d M Y') }}
                        </td>

                        <td class="py-3 px-4">
                            @if (auth()->id() !== $admin->id)
                                <form action="{{ route('admin.admins.delete', $admin->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus admin ini?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button class="px-3 py-1.5 rounded-lg text-xs font-medium
                                                   bg-rose-100 text-rose-600 border border-rose-200
                                                   hover:bg-rose-200 hover:text-rose-700 transition">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">
                                    Tidak bisa hapus akun sendiri
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="py-6 text-center text-slate-400 text-sm">
                            Belum ada admin
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
