-- Add token column in bookings
ALTER TABLE `bookings` ADD `token` VARCHAR(14) NOT NULL AFTER `email_verified`;