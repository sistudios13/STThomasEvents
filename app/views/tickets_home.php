<div class="items-center grid grid-cols-1 lg:grid-cols-2 gap-12 w-full">
    <div class="flex flex-col gap-12">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">My Tickets</h1>
            <p class="text-pretty">Hi, <?= htmlspecialchars($data['Name']) ?>! You can view your seats and ticket below. Payment takes place at the door. <br><br> <b>You only have to scan one code/ticket at the door to check your whole group in!</b></p>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Event Details</h2>
            <p class="text-gray-600 mb-2"><span class="font-semibold">Event:</span> <?= htmlspecialchars($data['Events.Name']) ?></p>
            <p class="text-gray-600 mb-2"><span class="font-semibold">Date & Time:</span> <?= date('F j, Y \a\t g:i A', strtotime($data['Events.Date'])) ?></p>

        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Seats</h2>
            <div class="grid grid-cols-3 gap-x-2" hx-vals="js:{code: '<?= $code ?>', _csrf : '<?= csrf_token() ?>'}" hx-post="<?= url('/partials/tickets/' . $code . '/home-seats/') ?>"  hx-trigger="load, refresh-list from:body"  hx-swap="innerHTML">
                <div id="seats-container" class="col-span-3">
                    <p class="text-gray-600">Loading seats...</p>
                </div>
                
            </div>
        </div>
    </div>


    <div class="bg-white rounded-lg shadow-sm transition border border-gray-100">
        <div class="bg-green-600 p-6 rounded-t-lg">
            <h3 class="text-xl font-bold text-white">Ticket Details</h3>

        </div>
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Event: <?= htmlspecialchars($data['Events.Name']) ?></h2>
            <p class="text-gray-600 mb-4">Reference Code: <span class="font-mono bg-gray-100 px-2 py-1 rounded"><?= htmlspecialchars($code) ?></span></p>
            <p class="text-gray-600 mb-4">Name: <?= htmlspecialchars($data['Name']) ?></p>
            <p class="text-gray-600 mb-4">Email: <?= htmlspecialchars($data['Email']) ?></p>


            <div class="w-full h-64">
                <img src="<?= $QRSource ?>" alt="QR Code for tickets" class="w-full h-full object-contain">
            </div>
            <p class="text-gray-600 mt-4">Show this QR code at the door to check your group in.</p>
        </div>
    </div>





</div>