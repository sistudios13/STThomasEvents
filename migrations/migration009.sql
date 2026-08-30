ALTER TABLE `booking_sessions` ADD `reminder_sent_at` DATETIME NOT NULL AFTER `access_code`;
ALTER TABLE `booking_sessions` CHANGE `reminder_sent_at` `reminder_sent_at` DATETIME NULL DEFAULT NULL;