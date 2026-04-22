<!-- Hero Section -->
<section class="bg-gradient-to-br from-indigo-600 to-blue-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Discover Our Premium Collection</h1>
                <p class="text-xl text-indigo-100 mb-8">Shop the finest selection of quality products curated just for you. Experience exceptional value and seamless shopping.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= url('/products') ?>" class="inline-block px-8 py-3 bg-white text-indigo-600 font-bold rounded-lg hover:bg-gray-100 transition text-center">
                        Shop Now
                    </a>
                    <?php if (!isLoggedIn()): ?>
                        <a href="<?= url('/register') ?>" class="inline-block px-8 py-3 bg-indigo-700 text-white font-bold rounded-lg hover:bg-indigo-800 transition text-center border border-indigo-500">
                            Create Account
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="bg-indigo-500 rounded-lg aspect-square flex items-center justify-center">
                    <svg class="w-48 h-48 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Why Shop With Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-lg bg-gray-50 border border-gray-200">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Fast Delivery</h3>
                <p class="text-gray-600">Get your products delivered quickly with our efficient shipping partners.</p>
            </div>
            <div class="text-center p-8 rounded-lg bg-gray-50 border border-gray-200">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Quality Guarantee</h3>
                <p class="text-gray-600">All products are carefully selected to ensure the highest quality standards.</p>
            </div>
            <div class="text-center p-8 rounded-lg bg-gray-50 border border-gray-200">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.172l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.364l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-600">Our customer service team is always here to help with any questions.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-indigo-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-gray-900 mb-6">Ready to Shop?</h2>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Browse our extensive collection of high-quality products and find exactly what you're looking for.</p>
        <a href="<?= url('/products') ?>" class="inline-block px-8 py-4 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition text-lg">
            View All Products
        </a>
    </div>
</section>