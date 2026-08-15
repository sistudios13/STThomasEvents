<div class="grid grid-cols-1 lg:items-center gap-12">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Access Your Tickets</h1>
        <p>Enter your email and tickets access code below to access your tickets.</p>
    </div>
    <div>
        <form hx-post=" <?= url('/tickets/authenticate/') ?>">
            <?= csrf_input() ?>

            <div class="space-y-8">


                <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label for="email" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Email</label>
                    <input value="<?= htmlspecialchars($_GET['email'] ?? null) ?>" type="email" name="email" id="email" maxlength="200" minlength="5" autocomplete="email" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                </div>
                <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label x-data="{tool : false}" aria-describedby="tooltip" for="access_code" class="relative text-xs font-semibold text-gray-500  pb-2 tracking-wide"><span class="uppercase">Tickets Access Code</span>
                        <svg @mouseenter="tool = true" @mouseleave="tool = false" class="inline pb-1 w-6 h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <div x-show="tool" x-cloak id="tooltip" class=" pointer-events-none absolute mb-2 bottom-full left-0 sm:left-1/2 sm:-translate-x-1/2 translate-x-0 z-10 w-64 max-w-[90vw] flex-col shadow-sm gap-5 rounded bg-gray-900 p-2.5 text-xs text-white transition-all ease-out " role="tooltip">
                            <span class="text-sm font-medium ">Access Code</span>
                            <p class="text-balance">The tickets access code was provided in your confirmation email.</p>
                        </div>
                    </label>

                    <input value="<?= htmlspecialchars($_GET['access_code'] ?? null) ?>" type="text" name="access_code" id="access_code" maxlength="6" minlength="6" autocomplete="off" required class="w-full bg-transparent uppercase text-gray-900 py-2 focus:outline-none text-base">
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