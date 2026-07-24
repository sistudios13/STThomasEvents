<?php

$prices = json_decode($eventData['Price'], true);

?>



<div class="grid grid-cols-1 lg:grid-cols-2 items-start gap-12">
    <div>
        <a href="<?= url('/events') ?>" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-medium mb-6">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
            </svg>
            Back to Events
        </a>

        <h1 class="text-5xl font-bold text-gray-900 mb-6"><?= htmlspecialchars($eventData['Name']) ?></h1>

        <div class="max-w-none">
            <p class="text-lg text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($eventData['Description'])) ?></p>
        </div>

        <?php if ($eventData['Seating']): ?>
            <a href="<?= url('/events/' . $eventData['Id'] . '/seats') ?>" class="inline-block mt-8 <?= $eventData['StartsAt'] > new DateTime ? 'hover:bg-green-700' : 'opacity-50 cursor-not-allowed pointer-events-none' ?> shadow-sm px-6 py-3 bg-green-600 text-white font-semibold rounded  transition">
                Book Tickets
            </a>
            <?= $eventData['StartsAt'] > new DateTime ? '' : '<p class="text-sm text-gray-500 mt-2">*The event is in progress. Booking is unavailable</p>' ?>
        <?php endif; ?>
    </div>

    <!-- Info Card -->
    <div class="bg-white border border-gray-100 rounded-lg p-6 shadow-sm">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Event Info</h2>

        <?php
        $starts = strtotime($eventData['StartsAt']);
        $ends = strtotime($eventData['EndsAt']);

        // Build a duration string
        $diffMinutes = max(0, round(($ends - $starts) / 60));
        $hours = intdiv($diffMinutes, 60);
        $minutes = $diffMinutes % 60;
        $durationParts = [];
        if ($hours > 0)
            $durationParts[] = $hours . ' hr' . ($hours > 1 ? 's' : '');
        if ($minutes > 0)
            $durationParts[] = $minutes . ' min';
        $duration = implode(' ', $durationParts) ?: '—';

        // show date for end time if same day
        $sameDay = date('Y-m-d', $starts) === date('Y-m-d', $ends);
        ?>

        <!-- Date & Time -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-1">
                <svg class="size-6 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                </svg>

                Date &amp; Time
            </h3>
            <p class="text-gray-700">
                <?= date('l, F j, Y', $starts) ?>
            </p>
            <p class="text-gray-700">
                <?php if ($sameDay): ?>
                    <?= date('g:i A', $starts) ?> – <?= date('g:i A', $ends) ?>
                <?php else: ?>
                    <?= date('g:i A', $starts) ?> – <?= date('M j, g:i A', $ends) ?>
                <?php endif; ?>
                <span class="text-gray-400">(<?= $duration ?>)</span>
            </p>
        </div>

        <hr class="my-6">

        <!-- Pricing -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-1">
                <svg class="size-6 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                </svg>

                Pricing
            </h3>
            <div class="space-y-2">
                <?php foreach ($prices as $type => $price): ?>
                    <div class="flex justify-between text-gray-700">
                        <span><?= htmlspecialchars($type) ?></span>
                        <span class="font-medium">$<?= htmlspecialchars($price) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="text-sm text-gray-500 mt-4">* Cash only. Pay at the door</p>
        </div>

        <hr class="my-6">

        <!-- Location -->
        <div>
            <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-1">
                <svg class="size-6 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                </svg>

                Location
            </h3>
            <p class="text-gray-700">St. Thomas High School<br>Auditorium<br>111 Broadview Ave</p>
        </div>
    </div>
</div>