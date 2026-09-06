<section class="text-center">
                <h1 class="text-4xl font-bold text-red-700 mb-4">Reservation Cancelled</h1>
                <p class="text-lg text-gray-700 mb-6">Your seat reservation has been cancelled. Please select your seats again to proceed with booking.</p>
                <a href="<?= url('/events/' . $eventData['Id'] . '/seats') ?>" class="inline-flex items-center gap-2 font-semibold text-white bg-green-600 px-4 py-2 rounded transition hover:bg-green-700">
                    Select Seats Again
                </a>
                <br>
                <a href="<?= url('/') ?>" class="mt-4 inline-block text-base underline">Support</a>
            </section>