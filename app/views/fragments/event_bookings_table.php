<div class="mt-5 rounded-lg border border-gray-100">
    <div class="overflow-x-scroll">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                        <?php $nextSortOrder = ($sortKey == 'id' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>
                        <button type="button" <?= count($bookings) <= 1 ? 'disabled' : '' ?> class="flex disabled:text-gray-400 disabled:cursor-not-allowed items-center gap-1 text-left" hx-get="<?= url("/staff/events/{$id}/bookings/?page=1&search={$search}&sort=id&order={$nextSortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML">
                            <span>ID</span>
                            <?php if ($sortKey == 'id'): ?>
                                <?php if ($sortOrder == 'asc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                    </svg>

                                <?php elseif ($sortOrder == 'desc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                    </svg>

                                <?php endif; ?>
                            <?php else: ?>
                                <svg class="size-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                </svg>

                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                        <?php $nextSortOrder = ($sortKey == 'name' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>
                        <button type="button" <?= count($bookings) <= 1 ? 'disabled' : '' ?> class="flex disabled:text-gray-400 disabled:cursor-not-allowed  items-center gap-1 text-left" hx-get="<?= url("/staff/events/{$id}/bookings/?page=1&search={$search}&sort=name&order={$nextSortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML">
                            <span>Name</span>
                            <?php if ($sortKey == 'name'): ?>
                                <?php if ($sortOrder == 'asc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                    </svg>

                                <?php elseif ($sortOrder == 'desc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                    </svg>

                                <?php endif; ?>
                            <?php else: ?>
                                <svg class="size-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                </svg>

                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                        <?php $nextSortOrder = ($sortKey == 'email' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>
                        <button type="button" <?= count($bookings) <= 1 ? 'disabled' : '' ?> class="flex disabled:text-gray-400 disabled:cursor-not-allowed items-center gap-1 text-left" hx-get="<?= url("/staff/events/{$id}/bookings/?page=1&search={$search}&sort=email&order={$nextSortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML">
                            <span>Email</span>
                            <?php if ($sortKey == 'email'): ?>
                                <?php if ($sortOrder == 'asc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                    </svg>

                                <?php elseif ($sortOrder == 'desc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                    </svg>

                                <?php endif; ?>
                            <?php else: ?>
                                <svg class="size-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                </svg>

                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                        <?php $nextSortOrder = ($sortKey == 'status' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>
                        <button type="button" <?= count($bookings) <= 1 ? 'disabled' : '' ?> class="flex disabled:text-gray-400 disabled:cursor-not-allowed items-center gap-1 text-left" hx-get="<?= url("/staff/events/{$id}/bookings/?page=1&search={$search}&sort=status&order={$nextSortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML">
                            <span>Status</span>
                            <?php if ($sortKey == 'status'): ?>
                                <?php if ($sortOrder == 'asc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                    </svg>

                                <?php elseif ($sortOrder == 'desc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                    </svg>

                                <?php endif; ?>
                            <?php else: ?>
                                <svg class="size-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                </svg>

                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                        <?php $nextSortOrder = ($sortKey == 'timestamp' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>
                        <button type="button" <?= count($bookings) <= 1 ? 'disabled' : '' ?> class="flex disabled:text-gray-400 disabled:cursor-not-allowed items-center gap-1 text-left" hx-get="<?= url("/staff/events/{$id}/bookings/?page=1&search={$search}&sort=timestamp&order={$nextSortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML">
                            <span>Timestamp</span>
                            <?php if ($sortKey == 'timestamp'): ?>
                                <?php if ($sortOrder == 'asc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4" />
                                    </svg>

                                <?php elseif ($sortOrder == 'desc'): ?>
                                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                    </svg>

                                <?php endif; ?>
                            <?php else: ?>
                                <svg class="size-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
                                </svg>

                            <?php endif; ?>
                        </button>
                    </th>
                    <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 0 bg-white">
                <?php foreach ($bookings as $booking): ?>
                    <tr class="align-top even:bg-gray-50 even:bg-opacity-50 ">
                        <td class="whitespace-nowrap px-3 py-3 text-sm font-medium text-gray-900"><?= $booking['Id'] ?></td>
                        <td class="px-3 py-3 text-sm text-gray-700 text-wrap max-w-56 whitespace-nowrap break-words h-[64.5px]"><?= htmlspecialchars($booking['Name']) ?></td>
                        <td class="px-3 py-3 text-sm  max-w-56 whitespace-nowrap line-clamp-1"><a href="mailto:<?= htmlspecialchars($booking['Email']) ?>" class="text-blue-700 hover:underline"><?= htmlspecialchars($booking['Email']) ?></a></td>
                        <td class="whitespace-nowrap px-3 py-3 h-full align-middle text-sm">
                            <span class="inline-flex items-center rounded bg-gray-100 px-2.5 py-1 text-xs font-medium <?= $booking['EmailVerified'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>"><?= $booking['EmailVerified'] ? 'Confirmed' : 'Pending' ?></span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 text-sm text-gray-700"><?= date('o-n-j g:ia', strtotime($booking['Timestamp'])) ?></td>
                        <td class="whitespace-nowrap px-3 py-3 text-sm w-min">
                            <div class="flex flex-wrap justify-center gap-2">
                                <button type="button" @click='showModal = true; modalData = {id: <?= $booking['Id'] ?>, name: "<?= htmlspecialchars($booking['Name']) ?>", email: "<?= htmlspecialchars($booking['Email']) ?>", phone: "<?= $booking['Phone'] ?>", role: "<?= $booking['Role'] ?>", reference: "<?= $booking['Reference'] ?>", emailVerified: <?= $booking['EmailVerified'] ? 'true' : 'false' ?>, seats: <?= json_encode($booking['seats']) ?>, timestamp: "<?= date('o-n-j g:ia', strtotime($booking['Timestamp'])) ?>"}' class="rounded-md border border-gray-200 px-2.5 py-1.5 font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4" />
                                    </svg>

                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($bookings) < 1): ?>
                    <tr>
                        <td colspan="7" class="px-3 py-8 text-center text-sm text-gray-500">No bookings match that search.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<nav aria-label="Pagination" class="mt-4 flex flex-col items-center justify-between gap-3 sm:flex-row">
    <!-- Status Text -->
    <p class="text-sm text-gray-500">
        Showing <span class="font-medium"><?php echo count($bookings); ?></span> of
        <span class="font-medium"><?= $info['total_rows'] ?></span> bookings
    </p>

    <!-- Pagination Controls -->
    <div class="flex flex-wrap items-center justify-center gap-2">
        <?php $prevPage = $currentPage - 1; ?>
        <button type="button" hx-get="<?= url("/staff/events/{$id}/bookings/?page={$prevPage}&search={$search}&sort={$sortKey}&order={$sortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML" <?= $currentPage == 1 ? 'disabled aria-disabled="true"' : '' ?> class="<?= $currentPage == 1 ? 'cursor-not-allowed border-gray-200 text-gray-400' : 'border-gray-200 text-gray-700 hover:bg-gray-50' ?> rounded-md border px-2 py-2.5 text-sm font-medium" aria-label="Previous Page"><svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
            </svg>
        </button>

        <!-- Desktop Page Numbers (Hidden on Mobile) -->
        <div class="hidden md:flex flex-wrap items-center justify-center gap-1">
            <?php
            // Calculate sliding window range
            $startPage = max(1, $currentPage - 2);
            $endPage = min($info['total_pages'], $currentPage + 2);

            // Adjust range if near start or end
            if ($currentPage - 2 < 1) {
                $endPage = min($info['total_pages'], $endPage + (1 - ($currentPage - 2)));
            }
            if ($currentPage + 2 > $info['total_pages']) {
                $startPage = max(1, $startPage - (($currentPage + 2) - $info['total_pages']));
            }

            // Render Start Ellipsis
            if ($startPage > 1)
                echo '<span class="px-3 py-2 text-sm font-medium text-gray-700">...</span>';

            for ($page = $startPage; $page <= $endPage; $page++):
                ?>
                <button type="button" hx-get="<?= url("/staff/events/{$id}/bookings/?page={$page}&search={$search}&sort={$sortKey}&order={$sortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML" class="rounded-md border px-3 py-2 text-sm font-medium <?= $page == $currentPage ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-200 text-gray-700 hover:bg-gray-50' ?>" aria-current="<?= $page == $currentPage ? 'page' : 'false' ?>" aria-label="Page <?= $page ?>"><?= $page ?></button>
            <?php endfor; ?>

            <!-- Render End Ellipsis -->
            <?php if ($endPage < $info['total_pages'])
                echo '<span class="px-3 py-2 text-sm font-medium text-gray-700">...</span>'; ?>
        </div>

        <!-- Mobile Page Numbers (Hidden on Desktop) -->
        <div class="flex md:hidden flex-wrap items-center justify-center gap-2">
            <span class="px-3 py-2 text-sm font-medium text-gray-700">Page <?= $currentPage ?> of <?= $info['total_pages'] ?></span>
        </div>
        <?php $nextPage = $currentPage + 1; ?>
        <button type="button" hx-get="<?= url("/staff/events/{$id}/bookings/?page={$nextPage}&search={$search}&sort={$sortKey}&order={$sortOrder}") ?>" hx-trigger="click" hx-target="#target-container" hx-swap="innerHTML" <?= $currentPage == $info['total_pages'] ? 'disabled aria-disabled="true"' : '' ?> class="<?= $currentPage == $info['total_pages'] ? 'cursor-not-allowed border-gray-200 text-gray-400' : 'border-gray-200 text-gray-700 hover:bg-gray-50' ?> rounded-md border px-2 py-2.5 text-sm font-medium" aria-label="Next Page"><svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
            </svg>
        </button>
    </div>
</nav>
<!-- modal -->
<div x-cloak x-show="showModal" class="fixed inset-0 z-[40] flex h-[100dvh] w-screen items-start justify-center overflow-y-auto p-4 pt-6 text-gray-900 sm:items-center sm:pt-4">
    <div x-show="showModal" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showModal=false" class="fixed inset-0 h-[100lvh] w-screen bg-white/70 backdrop-blur-sm"></div>
    <div x-show="showModal" x-trap.inert.noscroll="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative z-10 mx-auto my-4 w-full max-w-lg overflow-y-auto rounded-lg border border-gray-100 bg-white px-7 py-6 shadow-lg">
        <div class="flex items-center justify-between pb-3">
            <h3 class="mr-6 text-lg font-semibold">Booking Details</h3>
            <button @click="showModal=false" class="flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="w-auto space-y-4 pb-4 font-normal text-gray-700">
            <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                <p class="text-sm font-medium text-gray-500">Booking</p>
                <p class="mt-1 text-lg font-semibold text-gray-900" x-text="modalData?.name || '—'"></p>
                <a :href="'mailto:' + modalData.email" class="mt-1 text-sm  hover:underline text-blue-700" x-text="modalData.email || '—'"></a>
            </div>

            <dl class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-md border border-gray-100 p-3">
                    <dt class="text-sm font-medium text-gray-500">Tickets Reference #</dt>
                    <dd class="mt-1 text-sm text-gray-900" x-text="modalData.reference || '—'"></dd>
                </div>
                <div class="rounded-md border border-gray-100 p-3">
                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                    <dd class="mt-1 text-sm text-gray-900" x-text="modalData.phone || '—'"></dd>
                </div>
                <div class="rounded-md border border-gray-100 p-3">
                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900" x-text="modalData.role || '—'"></dd>
                </div>
                <div class="rounded-md border border-gray-100 p-3">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex items-center rounded px-2.5 py-1 text-xs font-medium" x-bind:class="modalData.emailVerified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'" x-text="modalData.emailVerified ? 'Confirmed' : 'Pending'"></span>
                    </dd>
                </div>
                <div class="rounded-md border border-gray-100 p-3">
                    <dt class="text-sm font-medium text-gray-500">Seats</dt>
                    <dd class="mt-1 text-sm text-gray-900 flex flex-wrap gap-1">
                        <template x-for="seat in modalData.seats" :key="seat">
                            <span class="inline-flex items-center rounded bg-gray-100 px-2.5 py-1 text-xs font-medium" x-text="seat"></span>
                        </template>
                    </dd>
                </div>
                <div class="rounded-md border border-gray-100 p-3">
                    <dt class="text-sm font-medium text-gray-500">Timestamp</dt>
                    <dd class="mt-1 text-sm text-gray-900" x-text="modalData.timestamp || '—'"></dd>
                </div>
            </dl>
        </div>
        <div class="flex justify-between pt-4">
            <button <?= $eventData['EndsAt'] < date('Y-m-d H:i:s') ? 'disabled' : '' ?> @click="showDeleteModal=true; showModal=false" class="rounded-md bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">Delete</button>

            <button @click="showModal=false" class="rounded-md border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">Close</button>

        </div>
    </div>
</div>

<!-- delete confirmation modal -->
<div x-cloak x-show="showDeleteModal" class="fixed inset-0 z-[40] flex h-[100dvh] w-screen items-center justify-center overflow-y-auto p-4 pt-6 text-gray-900 sm:items-center sm:pt-4">
    <div x-show="showDeleteModal" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showModal=false" class="fixed inset-0 h-[100lvh] w-screen bg-white/70 backdrop-blur-sm"></div>
    <div x-show="showDeleteModal" @click.away="showDeleteModal=false; showModal=true" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative z-10 mx-auto my-4 w-full max-w-lg overflow-y-auto rounded-lg border border-gray-100 bg-white px-7 py-6 shadow-lg">
        <div class="flex items-center justify-between pb-3">
            <h3 class="mr-6 text-lg font-semibold">Are you sure you want to delete this booking?</h3>
            <button @click="showDeleteModal=false; showModal = true" class="flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="w-auto pb-8 font-normal text-gray-700">
            <p>Are you sure you want to cancel this booking? <br> <span class="font-semibold" x-text="modalData.name"></span> (<span class="font-semibold" x-text="modalData.email"></span>) will be notified by email. This is irreversible!</p>
        </div>

        <div class="flex justify-between pt-4">
            <button class="rounded-md bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2" @click="
        htmx.ajax(
            'DELETE',
            '<?= url("/staff/events/{$id}/bookings/") ?>' +
                modalData.id +
                '/?page=<?= $currentPage ?>&search=<?= urlencode($search ?? '') ?>&sort=<?= urlencode($sortKey ?? '') ?>&order=<?= urlencode($sortOrder ?? '') ?>',
            {
                target: '#target-container',
                swap: 'innerHTML'
            }
        ); showDeleteModal=false; showModal=false;
    ">Delete</button>

            <button @click="showDeleteModal=false; showModal=true" class="rounded-md border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">Close</button>

        </div>
    </div>
</div>