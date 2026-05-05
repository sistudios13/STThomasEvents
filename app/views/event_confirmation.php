<main class="flex-grow py-12 md:py-16 lg:py-20 bg-white text-gray-900 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <section>
        <!-- Temporary Hold Warning with Countdown -->
        <div x-data="countdown('<?= $_SESSION['code_expires_at'] ?? date('Y-m-d H:i:s', time() + 600) ?>')" class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center gap-2 justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-green-900 text-pretty mb-1">Confirm Your Email</h3>
                    <p class="text-sm text-green-800">Enter your confirmation code in the next:</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600" x-text="formattedTime"></div>
                </div>
            </div>
            <p class="text-xs text-green-700 mt-3">Please confirm your email before the time runs out, or else your seats will be lost.</p>
        </div>

        <div class="max-w-md py-12 mx-auto text-center">
            <h2 class="text-2xl font-semibold mb-4">Confirm Your Email</h2>
            <div class="mb-4">
                <p class="text-sm text-gray-700">A confirmation code has been sent to <?= htmlspecialchars($email ?? 'your email') ?>. Please check your inbox and enter the code to confirm your booking.</p>
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
        }" x-ref="twoFactorForm" class="space-y-6" hx-post="<?= url('/events/' . $eventData['id'] . '/confirm/') ?>">
                <div class="inline-flex items-center gap-1.5">
                    <input x-ref="num1" x-on:input.change="() => { isNumber($refs.num1.value) ? $refs.num2.focus() : $refs.num1.value = '' }" x-on:paste="handlePaste" type="text" id="num1" name="num1" maxlength="1" autofocus class="block w-9 rounded-lg border border-gray-300 px-2 py-1.5 text-center text-sm/6 placeholder-gray-500 focus:border-gray-500 focus:ring-2 focus:outline-none focus:ring-green-500" />
                    <input x-ref="num2" x-on:input.change="() => { isNumber($refs.num2.value) ? $refs.num3.focus() : $refs.num2.value = '' }" x-on:keydown.backspace="() => { $refs.num2.value === '' ? $refs.num1.focus() : null }" x-on:paste="handlePaste" type="text" id="num2" name="num2" maxlength="1" class="block w-9 rounded-lg border border-gray-300 px-2 py-1.5 text-center text-sm/6 placeholder-gray-500 focus:border-gray-500 focus:ring-2 focus:outline-none focus:ring-green-500" />
                    <input x-ref="num3" x-on:input.change="() => { isNumber($refs.num3.value) ? $refs.num4.focus() : $refs.num3.value = '' }" x-on:keydown.backspace="() => { $refs.num3.value === '' ? $refs.num2.focus() : null }" x-on:paste="handlePaste" type="text" id="num3" name="num3" maxlength="1" class="block w-9 rounded-lg border border-gray-300 px-2 py-1.5 text-center text-sm/6 placeholder-gray-500 focus:border-gray-500 focus:ring-2 focus:outline-none focus:ring-green-500" />
                    <input x-ref="num4" x-on:input.change="() => { isNumber($refs.num4.value) ? $refs.num5.focus() : $refs.num4.value = '' }" x-on:keydown.backspace="() => { $refs.num4.value === '' ? $refs.num3.focus() : null }" x-on:paste="handlePaste" type="text" id="num4" name="num4" maxlength="1" class="block w-9 rounded-lg border border-gray-300 px-2 py-1.5 text-center text-sm/6 placeholder-gray-500 focus:border-gray-500 focus:ring-2 focus:outline-none focus:ring-green-500" />
                    <input x-ref="num5" x-on:input.change="() => { isNumber($refs.num5.value) ? $refs.num6.focus() : $refs.num5.value = '' }" x-on:keydown.backspace="() => { $refs.num5.value === '' ? $refs.num4.focus() : null }" x-on:paste="handlePaste" type="text" id="num5" name="num5" maxlength="1" class="block w-9 rounded-lg border border-gray-300 px-2 py-1.5 text-center text-sm/6 placeholder-gray-500 focus:border-gray-500 focus:ring-2 focus:outline-none focus:ring-green-500" />
                    <input x-ref="num6" x-on:input.change="() => { isNumber($refs.num6.value) ? handleSubmit() : $refs.num6.value = '' }" x-on:keydown.backspace="() => { $refs.num6.value === '' ? $refs.num5.focus() : null }" x-on:paste="handlePaste" type="text" id="num6" name="num6" maxlength="1" class="block w-9 rounded-lg border border-gray-300 px-2 py-1.5 text-center text-sm/6 placeholder-gray-500 focus:border-gray-500 focus:ring-2 focus:outline-none focus:ring-green-500" />
                </div>
                <div>
                    <?= csrf_input() ?>
                    <button x-ref="twoFactorButton" type="submit" class="inline-flex min-w-32 items-center justify-center gap-2 rounded-lg bg-green-700 px-3 py-2 text-sm font-semibold leading-5 text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-black ">
                        <span>Verify code</span>
                    </button>
                </div>
            </form>
            <div class="mt-5 text-sm text-gray-700 ">
                Haven't received it?
                <form hx-post="<?= url('/events/' . $eventData['id'] . '/resend-verification/') ?>" class="inline">
                    <?= csrf_input() ?>
                    <input type="text" disabled value="<?= $email ?? '' ?>" class="hidden">
                    <button type="submit" class="font-medium text-gray-700 underline underline-offset-2 hover:text-gray-900">
                        Resend a new one
                    </button>
                </form>
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