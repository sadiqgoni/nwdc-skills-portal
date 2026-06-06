@extends('layouts.portal')

@section('title', 'Applicant Dashboard - NWDC Skills Portal')

@section('content')
    <section class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">Applicant dashboard</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Welcome, {{ auth()->user()->name }}</h1>
                <p class="mt-3 text-slate-600">{{ $cycle?->name ?? 'No active programme cycle is currently open.' }}</p>
            </div>
            <a href="{{ route('portal.application.edit') }}" class="inline-flex justify-center rounded-md bg-emerald-800 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">
                {{ $application ? 'Open Application' : 'Start Application' }}
            </a>
        </div>

        @if (! $application)
            <div class="mt-8 rounded-md border border-amber-200 bg-amber-50 p-6">
                <h2 class="text-xl font-black text-amber-950">No application yet</h2>
                <p class="mt-2 max-w-3xl leading-7 text-amber-900">
                    Start your application by completing personal data, education, programme choice, hub preference, and document uploads.
                </p>
            </div>
        @else
            <div class="mt-8 grid gap-5 lg:grid-cols-4">
                <div class="rounded-md bg-white p-5 shadow-sm ring-1 ring-emerald-100">
                    <p class="text-sm font-bold uppercase tracking-wider text-slate-500">Application No.</p>
                    <p class="mt-2 text-2xl font-black text-emerald-900">{{ $application->application_number }}</p>
                </div>
                <div class="rounded-md bg-white p-5 shadow-sm ring-1 ring-emerald-100">
                    <p class="text-sm font-bold uppercase tracking-wider text-slate-500">Status</p>
                    <p class="mt-2 text-2xl font-black capitalize text-slate-950">{{ str_replace('_', ' ', $application->status) }}</p>
                </div>
                <div class="rounded-md bg-white p-5 shadow-sm ring-1 ring-emerald-100">
                    <p class="text-sm font-bold uppercase tracking-wider text-slate-500">Documents</p>
                    <p class="mt-2 text-2xl font-black text-slate-950">{{ $application->documents->count() }}/3</p>
                </div>
                <div class="rounded-md bg-white p-5 shadow-sm ring-1 ring-emerald-100">
                    <p class="text-sm font-bold uppercase tracking-wider text-slate-500">Entry Status</p>
                    <p class="mt-2 text-2xl font-black text-amber-700">{{ $application->submitted_at ? 'Submitted' : 'Pending' }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <section class="rounded-md bg-white p-6 shadow-sm ring-1 ring-emerald-100">
                    <h2 class="text-xl font-black text-slate-950">Application summary</h2>
                    <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Full name</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $application->full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">State of origin</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $application->stateOfOrigin?->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Programme</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $application->programmeCategory?->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Track</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $application->programmeTrack?->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Preferred hub</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $application->preferredTrainingHub?->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Submitted</dt>
                            <dd class="mt-1 font-semibold text-slate-950">{{ $application->submitted_at?->format('M d, Y h:i A') ?? 'Not submitted' }}</dd>
                        </div>
                    </dl>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('portal.documents') }}" class="rounded-md border border-emerald-200 px-4 py-3 text-sm font-black text-emerald-900 hover:bg-emerald-50">Documents</a>
                        @if ($application->submitted_at)
                            <a href="{{ route('portal.acknowledgement') }}" class="rounded-md bg-slate-950 px-4 py-3 text-sm font-black text-white hover:bg-slate-800">Acknowledgement</a>
                        @else
                            <a href="{{ route('portal.application.edit') }}" class="rounded-md bg-slate-950 px-4 py-3 text-sm font-black text-white hover:bg-slate-800">Continue Draft</a>
                        @endif
                    </div>
                </section>

                <section class="rounded-md bg-white p-6 shadow-sm ring-1 ring-emerald-100">
                    <h2 class="text-xl font-black text-slate-950">Admission update</h2>
                    @if ($application->admission)
                        <p class="mt-4 rounded-md bg-emerald-50 p-4 text-sm font-semibold capitalize text-emerald-950">
                            {{ str_replace('_', ' ', $application->admission->status) }}
                        </p>
                        <dl class="mt-5 space-y-4">
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Reporting hub</dt>
                                <dd class="mt-1 font-semibold text-slate-950">{{ $application->admission->trainingHub?->name ?? 'To be assigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Reporting date</dt>
                                <dd class="mt-1 font-semibold text-slate-950">{{ $application->admission->reporting_date?->format('M d, Y') ?? 'To be announced' }}</dd>
                            </div>
                        </dl>
                    @else
                        <p class="mt-4 leading-7 text-slate-600">
                            Screening and shortlisting updates will appear here after admin review.
                        </p>
                    @endif
                </section>
            </div>
        @endif
    </section>
@endsection
