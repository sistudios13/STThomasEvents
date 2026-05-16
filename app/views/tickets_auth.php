<div class="grid grid-cols-1 lg:items-center gap-12">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Access Your Tickets</h1>
        <p>Enter your email and tickets reference number below to access your tickets.</p>
    </div>
    <div>
        <form hx-post=" <?= url('/tickets/authenticate/') ?>">
            <?= csrf_input() ?>

            <div class="space-y-8">
                

                <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label for="email" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Email</label>
                    <input type="email" name="email" id="email" maxlength="200" minlength="5" autocomplete="email" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                </div>
                <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label for="code" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Tickets Reference Code</label>
                    <input type="text" name="code" id="code" maxlength="6" minlength="6" autocomplete="off" required class="w-full bg-transparent uppercase text-gray-900 py-2 focus:outline-none text-base">
                </div>
            </div>
    

    <div class="flex gap-3 mt-8">
        <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
            View Tickets
        </button>

    </div>
    </form>
    </div>
</div>


