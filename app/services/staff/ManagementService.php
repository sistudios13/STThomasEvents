<?php

declare(strict_types=1);

namespace App\Staff\Services;

use App\Repositories\EventRepository;
use App\Staff\Repositories\ManagementRepository;
use App\Services\EmailService;
use App\Config\Settings;
use Respect\Validation\Validator as v;

class ManagementService
{
    private EventRepository $eventRepository;
    private ManagementRepository $managementRepository;
    private EmailService $emailService;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->emailService = new EmailService();
        $this->managementRepository = new ManagementRepository();
    }

    public function getCalendarData(): ?array
    {
        $data = $this->eventRepository->findAll();

        $grouped = [];
        
        if (empty($data)) {
            return [];
        }

        foreach ($data as $event) {
            $startsAt = strtotime($event['StartsAt']);

            // format '2026-7-3' 
            $dateKey = date('Y-n-j', $startsAt);

            $grouped[$dateKey][] = [
                'title' => $event['Name'],
                'time' => date('g:i A', $startsAt),
                'color' => 'blue',
                'eventId' => $event['Id'],
            ];
        }

        return $grouped;
    }

    public function getUpcomingEvents(): ?array
    {
        $eventsArray = $this->eventRepository->findAllCurrent();
        $now = time();
        $oneMonth = strtotime('+1 month', $now);

        if (empty($eventsArray)) {
            return [];
        }
        $filtered = array_filter($eventsArray, function ($event) use ($now, $oneMonth) {
            $startsAt = strtotime($event['EndsAt']);
            return $startsAt >= $now && $startsAt <= $oneMonth;
        });

        return $filtered ?: [];
    }

    public function getGroupedEvents(): ?array // groups by passed, ongoing or future
    {
        $data = $this->eventRepository->findAll();

        if (empty($data)) {
            return [];
        }

        $now = strtotime('now');

        $grouped  = [
            'passed' => [],
            'ongoing' => [],
            'future' => []
        ];



        foreach ($data as $event) {

            if (strtotime($event['EndsAt']) < $now) {
                // array_push($grouped['passed'], $event); 
                $grouped['passed'][] = $event;
            } elseif (strtotime($event['StartsAt']) > $now) {
                // array_push($grouped['future'], $event);
                $grouped['future'][] = $event;
            } else {
                // array_push($grouped['ongoing'], $event);
                $grouped['ongoing'][] = $event;
            }
        }

        return $grouped ?: null;
    }

    public function findEventById(int $event_id): ?array
    {
        return $this->managementRepository->findEventById($event_id); //no time restrictions
    }

    public function getBookings(int $event_id, int $page = 1, ?string $search = '', ?string $sort_key = '', ?string $sort_order = ''): ?array
    {
        //values are already validated
        return $this->managementRepository->getBookings($event_id, $page, $search, $sort_key, $sort_order);
    }

    public function getInfoAndValidate(int $event_id, int $page, string $search, string $sort_key, string $sort_order): ?array
    {

        if (!v::length(0, 255)->validate($search)) {
            throw new \InvalidArgumentException("Search term must be between 1 and 255 characters.");
        }

        if (empty($search)) {
            $search = null;
        }



        

        if (!v::in(['email', 'name', 'timestamp', 'id', 'status'])->validate($sort_key)) {
            $sort_key = null;
        }


        if (!v::in(['asc', 'desc'])->validate($sort_order)) {
            $sort_order = null;
        }

        $total_rows = $this->managementRepository->getTotalRows($event_id, $search);

        $info = [];
        $info['total_rows'] = $total_rows;

        $info['total_pages'] = max(1, ceil($info['total_rows'] / Settings::STAFF_TABLE_MAX_ROWS ));
        $info['page_numbers'] = range(1, $info['total_pages']);

        
        if (!v::between(0, $info['total_pages'])->validate($page)) {
            throw new \InvalidArgumentException("Invalid page number.");
        }

        $info['current_page'] = $page;
        $info['sort_key'] = $sort_key;
        $info['sort_order'] = $sort_order;
        $info['search'] = $search;

        return $info;
    }

    public function bookingExists(int $eventId, int $bookingId): bool
    {
        return $this->managementRepository->bookingExists($eventId, $bookingId);
    }

    public function deleteBooking(int $bookingId): bool
    {

        $recipient = $this->managementRepository->getBookingById($bookingId);
        $event = $this->managementRepository->findEventById($recipient['EventId']);
        $deleted = $this->managementRepository->deleteBooking($bookingId);

        if (!$deleted) {
            return false;
        }

        $sent = $this->emailService->sendEmail(
            $recipient['Email'],
            $recipient['Name'], 
            'Your Booking Has Been Deleted',
            "
            <h1>Your Booking Has Been Deleted</h1>
            <p>Hello {$recipient['Name']},</p>
            <p>The event you booked is: {$event['Name']}</p>
            <p>We regret to inform you that your booking for has been deleted/cancelled by school staff. If you have any questions, please visit our support page here: <a href='" . Settings::APP_URL ."support/'>" . Settings::APP_URL ."support/</a></p>
            <p>Best regards,<br>St. Thomas Events Team</p>
            <hr>
            <p style='font-size: 0.8em;'>© " . date('Y') . " St. Thomas Events. All rights reserved.</p>
            "
        );

        if (!$sent) {
            throw new \InvalidArgumentException('Failed to send confirmation email. Please try again later.');
        }
        return true;
    }

    public function createEvent(string $name, string $description, string $pricing, string $starts_at, string $ends_at, string $location, string $seating_enabled): int
    {
        // Validate the data
        if (!v::length(5, 100)->validate($name)) {
            throw new \InvalidArgumentException("Event name must be between 5 and 100 characters.");
        }

        if (!v::length(5, 350)->validate($description)) {
            throw new \InvalidArgumentException("Event description must be between 5 and 350 characters.");
        }

        $pricingData = json_decode($pricing, true);
        if (!\is_array($pricingData)) {
            throw new \InvalidArgumentException("Event pricing is invalid.");
        }

        $tierNames = array_keys($pricingData);

        if (\count($pricingData) > 10 || \count($tierNames) < 1) {
            throw new \InvalidArgumentException("You can have between 1 and 10 pricing tiers.");
        }

        foreach ($tierNames as $tierName) {
            if (!v::length(1, 50)->validate($tierName)) {
                throw new \InvalidArgumentException("Pricing tier names must be between 1 and 50 characters.");
            }
        }

        $tierPrices = array_values($pricingData);
        foreach ($tierPrices as $tierPrice) {
            if (!v::numericVal()->between(0, 999)->validate($tierPrice)) {
                throw new \InvalidArgumentException("Pricing tier prices must be numeric and greater than or equal to 0.");
            }
        }
        
        // new events must be scheduled for the future
        if (!v::dateTime('Y-m-d\TH:i')->greaterThan(new \DateTime())->validate($starts_at)) {
            throw new \InvalidArgumentException("Event start time is invalid.");
        }

        if (!v::dateTime('Y-m-d\TH:i')->greaterThan(new \DateTime($starts_at))->validate($ends_at)) {
            throw new \InvalidArgumentException("Event end time is invalid.");
        }

        if (!v::length(5, 120)->validate($location)) {
            throw new \InvalidArgumentException("Event location must be between 5 and 120 characters.");
        }

        // Create the event
        return $this->managementRepository->createEvent($name, $description, $pricing, $starts_at, $ends_at, $location, $seating_enabled);
    }

    public function editEvent(string $id, string $name, string $description, string $pricing, string $starts_at, string $ends_at, string $location, string $seating_enabled): void
    {
        // Validate the data
        if (!v::length(5, 100)->validate($name)) {
            throw new \InvalidArgumentException("Event name must be between 5 and 100 characters.");
        }

        if (!v::length(5, 350)->validate($description)) {
            throw new \InvalidArgumentException("Event description must be between 5 and 350 characters.");
        }

        $pricingData = json_decode($pricing, true);
        if (!\is_array($pricingData)) {
            throw new \InvalidArgumentException("Event pricing is invalid.");
        }

        $tierNames = array_keys($pricingData);

        if (\count($pricingData) > 10 || \count($tierNames) < 1) {
            throw new \InvalidArgumentException("You can have between 1 and 10 pricing tiers.");
        }

        foreach ($tierNames as $tierName) {
            if (!v::length(1, 50)->validate($tierName)) {
                throw new \InvalidArgumentException("Pricing tier names must be between 1 and 50 characters.");
            }
        }

        $tierPrices = array_values($pricingData);
        foreach ($tierPrices as $tierPrice) {
            if (!v::numericVal()->between(0, 999)->validate($tierPrice)) {
                throw new \InvalidArgumentException("Pricing tier prices must be numeric and greater than or equal to 0.");
            }
        }

        // events can be edited and set to any time
        if (!v::dateTime('Y-m-d\TH:i')->greaterThan(new \DateTime($starts_at))->validate($ends_at)) {
            throw new \InvalidArgumentException("Event end time is invalid.");
        }

        if (!v::length(5, 120)->validate($location)) {
            throw new \InvalidArgumentException("Event location must be between 5 and 120 characters.");
        }

        // Update the event
        $this->managementRepository->updateEvent($id, $name, $description, $pricing, $starts_at, $ends_at, $location, $seating_enabled);

        return;
    }

    public function deleteEvent(int $eventId): void
    {
        $deleted = $this->managementRepository->deleteEvent($eventId);

        if (!$deleted) {
            throw new \InvalidArgumentException("Failed to delete event. Please try again later.");
        }

        return;
    }
}