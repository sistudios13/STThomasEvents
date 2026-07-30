<?php
// --- Build "Add to Calendar" links (ICS download + Google/Outlook/Office365/Yahoo) ---
$tzEvent = new DateTimeZone('America/New_York');
$tzUtc = new DateTimeZone('UTC');
 
$dtStartLocal = new DateTime($data['Events.StartsAt'], $tzEvent);
$dtEndLocal = new DateTime($data['Events.EndsAt'], $tzEvent);
$dtStartUtc = (clone $dtStartLocal)->setTimezone($tzUtc);
$dtEndUtc = (clone $dtEndLocal)->setTimezone($tzUtc);
 
$calTitle = $data['Events.Name'];
$calLocation = $data['Events.Location'];
$calDescription = $data['Events.Description'];
 
function icsEscape(string $text): string
{
    $text = str_replace(['\\', ';', ',', "\r\n", "\n"], ['\\\\', '\\;', '\\,', '\\n', '\\n'], $text);
    return $text;
}
 
$icsUrl = url('/tickets/' . $code . '/calendar/');
 
// Google Calendar
$googleUrl = 'https://calendar.google.com/calendar/render?' . http_build_query([
    'action' => 'TEMPLATE',
    'text' => $calTitle,
    'dates' => $dtStartUtc->format('Ymd\THis\Z') . '/' . $dtEndUtc->format('Ymd\THis\Z'),
    'details' => $calDescription,
    'location' => $calLocation,
]);
 
// Outlook.com
$outlookUrl = 'https://outlook.live.com/calendar/0/deeplink/compose?' . http_build_query([
    'path' => '/calendar/action/compose',
    'rru' => 'addevent',
    'subject' => $calTitle,
    'startdt' => $dtStartLocal->format(DateTime::ATOM),
    'enddt' => $dtEndLocal->format(DateTime::ATOM),
    'body' => $calDescription,
    'location' => $calLocation,
]);
 
// Office 365
$office365Url = 'https://outlook.office.com/calendar/0/deeplink/compose?' . http_build_query([
    'path' => '/calendar/action/compose',
    'rru' => 'addevent',
    'subject' => $calTitle,
    'startdt' => $dtStartLocal->format(DateTime::ATOM),
    'enddt' => $dtEndLocal->format(DateTime::ATOM),
    'body' => $calDescription,
    'location' => $calLocation,
]);
 
// Yahoo Calendar
$yahooDiff = $dtStartLocal->diff($dtEndLocal);
$yahooDuration = sprintf('%02d%02d', ($yahooDiff->days * 24) + $yahooDiff->h, $yahooDiff->i);
$yahooUrl = 'https://calendar.yahoo.com/?' . http_build_query([
    'v' => 60,
    'view' => 'd',
    'type' => 20,
    'title' => $calTitle,
    'st' => $dtStartLocal->format('Ymd\THis'),
    'dur' => $yahooDuration,
    'desc' => $calDescription,
    'in_loc' => $calLocation,
]);
?> 

<div class="items-start grid grid-cols-1 lg:grid-cols-2 gap-12 w-full ">
    <div class="flex flex-col gap-8 overflow-visible">

        <!-- Header -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">My Tickets</h1>
            <p class="text-gray-600 text-pretty leading-relaxed">
                Hi, <span class="font-semibold text-gray-900"><?= htmlspecialchars($data['Name']) ?></span>! You can view your seats and tickets below.
            </p>
            <div class="mt-3 inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium rounded-lg px-3 py-2">
                <svg class="size-4 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                Payment takes place at the door — cash only!
            </div>
        </div>

        <!-- Event Details Card -->
        <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Event Details</h2>

            <div class="flex flex-col gap-4">

                <!-- Event name -->
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 9H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h6m0-6v6m0-6 5.419-3.87A1 1 0 0 1 18 5.942v12.114a1 1 0 0 1-1.581.814L11 15m7 0a3 3 0 0 0 0-6M6 15h3v5H6v-5Z" />
                    </svg>


                    <div>
                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Event</p>
                        <p class="text-gray-900 font-medium"><?= htmlspecialchars($data['Events.Name']) ?></p>
                    </div>
                </div>

                <!-- Location -->
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-700 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                    </svg>

                    <div>
                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Location</p>
                        <p class="text-gray-900 font-medium"><?= htmlspecialchars($data['Events.Location']) ?></p>
                    </div>
                </div>

                <?php
                $starts = strtotime($data['Events.StartsAt']);
                $ends = strtotime($data['Events.EndsAt']);

                // Build a duration string
                $diffMinutes = max(0, round(($ends - $starts) / 60));
                $hours = intdiv($diffMinutes, 60);
                $minutes = $diffMinutes % 60;
                $durationParts = [];
                if ($hours > 0)
                    $durationParts[] = $hours . ' hr' . ($hours > 1 ? 's' : '');
                if ($minutes > 0)
                    $durationParts[] = $minutes . ' min';
                $duration = implode(' ', $durationParts) ?: '—';

                // show date for end time if same day
                $sameDay = date('Y-m-d', $starts) === date('Y-m-d', $ends);
                ?>

                <!-- Date & Time -->
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-700 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                    </svg>

                    <div>
                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Date & Time</p>
                        <p class="text-gray-900 font-medium"><?= date('l, F j, Y', $starts) ?></p>
                        <p class="text-gray-600 text-sm">
                            <?php if ($sameDay): ?>
                                <?= date('g:i A', $starts) ?> – <?= date('g:i A', $ends) ?>
                            <?php else: ?>
                                <?= date('g:i A', $starts) ?> – <?= date('M j, g:i A', $ends) ?>
                            <?php endif; ?>
                            <span class="text-gray-400">(<?= $duration ?>)</span>
                        </p>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-700 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17.345a4.76 4.76 0 0 0 2.558 1.618c2.274.589 4.512-.446 4.999-2.31.487-1.866-1.273-3.9-3.546-4.49-2.273-.59-4.034-2.623-3.547-4.488.486-1.865 2.724-2.899 4.998-2.31.982.236 1.87.793 2.538 1.592m-3.879 12.171V21m0-18v2.2" />
                    </svg>

                    <div class="w-full">
                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-400 mb-1">Pricing</p>
                        <div class="flex flex-col gap-1.5">
                            <?php
                            $prices = json_decode($data['Events.Price'], true);
                            foreach ($prices as $type => $price): ?>
                                <div class="flex justify-between items-center bg-gray-50 rounded-,d px-3 py-1.5">
                                    <span class="text-gray-600 text-sm"><?= htmlspecialchars($type) ?></span>
                                    <span class="font-semibold text-gray-900">$<?= htmlspecialchars($price) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Add to Calendar -->
            <div class="relative mt-6" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                <button
                    type="button"
                    @click="open = !open"
                    :aria-expanded="open"
                    class="w-full flex gap-2 items-center justify-center py-2.5 bg-green-600 shadow-sm text-white rounded-md hover:bg-green-700 transition-colors font-medium text-sm"
                >
                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4 9.05H3v2h1v-2Zm16 2h1v-2h-1v2ZM10 14a1 1 0 1 0 0 2v-2Zm4 2a1 1 0 1 0 0-2v2Zm-3 1a1 1 0 1 0 2 0h-2Zm2-4a1 1 0 1 0-2 0h2Zm-2-5.95a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-7 3a1 1 0 0 0 2 0H6Zm2-3a1 1 0 1 0-2 0h2Zm8 3a1 1 0 1 0 2 0h-2Zm2-3a1 1 0 1 0-2 0h2Zm-13 3h14v-2H5v2Zm14 0v12h2v-12h-2Zm0 12H5v2h14v-2Zm-14 0v-12H3v12h2Zm0 0H3a2 2 0 0 0 2 2v-2Zm14 0v2a2 2 0 0 0 2-2h-2Zm0-12h2a2 2 0 0 0-2-2v2Zm-14-2a2 2 0 0 0-2 2h2v-2Zm-1 6h16v-2H4v2ZM10 16h4v-2h-4v2Zm3 1v-4h-2v4h2Zm0-9.95v-3h-2v3h2Zm-5 0v-3H6v3h2Zm10 0v-3h-2v3h2Z" />
                    </svg>
                    Add to Calendar
                    <svg class="w-4 h-4 ml-0.5 transition-transform" :class="open && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                    </svg>
                </button>
 
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak
                    @click="open = false"
                    class="absolute left-0 right-0 mt-2 bg-white border border-gray-100 rounded-md shadow-lg  z-10"
                >
                    <a href="<?= htmlspecialchars($icsUrl) ?>"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                        <span class="w-2 h-2 rounded-full bg-gray-400 flex-shrink-0"></span>
                        Apple Calendar / Download ICS
                    </a>
                    <a href="<?= htmlspecialchars($googleUrl) ?>" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 border-t border-gray-100">
                        <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                        Google Calendar
                    </a>
                    <a href="<?= htmlspecialchars($outlookUrl) ?>" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 border-t border-gray-100">
                        <span class="w-2 h-2 rounded-full bg-sky-500 flex-shrink-0"></span>
                        Outlook.com
                    </a>
                    <a href="<?= htmlspecialchars($office365Url) ?>" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 border-t border-gray-100">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0"></span>
                        Office 365
                    </a>
                    <a href="<?= htmlspecialchars($yahooUrl) ?>" target="_blank" rel="noopener"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 border-t border-gray-100">
                        <span class="w-2 h-2 rounded-full bg-purple-500 flex-shrink-0"></span>
                        Yahoo Calendar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-[720px] w-full min-w-0" hx-vals="js:{code: '<?= $code ?>', _csrf : '<?= csrf_token() ?>'}" hx-post="<?= url('/partials/tickets/' . $code . '/home-seats/') ?>" hx-trigger="load, refresh-list from:body" hx-swap="innerHTML">
        <div id="seats-container" class="col-span-3">
            <p class="text-gray-600">Loading seats...</p>
        </div>
    </div>
</div>