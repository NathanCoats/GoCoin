CREATE DATABASE `go_coin`;
USE go_coin;
CREATE TABLE `log` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`type` VARCHAR(50) NOT NULL,
	`action` ENUM('buy','sell') NOT NULL,
	`percent_difference` DOUBLE(14,8) NOT NULL DEFAULT '0.00000000',
	`rate` DOUBLE(18,9) NOT NULL,
	`qty` INT(18) NOT NULL,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);