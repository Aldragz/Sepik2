@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-xl font-semibold mb-4">Kelola User</h1>

    <div class="bg-white rounded-xl shadow p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Nama</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Username</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="py-2">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ '@' . $user->username }}</td>
                        <td class="text-right">
                            <form action="{{ route('admin.users.delete', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="px-3 py-1 text-xs bg-rose-500 text-white rounded-full hover:bg-rose-600">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-2 text-center text-slate-500">Tidak ada user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
