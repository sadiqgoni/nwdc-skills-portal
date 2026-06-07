@extends('layouts.portal')

@section('title', 'Acknowledgement - NWDC Skills Portal')

@section('content')
    <style>
        @media print {
            header, .no-print { display: none !important; }
            body { background: #ffffff !important; }
            .print-panel { box-shadow: none !important; border: 1px solid #d1d5db !important; }
        }
    </style>

    <section class="mx-auto max-w-5xl px-5 py-8 sm:px-6 lg:px-8">
        <div class="no-print mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">Acknowledgement slip</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Application received</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('portal.dashboard') }}" class="rounded-md border border-emerald-200 px-4 py-3 text-sm font-black text-emerald-900 hover:bg-emerald-50">Dashboard</a>
                <button onclick="window.print()" class="rounded-md bg-slate-950 px-4 py-3 text-sm font-black text-white hover:bg-slate-800">Print Slip</button>
            </div>
        </div>

        <article class="print-panel rounded-md bg-white p-6 shadow-xl shadow-emerald-950/10 ring-1 ring-emerald-100">
            <div class="flex flex-col gap-5 border-b border-slate-200 pb-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <img src="/images/nwdc.png" alt="NWDC" class="h-16 w-16 rounded-md object-contain ring-1 ring-emerald-100">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wider text-emerald-700">North West Development Commission</p>
                        <h2 class="text-2xl font-black text-slate-950">Skills Programme Application</h2>
                    </div>
                </div>
                <div class="rounded-md bg-emerald-50 px-4 py-3 text-right">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Application number</p>
                    <p class="mt-1 text-xl font-black text-emerald-950">{{ $application->application_number }}</p>
                </div>
            </div>

            <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Applicant</dt>
                    <dd class="mt-1 font-semibold text-slate-950">{{ $application->full_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Submitted</dt>
                    <dd class="mt-1 font-semibold text-slate-950">{{ $application->submitted_at->format('M d, Y h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">State and LGA</dt>
                    <dd class="mt-1 font-semibold text-slate-950">{{ $application->stateOfOrigin?->name }} / {{ $application->lgaOfOrigin?->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Phone</dt>
                    <dd class="mt-1 font-semibold text-slate-950">{{ $application->phone }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Programme category</dt>
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
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Status</dt>
                    <dd class="mt-1 font-semibold capitalize text-slate-950">{{ str_replace('_', ' ', $application->status) }}</dd>
                </div>
            </dl>

            <div class="mt-6 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm leading-7 text-amber-950">
                Keep this acknowledgement number safe. Screening, shortlisting, admission notification, reporting instructions, and cohort assignment will be managed through the portal.
            </div>

            <div class="no-print mt-6">
                @include('portal.partials.application-workflow', ['application' => $application])
            </div>

            <div class="mt-6 rounded-md bg-slate-50 p-5">
                <h3 class="text-lg font-black text-slate-950">Notification details</h3>
                <p class="mt-2 text-sm leading-7 text-slate-600">
                    NWDC will use the contact details below for screening, admission, and reporting updates. Keep your phone active and check your email regularly.
                </p>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Phone number</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $application->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Email address</dt>
                        <dd class="mt-1 font-semibold text-slate-950">{{ $application->email ?: 'Not provided' }}</dd>
                    </div>
                </dl>
            </div>
        </article>
    </section>
@endsection
