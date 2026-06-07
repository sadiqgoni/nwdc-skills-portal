<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eligibility Check - NWDC Skills Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_80%_80%,#16a34a_0%,#0f7a3d_30%,#063f31_62%,#022c22_100%)] text-slate-950 antialiased">
    <main class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-6 lg:px-8">
        <section class="grid w-full max-w-6xl overflow-hidden rounded-md bg-white shadow-2xl shadow-emerald-950/40 lg:min-h-[620px] lg:grid-cols-[0.86fr_1.14fr]">
            <aside class="relative overflow-hidden bg-[#0b5f37] p-5 text-white sm:p-10 lg:p-12">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.12),transparent_28%),linear-gradient(160deg,rgba(212,160,23,0.22),transparent_38%)]"></div>
                <div class="relative flex h-full flex-col">
                    <a href="{{ route('home') }}" class="inline-flex w-fit items-center">
                        <span class="grid h-8 w-8 place-items-center rounded-md bg-white p-1 ring-1 ring-white/20 sm:h-12 sm:w-12">
                            <img src="/images/nwdc.png" alt="NWDC" class="max-h-full max-w-full object-contain">
                        </span>
                    </a>

                    <div class="mt-4 sm:mt-8">
                        <p class="text-xs font-bold uppercase tracking-wider text-amber-100 sm:text-sm">Applicant pre-check</p>
                        <h1 class="mt-2 text-2xl font-black leading-tight sm:mt-3 sm:text-4xl">
                            Confirm before account creation.
                        </h1>
                        <p class="mt-3 max-w-md text-sm leading-6 text-emerald-50 sm:mt-5 sm:text-base sm:leading-8">
                            Confirm your age and state of origin before account creation.
                        </p>
                    </div>

                    <div class="mt-4 hidden space-y-3 sm:mt-8 sm:block">
                        <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">Simple first step</p>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">The full application opens immediately when your details meet the approved entry rule.</p>
                        </div>
                        <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="font-black">Prepare your records</p>
                            <p class="mt-1 text-sm leading-6 text-emerald-100">Use the same personal details you will submit during account creation and document upload.</p>
                        </div>
                    </div>

                    <p class="mt-auto hidden pt-8 text-sm leading-6 text-emerald-100 sm:block">
                        Keep your NIN, phone number, email address, and documents ready. If you meet the requirement, you can continue immediately to account creation.
                    </p>
                </div>
            </aside>

            <div class="flex items-center p-5 sm:p-10 lg:p-14">
                <div class="w-full">
                    <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">Eligibility check</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Check your details.</h2>
                    <p class="mt-3 leading-7 text-slate-600">
Please enter your date of birth and state of origin. Eligible applicants will then be able to create an account.
                    </p>

                    <form action="{{ route('eligibility.check') }}" method="post" class="mt-7 space-y-5">
                        @csrf
                        <div>
                            <label for="date_of_birth" class="text-sm font-bold text-slate-700">Date of birth</label>
                            <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" required
                                class="mt-2 block w-full min-w-0 max-w-full appearance-none rounded-md border border-slate-300 bg-slate-50 px-4 py-3 text-center outline-none ring-emerald-500 [box-sizing:border-box] [color-scheme:light] focus:bg-white focus:ring-2">
                            @error('date_of_birth')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state_id" class="text-sm font-bold text-slate-700">State of origin</label>
                            <select id="state_id" name="state_id" required class="mt-2 w-full rounded-md border border-slate-300 bg-slate-50 px-4 py-3 outline-none ring-emerald-500 focus:bg-white focus:ring-2">
                                <option value="">Select your state</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @selected(old('state_id') == $state->id)>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button data-loading-text="Checking..." class="w-full rounded-md bg-emerald-700 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-emerald-800">
                            Check and Continue
                        </button>
                    </form>

                    @if ($result)
                        <div id="eligibility-result" tabindex="-1" class="mt-6 scroll-mt-6 rounded-md border p-5 outline-none {{ $result['passed'] ? 'border-emerald-200 bg-emerald-50 text-emerald-950' : 'border-rose-200 bg-rose-50 text-rose-950' }}">
                            <p class="text-sm font-bold uppercase tracking-wider">{{ $result['passed'] ? 'You can continue' : 'Not accepted for this cycle' }}</p>
                            <h3 class="mt-2 text-2xl font-black">{{ $result['state'] }} applicant, age {{ $result['age'] }}</h3>
                            <p class="mt-3 leading-7">{{ $result['message'] }}</p>
                            @if ($result['passed'])
                                <a href="{{ auth()->check() ? route('portal.application.edit') : route('register') }}" class="mt-5 inline-flex rounded-md bg-emerald-700 px-5 py-3 text-sm font-black text-white hover:bg-emerald-800">
                                    Proceed to Application
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="mt-6 text-center text-sm font-semibold text-slate-500">
                        Already created an account?
                        <a href="{{ route('login') }}" class="text-emerald-700 hover:text-emerald-800">Login here</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @if ($result)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const result = document.getElementById('eligibility-result');

                if (result) {
                    result.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    result.focus({ preventScroll: true });
                }
            });
        </script>
    @endif
</body>
</html>
