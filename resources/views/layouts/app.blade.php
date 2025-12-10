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

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14">
                {{-- Brand --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-pink-500 via-fuchsia-500 to-purple-500 bg-clip-text text-transparent">
                        Sepik2
                    </span>
                    <!-- <span class="hidden sm:inline text-xs text-slate-500">
                        simple social media clone
                    </span> -->
                </a>

                {{-- Search --}}
                <div class="hidden md:flex flex-1 justify-center px-6">
                    <form method="GET" action="{{ route('search') }}" class="w-full max-w-sm relative">
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
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 text-sm">
                    @auth
                        <a href="{{ route('explore') }}"
                        class="px-3 py-1 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-100">
                            Explore
                        </a>

                        <a href="{{ route('profile.show', auth()->user()) }}"
                           class="px-3 py-1 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-100">
                            Profil
                        </a>

                        <a href="{{ route('posts.create') }}"
                           class="px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white hover:opacity-90">
                            + Post
                        </a>

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
                        <a href="{{ route('register') }}"
                           class="px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white hover:opacity-90">
                            Register
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
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

    @stack('scripts')
</body>
</html>
