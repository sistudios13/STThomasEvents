<!-- Login Section -->
<section class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-bold text-2xl">S</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
            <p class="text-gray-600 mt-2">Sign in to your account to continue shopping</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form hx-post="<?= url('/login/') ?>" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="you@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" class="w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Forgot password?</a>
                </div>

                <!-- CSRF Token -->
                <?= csrf_input() ?>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
                    Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
                </div>
            </div>

            <!-- Sign Up Link -->
            <a href="<?= url('/register') ?>" class="block w-full text-center px-4 py-3 border-2 border-indigo-600 text-indigo-600 font-bold rounded-lg hover:bg-indigo-50 transition">
                Create Account
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-600 mt-6">
            By signing in, you agree to our <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Terms of Service</a>
        </p>
    </div>
</section>