<?php



?>
<div x-data x-init="$dispatch('checked-in', {
        id:   <?= json_encode($checkin['id']) ?>,
        name: '<?= htmlspecialchars($checkin['name']) ?>',
        seat: '<?= htmlspecialchars($checkin['seat']) ?>',
        time: '<?= htmlspecialchars($checkin['time']) ?>',
        undoing: false,
        numberCheckedIn: <?= json_encode($checkin['checked']) ?>,
        numberTotal: <?= json_encode($checkin['total']) ?>,
    })" class="fixed inset-0 z-50 bg-white flex flex-col items-center justify-center text-center p-6">
    <div class="size-20 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
        <svg class="size-10 text-indigo-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
        </svg>
    </div>

    <p class="text-xl text-gray-600">Checked In</p>
    <h2 class="text-3xl font-medium mt-1"><?= htmlspecialchars($checkin['name']) ?></h2>
    <?php if (!empty($checkin['seat'])): ?>
        <p class="text-gray-900 mt-1 font-bold text-6xl"> <?= htmlspecialchars($checkin['seat']) ?></p>
    <?php endif; ?>
    <p class="text-gray-500 text-base mt-1"><?= htmlspecialchars($checkin['time']) ?></p>

    <button
    type="button"
    x-data
    @click="window.resumeScanning()"
    x-init="
        $nextTick(() => {
            $refs.progress.style.width = '100%';
        });
        setTimeout(() => window.resumeScanning(), 2000);
    "
    class="relative mt-10 overflow-hidden bg-indigo-600 text-white rounded-full px-8 py-4 text-lg font-medium"
>
    <span
        x-ref="progress"
        class="absolute inset-y-0 left-0 w-0 bg-indigo-500"
        style="transition: width 2s linear;"
    ></span>

    <span class="relative z-10">
        Scan Next
    </span>
</button>
</div>