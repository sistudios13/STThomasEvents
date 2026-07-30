<main class="flex-grow py-12 md:py-16 lg:py-20 bg-white text-gray-900 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Countdown Timer -->
    <div x-data="countdown('<?= $_SESSION['code_expires_at'] ?? date('Y-m-d H:i:s', time() + 600) ?>')" class="mb-12 p-6 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Verify Your Email</h3>
                <p class="text-sm text-gray-600">Check your inbox for the confirmation code</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600" x-text="formattedTime"></div>
                <p class="text-xs text-gray-500 mt-1">time remaining</p>
            </div>
        </div>
    </div>

    <!-- Confirmation Form -->
    <div class="max-w-md text-center mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Confirm Your Booking</h2>
            <p class="text-gray-600">
                We sent a 6-digit code to <span class="font-semibold"><?= htmlspecialchars($email ?? 'your email') ?></span>. Enter it below to complete your booking for <span><?= htmlspecialchars($eventData['Name'] ?? 'the event') ?></span>.
            </p>
        </div>

        <form x-data="{
          autoSubmit: false,
          isNumber(value) {
            if (value.match(/^[0-9]$/g)) {
              return true;
            }
          },
          handleSubmit() {
            $refs.twoFactorButton.focus();

            // Submit form
            if (this.autoSubmit) {
              $refs.twoFactorForm.submit();
            }
          },
          handlePaste(e) {
            let num = e.clipboardData.getData('text/plain').trim();
            
            if (num.length === 6 && num.match(/^[0-9]+$/g)) {
              $refs.num1.value = num.charAt(0);
              $refs.num2.value = num.charAt(1);
              $refs.num3.value = num.charAt(2);
              $refs.num4.value = num.charAt(3);
              $refs.num5.value = num.charAt(4);
              $refs.num6.value = num.charAt(5);

              this.handleSubmit();
            }
          },
          loading: false
        }" x-ref="twoFactorForm" class="space-y-8" hx-post="<?= url('/events/' . $eventData['Id'] . '/confirm/') ?>" @htmx:before-request="loading = true" @htmx:after-request="loading = false">
            <div>
                <label class="text-xs font-semibold text-center text-gray-500 uppercase tracking-wide block mb-4">Confirmation Code</label>
                <div class="flex items-center justify-center gap-3">
                    <input x-ref="num1" x-on:input.change="() => { isNumber($refs.num1.value) ? $refs.num2.focus() : $refs.num1.value = '' }" x-on:paste="handlePaste" type="text" id="num1" name="num1" maxlength="1" autofocus class="w-12 h-12 rounded border border-gray-300 text-center text-lg font-semibold text-gray-900 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" />
                    <input x-ref="num2" x-on:input.change="() => { isNumber($refs.num2.value) ? $refs.num3.focus() : $refs.num2.value = '' }" x-on:keydown.backspace="() => { $refs.num2.value === '' ? $refs.num1.focus() : null }" x-on:paste="handlePaste" type="text" id="num2" name="num2" maxlength="1" class="w-12 h-12 rounded border border-gray-300 text-center text-lg font-semibold text-gray-900 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" />
                    <input x-ref="num3" x-on:input.change="() => { isNumber($refs.num3.value) ? $refs.num4.focus() : $refs.num3.value = '' }" x-on:keydown.backspace="() => { $refs.num3.value === '' ? $refs.num2.focus() : null }" x-on:paste="handlePaste" type="text" id="num3" name="num3" maxlength="1" class="w-12 h-12 rounded border border-gray-300 text-center text-lg font-semibold text-gray-900 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" />
                    <input x-ref="num4" x-on:input.change="() => { isNumber($refs.num4.value) ? $refs.num5.focus() : $refs.num4.value = '' }" x-on:keydown.backspace="() => { $refs.num4.value === '' ? $refs.num3.focus() : null }" x-on:paste="handlePaste" type="text" id="num4" name="num4" maxlength="1" class="w-12 h-12 rounded border border-gray-300 text-center text-lg font-semibold text-gray-900 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" />
                    <input x-ref="num5" x-on:input.change="() => { isNumber($refs.num5.value) ? $refs.num6.focus() : $refs.num5.value = '' }" x-on:keydown.backspace="() => { $refs.num5.value === '' ? $refs.num4.focus() : null }" x-on:paste="handlePaste" type="text" id="num5" name="num5" maxlength="1" class="w-12 h-12 rounded border border-gray-300 text-center text-lg font-semibold text-gray-900 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" />
                    <input x-ref="num6" x-on:input.change="() => { isNumber($refs.num6.value) ? handleSubmit() : $refs.num6.value = '' }" x-on:keydown.backspace="() => { $refs.num6.value === '' ? $refs.num5.focus() : null }" x-on:paste="handlePaste" type="text" id="num6" name="num6" maxlength="1" class="w-12 h-12 rounded border border-gray-300 text-center text-lg font-semibold text-gray-900 focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600" />
                </div>
            </div>

            <div>
                <?= csrf_input() ?>
                <button x-ref="twoFactorButton" type="submit" :disabled="loading" class="px-6 py-2 w-full bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <svg x-show="loading" x-cloak class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span x-text="loading ? 'Verifying…' : 'Verify Code'"></span>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-gray-600">
            
            <form hx-post="<?= url('/events/' . $eventData['Id'] . '/resend-verification/') ?>" class="inline" hx-swap="none" x-data="{ loading: false }" @htmx:before-request="loading = true" @htmx:after-request="loading = false">
                <?= csrf_input() ?>
                <span>Didn't receive the code?</span>
                <input type="text" disabled value="<?= $email ?? '' ?>" class="hidden">
                <button type="submit" :disabled="loading" class="font-semibold text-green-600 inline hover:text-green-700 transition disabled:opacity-70 disabled:cursor-not-allowed items-center justify-center gap-2">
                    <span x-text="loading ? 'Sending…' : 'Resend it'"></span>
                </button>
            </form>
        </div>
    </div>

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
                window.location.href = '<?= url("/events/" . $eventData["Id"] . "/expired") ?>';
            }
        }
    }
</script>