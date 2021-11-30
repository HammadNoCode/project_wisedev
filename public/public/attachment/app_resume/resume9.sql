-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5293
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for laravel
CREATE DATABASE IF NOT EXISTS `laravel` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `laravel`;

-- Dumping structure for table laravel.applicant_compliance
CREATE TABLE IF NOT EXISTS `applicant_compliance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` int(11) DEFAULT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `renewal_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `expired` int(11) DEFAULT '0',
  `checked_by` int(11) DEFAULT NULL,
  `test` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.applicant_compliance: ~0 rows (approximately)
DELETE FROM `applicant_compliance`;
/*!40000 ALTER TABLE `applicant_compliance` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_compliance` ENABLE KEYS */;

-- Dumping structure for table laravel.applicant_map
CREATE TABLE IF NOT EXISTS `applicant_map` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `test` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.applicant_map: ~0 rows (approximately)
DELETE FROM `applicant_map`;
/*!40000 ALTER TABLE `applicant_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_map` ENABLE KEYS */;

-- Dumping structure for table laravel.applicant_profile
CREATE TABLE IF NOT EXISTS `applicant_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `about_me` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.applicant_profile: ~0 rows (approximately)
DELETE FROM `applicant_profile`;
/*!40000 ALTER TABLE `applicant_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_profile` ENABLE KEYS */;

-- Dumping structure for table laravel.applicant_profile_picture
CREATE TABLE IF NOT EXISTS `applicant_profile_picture` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.applicant_profile_picture: ~0 rows (approximately)
DELETE FROM `applicant_profile_picture`;
/*!40000 ALTER TABLE `applicant_profile_picture` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_profile_picture` ENABLE KEYS */;

-- Dumping structure for table laravel.applications
CREATE TABLE IF NOT EXISTS `applications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `landline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `county` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `experience` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shifts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `national_insurance_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `skills` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nurse_pin_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `right_to_work` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qualifications` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `most_recent_work` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `relevant_skills` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `employment_gaps` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `referees` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_referee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drivers_license` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `in_good_health` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `good_health_information` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `offender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `offender_information` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vaccinated` tinyint(1) NOT NULL,
  `declaration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `hired` int(11) NOT NULL,
  `accept_date` timestamp NOT NULL,
  `hire_date` timestamp NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contacted` int(11) NOT NULL,
  `phoned` int(11) NOT NULL,
  `reminder_count` int(11) NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source_details` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invite_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test` int(11) NOT NULL,
  `pulse` tinyint(1) NOT NULL,
  `covid_reminders` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `favourite` tinyint(4) DEFAULT '0',
  `hours_pw` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.applications: ~16 rows (approximately)
DELETE FROM `applications`;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` (`id`, `branch_id`, `position`, `first_name`, `last_name`, `email`, `mobile`, `landline`, `address_line_1`, `address_line_2`, `city`, `county`, `postcode`, `experience`, `shifts`, `national_insurance_number`, `skills`, `nurse_pin_number`, `right_to_work`, `qualifications`, `most_recent_work`, `relevant_skills`, `employment_gaps`, `referees`, `contact_referee`, `drivers_license`, `in_good_health`, `good_health_information`, `offender`, `offender_information`, `vaccinated`, `declaration`, `token`, `status`, `hired`, `accept_date`, `hire_date`, `notes`, `contacted`, `phoned`, `reminder_count`, `source`, `source_details`, `job_id`, `invite_token`, `test`, `pulse`, `covid_reminders`, `created_at`, `updated_at`, `favourite`, `hours_pw`) VALUES
	(5, 3, 'Healthcare Assistant', 'saadalam', 'alam', 'saad@gmail.com', '923323383463', '02134556778', 'R 505 sevtor 14A shadman Town', '', 'london', 'united Kingdom', '4200', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '2001-11-30 00:01:15', '2001-11-30 00:01:15', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, '2021-09-27 15:21:24', 0, 0),
	(9, 3, 'Healthcare Assistant', 'hammad', 'alam', 'abc@gmail.com', '923052513506', '', '19 res downtown london UK', '', 'bradford', 'united Kingdom', '4200', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '2001-11-30 00:01:15', '2001-11-30 00:01:15', '', 0, 0, 0, 'linkedin', '', '', '', 0, 0, 0, NULL, '2021-09-27 16:32:47', 0, 0),
	(10, 3, 'Senior Healthcare Assistant', 'imran', 'ahmed', 'hammad@gmail.com', '923452811140', '', 'L 120 north london, United Kingdom', '', 'bradford', 'united Kingdom', '4200', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '2001-11-30 00:01:15', '2001-11-30 00:01:15', '', 0, 0, 0, '', '', '', '', 0, 0, 0, NULL, '2021-09-29 10:43:05', 0, 0),
	(11, 0, 'Senior Healthcare Assistant', 'waleed', 'ahmed', 'abc@gmail.com', '923323383463', '', 'L 120 north london, United Kingdom', '', 'bradford', 'united Kingdom', '4200', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 0, 0, 0, NULL, NULL, 0, 0),
	(12, 0, 'Healthcare Assistant', 'usman', 'ahmed', 'abc@gmail.com', '923323383463', '', 'L 120 north london, United Kingdom', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 0, 0, 0, NULL, NULL, 0, 0),
	(13, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(14, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(15, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(16, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(17, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(18, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(19, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(20, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0),
	(21, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 0, 0, 0, NULL, NULL, 0, 0),
	(22, 0, 'Senior Healthcare Assistant', 'ahmed', 'ahmed', 'saad123@gmail.com', '923323383463', '', 'LN 23 back street front road', '', 'warrington', 'united kingdom', '42800', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '2001-11-30 00:01:15', '2001-11-30 00:01:15', '', 0, 0, 0, '', '', '', '', 0, 0, 0, NULL, '2021-10-07 11:47:30', 0, 0),
	(23, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0, 0, '', '', '', '', 1, 0, 0, NULL, NULL, 0, 0);
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;

-- Dumping structure for table laravel.application_invites
CREATE TABLE IF NOT EXISTS `application_invites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hours_pw` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driving_licence` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.application_invites: ~0 rows (approximately)
DELETE FROM `application_invites`;
/*!40000 ALTER TABLE `application_invites` DISABLE KEYS */;
/*!40000 ALTER TABLE `application_invites` ENABLE KEYS */;

-- Dumping structure for table laravel.application_notes
CREATE TABLE IF NOT EXISTS `application_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.application_notes: ~0 rows (approximately)
DELETE FROM `application_notes`;
/*!40000 ALTER TABLE `application_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `application_notes` ENABLE KEYS */;

-- Dumping structure for table laravel.application_retrievals
CREATE TABLE IF NOT EXISTS `application_retrievals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) DEFAULT NULL,
  `retrievals` int(11) DEFAULT NULL,
  `completed` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.application_retrievals: ~0 rows (approximately)
DELETE FROM `application_retrievals`;
/*!40000 ALTER TABLE `application_retrievals` DISABLE KEYS */;
/*!40000 ALTER TABLE `application_retrievals` ENABLE KEYS */;

-- Dumping structure for table laravel.audits
CREATE TABLE IF NOT EXISTS `audits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `max_score` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.audits: ~0 rows (approximately)
DELETE FROM `audits`;
/*!40000 ALTER TABLE `audits` DISABLE KEYS */;
/*!40000 ALTER TABLE `audits` ENABLE KEYS */;

-- Dumping structure for table laravel.audits_completed
CREATE TABLE IF NOT EXISTS `audits_completed` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `audit_id` int(11) NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `score` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.audits_completed: ~0 rows (approximately)
DELETE FROM `audits_completed`;
/*!40000 ALTER TABLE `audits_completed` DISABLE KEYS */;
/*!40000 ALTER TABLE `audits_completed` ENABLE KEYS */;

-- Dumping structure for table laravel.audit_completed_viewers
CREATE TABLE IF NOT EXISTS `audit_completed_viewers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `completed_audit_id` int(11) NOT NULL,
  `viewer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.audit_completed_viewers: ~0 rows (approximately)
DELETE FROM `audit_completed_viewers`;
/*!40000 ALTER TABLE `audit_completed_viewers` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_completed_viewers` ENABLE KEYS */;

-- Dumping structure for table laravel.audit_groups
CREATE TABLE IF NOT EXISTS `audit_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.audit_groups: ~0 rows (approximately)
DELETE FROM `audit_groups`;
/*!40000 ALTER TABLE `audit_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_groups` ENABLE KEYS */;

-- Dumping structure for table laravel.audit_procedures
CREATE TABLE IF NOT EXISTS `audit_procedures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.audit_procedures: ~0 rows (approximately)
DELETE FROM `audit_procedures`;
/*!40000 ALTER TABLE `audit_procedures` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_procedures` ENABLE KEYS */;

-- Dumping structure for table laravel.branches
CREATE TABLE IF NOT EXISTS `branches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.branches: ~0 rows (approximately)
DELETE FROM `branches`;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'london', NULL, NULL),
	(2, 'new york', NULL, NULL),
	(3, 'blackburn', NULL, NULL);
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;

-- Dumping structure for table laravel.branch_reporting
CREATE TABLE IF NOT EXISTS `branch_reporting` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` tinyint(4) NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hours_achieved` tinyint(4) DEFAULT NULL,
  `hours_lost` tinyint(4) DEFAULT NULL,
  `week_commencing` date NOT NULL,
  `week_ending` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.branch_reporting: ~0 rows (approximately)
DELETE FROM `branch_reporting`;
/*!40000 ALTER TABLE `branch_reporting` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_reporting` ENABLE KEYS */;

-- Dumping structure for table laravel.call_schedule
CREATE TABLE IF NOT EXISTS `call_schedule` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` bigint(20) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `outcome` int(11) NOT NULL,
  `scheduled` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.call_schedule: ~0 rows (approximately)
DELETE FROM `call_schedule`;
/*!40000 ALTER TABLE `call_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `call_schedule` ENABLE KEYS */;

-- Dumping structure for table laravel.carehomes
CREATE TABLE IF NOT EXISTS `carehomes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `main_contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `beds` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rating` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agency_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehomes: ~0 rows (approximately)
DELETE FROM `carehomes`;
/*!40000 ALTER TABLE `carehomes` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehomes` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_agencies
CREATE TABLE IF NOT EXISTS `carehome_agencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_agencies: ~0 rows (approximately)
DELETE FROM `carehome_agencies`;
/*!40000 ALTER TABLE `carehome_agencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_agencies` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_call_history
CREATE TABLE IF NOT EXISTS `carehome_call_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spoke_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `decision_maker` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_call_history: ~0 rows (approximately)
DELETE FROM `carehome_call_history`;
/*!40000 ALTER TABLE `carehome_call_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_call_history` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_contacts
CREATE TABLE IF NOT EXISTS `carehome_contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_contacts: ~0 rows (approximately)
DELETE FROM `carehome_contacts`;
/*!40000 ALTER TABLE `carehome_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_contacts` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_coordinates
CREATE TABLE IF NOT EXISTS `carehome_coordinates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_coordinates: ~0 rows (approximately)
DELETE FROM `carehome_coordinates`;
/*!40000 ALTER TABLE `carehome_coordinates` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_coordinates` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_key_contacts
CREATE TABLE IF NOT EXISTS `carehome_key_contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_key_contacts: ~0 rows (approximately)
DELETE FROM `carehome_key_contacts`;
/*!40000 ALTER TABLE `carehome_key_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_key_contacts` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_notes
CREATE TABLE IF NOT EXISTS `carehome_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_notes: ~0 rows (approximately)
DELETE FROM `carehome_notes`;
/*!40000 ALTER TABLE `carehome_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_notes` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_onboarding_completed_stages
CREATE TABLE IF NOT EXISTS `carehome_onboarding_completed_stages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stage_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `checked_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_onboarding_completed_stages: ~0 rows (approximately)
DELETE FROM `carehome_onboarding_completed_stages`;
/*!40000 ALTER TABLE `carehome_onboarding_completed_stages` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_onboarding_completed_stages` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_onboarding_stages
CREATE TABLE IF NOT EXISTS `carehome_onboarding_stages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `stage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_onboarding_stages: ~0 rows (approximately)
DELETE FROM `carehome_onboarding_stages`;
/*!40000 ALTER TABLE `carehome_onboarding_stages` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_onboarding_stages` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_service_types
CREATE TABLE IF NOT EXISTS `carehome_service_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_service_types: ~0 rows (approximately)
DELETE FROM `carehome_service_types`;
/*!40000 ALTER TABLE `carehome_service_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_service_types` ENABLE KEYS */;

-- Dumping structure for table laravel.carehome_specialisms
CREATE TABLE IF NOT EXISTS `carehome_specialisms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `specialism` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.carehome_specialisms: ~0 rows (approximately)
DELETE FROM `carehome_specialisms`;
/*!40000 ALTER TABLE `carehome_specialisms` DISABLE KEYS */;
/*!40000 ALTER TABLE `carehome_specialisms` ENABLE KEYS */;

-- Dumping structure for table laravel.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `test` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.clients: ~0 rows (approximately)
DELETE FROM `clients`;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Dumping structure for table laravel.client_actions
CREATE TABLE IF NOT EXISTS `client_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assigned_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `completed_at` date DEFAULT NULL,
  `test` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.client_actions: ~0 rows (approximately)
DELETE FROM `client_actions`;
/*!40000 ALTER TABLE `client_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_actions` ENABLE KEYS */;

-- Dumping structure for table laravel.client_contacts
CREATE TABLE IF NOT EXISTS `client_contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.client_contacts: ~0 rows (approximately)
DELETE FROM `client_contacts`;
/*!40000 ALTER TABLE `client_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_contacts` ENABLE KEYS */;

-- Dumping structure for table laravel.client_contact_history
CREATE TABLE IF NOT EXISTS `client_contact_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.client_contact_history: ~0 rows (approximately)
DELETE FROM `client_contact_history`;
/*!40000 ALTER TABLE `client_contact_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_contact_history` ENABLE KEYS */;

-- Dumping structure for table laravel.client_conversations
CREATE TABLE IF NOT EXISTS `client_conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.client_conversations: ~0 rows (approximately)
DELETE FROM `client_conversations`;
/*!40000 ALTER TABLE `client_conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_conversations` ENABLE KEYS */;

-- Dumping structure for table laravel.client_hours
CREATE TABLE IF NOT EXISTS `client_hours` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `requested_hours` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provided_hours` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `test` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.client_hours: ~0 rows (approximately)
DELETE FROM `client_hours`;
/*!40000 ALTER TABLE `client_hours` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_hours` ENABLE KEYS */;

-- Dumping structure for table laravel.client_map
CREATE TABLE IF NOT EXISTS `client_map` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.client_map: ~0 rows (approximately)
DELETE FROM `client_map`;
/*!40000 ALTER TABLE `client_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_map` ENABLE KEYS */;

-- Dumping structure for table laravel.client_notes
CREATE TABLE IF NOT EXISTS `client_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.client_notes: ~0 rows (approximately)
DELETE FROM `client_notes`;
/*!40000 ALTER TABLE `client_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_notes` ENABLE KEYS */;

-- Dumping structure for table laravel.clinical_staff
CREATE TABLE IF NOT EXISTS `clinical_staff` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `hired_by` int(11) NOT NULL,
  `covid_reminders` int(11) NOT NULL,
  `vaccination_invite` int(11) NOT NULL,
  `test` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `contacted` int(11) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.clinical_staff: ~0 rows (approximately)
DELETE FROM `clinical_staff`;
/*!40000 ALTER TABLE `clinical_staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `clinical_staff` ENABLE KEYS */;

-- Dumping structure for table laravel.clinical_staff_pulse
CREATE TABLE IF NOT EXISTS `clinical_staff_pulse` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `covid_reminder` int(11) DEFAULT '0',
  `vaccination_invite` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.clinical_staff_pulse: ~0 rows (approximately)
DELETE FROM `clinical_staff_pulse`;
/*!40000 ALTER TABLE `clinical_staff_pulse` DISABLE KEYS */;
/*!40000 ALTER TABLE `clinical_staff_pulse` ENABLE KEYS */;

-- Dumping structure for table laravel.complex_care_competencies
CREATE TABLE IF NOT EXISTS `complex_care_competencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nurse_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `displayname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.complex_care_competencies: ~0 rows (approximately)
DELETE FROM `complex_care_competencies`;
/*!40000 ALTER TABLE `complex_care_competencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `complex_care_competencies` ENABLE KEYS */;

-- Dumping structure for table laravel.compliance_documents
CREATE TABLE IF NOT EXISTS `compliance_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `required` int(11) NOT NULL,
  `test` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `specific_role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ha` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `sha` tinyint(4) DEFAULT '0',
  `rng` tinyint(4) DEFAULT '0',
  `rmn` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.compliance_documents: ~0 rows (approximately)
DELETE FROM `compliance_documents`;
/*!40000 ALTER TABLE `compliance_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `compliance_documents` ENABLE KEYS */;

-- Dumping structure for table laravel.compliance_document_details
CREATE TABLE IF NOT EXISTS `compliance_document_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `dbs_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `issue_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_checked` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `online` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passport_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passport_expiry` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visa_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visa_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hours` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visa_expiry` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.compliance_document_details: ~0 rows (approximately)
DELETE FROM `compliance_document_details`;
/*!40000 ALTER TABLE `compliance_document_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `compliance_document_details` ENABLE KEYS */;

-- Dumping structure for table laravel.compliance_notes
CREATE TABLE IF NOT EXISTS `compliance_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.compliance_notes: ~0 rows (approximately)
DELETE FROM `compliance_notes`;
/*!40000 ALTER TABLE `compliance_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `compliance_notes` ENABLE KEYS */;

-- Dumping structure for table laravel.covid_results
CREATE TABLE IF NOT EXISTS `covid_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `covid_result` int(11) NOT NULL,
  `test_date` date NOT NULL,
  `test_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_of_other_test` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pin_sent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.covid_results: ~0 rows (approximately)
DELETE FROM `covid_results`;
/*!40000 ALTER TABLE `covid_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `covid_results` ENABLE KEYS */;

-- Dumping structure for table laravel.cqc_carehome_ids
CREATE TABLE IF NOT EXISTS `cqc_carehome_ids` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_ids` int(11) DEFAULT NULL,
  `provider_ids` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.cqc_carehome_ids: ~0 rows (approximately)
DELETE FROM `cqc_carehome_ids`;
/*!40000 ALTER TABLE `cqc_carehome_ids` DISABLE KEYS */;
/*!40000 ALTER TABLE `cqc_carehome_ids` ENABLE KEYS */;

-- Dumping structure for table laravel.document_compliance
CREATE TABLE IF NOT EXISTS `document_compliance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.document_compliance: ~0 rows (approximately)
DELETE FROM `document_compliance`;
/*!40000 ALTER TABLE `document_compliance` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_compliance` ENABLE KEYS */;

-- Dumping structure for table laravel.employment_history
CREATE TABLE IF NOT EXISTS `employment_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employed_to` date DEFAULT NULL,
  `employed_from` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.employment_history: ~0 rows (approximately)
DELETE FROM `employment_history`;
/*!40000 ALTER TABLE `employment_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `employment_history` ENABLE KEYS */;

-- Dumping structure for table laravel.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agenda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attendee_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `expired` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.events: ~0 rows (approximately)
DELETE FROM `events`;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;

-- Dumping structure for table laravel.event_attendees
CREATE TABLE IF NOT EXISTS `event_attendees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attendee_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attendee_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attendance` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.event_attendees: ~0 rows (approximately)
DELETE FROM `event_attendees`;
/*!40000 ALTER TABLE `event_attendees` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_attendees` ENABLE KEYS */;

-- Dumping structure for table laravel.interviews
CREATE TABLE IF NOT EXISTS `interviews` (
  `applicant_id` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `time` time DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table laravel.interviews: ~0 rows (approximately)
DELETE FROM `interviews`;
/*!40000 ALTER TABLE `interviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `interviews` ENABLE KEYS */;

-- Dumping structure for table laravel.interview_questions
CREATE TABLE IF NOT EXISTS `interview_questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `experience` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `strengths` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exceed_example` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `skills` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `scenario_one` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `scenario_two` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `outcome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shift_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shifts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hobbies` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `overall_score` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.interview_questions: ~0 rows (approximately)
DELETE FROM `interview_questions`;
/*!40000 ALTER TABLE `interview_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `interview_questions` ENABLE KEYS */;

-- Dumping structure for table laravel.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(9, 'default', '{"uuid":"849b5126-75ac-436f-9ec7-89718717bbc4","displayName":"App\\\\Listeners\\\\ExeBulkSmsCd","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Events\\\\CallQueuedListener","command":"O:36:\\"Illuminate\\\\Events\\\\CallQueuedListener\\":19:{s:5:\\"class\\";s:26:\\"App\\\\Listeners\\\\ExeBulkSmsCd\\";s:6:\\"method\\";s:6:\\"handle\\";s:4:\\"data\\";a:1:{i:0;O:27:\\"App\\\\Events\\\\SendBulkSmsEvent\\":3:{s:3:\\"des\\";s:29:\\"Consequatur tempora dsfdsmfsd\\";s:7:\\"numbers\\";s:25:\\"923052513506,923452811140\\";s:6:\\"socket\\";N;}}s:5:\\"tries\\";N;s:13:\\"maxExceptions\\";N;s:7:\\"backoff\\";N;s:10:\\"retryUntil\\";N;s:7:\\"timeout\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:3:\\"job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 1, 1633102123, 1633102120, 1633102120);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- Dumping structure for table laravel.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.logs: ~5 rows (approximately)
DELETE FROM `logs`;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` (`id`, `applicant_id`, `staff_id`, `message`, `created_at`, `updated_at`) VALUES
	(1, '3', '1', 'Application status updated', '2021-09-27 15:05:26', '2021-09-27 15:05:26'),
	(2, '3', '1', 'Application status updated', '2021-09-27 15:05:28', '2021-09-27 15:05:28'),
	(3, '5', '1', 'Applicant details updated', '2021-09-27 15:21:24', '2021-09-27 15:21:24'),
	(4, '9', '1', 'Applicant details updated', '2021-09-27 16:32:47', '2021-09-27 16:32:47'),
	(5, '10', '1', 'Applicant details updated', '2021-09-29 10:43:05', '2021-09-29 10:43:05'),
	(6, '22', '2', 'Applicant details updated', '2021-10-07 11:47:30', '2021-10-07 11:47:30');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

-- Dumping structure for table laravel.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.migrations: ~84 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_09_09_154809_create_sessions_table', 1),
	(4, '2020_07_10_154042_create_jobs_table', 1),
	(5, '2020_10_15_133304_create_compliance_document_details', 1),
	(6, '2020_11_04_091920_create_interview_questions_table', 1),
	(7, '2020_11_05_143705_create_applicant_profile_table', 1),
	(8, '2020_11_09_160130_create_audits_table', 1),
	(9, '2020_11_10_101914_create_audit_groups_table', 1),
	(10, '2020_11_11_095642_create_audits_completed_table', 1),
	(11, '2020_11_13_092248_create_audit_completed_viewers_table', 1),
	(12, '2020_11_24_140134_create_audit_procedures_table', 1),
	(13, '2020_12_07_110705_create_applicant_profile_picture_table', 1),
	(14, '2020_12_15_101528_create_organisations_table', 1),
	(15, '2020_12_16_115707_create_client_notes_table', 1),
	(16, '2020_12_17_105313_create_client_hours_table', 1),
	(17, '2020_12_17_111929_add_test_to_client_hours_table', 1),
	(18, '2020_12_17_150052_create_client_conversations_table', 1),
	(19, '2020_12_23_122550_create_client_map_table', 1),
	(20, '2021_01_24_115204_create_covid_results_table', 1),
	(21, '2021_01_25_115204_add_pin_sent_to_covid_results_table', 1),
	(22, '2021_01_25_115205_create_clinical_staff_table', 1),
	(23, '2021_01_25_115820_add_contacted_to_clinical_staff_table', 1),
	(24, '2021_01_28_092705_create_clinical_staff_pulse_table', 1),
	(25, '2021_03_22_120444_create_application_notes_table', 1),
	(26, '2021_03_24_092552_create_applicant_compliance_table', 1),
	(27, '2021_03_24_093212_create_applicant_map_table', 1),
	(28, '2021_03_24_094830_create_branches_table', 1),
	(29, '2021_03_24_095050_create_client_actions_table', 1),
	(30, '2021_03_24_095548_create_client_contact_history_table', 1),
	(31, '2021_03_24_125642_create_complex_care_competencies_table', 1),
	(32, '2021_03_25_161303_create_compliance_documents_table', 1),
	(33, '2021_03_25_161442_create_document_compliance_table', 1),
	(34, '2021_03_25_161617_create_event_attendees_table', 1),
	(35, '2021_03_25_161859_create_events_table', 1),
	(36, '2021_03_25_162300_create_logs_table', 1),
	(37, '2021_03_25_162425_create_postcodes_table', 1),
	(38, '2021_03_25_163854_create_client_contacts_table', 1),
	(39, '2021_03_26_090848_create_users_authorised_ips_table', 1),
	(40, '2021_03_26_091129_create_users_departments_table', 1),
	(41, '2021_03_26_091435_create_users_failed_logins_table', 1),
	(42, '2021_03_26_091541_create_users_logs_table', 1),
	(43, '2021_03_26_091807_create_users_password_resets_table', 1),
	(44, '2021_03_26_092044_create_users_tasks_table', 1),
	(45, '2021_03_27_082710_create_call_schedule_table', 1),
	(46, '2021_04_01_113311_add_test_to_applicant_map_table', 1),
	(47, '2021_04_21_141214_create_cqc_carehome_ids', 1),
	(48, '2021_04_21_155742_create_carehomes_table', 1),
	(49, '2021_04_22_100431_add_city_to_carehomes_table', 1),
	(50, '2021_04_22_102204_add_porvider_id_to_carehomes_table', 1),
	(51, '2021_04_23_121424_create_carehome_specialisms_table', 1),
	(52, '2021_04_26_101418_create_carehome_notes_table', 1),
	(53, '2021_04_26_122930_create_carehome_coordinates_table', 1),
	(54, '2021_04_28_122951_create_carehome_service_types_table', 1),
	(55, '2021_04_28_132033_add_rating_to_carehomes_table', 1),
	(56, '2021_05_05_091735_add_specific_role_to_compliance_documents', 1),
	(57, '2021_05_05_110737_create_carehome_call_history_table', 1),
	(58, '2021_05_06_105909_create_carehome_agencies_table', 1),
	(59, '2021_05_06_113603_add_branch_id_to_carehomes', 1),
	(60, '2021_05_06_113645_add_agency_status_to_carehomes', 1),
	(61, '2021_05_06_130520_create_carehome_contacts_table', 1),
	(62, '2021_05_06_153422_create_carehome_onboarding_stages_table', 1),
	(63, '2021_05_06_160250_create_carehome_onboarding_completed_stages_table', 1),
	(64, '2021_05_10_112541_create_compliance_notes_table', 1),
	(65, '2021_05_10_123310_create_carehome_key_contacts_table', 1),
	(66, '2021_05_20_092625_add_active_to_clinical_staff_table', 1),
	(67, '2021_06_08_133112_add_overall_score_to_interview_questions_table', 1),
	(68, '2021_06_09_093620_add_ha_to_compliance_documents', 1),
	(69, '2021_06_09_094314_add_sha_to_compliance_documents', 1),
	(70, '2021_06_09_094502_add_rgn_to_compliance_documents', 1),
	(71, '2021_06_09_094620_add_rmn_to_compliance_documents', 1),
	(72, '2021_06_10_113414_create_applications_table', 1),
	(73, '2021_06_10_113416_add_favourite_to_applications', 1),
	(74, '2021_06_11_131721_add_hours_pw_to_applications', 1),
	(75, '2021_06_24_135827_create_application_invites_table', 1),
	(76, '2021_07_05_121836_create_branch_reporting_table', 1),
	(77, '2021_08_10_140751_create_staff_onboarding_table', 1),
	(78, '2021_08_10_154924_create_staff_onboarding_documents_table', 1),
	(79, '2021_09_08_160621_create_application_retrievals_table', 1),
	(80, '2021_09_08_160645_create_clients_table', 1),
	(81, '2021_09_08_160803_create_employment_history_table', 1),
	(82, '2021_09_08_161123_create_references_table', 1),
	(83, '2021_09_08_161533_create_vaccination_proof_table', 1),
	(84, '2021_09_08_161533_create_vaccinations_table', 1),
	(85, '2021_09_28_213442_sms_template', 2),
	(86, '2021_10_03_182831_sms_log', 3),
	(87, '2021_10_04_091802_update_smslog', 4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table laravel.organisations
CREATE TABLE IF NOT EXISTS `organisations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `county` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `test` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.organisations: ~0 rows (approximately)
DELETE FROM `organisations`;
/*!40000 ALTER TABLE `organisations` DISABLE KEYS */;
/*!40000 ALTER TABLE `organisations` ENABLE KEYS */;

-- Dumping structure for table laravel.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table laravel.postcodes
CREATE TABLE IF NOT EXISTS `postcodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `postcode_prefix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.postcodes: ~0 rows (approximately)
DELETE FROM `postcodes`;
/*!40000 ALTER TABLE `postcodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `postcodes` ENABLE KEYS */;

-- Dumping structure for table laravel.references
CREATE TABLE IF NOT EXISTS `references` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `known_since` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `related` int(11) DEFAULT NULL,
  `capacity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `safeguard_check` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employed_from` date DEFAULT NULL,
  `employed_to` date DEFAULT NULL,
  `staff_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manually` int(11) DEFAULT NULL,
  `reminder_count` int(11) DEFAULT NULL,
  `test` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.references: ~0 rows (approximately)
DELETE FROM `references`;
/*!40000 ALTER TABLE `references` DISABLE KEYS */;
/*!40000 ALTER TABLE `references` ENABLE KEYS */;

-- Dumping structure for table laravel.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.sessions: ~0 rows (approximately)
DELETE FROM `sessions`;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

-- Dumping structure for table laravel.sms_log
CREATE TABLE IF NOT EXISTS `sms_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recipient` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.sms_log: ~50 rows (approximately)
DELETE FROM `sms_log`;
/*!40000 ALTER TABLE `sms_log` DISABLE KEYS */;
INSERT INTO `sms_log` (`id`, `status`, `message`, `recipient`, `created_at`, `updated_at`, `batch_id`) VALUES
	(3, 'success', 'Distinctio Molest', '1', '2021-10-03 21:33:00', '2021-10-03 21:33:00', 99),
	(4, 'success', 'Distinctio Molest', '1', '2021-10-03 21:35:19', '2021-10-03 21:35:19', 99),
	(5, 'success', 'Consequatur sapient dfdsf sd xzc', '2', '2021-10-03 21:45:30', '2021-10-03 21:45:30', 99),
	(6, 'success', 'Consequatur sapient dfdsf sd xzc', '2', '2021-10-03 21:47:34', '2021-10-03 21:47:34', 99),
	(7, 'success', 'Irure sint aut qui', '1', '2021-10-03 21:49:18', '2021-10-03 21:49:18', 99),
	(8, 'success', 'cvxcxvvccvvcxxcvcxvcxcxvxcxcvvxcxccxvvxcvxcvccxvvcxvcvvcxvxcvvxcxcv', '1', '2021-10-03 21:50:42', '2021-10-03 21:50:42', 99),
	(9, 'success', 'Doloribus omnis occa. hi my name is saad alam', '2', '2021-10-04 06:50:44', '2021-10-04 06:50:44', 99),
	(10, 'success', 'Voluptas lorem place', '2', '2021-10-04 06:54:24', '2021-10-04 06:54:24', 99),
	(11, 'success', 'Voluptas lorem place', '2', '2021-10-04 06:54:26', '2021-10-04 06:54:26', 99),
	(12, 'success', 'Voluptas lorem place', '2', '2021-10-04 06:54:29', '2021-10-04 06:54:29', 99),
	(13, 'success', 'Recusandae Eos offi this ismy new template dxzzdx  fddsfds  df dsfdsf   fsdf sd sd fdfsd fds ds ds dsf ds f fs sd fsd fds fds fds sf sdf sf sf s fsd ds', '1', '2021-10-04 06:57:08', '2021-10-04 06:57:08', 99),
	(14, 'success', 'Vel laboris pariatur. Eden hazard', '1', '2021-10-04 06:57:54', '2021-10-04 06:57:54', 99),
	(15, 'success', 'my name is alvin burton. David beckham', '2', '2021-10-04 06:58:28', '2021-10-04 06:58:28', 99),
	(16, 'success', 'Irure sint aut qui', '1', '2021-10-04 06:59:36', '2021-10-04 06:59:36', 99),
	(17, 'success', 'my name is flafla', '4', '2021-10-04 09:00:44', '2021-10-04 09:00:44', 99),
	(18, 'success', 'Eveniet labore et p', '4', '2021-10-04 10:16:46', '2021-10-04 10:16:46', 99),
	(19, 'success', 'Happy Eid To All. bla bla', '1', '2021-10-04 10:20:18', '2021-10-04 10:20:18', 99),
	(20, 'success', 'Eveniet labore et p', '2', '2021-10-04 10:39:14', '2021-10-04 10:39:14', 1285078787),
	(21, 'success', 'Happy Eid To All', '1', '2021-10-04 10:42:48', '2021-10-04 10:42:48', 99),
	(22, 'success', 'Happy Eid To All', '1', '2021-10-04 10:43:28', '2021-10-04 10:43:28', 1285084800),
	(23, 'success', 'this is hammad alam', '1', '2021-10-04 12:32:07', '2021-10-04 12:32:07', 99),
	(24, 'success', 'hi, i have added model function to controller', '4', '2021-10-04 12:33:57', '2021-10-04 12:33:57', 99),
	(25, 'success', 'my name is alvin burton', '1', '2021-10-04 13:14:09', '2021-10-04 13:14:09', 99),
	(26, 'success', 'Recusandae Eos offi this ismy new template', '4', '2021-10-04 13:54:13', '2021-10-04 13:54:13', 99),
	(27, 'success', 'this is my name', '1', '2021-10-04 13:54:36', '2021-10-04 13:54:36', 99),
	(28, 'success', 'my name is alvin burton', '1', '2021-10-05 09:53:53', '2021-10-05 09:53:53', 99),
	(29, 'success', 'Vel laboris pariatur', '4', '2021-10-05 09:54:08', '2021-10-05 09:54:08', 99),
	(30, 'success', 'Recusandae Eos offi this ismy new template', '1', '2021-10-05 11:13:14', '2021-10-05 11:13:14', 99),
	(31, 'success', 'Distinctio Molestia Distinctio', '1', '2021-10-06 10:19:16', '2021-10-06 10:19:16', 99),
	(32, 'success', 'Ea non saepe ut est', '1', '2021-10-06 11:51:11', '2021-10-06 11:51:11', 99),
	(33, 'success', 'Eveniet labore et p', '1', '2021-10-06 11:51:18', '2021-10-06 11:51:18', 99),
	(34, 'success', 'saad is here. please mention your name', '1', '2021-10-06 11:51:40', '2021-10-06 11:51:40', 99),
	(35, 'success', 'Consequatur tempora. open review', '1', '2021-10-06 12:26:08', '2021-10-06 12:26:08', 99),
	(36, 'success', 'Consequatur tempora. open reviews', '1', '2021-10-06 12:26:17', '2021-10-06 12:26:17', 99),
	(37, 'success', 'Voluptas lorem place', '4', '2021-10-06 13:18:57', '2021-10-06 13:18:57', 99),
	(38, 'success', 'Consequatur tempora', '1', '2021-10-06 13:19:33', '2021-10-06 13:19:33', 99),
	(39, 'success', 'Ea non saepe ut est', '2', '2021-10-06 13:19:48', '2021-10-06 13:19:48', 99),
	(40, 'success', 'Ea non saepe ut est.com', '4', '2021-10-06 13:20:01', '2021-10-06 13:20:01', 99),
	(41, 'success', 'Ut reprehenderit del', '1', '2021-10-06 14:09:51', '2021-10-06 14:09:51', 99),
	(42, 'success', 'Est consectetur est', '4', '2021-10-06 14:10:20', '2021-10-06 14:10:20', 99),
	(43, 'success', 'Ut reprehenderit del', '1', '2021-10-06 14:56:36', '2021-10-06 14:56:36', 99),
	(44, 'success', 'Recusandae Eos offi this ismy new template', '2', '2021-10-06 14:56:49', '2021-10-06 14:56:49', 99),
	(45, 'success', 'Vel laboris pariatur', '1', '2021-10-06 15:12:37', '2021-10-06 15:12:37', 99),
	(46, 'success', 'my name is alvin burton', '1', '2021-10-06 15:12:45', '2021-10-06 15:12:45', 99),
	(47, 'success', 'my name is alvin burton', '1', '2021-10-06 15:13:03', '2021-10-06 15:13:03', 99),
	(48, 'success', 'Voluptas lorem place', '4', '2021-10-06 15:13:26', '2021-10-06 15:13:26', 99),
	(49, 'success', 'Consequatur sapient', '1', '2021-10-06 15:13:48', '2021-10-06 15:13:48', 99),
	(50, 'success', 'Ea non saepe ut est', '1', '2021-10-06 15:14:40', '2021-10-06 15:14:40', 99),
	(51, 'success', 'Doloribus omnis occa', '4', '2021-10-06 15:14:53', '2021-10-06 15:14:53', 99),
	(52, 'success', 'i am alvin burton', '4', '2021-10-06 15:15:28', '2021-10-06 15:15:28', 99),
	(53, 'success', 'my name is alvin burton', '1', '2021-10-06 15:16:47', '2021-10-06 15:16:47', 99),
	(54, 'success', 'Happy Eid To All', '1', '2021-10-06 16:07:29', '2021-10-06 16:07:29', 99),
	(55, 'success', 'this is my name', '4', '2021-10-06 16:07:48', '2021-10-06 16:07:48', 99),
	(56, 'success', 'this is my name', '1', '2021-10-06 16:23:52', '2021-10-06 16:23:52', 99),
	(57, 'success', 'Ea non saepe ut est', '4', '2021-10-06 16:24:06', '2021-10-06 16:24:06', 99),
	(58, 'success', 'Distinctio Molestia Distinctio', '1', '2021-10-07 11:45:58', '2021-10-07 11:45:58', 99);
/*!40000 ALTER TABLE `sms_log` ENABLE KEYS */;

-- Dumping structure for table laravel.sms_template
CREATE TABLE IF NOT EXISTS `sms_template` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `t_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.sms_template: ~32 rows (approximately)
DELETE FROM `sms_template`;
/*!40000 ALTER TABLE `sms_template` DISABLE KEYS */;
INSERT INTO `sms_template` (`id`, `template_name`, `t_description`, `created_at`, `deleted_at`, `updated_at`) VALUES
	(1, 'new msg', 'my name is flafla', '2021-09-29 01:55:19', 0, '2021-10-03 13:46:52'),
	(2, 'old msg', 'your name is flaafla', '2021-09-29 01:55:20', 1, '2021-09-30 20:17:23'),
	(3, 'Phoebe Alvarez', 'Est consectetur est', '2021-09-29 16:51:44', 0, '2021-09-29 16:51:44'),
	(4, 'Neve House', 'Voluptas lorem place', '2021-09-29 16:53:28', 0, '2021-09-29 16:53:28'),
	(5, 'Sacha Gay', 'Qui voluptatibus imp', '2021-09-29 16:55:58', 0, '2021-09-29 16:55:58'),
	(6, 'Dalton Rodgers', 'Irure sint aut qui', '2021-09-29 16:56:00', 0, '2021-09-29 16:58:35'),
	(7, 'Troy Lawson', 'Maxime tenetur delen', '2021-09-29 16:56:02', 0, '2021-09-29 16:56:02'),
	(8, 'Sean Cleveland', 'Doloribus omnis occa', '2021-09-29 16:56:05', 0, '2021-09-29 16:56:05'),
	(9, 'Ruby Evans', 'Consequatur tempora', '2021-09-29 16:56:12', 0, '2021-09-30 10:13:50'),
	(10, 'Ruby Evans', 'Consequatur tempora', '2021-09-29 16:56:42', 0, '2021-09-29 16:56:42'),
	(11, 'Eric Hancock', 'Eveniet labore et p', '2021-09-29 16:56:57', 0, '2021-09-29 16:56:57'),
	(12, 'Noelle Patrick', 'Consequatur sapient', '2021-09-29 16:57:30', 0, '2021-09-29 16:57:30'),
	(13, 'Hashim Mills', 'Ea non saepe ut est', '2021-09-29 16:58:11', 0, '2021-09-29 16:58:11'),
	(14, 'Alexa Hernandez', 'Vel laboris pariatur', '2021-09-29 17:10:17', 0, '2021-09-29 17:10:17'),
	(15, 'Alvin Burton', 'my name is alvin burton', '2021-09-30 08:12:27', 0, '2021-09-30 08:12:27'),
	(16, 'Eaton Cervantes', 'Recusandae Eos offi this ismy new template', '2021-09-30 10:13:08', 0, '2021-09-30 10:13:08'),
	(17, 'Brennan Herrera', 'Distinctio Molestia Distinctio Molestia Distinctio Molestia Distinctio Molestia Distinctio Molestia Distinctio Molestia Distinctio Molestia Distinctio', '2021-09-30 10:24:36', 0, '2021-09-30 10:24:55'),
	(18, 'Mari Silva', 'Ut reprehenderit del', '2021-10-01 11:42:16', 0, '2021-10-01 11:42:16'),
	(19, 'Shelby Reyes', 'Quos totam irure aut', '2021-10-03 13:47:03', 0, '2021-10-03 13:47:03'),
	(20, 'Wesley Moses', 'this is my name', '2021-10-04 06:58:47', 0, '2021-10-04 06:58:47'),
	(21, 'Mia Cole', 'Dolorum magnam aliqu', '2021-10-04 10:02:13', 0, '2021-10-04 10:02:13'),
	(22, 'eid greetings', 'Happy Eid To All', '2021-10-04 10:18:59', 0, '2021-10-04 10:19:37'),
	(23, 'happy easter', 'Easter Greetings', '2021-10-05 09:54:37', 0, '2021-10-05 09:54:37'),
	(24, 'Alvin Burton', 'this is my name and i am dexter', '2021-10-06 12:38:44', 0, '2021-10-06 12:38:51'),
	(25, 'Aimee Avila', 'Aimee Avila', '2021-10-06 12:41:49', 0, '2021-10-06 12:41:55'),
	(26, 'Alvin Burton', 'saad is here', '2021-10-06 13:19:16', 0, '2021-10-06 14:09:04'),
	(27, 'Alvin Burton', 'hi, whtz up', '2021-10-06 14:08:42', 0, '2021-10-06 14:09:05'),
	(28, 'dsa', 'cdsad', '2021-10-06 14:08:54', 0, '2021-10-06 14:09:06'),
	(29, 'Deirdre Greer', 'Aliquid accusamus no', '2021-10-06 14:56:57', 0, '2021-10-06 14:57:01'),
	(30, 'Alvin Burton', 'i am alvin burton', '2021-10-06 15:15:09', 0, '2021-10-06 15:15:09'),
	(31, 'Davis Mckinney', 'Necessitatibus asper', '2021-10-06 15:26:36', 0, '2021-10-06 15:26:36'),
	(32, 'sddsdskldsfndsmndsdsn,dsn', 'jksaasjd d kdhasdjsdkj das j dasjkdsajashashsa jadkj ash das hjdsajdsa  jkda dajk dasdhsd kjsa dakj sa', '2021-10-06 16:13:08', 0, '2021-10-06 16:13:08'),
	(33, 'sdfkl sdm,dsfjk sdfkjf fjkfjkdsfhf kjsdjdsj sdkj', 'sdfkjdskjdsfkjdf jk sdf kjsdf kj dsf kjsdf  kjdsf jkdsf kjdsf  dsfjk', '2021-10-06 16:13:22', 0, '2021-10-06 16:13:22'),
	(34, 'Alvin', 'function has done', '2021-10-06 16:21:12', 0, '2021-10-06 16:21:12'),
	(35, 'templatename', 'this is a new template', '2021-10-06 16:21:35', 0, '2021-10-06 16:22:08'),
	(36, 'Brynne Berry', 'Atque libero eligend', '2021-10-06 16:24:13', 0, '2021-10-06 16:24:13');
/*!40000 ALTER TABLE `sms_template` ENABLE KEYS */;

-- Dumping structure for table laravel.staff_onboarding
CREATE TABLE IF NOT EXISTS `staff_onboarding` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `town` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `marital_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `national_insurance_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passport_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payslip_access_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payslip_access_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emergency_contact_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emergency_contact_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emergency_contact_relation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `terms_&_conditions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `onboarding_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `print_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.staff_onboarding: ~0 rows (approximately)
DELETE FROM `staff_onboarding`;
/*!40000 ALTER TABLE `staff_onboarding` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_onboarding` ENABLE KEYS */;

-- Dumping structure for table laravel.staff_onboarding_documents
CREATE TABLE IF NOT EXISTS `staff_onboarding_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `onboarding_id` tinyint(4) NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.staff_onboarding_documents: ~0 rows (approximately)
DELETE FROM `staff_onboarding_documents`;
/*!40000 ALTER TABLE `staff_onboarding_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_onboarding_documents` ENABLE KEYS */;

-- Dumping structure for table laravel.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified` int(11) NOT NULL DEFAULT '0',
  `manager` int(11) NOT NULL DEFAULT '0',
  `compliance_manager` int(11) NOT NULL DEFAULT '0',
  `administrator` int(11) NOT NULL DEFAULT '0',
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` int(11) NOT NULL DEFAULT '1',
  `branch_id` int(11) DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `test` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.users: ~23 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `password`, `email`, `telephone`, `verified`, `manager`, `compliance_manager`, `administrator`, `position`, `department`, `branch_id`, `deleted`, `test`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Muhammad Saad Alam', '$2y$10$8LcOJyXN.fLhHb1AD2aXP.oxMacmehKPZPF00LHxbhVfd3.Okyj3a', 'saadalam@gmail.com', NULL, 1, 1, 1, 1, 'doctor', 1, 1, 0, 1, NULL, NULL, '2021-09-21 14:59:38'),
	(2, 'saad shah', '$2y$10$9bdf2n1iEFwiyOdV1ae17eenLJ.XIWyKe8oTlrQD1Ptb05bB0BVHq', 'saad@gmail.com', NULL, 1, 0, 1, 1, NULL, 1, 1, 0, 0, NULL, NULL, '2021-09-22 13:00:44'),
	(3, 'saad shah', '$2y$10$18VebbeZ8klDziM88QGqSeLr1Bp1Uyj00E.Su7zAuo//KK79FN9Ky', 'ABEO7wSIiG@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(4, '0xlYv2gMSn', '$2y$10$IHXhJKGYbz9aieShJd.gZuTeuQoPxRL/.ES7hkc4gcAaIymuDoXVO', 'oHK1xW8KXg@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(5, 'BjgM85xReq', '$2y$10$Q7/Ar3AE7mb77wOJTIQqVOyCdJvmpLNZ30BoYvwc1LVXjSSqz1bwi', 'R8WDehvNaS@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(6, 'i4a03YO53M', '$2y$10$1RHVLAQQxSyeURr2IAUIaunn0RhvrrLFh3iqxg5pvc/lD5NDOCEVO', 'VW5t6G9i49@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(7, 'UZ6dLwjNpi', '$2y$10$0bsgVX6Q8j/csaPTtc/YtuAGefyA/OTLQvpYfglNCK6o.5Je1/MnW', 'Xw8RKximCq@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(8, '0H0PJJfX5P', '$2y$10$7x2Awtleha43VQgrHuMj2ewOx8SFtgyXLaOcVbxhQOZeFwQOVHij2', 'G2Sn8xxrIM@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 1, 0, 0, NULL, NULL, '2021-09-26 12:32:08'),
	(9, 'kjgYmvOzoP', '$2y$10$WMWGoIP8D.cG29VGJvinzem14EFoOjCVNSZ3WQK9PuYvbpCjs0EqS', '2sqW7CG39Y@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 1, 0, 0, NULL, NULL, '2021-09-26 12:32:02'),
	(10, 'mWg4qKLVlB', '$2y$10$V5wNqKjaeijEO2ppawICaOm3KQ5/ixzcvWiO256Rw5qkrXcqr23Ay', 'lIwzWZMUIS@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(11, 'n4vt914mak', '$2y$10$6iSHeE3y0Vv/tpUegCX5X.yNq4ApoROG5JcAXHE8Dg/wHJsnm2QzG', '2FChmVd96a@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(12, 'MUSVs0P4g0', '$2y$10$luzW0uJCyeHvDQ7yIcXwhO9JH7CyT.LaJn5r5fGlVFlhFhaXw7eg6', 'oh43XXvVhI@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(13, 'H3zBNLA99z', '$2y$10$6fFFQ0o1myGLAVpvz.BGZeVHSsjUaBf./eouENuHb3PNKgxcesEES', 'OGEyT1beem@gmail.com', NULL, 1, 1, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(14, 'f5mDFn61CA', '$2y$10$1g2lQFU6PNXCvpeKHC7l9u8/QXLfJRb.LoxJUyzOir4HOQBQlS0Bu', 'GtwML1Lsv8@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(15, 'pzf8CmDjGf', '$2y$10$Dg1/H6wfSp1q9ZyK0HI36OxDJwND3eqDmDNoMcXqaGwk5KniTfdGy', 'bQDV6aOzMg@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(16, 'bgNlKyp9uN', '$2y$10$UO4agHSZ/sZq491UAZF9C.EcY3qaElPV7sxuypPd7cSFAFHzeLhsm', 'TJTTtBwLiX@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(17, 'FECMaTHHGE', '$2y$10$6gdyZd/tEJYIot5esYkXMOznhyQKKYReOHdyb0kqKIZhDrQoC4PP2', 'maU4RiYxV5@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(18, 'GbVc1LRIlP', '$2y$10$yr7zNkPWeEgAiNCql1FUIudInSGBS9dtuBVNgFHdxLmRkaP3cPexW', 'kRL9z4vIUj@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(19, 'f8VHCOsYa4', '$2y$10$F2o69nSDLqMBXprVMFafPu6KIu5aJp2GhinsISanuvZdiZQz8ooKC', '7PSqpK6A7B@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(20, 'znd2H0rQJd', '$2y$10$/vLwUwVwdDLw0m.jOSaNrumczkA653Y51V21EMNEF9l/VlDGj.TGq', 'XbFqbxBOMz@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(21, 'l2IUGw4dQM', '$2y$10$AUrlMbBqRWjSNmcD30Qa0OZdjtvs4LB66SIq8a3TF.mv/uV/CzfMS', 'PNUaj2VYNw@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(22, 'Ih5kOqQzxo', '$2y$10$LvCbqIse.v46Xftbrd83bOA0DZAmqPY2bd48c71vpGZK/pO5jBI1a', 'BdcEMJBPwz@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL),
	(23, '0mS6GLSpkE', '$2y$10$oaVYqwWFiYlmd2PWAFrCpexQ135mB70M3zbiMgKVS/n/ijjREtkSO', 'gX8cTWT2RE@gmail.com', NULL, 1, 0, 0, 0, NULL, 1, 0, 0, 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table laravel.users_authorised_ips
CREATE TABLE IF NOT EXISTS `users_authorised_ips` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.users_authorised_ips: ~23 rows (approximately)
DELETE FROM `users_authorised_ips`;
/*!40000 ALTER TABLE `users_authorised_ips` DISABLE KEYS */;
INSERT INTO `users_authorised_ips` (`id`, `ip`, `user_id`, `deleted_at`, `created_at`, `updated_at`, `last_login`) VALUES
	(2, '127.0.0.1', 1, 0, NULL, '2021-10-07 12:13:41', '2021-10-07'),
	(45, '127.0.0.1', 2, 0, '2021-09-24 16:52:34', '2021-10-07 12:13:41', '2021-10-07'),
	(46, '127.0.0.1', 11, 0, '2021-09-24 16:59:55', '2021-10-07 12:13:41', '2021-09-26'),
	(47, '127.0.0.1', 11, 0, '2021-09-24 20:55:39', '2021-10-07 12:13:41', '2021-09-25'),
	(48, '127.0.0.1', 11, 0, '2021-09-24 21:34:03', '2021-10-07 12:13:41', '2021-09-25'),
	(49, '127.0.0.1', 11, 0, '2021-09-24 21:49:11', '2021-10-07 12:13:41', '2021-09-25'),
	(50, '127.0.0.1', 11, 0, '2021-09-24 21:53:17', '2021-10-07 12:13:41', '2021-09-25'),
	(51, '127.0.0.1', 11, 0, '2021-09-24 22:07:04', '2021-10-07 12:13:41', '2021-09-25'),
	(52, '123.4.5.6', 11, 0, '2021-09-24 22:12:00', '2021-09-24 22:12:00', '2021-09-25'),
	(53, '123.4.5.6', 11, 0, '2021-09-24 22:13:04', '2021-09-24 22:13:04', '2021-09-25'),
	(54, '123.4.5.6', 11, 0, '2021-09-24 22:13:18', '2021-09-24 22:13:18', '2021-09-25'),
	(55, '123.9.0.0', 11, 0, '2021-09-24 22:14:09', '2021-09-24 22:14:09', '2021-09-25'),
	(56, '123.4.5.6', 11, 0, '2021-09-24 22:15:34', '2021-09-24 22:15:34', '2021-09-25'),
	(57, '123.4.5.6', 11, 0, '2021-09-24 22:23:55', '2021-09-24 22:23:55', '2021-09-25'),
	(58, '123.9.9.9', 11, 0, '2021-09-24 22:24:51', '2021-09-24 22:24:51', '2021-09-25'),
	(59, '100.0.0.0', 11, 0, '2021-09-24 22:26:37', '2021-09-24 22:26:37', '2021-09-25'),
	(60, '123.4.5.6', 11, 0, '2021-09-25 16:32:50', '2021-09-26 13:09:45', '2021-09-25'),
	(61, '123.3.4.5', 11, 0, '2021-09-25 16:33:25', '2021-10-06 08:51:42', '2021-09-25'),
	(62, '123.4.5.6', 16, 0, '2021-10-06 08:51:55', '2021-10-06 09:24:59', NULL),
	(63, '123.5.6.7', 5, 0, '2021-10-06 13:56:37', '2021-10-06 13:56:37', NULL),
	(64, '123.0.0.1', 4, 0, '2021-10-06 13:57:47', '2021-10-06 16:22:33', NULL),
	(65, '123.0.0.9', 4, 0, '2021-10-06 16:22:48', '2021-10-07 12:06:34', NULL),
	(66, '123.4.5.6', 14, 0, '2021-10-07 12:09:12', '2021-10-07 12:09:25', NULL);
/*!40000 ALTER TABLE `users_authorised_ips` ENABLE KEYS */;

-- Dumping structure for table laravel.users_departments
CREATE TABLE IF NOT EXISTS `users_departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.users_departments: ~0 rows (approximately)
DELETE FROM `users_departments`;
/*!40000 ALTER TABLE `users_departments` DISABLE KEYS */;
INSERT INTO `users_departments` (`id`, `name`, `admin`, `created_at`, `updated_at`) VALUES
	(1, 'X-ray', 1, NULL, NULL);
/*!40000 ALTER TABLE `users_departments` ENABLE KEYS */;

-- Dumping structure for table laravel.users_failed_logins
CREATE TABLE IF NOT EXISTS `users_failed_logins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.users_failed_logins: ~0 rows (approximately)
DELETE FROM `users_failed_logins`;
/*!40000 ALTER TABLE `users_failed_logins` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_failed_logins` ENABLE KEYS */;

-- Dumping structure for table laravel.users_logs
CREATE TABLE IF NOT EXISTS `users_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.users_logs: ~21 rows (approximately)
DELETE FROM `users_logs`;
/*!40000 ALTER TABLE `users_logs` DISABLE KEYS */;
INSERT INTO `users_logs` (`id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-13 15:51:29', '2021-09-13 15:51:29'),
	(2, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-21 16:47:58', '2021-09-21 16:47:58'),
	(3, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-22 17:32:33', '2021-09-22 17:32:33'),
	(4, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-22 17:37:40', '2021-09-22 17:37:40'),
	(5, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 08:49:19', '2021-09-24 08:49:19'),
	(6, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 08:58:57', '2021-09-24 08:58:57'),
	(7, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 09:00:42', '2021-09-24 09:00:42'),
	(8, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 09:00:56', '2021-09-24 09:00:56'),
	(9, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 09:01:26', '2021-09-24 09:01:26'),
	(10, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 09:01:43', '2021-09-24 09:01:43'),
	(11, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 09:01:50', '2021-09-24 09:01:50'),
	(12, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 16:54:00', '2021-09-24 16:54:00'),
	(13, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 16:58:35', '2021-09-24 16:58:35'),
	(14, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 17:00:40', '2021-09-24 17:00:40'),
	(15, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-24 17:01:27', '2021-09-24 17:01:27'),
	(16, 1, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-25 21:21:55', '2021-09-25 21:21:55'),
	(17, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-26 13:32:49', '2021-09-26 13:32:49'),
	(18, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-26 13:33:51', '2021-09-26 13:33:51'),
	(19, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-27 10:17:00', '2021-09-27 10:17:00'),
	(20, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-27 10:17:22', '2021-09-27 10:17:22'),
	(21, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-27 10:18:07', '2021-09-27 10:18:07'),
	(22, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-09-27 10:19:31', '2021-09-27 10:19:31'),
	(23, 2, 'Attempt to login from unauthorised IP:127.0.0.1', '2021-10-04 16:47:46', '2021-10-04 16:47:46');
/*!40000 ALTER TABLE `users_logs` ENABLE KEYS */;

-- Dumping structure for table laravel.users_password_resets
CREATE TABLE IF NOT EXISTS `users_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.users_password_resets: ~0 rows (approximately)
DELETE FROM `users_password_resets`;
/*!40000 ALTER TABLE `users_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_password_resets` ENABLE KEYS */;

-- Dumping structure for table laravel.users_tasks
CREATE TABLE IF NOT EXISTS `users_tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff_assigned` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `repeat` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.users_tasks: ~2 rows (approximately)
DELETE FROM `users_tasks`;
/*!40000 ALTER TABLE `users_tasks` DISABLE KEYS */;
INSERT INTO `users_tasks` (`id`, `user_id`, `description`, `staff_assigned`, `status`, `repeat`, `deleted`, `created_at`, `updated_at`, `scheduled_at`) VALUES
	(1, 1, 'check patient', 2, 0, 1, 0, NULL, NULL, '2021-09-24 00:00:00'),
	(2, 1, 'check patient', 7, 0, 3, 0, NULL, NULL, '2021-10-06 00:00:00'),
	(3, 1, 'check patient', 19, 0, 1, 0, NULL, NULL, '2021-09-25 00:00:00');
/*!40000 ALTER TABLE `users_tasks` ENABLE KEYS */;

-- Dumping structure for table laravel.vaccinations
CREATE TABLE IF NOT EXISTS `vaccinations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vaccination_date` date NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `archived` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.vaccinations: ~0 rows (approximately)
DELETE FROM `vaccinations`;
/*!40000 ALTER TABLE `vaccinations` DISABLE KEYS */;
INSERT INTO `vaccinations` (`id`, `staff_id`, `last_name`, `vaccination_date`, `filename`, `url`, `created_at`, `updated_at`, `archived`) VALUES
	(1, '5', 'alam', '2021-09-27', 'covid.png', 'storage/covide/covid.png', NULL, NULL, 0);
/*!40000 ALTER TABLE `vaccinations` ENABLE KEYS */;

-- Dumping structure for table laravel.vaccination_proof
CREATE TABLE IF NOT EXISTS `vaccination_proof` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vaccination_date` date NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table laravel.vaccination_proof: ~0 rows (approximately)
DELETE FROM `vaccination_proof`;
/*!40000 ALTER TABLE `vaccination_proof` DISABLE KEYS */;
INSERT INTO `vaccination_proof` (`id`, `staff_id`, `last_name`, `vaccination_date`, `filename`, `url`, `created_at`, `updated_at`) VALUES
	(1, '5', 'alam', '2021-09-27', 'covid.png', 'storage/covid.png', NULL, NULL);
/*!40000 ALTER TABLE `vaccination_proof` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
