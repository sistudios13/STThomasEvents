<section class="space-y-6">
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl"><?= $eventData['Name'] ?> - Manual Check-In</h1>
        <p class="text-sm text-gray-500">Check in attendees by access code</p>
    </div>

    <!-- Search form -->
    <form class="flex items-end" x-data="{code:''}" hx-post=" <?= url('staff/check-in/' . $id . '/manual/') ?>" hx-target="#checkin-results" hx-swap="innerHTML" @htmx:after-request=" if ($event.detail.successful) {
        const url = new URL(window.location.href);
        url.searchParams.set('code', code);
        window.history.pushState({}, '', url);
    }"
    >
        <?= csrf_input() ?>
        <div>
            <label for="access_code" x-model="code" class="block text-sm font-medium text-gray-700">Access Code</label>
        <input type="text" name="access_code" id="access_code" maxlength="6" minlength="6" required autocomplete="on" class="mt-1 block w-40 uppercase rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-lg tracking-wide outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
        </div>
        <button type="submit" class="ml-2 inline-flex items-center h-[46px] gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Search
        </button>
    </form>

    <div id="checkin-results">

    </div>
</section>