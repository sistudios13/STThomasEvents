<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">Dashboard</h1>
            <p class="max-w-2xl text-sm text-gray-500">Keep an eye on upcoming activity, bookings, and your event calendar from one place.</p>
        </div>
        <div class="flex flex-wrap sm:justify-end items-center gap-2">
            <a href="<?= url('/staff/events/new/') ?>" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                <svg class="size-5 mr-1 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                </svg>

                Create event</a>
            <a href="<?= url('/staff/events/') ?>" class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">View all events</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="space-y-6">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-gray-500">Upcoming events</p>
                    </div>
                    <p class="mt-4 text-3xl font-semibold tracking-tight text-gray-900"><?= $upcomingCount ?? '—' ?></p>
                    <p class="mt-2 text-sm text-gray-500">Events scheduled in the next 30 days.</p>
                </div>

                <div class="rounded-lg border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-gray-500">Total bookings</p>
                    </div>
                    <p class="mt-4 text-3xl font-semibold tracking-tight text-gray-900"><?= $stats['bookings'] ?? '—' ?></p>
                    <p class="mt-2 text-sm text-gray-500">Reservations recorded across events.</p>
                </div>
            </div>

            <section class="rounded-lg border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold tracking-tight text-gray-900">Upcoming events</h2>
                        <p class="mt-1 text-sm text-gray-500">A quick view of upcoming events.</p>
                    </div>
                    <a href="<?= url('/staff/events/') ?>" class="text-sm font-medium text-indigo-600 transition hover:text-indigo-700">View all</a>
                </div>

                <?php if (!empty($upcomingEvents)): ?>
                    <ul class="mt-5 space-y-3">
                        <?php foreach ($upcomingEvents as $e): ?>
                            <li class="flex flex-col gap-3 rounded-md border border-gray-100 bg-gray-50 p-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-gray-900"><?= htmlspecialchars($e['Name'] ?? 'Untitled') ?></p>
                                    <p class="mt-1 text-sm text-gray-500"><?= htmlspecialchars(date('M j, Y g:i A', strtotime($e['StartsAt'])) ?? '') ?></p>
                                </div>
                                <a href="<?= url('/staff/events/' . $e['Id'] . '/') ?>" class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">Manage</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="mt-5 rounded-lg border border-dashed border-gray-200 bg-gray-50 p-4 text-sm text-gray-500">No upcoming events to show right now.</div>
                <?php endif; ?>
            </section>
        </div>

        <div x-data="bentoCalendar()" x-cloak class="flex flex-col select-none rounded-lg border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Calendar</p>
                    <p class="mt-1 text-base font-semibold text-gray-900" x-text="monthLabel"></p>
                </div>
                <div class="flex items-center gap-1">
                    <button @click="prevMonth()" class="flex h-8 w-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-100 hover:text-gray-700" aria-label="Previous month">‹</button>
                    <button @click="goToday()" class="rounded-md px-2.5 py-1 text-xs font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-700">Today</button>
                    <button @click="nextMonth()" class="flex h-8 w-8 items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-100 hover:text-gray-700" aria-label="Next month">›</button>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-7">
                <template x-for="(d, idx) in weekdays" :key="idx">
                    <div class="py-1 text-center text-[10px] font-semibold uppercase tracking-[0.2em] text-gray-400" x-text="d"></div>
                </template>
            </div>

            <div class="mt-1 grid grid-cols-7 gap-1">
                <template x-for="(cell, i) in cells" :key="i">
                    <div class="flex items-center justify-center">
                        <template x-if="cell">
                            <button @click="selectDay(cell)" class="relative flex h-9 w-9 items-center justify-center rounded-md text-sm transition" :class="{
                                'bg-gray-900 text-white font-semibold': isSelected(cell),
                                'text-gray-700 hover:bg-gray-100': !isSelected(cell) && !isToday(cell),
                                'bg-gray-50 text-gray-900 ring-1 ring-gray-200': isToday(cell) && !isSelected(cell)
                            }">
                                <span x-text="cell.day"></span>
                                <span class="absolute bottom-1 flex gap-0.5" x-show="eventsFor(cell).length > 0">
                                    <template x-for="(ev, idx) in eventsFor(cell).slice(0,3)" :key="idx">
                                        <span class="h-1 w-1 rounded-full" :class="isSelected(cell) ? 'bg-white/80' : dotColor(ev.color)"></span>
                                    </template>
                                </span>
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            <div class="mt-4 border-t border-gray-100 pt-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-400" x-text="selectedLabel"></p>

                <div class="mt-3 flex min-h-[8rem] flex-col gap-2 overflow-y-auto pr-1">
                    <template x-if="selectedEvents.length === 0">
                        <p class="rounded-md border border-dashed border-gray-200 bg-gray-50 px-3 py-3 text-sm text-gray-400">No events scheduled.</p>
                    </template>

                    <template x-for="ev in selectedEvents" :key="ev.title + ev.time">
                        <div class="flex items-start gap-2 rounded-md border border-gray-100 bg-gray-50 px-3 py-2.5">
                            <span class="mt-1 h-2 w-2 shrink-0 rounded-full" :class="dotColor(ev.color)"></span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-gray-700" x-text="ev.title"></p>
                                <p class="mt-0.5 text-xs text-gray-500" x-text="ev.time"></p>
                            </div>
                            <a :href="'<?= url('/staff/events/') ?>' + ev.eventId + '/'" class="text-xs font-medium text-indigo-600 my-auto transition hover:text-indigo-700">Manage</a>
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
            events: <?= json_encode($events) ?>,
            today: new Date(),
            viewDate: new Date(),
            selected: null,
            weekdays: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],

            init() {
                this.selected = { year: this.today.getFullYear(), month: this.today.getMonth() + 1, day: this.today.getDate() };
            },

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