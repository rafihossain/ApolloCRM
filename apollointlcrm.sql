-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2022 at 06:34 AM
-- Server version: 10.3.37-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aptesttherssoftw_apollointlcrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(191) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_type` varchar(191) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `super_agent` int(11) DEFAULT NULL,
  `sub_agent` int(11) DEFAULT NULL,
  `agent_structure` int(11) DEFAULT NULL,
  `profile_image` varchar(128) DEFAULT NULL,
  `full_name` varchar(128) DEFAULT NULL,
  `business_name` varchar(128) DEFAULT NULL,
  `contact_name` varchar(128) DEFAULT NULL,
  `tax_number` varchar(128) DEFAULT NULL,
  `expiry_date` varchar(128) DEFAULT NULL,
  `phone_number` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `street` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `post_code` varchar(128) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `office_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `super_agent`, `sub_agent`, `agent_structure`, `profile_image`, `full_name`, `business_name`, `contact_name`, `tax_number`, `expiry_date`, `phone_number`, `email`, `street`, `city`, `state`, `post_code`, `country_id`, `office_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'images/agents/agents_1665989845_693478.jpg', NULL, 'Scarlett Simmons Update', 'Lillian Richards', '75', NULL, '(275) 177-3057', 'jyjehevic@mailinator.com', 'Natus sit ea eu ab', 'Velit porro corrupt', 'Non explicabo Dolor', 'Dolores repudiandae', 176, 1, 1, '2022-10-16 13:42:42', '2022-10-17 22:11:36'),
(2, 1, 1, 1, 'images/agents/agents_1666002286_282628.jpg', 'Aspen Schultz', NULL, NULL, NULL, NULL, '(213) 275-4184', 'hytorec@mailinator.com', 'Sapiente molestias p', 'Odio est enim vero f', 'Sit officia saepe v', 'Beatae sed quae corr', 187, 7, 2, '2022-10-17 10:16:08', '2022-10-17 22:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `workflow_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `stage_id` int(11) DEFAULT 1 COMMENT 'application=1,offer_letter=2,fee_payment=3,coe=4,visa_application=5,enrolment=6,course_ongoing=7,completed=4',
  `status` int(11) DEFAULT 0 COMMENT '1 = in progress, 2 = completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `workflow_id`, `partner_id`, `product_id`, `client_id`, `stage_id`, `status`, `created_at`, `updated_at`) VALUES
(7, 1, 17, 18, 3, 1, 0, '2022-09-19 21:35:01', '2022-09-19 21:35:01'),
(8, 1, 17, 18, 7, 1, 0, '2022-09-21 19:18:12', '2022-09-21 19:18:12'),
(9, 1, 17, 18, 8, 1, 0, '2022-09-27 21:47:43', '2022-09-27 21:47:43'),
(10, 1, 17, 18, 8, 1, 0, '2022-09-27 21:53:24', '2022-09-27 21:53:24'),
(11, 1, 17, 18, 9, 1, 0, '2022-10-30 21:17:08', '2022-10-30 21:17:08'),
(12, 2, 2, 1, 1, 1, 0, '2022-11-02 13:04:28', '2022-11-02 13:04:28'),
(13, 2, 2, 2, 2, 1, 0, '2022-11-02 13:51:33', '2022-11-02 13:51:33'),
(14, 4, 3, 8, 3, 1, 0, '2022-11-02 13:53:51', '2022-11-02 13:53:51'),
(15, 2, 2, 2, 4, 1, 0, '2022-11-03 07:15:10', '2022-11-03 07:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `application_options`
--

CREATE TABLE `application_options` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `application_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL DEFAULT '',
  `info_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `application_options`
--

INSERT INTO `application_options` (`id`, `client_id`, `application_id`, `category_id`, `type`, `info_value`, `created_at`, `updated_at`) VALUES
(1, 7, 8, 1, 'note', '{\"title\":\"sdfsfdf f\",\"description\":\"testertet\"}', '2022-09-29 22:54:31', '2022-09-29 22:54:31'),
(2, 7, 8, 2, 'note', '{\"title\":\"rest\",\"description\":\"<p>rrrerrr<\\/p>\"}', '2022-09-30 00:10:28', '2022-09-30 00:10:28'),
(3, 8, 9, 1, 'documentation', '{\"extenion\":\"docx\",\"file_name\":\"1664623014Project proposal.docx\",\"file_path\":\"\\/files\\/\"}', '2022-10-01 21:16:54', '2022-10-01 21:16:54'),
(4, 8, 9, 1, 'note', '{\"title\":\"rest\",\"description\":\"<p>resrter rs<\\/p>\"}', '2022-10-01 21:17:33', '2022-10-01 21:17:33'),
(5, 8, 9, 1, 'appointment', '{\"customRadio\":\"client\",\"client_name\":\"Bruno Britt\",\"date_time_date\":\"2022-10-01\",\"date_time_time\":\"12:00 PM\",\"title\":\"Dolore\",\"description\":\"Quaerat\",\"invitees\":\"Nobis\"}', '2022-10-02 00:05:44', '2022-10-02 00:05:44'),
(6, 7, 8, 1, 'documentation', '{\"extenion\":\"docx\",\"file_name\":\"1664623014Project proposal.docx\",\"file_path\":\"\\/files\\/\"}', '2022-10-01 21:16:54', '2022-10-01 21:16:54'),
(7, 8, 9, 1, 'task', '{\"attachment\":\"images\\/tasks\\/document_1665063519_139979.png\",\"title\":\"Explicabo Sunt ad\",\"category_id\":\"1\",\"assigee_id\":\"1\",\"priority_id\":\"4\",\"due_date\":\"28-Jan-1995\",\"description\":\"Sit similique quaera\"}', '2022-10-06 23:38:39', '2022-10-06 23:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `application_type_categories`
--

CREATE TABLE `application_type_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `application_type_categories`
--

INSERT INTO `application_type_categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Application', '2022-09-28 13:56:12', '2022-09-28 13:56:12'),
(2, 'Offer Letter', '2022-09-28 13:56:35', '2022-09-28 13:56:35'),
(3, 'Fee Payment', '2022-09-28 13:56:57', '2022-09-28 13:56:57'),
(4, 'COE', '2022-09-28 13:57:07', '2022-09-28 13:57:07'),
(5, 'Visa Application', '2022-09-28 13:57:16', '2022-09-28 13:57:16'),
(6, 'Enrolment', '2022-09-28 13:57:26', '2022-09-28 13:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `related_to` int(11) DEFAULT NULL COMMENT 'client = 1, partner = 2',
  `added_by` int(11) DEFAULT NULL,
  `partner_name` varchar(255) DEFAULT NULL,
  `timezone_id` int(11) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `invite` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `partner_id`, `client_id`, `related_to`, `added_by`, `partner_name`, `timezone_id`, `date`, `time`, `title`, `description`, `invite`, `created_at`, `updated_at`) VALUES
(5, 17, NULL, 2, 1, 'US Customs and Border Protection', 4, '2022-09-15', '12:00', 'appointment test update', 'appointment Description test', NULL, '2022-09-15 16:24:25', '2022-09-15 16:24:44'),
(7, NULL, 3, 1, 1, NULL, 1, '2022-09-19', '12:00', 'test title update', NULL, NULL, '2022-09-20 00:02:06', '2022-09-20 00:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `automations`
--

CREATE TABLE `automations` (
  `id` int(11) NOT NULL,
  `automation_name` varchar(255) DEFAULT NULL,
  `office_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `automations`
--

INSERT INTO `automations` (`id`, `automation_name`, `office_id`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Automation Update', 6, 1, 2, '2022-10-06 11:04:01', '2022-10-07 00:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `billing_histories`
--

CREATE TABLE `billing_histories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method` varchar(128) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `payment_date` varchar(128) DEFAULT NULL,
  `status` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `billing_histories`
--

INSERT INTO `billing_histories` (`id`, `user_id`, `payment_method`, `total_amount`, `payment_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Stripe', 57, '2022-10-25', 'succeeded', '2022-10-25 22:45:08', '2022-10-25 22:45:08'),
(2, 1, 'Paypal', 7, '2022-10-27', 'Success', '2022-10-27 19:56:03', '2022-10-27 19:56:03'),
(3, 1, 'Stripe', 7, '2022-10-27', 'succeeded', '2022-10-27 19:57:40', '2022-10-27 19:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(200) DEFAULT NULL,
  `status` tinyint(10) DEFAULT NULL,
  `brand_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand_name`, `status`, `brand_image`, `created_at`, `updated_at`) VALUES
(1, 'Microphone1', 2, '1660131620.jpg', '2022-08-10 11:40:20', '2022-08-10 12:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `business_invoice_address`
--

CREATE TABLE `business_invoice_address` (
  `id` int(11) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `business_invoice_address`
--

INSERT INTO `business_invoice_address` (`id`, `street`, `city`, `state`, `post_code`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'SUITE 1404, LEVEL 14, 97-99 BATHURST STREET', 'Dhaka', 'Queensland', '1200', 2, '2022-09-27 07:58:56', '2022-09-27 10:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `business_registration_number`
--

CREATE TABLE `business_registration_number` (
  `id` int(11) NOT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `business_registration_number`
--

INSERT INTO `business_registration_number` (`id`, `registration_number`, `created_at`, `updated_at`) VALUES
(1, '32457034757023945', '2022-09-27 07:52:51', '2022-09-27 09:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_image` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `client_dob` varchar(255) DEFAULT NULL,
  `client_id` varchar(128) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `contact_preference` tinyint(1) NOT NULL DEFAULT 0,
  `preferred_intake` varchar(255) DEFAULT NULL,
  `country_passport` int(11) DEFAULT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `visa_type` varchar(255) DEFAULT NULL,
  `visa_expiry` varchar(255) DEFAULT NULL,
  `application` int(11) DEFAULT 0,
  `assignee_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `client_status` int(11) NOT NULL DEFAULT 0 COMMENT 'prospect = 0, client = 1, archived = 2',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `client_image`, `first_name`, `last_name`, `client_dob`, `client_id`, `email`, `phone`, `street`, `city`, `state`, `post_code`, `country_id`, `contact_preference`, `preferred_intake`, `country_passport`, `passport_number`, `visa_type`, `visa_expiry`, `application`, `assignee_id`, `follower_id`, `source_id`, `tag_id`, `client_status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'images/clients/client_1667394267_914744.jpg', 'Suzan Demo', 'Thapa', '2022-11-02', NULL, 'sushan.me@mymail.com', '9851069568', NULL, 'Swoyambhu', NULL, NULL, 155, 0, NULL, 155, NULL, NULL, '2022-11-02', NULL, 1, 1, 3, 2, 1, '2022-11-02 13:04:28', '2022-11-03 13:40:03'),
(2, NULL, 'images/clients/client_1667397093_87443.jpg', 'Nikesh Demo', 'Shrestha', '2022-11-02', NULL, 'nikesh.shrestha@mymail.com', '9851042689', NULL, 'Jamal', NULL, NULL, 155, 0, NULL, 155, NULL, NULL, NULL, NULL, 1, 1, 3, NULL, 1, '2022-11-02 13:51:33', '2022-11-03 13:39:46'),
(3, NULL, 'images/clients/client_1667397231_879393.jpg', 'Diego Demo', 'Roberto', '2022-11-30', NULL, 'diego.roberto@mymail.com', '456936325', NULL, 'Melbourne', NULL, NULL, 14, 0, NULL, 14, NULL, NULL, NULL, NULL, 1, 1, 2, 2, 1, '2022-11-02 13:53:51', '2022-11-03 13:39:07'),
(4, NULL, 'images/clients/client_1667459710_44085.jpg', 'Nicholas', 'Marsh', '2022-11-03', '0', 'qawovoq@mailinator.com', '+1 (259) 969-6204', 'Mollitia eligendi ni', 'Quam esse id aperiam', 'Cumque et non vero d', 'Harum eius commodi a', 195, 0, '2022-11-03', 85, '166', 'Est nemo nemo eu dol', '2022-11-03', 1, 1, 1, NULL, NULL, 2, '2022-11-03 07:15:10', '2022-11-03 07:36:16'),
(5, NULL, 'images/clients/client_1667472575_269274.jpg', 'Ravi Demo', 'Singh', '2022-11-03', '#00001', 'ravi.singh@mymail.com', '01610701234', 'SUITE 1404, LEVEL 14, 97-99 BATHURST STREET', 'Dhaka', 'Queensland', '3000', 19, 0, 'Voluptatem ex et eum', 19, 'AZMY#9$0', 'student', '2022-10-29', NULL, 1, 1, 1, 1, 0, '2022-11-03 10:49:35', '2022-11-03 13:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `client_educations`
--

CREATE TABLE `client_educations` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `degree_title` varchar(255) DEFAULT NULL,
  `degree_level` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `course_start` varchar(255) DEFAULT NULL,
  `course_end` varchar(255) DEFAULT NULL,
  `subject_area` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `score_status` int(11) DEFAULT NULL,
  `score` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client_educations`
--

INSERT INTO `client_educations` (`id`, `client_id`, `degree_title`, `degree_level`, `institution`, `course_start`, `course_end`, `subject_area`, `subject_id`, `score_status`, `score`, `created_at`, `updated_at`) VALUES
(3, 3, 'Education Title', '1', 'Education Institute', '2022-09-22', '2022-09-22', NULL, 1, 1, '0', '2022-09-22 21:48:00', '2022-09-22 22:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `client_tags`
--

CREATE TABLE `client_tags` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `client_tags`
--

INSERT INTO `client_tags` (`id`, `tag_name`, `created_at`, `updated_at`) VALUES
(1, 'AUSTRALAIN CITIZEN -PR ALREADY', '2022-09-06 06:39:09', '2022-09-06 06:39:09'),
(2, 'DOCUMENTS- FOLLOW UP', '2022-09-06 06:39:09', '2022-09-06 06:39:09'),
(3, 'JUNK LEADS', '2022-09-06 06:39:09', '2022-09-06 06:39:09'),
(4, 'Migration Inquiry -Potential', '2022-09-06 06:39:09', '2022-09-06 06:39:09'),
(5, 'Migration Lead', '2022-09-06 06:39:09', '2022-09-06 06:39:09'),
(6, 'NEW LEAD', '2022-09-06 06:39:09', '2022-09-06 06:39:09'),
(7, 'OFFSHORE INQUIRY', '2022-09-06 06:39:09', '2022-09-06 06:39:09'),
(8, 'Potential- Follow UP', '2022-09-06 06:39:09', '2022-09-06 06:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `commentable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commentable_type` varchar(191) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `user_name` varchar(191) DEFAULT NULL,
  `order` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `moderated_by` int(10) UNSIGNED DEFAULT NULL,
  `moderated_at` datetime DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_emails`
--

CREATE TABLE `company_emails` (
  `id` int(11) NOT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'deactive = 0, active = 1',
  `incoming_email` int(11) DEFAULT NULL COMMENT 'all email = 1,\r\nonly agentcis email = 2',
  `display_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email_singature` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company_emails`
--

INSERT INTO `company_emails` (`id`, `email_id`, `status`, `incoming_email`, `display_name`, `user_id`, `email_singature`, `created_at`, `updated_at`) VALUES
(1, 'arrafi234@gmail.com', 0, 2, 'Display Name', 5, '<p>Company Email Signature<br></p>', '2022-09-28 10:39:30', '2022-09-28 23:37:01'),
(2, 'arrafi245@gmail.com', 1, 2, 'display name', 4, '<p>Company Email Signature<br></p>', '2022-09-28 13:03:10', '2022-09-28 13:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_fax` varchar(255) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `company_street` varchar(255) DEFAULT NULL,
  `company_city` varchar(255) DEFAULT NULL,
  `company_state` varchar(255) DEFAULT NULL,
  `company_zipcode` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `company_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `user_id`, `company_name`, `company_email`, `company_phone`, `company_fax`, `company_website`, `company_street`, `company_city`, `company_state`, `company_zipcode`, `country_id`, `company_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'therssoftware', 'nazmul@rssoft.win', '485818064', 'Company Fax', 'https://apollointlcrm.test/', 'Bonosree, Rampura, Dhaka', 'Dhaka', NULL, '1200', 19, 'images/company/company_1664198554_43217.jpg', '2022-09-26 13:15:02', '2022-09-26 23:42:24');

-- --------------------------------------------------------

--
-- Table structure for table `countrys`
--

CREATE TABLE `countrys` (
  `id` int(11) NOT NULL,
  `countrycode` varchar(5) NOT NULL,
  `countryname` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `countrys`
--

INSERT INTO `countrys` (`id`, `countrycode`, `countryname`, `code`) VALUES
(1, 'AFG', 'Afghanistan', 'AF'),
(2, 'ALA', 'Åland', 'AX'),
(3, 'ALB', 'Albania', 'AL'),
(4, 'DZA', 'Algeria', 'DZ'),
(5, 'ASM', 'American Samoa', 'AS'),
(6, 'AND', 'Andorra', 'AD'),
(7, 'AGO', 'Angola', 'AO'),
(8, 'AIA', 'Anguilla', 'AI'),
(9, 'ATA', 'Antarctica', 'AQ'),
(10, 'ATG', 'Antigua and Barbuda', 'AG'),
(11, 'ARG', 'Argentina', 'AR'),
(12, 'ARM', 'Armenia', 'AM'),
(13, 'ABW', 'Aruba', 'AW'),
(14, 'AUS', 'Australia', 'AU'),
(15, 'AUT', 'Austria', 'AT'),
(16, 'AZE', 'Azerbaijan', 'AZ'),
(17, 'BHS', 'Bahamas', 'BS'),
(18, 'BHR', 'Bahrain', 'BH'),
(19, 'BGD', 'Bangladesh', 'BD'),
(20, 'BRB', 'Barbados', 'BB'),
(21, 'BLR', 'Belarus', 'BY'),
(22, 'BEL', 'Belgium', 'BE'),
(23, 'BLZ', 'Belize', 'BZ'),
(24, 'BEN', 'Benin', 'BJ'),
(25, 'BMU', 'Bermuda', 'BM'),
(26, 'BTN', 'Bhutan', 'BT'),
(27, 'BOL', 'Bolivia', 'BO'),
(28, 'BES', 'Bonaire', 'BQ'),
(29, 'BIH', 'Bosnia and Herzegovina', 'BA'),
(30, 'BWA', 'Botswana', 'BW'),
(31, 'BVT', 'Bouvet Island', 'BV'),
(32, 'BRA', 'Brazil', 'BR'),
(33, 'IOT', 'British Indian Ocean Territory', 'IO'),
(34, 'VGB', 'British Virgin Islands', 'VG'),
(35, 'BRN', 'Brunei', 'BN'),
(36, 'BGR', 'Bulgaria', 'BG'),
(37, 'BFA', 'Burkina Faso', 'BF'),
(38, 'BDI', 'Burundi', 'BI'),
(39, 'KHM', 'Cambodia', 'KH'),
(40, 'CMR', 'Cameroon', 'CM'),
(41, 'CAN', 'Canada', 'CA'),
(42, 'CPV', 'Cape Verde', 'CV'),
(43, 'CYM', 'Cayman Islands', 'KY'),
(44, 'CAF', 'Central African Republic', 'CF'),
(45, 'TCD', 'Chad', 'TD'),
(46, 'CHL', 'Chile', 'CL'),
(47, 'CHN', 'China', 'CN'),
(48, 'CXR', 'Christmas Island', 'CX'),
(49, 'CCK', 'Cocos [Keeling] Islands', 'CC'),
(50, 'COL', 'Colombia', 'CO'),
(51, 'COM', 'Comoros', 'KM'),
(52, 'COK', 'Cook Islands', 'CK'),
(53, 'CRI', 'Costa Rica', 'CR'),
(54, 'HRV', 'Croatia', 'HR'),
(55, 'CUB', 'Cuba', 'CU'),
(56, 'CUW', 'Curacao', 'CW'),
(57, 'CYP', 'Cyprus', 'CY'),
(58, 'CZE', 'Czech Republic', 'CZ'),
(59, 'COD', 'Democratic Republic of the Congo', 'CD'),
(60, 'DNK', 'Denmark', 'DK'),
(61, 'DJI', 'Djibouti', 'DJ'),
(62, 'DMA', 'Dominica', 'DM'),
(63, 'DOM', 'Dominican Republic', 'DO'),
(64, 'TLS', 'East Timor', 'TL'),
(65, 'ECU', 'Ecuador', 'EC'),
(66, 'EGY', 'Egypt', 'EG'),
(67, 'SLV', 'El Salvador', 'SV'),
(68, 'GNQ', 'Equatorial Guinea', 'GQ'),
(69, 'ERI', 'Eritrea', 'ER'),
(70, 'EST', 'Estonia', 'EE'),
(71, 'ETH', 'Ethiopia', 'ET'),
(72, 'FLK', 'Falkland Islands', 'FK'),
(73, 'FRO', 'Faroe Islands', 'FO'),
(74, 'FJI', 'Fiji', 'FJ'),
(75, 'FIN', 'Finland', 'FI'),
(76, 'FRA', 'France', 'FR'),
(77, 'GUF', 'French Guiana', 'GF'),
(78, 'PYF', 'French Polynesia', 'PF'),
(79, 'ATF', 'French Southern Territories', 'TF'),
(80, 'GAB', 'Gabon', 'GA'),
(81, 'GMB', 'Gambia', 'GM'),
(82, 'GEO', 'Georgia', 'GE'),
(83, 'DEU', 'Germany', 'DE'),
(84, 'GHA', 'Ghana', 'GH'),
(85, 'GIB', 'Gibraltar', 'GI'),
(86, 'GRC', 'Greece', 'GR'),
(87, 'GRL', 'Greenland', 'GL'),
(88, 'GRD', 'Grenada', 'GD'),
(89, 'GLP', 'Guadeloupe', 'GP'),
(90, 'GUM', 'Guam', 'GU'),
(91, 'GTM', 'Guatemala', 'GT'),
(92, 'GGY', 'Guernsey', 'GG'),
(93, 'GIN', 'Guinea', 'GN'),
(94, 'GNB', 'Guinea-Bissau', 'GW'),
(95, 'GUY', 'Guyana', 'GY'),
(96, 'HTI', 'Haiti', 'HT'),
(97, 'HMD', 'Heard Island and McDonald Islands', 'HM'),
(98, 'HND', 'Honduras', 'HN'),
(99, 'HKG', 'Hong Kong', 'HK'),
(100, 'HUN', 'Hungary', 'HU'),
(101, 'ISL', 'Iceland', 'IS'),
(102, 'IND', 'India', 'IN'),
(103, 'IDN', 'Indonesia', 'ID'),
(104, 'IRN', 'Iran', 'IR'),
(105, 'IRQ', 'Iraq', 'IQ'),
(106, 'IRL', 'Ireland', 'IE'),
(107, 'IMN', 'Isle of Man', 'IM'),
(108, 'ISR', 'Israel', 'IL'),
(109, 'ITA', 'Italy', 'IT'),
(110, 'CIV', 'Ivory Coast', 'CI'),
(111, 'JAM', 'Jamaica', 'JM'),
(112, 'JPN', 'Japan', 'JP'),
(113, 'JEY', 'Jersey', 'JE'),
(114, 'JOR', 'Jordan', 'JO'),
(115, 'KAZ', 'Kazakhstan', 'KZ'),
(116, 'KEN', 'Kenya', 'KE'),
(117, 'KIR', 'Kiribati', 'KI'),
(118, 'XKX', 'Kosovo', 'XK'),
(119, 'KWT', 'Kuwait', 'KW'),
(120, 'KGZ', 'Kyrgyzstan', 'KG'),
(121, 'LAO', 'Laos', 'LA'),
(122, 'LVA', 'Latvia', 'LV'),
(123, 'LBN', 'Lebanon', 'LB'),
(124, 'LSO', 'Lesotho', 'LS'),
(125, 'LBR', 'Liberia', 'LR'),
(126, 'LBY', 'Libya', 'LY'),
(127, 'LIE', 'Liechtenstein', 'LI'),
(128, 'LTU', 'Lithuania', 'LT'),
(129, 'LUX', 'Luxembourg', 'LU'),
(130, 'MAC', 'Macao', 'MO'),
(131, 'MKD', 'Macedonia', 'MK'),
(132, 'MDG', 'Madagascar', 'MG'),
(133, 'MWI', 'Malawi', 'MW'),
(134, 'MYS', 'Malaysia', 'MY'),
(135, 'MDV', 'Maldives', 'MV'),
(136, 'MLI', 'Mali', 'ML'),
(137, 'MLT', 'Malta', 'MT'),
(138, 'MHL', 'Marshall Islands', 'MH'),
(139, 'MTQ', 'Martinique', 'MQ'),
(140, 'MRT', 'Mauritania', 'MR'),
(141, 'MUS', 'Mauritius', 'MU'),
(142, 'MYT', 'Mayotte', 'YT'),
(143, 'MEX', 'Mexico', 'MX'),
(144, 'FSM', 'Micronesia', 'FM'),
(145, 'MDA', 'Moldova', 'MD'),
(146, 'MCO', 'Monaco', 'MC'),
(147, 'MNG', 'Mongolia', 'MN'),
(148, 'MNE', 'Montenegro', 'ME'),
(149, 'MSR', 'Montserrat', 'MS'),
(150, 'MAR', 'Morocco', 'MA'),
(151, 'MOZ', 'Mozambique', 'MZ'),
(152, 'MMR', 'Myanmar [Burma]', 'MM'),
(153, 'NAM', 'Namibia', 'NA'),
(154, 'NRU', 'Nauru', 'NR'),
(155, 'NPL', 'Nepal', 'NP'),
(156, 'NLD', 'Netherlands', 'NL'),
(157, 'NCL', 'New Caledonia', 'NC'),
(158, 'NZL', 'New Zealand', 'NZ'),
(159, 'NIC', 'Nicaragua', 'NI'),
(160, 'NER', 'Niger', 'NE'),
(161, 'NGA', 'Nigeria', 'NG'),
(162, 'NIU', 'Niue', 'NU'),
(163, 'NFK', 'Norfolk Island', 'NF'),
(164, 'PRK', 'North Korea', 'KP'),
(165, 'MNP', 'Northern Mariana Islands', 'MP'),
(166, 'NOR', 'Norway', 'NO'),
(167, 'OMN', 'Oman', 'OM'),
(168, 'PAK', 'Pakistan', 'PK'),
(169, 'PLW', 'Palau', 'PW'),
(170, 'PSE', 'Palestine', 'PS'),
(171, 'PAN', 'Panama', 'PA'),
(172, 'PNG', 'Papua New Guinea', 'PG'),
(173, 'PRY', 'Paraguay', 'PY'),
(174, 'PER', 'Peru', 'PE'),
(175, 'PHL', 'Philippines', 'PH'),
(176, 'PCN', 'Pitcairn Islands', 'PN'),
(177, 'POL', 'Poland', 'PL'),
(178, 'PRT', 'Portugal', 'PT'),
(179, 'PRI', 'Puerto Rico', 'PR'),
(180, 'QAT', 'Qatar', 'QA'),
(181, 'COG', 'Republic of the Congo', 'CG'),
(182, 'REU', 'Réunion', 'RE'),
(183, 'ROU', 'Romania', 'RO'),
(184, 'RUS', 'Russia', 'RU'),
(185, 'RWA', 'Rwanda', 'RW'),
(186, 'BLM', 'Saint Barthélemy', 'BL'),
(187, 'SHN', 'Saint Helena', 'SH'),
(188, 'KNA', 'Saint Kitts and Nevis', 'KN'),
(189, 'LCA', 'Saint Lucia', 'LC'),
(190, 'MAF', 'Saint Martin', 'MF'),
(191, 'SPM', 'Saint Pierre and Miquelon', 'PM'),
(192, 'VCT', 'Saint Vincent and the Grenadines', 'VC'),
(193, 'WSM', 'Samoa', 'WS'),
(194, 'SMR', 'San Marino', 'SM'),
(195, 'STP', 'São Tomé and Príncipe', 'ST'),
(196, 'SAU', 'Saudi Arabia', 'SA'),
(197, 'SEN', 'Senegal', 'SN'),
(198, 'SRB', 'Serbia', 'RS'),
(199, 'SYC', 'Seychelles', 'SC'),
(200, 'SLE', 'Sierra Leone', 'SL'),
(201, 'SGP', 'Singapore', 'SG'),
(202, 'SXM', 'Sint Maarten', 'SX'),
(203, 'SVK', 'Slovakia', 'SK'),
(204, 'SVN', 'Slovenia', 'SI'),
(205, 'SLB', 'Solomon Islands', 'SB'),
(206, 'SOM', 'Somalia', 'SO'),
(207, 'ZAF', 'South Africa', 'ZA'),
(208, 'SGS', 'South Georgia and the South Sandwich Islands', 'GS'),
(209, 'KOR', 'South Korea', 'KR'),
(210, 'SSD', 'South Sudan', 'SS'),
(211, 'ESP', 'Spain', 'ES'),
(212, 'LKA', 'Sri Lanka', 'LK'),
(213, 'SDN', 'Sudan', 'SD'),
(214, 'SUR', 'Suriname', 'SR'),
(215, 'SJM', 'Svalbard and Jan Mayen', 'SJ'),
(216, 'SWZ', 'Swaziland', 'SZ'),
(217, 'SWE', 'Sweden', 'SE'),
(218, 'CHE', 'Switzerland', 'CH'),
(219, 'SYR', 'Syria', 'SY'),
(220, 'TWN', 'Taiwan', 'TW'),
(221, 'TJK', 'Tajikistan', 'TJ'),
(222, 'TZA', 'Tanzania', 'TZ'),
(223, 'THA', 'Thailand', 'TH'),
(224, 'TGO', 'Togo', 'TG'),
(225, 'TKL', 'Tokelau', 'TK'),
(226, 'TON', 'Tonga', 'TO'),
(227, 'TTO', 'Trinidad and Tobago', 'TT'),
(228, 'TUN', 'Tunisia', 'TN'),
(229, 'TUR', 'Turkey', 'TR'),
(230, 'TKM', 'Turkmenistan', 'TM'),
(231, 'TCA', 'Turks and Caicos Islands', 'TC'),
(232, 'TUV', 'Tuvalu', 'TV'),
(233, 'UMI', 'U.S. Minor Outlying Islands', 'UM'),
(234, 'VIR', 'U.S. Virgin Islands', 'VI'),
(235, 'UGA', 'Uganda', 'UG'),
(236, 'UKR', 'Ukraine', 'UA'),
(237, 'ARE', 'United Arab Emirates', 'AE'),
(238, 'GBR', 'United Kingdom', 'GB'),
(239, 'USA', 'United States', 'US'),
(240, 'URY', 'Uruguay', 'UY'),
(241, 'UZB', 'Uzbekistan', 'UZ'),
(242, 'VUT', 'Vanuatu', 'VU'),
(243, 'VAT', 'Vatican City', 'VA'),
(244, 'VEN', 'Venezuela', 'VE'),
(245, 'VNM', 'Vietnam', 'VN'),
(246, 'WLF', 'Wallis and Futuna', 'WF'),
(247, 'ESH', 'Western Sahara', 'EH'),
(248, 'YEM', 'Yemen', 'YE'),
(249, 'ZMB', 'Zambia', 'ZM'),
(250, 'ZWE', 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `currency_code` varchar(30) DEFAULT NULL,
  `currency_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `currency_code`, `currency_name`) VALUES
(1, 'AFA', 'Afghan Afghani'),
(2, 'ALL', 'Albanian Lek'),
(3, 'DZD', 'Algerian Dinar'),
(4, 'AOA', 'Angolan Kwanza'),
(5, 'ARS', 'Argentine Peso'),
(6, 'AMD', 'Armenian Dram'),
(7, 'AWG', 'Aruban Florin'),
(8, 'AUD', 'Australian Dollar'),
(9, 'AZN', 'Azerbaijani Manat'),
(10, 'BSD', 'Bahamian Dollar'),
(11, 'BHD', 'Bahraini Dinar'),
(12, 'BDT', 'Bangladeshi Taka'),
(13, 'BBD', 'Barbadian Dollar'),
(14, 'BYR', 'Belarusian Ruble'),
(15, 'BEF', 'Belgian Franc'),
(16, 'BZD', 'Belize Dollar'),
(17, 'BMD', 'Bermudan Dollar'),
(18, 'BTN', 'Bhutanese Ngultrum'),
(19, 'BTC', 'Bitcoin'),
(20, 'BOB', 'Bolivian Boliviano'),
(21, 'BAM', 'Bosnia-Herzegovina Convertible Mark'),
(22, 'BWP', 'Botswanan Pula'),
(23, 'BRL', 'Brazilian Real'),
(24, 'GBP', 'British Pound Sterling'),
(25, 'BND', 'Brunei Dollar'),
(26, 'BGN', 'Bulgarian Lev'),
(27, 'BIF', 'Burundian Franc'),
(28, 'KHR', 'Cambodian Riel'),
(29, 'CAD', 'Canadian Dollar'),
(30, 'CVE', 'Cape Verdean Escudo'),
(31, 'KYD', 'Cayman Islands Dollar'),
(32, 'XOF', 'CFA Franc BCEAO'),
(33, 'XAF', 'CFA Franc BEAC'),
(34, 'XPF', 'CFP Franc'),
(35, 'CLP', 'Chilean Peso'),
(36, 'CNY', 'Chinese Yuan'),
(37, 'COP', 'Colombian Peso'),
(38, 'KMF', 'Comorian Franc'),
(39, 'CDF', 'Congolese Franc'),
(40, 'CRC', 'Costa Rican ColÃ³n'),
(41, 'HRK', 'Croatian Kuna'),
(42, 'CUC', 'Cuban Convertible Peso'),
(43, 'CZK', 'Czech Republic Koruna'),
(44, 'DKK', 'Danish Krone'),
(45, 'DJF', 'Djiboutian Franc'),
(46, 'DOP', 'Dominican Peso'),
(47, 'XCD', 'East Caribbean Dollar'),
(48, 'EGP', 'Egyptian Pound'),
(49, 'ERN', 'Eritrean Nakfa'),
(50, 'EEK', 'Estonian Kroon'),
(51, 'ETB', 'Ethiopian Birr'),
(52, 'EUR', 'Euro'),
(53, 'FKP', 'Falkland Islands Pound'),
(54, 'FJD', 'Fijian Dollar'),
(55, 'GMD', 'Gambian Dalasi'),
(56, 'GEL', 'Georgian Lari'),
(57, 'DEM', 'German Mark'),
(58, 'GHS', 'Ghanaian Cedi'),
(59, 'GIP', 'Gibraltar Pound'),
(60, 'GRD', 'Greek Drachma'),
(61, 'GTQ', 'Guatemalan Quetzal'),
(62, 'GNF', 'Guinean Franc'),
(63, 'GYD', 'Guyanaese Dollar'),
(64, 'HTG', 'Haitian Gourde'),
(65, 'HNL', 'Honduran Lempira'),
(66, 'HKD', 'Hong Kong Dollar'),
(67, 'HUF', 'Hungarian Forint'),
(68, 'ISK', 'Icelandic KrÃ³na'),
(69, 'INR', 'Indian Rupee'),
(70, 'IDR', 'Indonesian Rupiah'),
(71, 'IRR', 'Iranian Rial'),
(72, 'IQD', 'Iraqi Dinar'),
(73, 'ILS', 'Israeli New Sheqel'),
(74, 'ITL', 'Italian Lira'),
(75, 'JMD', 'Jamaican Dollar'),
(76, 'JPY', 'Japanese Yen'),
(77, 'JOD', 'Jordanian Dinar'),
(78, 'KZT', 'Kazakhstani Tenge'),
(79, 'KES', 'Kenyan Shilling'),
(80, 'KWD', 'Kuwaiti Dinar'),
(81, 'KGS', 'Kyrgystani Som'),
(82, 'LAK', 'Laotian Kip'),
(83, 'LVL', 'Latvian Lats'),
(84, 'LBP', 'Lebanese Pound'),
(85, 'LSL', 'Lesotho Loti'),
(86, 'LRD', 'Liberian Dollar'),
(87, 'LYD', 'Libyan Dinar'),
(88, 'LTL', 'Lithuanian Litas'),
(89, 'MOP', 'Macanese Pataca'),
(90, 'MKD', 'Macedonian Denar'),
(91, 'MGA', 'Malagasy Ariary'),
(92, 'MWK', 'Malawian Kwacha'),
(93, 'MYR', 'Malaysian Ringgit'),
(94, 'MVR', 'Maldivian Rufiyaa'),
(95, 'MRO', 'Mauritanian Ouguiya'),
(96, 'MUR', 'Mauritian Rupee'),
(97, 'MXN', 'Mexican Peso'),
(98, 'MDL', 'Moldovan Leu'),
(99, 'MNT', 'Mongolian Tugrik'),
(100, 'MAD', 'Moroccan Dirham'),
(101, 'MZM', 'Mozambican Metical'),
(102, 'MMK', 'Myanmar Kyat'),
(103, 'NAD', 'Namibian Dollar'),
(104, 'NPR', 'Nepalese Rupee'),
(105, 'ANG', 'Netherlands Antillean Guilder'),
(106, 'TWD', 'New Taiwan Dollar'),
(107, 'NZD', 'New Zealand Dollar'),
(108, 'NIO', 'Nicaraguan CÃ³rdoba'),
(109, 'NGN', 'Nigerian Naira'),
(110, 'KPW', 'North Korean Won'),
(111, 'NOK', 'Norwegian Krone'),
(112, 'OMR', 'Omani Rial'),
(113, 'PKR', 'Pakistani Rupee'),
(114, 'PAB', 'Panamanian Balboa'),
(115, 'PGK', 'Papua New Guinean Kina'),
(116, 'PYG', 'Paraguayan Guarani'),
(117, 'PEN', 'Peruvian Nuevo Sol'),
(118, 'PHP', 'Philippine Peso'),
(119, 'PLN', 'Polish Zloty'),
(120, 'QAR', 'Qatari Rial'),
(121, 'RON', 'Romanian Leu'),
(122, 'RUB', 'Russian Ruble'),
(123, 'RWF', 'Rwandan Franc'),
(124, 'SVC', 'Salvadoran ColÃ³n'),
(125, 'WST', 'Samoan Tala'),
(126, 'SAR', 'Saudi Riyal'),
(127, 'RSD', 'Serbian Dinar'),
(128, 'SCR', 'Seychellois Rupee'),
(129, 'SLL', 'Sierra Leonean Leone'),
(130, 'SGD', 'Singapore Dollar'),
(131, 'SKK', 'Slovak Koruna'),
(132, 'SBD', 'Solomon Islands Dollar'),
(133, 'SOS', 'Somali Shilling'),
(134, 'ZAR', 'South African Rand'),
(135, 'KRW', 'South Korean Won'),
(136, 'XDR', 'Special Drawing Rights'),
(137, 'LKR', 'Sri Lankan Rupee'),
(138, 'SHP', 'St. Helena Pound'),
(139, 'SDG', 'Sudanese Pound'),
(140, 'SRD', 'Surinamese Dollar'),
(141, 'SZL', 'Swazi Lilangeni'),
(142, 'SEK', 'Swedish Krona'),
(143, 'CHF', 'Swiss Franc'),
(144, 'SYP', 'Syrian Pound'),
(145, 'STD', 'São Tomé and Príncipe Dobra'),
(146, 'TJS', 'Tajikistani Somoni'),
(147, 'TZS', 'Tanzanian Shilling'),
(148, 'THB', 'Thai Baht'),
(149, 'TOP', 'Tongan pa\'anga'),
(150, 'TTD', 'Trinidad & Tobago Dollar'),
(151, 'TND', 'Tunisian Dinar'),
(152, 'TRY', 'Turkish Lira'),
(153, 'TMT', 'Turkmenistani Manat'),
(154, 'UGX', 'Ugandan Shilling'),
(155, 'UAH', 'Ukrainian Hryvnia'),
(156, 'AED', 'United Arab Emirates Dirham'),
(157, 'UYU', 'Uruguayan Peso'),
(158, 'USD', 'US Dollar'),
(159, 'UZS', 'Uzbekistan Som'),
(160, 'VUV', 'Vanuatu Vatu'),
(161, 'VEF', 'Venezuelan BolÃ­var'),
(162, 'VND', 'Vietnamese Dong'),
(163, 'YER', 'Yemeni Rial'),
(164, 'ZMK', 'Zambian Kwacha');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL COMMENT 'client = 1, partner = 2, product = 3, application = 4',
  `section_id` int(11) DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `mandatory` int(11) DEFAULT NULL,
  `list_view` int(11) DEFAULT NULL,
  `workflow_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `module_id`, `section_id`, `field_name`, `field_id`, `mandatory`, `list_view`, `workflow_id`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'Custom Field Name', 1, 1, 2, NULL, '2022-10-01 09:51:36', '2022-10-01 13:47:23'),
(7, 2, 1, 'partner two', 1, 1, 2, NULL, '2022-10-01 13:44:16', '2022-10-01 13:45:19'),
(9, 3, 1, 'product one update', 2, 1, 2, NULL, '2022-10-01 13:50:15', '2022-10-01 13:53:16'),
(11, 4, 1, 'application one updated', 1, 1, 2, '1', '2022-10-01 13:57:38', '2022-10-01 13:58:47'),
(12, 4, 1, 'asdf', 2, 1, 2, '1,2,3', '2022-10-02 07:15:51', '2022-10-02 12:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `degree_levels`
--

CREATE TABLE `degree_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `degree_levels`
--

INSERT INTO `degree_levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Advance Diploma', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(2, 'Bachelor', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(3, 'Certificate', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(4, 'Diploma', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(5, 'Graduate Diploma', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(6, 'High School', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(7, 'Master', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(8, 'Master (Research)', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(9, 'Non AQF Award', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(10, 'PHD', '2022-09-21 09:51:48', '2022-09-21 09:51:48'),
(11, 'School', '2022-09-21 09:51:48', '2022-09-21 09:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `document_checklist`
--

CREATE TABLE `document_checklist` (
  `id` int(11) NOT NULL,
  `workflow_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `document_checklist`
--

INSERT INTO `document_checklist` (`id`, `workflow_id`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2022-10-12 09:09:19', '2022-10-12 09:09:19'),
(2, 3, 1, 1, '2022-10-13 21:13:23', '2022-10-13 21:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `document_total_checklist`
--

CREATE TABLE `document_total_checklist` (
  `id` int(11) NOT NULL,
  `checklist_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `checklist_status` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `apply_to` int(11) DEFAULT NULL,
  `select_partner` varchar(128) DEFAULT NULL,
  `product_to` int(11) DEFAULT NULL,
  `select_product` varchar(128) DEFAULT NULL,
  `upload_document` int(11) DEFAULT NULL,
  `mandatory_inorder` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `document_total_checklist`
--

INSERT INTO `document_total_checklist` (`id`, `checklist_id`, `document_type_id`, `checklist_status`, `description`, `apply_to`, `select_partner`, `product_to`, `select_product`, `upload_document`, `mandatory_inorder`, `created_at`, `updated_at`) VALUES
(7, 1, 3, 1, 'Salary Statement', 2, '17', 1, '1', 1, 1, '2022-10-13 07:43:32', '2022-10-13 07:43:32'),
(8, 1, 4, 1, 'Experience Letter', 2, '17', 2, '19', 1, 1, '2022-10-13 07:44:28', '2022-10-13 07:44:28'),
(11, 2, 4, 1, 'Experience Letter', 2, '17', 1, '1', 1, 1, '2022-10-13 21:14:01', '2022-10-13 21:14:01'),
(12, 2, 5, 1, 'Transcripts', 2, '17', 2, '18', 1, 1, '2022-10-13 21:14:56', '2022-10-13 21:14:56'),
(13, 2, 6, 7, 'Academic Certificates', 1, '1', 1, '1', 1, 1, '2022-10-13 21:16:12', '2022-10-13 21:16:12'),
(14, 2, 10, 7, 'to upload documents from client portal', 1, '1', 1, '1', NULL, NULL, '2022-10-13 21:16:34', '2022-10-13 21:16:34'),
(15, 2, 4, 5, 'ments from client porta', 1, '1', 1, '1', NULL, NULL, '2022-10-13 22:05:17', '2022-10-13 22:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(128) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `type_name`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Salary Statement', 1, 1, '2022-10-11 11:24:22', '2022-10-11 11:24:22'),
(4, 'Experience Letter', 1, 1, '2022-10-11 11:24:22', '2022-10-11 11:24:22'),
(5, 'Transcripts', 1, 1, '2022-10-11 11:24:22', '2022-10-11 11:24:22'),
(6, 'Academic Certificates', 1, 1, '2022-10-11 11:24:22', '2022-10-11 11:24:22'),
(7, 'Passport', 1, 1, '2022-10-11 11:24:22', '2022-10-11 11:24:22'),
(8, 'Citizenship', 1, 1, '2022-10-11 11:24:22', '2022-10-11 11:24:22'),
(9, 'OSHC Certificate', 1, 1, '2022-10-11 11:24:23', '2022-10-11 11:24:23'),
(10, 'Confirmation of Enrolment & Visa Grant Copy', 1, 1, '2022-10-11 11:25:03', '2022-10-11 11:25:03'),
(11, 'Confirmation of Enrolment', 1, 1, '2022-10-11 11:25:03', '2022-10-11 11:25:03'),
(12, 'Confirmation of Payment Receipts from Client/Agents', 1, 1, '2022-10-11 11:25:03', '2022-10-11 11:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `english_test_scores`
--

CREATE TABLE `english_test_scores` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `listening` int(11) DEFAULT NULL,
  `reading` int(11) DEFAULT NULL,
  `writing` int(11) DEFAULT NULL,
  `speaking` int(11) DEFAULT NULL,
  `overall_scores` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `english_test_scores`
--

INSERT INTO `english_test_scores` (`id`, `name`, `listening`, `reading`, `writing`, `speaking`, `overall_scores`, `created_at`, `updated_at`) VALUES
(1, 'TOEFL', 23, 2, 3, 4, 55, NULL, '2022-09-22 21:58:16'),
(2, 'IELTS', 21, 7, 8, 9, 10, NULL, '2022-09-22 10:26:35'),
(3, 'PTE', 24, 12, 13, 14, 15, NULL, '2022-09-22 10:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_types`
--

CREATE TABLE `fee_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fee_types`
--

INSERT INTO `fee_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Accommodation Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(2, 'Administration Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(3, 'Airline Ticket', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(4, 'Airport Transfer Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(5, 'Application Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(6, 'Bond', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(7, 'Exam Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(8, 'Date Change Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(9, 'Extension Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(10, 'Extra Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(11, 'FCE Exam Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(12, 'Health Cover', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(13, 'i20 Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(14, 'Instalment Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(15, 'Key Deposit Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(16, 'Late Payment Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(17, 'Material Deposit', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(18, 'Material Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(19, 'Medical Exam', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(20, 'Placement Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(21, 'Security Deposit Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(22, 'Service Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(23, 'Swipe Card Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(24, 'Training Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(25, 'Transaction Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(26, 'Translation Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(27, 'Travel Insurance', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(28, 'Tuition Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(29, 'Visa Counseling', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(30, 'Visa Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(31, 'Visa Process', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(32, 'RMA Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(33, 'Registered Migration Agent Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39'),
(34, 'Enrollment Fee', '2022-09-12 20:51:39', '2022-09-12 20:51:39');

-- --------------------------------------------------------

--
-- Table structure for table `field_names`
--

CREATE TABLE `field_names` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `field_names`
--

INSERT INTO `field_names` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Text', '2022-10-01 10:26:59', '2022-10-01 10:26:59'),
(2, 'Number', '2022-10-01 10:26:59', '2022-10-01 10:26:59'),
(3, 'Date', '2022-10-01 10:26:59', '2022-10-01 10:26:59'),
(4, 'Dropdown', '2022-10-01 10:26:59', '2022-10-01 10:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `general_aboutus`
--

CREATE TABLE `general_aboutus` (
  `id` int(11) NOT NULL,
  `about_us` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `general_aboutus`
--

INSERT INTO `general_aboutus` (`id`, `about_us`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sub Agent', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(2, 'Facebook Advert', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(3, 'Whatsapp', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(4, 'Social Media', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(5, 'Google', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(6, 'Other Online Sources', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(7, 'Office Check-In', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(8, 'Internal Seminar', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(9, 'Company Event', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(10, 'Sponsored Event', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(11, 'Education Fair', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(12, 'Friends & Relatives', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39'),
(13, 'TV Advertisement', 1, '2022-10-04 05:48:39', '2022-10-04 05:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `general_reasons`
--

CREATE TABLE `general_reasons` (
  `id` int(11) NOT NULL,
  `reason_name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `general_reasons`
--

INSERT INTO `general_reasons` (`id`, `reason_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Change of Application', 1, '2022-10-03 12:29:27', '2022-10-03 12:29:27'),
(2, 'Error by Team Member', 1, '2022-10-03 12:29:27', '2022-10-03 12:29:27'),
(3, 'Financial Difficulties', 1, '2022-10-03 12:29:27', '2022-10-03 12:29:27'),
(4, 'Loss of competitor', 1, '2022-10-03 12:29:27', '2022-10-03 12:29:27'),
(5, 'Other Reasons', 1, '2022-10-03 12:29:27', '2022-10-03 12:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `interested_services`
--

CREATE TABLE `interested_services` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `workflow_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `workflow_id` int(11) DEFAULT NULL,
  `currency` varchar(30) DEFAULT NULL,
  `invoice_type` varchar(30) DEFAULT NULL,
  `invoice_no` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_due_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '1=>"Paid",\r\n2="Unpaid"',
  `total_fee` double(10,2) DEFAULT NULL,
  `comission_amount` double(10,2) DEFAULT NULL,
  `income_amount` double(10,2) DEFAULT NULL,
  `discount_amount` double(10,2) DEFAULT NULL,
  `income_sharing` double(10,2) DEFAULT NULL,
  `other_payable` double(10,2) DEFAULT NULL,
  `net_income` double(10,2) DEFAULT NULL,
  `tax_received` double(10,2) DEFAULT NULL,
  `tax_paid` double(10,2) DEFAULT NULL,
  `paid_amount` double(10,2) DEFAULT NULL,
  `due_amount` double(10,2) DEFAULT NULL,
  `last_payment_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `client_id`, `partner_id`, `product_id`, `workflow_id`, `currency`, `invoice_type`, `invoice_no`, `invoice_date`, `invoice_due_date`, `status`, `total_fee`, `comission_amount`, `income_amount`, `discount_amount`, `income_sharing`, `other_payable`, `net_income`, `tax_received`, `tax_paid`, `paid_amount`, `due_amount`, `last_payment_date`, `created_at`, `updated_at`) VALUES
(1, 3, 17, 18, 1, 'USD', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-12 13:28:50', '2022-10-12 13:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `lead_forms`
--

CREATE TABLE `lead_forms` (
  `id` int(11) NOT NULL,
  `save_form_as` text DEFAULT NULL,
  `cover_image` varchar(100) DEFAULT NULL,
  `header_image` varchar(100) DEFAULT NULL,
  `header_title` text DEFAULT NULL,
  `header_text` text DEFAULT NULL,
  `system_fileds` text DEFAULT NULL,
  `custom_fileds` text DEFAULT NULL,
  `lead_form_link` text DEFAULT NULL,
  `embed_code` text DEFAULT NULL,
  `qr_code` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1=>''Active'',\r\n2=>''Deactive''',
  `favourite_status` int(11) NOT NULL DEFAULT 0 COMMENT '1=>favourite,\r\n2=>not_favourite,',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lead_forms`
--

INSERT INTO `lead_forms` (`id`, `save_form_as`, `cover_image`, `header_image`, `header_title`, `header_text`, `system_fileds`, `custom_fileds`, `lead_form_link`, `embed_code`, `qr_code`, `status`, `favourite_status`, `created_at`, `updated_at`) VALUES
(10, 'social-media-form', 'images/lead_form/document_1665919704_194117.jpg', 'images/lead_form/document_1665919705_178114.jpg', 'Let’s Get Connected', 'Hello bangladesh', '{\"state\":\"1\",\"postal_code\":\"1\",\"country\":\"1\",\"visa_type\":\"1\",\"visa_expiry_date\":\"1\",\"country_of_passport\":\"1\",\"preferred_intake\":\"1\",\"workflow\":0,\"partner\":0,\"australian_education\":\"1\",\"us_education\":\"1\",\"visa_service\":\"1\",\"accomodation_service\":\"1\",\"insurance_service\":\"1\",\"subject_area\":\"1\",\"subject\":\"1\",\"course_start\":\"1\",\"course_end\":\"1\",\"academic_score\":\"1\",\"tofel\":\"1\",\"IELTS\":\"1\",\"PTE\":\"1\",\"sat1\":\"1\",\"sat2\":\"1\",\"gre\":\"1\",\"gmat\":\"1\",\"upload_document\":\"1\",\"comment\":\"1\",\"related_office\":\"5\",\"source\":\"11\",\"tag_name\":\"5\",\"privacy_info\":\"<span style=\\\"color: rgb(91, 91, 91); font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\\\">We\'re committed to your privacy. We use the information you provide to us to contact you about our relevant content, products, and services. You may unsubscribe from these communications at any time by emailing us. For more information, check out our Privacy policy.<\\/span>\",\"consent\":\"<span style=\\\"color: rgb(91, 91, 91); font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\\\">I agree to Terms of Service and Privacy Policy. <\\/span>\",\"upload_profile_image\":\"1\",\"date_of_birth\":\"1\",\"phone\":\"1\",\"secondary_email\":\"1\",\"contact_preference\":\"1\",\"street\":\"1\",\"city\":\"1\",\"show_privacy_info\":\"1\"}', NULL, 'http://apollointlcrm.test/online-form/social-media-form', '<iframe src=\"https://therssoftware.agentcisapp.com/online-form/social-media-form\" frameborder=\"0\" style=\"width: 100%; border: none; min-height: 100vh;\" onload=\"window.parent.scrollTo(0,0)\"></iframe>', NULL, 1, 0, '2022-10-18 04:51:17', '2022-10-18 14:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `body` text DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `title`, `subject`, `body`, `documents`, `created_at`, `updated_at`) VALUES
(1, 'Visa Granted', 'Congratulation ?{Client First Name}?, your visa has been granted', '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">Hi <span class=\"ql-placeholder-content\" data-id=\"client_first_name\" data-label=\"Client First Name\" spellcheck=\"false\">?<span contenteditable=\"false\">{Client First Name}</span>?</span>,</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><br></p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">Congratulation !! We are so glad to inform you that your visa has been granted. Please contact your counselor - <span class=\"ql-placeholder-content\" data-id=\"client_assignee_name\" data-label=\"Client Assignee Name\" spellcheck=\"false\">?<span contenteditable=\"false\">{Client Assignee Name}</span>?</span> for further details.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><br></p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">In the meantime, please feel free to contact us, if you need any further help.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><br></p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">Best Regards,</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><span class=\"ql-placeholder-content\" data-id=\"tenant_name\" data-label=\"Company Name\" spellcheck=\"false\">?<span contenteditable=\"false\">{Company Name}</span>?</span> Team</p>', 'images/template/emaildocument_1664450960_421696.jpg', '2022-09-29 09:54:03', '2022-09-29 11:29:20'),
(3, 'Offer Letter Email', '?{Client First Name}?, we have received your offer letter', '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">Hi <span class=\"ql-placeholder-content\" data-id=\"client_first_name\" data-label=\"Client First Name\" spellcheck=\"false\">?<span contenteditable=\"false\">{Client First Name}</span>?</span>,</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><br></p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">Just to let you know that we have received an offer letter from the applied provider. Please contact your counselor - <span class=\"ql-placeholder-content\" data-id=\"client_assignee_name\" data-label=\"Client Assignee Name\" spellcheck=\"false\">?<span contenteditable=\"false\">{Client Assignee Name}</span>?</span> for further details.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><br></p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">We will keep you updated as your application progress further. In the meantime, please feel free to contact us, if you need any further help.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><br></p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\">Best Regards,</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(91, 91, 91); line-height: 1.5em; cursor: text; padding: 0px; counter-reset: b 0 c 0 d 0 e 0 f 0 g 0 h 0 i 0 j 0; font-family: Helvetica, Arial, sans-serif; font-size: 13px; white-space: pre-wrap;\"><span class=\"ql-placeholder-content\" data-id=\"tenant_name\" data-label=\"Company Name\" spellcheck=\"false\">?<span contenteditable=\"false\">{Company Name}</span>?</span> Team</p>', NULL, '2022-09-29 13:27:30', '2022-09-29 13:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `manually_payment_details`
--

CREATE TABLE `manually_payment_details` (
  `id` int(11) NOT NULL,
  `option_name` varchar(255) DEFAULT NULL,
  `details_content` varchar(255) DEFAULT NULL,
  `invoice_type` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `manually_payment_details`
--

INSERT INTO `manually_payment_details` (`id`, `option_name`, `details_content`, `invoice_type`, `created_at`, `updated_at`) VALUES
(2, 'Option Name Update', '<p>Test Description</p>', 1, '2022-09-27 12:27:31', '2022-09-27 13:31:01'),
(4, 'test payment update', '<p>payment details<br></p>', 4, '2022-09-28 17:48:48', '2022-09-28 17:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `mime_type` varchar(191) DEFAULT NULL,
  `disk` varchar(191) NOT NULL,
  `conversions_disk` varchar(191) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_03_11_062135_create_posts_table', 1),
(4, '2018_03_12_062135_create_categories_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2020_02_19_152418_create_permission_tables', 1),
(7, '2020_02_19_173115_create_activity_log_table', 1),
(8, '2020_02_19_173641_create_settings_table', 1),
(9, '2020_02_19_173700_create_userprofiles_table', 1),
(10, '2020_02_19_173711_create_notifications_table', 1),
(11, '2020_02_22_115918_create_user_providers_table', 1),
(12, '2020_05_01_163442_create_tags_table', 1),
(13, '2020_05_01_163833_create_polymorphic_taggables_table', 1),
(14, '2020_05_04_151517_create_comments_table', 1),
(15, '2020_10_27_155557_create_media_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 6),
(39, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` int(11) NOT NULL,
  `office_name` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `choose_admin` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `office_name`, `street`, `city`, `state`, `post_code`, `country_id`, `email`, `phone`, `mobile`, `contact_person`, `choose_admin`, `created_at`, `updated_at`) VALUES
(1, 'Head Office', 'SUITE 1404, LEVEL 14, 97-99 BATHURST STREET', 'Dhaka', 'NSW', '1200', 19, 'marketing.bd@apollointl.com.au', '+1 (185) 596-9964', NULL, 'Hasan Abdul Gofran', NULL, '2022-10-31 05:03:20', '2022-10-31 05:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `office_checkin`
--

CREATE TABLE `office_checkin` (
  `id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL DEFAULT 0,
  `purpose_mandatory` int(11) NOT NULL DEFAULT 0,
  `attending` int(11) NOT NULL DEFAULT 0,
  `completing` int(11) NOT NULL DEFAULT 0,
  `archiving` int(11) NOT NULL DEFAULT 0,
  `assignee_mandatory` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `office_visites`
--

CREATE TABLE `office_visites` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `visit_purpose` text DEFAULT NULL,
  `assigne_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `others_general`
--

CREATE TABLE `others_general` (
  `id` int(11) NOT NULL,
  `choose_criteria` int(11) DEFAULT 0 COMMENT 'internal = 1, client = 2',
  `internal_prefix` varchar(255) DEFAULT NULL,
  `date_format` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `others_general`
--

INSERT INTO `others_general` (`id`, `choose_criteria`, `internal_prefix`, `date_format`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, '1', '2022-10-03 13:55:12', '2022-10-04 05:30:28');

-- --------------------------------------------------------

--
-- Table structure for table `other_test_scores`
--

CREATE TABLE `other_test_scores` (
  `id` int(11) NOT NULL,
  `sat_one` int(11) DEFAULT NULL,
  `sat_two` int(11) DEFAULT NULL,
  `gre` int(11) DEFAULT NULL,
  `gmat` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `other_test_scores`
--

INSERT INTO `other_test_scores` (`id`, `sat_one`, `sat_two`, `gre`, `gmat`, `created_at`, `updated_at`) VALUES
(1, 4, 4, 4, 4, '2022-09-22 10:33:42', '2022-09-22 21:58:24');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `partner_image` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `workflow_id` varchar(50) DEFAULT NULL,
  `master_category_id` int(11) DEFAULT NULL,
  `partner_type` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `enrolled` int(11) DEFAULT NULL,
  `in_progress` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `partner_image`, `registration_number`, `workflow_id`, `master_category_id`, `partner_type`, `currency_id`, `street`, `city`, `state`, `post_code`, `country_id`, `phone_number`, `email`, `fax`, `website`, `product_id`, `enrolled`, `in_progress`, `created_at`, `updated_at`) VALUES
(1, 'University Of Sydney', 'images/partners/partner_1667309326_161081.jpg', NULL, '1,2', 1, 2, NULL, '1 City Road', 'Camperdown', 'NSW', NULL, NULL, '025555555555', 'marketing.bd@apollointl.com.au', NULL, 'qut.edu.au', NULL, NULL, NULL, '2022-11-01 13:28:47', '2022-11-01 13:50:59'),
(2, 'Queensland University of Tech', 'images/partners/partner_1667309463_499839.jpg', NULL, '2', 1, 2, 3, '2 George Street', 'Brisbane', 'Queensland', NULL, 14, NULL, 'enrolments@qut.edu.au', NULL, 'qut.edu.au', NULL, NULL, NULL, '2022-11-01 13:31:03', '2022-11-01 13:31:03'),
(3, 'ATMC', 'images/partners/partner_1667309569_327084.jpg', NULL, '4', 1, 2, 2, '540 George Street', 'Sydney', 'NSW', NULL, 14, NULL, 'admissions@atmc.edu.au', NULL, 'atmc.edu.au', NULL, NULL, NULL, '2022-11-01 13:32:50', '2022-11-01 13:32:50'),
(4, 'Louisiana State University', 'images/partners/partner_1667309687_409564.jpg', NULL, '3', 1, 2, 2, '114 West David Boyd', 'Baton Rouge', 'LA', NULL, 14, NULL, 'students@lsu.edu', NULL, 'lsu.edu', NULL, NULL, NULL, '2022-11-01 13:34:47', '2022-11-01 13:34:47'),
(5, 'Department of Home Affairs (AUS)', 'images/partners/partner_1667309779_841735.jpg', NULL, '3', 1, 2, 2, '26 Lee Street', 'Sydney', 'NSW', NULL, 14, NULL, 'visa@homeaffairs.gov.au', NULL, 'homeaffairs.gov.au', NULL, NULL, NULL, '2022-11-01 13:36:19', '2022-11-01 13:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `partner_agreements`
--

CREATE TABLE `partner_agreements` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `contract_expiry_date` varchar(255) DEFAULT NULL,
  `representing_regions` varchar(255) DEFAULT NULL,
  `commission_percentage` varchar(255) DEFAULT NULL,
  `default_super_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partner_branches`
--

CREATE TABLE `partner_branches` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `head_office` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partner_branches`
--

INSERT INTO `partner_branches` (`id`, `partner_id`, `name`, `email`, `country_id`, `city`, `state`, `street`, `post_code`, `phone_number`, `head_office`, `created_at`, `updated_at`) VALUES
(1, 1, 'Head Office', 'marketing.bd@apollointl.com.au', 0, '', '', '', '', '', 0, '2022-11-01 13:28:47', '2022-11-01 13:28:47'),
(2, 2, 'Head Office', 'marketing.bd@apollointl.com.au', 0, '', '', '', '', '', 0, '2022-11-01 13:31:03', '2022-11-01 13:31:03'),
(3, 3, 'Head Office', 'marketing.bd@apollointl.com.au', 0, '', '', '', '', '', 0, '2022-11-01 13:32:50', '2022-11-01 13:32:50'),
(4, 4, 'Head Office', 'students@lsu.edu', 0, '', '', '', '', '', 0, '2022-11-01 13:34:47', '2022-11-01 13:34:47'),
(5, 5, 'Head Office', 'visa@homeaffairs.gov.au', 0, '', '', '', '', '', 0, '2022-11-01 13:36:19', '2022-11-01 13:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `partner_contacts`
--

CREATE TABLE `partner_contacts` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT '',
  `fax` varchar(255) DEFAULT '',
  `department` varchar(255) DEFAULT '',
  `position` varchar(255) DEFAULT '',
  `primary_contact` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partner_master_categories`
--

CREATE TABLE `partner_master_categories` (
  `id` int(11) NOT NULL,
  `master_category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partner_master_categories`
--

INSERT INTO `partner_master_categories` (`id`, `master_category`, `created_at`, `updated_at`) VALUES
(1, 'Education', '2022-09-05 05:53:29', '2022-09-05 05:53:29'),
(2, 'Visa & Migration', '2022-09-05 05:53:29', '2022-09-05 05:53:29'),
(3, 'Insurance', '2022-09-05 05:53:50', '2022-09-05 05:53:50'),
(4, 'Accommodation', '2022-09-05 05:53:50', '2022-09-05 05:53:50'),
(5, 'Short Classes', '2022-09-05 05:54:18', '2022-09-05 05:54:18'),
(6, 'Skill Assessment', '2022-09-05 05:54:18', '2022-09-05 05:54:18'),
(7, 'Other Services', '2022-09-05 05:54:58', '2022-09-05 05:54:58'),
(8, 'Tours & Travel', '2022-09-05 05:54:58', '2022-09-05 05:54:58'),
(9, 'Tax & Accounting', '2022-09-05 05:55:15', '2022-09-05 05:55:15'),
(10, 'Professional Year', '2022-09-05 05:55:15', '2022-09-05 05:55:15'),
(11, 'Legal & Court', '2022-09-05 05:55:32', '2022-09-05 05:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `partner_notes`
--

CREATE TABLE `partner_notes` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `note_title` varchar(255) DEFAULT NULL,
  `note_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partner_notes`
--

INSERT INTO `partner_notes` (`id`, `partner_id`, `client_id`, `note_title`, `note_description`, `created_at`, `updated_at`) VALUES
(1, 17, NULL, 'Bangladesh Contact', 'contact description', '2022-09-13 07:48:09', '2022-09-13 11:32:29'),
(3, 17, NULL, 'test title', '<p>test update<br></p>', '2022-09-14 15:14:34', '2022-09-20 15:54:58'),
(4, NULL, 3, 'note title', '<p>test</p>', '2022-09-20 17:16:19', '2022-09-20 17:20:39'),
(6, NULL, 8, 'Quod quo quibusdam l', '<p>ertvfg</p>', '2022-10-08 18:36:55', '2022-10-08 18:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `partner_types`
--

CREATE TABLE `partner_types` (
  `id` int(11) NOT NULL,
  `partner_type` varchar(255) DEFAULT NULL,
  `master_category_id` int(11) DEFAULT NULL,
  `partner_status` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partner_types`
--

INSERT INTO `partner_types` (`id`, `partner_type`, `master_category_id`, `partner_status`, `created_at`, `updated_at`) VALUES
(1, 'Institution', 1, 1, '2022-09-05 05:59:09', '2022-09-05 05:59:09'),
(2, 'University', 1, 0, '2022-09-05 05:59:09', '2022-09-05 05:59:09'),
(3, 'College', 1, 0, '2022-09-05 05:59:33', '2022-09-05 05:59:33'),
(4, 'High School', 1, 0, '2022-09-05 05:59:33', '2022-09-05 05:59:33'),
(5, 'School', 1, 0, '2022-09-05 05:59:52', '2022-09-05 05:59:52'),
(6, 'Campus', 1, 0, '2022-09-05 05:59:52', '2022-09-05 05:59:52'),
(7, 'Training Center', 1, 0, '2022-09-05 06:00:17', '2022-09-05 06:00:17'),
(8, 'Visa Office', 2, 0, '2022-09-05 06:02:36', '2022-09-05 06:02:36'),
(9, 'Visa Department', 2, 0, '2022-09-05 06:02:36', '2022-09-05 06:02:36'),
(10, 'Insurance Provider', 3, 0, '2022-09-05 06:03:10', '2022-09-05 06:03:10'),
(11, 'Accommodation Provider', 4, 0, '2022-09-05 06:03:42', '2022-09-05 06:03:42'),
(12, 'Training Center', 5, 0, '2022-09-05 06:04:27', '2022-09-05 06:04:27'),
(13, 'Internal Instructor', 5, 0, '2022-09-05 06:04:27', '2022-09-05 06:04:27'),
(14, 'Private', 6, 0, '2022-09-05 06:05:06', '2022-09-05 06:05:06'),
(15, 'Government', 6, 0, '2022-09-05 06:05:06', '2022-09-05 06:05:06'),
(16, 'Service Provider', 7, 0, '2022-09-05 06:05:49', '2022-09-05 06:05:49'),
(17, 'Internal Other Department', 7, 0, '2022-09-05 06:05:49', '2022-09-05 06:05:49'),
(18, 'Tour Provider', 8, 0, '2022-09-05 06:06:32', '2022-09-05 06:06:32'),
(19, 'Airlines', 8, 0, '2022-09-05 06:06:32', '2022-09-05 06:06:32'),
(20, 'Hotels', 8, 0, '2022-09-05 06:07:17', '2022-09-05 06:07:17'),
(21, 'Tax Agent', 9, 0, '2022-09-05 06:07:17', '2022-09-05 06:07:17'),
(22, 'CA Firm', 9, 0, '2022-09-05 06:08:35', '2022-09-05 06:08:35'),
(23, 'CPA Firm', 9, 0, '2022-09-05 06:08:35', '2022-09-05 06:08:35'),
(24, 'Accounting Firm', 9, 0, '2022-09-05 06:08:35', '2022-09-05 06:08:35'),
(25, 'PY Provider', 10, 0, '2022-09-05 06:09:26', '2022-09-05 06:09:26'),
(26, 'Court', 11, 0, '2022-09-05 06:09:26', '2022-09-05 06:09:26'),
(27, 'Tribunal', 11, 0, '2022-09-05 06:09:40', '2022-09-05 06:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `permissions_category_id` int(11) DEFAULT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `original_name`, `permissions_category_id`, `guard_name`, `created_at`, `updated_at`) VALUES
(40, 'subscription_billing', 'Can view Subscription & Billing', 1, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(41, 'subscription_plan', 'Can change Subscription Plan', 1, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(42, 'cancel_subscription', 'Can Cancel Subscription', 1, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(43, 'primary_secondary', 'Can be assigned to Primary and Secondary Offices.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(44, 'create_edit_office', 'Can create new offices, edit and archive all the associated offices.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(45, 'associated_office', 'Can only view associated office details and its information.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(46, 'user_invite_change_status', 'Can invite users, cancel invitations, edit and change their status.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(47, 'view_user_list', 'Can only view users list and details of associated offices.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(48, 'view_guide', 'Can View Setup guide.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(49, 'import_partners_products', 'Can import Partners and Products from Agentcis database.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(50, 'access_service_page', 'Can access Service Page.', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(51, 'manage_roles_permissions', 'Can manage Roles and Permissions', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(52, 'change_primary_office', 'Can Change Primary Office', 2, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(53, 'add_edit_delete_workflow', 'Can add, edit and delete Workflow and its stages.', 3, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(54, 'add_edit_partner', 'Can add and edit partners.', 4, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(55, 'view_partner', 'Can only view partners information without commission percentage.', 4, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(56, 'delete_partner', 'Can delete partner.', 4, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(57, 'delete_contact', 'Can delete partner\'s primary contact', 4, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(58, 'import_csv_partner', 'Can import bulk information for partners through csv.', 4, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(59, 'add_edit_product', 'Can add and edit products.', 5, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(60, 'view_product', 'Can only view product\'s Information.', 5, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(61, 'delete_product', 'Can delete products.', 5, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(62, 'import_csv_product', 'Can import bulk information for product through csv.', 5, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(63, 'agents_list', 'Can only view agents list and details of associated offices.', 6, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(64, 'add_agents', 'Can add agents for their associated offices.', 6, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(65, 'edit_agents', 'Can edit agents of their associated offices.', 6, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(66, 'archive_agents', 'Can archive agents of their associated offices.', 6, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(67, 'restore_agents', 'Can restore agents of their associated offices.', 6, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(68, 'import_agent', 'Can import Agent from database', 6, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(69, 'view_clients', 'Can view all the clients of all the associated offices. Can assign clients to any users of the associated offices, respectively.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(70, 'add_edit_archive', 'Can add, edit and archive the clients.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(71, 'edit_archive', 'Can only edit and archive assigned clients.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(72, 'delete_client', 'Can delete client.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(73, 'delete_client_comment', 'Can delete client\'s comments.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(74, 'delete_clinet_service', 'Can delete client\'s interested services.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(75, 'import_clinet_csv', 'Can import bulk information for client through csv.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(76, 'view_edit_archive', 'Can view, edit and archive enquiries.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(77, 'view_archive', 'Can view archived enquiries.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(78, 'restore_archive', 'Can restore archived enquiries.', 7, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(79, 'view_service', 'Can view commission in product fees of Interested Services.', 8, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(80, 'edit_service', 'Can edit commission in product fees of Interested Services.', 8, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(81, 'view_sales_forecast', 'Can view sales forecast of interested services.', 8, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(82, 'edit_sales_forecast', 'Can edit sales forecast of interested services.', 8, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(83, 'create_applications', 'Can create applications.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(84, 'delete_applications', 'Can delete applications.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(85, 'setup_payment_schedule', 'Can setup payment schedule.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(86, 'create_payment_schedule', 'Can add a new payment schedule.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(87, 'edit_payment_schedule', 'Can edit a payment schedule.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(88, 'delete_payment_schedule', 'Can delete a payment schedule.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(89, 'view_edit_assign_primary', 'Can view/edit assigned and added application by the users of primary office.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(90, 'view_edit_assign_secondary', 'Can view/edit assigned and added application by the users of secondary office.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(91, 'view_product_fees_payment_schedule', 'Can view commission in product fees and payment schedule of application.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(92, 'edit_product_fees_payment_schedule', 'Can edit commission in product fees and payment schedule of application.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(93, 'view_sales_forecast', 'Can view sales forecast of application.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(94, 'edit_sales_forecast', 'Can edit sales forecast of application.', 9, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(95, 'create_invoices', 'Can create invoices of associated offices.', 10, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(96, 'add_edit_delete_client_invoice', 'Can add, edit, delete and make/revert payments of clients invoices of associated offices.', 10, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(97, 'add_edit_delete_only_assign_client', 'Can add, edit, delete and make/revert payments of invoices of only assigned clients.', 10, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(98, 'view_invoices', 'Can view invoices of only assigned clients.', 10, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(99, 'payments_revert_delete', 'Can make payments, revert and delete payables only of assigned clients invoices.', 10, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(100, 'view_agent_payables', 'Can view agent payables.', 10, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(101, 'create_quotations_templates', 'Can create quotation templates.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(102, 'edit_quotations_templates', 'Can edit quotation templates.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(103, 'delete_quotations_templates', 'Can delete quotation templates.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(104, 'view_quotations_templates', 'Can view quotation templates.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(105, 'create_quotations', 'Can create quotations.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(106, 'edit_quotations', 'Can edit quotations.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(107, 'archive_quotations', 'Can archive quotations.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(108, 'view_quotations', 'Can view quotations.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(109, 'delete_quotations', 'Can delete quotations.', 11, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(110, 'view_client_report', 'Can view Client and Application Reports.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(111, 'view_invoice_report', 'Can view Invoice Report.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(112, 'view_check_in_report', 'Can view Office Check-In Report.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(113, 'view_sales_forecast_report', 'Can view application sales forecast report.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(114, 'view_service_sales_forecast_report', 'Can view interested service sales forecast report.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(115, 'view_personal_task_report', 'Can view personal task report.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(116, 'view_all_task_report', 'Can view all task report.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(117, 'export_all_report', 'Can export all reports.', 12, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(118, 'partners_appointments', 'Can manage Partners appointments.', 13, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(119, 'create_tasks', 'Can create tasks.', 14, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(120, 'receive_notification', 'Can receive enquiries created notifications.', 15, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(121, 'receive_queue_notification', 'Can receive enquiries days in queue notifications.', 15, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(122, 'partner_expiry_date_notification', 'Can receive partner\'s contract expiry due date notification.', 15, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(123, 'receive_agent_contract_due_date_notification', 'Can receive agent\'s contract expiry due date notification.', 15, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(124, 'general_setting', 'Can manage general settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(125, 'company_profile_settings', 'Can manage company profile settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(126, 'view_users_primary', 'Can only view users primary office details.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(127, 'edit_assigned', 'Can edit assigned office settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(128, 'only_view_company_details', 'Can only view company details.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(129, 'manage_application_settings', 'Can manage application discontinue reasoning settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(130, 'add_edit_invoice_settings', 'Can add and edit invoice settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(131, 'add_edit_personal_email_settings', 'Can add and edit personal email settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(132, 'manage_email_notification', 'Can add and edit company email settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(133, 'add_edit_delete_email_templates', 'Can add, edit and delete email templates', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(134, 'view_workflow', 'Can only view workflow and its stages.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(135, 'add_edit_delete_partner_product_categories', 'Can add, edit and delete partner product categories.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(136, 'manage_automation_settings', 'Can manage automation settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(137, 'manage_api_settings', 'Can manage API settings', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(138, 'view_phone_number_settings', 'Can only view phone number settings.', 16, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(139, 'manage_custom_field', 'Can manage custom fields.', 17, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(140, 'manage_enquiry', 'Can manage enquiry forms.', 18, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(141, 'add_office_check_ins', 'Can add office check-ins.', 19, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(142, 'edit_office_check_ins', 'Can edit office check-ins.', 19, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(143, 'view_office_check_ins', 'Can view office check-ins assigned only.', 19, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(144, 'view_all_office_check_ins', 'Can view all office check-ins.', 19, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(145, 'delete_office_check_ins', 'Can delete office check-ins.', 19, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(146, 'view_role_kpi_target', 'Can view role\'s KPI target.', 20, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(147, 'add_role_kpi_target', 'Can add role\'s KPI target.', 20, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(148, 'edit_role_kpi_target', 'Can edit role\'s KPI target.', 20, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(149, 'delete_role_kpi_target', 'Can delete role\'s KPI target.', 20, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(150, 'view_user_kip_target', 'Can view user\'s KPI target.', 20, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(151, 'add_user_kip_target', 'Can add user\'s KPI target.', 20, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(152, 'add_rename_document', 'Can add and rename document type', 21, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(153, 'activate_deactive_document', 'Can activate/deactivate document type.', 21, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(154, 'add_edit_document_checklist', 'Can add and edit document checklist', 21, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29'),
(155, 'activate_deactive_document_checklist', 'Can activate/deactivate document checklist', 21, 'web', '2022-08-10 04:58:29', '2022-08-10 04:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `permission_categories`
--

CREATE TABLE `permission_categories` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(255) DEFAULT NULL,
  `permissions_original_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `permission_categories`
--

INSERT INTO `permission_categories` (`id`, `permission_name`, `permissions_original_text`, `created_at`, `updated_at`) VALUES
(1, 'subscription_billing', 'SUBSCRIPTION & BILLING', '2022-08-29 04:21:43', '2022-08-29 04:21:43'),
(2, 'office_teams', 'OFFICE & TEAMS', '2022-08-29 04:22:04', '2022-08-29 04:22:04'),
(3, 'workflows', 'WORKFLOWS', '2022-08-29 04:22:04', '2022-08-29 04:22:04'),
(4, 'partners', 'PARTNERS', '2022-08-29 04:22:20', '2022-08-29 04:22:20'),
(5, 'products', 'PRODUCTS', '2022-08-29 04:22:20', '2022-08-29 04:22:20'),
(6, 'agents', 'AGENTS', '2022-08-29 04:22:35', '2022-08-29 04:22:35'),
(7, 'clients', 'CLIENTS', '2022-08-29 04:22:35', '2022-08-29 04:22:35'),
(8, 'interested_services', 'INTERESTED SERVICES', '2022-08-29 04:22:50', '2022-08-29 04:22:50'),
(9, 'applications', 'APPLICATIONS', '2022-08-29 04:22:50', '2022-08-29 04:22:50'),
(10, 'accounts', 'ACCOUNTS', '2022-08-29 04:23:04', '2022-08-29 04:23:04'),
(11, 'quotations', 'QUOTATIONS', '2022-08-29 04:23:04', '2022-08-29 04:23:04'),
(12, 'reports', 'REPORTS', '2022-08-29 04:23:19', '2022-08-29 04:23:19'),
(13, 'appointments', 'APPOINTMENTS', '2022-08-29 04:23:19', '2022-08-29 04:23:19'),
(14, 'tasks', 'TASKS', '2022-08-29 04:23:35', '2022-08-29 04:23:35'),
(15, 'email_notifications', 'EMAIL NOTIFICATIONS', '2022-08-29 04:23:35', '2022-08-29 04:23:35'),
(16, 'settings', 'SETTINGS', '2022-08-29 04:23:50', '2022-08-29 04:23:50'),
(17, 'custom_fields', 'CUSTOM FIELDS', '2022-08-29 04:23:50', '2022-08-29 04:23:50'),
(18, 'enquiry_forms', 'ENQUIRY FORMS', '2022-08-29 04:24:05', '2022-08-29 04:24:05'),
(19, 'office_check_in', 'OFFICE CHECK-IN', '2022-08-29 04:24:05', '2022-08-29 04:24:05'),
(20, 'kpi_target', 'KPI TARGET', '2022-08-29 04:24:14', '2022-08-29 04:24:14'),
(21, 'document_checklist', 'DOCUMENT CHECKLIST', '2022-08-29 04:24:14', '2022-08-29 04:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `intro` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) DEFAULT NULL,
  `is_featured` int(11) DEFAULT NULL,
  `featured_image` varchar(191) DEFAULT NULL,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_og_image` varchar(191) DEFAULT NULL,
  `meta_og_url` varchar(191) DEFAULT NULL,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `moderated_by` int(10) UNSIGNED DEFAULT NULL,
  `moderated_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_by_name` varchar(191) DEFAULT NULL,
  `created_by_alias` varchar(191) DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priority_categories`
--

CREATE TABLE `priority_categories` (
  `id` int(11) NOT NULL,
  `priority_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `priority_categories`
--

INSERT INTO `priority_categories` (`id`, `priority_name`, `created_at`, `updated_at`) VALUES
(1, 'Low', '2022-09-14 10:07:35', '2022-09-14 10:07:35'),
(2, 'Normal', '2022-09-14 10:07:35', '2022-09-14 10:07:35'),
(3, 'High', '2022-09-14 10:07:35', '2022-09-14 10:07:35'),
(4, 'Urgent', '2022-09-14 10:07:35', '2022-09-14 10:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `product_type` int(11) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `enrolled` int(11) DEFAULT NULL,
  `in_progress` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `intake_month` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `partner_id`, `product_type`, `duration`, `enrolled`, `in_progress`, `branch_id`, `intake_month`, `note`, `created_at`, `updated_at`) VALUES
(1, 'Bachelors in Information Technology', NULL, 2, 1, NULL, 2, NULL, 2, 'Select Intake Month', NULL, '2022-11-01 13:37:45', '2022-11-01 13:37:45'),
(2, 'Bachelors in Intellectual Property Law', NULL, 2, 1, NULL, 1, NULL, 2, 'Select Intake Month', NULL, '2022-11-01 13:38:44', '2022-11-01 13:38:44'),
(3, 'Bachelors in Fine Arts', NULL, 2, 1, NULL, 2, NULL, 2, 'Select Intake Month', NULL, '2022-11-01 13:39:24', '2022-11-01 13:39:24'),
(4, 'Masters of Business Administration', NULL, 1, 3, NULL, 2, NULL, 1, 'Select Intake Month', NULL, '2022-11-01 13:40:16', '2022-11-01 13:40:16'),
(5, 'Masters of Actuary Studies', NULL, 1, 3, NULL, 2, NULL, 1, 'Select Intake Month', NULL, '2022-11-01 13:41:41', '2022-11-01 13:41:41'),
(6, 'Bachelors of Engineering', NULL, 4, 1, NULL, 2, NULL, 4, 'Select Intake Month', NULL, '2022-11-01 13:42:48', '2022-11-01 13:42:48'),
(7, 'Bachelors in Software Concepts', NULL, 4, 1, NULL, 2, NULL, 4, 'Select Intake Month', NULL, '2022-11-01 13:43:20', '2022-11-01 13:43:20'),
(8, 'Graduate Diploma of Management', NULL, 3, 1, NULL, 2, NULL, 3, 'Select Intake Month', NULL, '2022-11-01 13:44:16', '2022-11-01 13:44:16'),
(9, 'Masters of Professional Accounting', NULL, 3, 1, NULL, 2, NULL, 3, 'Select Intake Month', NULL, '2022-11-01 13:44:33', '2022-11-01 13:44:33'),
(10, 'Advance Diploma of Business', NULL, 3, 1, NULL, 2, NULL, 3, 'Select Intake Month', NULL, '2022-11-01 13:44:58', '2022-11-01 13:44:58'),
(11, 'Bachelors in Nursing', NULL, 2, 1, NULL, 2, NULL, 2, 'Select Intake Month', NULL, '2022-11-01 13:45:26', '2022-11-01 13:45:26'),
(12, 'Bachelors in Applied Science', NULL, 2, 1, NULL, 2, NULL, 2, 'Select Intake Month', NULL, '2022-11-01 13:45:49', '2022-11-01 13:45:49'),
(13, 'Student Visa (Subclass 500)', NULL, 5, 7, NULL, 2, NULL, 5, 'Select Intake Month', NULL, '2022-11-01 13:47:01', '2022-11-01 13:47:01'),
(14, 'Partner Visa (Subclass 801)', NULL, 5, 7, NULL, 2, NULL, 5, 'Select Intake Month', NULL, '2022-11-01 13:47:18', '2022-11-01 13:47:18'),
(15, 'ENS Visa ( Subclass 186)', NULL, 5, 7, NULL, 2, NULL, 5, 'Select Intake Month', NULL, '2022-11-01 13:47:36', '2022-11-01 13:47:36'),
(16, 'Visitor Visa (Subclass 600)', NULL, 5, 7, NULL, 2, NULL, 5, 'Select Intake Month', NULL, '2022-11-01 13:47:56', '2022-11-01 13:47:56'),
(17, 'Skilled Independent Visa (Subclass 189)', NULL, 5, 7, NULL, 2, NULL, 5, 'Select Intake Month', NULL, '2022-11-01 13:48:21', '2022-11-01 13:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_documentations`
--

CREATE TABLE `product_documentations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `file_name` text NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `author` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_documentations`
--

INSERT INTO `product_documentations` (`id`, `product_id`, `partner_id`, `client_id`, `file_name`, `file_size`, `author`, `created_at`, `updated_at`) VALUES
(4, 18, NULL, NULL, '1663051802-au-1.jpg', '150198', 1, '2022-09-13 16:50:02', '2022-09-13 16:50:02'),
(5, 0, 17, NULL, 'document_1663132568_715776.jpg', '105434', 1, '2022-09-14 15:16:08', '2022-09-14 15:16:08'),
(6, 0, NULL, 3, 'document_1663592656_262929.jpg', '216372', 1, '2022-09-19 23:04:16', '2022-09-19 23:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_fees_items`
--

CREATE TABLE `product_fees_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `fee_type_id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `client_revenue_type` varchar(255) NOT NULL DEFAULT '0',
  `commission_percentage` varchar(255) NOT NULL DEFAULT '0',
  `installments` int(11) NOT NULL DEFAULT 0,
  `amount_total` varchar(255) NOT NULL DEFAULT '0',
  `show_in_quotation` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_fees_items`
--

INSERT INTO `product_fees_items` (`id`, `product_id`, `fee_type_id`, `amount`, `client_revenue_type`, `commission_percentage`, `installments`, `amount_total`, `show_in_quotation`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '200', '1', '0', 1, '200', 0, '2022-09-13 23:29:21', '2022-09-14 23:24:34'),
(2, 1, 11, '344', '1', '0', 2, '688', 1, '2022-09-13 23:29:21', '2022-09-15 19:56:11'),
(4, 1, 6, '400', '1', '0', 1, '400', 1, '2022-09-14 23:28:17', '2022-09-15 19:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fee_term_id` int(11) NOT NULL DEFAULT 0,
  `nationality` text NOT NULL,
  `product_fee_items` varchar(255) NOT NULL DEFAULT '',
  `totals` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `product_id`, `name`, `fee_term_id`, `nationality`, `product_fee_items`, `totals`, `created_at`, `updated_at`) VALUES
(1, 18, 'New price', 1, '[\"1\",\"5\",\"6\"]', '[\"1\",\"2\",\"4\"]', '1288', '2022-09-13 23:29:21', '2022-09-15 19:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int(11) NOT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `master_category_id` int(11) DEFAULT NULL,
  `product_status` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `product_type`, `master_category_id`, `product_status`, `created_at`, `updated_at`) VALUES
(1, 'Course', 1, 1, '2022-09-07 07:27:21', '2022-09-07 10:05:23'),
(2, 'Short Course', 1, 1, '2022-09-07 07:41:34', '2022-09-07 07:41:34'),
(3, 'Higher Education Course', 1, 1, '2022-09-07 07:45:41', '2022-09-07 07:45:41'),
(4, 'VET Course', 1, 1, '2022-09-07 07:46:06', '2022-09-07 07:46:06'),
(5, 'Degree', 1, 1, '2022-09-07 07:46:44', '2022-09-07 07:46:44'),
(6, 'Immigration', 2, 1, '2022-09-07 07:47:05', '2022-09-07 07:47:05'),
(7, 'Visa Subclass', 2, 1, '2022-09-07 07:47:26', '2022-09-07 07:47:26'),
(8, 'Skill Occupation List', 2, 1, '2022-09-07 07:47:49', '2022-09-07 07:47:49'),
(9, 'Insurance policy', 3, 1, '2022-09-07 07:48:06', '2022-09-07 07:48:06'),
(10, 'Life Insurance', 3, 1, '2022-09-07 07:48:23', '2022-09-07 07:48:23'),
(11, 'Health Insurance', 3, 1, '2022-09-07 07:48:40', '2022-09-07 07:48:40'),
(12, 'Personal Insurance', 3, 1, '2022-09-07 07:52:15', '2022-09-07 07:52:15'),
(13, 'Property Insurance', 3, 1, '2022-09-07 07:52:31', '2022-09-07 07:52:31'),
(14, 'Marine Insurance', 3, 1, '2022-09-07 07:52:44', '2022-09-07 07:52:44'),
(15, 'Fire Insurance', 3, 1, '2022-09-07 07:52:57', '2022-09-07 07:52:57'),
(16, 'Liability Insurance', 3, 1, '2022-09-07 07:53:13', '2022-09-07 07:53:13'),
(17, 'Automobile Insurance', 3, 1, '2022-09-07 07:53:32', '2022-09-07 07:53:32'),
(18, 'Hotel', 4, 1, '2022-09-07 07:53:49', '2022-09-07 07:53:49'),
(19, 'Hostel', 4, 1, '2022-09-07 07:54:08', '2022-09-07 07:54:08'),
(20, 'Apartment', 4, 1, '2022-09-07 07:54:24', '2022-09-07 07:54:24'),
(21, 'HomeStay', 4, 1, '2022-09-07 07:54:41', '2022-09-07 07:54:41'),
(22, 'Rental Term', 4, 1, '2022-09-07 07:54:56', '2022-09-07 07:54:56'),
(23, 'Student Accommodation', 4, 1, '2022-09-07 07:55:08', '2022-09-07 07:55:08'),
(24, 'Class Option', 5, 1, '2022-09-07 07:55:22', '2022-09-07 07:55:22'),
(25, 'Internal Class', 5, 1, '2022-09-07 07:55:35', '2022-09-07 07:55:35'),
(26, 'English Class', 5, 1, '2022-09-07 07:55:49', '2022-09-07 07:55:49'),
(27, 'Skill Assessment', 6, 1, '2022-09-07 07:56:06', '2022-09-07 07:56:06'),
(28, 'Internal Service', 7, 1, '2022-09-07 07:56:35', '2022-09-07 07:56:35'),
(29, 'External Service', 7, 1, '2022-09-07 07:56:51', '2022-09-07 07:56:51'),
(30, 'Short Tours', 8, 1, '2022-09-07 07:57:35', '2022-09-07 07:57:35'),
(31, 'Air Ticket', 8, 1, '2022-09-07 07:58:00', '2022-09-07 07:58:00'),
(32, 'Short Hotel Accommodation', 8, 1, '2022-09-07 07:58:19', '2022-09-07 07:58:19'),
(33, 'Tax Return', 9, 1, '2022-09-07 07:58:38', '2022-09-07 07:58:38'),
(34, 'BAS Return', 9, 1, '2022-09-07 07:58:55', '2022-09-07 07:58:55'),
(35, 'Accounting', 9, 1, '2022-09-07 07:59:09', '2022-09-07 07:59:09'),
(36, 'Bookkeeping', 9, 1, '2022-09-07 07:59:22', '2022-09-07 07:59:22'),
(37, 'Accounting Professional Year', 10, 1, '2022-09-07 07:59:35', '2022-09-07 07:59:35'),
(38, 'IT Professional Year', 10, 1, '2022-09-07 07:59:51', '2022-09-07 07:59:51'),
(39, 'Decision', 11, 1, '2022-09-07 08:00:23', '2022-09-07 08:00:23'),
(40, 'Legal Case', 11, 1, '2022-09-07 08:00:37', '2022-09-07 08:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `apply_status` int(11) DEFAULT 1,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `date_start_end` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `partner_id`, `apply_status`, `title`, `description`, `attachment`, `date_start_end`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Promotion Title  One', 'Promotion Title  Description', 'images/promotions/promotion_1667392264_201663.jpg', '2022-11-02 to 2022-11-11', '8,9,10', '2022-11-02 11:24:51', '2022-11-02 12:31:04'),
(2, 3, 2, 'Promotion Title  Two', 'Promotion Title  Description', 'images/promotions/promotion_1667392229_310252.jpg', '2022-11-24 to 2022-11-26', '10', '2022-11-02 11:25:20', '2022-11-02 12:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `product_item` tinyint(2) DEFAULT NULL,
  `total_fee` varchar(255) DEFAULT '0',
  `status` tinyint(11) NOT NULL DEFAULT 0 COMMENT 'template=0,active=1,archived=2',
  `due_date` varchar(255) NOT NULL DEFAULT '',
  `office` int(11) NOT NULL DEFAULT 0,
  `quote_currency` varchar(255) NOT NULL DEFAULT '',
  `created_user` int(11) NOT NULL DEFAULT 0,
  `client_id` int(11) DEFAULT 0,
  `quotation_status` int(11) DEFAULT 1 COMMENT 'draft = 1, decline = 2',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `template_name`, `product_item`, `total_fee`, `status`, `due_date`, `office`, `quote_currency`, `created_user`, `client_id`, `quotation_status`, `created_at`, `updated_at`) VALUES
(1, 'Test Template', 2, '1300', 0, '2022-10-22', 1, '1', 1, 0, 1, '2022-10-22 23:07:11', '2022-10-22 23:09:59'),
(2, NULL, 3, '1400', 1, '2022-10-22 00:00', 0, '1', 1, 5, 1, '2022-10-22 23:10:28', '2022-10-22 23:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `service_fee` varchar(255) NOT NULL DEFAULT '0',
  `discount` varchar(255) NOT NULL DEFAULT '0',
  `net_fee` varchar(255) NOT NULL DEFAULT '0',
  `egx_rte` varchar(255) NOT NULL DEFAULT '0',
  `total_ammount` varchar(255) NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quotation_items`
--

INSERT INTO `quotation_items` (`id`, `quotation_id`, `workflow_id`, `partner_id`, `product_id`, `branch_id`, `description`, `service_fee`, `discount`, `net_fee`, `egx_rte`, `total_ammount`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 17, 18, 23, 'Tuition Fee', '1100', '0.00', '1100', '0.00', '1100', '2022-10-22 23:07:11', '2022-10-22 23:07:11'),
(2, 1, 1, 17, 18, 23, 'Tuition Fee', '200', '0.00', '200', '0.00', '200', '2022-10-22 23:09:59', '2022-10-22 23:09:59'),
(3, 2, 1, 17, 18, 23, 'Tuition Fee', '1100', '0.00', '1100', '0.00', '1100', '2022-10-22 23:10:28', '2022-10-22 23:10:28'),
(4, 2, 1, 17, 18, 23, 'Tuition Fee', '200', '0.00', '200', '0.00', '200', '2022-10-22 23:10:28', '2022-10-22 23:10:28'),
(5, 2, 1, 17, 18, 23, 'Tuition Fee', '100', '0.00', '100', '0.00', '100', '2022-10-22 23:17:53', '2022-10-22 23:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'web', '2022-08-10 04:58:28', '2022-08-10 04:58:28'),
(6, 'admin', 'web', '2022-08-28 20:18:45', '2022-08-28 20:18:45'),
(7, 'manager', 'web', '2022-08-28 23:47:22', '2022-08-28 23:47:22'),
(8, 'accountant', 'web', '2022-08-28 23:47:38', '2022-08-28 23:47:38'),
(9, 'counsellor', 'web', '2022-08-28 23:48:14', '2022-08-28 23:48:14'),
(10, 'operator', 'web', '2022-08-28 23:48:34', '2022-08-28 23:48:34'),
(11, 'director', 'web', '2022-08-28 23:48:55', '2022-08-28 23:48:55'),
(12, 'team leader - student recruitment', 'web', '2022-08-28 23:49:17', '2022-08-28 23:49:17'),
(13, 'team leader - admissions', 'web', '2022-08-28 23:49:42', '2022-08-28 23:49:42'),
(14, 'team member - admissions', 'web', '2022-08-28 23:50:02', '2022-08-28 23:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(40, 1),
(40, 9),
(41, 1),
(41, 9),
(43, 1),
(43, 6),
(43, 9),
(44, 1),
(44, 6),
(45, 1),
(45, 6),
(46, 1),
(46, 6),
(46, 7),
(47, 1),
(47, 6),
(47, 7),
(47, 9),
(48, 1),
(48, 6),
(48, 7),
(49, 1),
(49, 9),
(50, 1),
(50, 6),
(50, 7),
(51, 1),
(51, 9),
(52, 1),
(52, 7),
(52, 9),
(53, 1),
(53, 6),
(54, 1),
(54, 6),
(55, 1),
(55, 6),
(55, 7),
(56, 1),
(57, 1),
(58, 1),
(58, 6),
(58, 7),
(59, 1),
(59, 6),
(59, 13),
(60, 1),
(60, 6),
(60, 7),
(60, 8),
(61, 1),
(61, 8),
(62, 1),
(62, 6),
(62, 7),
(62, 8),
(63, 1),
(63, 6),
(63, 7),
(63, 8),
(63, 13),
(64, 1),
(64, 6),
(64, 7),
(64, 8),
(65, 1),
(65, 6),
(65, 7),
(65, 8),
(66, 1),
(66, 6),
(66, 7),
(66, 13),
(67, 1),
(67, 6),
(67, 7),
(67, 8),
(68, 1),
(68, 6),
(68, 7),
(69, 1),
(69, 6),
(69, 7),
(70, 1),
(70, 6),
(70, 7),
(71, 1),
(71, 6),
(71, 7),
(72, 1),
(72, 7),
(73, 1),
(74, 1),
(75, 1),
(75, 6),
(75, 7),
(75, 13),
(76, 1),
(76, 6),
(76, 7),
(77, 1),
(77, 6),
(78, 1),
(78, 6),
(79, 1),
(80, 1),
(81, 1),
(81, 6),
(81, 7),
(81, 12),
(82, 1),
(83, 1),
(83, 6),
(83, 7),
(84, 1),
(85, 1),
(85, 6),
(85, 7),
(86, 1),
(86, 6),
(86, 7),
(87, 1),
(87, 6),
(87, 7),
(88, 1),
(88, 6),
(88, 7),
(88, 12),
(88, 13),
(89, 1),
(89, 6),
(89, 7),
(90, 1),
(90, 6),
(90, 7),
(90, 12),
(91, 1),
(92, 1),
(92, 13),
(95, 1),
(95, 6),
(95, 7),
(96, 1),
(96, 6),
(96, 7),
(96, 12),
(97, 1),
(97, 6),
(97, 7),
(97, 12),
(98, 1),
(98, 6),
(98, 7),
(99, 1),
(99, 6),
(99, 7),
(100, 1),
(100, 6),
(100, 7),
(100, 12),
(101, 1),
(101, 6),
(101, 7),
(102, 1),
(102, 6),
(102, 7),
(103, 1),
(103, 6),
(103, 7),
(103, 12),
(104, 1),
(104, 6),
(104, 7),
(105, 1),
(105, 6),
(105, 7),
(106, 1),
(106, 6),
(106, 7),
(107, 1),
(107, 6),
(107, 7),
(107, 12),
(108, 1),
(108, 6),
(108, 7),
(109, 1),
(110, 1),
(110, 6),
(110, 7),
(111, 1),
(111, 6),
(111, 7),
(111, 11),
(112, 1),
(113, 1),
(113, 13),
(114, 1),
(114, 11),
(115, 1),
(116, 1),
(116, 7),
(116, 13),
(117, 1),
(117, 6),
(117, 7),
(118, 1),
(118, 6),
(118, 7),
(119, 1),
(119, 6),
(119, 7),
(119, 11),
(120, 1),
(120, 6),
(120, 7),
(120, 11),
(120, 13),
(121, 1),
(121, 6),
(121, 7),
(121, 11),
(122, 1),
(123, 1),
(123, 6),
(123, 7),
(123, 11),
(124, 1),
(125, 1),
(125, 6),
(126, 1),
(126, 6),
(127, 1),
(127, 6),
(128, 1),
(128, 6),
(129, 1),
(129, 6),
(130, 1),
(130, 6),
(131, 1),
(131, 6),
(132, 1),
(132, 6),
(133, 1),
(133, 6),
(134, 1),
(134, 6),
(134, 14),
(135, 1),
(135, 6),
(135, 14),
(136, 1),
(137, 1),
(137, 6),
(138, 1),
(138, 6),
(138, 14),
(139, 1),
(139, 6),
(140, 1),
(140, 6),
(141, 1),
(141, 6),
(142, 1),
(142, 6),
(143, 1),
(143, 6),
(143, 10),
(144, 1),
(144, 6),
(145, 1),
(145, 6),
(145, 10),
(146, 1),
(146, 10),
(147, 1),
(147, 10),
(148, 1),
(148, 10),
(148, 14),
(149, 1),
(149, 10),
(150, 1),
(150, 10),
(151, 1),
(151, 10),
(152, 1),
(152, 10),
(153, 1),
(154, 1),
(155, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_workflow_categories`
--

CREATE TABLE `service_workflow_categories` (
  `id` int(11) NOT NULL,
  `service_workflow` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `service_workflow_categories`
--

INSERT INTO `service_workflow_categories` (`id`, `service_workflow`, `created_at`, `updated_at`) VALUES
(1, 'Insurance Service', '2022-09-05 05:46:22', '2022-09-05 05:46:22'),
(2, 'Migration Service', '2022-09-05 05:46:22', '2022-09-05 05:46:22'),
(3, 'Offshore Application', '2022-09-05 05:46:59', '2022-09-05 05:46:59'),
(4, 'Onshore Application', '2022-09-05 05:46:59', '2022-09-05 05:46:59'),
(5, 'Professional Year', '2022-09-05 05:47:17', '2022-09-05 05:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `val` text DEFAULT NULL,
  `type` char(20) NOT NULL DEFAULT 'string',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_workflow`
--

CREATE TABLE `setting_workflow` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `accessible_id` int(11) NOT NULL DEFAULT 0,
  `office_id` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `setting_workflow`
--

INSERT INTO `setting_workflow` (`id`, `name`, `accessible_id`, `office_id`, `created_at`, `updated_at`) VALUES
(4, 'Australian Education', 2, '1,6', '2022-10-08 12:43:37', '2022-10-18 21:09:07'),
(5, 'Us Education F1', 1, NULL, '2022-10-10 05:39:03', '2022-10-10 11:14:03'),
(9, 'VISA Service', 1, NULL, '2022-10-10 11:15:01', '2022-10-10 11:15:01'),
(10, 'Accomodation Service', 1, NULL, '2022-10-10 11:16:11', '2022-10-10 11:16:11'),
(11, 'Insurance Service', 1, NULL, '2022-10-10 11:16:53', '2022-10-10 11:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `sms_templates`
--

CREATE TABLE `sms_templates` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sms_templates`
--

INSERT INTO `sms_templates` (`id`, `title`, `text_message`, `created_at`, `updated_at`) VALUES
(3, 'test two', '<p>{Client First Name}, text message<br></p>', '2022-09-29 13:25:37', '2022-09-29 13:25:37');

-- --------------------------------------------------------

--
-- Table structure for table `source_lists`
--

CREATE TABLE `source_lists` (
  `id` int(11) NOT NULL,
  `source_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `source_lists`
--

INSERT INTO `source_lists` (`id`, `source_name`, `created_at`, `updated_at`) VALUES
(1, 'Sub Agent', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(2, 'Facebook Ads', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(3, 'Whatsapp', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(4, 'Social Media', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(5, 'Google', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(6, 'Other Online Sources', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(7, 'Office Check-In', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(8, 'Internal Seminar', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(9, 'Company Event', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(10, 'Sponsored Event', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(11, 'Education Fair', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(12, 'Friends & Relatives', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(13, 'Visiting card QR', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(14, 'TV Advertisement', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(15, 'Newspaper Advertisement', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(16, 'Employee Referral', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(17, 'Reception', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(18, 'Partner', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(19, 'Zoho Bookings', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(20, 'External Referral', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(21, 'Live Chat', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(22, 'Lead Form - Automotive', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(23, 'ND - Nursing Form', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(24, 'ND - Nursing Form Melbourne', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(25, 'ND - PR Form', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(26, 'ND - PR Form Melbourne', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(27, 'ND - Visa Form', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(28, 'ND - Visa Form Melbourne', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(29, 'Sydney Scholarships Form 1', '2022-09-06 07:02:13', '2022-09-06 07:02:13'),
(30, 'Others', '2022-09-06 07:02:13', '2022-09-06 07:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 'Agriculture', 1, '2022-09-21 10:17:12', '2022-09-21 10:17:12'),
(2, 'Farm Management', 1, '2022-09-21 10:17:12', '2022-09-21 10:17:12'),
(3, 'Horticulture', 1, '2022-09-21 10:17:12', '2022-09-21 10:17:12'),
(4, 'Plant and Crop Sciences', 1, '2022-09-21 10:17:12', '2022-09-21 10:17:12'),
(5, 'Veterinary Medicine', 1, '2022-09-21 10:17:12', '2022-09-21 10:17:12'),
(6, 'Other Agriculture and Veterinary Medicine Courses', 1, '2022-09-21 10:17:12', '2022-09-21 10:17:12'),
(7, 'Astronomy', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(8, 'Biology', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(9, 'Biomedical Sciences', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(10, 'Chemistry', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(11, 'Earth Sciences', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(12, 'Environmental Sciences', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(13, 'Food Science and Technology', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(14, 'General Sciences', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(15, 'Life Sciences', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(16, 'Materials Sciences', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(17, 'Mathematics', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(18, 'Physical Geography', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(19, 'Physics', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(20, 'Sports Science', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(21, 'Other Applied and Pure Science Courses', 2, '2022-09-21 10:20:47', '2022-09-21 10:20:47'),
(22, 'Architecture', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(23, 'Built Environment', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(24, 'Construction', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(25, 'Maintenance Services', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(26, 'Planning', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(27, 'Property Management', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(28, 'Surveying', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(29, 'Other Architecture and Construction Courses', 3, '2022-09-21 10:23:06', '2022-09-21 10:23:06'),
(30, 'Accounting', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(31, 'Business Studies', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(32, 'E-Commerce', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(33, 'Entrepreneurship', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(34, 'Finance', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(35, 'Human Resource Management', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(36, 'Management', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(37, 'Marketing', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(38, 'MBA', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(39, 'Office Administration', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(40, 'Quality Management', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(41, 'Retail', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(42, 'Transportation and Logistics', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(43, 'Other Business and Management Courses', 4, '2022-09-21 10:26:28', '2022-09-21 10:26:28'),
(51, 'Computer Science', 5, '2022-09-21 10:38:23', '2022-09-21 10:38:23'),
(52, 'Computing', 5, '2022-09-21 10:38:23', '2022-09-21 10:38:23'),
(53, 'Computer Information Systems', 5, '2022-09-21 10:38:23', '2022-09-21 10:38:23'),
(54, 'IT', 5, '2022-09-21 10:38:23', '2022-09-21 10:38:23'),
(55, 'Multimedia', 55, '2022-09-21 10:38:23', '2022-09-21 10:38:23'),
(56, 'Software', 5, '2022-09-21 10:38:23', '2022-09-21 10:38:23'),
(57, 'Other Computer Science and IT Courses', 5, '2022-09-21 10:38:23', '2022-09-21 10:38:23'),
(58, 'Art', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(59, 'Art Administration', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(60, 'Crafts', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(61, 'Dance', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(62, 'Fashion and Textile Design', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(63, 'Graphic Design', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(64, 'Industrial Design', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(65, 'Interior Design', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(66, 'Music', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(67, 'Non - industrial Design', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(68, 'Theatre and Drama Studies', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(69, 'Other Creative Arts and Design Courses', 6, '2022-09-21 10:40:59', '2022-09-21 10:40:59'),
(70, 'Adult Education', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(71, 'CPD', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(72, 'Career Advice', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(73, 'Childhood Education', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(74, 'Coaching', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(75, 'Education Learning', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(76, 'Education Management', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(77, 'Education Research', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(78, 'Educational Psychology', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(79, 'Pedagogy', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(80, 'Special Education', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(81, 'Specialised Teaching', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(82, 'Teacher Training PGCE', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(83, 'Other Education and Training Courses', 7, '2022-09-21 10:44:05', '2022-09-21 10:44:05'),
(84, 'Aerospace Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(85, 'Biomedical Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(86, 'Chemical and Materials Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(87, 'Civil Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(88, 'Electrical Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(89, 'Electronic Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(90, 'Environmental Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(91, 'General Engineering and Technology', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(92, 'Manufacturing and Production', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(93, 'Marine Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(94, 'Mechanical Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(95, 'Metallurgy', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(96, 'Mining and Oil & Gas Operations', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(97, 'Power and Energy Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(98, 'Quality Control', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(99, 'Structural Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(100, 'Telecommunications', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(101, 'Vehicle Engineering', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(102, 'Other Engineering Courses', 8, '2022-09-21 11:47:01', '2022-09-21 11:47:01'),
(103, 'Complementary Health', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(104, 'Counselling', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(105, 'Dentistry', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(106, 'Health Studies', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(107, 'Health and Safety', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(108, 'Medicine', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(109, 'Midwifery', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(110, 'Nursing', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(111, 'Nutrition and Health', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(112, 'Ophthalmology', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(113, 'Pharmacology', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(114, 'Physiology', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(115, 'Physiotherapy', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(116, 'Psychology', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(117, 'Public Health', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(118, 'Other Health and Medicine Courses', 9, '2022-09-21 11:50:18', '2022-09-21 11:50:18'),
(119, 'Archaeology', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(120, 'Classics', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(121, 'Cultural Studies', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(122, 'English Studies', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(123, 'General Studies', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(124, 'History', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(125, 'Languages', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(126, 'Literature', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(127, 'Museum Studies', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(128, 'Philosophy', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(129, 'Regional Studies', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(130, 'Religious Studies', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(131, 'Other Humanities Courses', 10, '2022-09-21 11:53:26', '2022-09-21 11:53:26'),
(132, 'Civil Law', 11, '2022-09-21 11:55:02', '2022-09-21 11:55:02'),
(133, 'Criminal Law', 11, '2022-09-21 11:55:02', '2022-09-21 11:55:02'),
(134, 'International Law', 11, '2022-09-21 11:55:02', '2022-09-21 11:55:02'),
(135, 'Legal Advice', 11, '2022-09-21 11:55:02', '2022-09-21 11:55:02'),
(136, 'Legal Studies', 11, '2022-09-21 11:55:02', '2022-09-21 11:55:02'),
(137, 'Public Law', 11, '2022-09-21 11:55:02', '2022-09-21 11:55:02'),
(138, 'Other Law Courses', 11, '2022-09-21 11:55:02', '2022-09-21 11:55:02'),
(139, 'Aromatherapy', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(140, 'Beauty Therapy', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(141, 'Hairdressing', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(142, 'Health and Fitness', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(143, 'Massage', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(144, 'Reflexology', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(145, 'Therapeutic', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(146, 'Other Personal Care and Fitness Courses', 12, '2022-09-21 11:56:45', '2022-09-21 11:56:45'),
(147, 'Anthropology', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(148, 'Economics', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(149, 'Environmental Management', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(150, 'Film & Television', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(151, 'Human Geography', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(152, 'International Development', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(153, 'International relations', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(154, 'Journalism', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(155, 'Library Studies', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(156, 'Linguistics', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(157, 'Media', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(158, 'Photography', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(159, 'Politics', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(160, 'Public Administration', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(161, 'Social Sciences', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(162, 'Social Work', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(163, 'Sociology', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(164, 'Writing', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(165, 'Other Social Studies and Media Courses', 13, '2022-09-21 12:00:19', '2022-09-21 12:00:19'),
(166, 'Aviation', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01'),
(167, 'Catering', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01'),
(168, 'Food and Drink Production', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01'),
(169, 'Hospitality', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01'),
(170, 'Hotel Management', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01'),
(171, 'Leisure Management', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01'),
(172, 'Travel and Tourism', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01'),
(173, 'Other Travel and Hospitality Courses', 14, '2022-09-21 12:02:01', '2022-09-21 12:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `subject_area`
--

CREATE TABLE `subject_area` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subject_area`
--

INSERT INTO `subject_area` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Agriculture and Veterinary Medicine', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(2, 'Applied and Pure Science', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(3, 'Architecture and Construction', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(4, 'Business and Management', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(5, 'Computer Science and IT', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(6, 'Creative Arts and Design', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(7, 'Education and Training', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(8, 'Engineering', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(9, 'Health and Medicine', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(10, 'Humanities', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(11, 'Law', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(12, 'Personal Care and Fitness', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(13, 'Social Studies and Media', '2022-09-21 10:09:23', '2022-09-21 10:09:23'),
(14, 'Travel and Hospitality', '2022-09-21 10:09:23', '2022-09-21 10:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_billings`
--

CREATE TABLE `subscription_billings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_name` varchar(128) DEFAULT NULL,
  `mode_name` varchar(128) DEFAULT NULL,
  `total_user` int(11) DEFAULT NULL,
  `mode_unit` int(11) DEFAULT NULL,
  `mode_total` float DEFAULT NULL,
  `storage_unit` float DEFAULT NULL,
  `storage_total` int(11) DEFAULT NULL,
  `inbox_unit` float DEFAULT NULL,
  `inbox_total` int(11) DEFAULT NULL,
  `outbox_total` int(11) DEFAULT NULL,
  `outbox_unit` float DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subscription_billings`
--

INSERT INTO `subscription_billings` (`id`, `user_id`, `plan_name`, `mode_name`, `total_user`, `mode_unit`, `mode_total`, `storage_unit`, `storage_total`, `inbox_unit`, `inbox_total`, `outbox_total`, `outbox_unit`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'monthly', 'Basic', 1, 7, 0, 0, 50, 0, 2000, 2000, 0, 7, '2022-10-25 22:44:58', '2022-10-27 19:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_type` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `user_id`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'tag1', NULL, 1, NULL, NULL, '2022-11-03 11:06:10', '2022-11-03 11:06:10', NULL),
(2, 'tag2', NULL, 1, NULL, NULL, '2022-11-03 11:06:10', '2022-11-03 11:06:10', NULL),
(3, 'tag3', NULL, 1, NULL, NULL, '2022-11-03 11:06:10', '2022-11-03 11:06:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `assigee_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `due_date` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT 'toda = 1, inprogress = 2, onreview = 3, completed = 4',
  `related` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `partner_id`, `client_id`, `title`, `category_id`, `assigee_id`, `priority_id`, `due_date`, `description`, `attachment`, `follower_id`, `status`, `related`, `contact_id`, `stage_id`, `application_id`, `created_at`, `updated_at`) VALUES
(7, NULL, NULL, 'client', 2, 2, 3, '2022-09-25 12:00', 'client description', 'images/tasks/document_1664100162_847285.jpg', 4, 1, 1, 3, NULL, NULL, '2022-09-25 10:02:42', '2022-09-25 10:02:42'),
(8, 17, NULL, 'partner', 5, 3, 2, '2022-09-25 12:00', 'partner details', 'images/tasks/document_1664100212_647157.jpg', 4, 1, 2, NULL, NULL, NULL, '2022-09-25 10:03:32', '2022-09-25 10:03:32'),
(9, NULL, 7, 'application', 4, 3, 2, '2022-09-25 12:00', 'application details', 'images/tasks/document_1664100253_200413.jpg', 4, 1, 3, NULL, 1, 8, '2022-09-25 10:04:13', '2022-09-25 10:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `task_categories`
--

CREATE TABLE `task_categories` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `task_categories`
--

INSERT INTO `task_categories` (`id`, `task_name`, `created_at`, `updated_at`) VALUES
(1, 'Reminder', '2022-09-14 10:01:21', '2022-09-14 10:01:21'),
(2, 'Call', '2022-09-14 10:01:21', '2022-09-14 10:01:21'),
(3, 'Follow Up', '2022-09-14 10:01:21', '2022-09-14 10:01:21'),
(4, 'Email', '2022-09-14 10:01:21', '2022-09-14 10:01:21'),
(5, 'Meeting', '2022-09-14 10:01:21', '2022-09-14 10:01:21'),
(6, 'Support', '2022-09-14 10:01:21', '2022-09-14 10:01:21'),
(7, 'Others', '2022-09-14 10:01:21', '2022-09-14 10:01:21');

-- --------------------------------------------------------

--
-- Table structure for table `tax_settings`
--

CREATE TABLE `tax_settings` (
  `id` int(11) NOT NULL,
  `tax_code` varchar(255) DEFAULT NULL,
  `tax_rate` varchar(255) DEFAULT NULL,
  `set_default` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tax_settings`
--

INSERT INTO `tax_settings` (`id`, `tax_code`, `tax_rate`, `set_default`, `created_at`, `updated_at`) VALUES
(1, 'test1', '8951', NULL, '2022-09-28 07:36:38', '2022-09-28 07:36:38'),
(2, 'test2', '8952', NULL, '2022-09-28 07:36:38', '2022-09-28 07:36:38'),
(3, 'test3', '8953', NULL, '2022-09-28 07:36:38', '2022-09-28 07:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` int(11) NOT NULL,
  `group` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `group`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'US', 'Puerto Rico (Atlantic)', 'America/Puerto_Rico', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(2, 'US', 'New York (Eastern)', 'America/New_York', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(3, 'US', 'Chicago (Central)', 'America/Chicago', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(4, 'US', 'Denver (Mountain)', 'America/Denver', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(5, 'US', 'Phoenix (MST)', 'America/Phoenix', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(6, 'US', 'Los Angeles (Pacific)', 'America/Los_Angeles', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(7, 'US', 'Anchorage (Alaska)', 'America/Anchorage', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(8, 'US', 'Honolulu (Hawaii)', 'Pacific/Honolulu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(9, 'America', 'Adak', 'America/Adak', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(10, 'America', 'Anchorage', 'America/Anchorage', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(11, 'America', 'Anguilla', 'America/Anguilla', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(12, 'America', 'Antigua', 'America/Antigua', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(13, 'America', 'Araguaina', 'America/Araguaina', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(14, 'America', 'Argentina - Buenos Aires', 'America/Argentina/Buenos_Aires', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(15, 'America', 'Argentina - Catamarca', 'America/Argentina/Catamarca', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(16, 'America', 'Argentina - ComodRivadavia', 'America/Argentina/ComodRivadavia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(17, 'America', 'Argentina - Cordoba', 'America/Argentina/Cordoba', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(18, 'America', 'Argentina - Jujuy', 'America/Argentina/Jujuy', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(19, 'America', 'Argentina - La Rioja', 'America/Argentina/La_Rioja', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(20, 'America', 'Argentina - Mendoza', 'America/Argentina/Mendoza', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(21, 'America', 'Argentina - Rio Gallegos', 'America/Argentina/Rio_Gallegos', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(22, 'America', 'Argentina - Salta', 'America/Argentina/Salta', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(23, 'America', 'Argentina - San Juan', 'America/Argentina/San_Juan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(24, 'America', 'Argentina - San Luis', 'America/Argentina/San_Luis', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(25, 'America', 'Argentina - Tucuman', 'America/Argentina/Tucuman', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(26, 'America', 'Argentina - Ushuaia', 'America/Argentina/Ushuaia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(27, 'America', 'Aruba', 'America/Aruba', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(28, 'America', 'Asuncion', 'America/Asuncion', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(29, 'America', 'Atikokan', 'America/Atikokan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(30, 'America', 'Atka', 'America/Atka', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(31, 'America', 'Bahia', 'America/Bahia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(32, 'America', 'Barbados', 'America/Barbados', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(33, 'America', 'Belem', 'America/Belem', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(34, 'America', 'Belize', 'America/Belize', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(35, 'America', 'Blanc-Sablon', 'America/Blanc-Sablon', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(36, 'America', 'Boa Vista', 'America/Boa_Vista', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(37, 'America', 'Bogota', 'America/Bogota', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(38, 'America', 'Boise', 'America/Boise', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(39, 'America', 'Buenos Aires', 'America/Buenos_Aires', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(40, 'America', 'Cambridge Bay', 'America/Cambridge_Bay', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(41, 'America', 'Campo Grande', 'America/Campo_Grande', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(42, 'America', 'Cancun', 'America/Cancun', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(43, 'America', 'Caracas', 'America/Caracas', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(44, 'America', 'Catamarca', 'America/Catamarca', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(45, 'America', 'Cayenne', 'America/Cayenne', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(46, 'America', 'Cayman', 'America/Cayman', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(47, 'America', 'Chicago', 'America/Chicago', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(48, 'America', 'Chihuahua', 'America/Chihuahua', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(49, 'America', 'Coral Harbour', 'America/Coral_Harbour', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(50, 'America', 'Cordoba', 'America/Cordoba', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(51, 'America', 'Costa Rica', 'America/Costa_Rica', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(52, 'America', 'Cuiaba', 'America/Cuiaba', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(53, 'America', 'Curacao', 'America/Curacao', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(54, 'America', 'Danmarkshavn', 'America/Danmarkshavn', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(55, 'America', 'Dawson', 'America/Dawson', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(56, 'America', 'Dawson Creek', 'America/Dawson_Creek', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(57, 'America', 'Denver', 'America/Denver', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(58, 'America', 'Detroit', 'America/Detroit', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(59, 'America', 'Dominica', 'America/Dominica', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(60, 'America', 'Edmonton', 'America/Edmonton', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(61, 'America', 'Eirunepe', 'America/Eirunepe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(62, 'America', 'El Salvador', 'America/El_Salvador', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(63, 'America', 'Ensenada', 'America/Ensenada', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(64, 'America', 'Fortaleza', 'America/Fortaleza', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(65, 'America', 'Fort Wayne', 'America/Fort_Wayne', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(66, 'America', 'Glace Bay', 'America/Glace_Bay', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(67, 'America', 'Godthab', 'America/Godthab', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(68, 'America', 'Goose Bay', 'America/Goose_Bay', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(69, 'America', 'Grand Turk', 'America/Grand_Turk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(70, 'America', 'Grenada', 'America/Grenada', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(71, 'America', 'Guadeloupe', 'America/Guadeloupe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(72, 'America', 'Guatemala', 'America/Guatemala', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(73, 'America', 'Guayaquil', 'America/Guayaquil', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(74, 'America', 'Guyana', 'America/Guyana', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(75, 'America', 'Halifax', 'America/Halifax', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(76, 'America', 'Havana', 'America/Havana', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(77, 'America', 'Hermosillo', 'America/Hermosillo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(78, 'America', 'Indiana - Indianapolis', 'America/Indiana/Indianapolis', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(79, 'America', 'Indiana - Knox', 'America/Indiana/Knox', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(80, 'America', 'Indiana - Marengo', 'America/Indiana/Marengo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(81, 'America', 'Indiana - Petersburg', 'America/Indiana/Petersburg', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(82, 'America', 'Indiana - Tell City', 'America/Indiana/Tell_City', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(83, 'America', 'Indiana - Vevay', 'America/Indiana/Vevay', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(84, 'America', 'Indiana - Vincennes', 'America/Indiana/Vincennes', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(85, 'America', 'Indiana - Winamac', 'America/Indiana/Winamac', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(86, 'America', 'Indianapolis', 'America/Indianapolis', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(87, 'America', 'Inuvik', 'America/Inuvik', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(88, 'America', 'Iqaluit', 'America/Iqaluit', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(89, 'America', 'Jamaica', 'America/Jamaica', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(90, 'America', 'Jujuy', 'America/Jujuy', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(91, 'America', 'Juneau', 'America/Juneau', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(92, 'America', 'Kentucky - Louisville', 'America/Kentucky/Louisville', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(93, 'America', 'Kentucky - Monticello', 'America/Kentucky/Monticello', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(94, 'America', 'Knox IN', 'America/Knox_IN', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(95, 'America', 'La Paz', 'America/La_Paz', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(96, 'America', 'Lima', 'America/Lima', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(97, 'America', 'Los Angeles', 'America/Los_Angeles', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(98, 'America', 'Louisville', 'America/Louisville', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(99, 'America', 'Maceio', 'America/Maceio', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(100, 'America', 'Managua', 'America/Managua', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(101, 'America', 'Manaus', 'America/Manaus', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(102, 'America', 'Marigot', 'America/Marigot', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(103, 'America', 'Martinique', 'America/Martinique', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(104, 'America', 'Matamoros', 'America/Matamoros', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(105, 'America', 'Mazatlan', 'America/Mazatlan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(106, 'America', 'Mendoza', 'America/Mendoza', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(107, 'America', 'Menominee', 'America/Menominee', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(108, 'America', 'Merida', 'America/Merida', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(109, 'America', 'Mexico City', 'America/Mexico_City', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(110, 'America', 'Miquelon', 'America/Miquelon', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(111, 'America', 'Moncton', 'America/Moncton', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(112, 'America', 'Monterrey', 'America/Monterrey', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(113, 'America', 'Montevideo', 'America/Montevideo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(114, 'America', 'Montreal', 'America/Montreal', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(115, 'America', 'Montserrat', 'America/Montserrat', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(116, 'America', 'Nassau', 'America/Nassau', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(117, 'America', 'New York', 'America/New_York', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(118, 'America', 'Nipigon', 'America/Nipigon', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(119, 'America', 'Nome', 'America/Nome', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(120, 'America', 'Noronha', 'America/Noronha', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(121, 'America', 'North Dakota - Center', 'America/North_Dakota/Center', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(122, 'America', 'North Dakota - New Salem', 'America/North_Dakota/New_Salem', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(123, 'America', 'Ojinaga', 'America/Ojinaga', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(124, 'America', 'Panama', 'America/Panama', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(125, 'America', 'Pangnirtung', 'America/Pangnirtung', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(126, 'America', 'Paramaribo', 'America/Paramaribo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(127, 'America', 'Phoenix', 'America/Phoenix', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(128, 'America', 'Port-au-Prince', 'America/Port-au-Prince', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(129, 'America', 'Porto Acre', 'America/Porto_Acre', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(130, 'America', 'Port of Spain', 'America/Port_of_Spain', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(131, 'America', 'Porto Velho', 'America/Porto_Velho', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(132, 'America', 'Puerto Rico', 'America/Puerto_Rico', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(133, 'America', 'Rainy River', 'America/Rainy_River', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(134, 'America', 'Rankin Inlet', 'America/Rankin_Inlet', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(135, 'America', 'Recife', 'America/Recife', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(136, 'America', 'Regina', 'America/Regina', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(137, 'America', 'Resolute', 'America/Resolute', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(138, 'America', 'Rio Branco', 'America/Rio_Branco', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(139, 'America', 'Rosario', 'America/Rosario', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(140, 'America', 'Santa Isabel', 'America/Santa_Isabel', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(141, 'America', 'Santarem', 'America/Santarem', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(142, 'America', 'Santiago', 'America/Santiago', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(143, 'America', 'Santo Domingo', 'America/Santo_Domingo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(144, 'America', 'Sao Paulo', 'America/Sao_Paulo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(145, 'America', 'Scoresbysund', 'America/Scoresbysund', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(146, 'America', 'Shiprock', 'America/Shiprock', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(147, 'America', 'St Barthelemy', 'America/St_Barthelemy', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(148, 'America', 'St Johns', 'America/St_Johns', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(149, 'America', 'St Kitts', 'America/St_Kitts', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(150, 'America', 'St Lucia', 'America/St_Lucia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(151, 'America', 'St Thomas', 'America/St_Thomas', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(152, 'America', 'St Vincent', 'America/St_Vincent', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(153, 'America', 'Swift Current', 'America/Swift_Current', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(154, 'America', 'Tegucigalpa', 'America/Tegucigalpa', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(155, 'America', 'Thule', 'America/Thule', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(156, 'America', 'Thunder Bay', 'America/Thunder_Bay', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(157, 'America', 'Tijuana', 'America/Tijuana', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(158, 'America', 'Toronto', 'America/Toronto', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(159, 'America', 'Tortola', 'America/Tortola', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(160, 'America', 'Vancouver', 'America/Vancouver', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(161, 'America', 'Virgin', 'America/Virgin', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(162, 'America', 'Whitehorse', 'America/Whitehorse', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(163, 'America', 'Winnipeg', 'America/Winnipeg', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(164, 'America', 'Yakutat', 'America/Yakutat', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(165, 'America', 'Yellowknife', 'America/Yellowknife', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(166, 'Europe', 'Amsterdam', 'Europe/Amsterdam', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(167, 'Europe', 'Andorra', 'Europe/Andorra', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(168, 'Europe', 'Athens', 'Europe/Athens', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(169, 'Europe', 'Belfast', 'Europe/Belfast', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(170, 'Europe', 'Belgrade', 'Europe/Belgrade', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(171, 'Europe', 'Berlin', 'Europe/Berlin', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(172, 'Europe', 'Bratislava', 'Europe/Bratislava', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(173, 'Europe', 'Brussels', 'Europe/Brussels', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(174, 'Europe', 'Bucharest', 'Europe/Bucharest', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(175, 'Europe', 'Budapest', 'Europe/Budapest', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(176, 'Europe', 'Chisinau', 'Europe/Chisinau', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(177, 'Europe', 'Copenhagen', 'Europe/Copenhagen', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(178, 'Europe', 'Dublin', 'Europe/Dublin', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(179, 'Europe', 'Gibraltar', 'Europe/Gibraltar', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(180, 'Europe', 'Guernsey', 'Europe/Guernsey', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(181, 'Europe', 'Helsinki', 'Europe/Helsinki', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(182, 'Europe', 'Isle of Man', 'Europe/Isle_of_Man', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(183, 'Europe', 'Istanbul', 'Europe/Istanbul', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(184, 'Europe', 'Jersey', 'Europe/Jersey', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(185, 'Europe', 'Kaliningrad', 'Europe/Kaliningrad', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(186, 'Europe', 'Kiev', 'Europe/Kiev', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(187, 'Europe', 'Lisbon', 'Europe/Lisbon', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(188, 'Europe', 'Ljubljana', 'Europe/Ljubljana', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(189, 'Europe', 'London', 'Europe/London', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(190, 'Europe', 'Luxembourg', 'Europe/Luxembourg', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(191, 'Europe', 'Madrid', 'Europe/Madrid', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(192, 'Europe', 'Malta', 'Europe/Malta', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(193, 'Europe', 'Mariehamn', 'Europe/Mariehamn', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(194, 'Europe', 'Minsk', 'Europe/Minsk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(195, 'Europe', 'Monaco', 'Europe/Monaco', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(196, 'Europe', 'Moscow', 'Europe/Moscow', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(197, 'Europe', 'Nicosia', 'Europe/Nicosia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(198, 'Europe', 'Oslo', 'Europe/Oslo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(199, 'Europe', 'Paris', 'Europe/Paris', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(200, 'Europe', 'Podgorica', 'Europe/Podgorica', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(201, 'Europe', 'Prague', 'Europe/Prague', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(202, 'Europe', 'Riga', 'Europe/Riga', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(203, 'Europe', 'Rome', 'Europe/Rome', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(204, 'Europe', 'Samara', 'Europe/Samara', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(205, 'Europe', 'San Marino', 'Europe/San_Marino', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(206, 'Europe', 'Sarajevo', 'Europe/Sarajevo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(207, 'Europe', 'Simferopol', 'Europe/Simferopol', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(208, 'Europe', 'Skopje', 'Europe/Skopje', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(209, 'Europe', 'Sofia', 'Europe/Sofia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(210, 'Europe', 'Stockholm', 'Europe/Stockholm', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(211, 'Europe', 'Tallinn', 'Europe/Tallinn', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(212, 'Europe', 'Tirane', 'Europe/Tirane', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(213, 'Europe', 'Tiraspol', 'Europe/Tiraspol', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(214, 'Europe', 'Uzhgorod', 'Europe/Uzhgorod', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(215, 'Europe', 'Vaduz', 'Europe/Vaduz', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(216, 'Europe', 'Vatican', 'Europe/Vatican', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(217, 'Europe', 'Vienna', 'Europe/Vienna', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(218, 'Europe', 'Vilnius', 'Europe/Vilnius', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(219, 'Europe', 'Volgograd', 'Europe/Volgograd', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(220, 'Europe', 'Warsaw', 'Europe/Warsaw', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(221, 'Europe', 'Zagreb', 'Europe/Zagreb', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(222, 'Europe', 'Zaporozhye', 'Europe/Zaporozhye', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(223, 'Europe', 'Zurich', 'Europe/Zurich', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(224, 'Asia', 'Aden', 'Asia/Aden', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(225, 'Asia', 'Almaty', 'Asia/Almaty', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(226, 'Asia', 'Amman', 'Asia/Amman', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(227, 'Asia', 'Anadyr', 'Asia/Anadyr', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(228, 'Asia', 'Aqtau', 'Asia/Aqtau', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(229, 'Asia', 'Aqtobe', 'Asia/Aqtobe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(230, 'Asia', 'Ashgabat', 'Asia/Ashgabat', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(231, 'Asia', 'Ashkhabad', 'Asia/Ashkhabad', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(232, 'Asia', 'Baghdad', 'Asia/Baghdad', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(233, 'Asia', 'Bahrain', 'Asia/Bahrain', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(234, 'Asia', 'Baku', 'Asia/Baku', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(235, 'Asia', 'Bangkok', 'Asia/Bangkok', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(236, 'Asia', 'Beirut', 'Asia/Beirut', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(237, 'Asia', 'Bishkek', 'Asia/Bishkek', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(238, 'Asia', 'Brunei', 'Asia/Brunei', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(239, 'Asia', 'Calcutta', 'Asia/Calcutta', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(240, 'Asia', 'Choibalsan', 'Asia/Choibalsan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(241, 'Asia', 'Chongqing', 'Asia/Chongqing', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(242, 'Asia', 'Chungking', 'Asia/Chungking', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(243, 'Asia', 'Colombo', 'Asia/Colombo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(244, 'Asia', 'Dacca', 'Asia/Dacca', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(245, 'Asia', 'Damascus', 'Asia/Damascus', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(246, 'Asia', 'Dhaka', 'Asia/Dhaka', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(247, 'Asia', 'Dili', 'Asia/Dili', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(248, 'Asia', 'Dubai', 'Asia/Dubai', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(249, 'Asia', 'Dushanbe', 'Asia/Dushanbe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(250, 'Asia', 'Gaza', 'Asia/Gaza', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(251, 'Asia', 'Harbin', 'Asia/Harbin', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(252, 'Asia', 'Ho Chi Minh', 'Asia/Ho_Chi_Minh', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(253, 'Asia', 'Hong Kong', 'Asia/Hong_Kong', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(254, 'Asia', 'Hovd', 'Asia/Hovd', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(255, 'Asia', 'Irkutsk', 'Asia/Irkutsk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(256, 'Asia', 'Istanbul', 'Asia/Istanbul', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(257, 'Asia', 'Jakarta', 'Asia/Jakarta', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(258, 'Asia', 'Jayapura', 'Asia/Jayapura', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(259, 'Asia', 'Jerusalem', 'Asia/Jerusalem', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(260, 'Asia', 'Kabul', 'Asia/Kabul', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(261, 'Asia', 'Kamchatka', 'Asia/Kamchatka', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(262, 'Asia', 'Karachi', 'Asia/Karachi', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(263, 'Asia', 'Kashgar', 'Asia/Kashgar', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(264, 'Asia', 'Kathmandu', 'Asia/Kathmandu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(265, 'Asia', 'Katmandu', 'Asia/Katmandu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(266, 'Asia', 'Kolkata', 'Asia/Kolkata', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(267, 'Asia', 'Krasnoyarsk', 'Asia/Krasnoyarsk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(268, 'Asia', 'Kuala Lumpur', 'Asia/Kuala_Lumpur', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(269, 'Asia', 'Kuching', 'Asia/Kuching', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(270, 'Asia', 'Kuwait', 'Asia/Kuwait', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(271, 'Asia', 'Macao', 'Asia/Macao', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(272, 'Asia', 'Macau', 'Asia/Macau', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(273, 'Asia', 'Magadan', 'Asia/Magadan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(274, 'Asia', 'Makassar', 'Asia/Makassar', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(275, 'Asia', 'Manila', 'Asia/Manila', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(276, 'Asia', 'Muscat', 'Asia/Muscat', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(277, 'Asia', 'Nicosia', 'Asia/Nicosia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(278, 'Asia', 'Novokuznetsk', 'Asia/Novokuznetsk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(279, 'Asia', 'Novosibirsk', 'Asia/Novosibirsk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(280, 'Asia', 'Omsk', 'Asia/Omsk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(281, 'Asia', 'Oral', 'Asia/Oral', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(282, 'Asia', 'Phnom Penh', 'Asia/Phnom_Penh', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(283, 'Asia', 'Pontianak', 'Asia/Pontianak', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(284, 'Asia', 'Pyongyang', 'Asia/Pyongyang', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(285, 'Asia', 'Qatar', 'Asia/Qatar', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(286, 'Asia', 'Qyzylorda', 'Asia/Qyzylorda', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(287, 'Asia', 'Rangoon', 'Asia/Rangoon', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(288, 'Asia', 'Riyadh', 'Asia/Riyadh', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(289, 'Asia', 'Saigon', 'Asia/Saigon', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(290, 'Asia', 'Sakhalin', 'Asia/Sakhalin', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(291, 'Asia', 'Samarkand', 'Asia/Samarkand', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(292, 'Asia', 'Seoul', 'Asia/Seoul', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(293, 'Asia', 'Shanghai', 'Asia/Shanghai', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(294, 'Asia', 'Singapore', 'Asia/Singapore', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(295, 'Asia', 'Taipei', 'Asia/Taipei', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(296, 'Asia', 'Tashkent', 'Asia/Tashkent', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(297, 'Asia', 'Tbilisi', 'Asia/Tbilisi', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(298, 'Asia', 'Tehran', 'Asia/Tehran', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(299, 'Asia', 'Tel Aviv', 'Asia/Tel_Aviv', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(300, 'Asia', 'Thimbu', 'Asia/Thimbu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(301, 'Asia', 'Thimphu', 'Asia/Thimphu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(302, 'Asia', 'Tokyo', 'Asia/Tokyo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(303, 'Asia', 'Ujung Pandang', 'Asia/Ujung_Pandang', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(304, 'Asia', 'Ulaanbaatar', 'Asia/Ulaanbaatar', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(305, 'Asia', 'Ulan Bator', 'Asia/Ulan_Bator', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(306, 'Asia', 'Urumqi', 'Asia/Urumqi', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(307, 'Asia', 'Vientiane', 'Asia/Vientiane', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(308, 'Asia', 'Vladivostok', 'Asia/Vladivostok', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(309, 'Asia', 'Yakutsk', 'Asia/Yakutsk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(310, 'Asia', 'Yekaterinburg', 'Asia/Yekaterinburg', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(311, 'Asia', 'Yerevan', 'Asia/Yerevan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(312, 'Africa', 'Abidjan', 'Africa/Abidjan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(313, 'Africa', 'Accra', 'Africa/Accra', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(314, 'Africa', 'Addis Ababa', 'Africa/Addis_Ababa', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(315, 'Africa', 'Algiers', 'Africa/Algiers', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(316, 'Africa', 'Asmara', 'Africa/Asmara', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(317, 'Africa', 'Asmera', 'Africa/Asmera', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(318, 'Africa', 'Bamako', 'Africa/Bamako', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(319, 'Africa', 'Bangui', 'Africa/Bangui', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(320, 'Africa', 'Banjul', 'Africa/Banjul', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(321, 'Africa', 'Bissau', 'Africa/Bissau', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(322, 'Africa', 'Blantyre', 'Africa/Blantyre', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(323, 'Africa', 'Brazzaville', 'Africa/Brazzaville', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(324, 'Africa', 'Bujumbura', 'Africa/Bujumbura', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(325, 'Africa', 'Cairo', 'Africa/Cairo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(326, 'Africa', 'Casablanca', 'Africa/Casablanca', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(327, 'Africa', 'Ceuta', 'Africa/Ceuta', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(328, 'Africa', 'Conakry', 'Africa/Conakry', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(329, 'Africa', 'Dakar', 'Africa/Dakar', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(330, 'Africa', 'Dar es Salaam', 'Africa/Dar_es_Salaam', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(331, 'Africa', 'Djibouti', 'Africa/Djibouti', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(332, 'Africa', 'Douala', 'Africa/Douala', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(333, 'Africa', 'El Aaiun', 'Africa/El_Aaiun', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(334, 'Africa', 'Freetown', 'Africa/Freetown', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(335, 'Africa', 'Gaborone', 'Africa/Gaborone', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(336, 'Africa', 'Harare', 'Africa/Harare', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(337, 'Africa', 'Johannesburg', 'Africa/Johannesburg', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(338, 'Africa', 'Kampala', 'Africa/Kampala', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(339, 'Africa', 'Khartoum', 'Africa/Khartoum', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(340, 'Africa', 'Kigali', 'Africa/Kigali', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(341, 'Africa', 'Kinshasa', 'Africa/Kinshasa', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(342, 'Africa', 'Lagos', 'Africa/Lagos', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(343, 'Africa', 'Libreville', 'Africa/Libreville', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(344, 'Africa', 'Lome', 'Africa/Lome', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(345, 'Africa', 'Luanda', 'Africa/Luanda', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(346, 'Africa', 'Lubumbashi', 'Africa/Lubumbashi', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(347, 'Africa', 'Lusaka', 'Africa/Lusaka', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(348, 'Africa', 'Malabo', 'Africa/Malabo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(349, 'Africa', 'Maputo', 'Africa/Maputo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(350, 'Africa', 'Maseru', 'Africa/Maseru', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(351, 'Africa', 'Mbabane', 'Africa/Mbabane', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(352, 'Africa', 'Mogadishu', 'Africa/Mogadishu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(353, 'Africa', 'Monrovia', 'Africa/Monrovia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(354, 'Africa', 'Nairobi', 'Africa/Nairobi', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(355, 'Africa', 'Ndjamena', 'Africa/Ndjamena', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(356, 'Africa', 'Niamey', 'Africa/Niamey', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(357, 'Africa', 'Nouakchott', 'Africa/Nouakchott', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(358, 'Africa', 'Ouagadougou', 'Africa/Ouagadougou', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(359, 'Africa', 'Porto-Novo', 'Africa/Porto-Novo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(360, 'Africa', 'Sao Tome', 'Africa/Sao_Tome', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(361, 'Africa', 'Timbuktu', 'Africa/Timbuktu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(362, 'Africa', 'Tripoli', 'Africa/Tripoli', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(363, 'Africa', 'Tunis', 'Africa/Tunis', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(364, 'Africa', 'Windhoek', 'Africa/Windhoek', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(365, 'Australia', 'ACT', 'Australia/ACT', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(366, 'Australia', 'Adelaide', 'Australia/Adelaide', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(367, 'Australia', 'Brisbane', 'Australia/Brisbane', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(368, 'Australia', 'Broken Hill', 'Australia/Broken_Hill', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(369, 'Australia', 'Canberra', 'Australia/Canberra', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(370, 'Australia', 'Currie', 'Australia/Currie', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(371, 'Australia', 'Darwin', 'Australia/Darwin', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(372, 'Australia', 'Eucla', 'Australia/Eucla', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(373, 'Australia', 'Hobart', 'Australia/Hobart', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(374, 'Australia', 'LHI', 'Australia/LHI', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(375, 'Australia', 'Lindeman', 'Australia/Lindeman', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(376, 'Australia', 'Lord Howe', 'Australia/Lord_Howe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(377, 'Australia', 'Melbourne', 'Australia/Melbourne', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(378, 'Australia', 'North', 'Australia/North', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(379, 'Australia', 'NSW', 'Australia/NSW', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(380, 'Australia', 'Perth', 'Australia/Perth', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(381, 'Australia', 'Queensland', 'Australia/Queensland', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(382, 'Australia', 'South', 'Australia/South', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(383, 'Australia', 'Sydney', 'Australia/Sydney', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(384, 'Australia', 'Tasmania', 'Australia/Tasmania', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(385, 'Australia', 'Victoria', 'Australia/Victoria', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(386, 'Australia', 'West', 'Australia/West', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(387, 'Australia', 'Yancowinna', 'Australia/Yancowinna', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(388, 'Indian', 'Antananarivo', 'Indian/Antananarivo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(389, 'Indian', 'Chagos', 'Indian/Chagos', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(390, 'Indian', 'Christmas', 'Indian/Christmas', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(391, 'Indian', 'Cocos', 'Indian/Cocos', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(392, 'Indian', 'Comoro', 'Indian/Comoro', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(393, 'Indian', 'Kerguelen', 'Indian/Kerguelen', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(394, 'Indian', 'Mahe', 'Indian/Mahe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(395, 'Indian', 'Maldives', 'Indian/Maldives', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(396, 'Indian', 'Mauritius', 'Indian/Mauritius', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(397, 'Indian', 'Mayotte', 'Indian/Mayotte', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(398, 'Indian', 'Reunion', 'Indian/Reunion', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(399, 'Atlantic', 'Azores', 'Atlantic/Azores', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(400, 'Atlantic', 'Bermuda', 'Atlantic/Bermuda', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(401, 'Atlantic', 'Canary', 'Atlantic/Canary', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(402, 'Atlantic', 'Cape Verde', 'Atlantic/Cape_Verde', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(403, 'Atlantic', 'Faeroe', 'Atlantic/Faeroe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(404, 'Atlantic', 'Faroe', 'Atlantic/Faroe', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(405, 'Atlantic', 'Jan Mayen', 'Atlantic/Jan_Mayen', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(406, 'Atlantic', 'Madeira', 'Atlantic/Madeira', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(407, 'Atlantic', 'Reykjavik', 'Atlantic/Reykjavik', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(408, 'Atlantic', 'South Georgia', 'Atlantic/South_Georgia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(409, 'Atlantic', 'Stanley', 'Atlantic/Stanley', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(410, 'Atlantic', 'St Helena', 'Atlantic/St_Helena', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(411, 'Pacific', 'Apia', 'Pacific/Apia', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(412, 'Pacific', 'Auckland', 'Pacific/Auckland', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(413, 'Pacific', 'Chatham', 'Pacific/Chatham', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(414, 'Pacific', 'Easter', 'Pacific/Easter', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(415, 'Pacific', 'Efate', 'Pacific/Efate', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(416, 'Pacific', 'Enderbury', 'Pacific/Enderbury', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(417, 'Pacific', 'Fakaofo', 'Pacific/Fakaofo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(418, 'Pacific', 'Fiji', 'Pacific/Fiji', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(419, 'Pacific', 'Funafuti', 'Pacific/Funafuti', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(420, 'Pacific', 'Galapagos', 'Pacific/Galapagos', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(421, 'Pacific', 'Gambier', 'Pacific/Gambier', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(422, 'Pacific', 'Guadalcanal', 'Pacific/Guadalcanal', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(423, 'Pacific', 'Guam', 'Pacific/Guam', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(424, 'Pacific', 'Honolulu', 'Pacific/Honolulu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(425, 'Pacific', 'Johnston', 'Pacific/Johnston', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(426, 'Pacific', 'Kiritimati', 'Pacific/Kiritimati', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(427, 'Pacific', 'Kosrae', 'Pacific/Kosrae', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(428, 'Pacific', 'Kwajalein', 'Pacific/Kwajalein', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(429, 'Pacific', 'Majuro', 'Pacific/Majuro', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(430, 'Pacific', 'Marquesas', 'Pacific/Marquesas', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(431, 'Pacific', 'Midway', 'Pacific/Midway', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(432, 'Pacific', 'Nauru', 'Pacific/Nauru', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(433, 'Pacific', 'Niue', 'Pacific/Niue', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(434, 'Pacific', 'Norfolk', 'Pacific/Norfolk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(435, 'Pacific', 'Noumea', 'Pacific/Noumea', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(436, 'Pacific', 'Pago Pago', 'Pacific/Pago_Pago', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(437, 'Pacific', 'Palau', 'Pacific/Palau', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(438, 'Pacific', 'Pitcairn', 'Pacific/Pitcairn', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(439, 'Pacific', 'Ponape', 'Pacific/Ponape', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(440, 'Pacific', 'Port Moresby', 'Pacific/Port_Moresby', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(441, 'Pacific', 'Rarotonga', 'Pacific/Rarotonga', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(442, 'Pacific', 'Saipan', 'Pacific/Saipan', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(443, 'Pacific', 'Samoa', 'Pacific/Samoa', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(444, 'Pacific', 'Tahiti', 'Pacific/Tahiti', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(445, 'Pacific', 'Tarawa', 'Pacific/Tarawa', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(446, 'Pacific', 'Tongatapu', 'Pacific/Tongatapu', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(447, 'Pacific', 'Truk', 'Pacific/Truk', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(448, 'Pacific', 'Wake', 'Pacific/Wake', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(449, 'Pacific', 'Wallis', 'Pacific/Wallis', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(450, 'Pacific', 'Yap', 'Pacific/Yap', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(451, 'Antarctica', 'Casey', 'Antarctica/Casey', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(452, 'Antarctica', 'Davis', 'Antarctica/Davis', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(453, 'Antarctica', 'DumontDUrville', 'Antarctica/DumontDUrville', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(454, 'Antarctica', 'Macquarie', 'Antarctica/Macquarie', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(455, 'Antarctica', 'Mawson', 'Antarctica/Mawson', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(456, 'Antarctica', 'McMurdo', 'Antarctica/McMurdo', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(457, 'Antarctica', 'Palmer', 'Antarctica/Palmer', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(458, 'Antarctica', 'Rothera', 'Antarctica/Rothera', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(459, 'Antarctica', 'South Pole', 'Antarctica/South_Pole', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(460, 'Antarctica', 'Syowa', 'Antarctica/Syowa', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(461, 'Antarctica', 'Vostok', 'Antarctica/Vostok', '2021-10-26 10:35:11', '2021-10-26 10:35:11'),
(462, 'Arctic', 'Longyearbyen', 'Arctic/Longyearbyen', '2021-10-26 10:35:11', '2021-10-26 10:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `userprofiles`
--

CREATE TABLE `userprofiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `gender` varchar(191) DEFAULT NULL,
  `url_website` varchar(191) DEFAULT NULL,
  `url_facebook` varchar(191) DEFAULT NULL,
  `url_twitter` varchar(191) DEFAULT NULL,
  `url_instagram` varchar(191) DEFAULT NULL,
  `url_linkedin` varchar(191) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `user_metadata` text DEFAULT NULL,
  `last_ip` varchar(191) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT 0,
  `last_login` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userprofiles`
--

INSERT INTO `userprofiles` (`id`, `user_id`, `name`, `first_name`, `last_name`, `username`, `email`, `mobile`, `gender`, `url_website`, `url_facebook`, `url_twitter`, `url_instagram`, `url_linkedin`, `date_of_birth`, `address`, `bio`, `avatar`, `user_metadata`, `last_ip`, `login_count`, `last_login`, `email_verified_at`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Super Admin', 'Super', 'Admin', '100001', 'super@admin.com', '(865) 947-4201', 'Female', NULL, NULL, NULL, NULL, NULL, '2010-04-15', NULL, NULL, 'img/default-avatar.jpg', NULL, '203.76.221.62', 183, '2022-11-30 17:42:00', NULL, 1, NULL, 1, NULL, '2022-08-10 04:58:28', '2022-11-30 17:42:00', NULL),
(2, 2, 'Admin Istrator', 'Admin', 'Istrator', '100002', 'admin@admin.com', '272.961.8395', 'Other', NULL, NULL, NULL, NULL, NULL, '1997-06-27', NULL, NULL, 'img/default-avatar.jpg', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-10 04:58:28', '2022-08-10 04:58:28', NULL),
(3, 3, 'Manager', 'Manager', 'User User', '100003', 'manager@manager.com', '563.853.4452', 'Other', NULL, NULL, NULL, NULL, NULL, '2003-02-27', NULL, NULL, 'img/default-avatar.jpg', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-10 04:58:28', '2022-08-10 04:58:28', NULL),
(4, 4, 'Executive User', 'Executive', 'User', '100004', 'executive@executive.com', '(938) 783-8064', 'Other', NULL, NULL, NULL, NULL, NULL, '2017-07-19', NULL, NULL, 'img/default-avatar.jpg', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-10 04:58:28', '2022-08-10 04:58:28', NULL),
(5, 5, 'General User', 'General', 'User', '100005', 'user@user.com', '+1.678.728.3936', 'Male', NULL, NULL, NULL, NULL, NULL, '1988-12-03', NULL, NULL, 'img/default-avatar.jpg', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-10 04:58:28', '2022-08-10 04:58:28', NULL),
(6, 6, 'Cassady', 'Cassady', 'Harrington', '100006', 'syris@mailinator.com', '+1 (635) 826-7563', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'img/default-avatar.jpg', NULL, '::1', 5, '2022-08-31 05:27:39', NULL, 1, 1, 6, NULL, '2022-08-28 06:13:31', '2022-08-31 05:27:39', NULL),
(7, 8, 'Moses', 'Moses', 'Bright', '100008', 'bysij@mailinator.com', '+1 (771) 152-4165', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'img/default-avatar.jpg', NULL, NULL, 0, NULL, NULL, 1, 1, 1, NULL, '2022-08-29 13:26:47', '2022-08-29 13:26:47', NULL),
(8, 7, 'Rafi', 'Rafi', 'Hossain', '100007', 'rafi.hossain@gmail.com', '+1 (185) 596-9964', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'img/default-avatar.jpg', NULL, NULL, 0, NULL, NULL, 1, 1, 1, NULL, '2022-09-06 05:59:09', '2022-09-06 05:59:09', NULL),
(9, 8, 'rafi', 'rafi', 'rahman', '100008', 'rafi@gmail.com', '01963444543', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'img/default-avatar.jpg', NULL, NULL, 0, NULL, NULL, 0, 1, 1, NULL, '2022-10-10 22:36:26', '2022-10-10 22:36:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `gender` varchar(191) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT 'img/default-avatar.jpg',
  `profile_image` varchar(150) DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `invite_status` int(11) NOT NULL DEFAULT 0 COMMENT '	0=>''Invited'' 1=>''Active'', 2=>''Inactive''',
  `user_role` int(11) DEFAULT NULL COMMENT '1=>"super admin", 2=>"admin",3=>"manager"',
  `user_timezone` int(11) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `office_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `username`, `email`, `mobile`, `gender`, `date_of_birth`, `email_verified_at`, `password`, `avatar`, `profile_image`, `status`, `invite_status`, `user_role`, `user_timezone`, `position`, `office_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nazmul Hossain', 'Nazmul', 'Hossain', '100001', 'super@admin.com', '(865) 947-4201', 'Female', '2010-04-15', '2022-08-10 04:58:28', '$2y$10$TgD6TnWg3WrO2ImMo.GrO.Ejj6z./hdU2quvjmm8eOY4z1kjVnG0S', 'img/default-avatar.jpg', NULL, 1, 0, 1, NULL, 'Pakistan Office', 1, NULL, '2022-08-10 04:58:28', '2022-09-06 05:52:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_kpi_target`
--

CREATE TABLE `user_kpi_target` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kpi_heading` varchar(50) DEFAULT NULL,
  `kpi_perameter` int(11) DEFAULT NULL,
  `kpi_frequency` int(11) DEFAULT NULL,
  `date_form` text DEFAULT NULL,
  `date_to` text DEFAULT NULL,
  `target_currency` text DEFAULT NULL,
  `target_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_kpi_target`
--

INSERT INTO `user_kpi_target` (`id`, `user_id`, `kpi_heading`, `kpi_perameter`, `kpi_frequency`, `date_form`, `date_to`, `target_currency`, `target_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'user kpi', 1, 2, '[\"2022-10-13\",\"2022-10-10\"]', '[\"2022-10-14\",\"2022-10-12\"]', '[\"AFA\",\"ALL\"]', '[\"5\",\"5\"]', '2022-10-10 07:58:18', '2022-10-10 07:58:18'),
(2, 2, 'user kpi', 2, 2, '[\"2022-10-10\",\"2022-10-14\"]', '[\"2022-10-12\",\"2022-10-16\"]', '[\"BDT\",\"BDT\"]', '[\"5\",\"10\"]', '2022-10-10 22:39:35', '2022-10-10 22:39:35'),
(3, 2, 'user kpi new', 3, 2, '[\"2022-10-20\",\"2022-10-20\"]', '[\"2022-10-22\",\"2022-10-15\"]', '[\"BDT\",\"BDT\"]', '[\"10\",\"10\"]', '2022-10-10 22:41:36', '2022-10-10 22:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_lead_forms`
--

CREATE TABLE `user_lead_forms` (
  `id` int(11) NOT NULL,
  `save_form_as` varchar(50) DEFAULT NULL,
  `personal_details_photo` varchar(150) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_secondary_email` varchar(50) DEFAULT NULL,
  `contact_preference` varchar(20) DEFAULT NULL,
  `street` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `visa_type` varchar(30) DEFAULT NULL,
  `visa_expire_date` date DEFAULT NULL,
  `country_passport` varchar(30) DEFAULT NULL,
  `preferred_intake` varchar(30) DEFAULT NULL,
  `autralian_education` int(11) DEFAULT NULL,
  `us_education` int(11) DEFAULT NULL,
  `visa_service` int(11) DEFAULT NULL,
  `accomodation_service` int(11) DEFAULT NULL,
  `insurance_service` int(11) DEFAULT NULL,
  `degree_title` varchar(50) DEFAULT NULL,
  `degree_level` varchar(50) DEFAULT NULL,
  `institution` varchar(50) DEFAULT NULL,
  `course_start` date DEFAULT NULL,
  `course_end` date DEFAULT NULL,
  `subject_area` int(11) DEFAULT NULL,
  `subject` int(11) DEFAULT NULL,
  `academic_score` varchar(15) DEFAULT NULL,
  `academic_score_value` double(10,2) DEFAULT NULL,
  `tofel` double(10,2) DEFAULT NULL,
  `ielts` double(10,2) DEFAULT NULL,
  `pte` double(10,2) DEFAULT NULL,
  `sat1` double(10,2) DEFAULT NULL,
  `sat2` double(10,2) DEFAULT NULL,
  `gre` double(10,2) DEFAULT NULL,
  `gmat` double(10,2) DEFAULT NULL,
  `upload_document` varchar(100) DEFAULT NULL,
  `comments` text NOT NULL,
  `privacy_check` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_providers`
--

CREATE TABLE `user_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(191) NOT NULL,
  `provider_id` varchar(191) NOT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_stages`
--

CREATE TABLE `workflow_stages` (
  `id` int(11) NOT NULL,
  `setting_workflow_id` int(11) NOT NULL DEFAULT 0,
  `stage_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `workflow_stages`
--

INSERT INTO `workflow_stages` (`id`, `setting_workflow_id`, `stage_name`, `created_at`, `updated_at`) VALUES
(38, 5, 'Application', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(39, 5, 'Acceptance', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(40, 5, 'Payment', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(41, 5, 'Form I 20', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(42, 5, 'Visa Application', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(43, 5, 'Interview', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(44, 5, 'Enrolment', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(45, 5, 'Course Ongoing', '2022-10-10 11:14:03', '2022-10-10 11:14:03'),
(46, 9, 'Client Documents', '2022-10-10 11:15:01', '2022-10-10 11:15:01'),
(47, 9, 'Application', '2022-10-10 11:15:01', '2022-10-10 11:15:01'),
(48, 9, 'Information request', '2022-10-10 11:15:02', '2022-10-10 11:15:02'),
(49, 9, 'Interview', '2022-10-10 11:15:02', '2022-10-10 11:15:02'),
(50, 9, 'Visa Approved', '2022-10-10 11:15:02', '2022-10-10 11:15:02'),
(51, 9, 'Visa Refused', '2022-10-10 11:15:02', '2022-10-10 11:15:02'),
(52, 10, 'Vacancy Check', '2022-10-10 11:16:11', '2022-10-10 11:16:11'),
(53, 10, 'Quotation', '2022-10-10 11:16:11', '2022-10-10 11:16:11'),
(54, 10, 'Approved', '2022-10-10 11:16:11', '2022-10-10 11:16:11'),
(55, 10, 'Payment', '2022-10-10 11:16:11', '2022-10-10 11:16:11'),
(56, 10, 'Confirmation', '2022-10-10 11:16:11', '2022-10-10 11:16:11'),
(57, 11, 'Application', '2022-10-10 11:16:53', '2022-10-10 11:16:53'),
(58, 11, 'Payment', '2022-10-10 11:16:53', '2022-10-10 11:16:53'),
(59, 11, 'Confirmation', '2022-10-10 11:16:53', '2022-10-10 11:16:53'),
(60, 4, 'Application', '2022-10-18 21:09:07', '2022-10-18 21:09:07'),
(61, 4, 'Offer Letter', '2022-10-18 21:09:07', '2022-10-18 21:09:07'),
(62, 4, 'Fee Payment', '2022-10-18 21:09:07', '2022-10-18 21:09:07'),
(63, 4, 'COE', '2022-10-18 21:09:07', '2022-10-18 21:09:07'),
(64, 4, 'Visa Application', '2022-10-18 21:09:07', '2022-10-18 21:09:07'),
(65, 4, 'Enrolment', '2022-10-18 21:09:07', '2022-10-18 21:09:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_log_log_name_index` (`log_name`),
  ADD KEY `subject` (`subject_id`,`subject_type`),
  ADD KEY `causer` (`causer_id`,`causer_type`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_options`
--
ALTER TABLE `application_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_type_categories`
--
ALTER TABLE `application_type_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `automations`
--
ALTER TABLE `automations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_histories`
--
ALTER TABLE `billing_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_invoice_address`
--
ALTER TABLE `business_invoice_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_registration_number`
--
ALTER TABLE `business_registration_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_educations`
--
ALTER TABLE `client_educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_tags`
--
ALTER TABLE `client_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_emails`
--
ALTER TABLE `company_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countrys`
--
ALTER TABLE `countrys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `degree_levels`
--
ALTER TABLE `degree_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_checklist`
--
ALTER TABLE `document_checklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_total_checklist`
--
ALTER TABLE `document_total_checklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `english_test_scores`
--
ALTER TABLE `english_test_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_types`
--
ALTER TABLE `fee_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_names`
--
ALTER TABLE `field_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_aboutus`
--
ALTER TABLE `general_aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_reasons`
--
ALTER TABLE `general_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interested_services`
--
ALTER TABLE `interested_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_forms`
--
ALTER TABLE `lead_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manually_payment_details`
--
ALTER TABLE `manually_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_checkin`
--
ALTER TABLE `office_checkin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_visites`
--
ALTER TABLE `office_visites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `others_general`
--
ALTER TABLE `others_general`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_test_scores`
--
ALTER TABLE `other_test_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_agreements`
--
ALTER TABLE `partner_agreements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_branches`
--
ALTER TABLE `partner_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_contacts`
--
ALTER TABLE `partner_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_master_categories`
--
ALTER TABLE `partner_master_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_notes`
--
ALTER TABLE `partner_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner_types`
--
ALTER TABLE `partner_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_categories`
--
ALTER TABLE `permission_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `priority_categories`
--
ALTER TABLE `priority_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_documentations`
--
ALTER TABLE `product_documentations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_fees_items`
--
ALTER TABLE `product_fees_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `service_workflow_categories`
--
ALTER TABLE `service_workflow_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_workflow`
--
ALTER TABLE `setting_workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_templates`
--
ALTER TABLE `sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source_lists`
--
ALTER TABLE `source_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_area`
--
ALTER TABLE `subject_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_billings`
--
ALTER TABLE `subscription_billings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taggables`
--
ALTER TABLE `taggables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_categories`
--
ALTER TABLE `task_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_settings`
--
ALTER TABLE `tax_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userprofiles`
--
ALTER TABLE `userprofiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_kpi_target`
--
ALTER TABLE `user_kpi_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_lead_forms`
--
ALTER TABLE `user_lead_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_providers`
--
ALTER TABLE `user_providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_providers_user_id_foreign` (`user_id`);

--
-- Indexes for table `workflow_stages`
--
ALTER TABLE `workflow_stages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `application_options`
--
ALTER TABLE `application_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `application_type_categories`
--
ALTER TABLE `application_type_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `automations`
--
ALTER TABLE `automations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `billing_histories`
--
ALTER TABLE `billing_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_invoice_address`
--
ALTER TABLE `business_invoice_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_registration_number`
--
ALTER TABLE `business_registration_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `client_educations`
--
ALTER TABLE `client_educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `client_tags`
--
ALTER TABLE `client_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_emails`
--
ALTER TABLE `company_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countrys`
--
ALTER TABLE `countrys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `degree_levels`
--
ALTER TABLE `degree_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `document_checklist`
--
ALTER TABLE `document_checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document_total_checklist`
--
ALTER TABLE `document_total_checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `english_test_scores`
--
ALTER TABLE `english_test_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_types`
--
ALTER TABLE `fee_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `field_names`
--
ALTER TABLE `field_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `general_aboutus`
--
ALTER TABLE `general_aboutus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `general_reasons`
--
ALTER TABLE `general_reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `interested_services`
--
ALTER TABLE `interested_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lead_forms`
--
ALTER TABLE `lead_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manually_payment_details`
--
ALTER TABLE `manually_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `office_checkin`
--
ALTER TABLE `office_checkin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `office_visites`
--
ALTER TABLE `office_visites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `others_general`
--
ALTER TABLE `others_general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `other_test_scores`
--
ALTER TABLE `other_test_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `partner_agreements`
--
ALTER TABLE `partner_agreements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partner_branches`
--
ALTER TABLE `partner_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `partner_contacts`
--
ALTER TABLE `partner_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partner_master_categories`
--
ALTER TABLE `partner_master_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `partner_notes`
--
ALTER TABLE `partner_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partner_types`
--
ALTER TABLE `partner_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `permission_categories`
--
ALTER TABLE `permission_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priority_categories`
--
ALTER TABLE `priority_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_documentations`
--
ALTER TABLE `product_documentations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_fees_items`
--
ALTER TABLE `product_fees_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `service_workflow_categories`
--
ALTER TABLE `service_workflow_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_workflow`
--
ALTER TABLE `setting_workflow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sms_templates`
--
ALTER TABLE `sms_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `source_lists`
--
ALTER TABLE `source_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `subject_area`
--
ALTER TABLE `subject_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subscription_billings`
--
ALTER TABLE `subscription_billings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taggables`
--
ALTER TABLE `taggables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task_categories`
--
ALTER TABLE `task_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tax_settings`
--
ALTER TABLE `tax_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;

--
-- AUTO_INCREMENT for table `userprofiles`
--
ALTER TABLE `userprofiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_kpi_target`
--
ALTER TABLE `user_kpi_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_lead_forms`
--
ALTER TABLE `user_lead_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_providers`
--
ALTER TABLE `user_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workflow_stages`
--
ALTER TABLE `workflow_stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
