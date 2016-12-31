CREATE TABLE `customer` (
	`id` bigint NOT NULL,
	`site_id` bigint NOT NULL,
	`short_name` tinytext(10) NOT NULL UNIQUE,
	`long_name` tinytext(30),
	PRIMARY KEY (`id`)
);

CREATE TABLE `landscape` (
	`id` bigint NOT NULL,
	`customer_id` bigint NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `system` (
	`id` int(4) NOT NULL,
	`landscape_id` bigint NOT NULL,
	`install_no` bigint,
	PRIMARY KEY (`id`)
);

CREATE TABLE `alert` (
	`id` int(4) NOT NULL,
	`system_id` int(4) NOT NULL,
	`alert_priority_id` tinyint(2) NOT NULL,
	`issued_date` DATE NOT NULL,
	`last_modified_user_id` bigint(20) NOT NULL,
	`last_modified_date` DATE NOT NULL,
	`alert_message` tinytext NOT NULL,
	`action_party_id` bigint,
	`action_id` varchar(50),
	PRIMARY KEY (`id`)
);

CREATE TABLE `alert_priority` (
	`id` tinyint(2) NOT NULL,
	`short_name` varchar(15) NOT NULL,
	`icon` varchar(50),
	`css_class` varchar(100),
	`hex_color` varchar(6),
	PRIMARY KEY (`id`)
);

CREATE TABLE `action_party` (
	`id` bigint NOT NULL,
	`code` tinytext NOT NULL,
	`url` TEXT,
	`third_party` bool,
	`icon` varchar(50),
	PRIMARY KEY (`id`)
);

CREATE TABLE `project_status` (
	`id` tinyint(2) NOT NULL,
	`short_name` varchar(50) NOT NULL,
	`code` varchar(20) NOT NULL UNIQUE,
	`css_class` varchar(100),
	`hex_color` varchar(6),
	PRIMARY KEY (`id`)
);

CREATE TABLE `project_urgency` (
	`id` tinyint(2) NOT NULL,
	`short_name` varchar(50) NOT NULL,
	`code` varchar(20) NOT NULL UNIQUE,
	`css_class` varchar(100),
	`hex_color` varchar(6),
	PRIMARY KEY (`id`)
);

CREATE TABLE `project` (
	`id` bigint(20) NOT NULL,
	`customer_id` bigint NOT NULL,
	`short_name` varchar(100) NOT NULL,
	`description` TEXT NOT NULL,
	`requested_user_id` bigint(20) NOT NULL,
	`requested_time` TIME NOT NULL,
	`requested_start_date` DATE,
	`requested_end_date` DATE,
	`requested_urgency_id` tinyint(2) NOT NULL,
	`status_id` tinyint(2) NOT NULL,
	`planned_start_date` DATE,
	`planned_end_date` DATE,
	`percentage` tinyint(1) DEFAULT '0',
	`last_modified_user_id` bigint(20),
	`last_modified_time` DATE,
	`doc_link` varchar(255),
	`task_link` varchar(255),
	`last_modified_date` DATE,
	`requested_date` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `landscape` ADD CONSTRAINT `landscape_fk0` FOREIGN KEY (`customer_id`) REFERENCES `customer`(`id`);

ALTER TABLE `system` ADD CONSTRAINT `system_fk0` FOREIGN KEY (`landscape_id`) REFERENCES `landscape`(`id`);

ALTER TABLE `alert` ADD CONSTRAINT `alert_fk0` FOREIGN KEY (`system_id`) REFERENCES `system`(`id`);

ALTER TABLE `alert` ADD CONSTRAINT `alert_fk1` FOREIGN KEY (`alert_priority_id`) REFERENCES `alert_priority`(`id`);

ALTER TABLE `alert` ADD CONSTRAINT `alert_fk2` FOREIGN KEY (`action_party_id`) REFERENCES `action_party`(`id`);

ALTER TABLE `project` ADD CONSTRAINT `project_fk0` FOREIGN KEY (`customer_id`) REFERENCES `customer`(`id`);

ALTER TABLE `project` ADD CONSTRAINT `project_fk1` FOREIGN KEY (`requested_urgency_id`) REFERENCES `project_urgency`(`id`);

ALTER TABLE `project` ADD CONSTRAINT `project_fk2` FOREIGN KEY (`status_id`) REFERENCES `project_status`(`id`);
