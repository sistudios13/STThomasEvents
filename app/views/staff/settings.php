<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Your Settings</h1>
        <div class="flex items-center gap-3">
            <a href="<?= url('/staff/events/new/') ?>" class="inline-flex items-center gap-2 rounded bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">+ Create Event</a>
            <a href="<?= url('/staff/events/') ?>" class="inline-flex items-center gap-2 rounded border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">All Events</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
        <div class="grid grid-cols-1 gap-4 sm:gap-6">
            <!-- Top stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="p-4 bg-white border border-gray-100 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Upcoming events</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900"><?= $stats['upcoming'] ?? '—' ?></div>
                </div>
                <div class="p-4 bg-white border border-gray-100 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Total bookings</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900"><?= $stats['bookings'] ?? '—' ?></div>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <!-- Upcoming events / quick actions -->
                <section class="bg-white rounded-lg border border-gray-100 shadow-sm p-4">
                    <h2 class="text-lg font-medium text-gray-900">Upcoming events</h2>
                    <p class="text-sm text-gray-500 mb-3">Events in the next month</p>
                    <?php if (!empty($upcomingEvents)): ?>
                        <ul class="space-y-2">
                            <?php foreach ($upcomingEvents as $e): ?>
                                <li class="flex items-center justify-between p-2 border border-gray-100 rounded">
                                    <div>
                                        <div class="font-medium text-gray-900"><?= htmlspecialchars($e['title'] ?? $e->getTitle() ?? 'Untitled') ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($e['starts_at'] ?? $e->getStartsAt() ?? '') ?></div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="<?= url('/staff/events/') ?>" class="text-sm text-indigo-600 hover:underline">Manage</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-sm text-gray-500">No upcoming events.</div>
                    <?php endif; ?>
                </section>

            </div>
        </div>
    </div>
</div>