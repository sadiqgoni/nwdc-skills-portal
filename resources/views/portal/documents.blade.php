@extends('layouts.portal')

@section('title', 'Document Upload - NWDC Skills Portal')

@section('content')
    <section class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-md bg-emerald-950 shadow-xl shadow-emerald-950/15">
            <div class="relative p-6 text-white sm:p-8">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_85%_20%,rgba(52,211,153,0.28),transparent_30%),linear-gradient(135deg,rgba(245,158,11,0.18),transparent_42%)]"></div>
                <div class="relative flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-emerald-200">Document upload</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-white sm:text-4xl">{{ $application->application_number }}</h1>
                <p class="mt-3 max-w-3xl leading-7 text-emerald-50">
                    Upload the required documents before final submission. PDF, JPG, and PNG files are accepted for documents; passport photo must be JPG or PNG.
                </p>
            </div>
            <a href="{{ route('portal.application.edit') }}" class="rounded-md bg-white px-4 py-3 text-center text-sm font-black text-emerald-950 hover:bg-emerald-50">Back to Form</a>
                </div>
            </div>
        </div>

        @if ($application->is_submitted)
            <div class="mt-6 rounded-md border border-emerald-200 bg-emerald-50 p-5 text-sm font-semibold text-emerald-950">
                Your application has been submitted. Uploaded documents are locked for applicant changes.
            </div>
        @endif

        <div class="mt-8 grid gap-4 lg:grid-cols-3">
            @foreach ($documentTypes as $type => $meta)
                @php($document = $application->documents->firstWhere('document_type', $type))
	                <section class="overflow-hidden rounded-md bg-white shadow-md shadow-emerald-950/10 ring-1 ring-emerald-200">
	                    <div class="h-2 {{ $document ? 'bg-emerald-700' : 'bg-amber-400' }}"></div>
	                    <div class="p-5">
	                        <div class="flex min-w-0 items-start justify-between gap-3">
	                            <div class="min-w-0">
	                                <h2 class="truncate text-lg font-black text-slate-950">{{ $meta['label'] }}</h2>
	                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ $meta['hint'] }}</p>
	                            </div>
	                            <span class="shrink-0 rounded-full px-3 py-1 text-xs font-black {{ $document ? 'bg-emerald-100 text-emerald-900' : 'bg-amber-100 text-amber-900' }}">
	                                {{ $document ? 'Uploaded' : 'Required' }}
	                            </span>
	                        </div>

	                        @if ($document)
	                            <div class="mt-4 min-w-0 rounded-md border border-emerald-100 bg-emerald-50/70 p-4 text-sm">
	                                <p class="truncate font-bold text-slate-950" title="{{ $document->original_name }}">{{ $document->original_name }}</p>
	                                <p class="mt-1 text-slate-500">{{ number_format(($document->file_size ?? 0) / 1024, 1) }} KB</p>
	                                <p class="mt-2 font-semibold capitalize text-slate-700">Status: {{ str_replace('_', ' ', $document->verification_status) }}</p>
	                                <a href="{{ route('portal.documents.view', $type) }}" target="_blank" class="mt-3 inline-flex rounded-md border border-emerald-200 bg-white px-3 py-2 text-xs font-black text-emerald-900 hover:bg-emerald-50">
	                                    View File
	                                </a>
	                            </div>
	                        @endif

	                        @if (! $application->is_submitted)
	                            <form action="{{ route('portal.documents.upload', $type) }}" method="post" enctype="multipart/form-data" class="mt-4 space-y-3">
	                                @csrf
	                                <input name="document" type="file" required class="block w-full min-w-0 rounded-md border border-emerald-200 bg-emerald-50/50 px-3 py-3 text-xs outline-none ring-emerald-500 file:mr-3 file:rounded-md file:border-0 file:bg-white file:px-3 file:py-2 file:text-xs file:font-bold file:text-emerald-900 focus:ring-2 sm:text-sm sm:file:text-sm">
	                                @error('document') <p class="text-sm text-rose-600">{{ $message }}</p> @enderror
	                                <button data-loading-text="Uploading..." class="w-full rounded-md bg-emerald-700 px-4 py-3 text-sm font-black text-white hover:bg-emerald-800">
	                                    {{ $document ? 'Replace File' : 'Upload File' }}
	                                </button>
	                            </form>
	                        @endif
	                    </div>
	                </section>
            @endforeach
        </div>

        <section class="mt-8 rounded-md border border-emerald-200 bg-white/95 p-6 shadow-md shadow-emerald-950/10">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-950">Final submission</h2>
                    <p class="mt-2 max-w-3xl leading-7 text-slate-600">
                        Review your details before submitting. Once submitted, the applicant portal will lock edits and generate acknowledgement.
                    </p>
                </div>
                @if ($application->submitted_at)
                    <a href="{{ route('portal.acknowledgement') }}" class="rounded-md bg-slate-950 px-5 py-3 text-center text-sm font-black text-white hover:bg-slate-800">View Acknowledgement</a>
                @else
                    <form action="{{ route('portal.application.submit') }}" method="post">
                        @csrf
                        <button data-loading-text="Submitting..." class="rounded-md bg-emerald-800 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">
                            Submit Application
                        </button>
                    </form>
                @endif
            </div>
        </section>
    </section>
@endsection
