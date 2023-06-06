<?php
"ALTER TABLE `property_food` CHANGE `property_id` `location_id` INT(11) NOT NULL;"

//05-06-2023
ALTER TABLE `users` ADD `reset_password_code` INT(11) NOT NULL AFTER `email_verified_at`, ADD `reset_password_code_created_at` TIMESTAMP NULL DEFAULT NULL AFTER `reset_password_code`, ADD `is_reset_password` TINYINT(1) NOT NULL DEFAULT '0' AFTER `reset_password_code_created_at`;
?>