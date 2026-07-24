ALTER TABLE `events` CHANGE `date` `starts_at` DATETIME NOT NULL;
ALTER TABLE `events` ADD `ends_at` DATETIME NOT NULL AFTER `starts_at`;