<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sepik2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">

    {{-- TOP BAR: logo + search + logout --}}
    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14 gap-4">

                {{-- Brand kiri --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-pink-500 via-fuchsia-500 to-purple-500 bg-clip-text text-transparent">
                        Sepik2
                    </span>
                </a>

                {{-- Search tengah --}}
                @auth
                    @if (auth()->user()->role !== 'admin')
                        <form method="GET" action="{{ route('search') }}"
                            class="flex-1 max-w-md mx-2 relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                                🔍
                            </span>
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari user atau lokasi..."
                                class="w-full pl-8 pr-3 py-1.5 rounded-full text-xs bg-slate-100 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:bg-white"
                                autocomplete="off"
                            >
                        </form>
                    @endif
                @endauth

                {{-- Logout kanan --}}
                <div class="flex items-center gap-2">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="px-3 py-1 rounded-full text-xs font-medium text-rose-500 border border-rose-200 hover:bg-rose-50">
                                Logout
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                           class="px-3 py-1 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-100">
                            Login
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    {{-- WRAPPER: sidebar + main content --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 flex gap-6">

        {{-- SIDEBAR NAV --}}
        @auth
            @if (auth()->user()->role === 'admin')
                {{-- SIDEBAR ADMIN --}}
                <aside class="w-52 shrink-0 hidden md:flex flex-col">
                    <div class="bg-white rounded-xl shadow-sm px-4 py-4 mb-4">
                        <p class="text-xs text-slate-500 uppercase mb-1">Admin</p>
                        <p class="text-sm font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <nav class="bg-white rounded-xl shadow-sm py-3">
                        <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>🛠</span>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('admin.users') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>👥</span>
                            <span>Kelola User</span>
                        </a>
                        <a href="{{ route('admin.posts.index') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm 
                        {{ request()->routeIs('admin.posts.*') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>🖼️</span>
                            <span>Kelola Postingan</span>
                        </a>
                        
                        {{-- nanti tambah menu admin lain: Users, Posts, Reports, Settings, dst --}}
                    </nav>
                </aside>
            @else
                {{-- SIDEBAR USER BIASA --}}
                <aside class="w-52 shrink-0 hidden md:flex flex-col">
                    {{-- Profil singkat --}}
                    <div class="bg-white rounded-xl shadow-sm px-4 py-4 mb-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden flex items-center justify-center">
                            @if (auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                    alt="Avatar"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-sm font-semibold text-slate-600">
                                    {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ '@' . auth()->user()->username }}
                            </p>
                        </div>
                    </div>

                    {{-- Menu navigasi user --}}
                    <nav class="bg-white rounded-xl shadow-sm py-3">
                        <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('home') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>🏠</span>
                            <span>Beranda</span>
                        </a>

                        <a href="{{ route('explore') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('explore') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>🧭</span>
                            <span>Explore</span>
                        </a>

                        <a href="{{ route('search') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('search') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>🔍</span>
                            <span>Cari</span>
                        </a>

                        <a href="{{ route('posts.create') }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('posts.create') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>➕</span>
                            <span>Buat Post</span>
                        </a>

                        <a href="{{ route('profile.show', auth()->user()) }}"
                        class="flex items-center gap-3 px-4 py-2 text-sm {{ request()->routeIs('profile.show') ? 'font-semibold text-pink-500' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>👤</span>
                            <span>Profil</span>
                        </a>
                    </nav>
                </aside>
            @endif
        @endauth


        {{-- MAIN CONTENT --}}
        <main class="flex-1">
            {{-- flash message --}}
            @if (session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-2 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
