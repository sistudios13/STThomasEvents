<div class="space-y-6">
    <div class="flex gap-4 items-center sm:justify-between">
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">New Event</h1>
            <p class="max-w-2xl text-sm text-gray-500">Publish a new event.</p>
        </div>
        <a href="<?= url('/staff/events/') ?>" class=" hidden md:inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">View all events</a>


    </div>
    <div class="rounded-lg border border-gray-100 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold tracking-tight text-gray-900">Event Details</h2>
        <p class="mt-1 text-sm text-gray-500">Provide the event details below.</p>

        <form id="new-event-form" hx-post="<?= url('/staff/events/new/') ?>" hx-swap="outerHTML" hx-target="#main-content" class="mt-6 space-y-6">
            <?= csrf_input() ?>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 items-end">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input minlength="5" maxlength="100" type="text" name="name" id="name" required placeholder="e.g. 2026 Variety Show" class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>
                <div>
                    <label x-data="{tool : false}" aria-describedby="tooltip" for="location" class="block text-sm relative font-medium text-gray-700"><span>Location</span>
                        <svg @mouseenter="tool = true" @mouseleave="tool = false" class="inline pb-1 w-6 h-6 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <div x-show="tool" x-cloak id="tooltip" x-transition class=" pointer-events-none absolute mb-2 bottom-full left-0 sm:left-1/4 sm:-translate-x-1/2 translate-x-0 z-10 w-64 max-w-[90vw] flex-col shadow-sm gap-5 rounded bg-gray-900 p-2.5 text-xs text-white transition-all ease-out " role="tooltip">
                            <span class="text-sm font-medium ">Event Location</span>
                            <p class="text-balance">Defaults to St. Thomas High School, but add more detail, such as class number if needed.</p>
                        </div>
                    </label>
                    <input type="text" minlength="5" maxlength="120" name="location" id="location" value="St. Thomas High School" required class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>
                <div class="sm:col-span-2" x-data="{length : 0}">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea @input="length = $event.target.value.length" type="text" minlength="5" maxlength="350" type="text" name="description" id="description" required class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2  outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"></textarea>
                    <span class="text-xs text-gray-500" x-text="length + '/350'"></span>
                </div>

                <div class="sm:col-span-2 grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div x-data="pricingTiers()">
                        <label class="block text-sm font-medium text-gray-700">Pricing Tiers</label>
                        <p class="text-xs text-gray-500 mt-0.5">Add a price for each ticket type (e.g. students, parents or all).</p>
                        <!-- Tier cards -->
                        <div class="mt-2 space-y-2">
                            <template x-for="(tier, index) in tiers">
                                <div class="flex items-center justify-between rounded-md border border-gray-300 bg-gray-50 px-3 py-2">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate" x-text="tier.name"></p>
                                        <p class="text-sm text-gray-500" x-text="'$' + Number(tier.price).toFixed(2)"></p>
                                    </div>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <!-- Edit -->
                                        <button type="button" @click="editingIndex !== null ? cancelEdit() : startEdit(index)" class="p-1.5 rounded-md text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 outline-none focus:ring-1 focus:ring-indigo-500" aria-label="Edit tier">
                                            <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                            </svg>
                                        </button>
                                        <!-- Remove -->
                                        <button type="button" @click="removeTier(index)" class="p-1.5 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 outline-none focus:ring-1 focus:ring-red-500" aria-label="Remove tier">
                                            <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <p x-show="tiers.length === 0" class="text-sm text-gray-400 italic">No pricing tiers added yet.</p>
                        </div>
                        <!-- Add / edit form -->
                        <div class="mt-3 flex items-end gap-2" :class="editingIndex !== null ? 'grid grid-cols-1' : ''">
                            <div class="flex gap-2">
                                <div class="flex-1">
                                    <label for="tier-name" class="block text-xs font-medium text-gray-700">Tier name</label>
                                    <input x-model="draft.name" type="text" id="tier-name" placeholder="e.g. Students, Everyone" class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div class="w-28">
                                    <label for="tier-price" class="block text-xs font-medium text-gray-700">Price</label>
                                    <div class="relative mt-1">
                                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-sm text-gray-400">$</span>
                                        <input x-model="draft.price" type="number" id="tier-price" min="0" step="0.01" placeholder="0.00" class="block w-full rounded-md border border-gray-300 bg-gray-50 pl-6 pr-2 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600 ">
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" @click="saveDraft()" class="rounded-md bg-indigo-600 px-3 py-[11px] text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 transition focus:ring-indigo-600 focus:ring-offset-2" x-text="editingIndex === null ? 'Add' : 'Save'"></button>
                                <button type="button" x-show="editingIndex !== null" @click="cancelEdit()" class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 outline-none focus:ring-1 focus:ring-indigo-500">
                                    Cancel
                                </button>
                            </div>
                        </div>
                        <p x-show="error" x-text="error" class="mt-1 text-xs text-red-600"></p>
                        <!-- Hidden field consumed by the PHP form -->
                        <input type="hidden" name="pricing" id="pricing" :value="JSON.stringify(toObject())">
                    </div>
                    <div class="flex flex-col h-full w-full justify-start gap-3">
                        <div>
                            <label for="starts" class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input type="datetime-local" name="starts" id="starts" required class="mt-1 block w-full max-w-72 rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="ends" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="datetime-local" name="ends" id="ends" required class="mt-1 block w-full max-w-72 rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>


                <div class="relative sm:col-span-2 flex items-center gap-1" x-data="{tool : false, seating: false}">
                    <label class="inline-flex items-center cursor-pointer" aria-describedby="tooltip">
                        <input type="checkbox" name="seating" x-model="seating" :value="seating ? '1' : '0'" class="sr-only peer">
                        <div class="relative w-9 h-5 bg-gray-400 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 shrink-0 ring-offset-2 dark:peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                        <span class="select-none  ms-3 text-sm font-medium text-heading">Auditorium Seat Bookings</span>

                    </label>
                    <svg @mouseenter="tool = true" @mouseleave="tool = false" @click="tool = true" @click.away="tool = false" class="inline w-6 h-6 pb-0.5 text-gray-500 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div x-show="tool" x-cloak id="tooltip" x-transition class=" pointer-events-none absolute mb-2 bottom-full left-0 sm:left-80 sm:-translate-x-1/2 translate-x-0 z-10 w-64 max-w-[90vw] flex-col shadow-sm gap-5 rounded bg-gray-900 p-2.5 text-xs text-white transition-all ease-out " role="tooltip">
                        <span class="text-sm font-medium ">Enable Seat Bookings</span>
                        <p class="text-balance">Turn this on if users can book <b>auditorium</b> seats for this event. <br> Tip: put 'main auditorium' in location.</p>
                    </div>
                </div>
                <div class="flex justify-between gap-4 sm:col-span-2">

                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">Publish Event</button>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function pricingTiers() {
        return {
            tiers: [],
            draft: { name: '', price: '' },
            editingIndex: null,
            error: '',

            toObject() {
                const obj = {};
                this.tiers.forEach(t => {
                    obj[t.name.toLowerCase().trim()] = Number(t.price);
                });
                return obj;
            },

            startEdit(index) {
                this.editingIndex = index;
                this.draft = { name: this.tiers[index].name, price: this.tiers[index].price };
            },

            cancelEdit() {
                this.editingIndex = null;
                this.draft = { name: '', price: '' };
                this.error = '';
            },

            saveDraft() {
                const name = this.draft.name.trim();
                const price = parseFloat(this.draft.price);

                if (!name) {
                    this.error = 'Enter a tier name.';
                    return;
                }
                if (isNaN(price) || price < 0) {
                    this.error = 'Enter a valid price.';
                    return;
                }

                const duplicate = this.tiers.some((t, i) =>
                    t.name.toLowerCase() === name.toLowerCase() && i !== this.editingIndex
                );
                if (duplicate) {
                    this.error = 'A tier with that name already exists.';
                    return;
                }

                this.error = '';

                if (this.editingIndex === null) {
                    this.tiers.push({ name, price });
                } else {
                    this.tiers[this.editingIndex].name = name;
                    this.tiers[this.editingIndex].price = price;
                    this.editingIndex = null;
                }

                this.draft = { name: '', price: '' };
            },

            removeTier(index) {
                this.tiers.splice(index, 1);
                if (this.editingIndex === index) this.cancelEdit();
            }
        }
    }
</script>