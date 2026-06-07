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
            <section class="mt-8 overflow-hidden rounded-md bg-[linear-gradient(135deg,#159893,#073230)] text-white shadow-xl shadow-emerald-950/15">
                <div class="relative px-5 pb-20 pt-5 sm:px-7 sm:pb-24">
                    <div class="absolute inset-0 opacity-30 [background-image:radial-gradient(circle_at_92%_14%,rgba(255,255,255,0.35),transparent_24%),linear-gradient(135deg,transparent_55%,rgba(255,255,255,0.16)_55%,transparent_72%)]"></div>
                    <div class="relative">
                        <p class="text-sm text-emerald-100">My Applications <span class="px-2">&rsaquo;</span> <strong class="text-white">Application Details</strong></p>
                        <div class="mt-5 flex flex-wrap items-center gap-3">
                            <h2 class="text-2xl font-black tracking-tight sm:text-3xl">{{ $application->application_number }}</h2>
                            <span class="rounded-full border border-violet-200 bg-white px-3 py-1 text-sm font-black capitalize text-violet-700">
                                {{ str_replace('_', ' ', $application->status) }}
                            </span>
                        </div>
                        <div class="mt-5 flex flex-wrap gap-2 text-sm font-semibold text-emerald-50">
                            <span class="rounded-md bg-white/12 px-3 py-2">{{ $application->submitted_at?->format('d/m/Y H:i') ?? 'Draft' }}</span>
                            <span class="rounded-md bg-white/12 px-3 py-2">{{ $application->documents->count() }} docs</span>
                            <span class="rounded-md bg-white/12 px-3 py-2">{{ $application->stateOfOrigin?->name }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <div class="relative z-10 -mt-14 flex flex-col gap-6 px-4 sm:px-6 lg:flex-row">
                <aside class="shrink-0 order-1 lg:w-[404px]">
                    @include('portal.partials.application-workflow', ['application' => $application])
                </aside>

                <div class="order-2 min-w-0 flex-1">
                    <section class="rounded-[8px] border border-[rgba(0,0,0,0.04)] bg-white p-6">
                        <h2 class="text-[18px] font-semibold leading-6 text-black">Application Summary</h2>
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
                                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Training hub</dt>
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

                    <section class="mt-6 rounded-[8px] border border-[rgba(0,0,0,0.04)] bg-white p-6">
                        <h2 class="text-[18px] font-semibold leading-6 text-black">Admission Update</h2>
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
            </div>
        @endif
    </section>
@endsection
