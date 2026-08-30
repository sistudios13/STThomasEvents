<section class="max-w-3xl mx-auto leading-7 px-2 sm:px-0">
    <div class="border-b border-gray-200 pb-6 mb-8">
        <p class="text-sm font-semibold uppercase tracking-widest text-green-700">Privacy Policy</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">St. Thomas Events</h1>
        <p class="mt-2 text-sm text-gray-500">Effective Date: 07/07/2026</p>
        <p class="mt-4 text-base text-gray-600">
            This page explains, in simple terms, what information we collect for the St. Thomas High School events site, how we use it, and how we keep it safe.
        </p>
    </div>

    <div class="space-y-8 text-[15px] sm:text-base">
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">1. Information We Collect</h2>
            <p class="text-gray-600">
                When you use this site, we may collect basic details needed to book or manage school event tickets.
            </p>
            <ul class="mt-4 list-disc pl-6 space-y-2 text-gray-600">
                <li>Name and email address</li>
                <li>Phone number or other contact details if needed</li>
                <li>Ticket or reservation details for school events</li>
                <li>Basic website usage data and cookies</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">2. How We Use It</h2>
            <p class="text-gray-600">
                We use the information to run the site and help students, parents, and staff with event bookings.
            </p>
            <ul class="mt-4 list-disc pl-6 space-y-2 text-gray-600">
                <li>Confirm reservations and send updates</li>
                <li>Help with support questions</li>
                <li>Improve the site and fix problems</li>
                <li>Keep the site secure and working properly</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">3. Cookies</h2>
            <p class="text-gray-600">
                Cookies help the site remember small settings and keep the booking flow working. You can turn them off in your browser, but some parts of the site may not work as well.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">4. Sharing and Safety</h2>
            <p class="text-gray-600">
                We do not sell your information. We only share it when it is needed to run the site, handle school event services, or follow the law.
            </p>
            <p class="mt-3 text-gray-600">
                We do our best to protect your data, but no website can guarantee perfect security.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">5. Keeping Data</h2>
            <p class="text-gray-600">
                We keep personal data only as long as needed for school event bookings, support, and any required record keeping.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-3">6. Your Rights</h2>
            <p class="text-gray-600">
                You can ask to see, update, or delete the information we have about you. If you want help with that, contact us and we will respond as soon as we can.
            </p>
            <p class="mt-3 text-gray-600">
                If student or parent information needs to be corrected, we can help with that too.
            </p>
        </section>

        <section class="pt-4 border-t border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-3">7. Contact Us</h2>
            <p class="text-gray-600">
                If you have any questions about this privacy policy or your event booking information, contact us through the support page or email below.
            </p>
            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                <a href="mailto:<?= App\Config\Settings::SUPPORT_EMAIL ?>" class="text-green-700 font-medium hover:text-green-800 transition">
                    <?= App\Config\Settings::SUPPORT_EMAIL ?>
                </a>
                <a href="<?= url('/support') ?>" class="text-gray-600 hover:text-green-700 transition">
                    Visit the support page
                </a>
            </div>
        </section>
    </div>
</section>