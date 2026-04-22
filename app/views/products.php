<!-- Products Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Products</h1>
            <p class="text-lg text-gray-600">Explore our curated collection of premium products</p>
        </div>

        <?php if (isset($productsData) && count($productsData) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($productsData as $product): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 h-full flex flex-col">
                        <!-- Product Image Placeholder -->
                        <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-400">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6 flex flex-col flex-grow">
                            <a href="<?= url("/products/{$product['id']}") ?>" class="block mb-3">
                                <h2 class="text-xl font-bold text-gray-900 hover:text-indigo-600 transition"><?= htmlspecialchars($product['name']) ?></h2>
                            </a>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-2"><?= htmlspecialchars($product['category']) ?></p>
                                <p class="text-3xl font-bold text-indigo-600">$<?= number_format(htmlspecialchars($product['price']), 2) ?></p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3 mt-auto">
                                <a href="<?= url("/products/{$product['id']}") ?>" class="flex-1 px-4 py-2 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition text-center">
                                    View Details
                                </a>
                                <button @click="addToCart({ id: <?= $product['id'] ?>, name: '<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>' })" class="flex-1 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No Products Found</h2>
                <p class="text-gray-600 mb-6">We'll have amazing products coming soon!</p>
                <a href="<?= url('/') ?>" class="inline-block px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Return Home
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>