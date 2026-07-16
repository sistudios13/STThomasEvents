<div x-data="supportChat()" x-init="init()">
    <!-- Hero Section -->
    <div class="mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-1">
                <h1 class="text-5xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    Need Help?
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    We're here to help you with any questions about booking tickets, managing your events, or troubleshooting issues. Find answers and get the support you need.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#faq" class="inline-flex items-center justify-center px-8 py-4 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition transform shadow-sm">
                        View FAQ
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                        </svg>

                    </a>
                    <a href="#contact" class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded hover:border-green-600 hover:text-green-600 transition">
                        Contact Us
                    </a>
                </div>
            </div>

            <div class="order-2">
                <div class="bg-green-50 rounded-lg p-8 border border-green-200">
                    <div class="flex items-center justify-center">
                        <svg class="w-24 h-24 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z" />
                        </svg>

                    </div>
                    <p class="text-center text-gray-600 mt-4">Available 24/7 to assist you with any questions.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ Section -->
    <section id="faq" class="py-16 scroll-mt-20">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl font-bold text-gray-900 mb-12 text-center">Frequently Asked Questions</h2>

            <div class="space-y-4">
                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-bold text-gray-900">
                        <span>How do I book tickets?</span>
                        <span class="text-green-600 group-open:rotate-180">
                            <svg class="w-6 h-6 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m19 9-7 7-7-7" />
                            </svg>

                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600">Simply browse our events, select the event you're interested in, choose your preferred seats from the interactive map, and complete the booking. You'll receive a confirmation email with your tickets.</p>
                </details>

                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-bold text-gray-900">
                        <span>Can I modify or cancel my booking?</span>
                        <span class="text-green-600 group-open:rotate-180">
                            <svg class="w-6 h-6 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m19 9-7 7-7-7" />
                            </svg>

                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600">Yes, you can modify or cancel your booking from your tickets dashboard up to 48 hours before the event. Contact us for modifications within 48 hours of the event.</p>
                </details>

                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-bold text-gray-900">
                        <span>What payment methods do you accept?</span>
                        <span class="text-green-600 group-open:rotate-180">
                            <svg class="w-6 h-6 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m19 9-7 7-7-7" />
                            </svg>

                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600">We only accept cash payments at our events. Be prepared at the door!</p>
                </details>

                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-bold text-gray-900">
                        <span>How will I receive my tickets?</span>
                        <span class="text-green-600 group-open:rotate-180">
                            <svg class="w-6 h-6 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m19 9-7 7-7-7" />
                            </svg>

                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600">Tickets are delivered instantly via email after successful booking, or can be accessed through the tickets dashboard. You can print them or display the digital version on your mobile device at the venue.</p>
                </details>

                <details class="group bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-bold text-gray-900">
                        <span>How to access my tickets dashboard?</span>
                        <span class="text-green-600 group-open:rotate-180">
                            <svg class="w-6 h-6 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m19 9-7 7-7-7" />
                            </svg>

                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600">You can access your tickets dashboard by logging in using your email and reference code. This code should be in your confirmation email and on your tickets. Once logged in, you can view and manage all your tickets.</p>
                </details>
            </div>
        </div>
    </section>
    <!-- Contact Section -->
    <section id="contact" class="py-16 scroll-m-20">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl font-bold text-gray-900 mb-12 text-center">Get in Touch</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- email -->
                <div class="bg-white p-6 rounded-lg shadow-sm transition border border-gray-100">
                    <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                        </svg>

                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600 mb-3">stthomaseventsinfo@gmail.com</p>
                    <p class="text-sm text-gray-500">Response within 24 hours</p>
                </div>
                <!-- ai chat -->
                <div class="bg-white p-6 rounded-lg shadow-sm transition border border-gray-100">
                    <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-700 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z" />
                        </svg>

                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Live Chat</h3>
                    <p class="text-gray-600 mb-3">Chat with a support bot</p>
                    <p class="text-sm text-gray-500">Available 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- chat widget -->
    <div class="fixed bottom-4 right-4 z-50">
        <!-- Chat Toggle Button -->
        <div @click="open = !open" class="bg-white hover:bg-gray-100 hover:border-gray-200 rounded-full border border-gray-100 shadow-lg p-3 cursor-pointer transition hover:shadow-xl" id="chat-widget">
            <div class="relative w-8 h-8">
                <svg x-show="!open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 rotate-90 scale-75" x-transition:enter-end="opacity-100 rotate-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 rotate-0 scale-100" x-transition:leave-end="opacity-0 -rotate-90 scale-75" class="absolute inset-0 w-8 h-8 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17h6l3 3v-3h2V9h-2M4 4h11v8H9l-3 3v-3H4V4Z" />
                </svg>
                <svg x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 rotate-90 scale-75" x-transition:enter-end="opacity-100 rotate-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 rotate-0 scale-100" x-transition:leave-end="opacity-0 -rotate-90 scale-75" class="absolute inset-0 w-8 h-8 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>

        <!-- Chat Popup -->
        <div x-transition x-cloak x-show="open" class="absolute bottom-20 px-4 -right-4 w-screen max-w-sm md:w-96 h-auto max-h-96 md:max-h-96">
            <div class=" bg-white rounded-lg shadow-xl border border-gray-200 w-full h-full flex max-h-96 flex-col overflow-hidden">
                <!-- Header -->
                <div class="bg-green-600 text-white p-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg">Chat with us</h3>
                        <p class="text-green-100 text-sm">We're here to help!</p>
                    </div>
                    <button @click="open = false" class="text-white hover:bg-green-700 rounded p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Messages Area -->
                <div class="flex-1 p-4 overflow-y-auto bg-gray-50" x-ref="messagesArea">
                    <div id="chat-messages" class="space-y-3">
                        <div class="flex justify-start">
                            <div class="bg-white rounded-lg p-3 shadow-sm max-w-xs border border-gray-200">
                                <p class="text-gray-800 text-sm whitespace-pre-wrap">Hello! How can we help you today?</p>
                            </div>
                        </div>
                        <span class="text-gray-500 text-xs">*Responses are AI generated</span>
                    </div>
                </div>
                <!-- Input Area -->
                <form id="support-chat-form" class="border-t border-gray-200 p-3 bg-white" hx-post="<?= url('/support/chatbot-request/') ?>" hx-target="#chat-messages" hx-swap="beforeend" x-on:htmx:before-request.camel="supportChatBeforeRequest($event)" x-on:htmx:after-request.camel="supportChatAfterRequest()">
                    <?= csrf_input() ?>
                    <div class="flex gap-2">
                        <input name="message" minlength="5" autocomplete="off" maxlength="150" x-model="message" type="text" placeholder="Type your question..." class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm" :disabled="loading">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition disabled:opacity-60 disabled:cursor-not-allowed" :disabled="loading || !message.trim() || message.trim().length < 5 || message.trim().length > 150">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function supportChat() {
            return {
                open: false,
                message: '',
                loading: false,
                csrfToken: '<?= csrf_token() ?>',

                init() {
                    this.$nextTick(() => this.scrollMessagesToBottom());
                },

                scrollMessagesToBottom() {
                    this.$nextTick(() => {
                        const area = this.$refs.messagesArea;
                        if (area) {
                            area.scrollTop = area.scrollHeight;
                        }
                    });
                },

                appendBubble(role, text, loading = false, bubbleId = '') {
                    const messages = document.getElementById('chat-messages');
                    if (!messages) {
                        return;
                    }

                    const wrapperClass = role === 'user' ? 'flex justify-end' : 'flex justify-start';
                    const bubbleClass = role === 'user'
                        ? 'bg-green-600 text-white rounded-br-none'
                        : 'bg-white text-gray-800 rounded-bl-none border border-gray-200';
                    const safeText = text
                        .replaceAll('&', '&amp;')
                        .replaceAll('<', '&lt;')
                        .replaceAll('>', '&gt;')
                        .replaceAll('"', '&quot;')
                        .replaceAll("'", '&#039;');

                    const loadingMarkup = loading ? '<p class="text-sm text-gray-500 animate-pulse">Loading...</p>' : `<p class="text-sm whitespace-pre-wrap break-all">${safeText}</p>`;
                    messages.insertAdjacentHTML('beforeend', `
                            <div class="${wrapperClass}"${bubbleId ? ` id="${bubbleId}"` : ''}>
                                <div class="${bubbleClass} rounded-lg p-3 shadow-sm max-w-xs">
                                    ${loadingMarkup}
                                </div>
                            </div>
                        `);
                    this.scrollMessagesToBottom();
                },

                supportChatBeforeRequest(event) {
                    const form = event.detail.elt;
                    const input = form.querySelector('input[name="message"]');
                    const text = (input ? input.value : this.message).trim();

                    if (!text) {
                        event.preventDefault();
                        return;
                    }

                    this.appendBubble('user', text);
                    this.appendBubble('assistant', 'Loading...', true, 'chat-loading');
                    this.loading = true;
                    if (input) {
                        input.value = text;
                    }
                },

                supportChatAfterRequest() {
                    const loadingBubble = document.getElementById('chat-loading');
                    if (loadingBubble) {
                        loadingBubble.remove();
                    }

                    this.loading = false;
                    this.message = '';
                    this.scrollMessagesToBottom();
                },

                async sendMessage() {
                    const text = this.message.trim();
                    if (!text || this.loading) {
                        return;
                    }
                }
            }
        }
    </script>
</div>