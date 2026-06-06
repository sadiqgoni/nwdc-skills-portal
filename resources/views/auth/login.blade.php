<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - NWDC Skills Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_80%_80%,#16a34a_0%,#0f7a3d_30%,#063f31_62%,#022c22_100%)] text-slate-950 antialiased">
    <main class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-6 lg:px-8">
        <section class="grid w-full max-w-6xl overflow-hidden rounded-md bg-white shadow-2xl shadow-emerald-950/40 lg:min-h-[600px] lg:grid-cols-[0.88fr_1.12fr]">
            <aside class="relative overflow-hidden bg-[#0b5f37] p-8 text-white sm:p-10 lg:p-12">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_20%,rgba(255,255,255,0.14),transparent_30%),linear-gradient(150deg,rgba(212,160,23,0.2),transparent_42%)]"></div>
                <div class="relative flex h-full flex-col">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                        <span class="grid h-20 w-20 place-items-center rounded-md bg-white/15 p-3 ring-1 ring-white/20">
                            <img src="/images/nwdc.png" alt="NWDC" class="max-h-full max-w-full rounded-md bg-white object-contain p-1">
                        </span>
                    </a>

                    <div class="mt-9">
                        <p class="text-sm font-bold uppercase tracking-wider text-amber-100">Applicant access</p>
                        <h1 class="mt-3 text-3xl font-black leading-tight sm:text-4xl">
                            NWDC Skills Portal
                        </h1>
                        <p class="mt-5 max-w-md text-base leading-8 text-emerald-50">
                            Continue your application, update pending details, upload documents, print acknowledgement, and follow official programme updates from one secure account.
                        </p>
                    </div>

                    <div class="mt-8 space-y-3">
                        <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">Returning applicants</p>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Use the phone number, email address, or NIN connected to your application.</p>
                        </div>
                        <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">Official communication</p>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Screening and admission messages will be tied to the records in your applicant profile.</p>
                        </div>
                    </div>

                    <p class="mt-auto pt-8 text-sm leading-6 text-emerald-100">
                        Applications are free. Do not make payment to anyone for registration, shortlisting, admission, or cohort placement.
                    </p>
                </div>
            </aside>

            <div class="flex items-center p-8 sm:p-10 lg:p-14">
                <div class="w-full">
                    @if (session('success') || session('error'))
                        <div class="mb-6 space-y-3">
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

                    <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">Welcome back</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Sign in to continue.</h2>
                    <p class="mt-3 leading-7 text-slate-600">
                        Enter your applicant login details to continue from where you stopped.
                    </p>

                    <form action="{{ route('login.store') }}" method="post" class="mt-7 space-y-5">
                        @csrf
                        <div>
                            <label for="login" class="text-sm font-bold text-slate-700">Phone, email, or NIN</label>
                            <input id="login" name="login" value="{{ old('login') }}" required autofocus class="mt-2 w-full rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2">
                            @error('login') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                            <div class="relative mt-2">
                                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-md border border-slate-300 bg-slate-50 py-3 pl-4 pr-12 outline-none ring-emerald-500 focus:bg-white focus:ring-2">
                                <button type="button" data-password-toggle="password" aria-label="Show password" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-slate-500 hover:text-emerald-700">
                                    <svg class="h-5 w-5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <label class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-700">
                            Remember this device
                        </label>

                        <button data-loading-text="Signing in..." class="w-full rounded-md bg-emerald-700 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-emerald-800">
                            Sign In
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm font-semibold text-slate-500">
                        New applicant?
                        <a href="{{ route('register') }}" class="text-emerald-700 hover:text-emerald-800">Create an account</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
