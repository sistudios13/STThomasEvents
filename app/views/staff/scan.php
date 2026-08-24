<section class="min-h-[calc(100vh-6rem)] text-center flex flex-col items-center" x-data="{
            scanned: <?= json_encode($stats['checked']) ?>,
            total: <?= json_encode($stats['total']) ?>,
            history: [
               

            ],
            addCheckIn(detail) {
                // newest first
                this.history.unshift(detail);
                this.scanned = this.history[0].numberCheckedIn;
                this.total = this.history[0].numberTotal;
                this.$nextTick(() => {
        htmx.process(this.$refs.historyList); // or document.body
    });

            },
            removeCheckIn(id) {
                this.history = this.history.filter(entry => entry.id !== id);
                this.scanned = this.scanned < 1 ? 0 : this.scanned -1;
            }
         }" x-on:checked-in.window="addCheckIn($event.detail)">
    <div>
        <p class="text-gray-600 text-sm">Scan QR Code to check in.</p>
        <h1 class="font-semibold text-lg"><?= htmlspecialchars($eventData['Name']) ?></h1>

        <div class="flex justify-between items-center gap-12">
            <div class="flex items-center gap-2 py-2 justify-center">
                <div id="scanner-status-dot" class="size-3 bg-green-600 rounded-full"></div>
                <span id="scanner-status-text" class="text-sm text-gray-600">Scanner Active</span>
            </div>
            <p class="text-sm text-gray-600"><span x-text="scanned"></span> / <span x-text="total"></span> Checked In</p>
        </div>

    </div>

    <div id="scanner-wrap" class="relative mt-6 w-full max-w-md aspect-square">
        <video class="w-full h-full object-cover bg-black text-white"></video>

        <!-- corner-bracket outline overlay -->
        <div class="pointer-events-none absolute inset-10">
            <div class="absolute top-0 left-0 w-10 h-10 border-t-4 border-l-4 border-white/90 rounded-tl-lg"></div>
            <div class="absolute top-0 right-0 w-10 h-10 border-t-4 border-r-4 border-white/90 rounded-tr-lg"></div>
            <div class="absolute bottom-0 left-0 w-10 h-10 border-b-4 border-l-4 border-white/90 rounded-bl-lg"></div>
            <div class="absolute bottom-0 right-0 w-10 h-10 border-b-4 border-r-4 border-white/90 rounded-br-lg"></div>
        </div>
    </div>

    <!-- history -->
    <div class="w-full max-w-md">
        <div class="mt-6 space-y-2 overflow-y-auto max-h-64 pr-1">
            <h2 class="font-medium text-lg">Check-in History</h2>
            <p x-show="history.length === 0" class="text-sm text-gray-400 py-4">
                No recent check-ins.
            </p>

            <div class="grid pb-2 gap-2" x-ref="historyList">
                <template x-for="entry in history" :key="entry.id">
                    <div class="flex items-center justify-between gap-3 bg-white border border-gray-100 shadow-sm rounded-lg px-4 py-2.5 text-left">
                        <div class="min-w-0">
                            <p class="font-medium text-sm truncate" x-text="entry.name"></p>
                            <p class="text-xs text-gray-500">
                                <span x-text="entry.time"></span>
                                <span x-show="entry.seat">
                                    · Seat <span class="font-semibold" x-text="entry.seat"></span>
                                </span>
                            </p>
                        </div>
                        <button type="button" class="shrink-0 text-xs font-medium text-red-600 hover:text-red-700 hover:underline disabled:opacity-40" hx-post="<?= url('/staff/check-in/' . $id . '/undo/') ?>" :hx-vals="JSON.stringify({_csrf: '<?= csrf_token() ?>', id: entry.id})" hx-swap="none" @click="entry.undoing = true" @htmx:after-request="
                    entry.undoing = false;
                    if ($event.detail.successful) {
                        removeCheckIn(entry.id);
                    }
                " :disabled="entry.undoing">
                            <span x-show="!entry.undoing">Undo</span>
                            <span x-show="entry.undoing">Undoing…</span>
                        </button>
                    </div>
                </template>
            </div>

        </div>
    </div>

</section>

<!-- fullpage modal target -->
<div id="modal-container"></div>

<style>
    @keyframes modal-slide-up {
        from {

            opacity: 0;
            scale: 0.95;
        }

        to {

            opacity: 1;
            scale: 1;
        }
    }

    .modal-slide-up {
        animation: modal-slide-up 150ms ease-out;
    }
</style>

<div id="scan-trigger" hx-post="<?= url('/staff/check-in/' . $id . '/scan/') ?>" hx-trigger="scan-detected" hx-target="#modal-container" hx-swap="innerHTML" hx-vals="js:{data: window.__lastQrData, _csrf: '<?= csrf_token() ?>'}"></div>

<script type="module">
    // ...

    const modalHost = document.getElementById('modal-container');

    document.body.addEventListener('htmx:afterSwap', (e) => {
        if (e.detail.target !== modalHost) return;

        const modal = modalHost.firstElementChild;
        if (!modal) return;

        modal.classList.add('modal-slide-up');
    });

    // ...
</script>

<!-- hidden htmx trigger: fires the POST, htmx never touches it visually -->
<div id="scan-trigger" hx-post="<?= url('/staff/check-in/' . $id . '/scan/') ?>" hx-trigger="scan-detected" hx-target="#modal-container" hx-swap="innerHTML" hx-vals="js:{data: window.__lastQrData, _csrf: '<?= csrf_token() ?>'}">
</div>

<script type="module">
    import QrScanner from '<?= url('/scripts/qr-scanner.min.js') ?>';


    const videoElem = document.querySelector('video');
    const triggerElem = document.getElementById('scan-trigger');
    const modalHost = document.getElementById('modal-container');
    const statusDot = document.getElementById('scanner-status-dot');
    const statusText = document.getElementById('scanner-status-text');

    let scanningLocked = false; // true = camera keeps running, but we ignore results

    const updateScannerStatus = () => {
        statusDot.classList.toggle('bg-green-600', !scanningLocked);
        statusDot.classList.toggle('bg-red-600', scanningLocked);
        statusText.classList.toggle('text-gray-600', !scanningLocked);
        statusText.classList.toggle('text-red-600', scanningLocked);
        statusText.textContent = scanningLocked ? 'Scanning Locked' : 'Scanner Active';
    };

    const qrScanner = new QrScanner(
        videoElem,
        result => {
            if (scanningLocked) return; // camera stays live, we just don't act on it
            scanningLocked = true;
            updateScannerStatus();
            window.__lastQrData = result.data;
            htmx.trigger(triggerElem, 'scan-detected');
        },
        {
            highlightScanRegion: false,
            highlightCodeOutline: false,
            maxScansPerSecond: 5,
            calculateScanRegion: (video) => {
                const size = Math.min(video.videoWidth, video.videoHeight) * 0.7;
                return {
                    x: (video.videoWidth - size) / 2,
                    y: (video.videoHeight - size) / 2,
                    width: size,
                    height: size,
                };
            },
        },
    );

    qrScanner.start(); // called once, never touched again

    // If the request fails, unlock so they can retry
    document.body.addEventListener('htmx:responseError', (e) => {
        if (e.target === triggerElem) {
            scanningLocked = false;
            updateScannerStatus();
        }
    });

    // Called from the modal to go again
    window.resumeScanning = function () {
        modalHost.innerHTML = '';
        scanningLocked = false;
        updateScannerStatus();

    };

    updateScannerStatus();
</script>