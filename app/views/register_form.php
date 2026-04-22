<!-- Register Section -->
<section class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-bold text-2xl">S</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Create Account</h1>
            <p class="text-gray-600 mt-2">Join us and start shopping today</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form hx-post="<?= url('/register/') ?>" class="space-y-6">
                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-900 mb-2">Username</label>
                    <input type="text" id="username" name="username" required autofocus placeholder="Choose your username" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="you@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <p class="text-xs text-gray-600 mt-2">Must be at least 8 characters long</p>
                </div>

                <!-- Terms Agreement -->
                <label class="flex items-start">
                    <input type="checkbox" required class="w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500 mt-1">
                    <span class="ml-2 text-sm text-gray-600">I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Privacy Policy</a></span>
                </label>

                <!-- CSRF Token -->
                <?= csrf_input() ?>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                </div>
            </div>

            <!-- Sign In Link -->
            <a href="<?= url('/login') ?>" class="block w-full text-center px-4 py-3 border-2 border-indigo-600 text-indigo-600 font-bold rounded-lg hover:bg-indigo-50 transition">
                Sign In
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Have questions? <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Contact support</a>
        </p>
    </div>
</section>