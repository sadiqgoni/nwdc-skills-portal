<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NWDC Skills Portal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.18),transparent_34%),linear-gradient(180deg,#f0fdf4_0%,#f8faf7_38%,#eef8f0_100%)] text-slate-950 antialiased">
    <header class="border-b border-emerald-200 bg-white/90 shadow-sm backdrop-blur">
        <div class="bg-emerald-950 px-5 py-2 text-center text-xs font-semibold text-emerald-50 sm:px-6">
            NWDC Youth Skills and Empowerment Programme application portal
        </div>
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                <img src="/images/nwdc.png" alt="NWDC" class="h-11 w-11 shrink-0 rounded-md bg-white object-contain p-1 shadow-sm ring-1 ring-emerald-100">
                <div class="min-w-0">
                    <p class="truncate text-xs font-bold uppercase tracking-wider text-emerald-700">North West Development Commission</p>
                    <p class="truncate text-base font-black text-emerald-950">Skills Portal</p>
                </div>
            </a>

            <nav class="flex shrink-0 items-center gap-2 text-sm font-bold">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <span class="hidden rounded-lg px-3 py-2 text-slate-700 sm:inline-flex">Staff session</span>
                    @else
                        <a href="{{ route('portal.dashboard') }}" class="hidden rounded-lg px-3 py-2 text-slate-700 hover:bg-emerald-50 sm:inline-flex">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button data-loading-text="Logging out..." class="rounded-lg bg-slate-950 px-3 py-2 text-white hover:bg-slate-800">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-slate-700 hover:bg-emerald-50">Login</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-emerald-800 px-3 py-2 text-white hover:bg-emerald-700">Apply</a>
                @endauth
            </nav>
        </div>
    </header>

    @if (session('success') || session('error'))
        <div class="mx-auto max-w-7xl px-5 pt-5 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-950">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-950">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    <main class="relative">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-52 bg-gradient-to-b from-emerald-100/65 to-transparent"></div>
        <div class="relative">
        @yield('content')
        </div>
    </main>
</body>
</html>
