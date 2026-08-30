<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ReminderRepository;

class ReminderService
{
    private ReminderRepository $reminderRepository;

    public function __construct()
    {
        $this->reminderRepository = new ReminderRepository();
    }
    public function getUpcomingReminders(): array
    {
        return $this->reminderRepository->getUpcomingReminders();
    }

    public function markReminderSent(int $booking_session_id): void
    {
        $this->reminderRepository->markReminderSent($booking_session_id);
    }
}   