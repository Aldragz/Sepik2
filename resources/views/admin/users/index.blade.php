@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Judul Halaman --}}
    <h1 class="text-xl font-semibold mb-4">Kelola User</h1>

    {{-- Box utama --}}
    <div class="bg-white rounded-xl shadow p-5">

        {{-- Tabel --}}
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2 font-medium text-slate-600">Nama</th>
                    <th class="text-left font-medium text-slate-600">Email</th>
                    <th class="text-left font-medium text-slate-600">Username</th>
                    <th class="text-right font-medium text-slate-600">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="py-3">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ '@' . $user->username }}</td>

                        <td class="text-right">

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.users.delete', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="px-3 py-1.5 text-xs bg-rose-500 text-white rounded-full hover:bg-rose-600 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="py-3 text-center text-slate-500">
                            Tidak ada user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
