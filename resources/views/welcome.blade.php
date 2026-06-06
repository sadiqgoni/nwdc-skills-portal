<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NWDC Youth Skills and Empowerment Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-slide {
            animation: nwdcHeroFade 18s infinite;
            opacity: 0;
        }

        .hero-slide:nth-child(2) {
            animation-delay: 6s;
        }

        .hero-slide:nth-child(3) {
            animation-delay: 12s;
        }

        @keyframes nwdcHeroFade {
            0%, 30% { opacity: 1; }
            36%, 100% { opacity: 0; }
        }
    </style>
</head>
<body class="bg-[#f7f9f6] text-slate-950 antialiased">
    <main>
        <section class="relative overflow-hidden bg-[#063f31] text-white">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_85%_20%,rgba(22,163,74,0.55),transparent_32%),linear-gradient(135deg,rgba(212,160,23,0.22),transparent_38%)]"></div>

            <div class="relative mx-auto max-w-7xl px-5 py-5 sm:px-6 lg:px-8">
                <nav class="flex items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                        <img src="/images/nwdc.png" alt="NWDC" class="h-12 w-12 shrink-0 rounded-md bg-white object-contain p-1.5">
                        <div class="min-w-0">
                            <p class="truncate text-xs font-bold uppercase tracking-wider text-amber-100">North West Development Commission</p>
                            <p class="truncate text-lg font-black">Skills Portal</p>
                        </div>
                    </a>
                    <div class="flex items-center gap-2 text-sm font-bold">
                        <a href="{{ route('eligibility') }}" class="hidden rounded-md border border-white/20 px-4 py-2 text-white hover:bg-white/10 sm:inline-flex">Eligibility</a>
                        <a href="{{ route('login') }}" class="rounded-md bg-white px-4 py-2 text-emerald-950 shadow-sm hover:bg-emerald-50">Applicant Login</a>
                    </div>
                </nav>

                <div class="grid gap-10 py-14 lg:grid-cols-[1fr_0.95fr] lg:items-center lg:py-20">
                    <div>
                        <div class="inline-flex rounded-md border border-amber-200/30 bg-white/10 px-4 py-2 text-sm font-semibold text-amber-50">
                            Applications open for eligible youth
                        </div>
                        <h1 class="mt-5 max-w-4xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-6xl">
                            NWDC Youth Skills and Empowerment Programme
                        </h1>
                        <p class="mt-6 max-w-2xl text-lg leading-8 text-emerald-50">
                            Apply for TVET and digital skills training, upload required documents, print your acknowledgement slip, and follow official updates from screening to admission.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="{{ route('eligibility') }}" class="rounded-md bg-[#d4a017] px-5 py-3 text-sm font-black text-slate-950 shadow-lg shadow-black/20 hover:bg-amber-300">
                                Start Application
                            </a>
                            <a href="{{ route('login') }}" class="rounded-md border border-white/25 px-5 py-3 text-sm font-black text-white hover:bg-white/10">
                                Continue Application
                            </a>
                        </div>

                        <div class="mt-8 grid max-w-2xl gap-3 sm:grid-cols-3">
                            <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                                <p class="text-2xl font-black">{{ $stateCount }}</p>
                                <p class="mt-1 text-sm font-semibold text-emerald-50">Eligible states</p>
                            </div>
                            <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                                <p class="text-2xl font-black">{{ $trackCount }}</p>
                                <p class="mt-1 text-sm font-semibold text-emerald-50">Training tracks</p>
                            </div>
                            <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/15">
                                <p class="text-2xl font-black">{{ $hubCount }}</p>
                                <p class="mt-1 text-sm font-semibold text-emerald-50">Training hubs</p>
                            </div>
                        </div>
                    </div>

                    <aside class="relative">
                        <div class="overflow-hidden rounded-lg bg-white/10 p-3 shadow-2xl shadow-black/30 ring-1 ring-white/15">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-md bg-emerald-950">
                                <img src="/images/skills-hero.jpg" alt="NWDC skills training" class="hero-slide absolute inset-0 h-full w-full object-cover">
                                                                <img src="/images/skills-2.jpg" alt="Digital skills classroom" class="hero-slide absolute inset-0 h-full w-full object-cover">

                                <img src="/images/skills.jpg" alt="Digital skills classroom" class="hero-slide absolute inset-0 h-full w-full object-cover">
                                <img src="/images/tvet-workshop.jpg" alt="TVET workshop" class="hero-slide absolute inset-0 h-full w-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-emerald-950/10 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <p class="text-sm font-bold uppercase tracking-wider text-amber-100">Training pathways</p>
                                    <h2 class="mt-1 text-2xl font-black text-white">Digital skills, technical trades, and practical enterprise training.</h2>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 left-6 right-6 rounded-md bg-white p-5 text-slate-950 shadow-xl ring-1 ring-emerald-100">
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Active programme</p>
                            <h3 class="mt-1 text-lg font-black">{{ $cycle?->name ?? 'Programme cycle setup pending' }}</h3>
                            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-600">
                                <span>Age: {{ $cycle?->minimum_age ?? 18 }}-{{ $cycle?->maximum_age ?? 35 }}</span>
                                <span>Application fee: <strong class="text-emerald-800">Free</strong></span>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-5 pb-12 pt-20 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">Before you apply</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Use your correct personal records.</h2>
                    <p class="mt-4 max-w-xl leading-7 text-slate-600">
                        The portal links each applicant to one NIN, one phone number, and one programme-cycle application. Keep your documents ready before final submission.
                    </p>
                </div>

                <div class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm">
                    @foreach ([
                        ['Pre-check', 'Confirm that your age and state of origin match the approved programme requirements.'],
                        ['Applicant account', 'Create an account with your phone number or email address and NIN.'],
                        ['Application record', 'Complete your personal information, education, programme choice, preferred hub, and uploads.'],
                        ['Screening updates', 'Return to the portal for acknowledgement, screening, admission, and reporting information.'],
                    ] as $row)
                        <div class="grid gap-1 border-b border-slate-100 px-5 py-4 last:border-b-0 sm:grid-cols-[0.85fr_1.4fr]">
                            <p class="font-black text-slate-950">{{ $row[0] }}</p>
                            <p class="leading-6 text-slate-600">{{ $row[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="border-y border-emerald-100 bg-white">
            <div class="mx-auto grid max-w-7xl gap-6 px-5 py-12 sm:px-6 lg:grid-cols-3 lg:px-8">
                <article class="overflow-hidden rounded-md border border-slate-200 bg-slate-50">
                    <img src="/images/digital-skills-classroom.jpg" alt="Digital skills training" class="h-52 w-full object-cover">
                    <div class="p-5">
                        <h3 class="text-xl font-black text-slate-950">Digital Skills</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Web development, data, cybersecurity, design, digital marketing, content creation, and productivity tools.</p>
                    </div>
                </article>
                <article class="overflow-hidden rounded-md border border-slate-200 bg-slate-50">
                    <img src="/images/tvet-workshop.jpg" alt="TVET workshop" class="h-52 w-full object-cover">
                    <div class="p-5">
                        <h3 class="text-xl font-black text-slate-950">TVET Tracks</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Solar, electrical, plumbing, welding, tailoring, mechanics, repair services, and other practical pathways.</p>
                    </div>
                </article>
                <article class="rounded-md border border-amber-200 bg-amber-50 p-5">
                    <p class="text-sm font-bold uppercase tracking-wider text-amber-800">Important notice</p>
                    <h3 class="mt-3 text-2xl font-black text-amber-950">Application is free.</h3>
                    <p class="mt-3 leading-7 text-amber-950">Do not pay anyone for registration, shortlisting, admission, reporting instructions, or cohort placement.</p>
                    <a href="{{ route('eligibility') }}" class="mt-5 inline-flex rounded-md bg-emerald-800 px-4 py-3 text-sm font-black text-white hover:bg-emerald-700">Check Eligibility</a>
                </article>
            </div>
        </section>
    </main>
</body>
</html>
