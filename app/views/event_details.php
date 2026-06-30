<?php

$prices = json_decode($eventData['Price'], true);

?>



<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12 ">
    <div class="">
        <a href="<?= url('/events') ?>" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-medium mb-6">
            <svg class="w-5 h-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
</svg>
 Back to Events
        </a>
        <h1 class="text-5xl font-bold text-gray-900 mb-3"><?= htmlspecialchars($eventData['Name']) ?></h1>
        <p class="text-lg text-gray-700 mb-6"><?= date('F j, Y \a\t g:i A', strtotime($eventData['Date'])) ?></p>

        <div class=" max-w-none">
            <p class="text-lg text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($eventData['Description'])) ?></p>
        </div>
        <?php if ($eventData['Seating']) : ?>
        <a href="<?= url('/events/' . $eventData['Id'] . '/seats') ?>" class="inline-block mt-6 px-6 py-3 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
            Book Tickets
        </a>
        <?php endif; ?>
    </div>

    <!-- Info Card -->
    <div>
        <div class="bg-white border border-gray-100 rounded-lg p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Event Info</h2>

            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Pricing</h3>
                <div class="space-y-2">
                    <?php foreach ($prices as $type => $price): ?>
                        <div class="flex justify-between text-gray-700">
                            <span><?= htmlspecialchars($type) ?></span>
                            <span class="font-medium">$<?= htmlspecialchars($price) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-xs text-gray-500 mt-4">* Cash only at the door</p>
            </div>

            <hr class="my-6">

            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Location</h3>
                <p class="text-gray-700">St. Thomas High School<br>Auditorium<br>111 Broadview Ave</p>
            </div>
        </div>
    </div>
</div>