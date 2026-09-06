<?php
$invites = array_filter($invites ?? [], function ($invite) {
    return !$invite['UsedAt'];
});
$now = new DateTime();


?>

<div class="max-w-6xl">
    <div class="mb-8">
        <h1 class="mb-2 text-3xl font-bold text-gray-900">Staff Management</h1>
        <p class="text-gray-600">Invite new team members and keep track of staff portal access.</p>
    </div>

    <section x-data="{ name : '', email : '' }" class="rounded-lg border border-gray-100 bg-white p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Invite a staff member</h2>
            <p class="mt-1 text-sm text-gray-600">Send an invitation to a new staff member to join the portal.</p>
        </div>

        <form hx-post="<?= url('/staff/invite/send/') ?>" hx-swap="none" @htmx:after-request="if ($event.detail.xhr.status === 200) {name=''; email='' ;} " class=" space-y-6">
            <?= csrf_input() ?>

            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-gray-700">
                    Full Name <span class="text-red-600">*</span>
                </label>
                <input x-model="name" type="text" id="name" name="name" required placeholder="e.g., John Smith" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                    Email Address <span class="text-red-600">*</span>
                </label>
                <input x-model="email" type="email" id="email" name="email" required placeholder="e.g., john@example.com" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="rounded-md border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600">
                <p><strong>What happens next:</strong></p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li>An email will be sent to the staff member</li>
                    <li>They'll have 7 days to complete their registration</li>
                    <li>They can set their password and access the portal</li>
                </ul>
            </div>

            <button type="submit" class="w-full rounded-md bg-indigo-600 py-2 font-medium text-white transition hover:bg-indigo-700">
                Send Invite
            </button>
        </form>
    </section>


    <section class="mt-6 rounded-lg border border-gray-100 bg-white p-4">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Outgoing invites</h2>
            <p class="mt-1 text-sm text-gray-500">Recent invitations and their registration status.</p>
        </div>

        <?php if (!$invites): ?>
            <p class="rounded-md bg-gray-50 px-3 py-4 text-sm text-gray-500">No invitations have been sent yet.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[38rem] text-left text-sm">
                    <thead class="border-b border-gray-200 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th scope="col" class="px-3 py-3 font-medium">Recipient</th>
                            <th scope="col" class="px-3 py-3 font-medium">Sent</th>
                            <th scope="col" class="px-3 py-3 font-medium">Expires</th>
                            <th scope="col" class="px-3 py-3 font-medium">Status</th>
                            <th scope="col" class="px-3 py-3 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <?php foreach ($invites as $invite): ?>

                            <?php
                            $status = $invite['UsedAt']
                                ? 'Accepted'
                                : (new DateTime($invite['ExpiresAt']) < $now ? 'Expired' : 'Pending');
                            $statusClass = match ($status) {
                                'Accepted' => 'bg-green-50 text-green-700',
                                'Expired' => 'bg-gray-100 text-gray-600',
                                default => 'bg-indigo-50 text-indigo-700',
                            };
                            ?>
                            <tr>
                                <td class="px-3 py-3">
                                    <div class="font-medium text-gray-900"><?= htmlspecialchars($invite['Name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= htmlspecialchars($invite['Email']) ?></div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-gray-500"><?= date('Y-m-d g:iA', strtotime($invite['CreatedAt'])) ?></td>
                                <td class="whitespace-nowrap px-3 py-3 text-gray-500"><?= date('Y-m-d g:iA', strtotime($invite['ExpiresAt'])) ?></td>
                                <td class="px-3 py-3"><span class="inline-flex rounded-md px-2 py-1 text-xs font-medium <?= $statusClass ?>"><?= $status ?></span></td>
                                <td class="px-3 py-3">
                                    <button hx-delete="<?= url('/staff/invites/' . $invite['Id'] . '/') ?>" type="button" class="text-sm font-medium text-red-600 hover:text-red-800 focus:outline-hidden focus-visible:underline">Delete</button>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</div>