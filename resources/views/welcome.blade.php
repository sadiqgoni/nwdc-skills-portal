<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NWDC Youth Skills and Empowerment Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-slide {
            animation: nwdcHeroFade 24s infinite;
            opacity: 0;
        }

        .hero-dot {
            animation: nwdcDotPulse 24s infinite;
            background: rgba(255, 255, 255, 0.38);
        }

        .hero-slide:nth-child(2) {
            animation-delay: 6s;
        }

        .hero-slide:nth-child(3) {
            animation-delay: 12s;
        }

        .hero-slide:nth-child(4) {
            animation-delay: 18s;
        }

        .hero-dot:nth-child(2) {
            animation-delay: 6s;
        }

        .hero-dot:nth-child(3) {
            animation-delay: 12s;
        }

        .hero-dot:nth-child(4) {
            animation-delay: 18s;
        }

        @keyframes nwdcHeroFade {
            0%, 20% { opacity: 1; }
            26%, 100% { opacity: 0; }
        }

        @keyframes nwdcDotPulse {
            0%, 20% { background: #d4a017; transform: scaleX(1.75); }
            26%, 100% { background: rgba(255, 255, 255, 0.38); transform: scaleX(1); }
        }

        .rise-in {
            animation: nwdcRiseIn 0.78s ease-out both;
        }

        .rise-in-delay {
            animation: nwdcRiseIn 0.9s 0.12s ease-out both;
        }

        @keyframes nwdcRiseIn {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        [data-reveal] {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.72s ease, transform 0.72s ease;
        }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        [data-reveal="stagger"] > * {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.68s ease, transform 0.68s ease;
        }

        [data-reveal="stagger"].is-visible > * {
            opacity: 1;
            transform: translateY(0);
        }

        [data-reveal="stagger"].is-visible > *:nth-child(2) {
            transition-delay: 0.08s;
        }

        [data-reveal="stagger"].is-visible > *:nth-child(3) {
            transition-delay: 0.16s;
        }

        .training-card img {
            transition: transform 0.85s ease;
        }

        .training-card:hover img {
            transform: scale(1.045);
        }

        @media (prefers-reduced-motion: reduce) {
            .hero-slide,
            .hero-dot,
            .rise-in,
            .rise-in-delay,
            [data-reveal],
            [data-reveal="stagger"] > *,
            .training-card img {
                animation: none !important;
                transition: none !important;
            }

            .hero-slide:first-child {
                opacity: 1;
            }

            [data-reveal],
            [data-reveal="stagger"] > * {
                opacity: 1;
                transform: none;
            }
        }

        html,
        body {
            overflow-x: hidden;
            width: 100%;
        }

        .mobile-safe {
            max-width: calc(100vw - 2rem);
            width: 100%;
        }

        @media (min-width: 640px) {
            .mobile-safe {
                max-width: none;
            }
        }
    </style>
</head>
<body class="bg-[#f7f9f6] text-slate-950 antialiased">
    <main>
        <section class="relative overflow-hidden bg-[#063f31] text-white">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_85%_20%,rgba(22,163,74,0.55),transparent_32%),linear-gradient(135deg,rgba(212,160,23,0.22),transparent_38%)]"></div>

            <div class="relative mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                <nav class="mobile-safe flex min-w-0 items-center justify-between gap-3">
                    <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                        <img src="/images/nwdc.png" alt="NWDC" class="h-11 w-11 shrink-0 rounded-md bg-white object-contain p-1.5 sm:h-12 sm:w-12">
                        <div class="min-w-0">
                            <p class="hidden truncate text-xs font-bold uppercase tracking-wider text-amber-100 sm:block">North West Development Commission</p>
                            <p class="truncate text-base font-black sm:text-lg">Skills Portal</p>
                        </div>
                    </a>
                    <div class="flex shrink-0 items-center gap-2 text-sm font-bold">
                        <a href="{{ route('eligibility') }}" class="hidden rounded-md border border-white/20 px-4 py-2 text-white hover:bg-white/10 sm:inline-flex">Eligibility</a>
                        <a href="{{ route('login') }}" class="rounded-md bg-white px-3 py-2 text-emerald-950 shadow-sm hover:bg-emerald-50 sm:px-4">Login</a>
                    </div>
                </nav>

                <div class="mobile-safe grid min-w-0 gap-10 py-10 sm:py-14 lg:grid-cols-[minmax(0,1fr)_minmax(0,0.95fr)] lg:items-center lg:py-12 lg:pb-10">
                    <div class="min-w-0 rise-in">
                        <div class="inline-flex rounded-md border border-amber-200/30 bg-white/10 px-4 py-2 text-sm font-semibold text-amber-50">
                            Applications open for eligible youth
                        </div>
                        <h1 class="mt-5 max-w-full break-words text-3xl font-black tracking-tight text-white sm:text-5xl lg:max-w-4xl lg:text-5xl xl:text-6xl">
                            NWDC Youth Skills and Empowerment Programme
                        </h1>
                        <p class="mt-5 max-w-full break-words text-base leading-7 text-emerald-50 sm:mt-6 sm:max-w-2xl sm:text-lg sm:leading-8">
                            Apply for TVET and digital skills training, upload required documents, print your acknowledgement slip, and follow official updates from screening to admission.
                        </p>

                        <div class="mt-8 grid min-w-0 gap-3 sm:flex sm:flex-wrap">
                            <a href="{{ route('eligibility') }}" class="rounded-md bg-[#d4a017] px-5 py-3 text-center text-sm font-black text-slate-950 shadow-lg shadow-black/20 hover:bg-amber-300">
                                Start Application
                            </a>
                            <a href="{{ route('login') }}" class="rounded-md border border-white/25 px-5 py-3 text-center text-sm font-black text-white hover:bg-white/10">
                                Continue Application
                            </a>
                        </div>

                        <div class="mt-8 grid max-w-full gap-3 sm:max-w-2xl sm:grid-cols-3">
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

                    <aside class="relative mx-auto w-full max-w-full min-w-0 rise-in-delay">
                        <div class="mx-auto w-full max-w-full overflow-hidden rounded-lg bg-white/10 p-3 shadow-2xl shadow-black/30 ring-1 ring-white/15">
                            <div class="relative mx-auto aspect-[4/3] min-h-[300px] w-full max-w-full overflow-hidden rounded-md bg-emerald-950 sm:min-h-0 lg:max-h-[520px]">
                                <img src="/images/skills-hero.jpg" alt="NWDC skills training" width="1600" height="800" fetchpriority="high" decoding="async" class="hero-slide absolute inset-0 h-full w-full object-cover object-center">
                                <img data-src="/images/skills-2.jpg" alt="Digital skills classroom" width="1170" height="738" loading="lazy" decoding="async" class="hero-slide absolute inset-0 h-full w-full object-cover object-center">
                                <img data-src="/images/skills.jpg" alt="Digital skills classroom" width="1024" height="682" loading="lazy" decoding="async" class="hero-slide absolute inset-0 h-full w-full object-cover object-center">
                                <img data-src="/images/tvet-workshop.jpg" alt="TVET workshop" width="1400" height="700" loading="lazy" decoding="async" class="hero-slide absolute inset-0 h-full w-full object-cover object-center">
                                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-emerald-950/10 to-transparent"></div>
                                <div class="absolute left-5 top-5 flex gap-2">
                                    <span class="hero-dot h-2 w-6 rounded-full"></span>
                                    <span class="hero-dot h-2 w-6 rounded-full"></span>
                                    <span class="hero-dot h-2 w-6 rounded-full"></span>
                                    <span class="hero-dot h-2 w-6 rounded-full"></span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <p class="text-sm font-bold uppercase tracking-wider text-amber-100">Training pathways</p>
                                    <h2 class="mt-1 text-xl font-black text-white sm:text-2xl">Digital skills, technical trades, and practical enterprise training.</h2>
                                </div>
                            </div>
                        </div>

                        <div class="relative mt-3 rounded-md bg-white p-4 text-slate-950 shadow-xl ring-1 ring-emerald-100 sm:absolute sm:-bottom-6 sm:left-6 sm:right-6 sm:mt-0 sm:p-5">
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

        <section class="border-y border-emerald-900 bg-emerald-950 py-2 text-white">
            <div class="mx-auto flex max-w-7xl flex-wrap gap-2 px-3">
                @foreach ([
                    'Digital Literacy',
                    'Frontend Web Development',
                    'Solar Installation',
                    'Welding and Fabrication',
                    'UI/UX Design',
                    'Data Analysis',
                    'Tailoring and Fashion Design',
                    'Phone Repair',
                    'Cybersecurity Fundamentals',
                    'Catering and Culinary Skills',
                    'Cloud Computing Fundamentals',
                    'Automobile Mechanics',
                ] as $track)
                    <span class="rounded-md border border-white/10 bg-white/10 px-3 py-2 text-[11px] font-black uppercase tracking-wider text-emerald-50 sm:px-4 sm:text-xs">{{ $track }}</span>
                @endforeach
            </div>
        </section>

        <section class="bg-white" data-reveal>
            <div class="mx-auto grid max-w-7xl gap-8 px-5 py-10 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">About NWDC</p>
                    <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">Driving human capital development across the North-West.</h2>
                </div>
                <div class="grid gap-5 md:grid-cols-3" data-reveal="stagger">
                    <div class="rounded-md border border-emerald-100 bg-emerald-50 p-5">
                        <p class="text-2xl font-black text-emerald-900">7</p>
                        <p class="mt-1 text-sm font-bold text-slate-950">Member states</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Jigawa, Kaduna, Kano, Katsina, Kebbi, Sokoto, and Zamfara.</p>
                    </div>
                    <div class="rounded-md border border-emerald-100 bg-emerald-50 p-5">
                        <p class="text-2xl font-black text-emerald-900">186</p>
                        <p class="mt-1 text-sm font-bold text-slate-950">LGAs</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">A regional mandate focused on recovery, stability, and opportunity.</p>
                    </div>
                    <div class="rounded-md border border-emerald-100 bg-emerald-50 p-5">
                        <p class="text-2xl font-black text-emerald-900">2024</p>
                        <p class="mt-1 text-sm font-bold text-slate-950">Established by law</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">NWDC supports sustainable development and human capital growth in the zone.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-5 pb-12 pt-12 sm:px-6 lg:px-8" data-reveal>
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">Before you apply</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-950">Use your correct personal records.</h2>
                    <p class="mt-4 max-w-xl leading-7 text-slate-600">
                        The portal links each applicant to one NIN, one phone number, and one programme-cycle application. Keep your documents ready before final submission.
                    </p>
                </div>

                <div class="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm" data-reveal="stagger">
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
            <div class="mx-auto grid max-w-7xl gap-6 px-5 py-12 sm:px-6 lg:grid-cols-3 lg:px-8" data-reveal="stagger">
                <article class="training-card overflow-hidden rounded-md border border-slate-200 bg-slate-50">
                    <img src="/images/digital-skills-classroom.jpg" alt="Digital skills training" class="h-52 w-full object-cover">
                    <div class="p-5">
                        <h3 class="text-xl font-black text-slate-950">Digital Skills</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Web development, data, cybersecurity, design, digital marketing, content creation, and productivity tools.</p>
                    </div>
                </article>
                <article class="training-card overflow-hidden rounded-md border border-slate-200 bg-slate-50">
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
    <script>
        window.addEventListener('load', () => {
            const loadDeferredHeroSlides = () => {
                document.querySelectorAll('.hero-slide[data-src]').forEach((image) => {
                    image.src = image.dataset.src;
                    image.removeAttribute('data-src');
                });
            };

            if ('requestIdleCallback' in window) {
                requestIdleCallback(loadDeferredHeroSlides, { timeout: 1200 });
            } else {
                setTimeout(loadDeferredHeroSlides, 600);
            }
        });
    </script>
</body>
</html>
