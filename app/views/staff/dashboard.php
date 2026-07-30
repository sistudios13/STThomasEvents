<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Staff Dashboard</h1>
        <div class="flex items-center gap-3">
            <a href="<?= url('/staff/events/new/') ?>" class="inline-flex items-center gap-2 rounded bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700">+ Create Event</a>
            <a href="<?= url('/staff/events/') ?>" class="inline-flex items-center gap-2 rounded border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">All Events</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
        <div class="grid grid-cols-1 gap-4 sm:gap-6">
            <!-- Top stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="p-4 bg-white border border-gray-100 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Upcoming events</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900"><?= $upcomingCount ?? '—' ?></div>
                </div>
                <div class="p-4 bg-white border border-gray-100 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Total bookings</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900"><?= $stats['bookings'] ?? '—' ?></div>
                </div>
            </div>
            <div class="grid grid-cols-1">
                <!-- Upcoming events / quick actions -->
                <section class="bg-white rounded-lg border border-gray-100 shadow-sm p-4">
                    <h2 class="text-lg font-medium text-gray-900">Upcoming events</h2>
                    <p class="text-sm text-gray-500 mb-3">Events in the next month</p>
                    <?php if (!empty($upcomingEvents)): ?>
                        <ul class="space-y-2">
                            <?php foreach ($upcomingEvents as $e): ?>
                                <li class="flex items-center justify-between p-2 border border-gray-100 rounded-md">
                                    <div>
                                        <div class="font-medium text-gray-900"><?= htmlspecialchars($e['Name'] ?? 'Untitled') ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars(date('M j, Y g:i A', strtotime($e['StartsAt'])) ?? '') ?></div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="<?= url('/staff/events/' . $e['Id'] . '/') ?>" class="text-xs text-indigo-600 hover:underline">Manage</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-sm text-gray-500">No upcoming events.</div>
                    <?php endif; ?>
                </section>

            </div>
        </div>
        <div x-data="bentoCalendar()" x-cloak class=" bg-white rounded-lg border border-gray-100 shadow-sm p-4 flex flex-col select-none">
            <!-- Header -->
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-semibold text-gray-800" x-text="monthLabel"></p>
                <div class="flex items-center gap-1">
                    <button @click="prevMonth()" class="w-6 h-6 flex items-center justify-center rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6" />
                        </svg>
                    </button>
                    <button @click="goToday()" class="text-[10px] font-medium text-gray-400 hover:text-gray-700 px-1.5 py-0.5 rounded-md hover:bg-gray-100 transition">today</button>
                    <button @click="nextMonth()" class="w-6 h-6 flex items-center justify-center rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Weekday labels -->
            <div class="grid grid-cols-7 mb-1">
                <template x-for="(d, idx) in weekdays" :key="idx">
                    <div class="text-center text-[10px] font-medium text-gray-400 py-1" x-text="d"></div>
                </template>
            </div>

            <!-- Day grid -->
            <div class="grid grid-cols-7 gap-y-1">
                <template x-for="(cell, i) in cells" :key="i">
                    <div class="flex items-center justify-center">
                        <template x-if="cell">
                            <button @click="selectDay(cell)" class="relative w-8 h-8 flex flex-col items-center justify-center rounded-md text-xs transition" :class="{
                'bg-gray-800 text-white font-semibold hover:bg-gray-700': isSelected(cell),
                'text-gray-700 hover:bg-gray-100': !isSelected(cell) && !isToday(cell),
                'text-gray-800 font-semibold ring-1 ring-gray-300 hover:bg-gray-100': isToday(cell) && !isSelected(cell)
              }">
                                <span x-text="cell.day"></span>
                                <!-- event dots -->
                                <span class="absolute bottom-1 flex gap-0.5" x-show="eventsFor(cell).length > 0">
                                    <template x-for="(ev, idx) in eventsFor(cell).slice(0,3)" :key="idx">
                                        <span class="w-1 h-1 rounded-full" :class="isSelected(cell) ? 'bg-white/80' : dotColor(ev.color)"></span>
                                    </template>
                                </span>
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-100 my-3"></div>

            <!-- Selected day events panel -->
            <div class="flex-1 min-h-0 flex flex-col">
                <p class="text-[11px] font-medium text-gray-400 mb-2" x-text="selectedLabel"></p>

                <div class="flex-1 overflow-y-auto space-y-1.5 pr-1" style="max-height: 9rem;">
                    <template x-if="selectedEvents.length === 0">
                        <p class="text-xs text-gray-300 h-[43px] italic py-2">No events</p>
                    </template>

                    <template x-for="ev in selectedEvents" :key="ev.title + ev.time">
                        <div class="flex items-start gap-2 bg-gray-50 rounded-md px-2.5 py-1.5">
                            <span class="w-1.5 h-1.5 rounded-full mt-1 shrink-0" :class="dotColor(ev.color)"></span>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-gray-700 truncate" x-text="ev.title"></p>
                                <p class="text-[10px] text-gray-400" x-text="ev.time"></p>
                            </div>
                            <div class="ml-auto">
                                <a :href="'<?= url('/staff/events/') ?>' + ev.eventId + '/'" class="text-[10px] text-indigo-600 hover:underline">Manage</a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function bentoCalendar() {
        return {

            // events: {
            //     '2026-7-3': [{ title: 'Variety Show', time: '7:00 PM', color: 'blue', eventId: 1 }],
            // },

            events: <?= json_encode($events) ?>,

            // ----------------------------------------------------------------
            // state
            // ----------------------------------------------------------------
            today: new Date(),
            viewDate: new Date(),
            selected: null,
            weekdays: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],

            init() {
                this.selected = { year: this.today.getFullYear(), month: this.today.getMonth() + 1, day: this.today.getDate() };
            },

            // ----------------------------------------------------------------
            // computed-ish helpers
            // ----------------------------------------------------------------
            get monthLabel() {
                return this.viewDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            },

            get cells() {
                const year = this.viewDate.getFullYear();
                const month = this.viewDate.getMonth();
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                const cells = [];
                for (let i = 0; i < firstDay; i++) cells.push(null);
                for (let d = 1; d <= daysInMonth; d++) {
                    cells.push({ year, month: month + 1, day: d });
                }
                return cells;
            },

            get selectedLabel() {
                if (!this.selected) return '';
                const d = new Date(this.selected.year, this.selected.month - 1, this.selected.day);
                return d.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
            },

            get selectedEvents() {
                if (!this.selected) return [];
                return this.eventsFor(this.selected);
            },

            // ----------------------------------------------------------------
            // methods
            // ----------------------------------------------------------------
            key(cell) {
                return `${cell.year}-${cell.month}-${cell.day}`;
            },

            eventsFor(cell) {
                return this.events[this.key(cell)] || [];
            },

            isToday(cell) {
                return cell.year === this.today.getFullYear()
                    && cell.month === this.today.getMonth() + 1
                    && cell.day === this.today.getDate();
            },

            isSelected(cell) {
                return this.selected
                    && cell.year === this.selected.year
                    && cell.month === this.selected.month
                    && cell.day === this.selected.day;
            },

            selectDay(cell) {
                this.selected = cell;
            },

            prevMonth() {
                this.viewDate = new Date(this.viewDate.getFullYear(), this.viewDate.getMonth() - 1, 1);
            },

            nextMonth() {
                this.viewDate = new Date(this.viewDate.getFullYear(), this.viewDate.getMonth() + 1, 1);
            },

            goToday() {
                this.viewDate = new Date(this.today.getFullYear(), this.today.getMonth(), 1);
                this.selected = { year: this.today.getFullYear(), month: this.today.getMonth() + 1, day: this.today.getDate() };
            },

            dotColor(name) {
                const map = {
                    blue: 'bg-blue-400',
                    green: 'bg-emerald-400',
                    amber: 'bg-amber-400',
                    rose: 'bg-rose-400',
                    violet: 'bg-violet-400',
                    teal: 'bg-teal-400',
                };
                return map[name] || 'bg-gray-400';
            },
        }
    }
</script>