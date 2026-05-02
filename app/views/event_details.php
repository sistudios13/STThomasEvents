<?php

$prices = json_decode($eventData['price'], true);

?>

<section class="grid grid-cols-1 md:grid-cols-2 gap-12">
    <div>
        <div class="pb-10 items-center gap-10">
            <h1 class=" text-4xl md:text-5xl font-semibold text-pretty mb-4"><?= htmlspecialchars($eventData['name']) ?></h1>
            <p class="text-xl text-gray-700 text-pretty"><?= date('F j, Y \a\t g:i A', strtotime($eventData['date'])) ?></p>
        
        </div>
        <div class=" max-w-3xl mx-auto">
            <p class="text-lg text-gray-700"><?= nl2br(htmlspecialchars($eventData['description'])) ?></p>
        </div>
        <div class="flex items-center gap-3 pt-8">
            <a href="<?= url('/events') ?>" class=" inline-flex items-center gap-2 font-semibold text-emerald-700 transition hover:text-emerald-900">
                ← Back to Events
            </a><a href="<?= url('/events/' . $eventData['id'] . '/seats') ?>" class=" inline-flex items-center gap-2 font-semibold text-white bg-emerald-700 px-4 py-2 rounded-lg transition hover:bg-emerald-900">
                Book Tickets
            </a>
            
        </div>
        
    </div>
    <div class="p-8 shadow-sm border border-slate-200 bg-white rounded-3xl">
        <h2 class="text-2xl font-semibold mb-4">More Info</h2>
        <div class="flex flex-col">
            <h3 class="text-xl font-medium mb-4">Pricing</h3>
            <p class="text-base text-gray-700 mb-2"><b><?php foreach ($prices as $key => $price): ?><?= htmlspecialchars($key) ?>:</b> $<?= htmlspecialchars($price) ?><?php endforeach; ?></p>
            <p class="text-sm text-gray-500 mb-2">* Payments will take place at the door. Cash only</p>
        </div>
        <hr>
        <div class="flex flex-col">
            <h3 class="text-xl font-medium mt-4 mb-4">Location</h3>
            <p class="text-base text-gray-700 mb-2">St. Thomas High School Auditorium (111 Broadview Ave)</p>
        </div>
    </div>
</section>