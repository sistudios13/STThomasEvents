<!-- Hero Section -->
<div class="mb-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="order-1">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Welcome to St. Thomas High School Events
            </h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                Discover all St. Thomas High School events. Find and reserve your front-row seat to unforgettable moments.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="<?= url('/events') ?>" class="inline-flex items-center justify-center px-8 py-4 bg-green-700 text-white font-semibold rounded hover:bg-green-800 transition transform shadow-sm">
                    Browse Events
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
</svg>

                </a>
                <a href="#about" class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded hover:border-green-600 hover:text-green-600 transition">
                    Learn More
                </a>
            </div>
        </div>

        <div class="order-2 grid grid-cols-2 gap-4">
            <img class="w-full rounded-lg max-h-96 h-full object-cover" src="<?= url('/assets/img1.webp') ?>" alt="office content 1">
            <img class="mt-4 w-full lg:mt-10 rounded-lg max-h-96 h-full aspect-[3/4] object-cover" src="<?= url('/assets/img2.webp') ?>" alt="office content 2">
        </div>
    </div>
</div>
<!-- About Section -->
<section id="about" class="py-16 scroll-mt-20">
    <div class="max-w-3xl mx-auto text-left md:text-center">
        <h2 class="text-4xl font-bold text-gray-900 mb-6 ">What is St. Thomas Events?</h2>
        <p class="text-lg text-gray-700 mb-6 leading-relaxed">
            This ticket booking system was built as a school project by <a href="https://simonsites.com" target="_blank" class="text-green-700 font-medium hover:text-green-800 transition">Simon Papp</a> to make event organization simpler and more efficient. It allows users to view events, select seats on an interactive map, and reserve tickets in just a few steps.
            <br><br>
            The goal was to create a modern, user-friendly experience while applying real-world web development concepts.
        </p>

    </div>
</section>
<!-- Features Section -->
<section class="pt-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Feature 1 -->
        <div class="bg-white p-6 rounded-lg shadow-sm transition border border-gray-100">
            <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>

            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pick Your Seat</h3>
            <p class="text-gray-600">Interactive seat map to choose the perfect spot for you and your friends.</p>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white p-6 rounded-lg shadow-sm transition border border-gray-100">
            <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Instant Booking</h3>
            <p class="text-gray-600">Reserve your tickets in seconds. Quick, easy, and hassle-free process.</p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white p-6 rounded-lg shadow-sm transition border border-gray-100">
            <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15h12M6 6h12m-6 12h.01M7 21h10a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1Z" />
                </svg>

            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm & Get Tickets</h3>
            <p class="text-gray-600">Receive your confirmation instantly. Print or show your digital ticket.</p>
        </div>
    </div>
</section>
<?php if(staffAuthenticated()): ?>
<div  class="fixed left-0  bottom-0 shadow-lg border-t border-7-gray-200 flex items-center justify-between p-4 bg-white w-full z-50">
    <p class="font-semibold">You're Logged In!</p>
    <a href="<?= url('/staff/dashboard/') ?>" class="inline-flex items-center justify-center rounded-md bg-indigo-600 p-4 text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
        To Staff Dashboard
    </a>

</div>
<?php endif; ?>