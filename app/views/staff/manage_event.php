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
$priceTiers = json_decode($eventData['Price'], true);
$priceTiers = is_array($priceTiers) ? $priceTiers : [];
?>

<section class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between md:flex-col md:items-start lg:flex-row">
        <div class="space-y-2">
            <div class="space-y-1">
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl"><?= htmlspecialchars($eventData['Name']) ?></h1>
                <p class="text-sm text-gray-500">Review the event details, schedule, and location.</p>
            </div>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row md:flex-col md:w-full lg:flex-row lg:w-fit" x-data="{
            copyText: '<?= \App\Config\Settings::APP_URL ?>events/<?= $id ?>/',
            copyNotification: false,
            copyToClipboard() {
                navigator.clipboard.writeText(this.copyText);
                this.copyNotification = true;
                let that = this;
                setTimeout(function(){
                    that.copyNotification = false;
                }, 3000);
            }
        }">
            <?php if ($eventData['EndsAt'] > date('Y-m-d H:i:s')): ?>
                <button @click="copyToClipboard();" class="inline-flex whitespace-nowrap items-center justify-center rounded-md border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 group">
                    <svg x-show="!copyNotification" class="size-5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z" />
                    </svg>
                    <span x-show="!copyNotification">Copy Event Link</span>
                    <svg x-show="copyNotification" class="size-5 text-green-700 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                    </svg>

                    <span x-show="copyNotification" class="text-green-700" x-cloak>Copied to Clipboard</span>
                </button>
            <?php endif; ?>

            <a href="<?= url("/staff/events/{$id}/edit") ?>" class="inline-flex whitespace-nowrap items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                Event Settings
            </a>
        </div>
    </div>
    <?php if ($eventData['EndsAt'] < date('Y-m-d H:i:s')): ?>
        <div class="p-4 mb-4 text-sm text-gray-700 rounded-md bg-gray-100 flex items-center gap-2">
            <svg class="size-6 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <p class="inline"><span class="font-semibold">Warning:</span> This event has already ended. You can still view the event details.</p>
        </div>
    <?php endif; ?>

    <div class="p-4 mb-4 text-sm text-indigo-700 rounded-md bg-indigo-50 flex items-center gap-2">
        <svg class="size-6 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        <p class="inline"><span class="font-semibold">Info:</span> This event does not allow people to make bookings. You can change this in the event settings.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1.35fr)_minmax(280px,0.65fr)]">
        <div class="space-y-6">
            <section class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm sm:p-5">

                <div class="flex flex-row items-center justify-between">
                    <div>
                        <h2 class=" font-medium text-lg text-gray-800">Schedule</h2>
                        <p class="mt-1 text-sm text-gray-500">Key timing details for this event.</p>
                    </div>
                    <?php if ($eventData['EndsAt'] > date('Y-m-d H:i:s') && $eventData['StartsAt'] < date('Y-m-d H:i:s')): ?>
                        <span class="inline-flex items-center whitespace-nowrap rounded px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800">In Progress</span>
                    <?php endif; ?>
                </div>


                <div class="mt-5 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                        <p class="text-sm font-medium text-gray-500">Starts</p>
                        <p class="mt-2 text-base font-semibold text-gray-900"><?= date('F j, Y', $starts) ?></p>
                        <p class="text-sm text-gray-600"><?= date('g:i A', $starts) ?></p>
                    </div>
                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                        <p class="text-sm font-medium text-gray-500">Ends</p>
                        <p class="mt-2 text-base font-semibold text-gray-900"><?= date('F j, Y', $ends) ?></p>
                        <p class="text-sm text-gray-600"><?= date('g:i A', $ends) ?></p>
                    </div>
                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                        <p class="text-sm font-medium text-gray-500">Duration</p>
                        <p class="mt-2 text-base font-semibold text-gray-900"><?= $duration ?></p>
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
                <h2 class=" font-medium text-lg text-gray-800">Description</h2>
                <p class=" mt-3 text-base leading-7 text-gray-600"><?= htmlspecialchars($eventData['Description']) ?></p>
            </section>
        </div>

        <aside class="space-y-6">
            <section class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
                <h2 class=" font-medium text-lg text-gray-800">Location</h2>
                <p class="mt-3 text-base leading-7 text-gray-600"><?= htmlspecialchars($eventData['Location']) ?></p>
            </section>

            <section class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class=" font-medium text-lg text-gray-800">Pricing</h2>
                        <p class="mt-1 text-sm text-gray-500">Ticket tiers and their current rates.</p>
                    </div>
                </div>

                <?php if (!empty($priceTiers)): ?>
                    <div class="mt-4 space-y-3">
                        <?php foreach ($priceTiers as $tier => $price): ?>
                            <div class="flex items-center justify-between gap-4 rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                                <p class="text-sm capitalize font-medium text-gray-900"><?= htmlspecialchars($tier) ?></p>
                                <div>
                                    <p class="text-base font-semibold tabular-nums text-gray-900">$<?= number_format((float) $price, 2) ?></p>
                                    <p class="text-xs text-gray-500">Per ticket</p>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="mt-4 rounded-lg border border-dashed border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-500">
                        No pricing has been configured.
                    </div>
                <?php endif; ?>
            </section>
        </aside>
    </div>
</section>