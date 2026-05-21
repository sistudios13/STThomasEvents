<?php

use chillerlan\QRCode\QRCode;

?>
<div x-data="{            
    slides: [                
        <?php foreach ($tickets as $ticket): ?>
        {
            QRSrc: '<?php echo (new QRCode)->render(($ticket['Bookings.Token'])) ?>',
            eventName: '<?php echo htmlspecialchars($booking['Events.Name']) ?>',
            reference: '<?php echo htmlspecialchars($booking['Reference']) ?>',
            seat: '<?php echo htmlspecialchars($ticket['Bookings.Seat']) ?>',
            ticketholder: '<?php echo htmlspecialchars($booking['Name']) ?>',
            email: '<?php echo htmlspecialchars($booking['Email']) ?>'

        },
        <?php endforeach; ?>  
    ],            
    currentSlideIndex: 1,
    previous() {                
        if (this.currentSlideIndex > 1) {                    
            this.currentSlideIndex = this.currentSlideIndex - 1                
        } else {   
            // If it's the first slide, go to the last slide           
            this.currentSlideIndex = this.slides.length                
        }            
    },            
    next() {                
        if (this.currentSlideIndex < this.slides.length) {                    
            this.currentSlideIndex = this.currentSlideIndex + 1                
        } else {                 
            // If it's the last slide, go to the first slide    
            this.currentSlideIndex = 1                
        }            
    },        
}" class="relative w-full min-h-[720px] h-full lg:max-w-lg mx-auto">



    <!-- slides -->
    <!-- Change min-h-[50svh] to your preferred height size -->
    <div class="relative min-h-[720px] h-full w-full lg:max-w-lg">
        <template x-for="(ticket, index) in slides">
            <div x-cloak x-show="currentSlideIndex == index + 1" class=" h-full w-full">

                <div class="bg-white relative overflow-visible mb-10 rounded-lg lg:max-w-lg w-full h-full shadow-sm transition border border-gray-100" x-data="{modalOpen:false}">
                    <div class="bg-green-600 px-5 py-4 flex justify-between items-center rounded-t-lg">
                        <h3 class="text-xl font-bold inline text-white">Ticket # <span x-text="index + 1"></span></h3>
                        <button @click="modalOpen= true">
                            <svg class="w-6 h-6 text-white transition-all " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                            </svg>

                        </button>
                        <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen text-gray-900 h-screen" x-cloak>
                            <div x-show="modalOpen" x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 w-full h-full backdrop-blur-sm bg-white/70"></div>
                            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95" class="relative mx-4 px-7 z-10 py-6 w-full bg-white border shadow-lg border-gray-100 sm:max-w-lg rounded-lg">
                                <div class="flex justify-between items-center pb-3">
                                    <h3 class="text-lg mr-6 font-semibold">Are you sure you want to remove this seat?</h3>
                                    <button @click="modalOpen=false" class="flex  justify-center items-start  w-8 h-8 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="relative text-gray-700 font-normal pb-8 w-auto">
                                    <p>You are removing the seat <span x-text="ticket.seat"></span> from your booking. <b x-text="slides.length === 1 ? 'Your booking will be fully deleted, this is your only seat!' : 'This action is irreversible!'"></b></p>
                                </div>
                                <div class="flex  flex-row justify-end space-x-2">
                                    <button @click="modalOpen=false" type="button" class="inline-flex justify-center items-center px-4 py-2 h-10 text-sm font-medium rounded-md border transition-colors focus:outline-none ">Cancel</button>
                                    <button id="deleteBtn" hx-vals="js:{ _csrf : '<?= csrf_token() ?>'}" :hx-post="'<?= url('tickets/') ?>' + ticket.reference + '/remove/' + ticket.seat + '/'" x-effect="htmx.process($el)" hx-swap="none" class="inline-flex justify-center items-center px-4 py-2 h-10 text-sm font-medium text-white rounded-md border border-transparent transition-colors focus:outline-none bg-red-600 hover:bg-red-700">Remove Seat</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4" x-text="`Event: ` + ticket.eventName"></h2>
                        <h3 class="text-lg font-medium text-gray-700 mb-4">Seat: <span x-text="ticket.seat" class="font-mono bg-green-200 ml-1 border border-green-600 px-2 py-1 rounded"></span></h3>
                        <p class="text-gray-600 mb-4">Reference Code: <span x-text="ticket.reference" class="font-mono bg-gray-100 px-2 py-1 rounded"></span></p>
                        <p class="text-gray-600 mb-4" x-text="`Ticketholder: ` + ticket.ticketholder"></p>
                        <p class="text-gray-600 mb-4" x-text="`Email: ` + ticket.email"></p>


                        <div class="w-full h-64">
                            <img :src="ticket.QRSrc" alt="QR Code for tickets" class="w-full h-full object-contain">
                        </div>
                        <p class="text-gray-600 mt-4">Show this QR code at the door to check in. <b>Remember: Payment is at the door. Cash only!</b></p>
                    </div>
                    <div class="flex items-center justify-between gap-3 px-5 py-4 border-t border-gray-100">

                        <button class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-green-600 text-green-700 hover:bg-green-50 active:scale-95 transition-all" aria-label="Previous ticket" x-on:click="previous()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5" class="w-4 h-4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </button>

                        <div class="flex items-center gap-2" role="group" aria-label="Tickets">
                            <template x-for="(slide, index) in slides">
                                <button x-on:click="currentSlideIndex = index + 1" x-bind:aria-label="'Ticket ' + (index + 1)" x-bind:class="currentSlideIndex === index + 1
                    ? 'w-5 bg-green-600'
                    : 'w-2 bg-gray-300 hover:bg-gray-400'" class="h-2 rounded-full transition-all duration-300 ease-in-out"></button>
                            </template>
                        </div>

                        <button class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-green-600 text-green-700 hover:bg-green-50 active:scale-95 transition-all" aria-label="Next ticket" x-on:click="next()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5" class="w-4 h-4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        </template>
    </div>


</div>