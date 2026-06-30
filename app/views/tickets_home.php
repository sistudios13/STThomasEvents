<link rel="stylesheet" href="<?= url('styles/addevent.css') ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= url('scripts/addevent.js') ?>" async defer></script>

<!-- AddEvent Settings -->
<script type="text/javascript">
    window.addeventasync = function () {
        addeventatc.settings({
            appleical: { show: true, text: "Apple Calendar" },
            google: { show: true, text: "Google <em>(online)</em>" },
            office365: { show: true, text: "Office 365 <em>(online)</em>" },
            outlook: { show: true, text: "Outlook" },
            outlookcom: { show: true, text: "Outlook.com <em>(online)</em>" },
            yahoo: { show: true, text: "Yahoo <em>(online)</em>" }
        });
    };
</script>
<div class="items-center grid grid-cols-1 lg:grid-cols-2 gap-12 w-full overflow-x-hidden">
    <div class="flex flex-col gap-12">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">My Tickets</h1>
            <p class="text-pretty">Hi, <?= htmlspecialchars($data['Name']) ?>! You can view your seats and tickets below. <br> <b>REMEMBER: Payment takes place at the door. Cash Only!</b> </p>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Event Details</h2>
            <p class="text-gray-600 mb-2"><span class="font-semibold">Event:</span> <?= htmlspecialchars($data['Events.Name']) ?></p>
            <p class="text-gray-600 mb-2"><span class="font-semibold">Date & Time:</span> <?= date('F j, Y \a\t g:i A', strtotime($data['Events.Date'])) ?></p>
            
             <div class="mb-4 w-48">
                <p class="text-gray-600 font-semibold">Pricing:</p>
                 <?php
                 $prices = json_decode($data['Events.Price'], true);
                 foreach ($prices as $type => $price): ?>
                            <div class="flex justify-between text-gray-600">
                                <span><?= htmlspecialchars($type) ?></span>
                                <span class="font-medium">$<?= htmlspecialchars($price) ?></span>
                            </div>
                        <?php endforeach; ?>
             </div>
            <div title="Add to Calendar" class="addeventatc bg-green-600 shadow-sm text-white rounded hover:bg-green-700" style="z-index: 1">
                <div class="flex gap-2 items-center">
                    <svg class="w-7 h-7 text-white inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4 9.05H3v2h1v-2Zm16 2h1v-2h-1v2ZM10 14a1 1 0 1 0 0 2v-2Zm4 2a1 1 0 1 0 0-2v2Zm-3 1a1 1 0 1 0 2 0h-2Zm2-4a1 1 0 1 0-2 0h2Zm-2-5.95a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-7 3a1 1 0 0 0 2 0H6Zm2-3a1 1 0 1 0-2 0h2Zm8 3a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-13 3h14v-2H5v2Zm14 0v12h2v-12h-2Zm0 12H5v2h14v-2Zm-14 0v-12H3v12h2Zm0 0H3a2 2 0 0 0 2 2v-2Zm14 0v2a2 2 0 0 0 2-2h-2Zm0-12h2a2 2 0 0 0-2-2v2Zm-14-2a2 2 0 0 0-2 2h2v-2Zm-1 6h16v-2H4v2ZM10 16h4v-2h-4v2Zm3 1v-4h-2v4h2Zm0-9.95v-3h-2v3h2Zm-5 0v-3H6v3h2Zm10 0v-3h-2v3h2Z" />
                    </svg>
                    Add to Calendar
                </div>
                <span class="start"><?= date('Y-m-d\TH:i:s', strtotime($data['Events.Date'])) ?></span>
                <span class="end"><?= date('Y-m-d\TH:i:s', strtotime($data['Events.Date'])) ?></span>
                <span class="timezone">America/New_York</span>
                <span class="title"><?= htmlspecialchars($data['Events.Name']) ?></span>
                <span class="description"><?= htmlspecialchars($data['Events.Description']) ?></span>
            </div>
        </div>
    </div>
    <div class="min-h-[720px] w-full min-w-0" hx-vals="js:{code: '<?= $code ?>', _csrf : '<?= csrf_token() ?>'}" hx-post="<?= url('/partials/tickets/' . $code . '/home-seats/') ?>" hx-trigger="load, refresh-list from:body" hx-swap="innerHTML">
        <div id="seats-container" class="col-span-3">
            <p class="text-gray-600">Loading seats...</p>
        </div>
    </div>
</div>