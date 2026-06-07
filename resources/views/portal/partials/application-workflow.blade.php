@php
    $latestReview = $application->latestScreeningReview;
    $admission = $application->admission;
    $documentsComplete = $application->relationLoaded('documents')
        ? $application->hasRequiredDocuments()
        : false;

    $reviewDecision = $latestReview?->decision;
    $reviewComplete = in_array($reviewDecision, ['eligible', 'ineligible', 'shortlisted', 'waitlisted', 'rejected'], true);

    $steps = [
        [
            'title' => 'Application Submission',
            'status' => 'complete',
            'detail' => $application->submitted_at
                ? 'Your application and attached documents have been received.'
                : 'Complete your form and documents, then submit.',
            'date' => $application->submitted_at ?? $application->created_at,
        ],
        [
            'title' => 'Document Review',
            'status' => $application->submitted_at ? ($latestReview ? 'complete' : 'current') : ($documentsComplete ? 'current' : 'pending'),
            'detail' => $application->submitted_at ? 'Your uploaded documents are queued for verification.' : 'Upload all required documents before final submission.',
            'date' => $documentsComplete ? $application->updated_at : null,
        ],
        [
            'title' => 'Screening Review',
            'status' => $reviewComplete ? 'complete' : ($latestReview ? 'current' : 'pending'),
            'detail' => $latestReview
                ? 'Current decision: ' . str_replace('_', ' ', $latestReview->decision) . '.'
                : 'An NWDC reviewer will screen your application.',
            'date' => $latestReview?->reviewed_at ?? $latestReview?->created_at,
        ],
        [
            'title' => 'Initial Admission',
            'status' => $admission ? 'complete' : 'pending',
            'detail' => $admission
                ? 'Admission status: ' . str_replace('_', ' ', $admission->status) . '.'
                : 'You can confirm admission once it is issued.',
            'date' => $admission?->notified_at ?? $admission?->created_at,
        ],
        [
            'title' => 'Reporting Instructions',
            'status' => $admission?->reporting_date ? 'current' : 'pending',
            'detail' => $admission?->reporting_date
                ? 'Report on ' . $admission->reporting_date->format('M d, Y') . ' at ' . ($admission->trainingHub?->name ?? 'your assigned hub') . '.'
                : 'Reporting date and hub instructions will appear here.',
            'date' => $admission?->reporting_date,
        ],
        [
            'title' => 'Final Onboarding',
            'status' => in_array($application->status, ['onboarded'], true) ? 'complete' : 'pending',
            'detail' => 'After clearance, NWDC will confirm your cohort and start date.',
            'date' => null,
        ],
    ];

@endphp

<section class="overflow-hidden rounded-[8px] border border-[rgba(0,0,0,0.04)] bg-white">
    <div class="flex items-center justify-start border-b border-[rgba(0,0,0,0.08)] px-6 py-5">
        <h3 class="text-[16px] font-semibold leading-6 text-black">Application Stages</h3>
    </div>

    <div class="flex flex-col px-6 py-5">
        @foreach ($steps as $step)
            @php
                $circleClass = match ($step['status']) {
                    'complete' => 'bg-[#d0fae5]',
                    'current' => 'bg-[#fff7ed]',
                    default => 'bg-[#f5f5f5]',
                };
                $dotClass = match ($step['status']) {
                    'current' => 'bg-[#FFA622]',
                    default => 'bg-[rgba(115,115,115,0.3)]',
                };
            @endphp
            <div class="flex items-start gap-3">
                <div class="flex min-h-[75px] shrink-0 flex-col items-center">
                    <div class="flex h-[28px] w-[28px] shrink-0 items-center justify-center rounded-full {{ $circleClass }}">
                        @if ($step['status'] === 'complete')
                            <span class="text-[16px] font-bold leading-none text-[#059669]">&#10003;</span>
                        @else
                            <div class="h-[8px] w-[8px] rounded-full {{ $dotClass }}"></div>
                        @endif
                    </div>
                    @if (! $loop->last)
                        <div class="mt-[2px] w-[2px] flex-1 bg-[rgba(0,0,0,0.05)]"></div>
                    @endif
                </div>

                <div class="flex min-w-0 flex-1 flex-col items-start gap-[2px] pt-[4px]">
                    <span class="text-[14px] font-medium leading-5 text-black">{{ $step['title'] }}</span>
                    @if ($step['date'])
                        <div class="flex items-center gap-[7px]">
                            <span class="text-[12px] text-[rgba(0,0,0,0.4)]">{{ $step['date']->format('H:i') }}</span>
                            <div class="h-[4px] w-[4px] rounded-full bg-[rgba(0,0,0,0.4)]"></div>
                            <span class="text-[12px] text-[rgba(0,0,0,0.4)]">{{ $step['date']->format('d M Y') }}</span>
                        </div>
                    @else
                        <span class="text-[12px] leading-4 text-[rgba(0,0,0,0.5)]">{{ $step['detail'] }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
