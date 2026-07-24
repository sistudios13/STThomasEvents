<section class="py-12 items-center text-center gap-10">
    <div>
        <h1 class=" text-4xl md:text-5xl font-semibold text-pretty mb-4">Browse All Events</h1>
        <p class="text-xl text-gray-700 text-pretty">See all the upcoming events at St. Thomas High School</p>

    </div>
</section>
<section class="pt-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (!empty($eventsData)): ?>
            <?php foreach ($eventsData as $event): ?>
                <div class="group overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm transition duration-300 ">
                    <div class="p-6">
                        <div class="mb-5 flex items-center justify-between gap-2 text-sm text-slate-500">
                            <span class="inline-flex items-center gap-2 rounded-lg bg-green-100 px-3 py-1 font-medium text-green-700">
                                <?= date('F j, Y \a\t g:i A', strtotime($event['StartsAt'])) ?>
                            </span>
                        </div>
                        <h2 class="text-2xl font-semibold tracking-tight text-gray-900 mb-3"><?= htmlspecialchars($event['Name']) ?></h2>
                        <p class="text-gray-700 mb-6 line-clamp-3"><?= nl2br(htmlspecialchars($event['Description'])) ?></p>
                        <a href="<?= url('/events/' . $event['Id']) ?>" class="inline-flex items-center gap-2 font-semibold text-green-700 transition hover:text-green-800">
                            View Details
                            <span aria-hidden="true"><svg class="w-5 h-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                </svg></span>
                        </a>
                    </div>
                </div>
                <!-- <div class="group overflow-hidden rounded-lg border border-gray-100 bg-white shadow-sm transition duration-300">
                    <?php
                    // Image handling: use event Image if present, otherwise a placeholder
                    $imgSrc = !empty($event['Image']) ? htmlspecialchars($event['Image']) : url('/assets/img1.webp');
                    ?>
                    <div class="relative p-2">
                        <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($event['Name']) ?>" class="w-full rounded-md h-48 object-cover">
                        <div class="absolute left-3 top-3 inline-flex items-center gap-2 rounded-lg bg-green-100 px-3 py-1 font-medium text-green-700 text-sm">
                            <?= date('F j, Y \a\t g:i A', strtotime($event['Date'])) ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold tracking-tight text-gray-900 mb-2"><?= htmlspecialchars($event['Name']) ?></h2>
                        <p class="text-gray-700 mb-6 line-clamp-3"><?= nl2br(htmlspecialchars($event['Description'])) ?></p>
                        <a href="<?= url('/events/' . $event['Id']) ?>" class="inline-flex items-center gap-2 font-semibold text-green-700 transition hover:text-green-800">
                            View Details
                            <span aria-hidden="true"><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                            </svg></span>
                        </a>
                    </div>
                </div> -->
            <?php endforeach; ?>

        <?php else: ?>
            <p class="text-gray-700 text-center text-xl col-span-full">No events found.</p>
        <?php endif; ?>
    </div>

</section>