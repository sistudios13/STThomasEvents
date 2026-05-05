<main class="flex-grow py-12 md:py-16 lg:py-20 bg-white text-gray-900 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <section>
        <!-- Temporary Hold Warning with Countdown -->
        <div x-data="countdown('<?= $_SESSION['reservation_expires'] ?? date('Y-m-d H:i:s', time() + 300) ?>')" class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center gap-2 justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-green-900 text-pretty mb-1">Seats on Temporary Hold</h3>
                    <p class="text-sm text-green-800">Your seats will expire in:</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600" x-text="formattedTime"></div>
                </div>
            </div>
            <p class="text-xs text-green-700 mt-3">Please complete your booking before time runs out or your seats will be released.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-2xl font-semibold mb-4">Booking Information</h2>
                <form hx-post=" <?= url('/events/' . $eventData['id'] . '/book/') ?>">
                    <?= csrf_input() ?>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" maxlength="100" minlength="2" autocomplete="name" required class="mt-1 w-full md:max-w-sm rounded-md border border-slate-200-300 bg-gray-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700 disabled:cursor-not-allowed disabled:opacity-75">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" maxlength="100" minlength="5" autocomplete="email" required class="mt-1 w-full rounded-md border border-slate-200-300 bg-gray-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700 disabled:cursor-not-allowed disabled:opacity-75">
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" id="phone" x-data x-mask="(999) 999-9999" name="phone" autocomplete="tel-national" placeholder="(999) 999-9999" autocomplete="tel" required class="mt-1 w-full md:max-w-80 rounded-md border border-slate-200-300 bg-gray-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700 disabled:cursor-not-allowed disabled:opacity-75">
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit" class="bg-green-700 hover:bg-green-800 font-semibold text-white py-2 px-4 rounded-lg">Confirm Booking</button>
                        <a href="<?= url('/events/' . $eventData['id'] . '/cancel/') ?>" class="text-sm text-gray-700 hover:text-gray-900 transition">Cancel Booking</a>
                    </div>

                </form>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Your Seats</h3>
                <div class="flex flex-wrap gap-2">
                    <?php if (!empty($seats)): ?>

                        <?php foreach ($seats as $seat): ?>
                            <div class="px-3 py-1 bg-green-700 text-white rounded-lg text-sm font-medium"><?= htmlspecialchars($seat) ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
</main>

<script>
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