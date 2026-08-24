<section x-data="{
        allOptions: [
            <?php foreach ($events as $event): ?>
                {
                    label: '<?= htmlspecialchars($event['Name']) ?>',
                    value: '<?= htmlspecialchars($event['Id']) ?>',
                },
            <?php endforeach; ?>
        ],
        options: [],
        isOpen: false,
        openedWithKeyboard: false,
        selectedOption: null,
        setSelectedOption(option) {
            this.selectedOption = option
            this.isOpen = false
            this.openedWithKeyboard = false
            this.$refs.hiddenTextField.value = option.value
        },
        getFilteredOptions(query) {
            this.options = this.allOptions.filter((option) =>
                option.label.toLowerCase().includes(query.toLowerCase()),
            )
            if (this.options.length === 0) {
                this.$refs.noResultsMessage.classList.remove('hidden')
            } else {
                this.$refs.noResultsMessage.classList.add('hidden')
            }
        },
        handleKeydownOnOptions(event) {
            // if the user presses backspace or the alpha-numeric keys, focus on the search field
            if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
                this.$refs.searchField.focus()
            }
        },
    }">
    <div class="flex flex-col gap-2 md:flex-row md:justify-between">
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">Start Ticket Check In</h1>
        <div  class="flex w-full max-w-xs flex-col gap-1" x-on:keydown="handleKeydownOnOptions($event)" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false" x-init="options = allOptions">
            <div class="relative">

                <!-- trigger button  -->
                <button type="button" class="inline-flex w-full items-center justify-between gap-2 rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-700 outline-none transition hover:bg-gray-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" role="combobox" aria-controls="makesList" aria-haspopup="listbox" x-on:click="isOpen = ! isOpen" x-on:keydown.down.prevent="openedWithKeyboard = true" x-on:keydown.enter.prevent="openedWithKeyboard = true" x-on:keydown.space.prevent="openedWithKeyboard = true" x-bind:aria-expanded="isOpen || openedWithKeyboard" x-bind:aria-label="selectedOption ? selectedOption.label : 'Select Event'">
                    <span class="text-sm font-normal text-gray-700" x-text="selectedOption ? selectedOption.label : 'Select Event'"></span>
                    <!-- Chevron  -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="isOpen || openedWithKeyboard" id="makesList" class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm" role="listbox" aria-label="industries list" x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition x-trap="openedWithKeyboard">

                    <!-- Search  -->
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.5" class="absolute left-3 top-1/2 size-5 -translate-y-1/2 text-gray-400" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" class="w-full border-0 rounded-t-md border-b border-gray-200 bg-white py-2.5 pl-10 pr-3 text-sm text-gray-700 outline-none focus:border-indigo-500 focus:ring-1 focus:ring-inset focus:ring-indigo-500" name="searchField" aria-label="Search" x-on:input="getFilteredOptions($el.value)" x-ref="searchField" placeholder="Search" />
                    </div>

                    <!-- Options  -->
                    <ul class="flex max-h-44 flex-col overflow-y-auto">
                        <li class="hidden px-3 py-2 text-sm text-gray-500" x-ref="noResultsMessage">
                            <span>No matches found</span>
                        </li>
                        <template x-for="(item, index) in options" x-bind:key="item.value">
                            <li class="combobox-option inline-flex w-full cursor-pointer items-center justify-between gap-4 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-50 focus-visible:bg-gray-50 focus-visible:outline-none" role="option" x-on:click="setSelectedOption(item)" x-on:keydown.enter="setSelectedOption(item)" x-bind:id="'option-' + index" tabindex="0">
                                <!-- Label  -->
                                <span x-bind:class="selectedOption == item ? 'font-medium text-gray-900' : null" x-text="item.label"></span>
                                <!-- Screen reader 'selected' indicator  -->
                                <span class="sr-only" x-text="selectedOption == item ? 'selected' : null"></span>
                                <!-- Checkmark  -->
                                <svg x-cloak x-show="selectedOption == item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" class="size-4 text-indigo-600" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5">
                                </svg>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 divide-y-2 md:divide-y-0 md:divide-x-2 min-h-[500px]  mt-6">
        <div class="p-12 text-center border-gray-200 flex flex-col items-center justify-center">
            <h2 class="text-xl font-medium text-gray-900">Scan QR Codes</h2>
            <p class="text-sm text-gray-600 pb-4">Quickly check in attendees using the QR codes on their tickets.</p>
            <a :href="'<?= url('/staff/check-in/') ?>' + selectedOption.value + '/scan/'" :class="selectedOption ? '' : 'opacity-50 cursor-not-allowed pointer-events-none'"  class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">Scan Tickets</a>
        </div>
        <div class="p-12 text-center border-gray-200 flex flex-col items-center justify-center">
            <h2 class="text-xl font-medium text-gray-900">Manual Check-in</h2>
            <p class="text-sm text-gray-600 pb-4">Manually check in attendees using their access code.</p>
            <a :href="'<?= url('/staff/check-in/') ?>' + selectedOption.value + '/manual/'" :class="selectedOption ? '' : 'opacity-50 cursor-not-allowed pointer-events-none'"  class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">Manual Check-in</a>
        </div>
    </div>
</section>