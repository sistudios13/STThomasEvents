<div class="fixed inset-0 z-50 bg-red-100 flex flex-col items-center justify-center text-center p-6">
    <div class="size-20 rounded-full bg-red-200 flex items-center justify-center mb-4">
        <svg class="size-10 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

    </div>



    <h2 class="text-3xl font-medium mt-1">Ticket Not Found</h2>
    <p class="text-gray-500 text-lg mt-1">The ticket you scanned could not be found.</p>


    <button type="button" onclick="window.resumeScanning()" class="relative mt-10 overflow-hidden bg-gray-600 text-white rounded-full px-8 py-4 text-lg font-medium">


        <span class="relative z-10">
            Scan Another Ticket
        </span>
    </button>
    <a href="<?= url('/staff/check-in/' . $id . '/manual/') ?>" class=" underline pt-2 text-gray-700 hover:text-gray-800">Manual Check-In</a>
</div>