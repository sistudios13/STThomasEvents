
<div class="lg:col-span-2 grid gap-10 lg:grid-cols-2 items-start">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Complete Your Registration</h2>
        <p class="text-gray-600 leading-relaxed max-w-md">
            Please complete your registration for the St. Thomas Events staff portal by creating an account with a strong password.
        </p>
        <div class="pt-4">
            <p class="text-sm text-gray-500">
                <strong>Name:</strong> <?= htmlspecialchars($name) ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($email) ?>
            </p>
        </div>
    </div>

    <div>
        <form hx-post="<?= url('/staff/register/complete/') ?>">
            <?= csrf_input() ?>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="space-y-8">
               <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label for="password" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Password</label>
                    <input type="password" name="password" id="password" autocomplete="current-password" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                </div>

                <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label for="password_confirm" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" autocomplete="current-password" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                </div>

            </div>

            <div class="flex justify-between gap-3 mt-8">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                    Create Account
                </button>
                <a href="<?= url('/login/') ?>" class="text-gray-500 hover:text-gray-700 transition self-center">Already have an account?</a>
            </div>
        </form>
    </div>
</div>