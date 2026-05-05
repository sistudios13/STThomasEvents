<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Bookings.php';
require_once __DIR__ . '/../repositories/ConfirmationRepository.php';


class ConfirmationService
{
    private ConfirmationRepository $confirmationRepository;
    private EventService $eventService;

    public function __construct()
    {
        $this->confirmationRepository = new ConfirmationRepository();
        $this->eventService = new EventService();
    }

    public function getEmailByToken(string $booking_token): ?string
    {
        return $this->confirmationRepository->getEmailByToken($booking_token);
    }

    public function confirmBooking(int $event_id, string $booking_token, int $enterred_code): void
    {
        $code = $this->confirmationRepository->getCodeByToken($event_id, $booking_token);

        if ($code == null) {
            throw new InvalidArgumentException("No booking session found, something went wrong.");
        }

        if (intval($code) != intval($enterred_code)) {
            throw new InvalidArgumentException("Invalid verification code.");
        }

        //more validation maybe?

        $SID = $this->confirmationRepository->getSIDByToken($event_id, $booking_token);

        if ($SID == null) {
            throw new InvalidArgumentException("No booking session found, something went wrong.");
        }


        $this->confirmationRepository->confirmBooking($event_id, $SID);

        //FINISH
    }


}
