<?php

declare(strict_types=1);

namespace App\Staff\Services;

use App\Repositories\EventRepository;
use App\Staff\Repositories\ManagementRepository;
use App\Services\EmailService;
use App\Staff\Repositories\CheckInRepository;
use App\Config\Settings;
use Respect\Validation\Validator as v;

class CheckInService
{
    private EventRepository $eventRepository;
    private ManagementRepository $managementRepository;
    private CheckInRepository $checkInRepository;
    private EmailService $emailService;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->emailService = new EmailService();
        $this->managementRepository = new ManagementRepository();
        $this->checkInRepository = new CheckInRepository();
    }
    
    public function getCurrentSeatedEventById(int $id): ?array // With Seatmap
    {
        return $this->checkInRepository->findCurrentSeatedById($id);
    }
    public function getCheckInStats(int $event_id): array
    {
        return $this->checkInRepository->getCheckInStats($event_id);
    }
    public function processCheckIn(int $event_id, string $qr_data): ?array
    {
        $bookingExists = $this->checkInRepository->bookingExists($qr_data);
        $checkinData = $this->checkInRepository->checkInBooking($event_id, $qr_data);
       if ($bookingExists && $checkinData === false) { //
            throw new \Exception('Wrong Event'); 
        } 
        if ($checkinData === false) {
            throw new \Exception('Booking not found');
        }
        if ($checkinData === true) {
            throw new \Exception('Already checked in');
        }

        $stats = $this->checkInRepository->getCheckInStats($event_id);
        
        return [
            'id' => $checkinData['Id'],
            'name' => $checkinData['Name'], 
            'seat' => $checkinData['Seat'],
            'time' => date('g:i A'),
            'checked' => $stats['checked'],
            'total' => $stats['total']
        ];

    }

    public function undoCheckIn(int $event_id, int $booking_id): ?string
    {
        return $this->checkInRepository->undoCheckIn($event_id, $booking_id); //returns seat, or null if not successful
    }

}