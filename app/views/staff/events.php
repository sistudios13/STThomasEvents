<?php
$formatEventTiming = static function (array $event): array {
    $starts = strtotime($event['StartsAt']);
    $ends = strtotime($event['EndsAt']);
    $sameDay = date('Y-m-d', $starts) === date('Y-m-d', $ends);

    return [
        'dateLabel' => date('F j, Y', $starts),
        'timeLabel' => $sameDay
            ? date('g:i A', $starts) . ' – ' . date('g:i A', $ends)
            : date('g:i A', $starts) . ' – ' . date('M j, g:i A', $ends),
    ];
};
?>

<section class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">All Events</h1>
            <p class="max-w-lg text-sm text-gray-500">Review upcoming activity, manage live events, and keep past sessions organized from one view.</p>
        </div>
        <a href="<?= url('/staff/events/new/') ?>" class="inline-flex whitespace-nowrap items-center justify-center rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                <svg class="size-5 mr-1 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                </svg>

                Create event</a>
    </div>

    <?php if (!empty($eventsData)): ?>
        <div class="space-y-8">
            <?php if (!empty($eventsData['ongoing'])): ?>
                <section class="space-y-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-semibold tracking-tight text-gray-900">In Progress</h2>
                            <p class="text-sm text-gray-500">Events that are currently in progress.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <?php foreach ($eventsData['ongoing'] as $event): ?>
                            <?php $eventTiming = $formatEventTiming($event); ?>
                            <article class="flex h-full flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm">
                                <div class="p-4 sm:p-5">
                                    <h3 class="text-lg font-semibold tracking-tight text-gray-900"><?= htmlspecialchars($event['Name']) ?></h3>


                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600"><?= nl2br(htmlspecialchars($event['Description'])) ?></p>

                                    <dl class="mt-4 space-y-3 border-t border-gray-100 pt-4 text-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <dt class="text-gray-500">Date</dt>
                                            <dd class="text-right font-medium text-gray-900"><?= $eventTiming['dateLabel'] ?></dd>
                                        </div>
                                        <div class="flex items-start justify-between gap-4">
                                            <dt class="text-gray-500">Time</dt>
                                            <dd class="text-right font-medium text-gray-900"><?= $eventTiming['timeLabel'] ?></dd>
                                        </div>
                                    </dl>

                                    <div class="mt-5">
                                        <a href="<?= url('/staff/events/' . $event['Id']) ?>" class="inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                            Manage event
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($eventsData['future'])): ?>
                <section class="space-y-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-semibold tracking-tight text-gray-900">Future Events</h2>
                            <p class="text-sm text-gray-500">Events scheduled for later.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <?php foreach ($eventsData['future'] as $event): ?>
                            <?php $eventTiming = $formatEventTiming($event); ?>
                            <article class="flex h-full flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm">
                                <div class="p-4 sm:p-5">

                                    <h3 class="text-lg font-semibold tracking-tight text-gray-900"><?= htmlspecialchars($event['Name']) ?></h3>


                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600"><?= nl2br(htmlspecialchars($event['Description'])) ?></p>

                                    <dl class="mt-4 space-y-3 border-t border-gray-100 pt-4 text-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <dt class="text-gray-500">Date</dt>
                                            <dd class="text-right font-medium text-gray-900"><?= $eventTiming['dateLabel'] ?></dd>
                                        </div>
                                        <div class="flex items-start justify-between gap-4">
                                            <dt class="text-gray-500">Time</dt>
                                            <dd class="text-right font-medium text-gray-900"><?= $eventTiming['timeLabel'] ?></dd>
                                        </div>
                                    </dl>

                                    <div class="mt-5">
                                        <a href="<?= url('/staff/events/' . $event['Id']) ?>" class="inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                            Manage event
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($eventsData['passed'])): ?>
                <section class="overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm" x-data="{ open: false }">
                    <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-4 px-4 py-4 text-left sm:px-5" :aria-expanded="open.toString()" aria-controls="passed-events-panel">
                        <div>
                            <h2 class="text-lg font-semibold tracking-tight text-gray-900">Passed Events</h2>
                            <p class="text-sm text-gray-500">Archived events kept for reference.</p>
                        </div>

                        <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4" />
                        </svg>


                    </button>

                    <div id="passed-events-panel" x-show="open" x-collapse x-cloak class="border-t border-gray-100 p-4 sm:p-5">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                            <?php foreach ($eventsData['passed'] as $event): ?>
                                <?php $eventTiming = $formatEventTiming($event); ?>
                                <article class="flex h-full flex-col overflow-hidden rounded-lg border border-gray-100 bg-gray-50">
                                    <div class="p-4 sm:p-5">
                                        <h3 class="text-lg font-semibold tracking-tight text-gray-900"><?= htmlspecialchars($event['Name']) ?></h3>
                                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600"><?= nl2br(htmlspecialchars($event['Description'])) ?></p>
                                        <dl class="mt-4 space-y-3 border-t border-gray-200 pt-4 text-sm">
                                            <div class="flex items-start justify-between gap-4">
                                                <dt class="text-gray-500">Date</dt>
                                                <dd class="text-right font-medium text-gray-900"><?= $eventTiming['dateLabel'] ?></dd>
                                            </div>
                                            <div class="flex items-start justify-between gap-4">
                                                <dt class="text-gray-500">Time</dt>
                                                <dd class="text-right font-medium text-gray-900"><?= $eventTiming['timeLabel'] ?></dd>
                                            </div>
                                        </dl>

                                        <div class="mt-5">
                                            <a href="<?= url('/staff/events/' . $event['Id']) ?>" class="inline-flex w-full items-center justify-center rounded-md bg-gray-700 px-3 py-2 text-sm font-medium text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                                View event
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="rounded-lg border border-gray-100 bg-white p-6 text-center shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">No events found</h2>
            <p class="mt-2 text-sm text-gray-500">Create an event to populate this dashboard section.</p>
        </div>
    <?php endif; ?>
</section>