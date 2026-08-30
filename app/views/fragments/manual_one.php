<div class="flex flex-col items-center gap-2 rounded-lg border p-4 <?= $checkin['CheckedIn'] ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' ?>">
    <span class="text-2xl font-bold text-gray-600"><?= htmlspecialchars($checkin['Seat']) ?></span>
    <?php if ($checkin['CheckedIn']): ?>
        <span class="text-xs font-medium text-green-600">Checked in</span>
    <?php else: ?>
        <button type="button" hx-post="<?= url('staff/check-in/' . $id . '/manual/' . 'one/') ?>" hx-vals="js:{'_csrf': '<?= csrf_token() ?>', session_id: '<?= $booking['session']['Id'] ?>', booking_id: '<?= $bookingItem['Id'] ?>'}" hx-target="closest div" hx-swap="outerHTML" class="rounded-md bg-indigo-600 px-2 py-1 text-xs font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
            Check In
        </button>
    <?php endif; ?>
</div>