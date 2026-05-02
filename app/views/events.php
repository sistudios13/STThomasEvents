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
                <div class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="p-6">
                        <div class="mb-5 flex items-center justify-between gap-2 text-sm text-slate-500">
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 font-medium text-emerald-700">
                                <?= date('F j, Y \a\t g:i A', strtotime($event['date'])) ?>
                            </span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                Upcoming
                            </span>
                        </div>
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-900 mb-3"><?= htmlspecialchars($event['name']) ?></h2>
                        <p class="text-slate-600 mb-6 line-clamp-3"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                        <a href="<?= url('/events/' . $event['id']) ?>" class="inline-flex items-center gap-2 font-semibold text-emerald-700 transition hover:text-emerald-900">
                            View Details
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p class="text-gray-700 text-center text-xl col-span-full">No events found.</p>
        <?php endif; ?>
    </div>

</section>