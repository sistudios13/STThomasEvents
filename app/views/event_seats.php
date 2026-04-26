<style>
    /* crisp rendering — prevents blur on scaled canvas */
    #canvas {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        -webkit-font-smoothing: subpixel-antialiased;
        transform-origin: 0 0;
        position: absolute;
        top: 0;
        left: 0;
        padding: 28px 36px 36px;
        will-change: transform;
        /* prevent fractional pixel translations */
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    /* viewport container */
    #vp {
        position: absolute;
        inset: 0;
        overflow: hidden;
        touch-action: none;
        -webkit-user-select: none;

        user-select: none;
    }

    #vp.is-grabbing {
        cursor: grabbing !important;
    }

    #vp:not(.is-grabbing) {
        cursor: grab;
    }

    /* seats */
    .seat {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 3px 3px 1px 1px;
        border: 1px solid transparent;
        font-size: 7px;
        font-weight: 700;
        flex-shrink: 0;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        /* no transition on transform — avoids blur during interaction */
        transition: background-color 0.08s, border-color 0.08s;
        line-height: 1;
    }

    .s-available {
        background: #dcfce7;
        border-color: #4ade80;
        color: #166534;
    }

    .s-available:hover,
    .s-available:focus {
        background: #bbf7d0;
        outline: none;
    }

    .s-available:active {
        background: #86efac;
    }

    .s-selected {
        background: #22c55e;
        border-color: #15803d;
        color: #f0fdf4;
    }

    .s-selected:hover,
    .s-selected:focus {
        background: #16a34a;
        outline: none;
    }

    .s-selected:active {
        background: #15803d;
    }

    .s-taken {
        background: #e5e7eb;
        border-color: #d1d5db;
        color: #9ca3af;
        cursor: default;
        pointer-events: none;
    }

    /* map structure */
    .mrow {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2px;
        height: 22px;
    }

    .rlabel {
        width: 13px;
        text-align: center;
        font-size: 9px;
        font-weight: 700;
        color: #9ca3af;
        flex-shrink: 0;
    }

    .aisle {
        width: 10px;
        flex-shrink: 0;
    }

    .caisle {
        width: 44px;
        flex-shrink: 0;
    }

    .section-gap {
        height: 10px;
    }

    /* zoom buttons */
    .zbtn {
        width: 30px;
        height: 30px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        background: white;
        color: #374151;
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        -webkit-tap-highlight-color: transparent;
    }

    .zbtn:hover {
        background: #f9fafb;
    }

    .zbtn:active {
        background: #f3f4f6;
    }

    /* seat chips in booking bar */
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 999px;
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #15803d;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    .chip:hover {
        background: #bbf7d0;
        border-color: #4ade80;
        color: #166534;
    }
</style>
</head>



<!-- HEADER -->
<header class="flex-shrink-0 bg-white border-b border-gray-200 text-center py-3 shadow-sm z-10">
    <p class="text-[10px] font-semibold tracking-[0.2em] text-gray-400 uppercase">Select your seats</p>
    <h1 class="text-xl font-bold text-gray-800 tracking-tight"><?= htmlspecialchars($eventData['name']) ?? 'Event' ?></h1>
</header>

<div x-data="app()" class="flex flex-col">

    <!-- TOOLBAR -->
    <div class="flex-shrink-0 bg-white border-b border-gray-200 px-3 py-2 flex flex-wrap items-center gap-x-4 gap-y-2 z-10 shadow-sm">

        <!-- Legend -->
        <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-1">
                <span class="seat s-available" style="pointer-events:none;width:14px;height:14px;font-size:0"></span>
                <span class="text-xs text-gray-500">Available</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="seat s-selected" style="pointer-events:none;width:14px;height:14px;font-size:0"></span>
                <span class="text-xs text-gray-500">Selected</span>
            </div>
            <div class="flex items-center gap-1">
                <span class="seat s-taken" style="pointer-events:none;width:14px;height:14px;font-size:0"></span>
                <span class="text-xs text-gray-500">Unavailable</span>
            </div>
        </div>

        <!-- Zoom controls -->
        <div class="flex items-center gap-1 ml-auto">
            <button class="zbtn" @click="zoomBy(-0.15)" aria-label="Zoom out">−</button>
            <span class="text-xs text-gray-400 w-10 text-center tabular-nums select-none" x-text="Math.round(scale*100)+'%'"></span>
            <button class="zbtn" @click="zoomBy(+0.15)" aria-label="Zoom in">+</button>
            <button class="zbtn text-sm" @click="fit()" aria-label="Fit to screen" title="Fit">⌂</button>
        </div>

        <!-- Count badge -->
        <span class="text-sm font-bold text-green-700" x-text="selected.length + ' seat' + (selected.length !== 1 ? 's' : '') + ' selected'">
        </span>
    </div>

    <!-- PAN/ZOOM VIEWPORT -->
    <div class="flex-1 relative bg-slate-100 min-h-80 sm:min-h-96 md:min-h-[24rem] lg:min-h-[28rem]">
        <div id="vp" :class="{ 'is-grabbing': panning }" @mousedown="onMD($event)" @mousemove="onMM($event)" @mouseup="onMU($event)" @mouseleave="onMU($event)" @wheel.prevent="onWheel($event)" @touchstart.prevent="onTS($event)" @touchmove.prevent="onTM($event)" @touchend.prevent="onTE($event)" @touchcancel.prevent="onTE($event)" x-init="$nextTick(() => fit())">
            <div id="canvas">

                <!-- ══ UPPER SECTION ══ -->
                <div class="text-[9px] font-bold tracking-widest text-gray-400 uppercase mb-1">Upper Section</div>

                <template x-for="row in upperRows" :key="row.id">
                    <div class="mrow">
                        <span class="rlabel" x-text="row.id"></span>
                        <template x-for="s in row.left" :key="'UL'+row.id+s">
                            <button :class="sc(row.id,'L',s)" @pointerup.stop="tap(row.id,'L',s,$event)" x-text="s" :title="`Row ${row.id} · ${s}`"></button>
                        </template>
                        <div class="caisle"></div>
                        <template x-for="s in row.right" :key="'UR'+row.id+s">
                            <button :class="sc(row.id,'R',s)" @pointerup.stop="tap(row.id,'R',s,$event)" x-text="s" :title="`Row ${row.id} · ${s}`"></button>
                        </template>
                        <span class="rlabel" x-text="row.id"></span>
                    </div>
                </template>

                <!-- Exit row -->
                <div class="flex items-center justify-center gap-3 my-2">
                    <span class="text-[8px] font-bold text-red-400 tracking-widest">EXIT</span>
                    <span class="text-red-300 text-[10px]">▲</span>
                    <span class="text-red-300 text-[10px]">▲</span>
                    <span class="text-red-300 text-[10px]">▲</span>
                    <span class="text-red-300 text-[10px]">▲</span>
                    <span class="text-[8px] font-bold text-red-400 tracking-widest">EXIT</span>
                </div>

                <!-- ══ LOWER SECTION ══ -->
                <div class="text-[9px] font-bold tracking-widest text-gray-400 uppercase mb-1">Lower Section</div>

                <template x-for="row in lowerRows" :key="row.id">
                    <div class="mrow">
                        <span class="rlabel" x-text="row.id"></span>
                        <template x-for="s in row.left" :key="'LL'+row.id+s">
                            <button :class="sc(row.id,'L',s)" @pointerup.stop="tap(row.id,'L',s,$event)" x-text="s" :title="`Row ${row.id} · ${s}`"></button>
                        </template>
                        <div class="aisle"></div>
                        <template x-for="s in row.centre" :key="'LC'+row.id+s">
                            <button :class="sc(row.id,'C',s)" @pointerup.stop="tap(row.id,'C',s,$event)" x-text="s" :title="`Row ${row.id} · ${s}`"></button>
                        </template>
                        <div class="aisle"></div>
                        <template x-for="s in row.right" :key="'LR'+row.id+s">
                            <button :class="sc(row.id,'R',s)" @pointerup.stop="tap(row.id,'R',s,$event)" x-text="s" :title="`Row ${row.id} · ${s}`"></button>
                        </template>
                        <span class="rlabel" x-text="row.id"></span>
                    </div>
                </template>

                <!-- Stage -->
                <div class="mt-4 w-full">
                    <div class="flex justify-between text-[8px] text-gray-300 tracking-widest uppercase mb-1 px-1">
                        <span>Stairs</span><span>Stage Entrance</span><span>Stairs</span>
                    </div>
                    <div class="bg-gray-200 border border-gray-300 rounded text-center py-2.5 text-xs font-bold tracking-[0.4em] text-gray-400 uppercase w-full">
                        STAGE
                    </div>
                </div>

            </div><!-- /canvas -->
        </div><!-- /vp -->

        <!-- Hint -->
        <p class="absolute bottom-2 left-1/2 -translate-x-1/2 text-[9px] text-gray-400 whitespace-nowrap pointer-events-none select-none">
            <span class="hidden sm:inline">Scroll to zoom · Drag to pan</span>
            <span class="inline sm:hidden">Pinch to zoom · Drag to pan</span>
        </p>
    </div>

    <!-- BOOKING BAR -->
    <div class=" bg-white border-t border-gray-200 px-3 py-2 flex items-center gap-2 shadow-[0_-1px_4px_rgba(0,0,0,0.06)]">
        <div class="flex flex-wrap gap-1.5 flex-1 min-w-0 items-center">
            <template x-if="selected.length === 0">
                <span class="text-xs text-gray-400 italic">No seats selected — tap a green seat</span>
            </template>
            <template x-for="k in selected" :key="k">
                <span class="chip" @click="removeKey(k)" :title="'Remove ' + label(k)">
                    <span x-text="label(k)"></span>
                    <span class="text-[10px] leading-none opacity-60">✕</span>
                </span>
            </template>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <button @click="clearAll()" class="text-xs font-medium border border-gray-300 text-gray-500 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                Clear
            </button>
            <form hx-post="<?= url('/events/' . $eventData['id'] . '/reserve/') ?>" class="mb-0">
                <input type="hidden" name="seats" :value="selected.join(',')">
                <?= csrf_input() ?>
                <button :disabled="selected.length === 0 || selected.length > 6" class="text-xs font-bold bg-green-500 h-full text-gray-900 px-4 py-1.5 rounded-lg hover:bg-green-400 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    Next Step
                </button>
            </form>
        </div>
    </div>

    <!-- TOAST -->
    <div x-show="toast" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0" class="fixed bottom-16 right-4 bg-green-600 text-white text-xs font-medium px-4 py-2.5 rounded-lg shadow-lg z-50" x-text="toast">
    </div>

</div><!-- /x-data -->

<script>
    function app() {

        /* ── seat data ── */
        const takenSet = new Set(<?= json_encode($reservedSeats ?? []) ?>);

        function rng(from, to, step = 1) {
            const a = []
            for (let i = from; step > 0 ? i <= to : i >= to; i += step) a.push(i)
            return a
        }

        const upperRows = [
            { id: 'N', leftMax: 22, rightMax: 21 },
            { id: 'M', leftMax: 24, rightMax: 23 },
            { id: 'L', leftMax: 28, rightMax: 27 },
            { id: 'K', leftMax: 30, rightMax: 29 },
            { id: 'J', leftMax: 32, rightMax: 31 },
            { id: 'H', leftMax: 34, rightMax: 33 },
        ].map(r => ({ id: r.id, left: rng(r.leftMax, 2, -2), right: rng(1, r.rightMax, 2) }))

        const lowerRows = [
            { id: 'G', leftMax: 22, cMax: 120, rightMax: 21 },
            { id: 'F', leftMax: 20, cMax: 119, rightMax: 19 },
            { id: 'E', leftMax: 20, cMax: 118, rightMax: 19 },
            { id: 'D', leftMax: 20, cMax: 117, rightMax: 19 },
            { id: 'C', leftMax: 20, cMax: 116, rightMax: 19 },
            { id: 'B', leftMax: 20, cMax: 115, rightMax: 19 },
            { id: 'A', leftMax: 18, cMax: 114, rightMax: 17 },
        ].map(r => ({ id: r.id, left: rng(r.leftMax, 2, -2), centre: rng(101, r.cMax), right: rng(1, r.rightMax, 2) }))

        return {
            upperRows, lowerRows,
            taken: takenSet,
            selected: [],
            toast: '', _tt: null,

            /* ── pan/zoom state ── */
            scale: 1, tx: 0, ty: 0,
            panning: false,
            _ps: null,          // pan start offset
            _didMove: false,    // distinguishes tap from drag
            _pinchD: null,      // pinch start distance
            _pinchS: null,      // pinch start scale
            MIN_S: 0.25, MAX_S: 4,

            vp() { return document.getElementById('vp') },
            canvas() { return document.getElementById('canvas') },

            /* snap to integer pixels to keep text crisp */
            apply() {
                const c = this.canvas()
                if (!c) return
                const x = Math.round(this.tx)
                const y = Math.round(this.ty)
                c.style.transform = `translate(${x}px,${y}px) scale(${this.scale})`
            },

            fit() {
                this.$nextTick(() => {
                    const vp = this.vp(), c = this.canvas()
                    if (!vp || !c) return
                    const vw = vp.clientWidth, vh = vp.clientHeight
                    const cw = c.scrollWidth, ch = c.scrollHeight
                    const s = Math.min(vw / cw, vh / ch, 1)
                    this.scale = s
                    this.tx = Math.round((vw - cw * s) / 2)
                    this.ty = Math.round((vh - ch * s) / 2)
                    this.apply()
                })
            },

            zoomBy(delta, cx, cy) {
                const vp = this.vp()
                cx = cx ?? vp.clientWidth / 2
                cy = cy ?? vp.clientHeight / 2
                const ns = Math.min(this.MAX_S, Math.max(this.MIN_S, this.scale + delta))
                const r = ns / this.scale
                this.tx = Math.round(cx - r * (cx - this.tx))
                this.ty = Math.round(cy - r * (cy - this.ty))
                this.scale = ns
                this.apply()
            },

            onWheel(e) {
                const r = this.vp().getBoundingClientRect()
                const cx = e.clientX - r.left
                const cy = e.clientY - r.top
                /* use scale multiplier for smoother trackpad feel */
                const factor = e.deltaY < 0 ? 0.12 : -0.12
                this.zoomBy(factor, cx, cy)
            },

            /* ── mouse pan ── */
            onMD(e) {
                if (e.button !== 0) return
                this.panning = true
                this._didMove = false
                this._ps = { x: e.clientX - this.tx, y: e.clientY - this.ty }
            },
            onMM(e) {
                if (!this.panning) return
                const nx = e.clientX - this._ps.x
                const ny = e.clientY - this._ps.y
                if (Math.abs(nx - this.tx) > 3 || Math.abs(ny - this.ty) > 3) this._didMove = true
                this.tx = nx; this.ty = ny
                this.apply()
            },
            onMU() { this.panning = false },

            /* ── touch pan + pinch ── */
            _td(touches) {
                const dx = touches[0].clientX - touches[1].clientX
                const dy = touches[0].clientY - touches[1].clientY
                return Math.sqrt(dx * dx + dy * dy)
            },
            _tm(touches, rect) {
                return {
                    x: (touches[0].clientX + touches[1].clientX) / 2 - rect.left,
                    y: (touches[0].clientY + touches[1].clientY) / 2 - rect.top,
                }
            },

            onTS(e) {
                if (e.touches.length === 1) {
                    this.panning = true
                    this._didMove = false
                    this._pinchD = null
                    this._ps = { x: e.touches[0].clientX - this.tx, y: e.touches[0].clientY - this.ty }
                } else if (e.touches.length === 2) {
                    this.panning = false
                    this._pinchD = this._td(e.touches)
                    this._pinchS = this.scale
                }
            },
            onTM(e) {
                if (e.touches.length === 1 && this.panning && !this._pinchD) {
                    const nx = e.touches[0].clientX - this._ps.x
                    const ny = e.touches[0].clientY - this._ps.y
                    if (Math.abs(nx - this.tx) > 4 || Math.abs(ny - this.ty) > 4) this._didMove = true
                    this.tx = nx; this.ty = ny
                    this.apply()
                } else if (e.touches.length === 2 && this._pinchD !== null) {
                    const vp = this.vp()
                    const rect = vp.getBoundingClientRect()
                    const d = this._td(e.touches)
                    const mid = this._tm(e.touches, rect)
                    const ns = Math.min(this.MAX_S, Math.max(this.MIN_S, this._pinchS * (d / this._pinchD)))
                    const r = ns / this.scale
                    this.tx = Math.round(mid.x - r * (mid.x - this.tx))
                    this.ty = Math.round(mid.y - r * (mid.y - this.ty))
                    this.scale = ns
                    this.apply()
                }
            },
            onTE(e) {
                if (e.touches.length < 2) this._pinchD = null
                if (e.touches.length === 0) this.panning = false
            },

            /* ── seat interaction ──
               Use pointerup instead of click so it fires on mobile too.
               Suppress if the user was panning (dragged more than 6px). */
            tap(row, sec, seat, e) {
                e.stopPropagation()
                if (this._didMove) return   // was a drag, not a tap
                if (this.taken.has(this.k(row, seat))) return
                if (this.selected.length >= 6 && !this.isSel(row, seat)) {
                    this.showToast('You can only select up to 6 seats.')
                    return
                }
                const k = this.k(row, seat)
                const i = this.selected.indexOf(k)
                i === -1 ? this.selected.push(k) : this.selected.splice(i, 1)
            },

            /* ── helpers ── */
            k(row, seat) { return `${row}${seat}` },
            isTaken(r, n) { return this.taken.has(this.k(r, n)) },
            isSel(r, n) { return this.selected.includes(this.k(r, n)) },
            sc(r, s, n) {
                if (this.isTaken(r, n)) return 'seat s-taken'
                if (this.isSel(r, n)) return 'seat s-selected'
                return 'seat s-available'
            },
            label(k) {
                return k
            },

            removeKey(k) { const i = this.selected.indexOf(k); if (i > -1) this.selected.splice(i, 1) },
            clearAll() { this.selected = [] },
            confirm() {
                if (!this.selected.length) return
                const n = this.selected.length
                this.selected.forEach(k => this.taken.add(k))
                this.selected = []
                this.showToast(`✓ ${n} seat${n > 1 ? 's' : ''} booked!`)
            },
            showToast(msg) {
                this.toast = msg
                clearTimeout(this._tt)
                this._tt = setTimeout(() => this.toast = '', 3000)
            },
        }
    }
</script>