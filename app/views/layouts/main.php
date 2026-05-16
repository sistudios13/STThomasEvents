<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'St. Thomas Events' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href='<?= url('/styles/main.css') ?>'>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?= url('/assets/favicon-96x96.png') ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= url('/assets/favicon.svg') ?>" />
    <link rel="shortcut icon" href="<?= url('/assets/favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= url('/assets/apple-touch-icon.png') ?>" />
    <meta name="apple-mobile-web-app-title" content="St. Thomas Events" />
    <link rel="manifest" href="<?= url('/assets/site.webmanifest') ?>" />
</head>

<body class="bg-gray-50 flex flex-col ">

    <!-- Navigation Header -->
    <header x-data="{ open: false }" class="bg-white fixed top-0 w-full z-10 shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-2 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?= url('/') ?>" class="flex items-center gap-2">
                        <img src="<?= url('/assets/sttlogo.png') ?>" alt="Shop Logo" class="size-14 md:size-16">
                        <span class="text-lg leading-5 font-bold text-gray-900">St. Thomas <br> Events</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-3">
                    <?php if (isAdmin()): ?>
                        <a href="<?= url('/admin/dashboard') ?>" class="text-gray-600 hover:text-red-600 transition font-medium">Dashboard</a>
                        <a href="<?= url('/logout') ?>" class="text-gray-600 hover:text-red-600 transition font-medium">Logout</a>
                    <?php else: ?>
                        <a href="<?= url('/') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">Home</a>
                        <a href="<?= url('/events') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">Events</a>
                        <a href="<?= url('/tickets') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">My Tickets</a>
                        <a href="<?= url('/support') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">Support</a>
                    <?php endif; ?>
                </nav>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation Menu -->
            <div x-show="open" x-cloak x-transition class="md:hidden mt-4 pb-4 border-t border-gray-200">
                <nav class="flex flex-col items-end gap-3 pt-6">
                    <?php if (isAdmin()): ?>
                        <a href="<?= url('/admin/dashboard') ?>" class="text-gray-600 hover:text-red-600 transition font-medium">Dashboard</a>
                        <a href="<?= url('/logout') ?>" class="text-gray-600 hover:text-red-600 transition font-medium">Logout</a>
                    <?php else: ?>
                        <a href="<?= url('/') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">Home</a>
                        <a href="<?= url('/events') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">Events</a>
                        <a href="<?= url('/tickets') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">My Tickets</a>
                        <a href="<?= url('/support') ?>" class="text-gray-600 hover:text-green-600 transition font-medium">Support</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>



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
    <main class="flex-grow mt-[72px] md:mt-20 py-12 md:py-16 lg:py-20 bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div href="<?= url('/') ?>" class="flex items-center gap-2">
                            <img src="<?= url('/assets/sttlogo.png') ?>" alt="Shop Logo" class="size-16">
                            <span class="text-lg leading-5 font-bold text-white">St. Thomas <br> Events</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm">St. Thomas Events is the place to book tickets for various events at St. Thomas High School.</p>
                    <a href="https://simonsites.com" target="_blank" class="mt-4 inline-block text-base text-white font-medium hover:text-gray-200 transition">Created by Simon Papp <br> <span class="font-normal">simonsites.com</span></a>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="<?= url('/') ?>" class="hover:text-white transition">Home</a></li>
                        <li><a href="<?= url('/events') ?>" class="hover:text-white transition">Events</a></li>
                        <li><a href="<?= url('/tickets') ?>" class="hover:text-white transition">My Tickets</a></li>
                        <?php if (isAdmin()): ?>
                            <li><a href="<?= url('/admin') ?>" class="hover:text-white transition">Admins</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="<?= url('/support') ?>" class="hover:text-white transition">Support Page</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> St. Thomas Events. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/htmx.org@1.9.3"></script>
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        .notification-card {
            animation: slideIn 0.3s ease-out;
        }
        .notification-card.removing {
            animation: slideOut 0.3s ease-in forwards;
        }
    </style>
    <script>
        // HTMX error and success handling
        let notificationsContainer = document.getElementById('notifications');
        if (!notificationsContainer) {
            notificationsContainer = document.createElement('div');
            notificationsContainer.id = 'notifications';
            notificationsContainer.className = 'fixed bottom-4 right-4 space-y-2 z-50 flex flex-col';
            document.body.appendChild(notificationsContainer);
        }
        document.body.addEventListener('htmx:responseError', function (event) {
            let messages = [];
            try {
                const data = JSON.parse(event.detail.xhr.responseText);
                // HTMX error handling
                document.body.addEventListener('htmx:responseError', function (event) {
                    const errorDiv = document.getElementById('htmx-error-message');
                    errorDiv.innerText = event.detail.xhr.responseText || "An error occurred";
                    const container = document.getElementById('htmx-error');
                    container.style.display = "block";

                    setTimeout(() => { container.style.display = "none"; }, 5000);
                });

                if (Array.isArray(data.errors)) {
                    messages = data.errors;
                } else if (data.message) {
                    messages = [data.message];
                } else {
                    messages = [event.detail.xhr.responseText];
                }
            } catch {
                messages = [event.detail.xhr.responseText || "An error occurred"];
            }
            messages.forEach(msg => {
                const card = document.createElement('div');
                card.className = 'notification-card p-4 bg-red-50 border border-red-200 rounded-lg shadow-lg flex items-start gap-3';
                card.innerHTML = `
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-red-900">Error</h3>
                            <p class="mt-1 text-sm text-red-700">${msg}</p>
                        </div>
                    `;
                notificationsContainer.appendChild(card);
                setTimeout(() => { 
                    card.classList.add('removing');
                    setTimeout(() => { card.remove(); }, 300);
                }, 5000);
            });
        });
        document.body.addEventListener('htmx:afterRequest', function (event) {
            if (event.detail.successful) {
                const successMessage = event.detail.xhr.getResponseHeader('HX-Success-Message');
                if (successMessage) {
                    // HTMX error handling
                    document.body.addEventListener('htmx:responseError', function (event) {
                        const errorDiv = document.getElementById('htmx-error-message');
                        errorDiv.innerText = event.detail.xhr.responseText || "An error occurred";
                        const container = document.getElementById('htmx-error');
                        container.style.display = "block";

                        setTimeout(() => { container.style.display = "none"; }, 5000);
                    });

                    const card = document.createElement('div');
                    card.className = 'notification-card p-4 bg-green-50 border border-green-200 rounded-lg shadow-lg flex items-start gap-3';
                    card.innerHTML = `
    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
    </svg>
    <div>
        <h3 class="font-semibold text-green-900">Success</h3>
        <p class="mt-1 text-sm text-green-700">${successMessage}</p>
    </div>
    `;
                    notificationsContainer.appendChild(card);
                    setTimeout(() => { 
                        card.classList.add('removing');
                        setTimeout(() => { card.remove(); }, 300);
                    }, 5000);
                }
            }
        });
    </style>
</body>

</html>