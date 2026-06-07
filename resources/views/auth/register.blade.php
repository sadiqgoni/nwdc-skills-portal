<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - NWDC Skills Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-[radial-gradient(circle_at_80%_80%,#16a34a_0%,#0f7a3d_30%,#063f31_62%,#022c22_100%)] text-slate-950 antialiased">
    @php
        $eligibilityLocked = filled(data_get($eligibility, 'date_of_birth')) && filled(data_get($eligibility, 'state_id'));
    @endphp
    <main class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <section class="grid w-full min-w-0 max-w-7xl overflow-hidden rounded-md bg-white shadow-2xl shadow-emerald-950/40 lg:grid-cols-[0.82fr_1.18fr]">
            <aside class="relative overflow-hidden bg-[#0b5f37] p-8 text-white sm:p-10 lg:p-12">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_22%_18%,rgba(255,255,255,0.14),transparent_30%),linear-gradient(150deg,rgba(212,160,23,0.2),transparent_42%)]"></div>
                <div class="relative flex h-full min-h-[520px] flex-col">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                        <span class="grid h-20 w-20 place-items-center rounded-md bg-white/15 p-3 ring-1 ring-white/20">
                            <img src="/images/nwdc.png" alt="NWDC" class="max-h-full max-w-full rounded-md bg-white object-contain p-1">
                        </span>
                    </a>

                    <div class="mt-9">
                        <p class="text-sm font-bold uppercase tracking-wider text-amber-100">Account creation</p>
                        <h1 class="mt-3 text-3xl font-black leading-tight sm:text-4xl">
                            Create your applicant account.
                        </h1>
                        <p class="mt-5 max-w-md text-base leading-8 text-emerald-50">
                            Use accurate personal records. Your phone number, email address, and NIN will be connected to one application for the current programme cycle.
                        </p>
                    </div>

                    <div class="mt-8 space-y-3">
                        <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">Before you submit</p>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Confirm that your name, date of birth, and state of origin match your documents.</p>
                        </div>
                        <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">Keep access secure</p>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Use a password you can remember and keep your login details private.</p>
                        </div>
                    </div>

                    <p class="mt-auto pt-8 text-sm leading-6 text-emerald-100">
                        NWDC will not ask applicants to pay for registration, shortlisting, admission, or cohort placement.
                    </p>
                </div>
            </aside>

            <div class="flex min-w-0 items-center p-5 sm:p-10 lg:p-12">
                <div class="w-full min-w-0">
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

                    <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">Start application</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Enter your correct details.</h2>
                
                    <form action="{{ route('register.store') }}" method="post" class="mt-7">
                        @csrf
                        <div class="grid min-w-0 gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="text-sm font-bold text-slate-700">Full name</label>
                                <input id="name" name="name" value="{{ old('name') }}" required class="mt-2 block w-full min-w-0 rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2">
                                @error('name') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="phone" class="text-sm font-bold text-slate-700">Phone number</label>
                                <input id="phone" name="phone" value="{{ old('phone') }}" type="tel" inputmode="numeric" pattern="[0-9]{10,15}" minlength="10" maxlength="15" required autocomplete="tel" class="mt-2 block w-full min-w-0 rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2" placeholder="08030000001">
                                @error('phone') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="text-sm font-bold text-slate-700">Email address</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="mt-2 block w-full min-w-0 rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2" placeholder="name@example.com">
                                @error('email') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="nin" class="text-sm font-bold text-slate-700">NIN</label>
                                <input id="nin" name="nin" value="{{ old('nin') }}" inputmode="numeric" pattern="[0-9]{11}" minlength="11" maxlength="11" required autocomplete="off" class="mt-2 block w-full min-w-0 rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2" placeholder="11-digit NIN">
                                @error('nin') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="date_of_birth" class="text-sm font-bold text-slate-700">Date of birth</label>
                                @if ($eligibilityLocked)
                                    <input type="hidden" name="date_of_birth" value="{{ data_get($eligibility, 'date_of_birth') }}">
                                @endif
                                <input id="date_of_birth" name="{{ $eligibilityLocked ? 'date_of_birth_display' : 'date_of_birth' }}" type="date" value="{{ $eligibilityLocked ? data_get($eligibility, 'date_of_birth') : old('date_of_birth') }}" required @disabled($eligibilityLocked) class="mt-2 block w-full min-w-0 rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2 disabled:cursor-not-allowed disabled:border-emerald-200 disabled:bg-emerald-50 disabled:text-emerald-950">
                                @error('date_of_birth') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="state_id" class="text-sm font-bold text-slate-700">State of origin</label>
                                @if ($eligibilityLocked)
                                    <input type="hidden" name="state_id" value="{{ data_get($eligibility, 'state_id') }}">
                                @endif
                                <select id="state_id" name="{{ $eligibilityLocked ? 'state_id_display' : 'state_id' }}" required @disabled($eligibilityLocked) class="mt-2 block w-full min-w-0 rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2 disabled:cursor-not-allowed disabled:border-emerald-200 disabled:bg-emerald-50 disabled:text-emerald-950">
                                    <option value="">Select state</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}" @selected(($eligibilityLocked ? data_get($eligibility, 'state_id') : old('state_id')) == $state->id)>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                                <div class="relative mt-2">
                                    <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-md border border-slate-300 bg-slate-50 py-3 pl-4 pr-12 outline-none ring-emerald-500 focus:bg-white focus:ring-2">
                                    <button type="button" data-password-toggle="password" aria-label="Show password" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-slate-500 hover:text-emerald-700">
                                        <svg class="h-5 w-5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </button>
                                </div>
                                @error('password') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="text-sm font-bold text-slate-700">Confirm password</label>
                                <div class="relative mt-2">
                                    <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-md border border-slate-300 bg-slate-50 py-3 pl-4 pr-12 outline-none ring-emerald-500 focus:bg-white focus:ring-2">
                                    <button type="button" data-password-toggle="password_confirmation" aria-label="Show password confirmation" class="absolute inset-y-0 right-0 grid w-12 place-items-center text-slate-500 hover:text-emerald-700">
                                        <svg class="h-5 w-5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button data-loading-text="Creating account..." class="mt-6 w-full rounded-md bg-emerald-700 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-emerald-800">
                            Create Account
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm font-semibold text-slate-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-emerald-700 hover:text-emerald-800">Sign in</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
