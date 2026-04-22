<!-- Product Detail Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($product) && isset($product['name'])): ?>
            <div class="mb-8">
                <a href="<?= url('/products') ?>" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Products
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 md:p-12">
                    <!-- Product Image -->
                    <div class="flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg h-96">
                        <svg class="w-40 h-40 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>

                    <!-- Product Info -->
                    <div class="flex flex-col justify-center">
                        <div class="mb-6">
                            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-3"><?= htmlspecialchars($product['category']) ?></p>
                            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($product['name']) ?></h1>

                            <!-- Rating -->
                            <div class="flex items-center gap-2 mb-6">
                                <div class="flex text-yellow-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-600 font-medium">(42 reviews)</span>
                            </div>

                            <!-- Price -->
                            <div class="mb-8 pb-8 border-b border-gray-200">
                                <p class="text-5xl font-bold text-indigo-600"><?= number_format(htmlspecialchars($product['price']), 2) ?></p>
                                <p class="text-gray-500 mt-2">Free shipping on orders over $50</p>
                            </div>

                            <!-- Description -->
                            <div class="mb-8">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">About This Product</h2>
                                <p class="text-gray-600 leading-relaxed">This premium product is carefully selected to meet our highest quality standards. Features exceptional craftsmanship and attention to detail. Perfect for anyone looking for reliability and value.</p>
                            </div>

                            <!-- Stock Status -->
                            <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-green-800 font-semibold">✓ In Stock - Ready to Ship</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4">
                                <button @click="addToCart({ id: <?= $product['id'] ?>, name: '<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>' })" class="flex-1 px-6 py-4 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition text-lg flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add to Cart
                                </button>
                                <button class="flex-1 px-6 py-4 border-2 border-gray-300 text-gray-900 font-bold rounded-lg hover:bg-gray-50 transition text-lg flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Wishlist
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <svg class="w-10 h-10 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">Free Returns</h3>
                    <p class="text-sm text-gray-600">30-day return policy for peace of mind</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <svg class="w-10 h-10 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">Fast Shipping</h3>
                    <p class="text-sm text-gray-600">Ships within 24-48 hours</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <svg class="w-10 h-10 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.172l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.364l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-1">24/7 Support</h3>
                    <p class="text-sm text-gray-600">Help when you need it</p>
                </div>
            </div>

        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Product Not Found</h2>
                <p class="text-gray-600 mb-6">Sorry, we couldn't find the product you're looking for.</p>
                <a href="<?= url('/products') ?>" class="inline-block px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Back to Products
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>