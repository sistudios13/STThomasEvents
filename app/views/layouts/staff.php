<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'St. Thomas Events' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/htmx.org@1.9.3"></script>
    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?= url('/assets/favicon-96x96.png') ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= url('/assets/favicon.svg') ?>" />
    <link rel="shortcut icon" href="<?= url('/assets/favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= url('/assets/apple-touch-icon.png') ?>" />
    <meta name="apple-mobile-web-app-title" content="St. Thomas Events" />
    <link fetchpriority="high" rel="manifest" href="<?= url('/assets/site.webmanifest') ?>" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 ">

    <!-- Navigation Header -->
    <div x-data="{ showSidebar: false }" class="relative flex w-full flex-col md:flex-row">
        <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
        <a class="sr-only" href="#main-content">skip to the main content</a>

        <!-- dark overlay for when the sidebar is open on smaller screens  -->
        <div x-cloak x-show="showSidebar" class="fixed inset-0 z-10 bg-neutral-950/10 backdrop-blur-xs md:hidden" aria-hidden="true" x-on:click="showSidebar = false" x-transition.opacity></div>

        <nav x-cloak class="fixed left-0 z-20 flex h-svh w-60 shrink-0 flex-col border-r border-gray-200 bg-gray-100 p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative" x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-60'" aria-label="sidebar navigation">
            <!-- logo  -->
            <a href="#" class="ml-2  w-fit text-2xl font-bold text-gray-900 ">
                St. Thomas Events
            </a>

            <hr class="my-4">

            <!-- sidebar links  -->
            <div class="flex flex-col justify-between h-full overflow-y-auto">
                <!-- top -->
                <div class="flex flex-col gap-1">
                    <a href="<?= url('/staff/dashboard') ?>" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-700 underline-offset-2 hover:bg-gray-200 hover:text-gray-900 focus-visible:underline focus:outline-hidden ">
                        <svg class="size-5 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                        </svg>

                        <span>Dashboard</span>
                    </a>
                    <!-- collapsible item  -->
                    <!-- <div x-data="{ isExpanded: false }" class="flex flex-col">
                        <button type="button" x-on:click="isExpanded = ! isExpanded" id="user-management-btn" aria-controls="user-management" x-bind:aria-expanded="isExpanded ? 'true' : 'false'" class="flex items-center justify-between rounded-sm gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-hidden focus-visible:underline" x-bind:class="isExpanded ? 'text-gray-900 bg-black/10 ' :  'text-gray-600 hover:bg-gray-200 hover:text-gray-900 '">
                            <svg class="size-5 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                            </svg>
                            <span class="mr-auto text-left">Events</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 transition-transform rotate-0 shrink-0" x-bind:class="isExpanded ? 'rotate-180' : 'rotate-0'" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn" id="user-management">
                            <li class="px-1 py-0.5 first:mt-1">
                                <a href="<?= url('/staff/events/') ?>" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm text-gray-700 underline-offset-2 hover:bg-gray-200 hover:text-gray-900 focus:outline-hidden focus-visible:underline">All Events</a>
                            </li>
                            <li class="px-1 py-0.5 first:mt-1">
                                <a href="<?= url('/staff/events/new/') ?>" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm text-gray-700 underline-offset-2 hover:bg-gray-200 hover:text-gray-900 focus:outline-hidden focus-visible:underline">Create New Event</a>
                            </li>
                        </ul>
                    </div> -->
                    <a href="<?= url('/staff/events/') ?>" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-700 underline-offset-2 hover:bg-gray-200 hover:text-gray-900 focus-visible:underline focus:outline-hidden ">
                        <svg class="size-5 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                        </svg>
                        <span>Events</span>
                    </a>
                    <a href="<?= url('/staff/events/new/') ?>" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-700 underline-offset-2 hover:bg-gray-200 hover:text-gray-900 focus-visible:underline focus:outline-hidden ">
                        <svg class="size-5 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        <span>Create New Event</span>
                    </a>
                </div>
                <!-- bottom -->
                <div class="flex flex-col gap-2">
                    <a href="<?= url('/staff/settings/') ?>" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-700 underline-offset-2 hover:bg-gray-200 hover:text-gray-900 focus-visible:underline focus:outline-hidden ">
                        <svg class="size-5 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        </svg>
                        <span>Settings</span>
                    </a>

                    <a href="<?= url('/auth/logout/') ?>" class="flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium text-gray-700 underline-offset-2 hover:bg-gray-200 hover:text-gray-900 focus-visible:underline focus:outline-hidden ">
                        <svg class="size-5 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                        </svg>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- main content  -->
        <main id="main-content" class="flex-grow py-12 md:py-16 lg:py-20 text-gray-900 px-4 sm:px-6 lg:px-8 max-w-7xl md:mx-auto">
            <?= $content ?? '' ?>
        </main>

        <!-- toggle button for small screen  -->
        <button class="fixed right-4 top-4 z-20 rounded-full bg-gray-900 p-3 md:hidden text-gray-100" x-on:click="showSidebar = ! showSidebar">
            <svg x-cloak x-show="showSidebar" class="size-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
            </svg>

            <svg x-cloak x-show="!showSidebar" class="size-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 10 1.99994 1.9999-1.99994 2M11 5v14m-7 0h16c.5523 0 1-.4477 1-1V6c0-.55228-.4477-1-1-1H4c-.55228 0-1 .44772-1 1v12c0 .5523.44772 1 1 1Z" />
            </svg>

            <span class="sr-only">sidebar toggle</span>
        </button>
    </div>



    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div href="<?= url('/') ?>" class="flex items-center gap-2">
                            <img src="<?= url('/assets/sttlogo.png') ?>" alt="St. Thomas High School Logo" class="size-16">
                            <span class="text-lg leading-5 font-bold text-white">St. Thomas Events Staff</span>
                        </div>
                    </div>

                    <a href="https://simonsites.com" target="_blank" class="mt-4 inline-block text-base text-white font-medium hover:text-gray-200 transition">Created by Simon Papp <br> <span class="font-normal">simonsites.com</span></a>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="<?= url('/staff/dashboard/') ?>" class="hover:text-white transition">Dashboard</a></li>
                        <li><a href="<?= url('/staff/events/') ?>" class="hover:text-white transition">Events</a></li>
                        <li><a href="<?= url('staff/events/new/') ?>" class="hover:text-white transition">New Event</a></li>
                        <li><a href="<?= url('/staff/settings') ?>" class="hover:text-white transition">Settings</a></li>

                    </ul>
                </div>

            </div>
            <div class="border-t border-gray-800 pt-8 flex justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> St. Thomas Events. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <div id="modals"></div>

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
            notificationsContainer.className = 'fixed bottom-4 right-4 ml-4 space-y-2 z-50 flex flex-col';
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