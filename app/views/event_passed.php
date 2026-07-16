<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $pageTitle ?? 'St. Thomas Events' ?></title>
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
    
    <body class="bg-gray-50 flex flex-col min-h-screen ">

    
    
    
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
        <main class="flex-grow flex items-center py-24 bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <section class="text-center">
                <h1 class="text-4xl font-bold text-red-700 mb-4">Event Passed!</h1>
                <p class="text-lg text-gray-700 mb-6">Unfortunately, the event or tickets you're looking for have passed!</p>
                <a href="<?= url('/events/') ?>" class="inline-flex items-center gap-2 font-semibold text-white bg-green-600 px-4 py-2 rounded transition hover:bg-green-700">
                    View Events
                </a>
            </section>
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
                        <a href="https://simonsites.com" target="_blank" class="mt-4 inline-block text-base text-white font-medium hover:text-gray-200 transition">Created by Simon Papp</a>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="<?= url('/') ?>" class="hover:text-white transition">Home</a></li>
                            <li><a href="<?= url('/events') ?>" class="hover:text-white transition">Events</a></li>
                            <li><a href="<?= url('/staff') ?>" class="hover:text-white transition">Staff</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Support</h4>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="<?= url('/support') ?>" class="hover:text-white transition">Support Page</a></li>
                            <li><a href="<?= url('/privacy') ?>" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="<?= url('/terms') ?>" class="hover:text-white transition">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 flex justify-between items-center">
                    <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> St. Thomas Events. All rights reserved.</p>
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
</html>