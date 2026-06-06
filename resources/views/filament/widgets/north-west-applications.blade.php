<x-filament-widgets::widget class="nwdc-region-widget">
    <section class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-emerald-100">
        <div class="bg-emerald-950 px-6 py-5 text-white">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-200">Regional dashboard</p>
                    <h2 class="mt-2 text-2xl font-black">North-West Applications</h2>
                    <p class="mt-2 max-w-3xl text-sm leading-6 text-emerald-50">
                        State-level view of applications, submitted records, LGAs, and active training hubs across the NWDC mandate area.
                    </p>
                </div>
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="rounded-lg bg-white/10 px-4 py-3 ring-1 ring-white/15">
                        <p class="text-xl font-black">{{ number_format($totalApplications) }}</p>
                        <p class="mt-1 text-xs font-semibold text-emerald-100">Applications</p>
                    </div>
                    <div class="rounded-lg bg-white/10 px-4 py-3 ring-1 ring-white/15">
                        <p class="text-xl font-black">{{ number_format($submittedApplications) }}</p>
                        <p class="mt-1 text-xs font-semibold text-emerald-100">Submitted</p>
                    </div>
                    <div class="rounded-lg bg-white/10 px-4 py-3 ring-1 ring-white/15">
                        <p class="text-xl font-black">{{ number_format($activeHubs) }}</p>
                        <p class="mt-1 text-xs font-semibold text-emerald-100">Hubs</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-0 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="border-b border-emerald-100 bg-emerald-50/70 p-6 lg:border-b-0 lg:border-r">
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($states as $state)
                        <div class="rounded-lg bg-white p-4 text-center shadow-sm ring-1 ring-emerald-100">
                            <p class="text-xs font-black uppercase tracking-wider text-emerald-700">{{ $state['code'] }}</p>
                            <p class="mt-1 text-sm font-black text-slate-950">{{ $state['name'] }}</p>
                            <p class="mt-3 text-2xl font-black text-emerald-800">{{ number_format($state['applications']) }}</p>
                            <p class="text-xs font-semibold text-slate-500">applications</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4 p-6">
                @foreach ($states as $state)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <div>
                                <span class="font-black text-slate-950">{{ $state['name'] }}</span>
                                <span class="ml-2 text-xs font-semibold text-slate-500">{{ $state['lgas'] }} LGAs · {{ $state['hubs'] }} hub{{ $state['hubs'] === 1 ? '' : 's' }}</span>
                            </div>
                            <span class="font-black text-emerald-800">{{ number_format($state['submitted']) }} submitted</span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-emerald-100">
                            <div class="h-full rounded-full bg-emerald-700" style="width: {{ max(5, ($state['applications'] / $maximumApplications) * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-filament-widgets::widget>
