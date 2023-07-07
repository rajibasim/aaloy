<?php
"ALTER TABLE `property_food` CHANGE `property_id` `location_id` INT(11) NOT NULL;"

//05-06-2023
ALTER TABLE `users` ADD `reset_password_code` INT(11) NOT NULL AFTER `email_verified_at`, ADD `reset_password_code_created_at` TIMESTAMP NULL DEFAULT NULL AFTER `reset_password_code`, ADD `is_reset_password` TINYINT(1) NOT NULL DEFAULT '0' AFTER `reset_password_code_created_at`;

ALTER TABLE `location` ADD `address` VARCHAR(255) NULL AFTER `city_id`, ADD `pin_code` INT(11) NULL AFTER `address`;

ALTER TABLE `property` ADD `latitude` VARCHAR(255) NULL AFTER `address`, ADD `longitude` VARCHAR(255) NULL AFTER `latitude`, ADD `pin_code` INT NULL AFTER `longitude`;

ALTER TABLE `property` CHANGE `note` `note` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
?>