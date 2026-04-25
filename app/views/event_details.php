<?php

$prices = json_decode($eventData['price'], true);

?>

<section class="py-12 grid grid-cols-1 md:grid-cols-2 gap-12">
    <div>
        <div class="pb-10 items-center gap-10">
            <h1 class=" text-4xl md:text-5xl font-semibold text-pretty mb-4"><?= htmlspecialchars($eventData['name']) ?></h1>
            <p class="text-xl text-gray-700 text-pretty"><?= date('F j, Y \a\t g:i A', strtotime($eventData['date'])) ?></p>
        
        </div>
        <div class=" max-w-3xl mx-auto">
            <p class="text-lg text-gray-700"><?= nl2br(htmlspecialchars($eventData['description'])) ?></p>
        </div>
    </div>
    <div class="p-8 shadow-sm bg-white">
        <h2 class="text-2xl font-semibold mb-4">Pricing</h2>
        <p class="text-lg text-gray-700 mb-6"><?php foreach ($prices as $key => $price): ?><?= htmlspecialchars($key) ?>: $<?= htmlspecialchars($price) ?><?php endforeach; ?></p>
    </div>
</section>