<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'St. Thomas Events' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href='<?= url('/styles/main.css') ?>'>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?= url('/assets/favicon-96x96.png') ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= url('/assets/favicon.svg') ?>" />
    <link rel="shortcut icon" href="<?= url('/assets/favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= url('/assets/apple-touch-icon.png') ?>" />
    <meta name="apple-mobile-web-app-title" content="St. Thomas Events" />
    <link rel="manifest" href="<?= url('/assets/site.webmanifest') ?>" />
    <style>
        .htmx-indicator {

            display: none !important;

        }

        .htmx-request .htmx-indicator,
        .htmx-request.htmx-indicator {
            display: inline-block !important;

        }
    </style>
</head>

<body class="bg-white flex flex-col ">




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

    <main>
        <section class="pt-12 bg-white">
            <div class="max-w-4xl mx-auto px-4">
                <!-- Steps Progress Bar -->
                <div class="flex items-center justify-center pb-8">
                    <div class="grid grid-cols-5 items-start text-center w-full max-w-2xl">
                        <!-- Step 1: Select Seats (Active) -->
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 rounded-full <?php echo $step === 1 ? 'bg-green-700 text-white' : 'bg-gray-300 text-gray-700'; ?> flex items-center justify-center text-sm font-bold shadow-sm ">1</div>
                            <span class="mt-2 hidden sm:inline-block text-sm font-medium <?php echo $step === 1 ? 'text-green-700' : 'text-gray-700'; ?>">Select Seats</span>
                            <span class="mt-2 inline-block sm:hidden text-sm font-medium <?php echo $step === 1 ? 'text-green-700' : 'text-gray-700'; ?>">Seats</span>
                        </div>
                        <!-- Connector -->
                        <div class="flex h-full items-center">
                            <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
                        </div>
                        <!-- Step 2: Enter Details -->
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 rounded-full <?php echo $step === 2 ? 'bg-green-700 text-white' : 'bg-gray-300 text-gray-700'; ?> flex items-center justify-center text-sm font-bold shadow-sm ">2</div>
                            <span class="mt-2 hidden sm:inline-block text-sm font-medium <?php echo $step === 2 ? 'text-green-700' : 'text-gray-700'; ?>">Enter Details</span>
                            <span class="mt-2 inline-block sm:hidden text-sm font-medium <?php echo $step === 2 ? 'text-green-700' : 'text-gray-700'; ?>">Details</span>
                        </div>
                        <!-- Connector -->
                        <div class="flex h-full items-center">
                            <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
                        </div>

                        <!-- Step 3: Confirmation -->
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 rounded-full <?php echo $step === 3 ? 'bg-green-700 text-white' : 'bg-gray-300 text-gray-700'; ?> flex items-center justify-center text-sm font-bold shadow-sm ">3</div>
                            <span class="mt-2 hidden sm:inline-block text-sm font-medium <?php echo $step === 3 ? 'text-green-700' : 'text-gray-700'; ?>">Confirmation</span>
                            <span class="mt-2 inline-block sm:hidden text-sm font-medium <?php echo $step === 3 ? 'text-green-700' : 'text-gray-700'; ?>">Confirm</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?= $content ?? '' ?>
    </main>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
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
                    <a href="https://simonsites.com" target="_blank" class="mt-4 inline-block text-base text-white font-medium hover:text-gray-200 transition">Created by Simon Papp<br> <span class="font-normal">simonsites.com</span></a>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="<?= url('/') ?>" class="hover:text-white transition">Home</a></li>
                        <li><a href="<?= url('/events') ?>" class="hover:text-white transition">Events</a></li>
                        <li><a href="<?= url('/tickets') ?>" class="hover:text-white transition">My Tickets</a></li>
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
        @keyframes fadeIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                transform: scale(1);
                opacity: 1;
            }

            to {
                transform: scale(0.8);
                opacity: 0;
            }
        }

        .notification-card {
            animation: fadeIn 0.05s ease-out;
        }

        .notification-card.removing {
            animation: fadeOut 0.03s ease-in forwards;
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
    </script>
</body>

</html>