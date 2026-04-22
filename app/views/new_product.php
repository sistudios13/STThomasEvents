<!-- Add Product Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="<?= url('/products') ?>" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Products
            </a>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Add New Product</h1>
            <p class="text-gray-600">Create a new product listing for your shop</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form hx-post="<?= url('/products/new/') ?>" class="space-y-8">

                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-3">Product Name</label>
                    <input type="text" name="name" id="name" required placeholder="e.g., Premium Wireless Headphones" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-900 mb-3">Price ($)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500 font-semibold">$</span>
                            <input type="number" name="price" id="price" step="0.01" required placeholder="0.00" class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-900 mb-3">Category</label>
                        <input type="text" name="category" id="category" required placeholder="e.g., Electronics" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                </div>

                <!-- Hidden Fields -->
                <?= csrf_input() ?>

                <!-- Form Actions -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <a href="<?= url('/products') ?>" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-900 font-bold rounded-lg hover:bg-gray-50 transition text-center">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold rounded-lg transition">
                        Add Product
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex gap-3">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-1">Tips for Adding Products</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Use clear, descriptive product names</li>
                        <li>• Set competitive pricing to attract customers</li>
                        <li>• Organize products into meaningful categories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>