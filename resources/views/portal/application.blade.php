@extends('layouts.portal')

@section('title', 'Application Form - NWDC Skills Portal')

@section('content')
    @php
        $hubOptions = $hubs->map(function ($hub): array {
            return [
                'id' => (string) $hub->id,
                'state_id' => (string) $hub->state_id,
                'name' => trim(($hub->state?->name ? $hub->state->name . ' - ' : '') . $hub->name),
            ];
        })->values();
    @endphp

    <section class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-md bg-emerald-950 shadow-xl shadow-emerald-950/15">
            <div class="relative p-6 text-white sm:p-8">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_88%_18%,rgba(52,211,153,0.28),transparent_30%),linear-gradient(135deg,rgba(245,158,11,0.16),transparent_42%)]"></div>
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wider text-emerald-200">Application form</p>
                        <h1 class="mt-2 text-3xl font-black tracking-tight text-white sm:text-4xl">{{ $cycle->name }}</h1>
                        <p class="mt-3 max-w-3xl leading-7 text-emerald-50">
                            Complete your details carefully. After saving this draft, you will upload your documents and submit the application.
                        </p>
                    </div>
                    <a href="{{ route('portal.dashboard') }}" class="rounded-md bg-white px-4 py-3 text-center text-sm font-black text-emerald-950 hover:bg-emerald-50">Dashboard</a>
                </div>
            </div>
        </div>

        @if ($application?->is_submitted)
            <div class="mt-6 rounded-md border border-amber-200 bg-amber-50 p-5 text-sm font-semibold text-amber-950">
                This application has been submitted and is locked for applicant edits.
            </div>
        @endif

        <form action="{{ route('portal.application.save') }}" method="post" class="mt-8 rounded-md bg-white/95 p-6 shadow-md shadow-emerald-950/10 ring-1 ring-emerald-200">
            @csrf

            <div class="space-y-8">
                <section class="rounded-md border border-emerald-100 bg-emerald-50/60 p-5">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-xl font-black text-slate-950">Applicant record</h2>
                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                These details were captured during eligibility and account creation, so they are locked on the application form.
                            </p>
                        </div>
                        <span class="inline-flex w-fit rounded-md bg-white px-3 py-2 text-xs font-black uppercase tracking-wider text-emerald-800 ring-1 ring-emerald-100">Verified entry data</span>
                    </div>

                    <dl class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="rounded-md bg-white p-4 ring-1 ring-emerald-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Full name</dt>
                            <dd class="mt-1 font-black text-slate-950">{{ $identity['full_name'] ?: 'Not available' }}</dd>
                        </div>
                        <div class="rounded-md bg-white p-4 ring-1 ring-emerald-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Date of birth</dt>
                            <dd class="mt-1 font-black text-slate-950">{{ $identity['date_of_birth'] ?: 'Not available' }}</dd>
                        </div>
                        <div class="rounded-md bg-white p-4 ring-1 ring-emerald-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">State of origin</dt>
                            <dd class="mt-1 font-black text-slate-950">{{ $identity['state_of_origin'] ?: 'Not available' }}</dd>
                        </div>
                        <div class="rounded-md bg-white p-4 ring-1 ring-emerald-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Phone number</dt>
                            <dd class="mt-1 font-black text-slate-950">{{ $identity['phone'] ?: 'Not available' }}</dd>
                        </div>
                        <div class="rounded-md bg-white p-4 ring-1 ring-emerald-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Email address</dt>
                            <dd class="mt-1 break-words font-black text-slate-950">{{ $identity['email'] ?: 'Not available' }}</dd>
                        </div>
                        <div class="rounded-md bg-white p-4 ring-1 ring-emerald-100">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">NIN</dt>
                            <dd class="mt-1 font-black text-slate-950">{{ $identity['nin'] ?: 'Not available' }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="rounded-md border border-emerald-100 bg-white p-5">
                    <h2 class="text-xl font-black text-slate-950">Personal data</h2>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2">

                        <div>
                            <label for="gender" class="text-sm font-semibold text-slate-700">Gender</label>
                            <select id="gender" name="gender" required @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                                <option value="">Select gender</option>
                                <option value="male" @selected(old('gender', $application?->gender) === 'male')>Male</option>
                                <option value="female" @selected(old('gender', $application?->gender) === 'female')>Female</option>
                                <option value="prefer_not_to_say" @selected(old('gender', $application?->gender) === 'prefer_not_to_say')>Prefer not to say</option>
                            </select>
                            @error('gender') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="residence_state_id" class="text-sm font-semibold text-slate-700">State of residence</label>
                            <select id="residence_state_id" name="residence_state_id" @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                                <option value="">Select state</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @selected(old('residence_state_id', $application?->residence_state_id) == $state->id)>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('residence_state_id') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <section class="rounded-md border border-emerald-100 bg-white p-5">
                    <h2 class="text-xl font-black text-slate-950">Origin and residence</h2>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="lga_of_origin_id" class="text-sm font-semibold text-slate-700">LGA of origin</label>
                            <select id="lga_of_origin_id" name="lga_of_origin_id" required @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                                <option value="">Select LGA</option>
                                @foreach ($lgas as $lga)
                                    <option value="{{ $lga->id }}" @selected(old('lga_of_origin_id', $application?->lga_of_origin_id) == $lga->id)>{{ $lga->name }}</option>
                                @endforeach
                            </select>
                            @error('lga_of_origin_id') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="text-sm font-semibold text-slate-700">Residential address</label>
                            <textarea id="address" name="address" rows="3" required @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">{{ old('address', $application?->address) }}</textarea>
                            @error('address') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <section class="rounded-md border border-emerald-100 bg-white p-5">
                    <h2 class="text-xl font-black text-slate-950">Education</h2>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label for="education_level" class="text-sm font-semibold text-slate-700">Highest education</label>
                            <select id="education_level" name="education_level" required @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                                <option value="">Select level</option>
                                @foreach (['Primary', 'Secondary', 'NCE/ND', 'HND/BSc', 'Postgraduate', 'Trade Certificate', 'No formal education'] as $level)
                                    <option value="{{ $level }}" @selected(old('education_level', $application?->education_level) === $level)>{{ $level }}</option>
                                @endforeach
                            </select>
                            @error('education_level') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="institution" class="text-sm font-semibold text-slate-700">Institution</label>
                            <input id="institution" name="institution" value="{{ old('institution', $application?->institution) }}" @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                            @error('institution') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="qualification" class="text-sm font-semibold text-slate-700">Qualification</label>
                            <input id="qualification" name="qualification" value="{{ old('qualification', $application?->qualification) }}" @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                            @error('qualification') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="graduation_year" class="text-sm font-semibold text-slate-700">Graduation year</label>
                            <input id="graduation_year" name="graduation_year" type="number" min="1970" max="{{ now()->year }}" value="{{ old('graduation_year', $application?->graduation_year) }}" @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                            @error('graduation_year') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <section class="rounded-md border border-emerald-100 bg-white p-5">
                    <h2 class="text-xl font-black text-slate-950">Programme choice</h2>
                    <div class="mt-5 grid gap-5 lg:grid-cols-3">
                        <div>
                            <label for="programme_category_id" class="text-sm font-semibold text-slate-700">Programme category</label>
                            <select id="programme_category_id" name="programme_category_id" required @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('programme_category_id', $application?->programme_category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('programme_category_id') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="programme_track_id" class="text-sm font-semibold text-slate-700">Trade or track</label>
                            <select id="programme_track_id" name="programme_track_id" required @disabled($application?->is_submitted) class="mt-2 w-full rounded-md border border-slate-200 px-4 py-3 outline-none ring-emerald-500 focus:ring-2 disabled:bg-slate-100">
                                <option value="">Select track</option>
                                @foreach ($tracks as $track)
                                    <option
                                        value="{{ $track->id }}"
                                        data-category-id="{{ $track->programme_category_id }}"
                                        data-hub-ids="{{ $track->trainingHubs->pluck('id')->implode(',') }}"
                                        @selected(old('programme_track_id', $application?->programme_track_id) == $track->id)
                                    >
                                        {{ $track->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('programme_track_id') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="preferred_training_hub_name" class="text-sm font-semibold text-slate-700">Training hub</label>
                            <input id="preferred_training_hub_id" name="preferred_training_hub_id" type="hidden" value="{{ old('preferred_training_hub_id', $application?->preferred_training_hub_id) }}">
                            <input id="preferred_training_hub_name" value="{{ $application?->preferredTrainingHub ? trim(($application->preferredTrainingHub->state?->name ? $application->preferredTrainingHub->state->name . ' - ' : '') . $application->preferredTrainingHub->name) : 'Select a track first' }}" readonly class="mt-2 w-full cursor-not-allowed rounded-md border border-slate-200 bg-slate-100 px-4 py-3 text-slate-700 outline-none">
                            @error('preferred_training_hub_id') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>
            </div>

            @if (! $application?->is_submitted)
                <div class="mt-8 flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('portal.dashboard') }}" class="rounded-md border border-slate-200 px-5 py-3 text-center text-sm font-black text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button data-loading-text="Saving..." class="rounded-md bg-emerald-800 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">Save and Continue</button>
                </div>
            @endif
        </form>
    </section>

    @if (! $application?->is_submitted)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const categorySelect = document.getElementById('programme_category_id');
                const trackSelect = document.getElementById('programme_track_id');
                const hubIdInput = document.getElementById('preferred_training_hub_id');
                const hubNameInput = document.getElementById('preferred_training_hub_name');
                const stateOfOriginId = @json((string) data_get($identity, 'state_of_origin_id'));
                const hubs = @json($hubOptions);
                const originalTrackOptions = Array.from(trackSelect.options).map((option) => option.cloneNode(true));

                const replaceOptions = (select, options) => {
                    select.replaceChildren(...options.map((option) => option.cloneNode(true)));
                };

                const selectedTrackHubIds = () => {
                    const selected = trackSelect.selectedOptions[0];
                    const hubIds = selected?.dataset.hubIds || '';

                    return hubIds.split(',').filter(Boolean);
                };

                const filterTracks = () => {
                    const selectedCategoryId = categorySelect.value;
                    const currentTrackId = trackSelect.value;
                    const options = originalTrackOptions.filter((option) => {
                        return ! option.value || option.dataset.categoryId === selectedCategoryId;
                    });

                    replaceOptions(trackSelect, options);

                    if (currentTrackId && Array.from(trackSelect.options).some((option) => option.value === currentTrackId)) {
                        trackSelect.value = currentTrackId;
                    } else {
                        trackSelect.value = '';
                    }
                };

                const filterHubs = () => {
                    const hubIds = selectedTrackHubIds();
                    const stateHub = hubs.find((hub) => hubIds.includes(hub.id) && hub.state_id === stateOfOriginId);

                    if (stateHub) {
                        hubIdInput.value = stateHub.id;
                        hubNameInput.value = stateHub.name;
                        return;
                    }

                    hubIdInput.value = '';
                    hubNameInput.value = hubIds.length ? 'No hub in your state for this track' : 'Select a track first';
                };

                categorySelect.addEventListener('change', () => {
                    filterTracks();
                    filterHubs();
                });

                trackSelect.addEventListener('change', filterHubs);

                filterTracks();
                filterHubs();
            });
        </script>
    @endif
@endsection
