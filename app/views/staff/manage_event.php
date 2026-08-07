<?php
$starts = strtotime($eventData['StartsAt']);
$ends = strtotime($eventData['EndsAt']);

$diffMinutes = max(0, round(($ends - $starts) / 60));
$hours = intdiv($diffMinutes, 60);
$minutes = $diffMinutes % 60;
$durationParts = [];

if ($hours > 0) {
    $durationParts[] = $hours . ' hr' . ($hours > 1 ? 's' : '');
}

if ($minutes > 0) {
    $durationParts[] = $minutes . ' min';
}

$duration = implode(' ', $durationParts) ?: '—';
?>

<section class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div class="space-y-2">
            <div class="space-y-1">
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl"><?= htmlspecialchars($eventData['Name']) ?></h1>
                <p class="text-sm text-gray-500">Review the event details, schedule, and location.</p>
            </div>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <a href="<?= url("/staff/events/{$id}/edit") ?>" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                Edit event
            </a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Starts</p>
            <p class="mt-2 text-base font-semibold text-gray-900"><?= date('F j, Y', $starts) ?></p>
            <p class="text-sm text-gray-600"><?= date('g:i A', $starts) ?></p>
        </div>
        <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Ends</p>
            <p class="mt-2 text-base font-semibold text-gray-900"><?= date('F j, Y', $ends) ?></p>
            <p class="text-sm text-gray-600"><?= date('g:i A', $ends) ?></p>
        </div>
        <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Duration</p>
            <p class="mt-2 text-base font-semibold text-gray-900"><?= $duration ?></p>
            <p class="text-sm text-gray-600">Total scheduled time</p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm lg:col-span-2">
            <h2 class="text-sm font-medium text-gray-500">Description</h2>
            <p class="mt-2 text-base font-normal text-gray-900"><?= htmlspecialchars($eventData['Description']) ?></p>
        </div>
        <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Location</p>
            <p class="mt-2 text-base font-normal text-gray-900"><?= htmlspecialchars($eventData['Location']) ?></p>
        </div>

        <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm lg:col-span-3 overflow-x-auto max-w-full">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h2 class="text-lg font-semibold tracking-tight text-gray-900">Bookings</h2>
                    <p class="mt-1 text-sm text-gray-500">Search, sort, and review attendee bookings for this event.</p>
                </div>
                <div class="flex w-full flex-col gap-2 lg:w-auto lg:flex-row">
                    <label for="booking-search" class="sr-only">Search bookings</label>
                    <div class="flex items-center">
                        <span class="inline-flex border border-gray-200 px-3 py-2.5 bg-gray-50 text-gray-800 items-center border-r-0 rounded-md rounded-r-none">
                            <svg class="size-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                            </svg>
                        </span>

                        <input id="booking-search" name="search" type="search" hx-get="<?= url("/staff/events/{$id}/bookings/") ?>" hx-trigger="keyup changed delay:500ms, search" hx-target="#target-container" hx-swap="innerHTML" placeholder="Search by name or email" class="w-full text-base rounded-md rounded-l-none border border-gray-200 bg-white px-3 py-2  text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 lg:w-72">
                    </div>

                </div>
            </div>

            <div id="target-container" x-data="{showModal : false, modalData : [], showDeleteModal : false}">
                <?php 
                $currentPage ??= 1;
                $search ??= '';
                $sortKey ??= '';
                $sortOrder ??= '';

                require __DIR__ . '/../partials/bookings.php';
                ?>
            </div>

        </div>
    </div>
</section>