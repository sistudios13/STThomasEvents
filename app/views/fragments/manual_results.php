<div class="space-y-6">

    <!-- Ticketholder info card -->
    <div class="rounded-lg border border-gray-100 bg-white p-4">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div class="space-y-1">
                <p class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($booking['session']['Name']) ?></p>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($booking['session']['Email']) ?></p>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($booking['session']['Phone']) ?></p>
            </div>
            <div class="flex flex-col items-start gap-2 sm:items-end">
                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700">
                    <?= htmlspecialchars($booking['session']['Role']) ?>
                </span>
                <p class="text-xs text-gray-400">Booked <?= date( 'M j, Y \a\t g:i A',strtotime($booking['session']['Timestamp'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Seats -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-medium text-gray-700">Seats (<?= count($booking['bookings']) ?>)</h2>

        </div>

        <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-6">
            <?php foreach ($booking['bookings'] as $bookingItem): ?>
                <div class="flex flex-col items-center gap-2 rounded-lg border p-4 <?= $bookingItem['CheckedIn'] ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50'?>">
                    <span class="text-2xl font-bold text-gray-600"><?= htmlspecialchars($bookingItem['Seat']) ?></span>
                    <?php if ($bookingItem['CheckedIn']): ?>
                        <span class="text-xs font-medium text-green-600">Checked in</span>
                    <?php else: ?>
                    <button type="button" hx-post="<?= url('staff/check-in/' . $id . '/manual/' . 'one/') ?>" hx-vals="js:{'_csrf': '<?= csrf_token() ?>', session_id: '<?= $booking['session']['Id'] ?>', booking_id: '<?= $bookingItem['Id'] ?>'}" hx-target="closest div" hx-swap="outerHTML" class="rounded-md bg-indigo-600 px-2 py-1 text-xs font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                        Check In
                    </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>