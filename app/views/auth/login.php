<div class="lg:col-span-2 grid gap-10 lg:grid-cols-2 items-start">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Staff Login</h2>
        <p class="text-gray-600 leading-relaxed max-w-md">
            This is a staff login area for authorized users only. Please sign in with your staff email and password to continue.
        </p>
    </div>

    <div>
        <form hx-post="<?= url('/auth/login/') ?>">
            <?= csrf_input() ?>

            <div class="space-y-8">
                <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label for="email" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Email</label>
                    <input type="email" name="email" id="email" autocomplete="email" maxlength="200" minlength="5" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                </div>

                <div class="border-b border-gray-300 pb-0 focus-within:border-green-600 transition">
                    <label for="password" class="text-xs font-semibold text-gray-500 uppercase pb-2 tracking-wide">Password</label>
                    <input type="password" name="password" id="password" autocomplete="current-password" required class="w-full bg-transparent text-gray-900 py-2 focus:outline-none text-base">
                </div>

            </div>

            <div class="flex justify-between gap-3 mt-8">
                <!-- Remember me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="text-green-600 size-4 focus:ring-green-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                </div>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</div>