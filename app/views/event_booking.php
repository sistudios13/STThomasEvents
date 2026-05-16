<main class="flex-grow py-12 md:py-16 lg:py-20 bg-white text-gray-900 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div x-data="countdown('<?= $_SESSION['reservation_expires'] ?? date('Y-m-d H:i:s', time() + 300) ?>')" class="mb-12 p-6 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Seats on Hold</h3>
                <p class="text-sm text-gray-600">Complete your booking before your seats expire</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600" x-text="formattedTime"></div>
                <p class="text-xs text-gray-500 mt-1">remaining</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Booking Form -->
        <div class="lg:col-span-2">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Complete Your Booking</h2>
            <form hx-post=" <?= url('/events/' . $eventData['id'] . '/book/') ?>" >
                <?= csrf_input() ?>

                <div class="space-y-8">
                    <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                        <label for="name" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Full Name</label>
                        <input type="text" name="name" id="name" maxlength="100" minlength="2" autocomplete="name" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                    </div>

                    <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                        <label for="email" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Email</label>
                        <input type="email" name="email" id="email" maxlength="200" minlength="5" autocomplete="email" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                    </div>

                    <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                        <label for="phone" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Phone Number</label>
                        <input type="text" name="phone" id="phone" x-data x-mask="(999) 999-9999" autocomplete="tel" placeholder="(999) 999-9999" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                    </div>

                    <div x-data="customSelect()" class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                        <label for="role" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Role</label>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="role" id="role" :value="selected" required>

                        <!-- Custom dropdown button -->
                        <button type="button" @click="open = !open" class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base text-left flex items-center justify-between">
                            <span x-text="selected ? getLabel(selected) : 'Select your role'" class="flex-1"></span>
                            <svg class="w-5 h-5 text-gray-800" :class=" { 'rotate-180': open }" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>

                        </button>

                        <!-- Custom dropdown menu -->
                        <div x-show="open" @click.away="open = false" class="absolute z-10 w-fit mt-2 mr-4 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <div class="py-1">
                                <button type="button" class="w-full px-4 py-2 text-left text-gray-500  transition text-sm">
                                    Select your role
                                </button>
                                <button type="button" @click="select('student'); open = false" :class="{ 'bg-green-100 text-green-700': selected === 'student' }" class="w-full px-4 py-2 text-left text-gray-900 hover:bg-green-50 transition text-sm">
                                    Student
                                </button>
                                <button type="button" @click="select('parent'); open = false" :class="{ 'bg-green-100 text-green-700': selected === 'parent' }" class="w-full px-4 py-2 text-left text-gray-900 hover:bg-green-50 transition text-sm">
                                    Parent
                                </button>
                                <button type="button" @click="select('teacher'); open = false" :class="{ 'bg-green-100 text-green-700': selected === 'teacher' }" class="w-full px-4 py-2 text-left text-gray-900 hover:bg-green-50 transition text-sm">
                                    Teacher
                                </button>
                                <button type="button" @click="select('other'); open = false" :class="{ 'bg-green-100 text-green-700': selected === 'other' }" class="w-full px-4 py-2 text-left text-gray-900 hover:bg-green-50 transition text-sm">
                                    Other
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                        Confirm Booking
                    </button>
                    <a href="<?= url('/events/' . $eventData['id'] . '/cancel/') ?>" class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Seats Summary -->
        <div>
            <div class="bg-white border border-gray-100 rounded-lg p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Your Seats</h3>
                <div class="space-y-2">
                    <?php if (!empty($seats)): ?>
                        <?php foreach ($seats as $seat): ?>
                            <div class="px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-green-700 font-semibold text-center">
                                <?= htmlspecialchars($seat) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-gray-500 mt-4 text-center">
                    <?php echo count($seats) ?? 0; ?> seat<?php echo (count($seats) ?? 0) !== 1 ? 's' : ''; ?> selected
                </p>
            </div>
        </div>
    </div>

    <div id="spinner" class="hidden fixed top-0 left-0 w-screen h-screen bg-white/60 flex items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
    </div>

    <script>
        function customSelect() {
            return {
                open: false,
                selected: '',

                select(value) {
                    this.selected = value;
                },

                getLabel(value) {
                    const labels = {
                        'student': 'Student',
                        'parent': 'Parent',
                        'teacher': 'Teacher',
                        'other': 'Other'
                    };
                    return labels[value] || '';
                }
            }
        }

        function countdown(expirationDatetime) {
            return {
                timeLeft: 0,
                formattedTime: '0:00',

                init() {
                    // Parse the datetime string "YYYY-MM-DD HH:MM:SS"
                    const expirationTime = new Date(expirationDatetime.replace(' ', 'T')).getTime();
                    const now = new Date().getTime();
                    this.timeLeft = Math.floor((expirationTime - now) / 1000);

                    this.updateDisplay();
                    const interval = setInterval(() => {
                        this.timeLeft--;
                        this.updateDisplay();

                        // When time expires
                        if (this.timeLeft <= 0) {
                            clearInterval(interval);
                            this.handleExpired();
                        }
                    }, 1000);
                },

                updateDisplay() {
                    const minutes = Math.floor(this.timeLeft / 60);
                    const seconds = this.timeLeft % 60;
                    this.formattedTime = `${minutes}:${seconds.toString().padStart(2, '0')}`;

                    if (this.timeLeft <= 0) {
                        this.formattedTime = '0:00';
                    }
                },

                handleExpired() {
                    window.location.href = '<?= url("/events/" . $eventData["id"] . "/expired") ?>';
                }
            }
        }
    </script>
</main>