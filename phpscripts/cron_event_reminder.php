<?php

declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../generated-conf/config.php';

use App\Services\ReminderService;
use App\Config\Settings;
use App\Services\EmailService;


/*
    Script for sending reminders to attendees 48h before event starts
    Will run with cron job every hour
**/

$reminderService = new ReminderService();
$emailService = new EmailService();
$reminders = $reminderService->getUpcomingReminders();

foreach ($reminders as $reminder) {
    $url = Settings::APP_URL . "tickets/?access_code=" . $reminder['accessCode'] . "&email=" . urlencode($reminder['email']);
    
    $emailService->sendEmail(
        $reminder['email'],
        $reminder['name'],
        'Reminder: ' . $reminder['eventName'] . ' is coming up!',
        "
        Hi " . $reminder['name'] . ",<br><br>
        This is a friendly reminder that the event <strong>" . $reminder['eventName'] . "</strong> is happening on <strong>" . date('F j, Y \a\t g:i A', strtotime($reminder['eventStartsAt'])) . "</strong>.<br><br>
        You can access your tickets using the following link: <a href='" . $url . "'>" . $url ."</a><br><br>
        Please make sure to arrive on time and bring: <br>
        <ul>
            <li>Your tickets</li>
            <li>Cash to pay at the door</li>
        </ul>
        <br>
        If you won't be able to attend, please cancel your booking on the tickets page to free up your spot for others.<br><br>
        We look forward to seeing you there!<br><br>
        Best regards,<br>
        St. Thomas Events Team
        "
    );

    $reminderService->markReminderSent($reminder['id']);

}
