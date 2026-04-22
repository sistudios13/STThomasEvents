<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'PHP Shop' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href='<?= url('/styles/main.css') ?>'>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="{
        cart : $persist([]).as('cart'),
        open: false,
        addToCart(product) {
            const existing = this.cart.find(item => item.id === product.id);
            if (existing) {
                existing.quantity += 1;
            } else {
                this.cart.push({ id: product.id, name: product.name, quantity: 1 });
            }
        },
        removeFromCart(index) {
            if (this.cart[index].quantity > 1) {
                this.cart[index].quantity -= 1;
            } else {
                this.cart.splice(index, 1);
            }
        },
        cartCount() {
            return this.cart.reduce((sum, item) => sum + item.quantity, 0);
        }
    }" class="bg-gray-50 flex flex-col min-h-screen">

    <!-- Navigation Header -->
    <header class="bg-white sticky top-0 w-full z-10 shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?= url('/') ?>" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">S</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Shop</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex gap-8 items-center">
                    <a href="<?= url('/products') ?>" class="text-gray-600 hover:text-indigo-600 transition font-medium">Products</a>
                    <?php if (isAdmin()): ?>
                        <a href="<?= url('/products/new') ?>" class="text-gray-600 hover:text-indigo-600 transition font-medium">Add Product</a>
                    <?php endif; ?>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-6">
                    <?php if (isLoggedIn()): ?>
                        <button @click='open = !open' class="relative flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900" x-text="cartCount()">0</span>
                        </button>
                        <a href="<?= url('/logout') ?>" class="text-gray-600 hover:text-red-600 transition font-medium">Logout</a>
                    <?php else: ?>
                        <a href="<?= url('/login') ?>" class="text-gray-600 hover:text-indigo-600 transition font-medium">Login</a>
                        <a href="<?= url('/register') ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Shopping Cart Sidebar -->
    <div id="cart-popout" x-show="open" x-cloak @click.away="open = false" class="relative">
        <div class="fixed right-0 top-0 bg-white border-l border-gray-200 h-full shadow-lg w-full md:w-96 overflow-y-auto z-40">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Shopping Cart</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <template x-if="cart.length === 0">
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-gray-500">Your cart is empty</p>
                    </div>
                </template>

                <template x-if="cart.length > 0">
                    <div class="space-y-4">
                        <template x-for="(item, index) in cart" :key="item.id">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-900" x-text="item.name"></p>
                                    <p class="text-sm text-gray-500" x-text="'Qty: ' + item.quantity"></p>
                                </div>
                                <button @click="removeFromCart(index)" class="text-red-500 hover:text-red-700 transition font-medium text-sm">Remove</button>
                            </div>
                        </template>
                        <form action="" class="mt-6 pt-6 border-t border-gray-200">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition">Proceed to Checkout</button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Error Notification -->
    <div id="htmx-error" class="fixed hidden bottom-4 right-4 p-4 bg-red-50 border border-red-200 rounded-lg shadow-lg z-50">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="font-semibold text-red-900">Error</h3>
                <p id="htmx-error-message" class="mt-1 text-sm text-red-700"></p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-blue-400 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">S</span>
                        </div>
                        <span class="text-lg font-bold">Shop</span>
                    </div>
                    <p class="text-gray-400 text-sm">Your premier destination for quality products and seamless shopping.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="<?= url('/products') ?>" class="hover:text-white transition">Products</a></li>
                        <li><a href="<?= url('/register') ?>" class="hover:text-white transition">Create Account</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> PHP Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/htmx.org@1.9.3"></script>
    <script>
        // HTMX error handling
        document.body.addEventListener('htmx:responseError', function (event) {
            const errorDiv = document.getElementById('htmx-error-message');
            errorDiv.innerText = event.detail.xhr.responseText || "An error occurred";
            const container = document.getElementById('htmx-error');
            container.style.display = "block";

            setTimeout(() => { container.style.display = "none"; }, 5000);
        });
    </script>
</body>

</body>