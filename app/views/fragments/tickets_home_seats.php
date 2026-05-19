<?php foreach ($seats as $seat): ?>
    <div x-data="{hover:false, modalOpen:false}" :class="{'bg-red-200 border-red-500 text-red-700' : hover}" class=" px-4 py-3 transition-all bg-green-50 border border-green-200 rounded-lg text-green-700 flex justify-between items-center font-semibold mb-2">
        <?= htmlspecialchars($seat) ?>
        <button @click="modalOpen= true" @mouseover="hover=true" @mouseleave="hover=false">
            <svg :class="{'text-red-700' : hover}" class="w-6 h-6 text-green-700 transition-all " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
            </svg>

        </button>
            <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen text-gray-900 h-screen" x-cloak>
                <div x-show="modalOpen" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 w-full h-full backdrop-blur-sm bg-white/70"></div>
                <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative mx-4 px-7 py-6 w-full bg-white border shadow-lg border-gray-100 sm:max-w-lg rounded-lg">
                    <div class="flex justify-between items-center pb-3">
                        <h3 class="text-lg mr-6 font-semibold">Are you sure you want to remove this seat?</h3>
                        <button @click="modalOpen=false" class="flex absolute top-0 right-0 justify-center items-center mt-5 mr-5 w-8 h-8 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative text-gray-700 font-normal pb-8 w-auto">
                        <p>You are removing the seat <?= htmlspecialchars($seat) ?> from your booking. <?= count($seats) == 1 ? '<b>Your booking will be completely deleted!</b>' : ' This action is irreversible' ?></p>
                    </div>
                    <div class="flex  flex-row justify-end space-x-2">
                        <button @click="modalOpen=false" type="button" class="inline-flex justify-center items-center px-4 py-2 h-10 text-sm font-medium rounded-md border transition-colors focus:outline-none ">Cancel</button>
                        <button id="deleteBtn" hx-vals="js:{code: '<?= $code ?>', _csrf : '<?= csrf_token() ?>'}" hx-post="<?= url('tickets/' . $code . '/remove/' . $seat . '/') ?>" hx-swap="none"  class="inline-flex justify-center items-center px-4 py-2 h-10 text-sm font-medium text-white rounded-md border border-transparent transition-colors focus:outline-none bg-red-600 hover:bg-red-700">Remove Seat</button>
                    </div>
                </div>
            </div>
    </div>
<?php endforeach; ?>
