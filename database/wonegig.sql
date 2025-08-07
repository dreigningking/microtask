-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2025 at 12:43 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wonegig`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `routing_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `swift_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `user_id`, `bank_name`, `bank_code`, `account_name`, `account_number`, `routing_number`, `swift_code`, `branch_code`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Guaranty Trust Bank', '058', 'Idera Oluwadamilola Samuel', '0051911523', NULL, NULL, NULL, '2025-06-21 18:51:47', '2025-06-21 18:17:31', '2025-06-21 18:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views_count` int NOT NULL DEFAULT '0',
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `reading_time` int DEFAULT NULL,
  `allow_comments` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `user_id`, `status`, `published_at`, `meta_title`, `meta_description`, `meta_keywords`, `views_count`, `category`, `tags`, `reading_time`, `allow_comments`, `featured`, `created_at`, `updated_at`) VALUES
(1, 'Video Production series', 'video-production', 'Video production is the process of producing video content', 'Video production is the process of producing video content. It is the equivalent of filmmaking, but with video recorded either as analog signals on videotape, digitally in video tape or as computer files stored on optical discs, hard drives, SSDs, magnetic tape or memory cards instead of film stock. There are three main stages of video production, pre-production, production and post-production.', 'blog/blog_dt9hZl5GHy7DIs5McR4k.jpg', 2, 'published', '2025-06-29 23:30:00', 'Voluptatem ipsum nis', 'Commodi ratione illu', 'Vel laboris omnis am', 0, 'News', '[\"video\", \"production\"]', 1, 1, 1, '2025-06-29 22:53:42', '2025-07-28 18:14:51');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('magreat_taste_cache_visitors', 'a:1:{i:0;s:13:\"197.211.58.12\";}', 2069186457),
('wonegig_cache_2591def5dc06443377f0bb90ee6928ec', 's:40:\"190389f8ad2fa7d261777a0d13af795a924139aa\";', 1751679247),
('wonegig_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1754449878),
('wonegig_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1754449878;', 1754449878),
('wonegig_cache_5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1751503685),
('wonegig_cache_5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1751503685;', 1751503685),
('wonegig_cache_edf5ba25e3ff0952a822cc58560bd8c6', 's:40:\"0352776ac03c1beb2b83bd6a7eeab209f8fa3807\";', 1751682056),
('wonegig_cache_open_exchange_rates', 'a:2:{s:9:\"timestamp\";i:1753721779;s:5:\"rates\";a:172:{s:3:\"AED\";d:3.67305;s:3:\"AFN\";d:69.5;s:3:\"ALL\";d:83.696618;s:3:\"AMD\";d:383.676067;s:3:\"ANG\";d:1.79;s:3:\"AOA\";d:911.955;s:3:\"ARS\";d:1288.9935;s:3:\"AUD\";d:1.534366;s:3:\"AWG\";d:1.8025;s:3:\"AZN\";d:1.7;s:3:\"BAM\";d:1.678517;s:3:\"BBD\";i:2;s:3:\"BDT\";d:122.568952;s:3:\"BGN\";d:1.68123;s:3:\"BHD\";d:0.376965;s:3:\"BIF\";i:2936;s:3:\"BMD\";i:1;s:3:\"BND\";d:1.285378;s:3:\"BOB\";d:6.938098;s:3:\"BRL\";d:5.5938;s:3:\"BSD\";i:1;s:3:\"BTC\";d:8.460146E-6;s:3:\"BTN\";d:86.658154;s:3:\"BWP\";d:13.486598;s:3:\"BYN\";d:3.274063;s:3:\"BZD\";d:2.009646;s:3:\"CAD\";d:1.371971;s:3:\"CDF\";i:2889;s:3:\"CHF\";d:0.802555;s:3:\"CLF\";d:0.024462;s:3:\"CLP\";d:959.62;s:3:\"CNH\";d:7.181535;s:3:\"CNY\";d:7.1779;s:3:\"COP\";d:4159.660889;s:3:\"CRC\";d:505.365506;s:3:\"CUC\";i:1;s:3:\"CUP\";d:25.75;s:3:\"CVE\";d:94.15;s:3:\"CZK\";d:21.179019;s:3:\"DJF\";d:178.150801;s:3:\"DKK\";d:6.428598;s:3:\"DOP\";d:60.4;s:3:\"DZD\";d:129.889832;s:3:\"EGP\";d:48.7785;s:3:\"ERN\";i:15;s:3:\"ETB\";d:139.17231;s:3:\"EUR\";d:0.861389;s:3:\"FJD\";d:2.2533;s:3:\"FKP\";d:0.74685;s:3:\"GBP\";d:0.74685;s:3:\"GEL\";d:2.70725;s:3:\"GGP\";d:0.74685;s:3:\"GHS\";d:10.41;s:3:\"GIP\";d:0.74685;s:3:\"GMD\";d:71.999996;s:3:\"GNF\";i:8656;s:3:\"GTQ\";d:7.678742;s:3:\"GYD\";d:209.310041;s:3:\"HKD\";d:7.849917;s:3:\"HNL\";d:26.199905;s:3:\"HRK\";d:6.489016;s:3:\"HTG\";d:130.887012;s:3:\"HUF\";d:342.503;s:3:\"IDR\";d:16396.565506;s:3:\"ILS\";d:3.350255;s:3:\"IMP\";d:0.74685;s:3:\"INR\";d:86.715001;s:3:\"IQD\";d:1310.668737;s:3:\"IRR\";d:42112.5;s:3:\"ISK\";d:122.49;s:3:\"JEP\";d:0.74685;s:3:\"JMD\";d:160.498119;s:3:\"JOD\";d:0.709;s:3:\"JPY\";d:148.45921429;s:3:\"KES\";d:129.5;s:3:\"KGS\";d:87.3;s:3:\"KHR\";d:4006.660706;s:3:\"KMF\";d:418.500409;s:3:\"KPW\";i:900;s:3:\"KRW\";d:1388.263635;s:3:\"KWD\";d:0.305393;s:3:\"KYD\";d:0.833687;s:3:\"KZT\";d:543.938124;s:3:\"LAK\";i:21565;s:3:\"LBP\";i:89550;s:3:\"LKR\";d:302.035149;s:3:\"LRD\";d:201.00003;s:3:\"LSL\";d:17.62;s:3:\"LYD\";d:5.395;s:3:\"MAD\";d:9.037535;s:3:\"MDL\";d:16.740703;s:3:\"MGA\";d:4445.268321;s:3:\"MKD\";d:52.832358;s:3:\"MMK\";i:2099;s:3:\"MNT\";d:3587.99;s:3:\"MOP\";d:8.089456;s:3:\"MRU\";d:39.82;s:3:\"MUR\";d:45.38;s:3:\"MVR\";d:15.400001;s:3:\"MWK\";d:1734.735762;s:3:\"MXN\";d:18.733676;s:3:\"MYR\";d:4.231;s:3:\"MZN\";d:63.830001;s:3:\"NAD\";d:17.858747;s:3:\"NGN\";d:1529.52;s:3:\"NIO\";d:36.817873;s:3:\"NOK\";d:10.18636;s:3:\"NPR\";d:138.653405;s:3:\"NZD\";d:1.674434;s:3:\"OMR\";d:0.38451;s:3:\"PAB\";i:1;s:3:\"PEN\";d:3.546218;s:3:\"PGK\";d:4.209632;s:3:\"PHP\";d:57.240751;s:3:\"PKR\";d:283.350652;s:3:\"PLN\";d:3.674909;s:3:\"PYG\";d:7494.005441;s:3:\"QAR\";d:3.648004;s:3:\"RON\";d:4.3687;s:3:\"RSD\";d:100.903;s:3:\"RUB\";d:81.097925;s:3:\"RWF\";d:1446.668386;s:3:\"SAR\";d:3.751017;s:3:\"SBD\";d:8.2851;s:3:\"SCR\";d:14.14518;s:3:\"SDG\";d:600.5;s:3:\"SEK\";d:9.60025;s:3:\"SGD\";d:1.286584;s:3:\"SHP\";d:0.74685;s:3:\"SLE\";d:22.9458;s:3:\"SLL\";d:20969.5;s:3:\"SOS\";d:571.793501;s:3:\"SRD\";d:36.56;s:3:\"SSP\";d:130.26;s:3:\"STD\";d:22281.8;s:3:\"STN\";d:21.026433;s:3:\"SVC\";d:8.754758;s:3:\"SYP\";i:13002;s:3:\"SZL\";d:17.864147;s:3:\"THB\";d:32.4755;s:3:\"TJS\";d:9.529261;s:3:\"TMT\";d:3.51;s:3:\"TND\";d:2.932446;s:3:\"TOP\";d:2.40776;s:3:\"TRY\";d:40.563803;s:3:\"TTD\";d:6.803515;s:3:\"TWD\";d:29.646999;s:3:\"TZS\";i:2570;s:3:\"UAH\";d:41.846317;s:3:\"UGX\";d:3586.50151;s:3:\"USD\";i:1;s:3:\"UYU\";d:40.014357;s:3:\"UZS\";d:12589.011277;s:3:\"VES\";d:121.643518;s:3:\"VND\";d:26206.5;s:3:\"VUV\";d:119.482;s:3:\"WST\";d:2.739;s:3:\"XAF\";d:565.034304;s:3:\"XAG\";d:0.02621284;s:3:\"XAU\";d:0.00030168;s:3:\"XCD\";d:2.70255;s:3:\"XCG\";d:1.803086;s:3:\"XDR\";d:0.69341;s:3:\"XOF\";d:565.034304;s:3:\"XPD\";d:0.00077569;s:3:\"XPF\";d:102.791079;s:3:\"XPT\";d:0.00070538;s:3:\"YER\";d:240.738999;s:3:\"ZAR\";d:17.891968;s:3:\"ZMW\";d:23.459952;s:3:\"ZWG\";d:26.85215;s:3:\"ZWL\";i:322;}}', 1753725379),
('wonegig_cache_visitors', 'a:1:{i:0;s:13:\"197.211.58.12\";}', 2066765209);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachments` text COLLATE utf8mb4_unicode_ci,
  `is_flag` tinyint(1) NOT NULL DEFAULT '0',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country_prices`
--

CREATE TABLE `country_prices` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priceable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priceable_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country_prices`
--

INSERT INTO `country_prices` (`id`, `country_id`, `amount`, `priceable_type`, `priceable_id`, `created_at`, `updated_at`) VALUES
(1, 161, '1500', 'App\\Models\\Plan', 1, '2025-06-20 14:31:57', '2025-06-20 14:31:57'),
(2, 161, '800', 'App\\Models\\Plan', 2, '2025-06-20 14:31:57', '2025-06-20 20:22:03'),
(3, 161, '30', 'App\\Models\\TaskTemplate', 1, '2025-06-20 14:32:28', '2025-06-20 14:32:28'),
(4, 161, '75', 'App\\Models\\TaskTemplate', 2, '2025-06-20 14:32:28', '2025-06-20 14:32:28'),
(5, 161, '70', 'App\\Models\\TaskTemplate', 3, '2025-06-20 14:32:28', '2025-06-20 14:32:28'),
(6, 161, '70', 'App\\Models\\TaskTemplate', 4, '2025-07-02 14:32:28', '2025-07-02 14:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `country_settings`
--

CREATE TABLE `country_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_length` int NOT NULL DEFAULT '0',
  `banking_fields` json DEFAULT NULL,
  `bank_verification_required` tinyint(1) NOT NULL DEFAULT '1',
  `bank_verification_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `bank_account_storage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on_premises',
  `verification_provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verifications_can_expire` tinyint(1) NOT NULL DEFAULT '0',
  `verification_fields` json DEFAULT NULL,
  `tax_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `feature_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urgent_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usd_exchange_rate_percentage` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_charges` json DEFAULT NULL,
  `withdrawal_charges` json DEFAULT NULL,
  `min_withdrawal` decimal(18,2) DEFAULT NULL,
  `max_withdrawal` decimal(18,2) DEFAULT NULL,
  `wallet_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payout_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `weekend_payout` tinyint(1) NOT NULL DEFAULT '0',
  `holiday_payout` tinyint(1) NOT NULL DEFAULT '0',
  `admin_monitoring_cost` decimal(12,2) DEFAULT NULL,
  `system_monitoring_cost` decimal(12,2) DEFAULT NULL,
  `invitee_commission_percentage` decimal(5,2) DEFAULT NULL,
  `referral_earnings_percentage` decimal(5,2) DEFAULT NULL,
  `notification_emails` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country_settings`
--

INSERT INTO `country_settings` (`id`, `country_id`, `gateway`, `account_length`, `banking_fields`, `bank_verification_required`, `bank_verification_method`, `bank_account_storage`, `verification_provider`, `verifications_can_expire`, `verification_fields`, `tax_rate`, `feature_rate`, `urgent_rate`, `usd_exchange_rate_percentage`, `transaction_charges`, `withdrawal_charges`, `min_withdrawal`, `max_withdrawal`, `wallet_status`, `payout_method`, `weekend_payout`, `holiday_payout`, `admin_monitoring_cost`, `system_monitoring_cost`, `invitee_commission_percentage`, `referral_earnings_percentage`, `notification_emails`, `created_at`, `updated_at`) VALUES
(1, 161, 'paystack', 10, '[\"account_name\", \"bank_name\", \"account_number\"]', 1, 'gateway', 'on_premises', 'sumsub', 0, '{\"gov_id\": {\"docs\": [\"national_id\", \"nin\"], \"mode\": \"all\"}, \"address\": {\"docs\": [\"electricity_bill\", \"waste_bill\"], \"mode\": \"one\"}}', '7', '1000', '20', '5', '{\"cap\": \"2000\", \"fixed\": \"100\", \"percentage\": \"2\"}', '{\"cap\": \"1000\", \"fixed\": \"50\", \"percentage\": \"1\"}', 1000.00, 100000.00, 'enabled', 'gateway', 0, 0, 100.00, 20.00, 10.00, 20.00, '{\"task\": \"is.oluwadamilola@gmail.com\", \"payment\": \"is.oluwadamilola@gmail.com\", \"support\": \"is.oluwadamilola@gmail.com\", \"disbursement\": \"is.oluwadamilola@gmail.com\"}', '2025-06-20 13:58:03', '2025-06-22 23:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `disputes`
--

CREATE TABLE `disputes` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `verdict` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispute_messages`
--

CREATE TABLE `dispute_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `dispute_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sender_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachments` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispute_trails`
--

CREATE TABLE `dispute_trails` (
  `id` bigint UNSIGNED NOT NULL,
  `dispute_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exchanges`
--

CREATE TABLE `exchanges` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `base_currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(18,8) NOT NULL,
  `base_amount` decimal(18,8) NOT NULL,
  `target_amount` decimal(18,8) NOT NULL,
  `base_wallet_id` bigint UNSIGNED NOT NULL,
  `target_wallet_id` bigint UNSIGNED NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exchanges`
--

INSERT INTO `exchanges` (`id`, `user_id`, `base_currency`, `target_currency`, `exchange_rate`, `base_amount`, `target_amount`, `base_wallet_id`, `target_wallet_id`, `status`, `reference`, `created_at`, `updated_at`) VALUES
(1, 3, 'USD', 'NGN', 1627.43700000, 10.00000000, 16274.37000000, 2, 1, 'completed', 'EX17506439313', '2025-06-23 00:58:51', '2025-06-23 00:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(5, 'default', '{\"uuid\":\"2011908d-4bdd-4711-b25e-44083004e5b1\",\"displayName\":\"App\\\\Notifications\\\\WelcomeNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:4;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:37:\\\"App\\\\Notifications\\\\WelcomeNotification\\\":1:{s:2:\\\"id\\\";s:36:\\\"c1435a77-b424-4303-a6ac-8e35a839ad49\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1750971393,\"delay\":null}', 0, NULL, 1750971393, 1750971393),
(6, 'default', '{\"uuid\":\"250af198-f94b-4d97-90d1-bd24f39d7247\",\"displayName\":\"App\\\\Jobs\\\\NotifyUrgentTaskPromotion\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NotifyUrgentTaskPromotion\",\"command\":\"O:34:\\\"App\\\\Jobs\\\\NotifyUrgentTaskPromotion\\\":1:{s:11:\\\"promotionId\\\";i:14;}\"},\"createdAt\":1754511118,\"delay\":null}', 0, NULL, 1754511118, 1754511118);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `continent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint UNSIGNED DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `ip`, `continent`, `country_id`, `country`, `code`, `currency`, `currency_symbol`, `dial`, `state_id`, `state`, `city`, `created_at`, `updated_at`) VALUES
(1, '197.211.58.12', 'Africa', 161, 'Nigeria', 'NG', 'NGN', '₦', '234', 306, 'Lagos', 'Lagos', '2025-06-10 21:44:48', '2025-06-10 21:44:48'),
(2, '197.211.58.12', 'Africa', 161, 'Nigeria', 'NG', 'NGN', '₦', '234', 306, 'Lagos', 'Lagos', '2025-06-24 10:18:22', '2025-06-24 10:18:22'),
(3, '197.211.58.12', 'Africa', 161, 'Nigeria', 'NG', 'NGN', '₦', '234', 306, 'Lagos', 'Lagos', '2025-06-26 19:56:33', '2025-06-26 19:56:33'),
(4, '197.211.58.12', 'Africa', 161, 'Nigeria', 'NG', 'NGN', '₦', '234', 306, 'Lagos', 'Lagos', '2025-07-01 20:26:49', '2025-07-01 20:26:49'),
(5, '197.211.58.12', 'Africa', 161, 'Nigeria', 'NG', 'NGN', '₦', '234', 306, 'Lagos', 'Lagos', '2025-07-29 21:00:57', '2025-07-29 21:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `login_activities`
--

CREATE TABLE `login_activities` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_activities`
--

INSERT INTO `login_activities` (`id`, `user_id`, `ip_address`, `location`, `browser`, `device`, `os`, `browser_name`, `browser_version`, `platform`, `platform_version`, `created_at`, `updated_at`) VALUES
(2, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-09 12:43:51', '2025-07-09 12:43:51'),
(3, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-09 16:25:35', '2025-07-09 16:25:35'),
(4, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 10:46:41', '2025-07-11 10:46:41'),
(5, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 10:48:00', '2025-07-11 10:48:00'),
(6, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 10:50:19', '2025-07-11 10:50:19'),
(7, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 11:07:10', '2025-07-11 11:07:10'),
(8, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 11:08:36', '2025-07-11 11:08:36'),
(9, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 11:10:12', '2025-07-11 11:10:12'),
(10, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 11:12:19', '2025-07-11 11:12:19'),
(11, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-11 11:24:09', '2025-07-11 11:24:09'),
(12, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-14 08:26:48', '2025-07-14 08:26:48'),
(13, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-14 18:09:32', '2025-07-14 18:09:32'),
(14, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-15 13:46:02', '2025-07-15 13:46:02'),
(15, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-25 10:47:27', '2025-07-25 10:47:27'),
(16, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-25 14:24:30', '2025-07-25 14:24:30'),
(17, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-26 11:30:57', '2025-07-26 11:30:57'),
(18, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-27 20:30:32', '2025-07-27 20:30:32'),
(19, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-28 08:18:36', '2025-07-28 08:18:36'),
(20, 2, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-28 13:49:55', '2025-07-28 13:49:55'),
(21, 2, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-07-29 17:56:34', '2025-07-29 17:56:34'),
(22, 2, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-04 13:32:24', '2025-08-04 13:32:24'),
(23, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-04 13:59:14', '2025-08-04 13:59:14'),
(24, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-04 18:44:04', '2025-08-04 18:44:04'),
(25, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-05 00:09:21', '2025-08-05 00:09:21'),
(26, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-05 09:34:18', '2025-08-05 09:34:18'),
(27, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-06 01:17:35', '2025-08-06 01:17:35'),
(28, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-06 18:56:07', '2025-08-06 18:56:07'),
(29, 1, '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'WebKit', 'Windows 10.0', 'Chrome', '138.0.0.0', 'Windows', '10.0', '2025-08-06 21:58:39', '2025-08-06 21:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '0001_01_01_000003_create_locations_table', 1),
(6, '0005_06_10_175911_create_platforms_table', 1),
(7, '2001_01_01_000008_create_user_platforms_table', 1),
(8, '2001_01_01_000008_create_user_locations_table', 1),
(9, '2001_02_10_182321_create_documents_table', 1),
(10, '2001_03_04_115128_create_bank_accounts_table', 1),
(11, '2025_06_10_175934_create_task_templates_table', 1),
(12, '2025_06_10_180023_create_tasks_table', 1),
(13, '2025_06_10_180110_create_task_promotions_table', 1),
(14, '2025_06_10_180128_create_orders_table', 1),
(15, '2025_06_10_180129_create_order_items_table', 1),
(16, '2025_06_10_180247_create_task_workers_table', 1),
(17, '2025_06_10_180253_create_referrals_table', 1),
(18, '2025_06_10_180314_create_payments_table', 1),
(19, '2025_06_10_180331_create_settlements_table', 1),
(20, '2025_06_10_182204_create_disputes_table', 1),
(21, '2025_06_10_182222_create_dispute_messages_table', 1),
(22, '2025_06_10_182240_create_dispute_trails_table', 1),
(23, '2025_06_17_024031_create_wallets_table', 2),
(24, '2025_06_18_140043_create_plans_table', 3),
(25, '2025_06_18_140051_create_subscriptions_table', 3),
(26, '2025_06_18_165718_create_country_prices_table', 4),
(27, '2025_06_20_122953_create_settings_table', 5),
(28, '2025_06_20_122954_create_roles_table', 5),
(29, '2025_06_20_122955_create_permissions_table', 5),
(30, '2025_06_20_122956_create_permission_role_table', 5),
(31, '2025_06_20_122957_create_role_user_table', 5),
(32, '0001_01_01_000004_create_country_settings_table', 6),
(33, '2025_06_20_195736_create_exchanges_table', 7),
(34, '2025_06_20_195744_create_withdrawals_table', 7),
(35, '2024_07_23_101217_create_user_verifications_table', 8),
(37, '2025_06_21_143012_create_platform_user_table', 10),
(38, '2025_06_21_143542_create_skills_table', 11),
(39, '2025_06_21_143631_create_skill_user_table', 11),
(43, '2025_06_29_015421_create_blog_posts_table', 12),
(45, '2025_07_03_024334_create_task_submissions_table', 13),
(46, '2025_07_04_000000_create_login_activities_table', 13),
(47, '2024_07_23_000000_add_notification_settings_to_users_table', 14),
(48, '2025_07_04_000001_add_document_name_to_user_verifications_table', 15),
(49, '2025_01_15_000002_add_user_ban_fields', 16),
(50, '2025_01_15_000003_create_task_hidden_table', 16),
(51, '2025_07_15_000001_create_task_reports_table', 16),
(52, '2025_07_09_013904_add_device_os_browser_to_login_activities_table', 17),
(54, '2025_07_22_213735_create_comments_table', 18),
(55, '2025_07_26_021304_create_supports_table', 18),
(56, '2025_07_28_130215_create_trails_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `slug`, `processed_at`, `completed_at`, `refunded_at`, `created_at`, `updated_at`) VALUES
(1, 1, '684c96d56cd6d', NULL, NULL, NULL, '2025-06-13 20:23:33', '2025-06-13 20:23:33'),
(2, 1, '684c97024b83e', NULL, NULL, NULL, '2025-06-13 20:24:18', '2025-06-13 20:24:18'),
(3, 1, '684c971797c86', NULL, NULL, NULL, '2025-06-13 20:24:39', '2025-06-13 20:24:39'),
(4, 1, '684dbbf7a40d0', NULL, NULL, NULL, '2025-06-14 17:14:15', '2025-06-14 17:14:15'),
(5, 1, '684dccc3d98c9', NULL, NULL, NULL, '2025-06-14 18:25:55', '2025-06-14 18:25:55'),
(6, 1, '68514b020a036', NULL, NULL, NULL, '2025-06-17 10:01:22', '2025-06-17 10:01:22'),
(7, 1, '685153dbc9c1b', NULL, NULL, NULL, '2025-06-17 10:39:07', '2025-06-17 10:39:07'),
(8, 1, '6856af4e0797b', NULL, NULL, NULL, '2025-06-21 12:10:38', '2025-06-21 12:10:38'),
(9, 3, '6859b4c6bd6f3', NULL, NULL, NULL, '2025-06-23 19:10:46', '2025-06-23 19:10:46'),
(10, 1, '6893b6e973a9e', NULL, NULL, NULL, '2025-08-06 19:11:21', '2025-08-06 19:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `orderable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderable_id` bigint UNSIGNED NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `orderable_type`, `orderable_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Task', 1, '107096.14', '2025-06-13 20:23:33', '2025-06-13 20:23:33'),
(3, 2, 'App\\Models\\Task', 2, '107096.14', '2025-06-13 20:24:18', '2025-06-13 20:24:18'),
(5, 3, 'App\\Models\\Task', 3, '107096.14', '2025-06-13 20:24:39', '2025-06-13 20:24:39'),
(7, 4, 'App\\Models\\Task', 4, '42312.85', '2025-06-14 17:14:15', '2025-06-14 17:14:15'),
(9, 5, 'App\\Models\\Task', 5, '10765.27', '2025-06-14 18:25:55', '2025-06-14 18:25:55'),
(10, 6, 'App\\Models\\Task', 6, '10780.81', '2025-06-17 10:01:22', '2025-06-17 10:01:22'),
(13, 7, 'App\\Models\\Task', 7, '1135.27', '2025-06-17 10:39:07', '2025-06-17 10:39:07'),
(14, 8, 'App\\Models\\Subscription', 1, '2568', '2025-06-21 12:10:38', '2025-06-21 12:10:38'),
(15, 9, 'App\\Models\\Task', 8, '8203.8', '2025-06-23 19:10:46', '2025-06-23 19:10:46'),
(16, 9, 'App\\Models\\TaskPromotion', 7, '3000', '2025-06-23 19:10:46', '2025-06-23 19:10:46'),
(17, 9, 'App\\Models\\TaskPromotion', 8, '2000', '2025-06-23 19:10:46', '2025-06-23 19:10:46'),
(18, 10, 'App\\Models\\Task', 11, '22300.6', '2025-08-06 19:11:21', '2025-08-06 19:11:21'),
(19, 10, 'App\\Models\\TaskPromotion', 13, '2000', '2025-08-06 19:11:21', '2025-08-06 19:11:21'),
(20, 10, 'App\\Models\\TaskPromotion', 14, '2000', '2025-08-06 19:11:21', '2025-08-06 19:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `vat_value` double NOT NULL DEFAULT '0',
  `gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `order_id`, `reference`, `request_id`, `currency`, `amount`, `vat_value`, `gateway`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'SUB-SoFaoQETd2-1749849813', NULL, 'NGN', 107537.14, 7035.14, 'paystack', 'pending', '2025-06-13 20:23:33', '2025-06-13 20:23:33'),
(2, 1, 2, 'SUB-Yve5fFU1na-1749849858', NULL, 'NGN', 107537.14, 7035.14, 'paystack', 'pending', '2025-06-13 20:24:18', '2025-06-13 20:24:18'),
(3, 1, 3, 'SUB-JRzYE9aAYx-1749849879', NULL, 'NGN', 107537.14, 7035.14, 'paystack', 'success', '2025-06-13 20:24:39', '2025-06-13 20:26:37'),
(4, 1, 4, 'SUB-SCJ4DD2YUI-1749924855', NULL, 'NGN', 42323.85, 2768.85, 'paystack', 'success', '2025-06-14 17:14:15', '2025-06-14 17:14:28'),
(5, 1, 5, 'SUB-Z9WisAUbYU-1749929155', NULL, 'NGN', 10765.27, 704.27, 'paystack', 'pending', '2025-06-14 18:25:55', '2025-06-14 18:25:55'),
(6, 1, 6, 'SUB-OrgTyi4tgj-1750158082', NULL, 'NGN', 11002.81, 719.81, 'paystack', 'success', '2025-06-17 10:01:22', '2025-06-17 10:01:43'),
(7, 1, 7, 'SUB-IfXEtXv0rm-1750160347', NULL, 'NGN', 1135.27, 74.27, 'paystack', 'success', '2025-06-17 10:39:07', '2025-06-17 10:39:30'),
(8, 1, 8, 'SUB-jPJkiHlS2X-1750511438', NULL, 'NGN', 2568, 168, 'paystack', 'success', '2025-06-21 12:10:38', '2025-06-21 12:18:06'),
(9, 3, 9, 'SUB-ZRnrtGY4bd-1750709446', NULL, 'NGN', 13203.8, 863.8, 'paystack', 'success', '2025-06-23 19:10:46', '2025-06-23 19:29:40'),
(10, 1, 10, 'SUB-5btPzqW29S-1754511081', NULL, 'NGN', 26300.6, 1720.6, 'paystack', 'success', '2025-08-06 19:11:21', '2025-08-06 19:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'System Settings', 'system_settings', 'Manage system-wide settings', '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(2, 'Country Settings', 'country_settings', 'Manage country-specific settings', '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(3, 'Task Management', 'task_management', 'Manage tasks and jobs', '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(4, 'User Management', 'user_management', 'Manage users', '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(5, 'Staff Management', 'staff_management', 'Manage staff accounts', '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(6, 'Finance Management', 'finance_management', 'Manage financial records', '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(7, 'Support Management', 'support_management', 'Support users', '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(8, 'Blog Management', 'blog_management', 'Manage Site Blog Contents', '2025-07-08 23:58:52', '2025-07-08 23:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(2, 1, 6, '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(3, 1, 5, '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(4, 1, 7, '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(5, 1, 1, '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(6, 1, 3, '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(7, 1, 4, '2025-06-20 12:01:37', '2025-06-20 12:01:37'),
(8, 2, 2, NULL, NULL),
(9, 2, 3, NULL, NULL),
(10, 2, 4, NULL, NULL),
(11, 2, 5, NULL, NULL),
(12, 2, 6, NULL, NULL),
(13, 2, 7, NULL, NULL),
(14, 3, 7, NULL, NULL),
(15, 4, 6, NULL, NULL),
(16, 3, 4, NULL, NULL),
(17, 1, 8, NULL, NULL),
(18, 2, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('taskmaster','worker') COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_promotion` tinyint(1) NOT NULL DEFAULT '0',
  `urgency_promotion` tinyint(1) NOT NULL DEFAULT '0',
  `active_tasks_per_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `withdrawal_maximum_multiplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `slug`, `description`, `type`, `featured_promotion`, `urgency_promotion`, `active_tasks_per_hour`, `is_active`, `withdrawal_maximum_multiplier`, `created_at`, `updated_at`) VALUES
(1, 'Basic Plan', 'basic-plan', 'For starters', 'taskmaster', 1, 1, '1', 1, '1', '2025-06-20 11:09:12', '2025-06-20 11:09:12'),
(2, 'Basic Plan', 'basic-plan-2', 'Basic for Workers', 'worker', 0, 0, '2', 1, '2', '2025-06-20 11:09:46', '2025-06-20 11:09:46');

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'facebook', 'Facebook Activities: Likes, Follow, Comment, Share, etc', '/storage/platforms/1749948982.jpg', 1, '2025-06-11 12:39:40', '2025-06-14 23:57:37'),
(2, 'Twitter', 'twitter', 'Activities on X.com', '/storage/platforms/1749949523.png', 1, '2025-06-15 00:05:23', '2025-06-15 00:05:23'),
(3, 'Instagram', 'instagram', 'Activities on instagram', '/storage/platforms/1749949584.jpg', 1, '2025-06-15 00:06:24', '2025-06-15 00:06:24'),
(4, 'Linkedin', 'linkedin', 'Activities on Linkedin', '/storage/platforms/1749949650.png', 1, '2025-06-15 00:07:30', '2025-06-15 00:07:30'),
(5, 'Youtube', 'youtube', 'Youtube activities', '/storage/platforms/1749949720.jpg', 1, '2025-06-15 00:08:40', '2025-06-15 00:08:40'),
(6, 'Reddit', 'reddit', 'Reddit Activities', '/storage/platforms/1749949771.jpg', 1, '2025-06-15 00:09:31', '2025-06-15 00:09:31'),
(7, 'TikTok', 'tiktok', 'Tiktok Activities', '/storage/platforms/1749949836.jpg', 1, '2025-06-15 00:10:36', '2025-06-15 00:10:36'),
(8, 'Snapchat', 'snapchat', 'Snapchat activities', '/storage/platforms/1749950052.png', 1, '2025-06-15 00:14:12', '2025-06-15 00:14:12'),
(9, 'Whatsapp', 'whatsapp', 'Whatsapp Activities', '/storage/platforms/1749950125.jpg', 1, '2025-06-15 00:15:25', '2025-06-15 00:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `platform_user`
--

CREATE TABLE `platform_user` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `platform_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platform_user`
--

INSERT INTO `platform_user` (`id`, `user_id`, `platform_id`, `created_at`, `updated_at`) VALUES
(8, 1, 1, NULL, NULL),
(9, 1, 2, NULL, NULL),
(10, 1, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint UNSIGNED NOT NULL,
  `referrer_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'external',
  `task_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `expire_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referrer_id`, `email`, `type`, `task_id`, `status`, `expire_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'fourth@gmail.com', 'external', 7, 'invited', '2025-06-30 02:21:54', '2025-06-23 02:21:54', '2025-06-23 02:21:54'),
(2, 1, 'fourth@gmail.com', 'external', 7, 'invited', '2025-06-30 02:24:09', '2025-06-23 02:24:09', '2025-06-23 02:24:09'),
(3, 1, 'isreal@gmail.com', 'external', 7, 'invited', '2025-06-30 02:24:09', '2025-06-23 02:24:15', '2025-06-23 02:24:15'),
(4, 1, 'clementpmargreth@gmail.com', 'external', 7, 'invited', '2025-06-30 03:18:55', '2025-06-23 03:18:55', '2025-06-23 03:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', NULL, '2025-06-20 12:01:37', '2025-07-28 14:04:53'),
(2, 'Country Manager', NULL, '2025-06-20 12:01:37', '2025-06-20 12:38:40'),
(3, 'User Support', NULL, '2025-06-20 12:01:37', '2025-06-20 12:39:15'),
(4, 'Financial Analyst', NULL, '2025-06-20 12:01:37', '2025-06-20 12:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, '2025-06-20 12:01:38', '2025-06-20 12:01:38'),
(2, 4, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hWgCafTUJI6dxDobTZDTBHsE7m6m49khoB5cZVaw', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTnF1NzcyNWplMDcxVThJUzV4MzRzaE90UFBZdDBBMXRnS2FObVRlZyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vd29uZWdpZy50ZXN0L2pvYnMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1754527296);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'enable_system_monitoring', '0', '2025-06-20 12:41:26', '2025-07-28 16:28:27'),
(2, 'freeze_wallets_globally', '0', '2025-06-20 12:41:26', '2025-07-28 16:28:27'),
(3, 'allow_wallet_funds_exchange', '0', '2025-06-20 12:41:26', '2025-07-28 16:28:27'),
(4, 'job_invite_expiry', '7', '2025-06-20 12:41:26', '2025-06-20 12:57:46'),
(5, 'enforce_2fa', '1', '2025-06-20 12:41:26', '2025-07-28 16:28:27'),
(6, 'allow_public_profile', '0', '2025-06-20 12:41:26', '2025-07-28 16:28:27'),
(7, 'free_user_task_limit', '2', '2025-06-20 12:41:26', '2025-06-20 12:57:52'),
(8, 'email_notifications', '[\"task_assigned\",\"task_completed\",\"weekly_summary\"]', '2025-06-20 13:00:22', '2025-06-20 13:00:22'),
(9, 'web_notifications', '[]', '2025-06-20 13:00:22', '2025-06-20 13:00:22'),
(10, 'submission_review_deadline', '24', '2025-07-08 17:13:16', '2025-07-08 17:13:16'),
(11, 'blog_categories', '[\"Guides\",\"Tips\",\"News\",\"Updates\",\"FAQ\"]', '2025-07-28 16:27:18', '2025-07-28 16:28:27');

-- --------------------------------------------------------

--
-- Table structure for table `settlements`
--

CREATE TABLE `settlements` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `settlementable_id` bigint UNSIGNED NOT NULL,
  `settlementable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settlements`
--

INSERT INTO `settlements` (`id`, `user_id`, `settlementable_id`, `settlementable_type`, `amount`, `currency`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 'App\\Models\\Task', '100', 'NGN', 'pending', '2025-06-17 01:36:46', '2025-06-17 01:36:46'),
(2, 3, 5, 'App\\Models\\Task', '100', 'NGN', 'pending', '2025-06-17 12:07:47', '2025-06-17 12:07:47');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Microsoft Excel', 'microsoft-excel', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(2, 'Copywriting', 'copywriting', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(3, 'Photoshop', 'photoshop', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(4, 'HTML/CSS', 'html-css', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(5, 'Social Media Management', 'social-media-management', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(6, 'Data Entry', 'data-entry', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(7, 'Customer Service', 'customer-service', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(8, 'Project Management', 'project-management', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(9, 'Content Writing', 'content-writing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(10, 'Graphic Design', 'graphic-design', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(11, 'Video Editing', 'video-editing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(12, 'SEO', 'seo', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(13, 'WordPress', 'wordpress', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(14, 'PHP', 'php', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(15, 'Laravel', 'laravel', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(16, 'JavaScript', 'javascript', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(17, 'React', 'react', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(18, 'Vue.js', 'vue-js', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(19, 'Node.js', 'node-js', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(20, 'Python', 'python', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(21, 'Django', 'django', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(22, 'Flask', 'flask', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(23, 'Ruby on Rails', 'ruby-on-rails', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(24, 'Java', 'java', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(25, 'Spring', 'spring', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(26, 'Kotlin', 'kotlin', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(27, 'Swift', 'swift', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(28, 'iOS Development', 'ios-development', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(29, 'Android Development', 'android-development', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(30, 'Flutter', 'flutter', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(31, 'React Native', 'react-native', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(32, 'Unity', 'unity', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(33, 'Unreal Engine', 'unreal-engine', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(34, 'Game Development', 'game-development', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(35, '3D Modeling', '3d-modeling', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(36, 'Animation', 'animation', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(37, 'UI/UX Design', 'ui-ux-design', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(38, 'Figma', 'figma', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(39, 'Adobe XD', 'adobe-xd', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(40, 'Sketch', 'sketch', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(41, 'Digital Marketing', 'digital-marketing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(42, 'Email Marketing', 'email-marketing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(43, 'PPC Advertising', 'ppc-advertising', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(44, 'Google Analytics', 'google-analytics', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(45, 'Facebook Ads', 'facebook-ads', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(46, 'Instagram Marketing', 'instagram-marketing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(47, 'Content Marketing', 'content-marketing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(48, 'Affiliate Marketing', 'affiliate-marketing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(49, 'Sales', 'sales', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(50, 'Lead Generation', 'lead-generation', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(51, 'CRM', 'crm', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(52, 'Customer Support', 'customer-support', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(53, 'Zendesk', 'zendesk', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(54, 'Intercom', 'intercom', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(55, 'Help Desk', 'help-desk', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(56, 'Technical Support', 'technical-support', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(57, 'Network Administration', 'network-administration', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(58, 'System Administration', 'system-administration', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(59, 'Linux', 'linux', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(60, 'Windows Server', 'windows-server', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(61, 'AWS', 'aws', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(62, 'Google Cloud', 'google-cloud', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(63, 'Microsoft Azure', 'microsoft-azure', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(64, 'Docker', 'docker', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(65, 'Kubernetes', 'kubernetes', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(66, 'Cybersecurity', 'cybersecurity', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(67, 'Penetration Testing', 'penetration-testing', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(68, 'Ethical Hacking', 'ethical-hacking', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(69, 'Blockchain', 'blockchain', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(70, 'Cryptocurrency', 'cryptocurrency', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(71, 'Smart Contracts', 'smart-contracts', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(72, 'Data Science', 'data-science', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(73, 'Machine Learning', 'machine-learning', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(74, 'Deep Learning', 'deep-learning', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(75, 'Artificial Intelligence', 'artificial-intelligence', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(76, 'TensorFlow', 'tensorflow', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(77, 'PyTorch', 'pytorch', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(78, 'Scikit-learn', 'scikit-learn', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(79, 'Pandas', 'pandas', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(80, 'NumPy', 'numpy', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(81, 'Matplotlib', 'matplotlib', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(82, 'Data Visualization', 'data-visualization', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(83, 'Tableau', 'tableau', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(84, 'Power BI', 'power-bi', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(85, 'SQL', 'sql', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(86, 'MySQL', 'mysql', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(87, 'PostgreSQL', 'postgresql', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(88, 'MongoDB', 'mongodb', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(89, 'Firebase', 'firebase', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(90, 'REST APIs', 'rest-apis', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(91, 'GraphQL', 'graphql', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(92, 'Git', 'git', '2025-06-21 13:41:22', '2025-06-21 13:41:22'),
(93, 'GitHub', 'github', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(94, 'Jira', 'jira', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(95, 'Agile', 'agile', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(96, 'Scrum', 'scrum', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(97, 'Product Management', 'product-management', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(98, 'Business Development', 'business-development', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(99, 'Financial Analysis', 'financial-analysis', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(100, 'Accounting', 'accounting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(101, 'Bookkeeping', 'bookkeeping', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(102, 'QuickBooks', 'quickbooks', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(103, 'Xero', 'xero', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(104, 'Legal Writing', 'legal-writing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(105, 'Contract Law', 'contract-law', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(106, 'Intellectual Property', 'intellectual-property', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(107, 'Human Resources', 'human-resources', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(108, 'Recruiting', 'recruiting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(109, 'Talent Acquisition', 'talent-acquisition', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(110, 'Employee Relations', 'employee-relations', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(111, 'Translation', 'translation', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(112, 'Transcription', 'transcription', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(113, 'Proofreading', 'proofreading', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(114, 'Editing', 'editing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(115, 'Ghostwriting', 'ghostwriting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(116, 'Creative Writing', 'creative-writing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(117, 'Technical Writing', 'technical-writing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(118, 'Grant Writing', 'grant-writing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(119, 'Resume Writing', 'resume-writing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(120, 'Cover Letter Writing', 'cover-letter-writing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(121, 'Public Speaking', 'public-speaking', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(122, 'Presentation Skills', 'presentation-skills', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(123, 'Negotiation', 'negotiation', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(124, 'Teamwork', 'teamwork', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(125, 'Leadership', 'leadership', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(126, 'Time Management', 'time-management', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(127, 'Problem Solving', 'problem-solving', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(128, 'Critical Thinking', 'critical-thinking', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(129, 'Communication', 'communication', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(130, 'Emotional Intelligence', 'emotional-intelligence', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(131, 'Adaptability', 'adaptability', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(132, 'Creativity', 'creativity', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(133, 'Innovation', 'innovation', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(134, 'Photography', 'photography', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(135, 'Videography', 'videography', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(136, 'Music Production', 'music-production', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(137, 'Audio Editing', 'audio-editing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(138, 'Podcasting', 'podcasting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(139, 'Voice Acting', 'voice-acting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(140, 'Illustration', 'illustration', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(141, 'Logo Design', 'logo-design', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(142, 'Brand Identity', 'brand-identity', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(143, 'Print Design', 'print-design', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(144, 'Fashion Design', 'fashion-design', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(145, 'Interior Design', 'interior-design', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(146, 'Architecture', 'architecture', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(147, 'CAD', 'cad', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(148, 'Tutoring', 'tutoring', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(149, 'Coaching', 'coaching', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(150, 'Mentoring', 'mentoring', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(151, 'Event Planning', 'event-planning', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(152, 'Wedding Planning', 'wedding-planning', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(153, 'Catering', 'catering', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(154, 'Baking', 'baking', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(155, 'Cooking', 'cooking', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(156, 'Personal Training', 'personal-training', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(157, 'Yoga Instruction', 'yoga-instruction', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(158, 'Meditation', 'meditation', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(159, 'Mindfulness', 'mindfulness', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(160, 'Life Coaching', 'life-coaching', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(161, 'Career Coaching', 'career-coaching', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(162, 'Financial Planning', 'financial-planning', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(163, 'Investment Strategy', 'investment-strategy', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(164, 'Real Estate', 'real-estate', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(165, 'Property Management', 'property-management', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(166, 'E-commerce', 'e-commerce', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(167, 'Shopify', 'shopify', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(168, 'WooCommerce', 'woocommerce', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(169, 'Magento', 'magento', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(170, 'Dropshipping', 'dropshipping', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(171, 'Amazon FBA', 'amazon-fba', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(172, 'eBay Selling', 'ebay-selling', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(173, 'Etsy Selling', 'etsy-selling', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(174, 'Digital Art', 'digital-art', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(175, 'NFTs', 'nfts', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(176, 'Game Testing', 'game-testing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(177, 'Software Testing', 'software-testing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(178, 'Quality Assurance', 'quality-assurance', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(179, 'Automation Testing', 'automation-testing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(180, 'Manual Testing', 'manual-testing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(181, 'User Research', 'user-research', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(182, 'A/B Testing', 'a-b-testing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(183, 'Conversion Rate Optimization', 'conversion-rate-optimization', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(184, 'Growth Hacking', 'growth-hacking', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(185, 'Public Relations', 'public-relations', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(186, 'Media Relations', 'media-relations', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(187, 'Crisis Management', 'crisis-management', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(188, 'Market Research', 'market-research', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(189, 'Survey Design', 'survey-design', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(190, 'Statistical Analysis', 'statistical-analysis', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(191, 'SPSS', 'spss', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(192, 'R', 'r', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(193, 'MATLAB', 'matlab', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(194, 'SAS', 'sas', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(195, 'Excel VBA', 'excel-vba', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(196, 'Google Sheets', 'google-sheets', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(197, 'Airtable', 'airtable', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(198, 'Notion', 'notion', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(199, 'Trello', 'trello', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(200, 'Asana', 'asana', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(201, 'Slack', 'slack', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(202, 'Microsoft Teams', 'microsoft-teams', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(203, 'Zoom', 'zoom', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(204, 'Google Meet', 'google-meet', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(205, 'Webflow', 'webflow', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(206, 'Bubble', 'bubble', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(207, 'Adalo', 'adalo', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(208, 'Zapier', 'zapier', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(209, 'Integromat', 'integromat', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(210, 'API Integration', 'api-integration', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(211, 'Web Scraping', 'web-scraping', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(212, 'Data Mining', 'data-mining', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(213, 'Big Data', 'big-data', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(214, 'Apache Spark', 'apache-spark', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(215, 'Hadoop', 'hadoop', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(216, 'Data Warehousing', 'data-warehousing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(217, 'ETL', 'etl', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(218, 'Business Intelligence', 'business-intelligence', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(219, 'Data Governance', 'data-governance', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(220, 'Risk Management', 'risk-management', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(221, 'Compliance', 'compliance', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(222, 'GDPR', 'gdpr', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(223, 'CCPA', 'ccpa', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(224, 'HIPAA', 'hipaa', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(225, 'Legal Research', 'legal-research', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(226, 'Paralegal Services', 'paralegal-services', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(227, 'Virtual Assistant', 'virtual-assistant', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(228, 'Executive Assistant', 'executive-assistant', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(229, 'Administrative Support', 'administrative-support', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(230, 'Data Entry Clerk', 'data-entry-clerk', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(231, 'Typing', 'typing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(232, 'Telemarketing', 'telemarketing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(233, 'Cold Calling', 'cold-calling', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(234, 'Appointment Setting', 'appointment-setting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(235, 'Customer Retention', 'customer-retention', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(236, 'Upselling', 'upselling', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(237, 'Cross-selling', 'cross-selling', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(238, 'Account Management', 'account-management', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(239, 'Salesforce', 'salesforce', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(240, 'HubSpot', 'hubspot', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(241, 'Zoho CRM', 'zoho-crm', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(242, 'Pipedrive', 'pipedrive', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(243, 'Freshdesk', 'freshdesk', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(244, 'LiveChat', 'livechat', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(245, 'Chatbot Development', 'chatbot-development', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(246, 'Dialogflow', 'dialogflow', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(247, 'Microsoft Bot Framework', 'microsoft-bot-framework', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(248, 'Rasa', 'rasa', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(249, 'Voice User Interface Design', 'voice-user-interface-design', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(250, 'Alexa Skills Kit', 'alexa-skills-kit', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(251, 'Google Assistant', 'google-assistant', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(252, 'Siri Shortcuts', 'siri-shortcuts', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(253, '3D Printing', '3d-printing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(254, 'CNC Machining', 'cnc-machining', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(255, 'Laser Cutting', 'laser-cutting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(256, 'Welding', 'welding', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(257, 'Woodworking', 'woodworking', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(258, 'Gardening', 'gardening', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(259, 'Landscaping', 'landscaping', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(260, 'Home Repair', 'home-repair', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(261, 'Plumbing', 'plumbing', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(262, 'Electrical Wiring', 'electrical-wiring', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(263, 'Painting', 'painting', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(264, 'Carpentry', 'carpentry', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(265, 'Masonry', 'masonry', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(266, 'HVAC', 'hvac', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(267, 'Appliance Repair', 'appliance-repair', '2025-06-21 13:41:23', '2025-06-21 13:41:23'),
(268, 'Auto Repair', 'auto-repair', '2025-06-21 13:41:23', '2025-06-21 13:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `skill_user`
--

CREATE TABLE `skill_user` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `skill_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skill_user`
--

INSERT INTO `skill_user` (`id`, `user_id`, `skill_id`, `created_at`, `updated_at`) VALUES
(1, 1, 15, NULL, NULL),
(2, 1, 11, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 134, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `cost` int NOT NULL DEFAULT '0',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `duration_months` int NOT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `billing_cycle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `auto_renew` tinyint(1) NOT NULL DEFAULT '1',
  `features` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `cost`, `currency`, `status`, `duration_months`, `starts_at`, `expires_at`, `cancelled_at`, `suspended_at`, `billing_cycle`, `auto_renew`, `features`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2568, 'NGN', 'active', 3, '2025-06-21 12:18:06', '2025-09-21 12:18:06', NULL, NULL, 'monthly', 1, '[\"2 active tasks per hour\", \"Withdrawal limit multiplier: 2\"]', '2025-06-21 12:10:37', '2025-06-21 12:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `supports`
--

CREATE TABLE `supports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `platform_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `expected_completion_minutes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_budget` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `files` json DEFAULT NULL,
  `template_data` json DEFAULT NULL,
  `requirements` json DEFAULT NULL,
  `number_of_people` int NOT NULL DEFAULT '1',
  `visibility` enum('public','private') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `budget_per_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monitoring_type` enum('self_monitoring','admin_monitoring','system_monitoring') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'self_monitoring',
  `restricted_countries` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `template_id`, `platform_id`, `title`, `slug`, `description`, `expected_completion_minutes`, `expected_budget`, `expiry_date`, `files`, `template_data`, `requirements`, `number_of_people`, `visibility`, `budget_per_person`, `currency`, `monitoring_type`, `restricted_countries`, `is_active`, `approved_at`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Deleniti ut et proid', 'deleniti-ut-et-proid', 'Sometimes, your models are simple enough that you only want to manage records on one page, using modals to create, edit and delete records. To generate a simple resource with modals:', '180', '100000', NULL, NULL, NULL, '[\"Molestiae est ut dol\"]', 1000, 'public', '100', 'NGN', 'self_monitoring', NULL, 1, '2025-06-27 11:24:02', 2, '2025-06-13 20:23:33', '2025-06-13 20:23:33'),
(2, 1, 1, 1, 'Deleniti ut et proid', 'deleniti-ut-et-proid-2', 'Sometimes, your models are simple enough that you only want to manage records on one page, using modals to create, edit and delete records. To generate a simple resource with modals:', '180', '100000', NULL, NULL, NULL, '[\"Molestiae est ut dol\"]', 1000, 'public', '100', 'NGN', 'self_monitoring', NULL, 1, '2025-06-27 11:24:08', 2, '2025-06-13 20:24:18', '2025-06-13 20:24:18'),
(3, 1, 1, 1, 'Deleniti ut et proid', 'deleniti-ut-et-proid-3', 'Sometimes, your models are simple enough that you only want to manage records on one page, using modals to create, edit and delete records. To generate a simple resource with modals:', '180', '100000', NULL, NULL, NULL, '[\"Molestiae est ut dol\"]', 1000, 'public', '100', 'NGN', 'self_monitoring', NULL, 1, '2025-06-27 11:24:13', 2, '2025-06-13 20:24:39', '2025-06-13 20:24:39'),
(4, 1, 1, 1, 'Quo dolore fugit im', 'quo-dolore-fugit-im', 'Follow my facebook page', '241920', '39483', NULL, NULL, '{\"page_url\": \"\"}', NULL, 963, 'private', '41', 'NGN', 'self_monitoring', NULL, 1, NULL, 2, '2025-06-14 17:14:15', '2025-06-14 17:14:15'),
(5, 1, 1, 1, 'Youre Beautify', 'youre-beautify', 'The classes in the Pages directory are used to customize the pages in the app that interact with your resource. They’re all full-page Livewire components that you can customize in any way you wish', '2880', '10000', NULL, NULL, '{\"page_url\": {\"title\": \"Page URL\", \"value\": \"http://facebook.com\", \"required\": true}}', '[\"beautiful\"]', 100, 'public', '100', 'NGN', 'self_monitoring', NULL, 1, NULL, 2, '2025-06-14 18:25:55', '2025-06-14 18:25:55'),
(6, 1, 1, 2, 'Like my facebook page', 'like-my-facebook-page', 'This is a description of my task for uoi', '60', '10000', NULL, NULL, NULL, '[\"Laptop\", \"Digital Marketing\"]', 100, 'public', '100', 'NGN', 'self_monitoring', '[]', 1, '2025-06-27 11:24:17', 2, '2025-06-17 10:01:22', '2025-06-17 10:01:22'),
(7, 1, 2, 1, 'Share my video', 'share-my-video', 'Watch my facebook video', '1440', '1000', NULL, '[{\"name\": \"Wonesuite User Menus- v2.txt\", \"path\": \"storage/task-files/GDodHOmNlz4oOOxA1058I4T2lJLTdmYaWs5hpS05.txt\", \"size\": 7678, \"mime_type\": \"text/plain\"}]', '{\"video_url\": {\"value\": \"http://facebookvideo.com\"}, \"video_minutes\": {\"value\": \"5\"}}', '[]', 10, 'public', '100', 'NGN', 'admin_monitoring', '[]', 1, NULL, 2, '2025-06-17 10:39:07', '2025-06-20 20:02:01'),
(8, 3, 3, 5, 'Chocolate', 'chocolate', 'Watch my youtube video', '3', '7000', '2025-06-30 23:00:00', '[{\"name\": \"birthday.jpeg\", \"path\": \"storage/task-files/V8ELSfHfKuUJ1CyRZWrem3oGEiBMbZE9KOqa40lf.jpg\", \"size\": 92283, \"mime_type\": \"image/jpeg\"}, {\"name\": \"birthday.jpg\", \"path\": \"storage/task-files/RynjnrhicfBtwGW3n1S2soMcajQbNsbSR9OwfA87.jpg\", \"size\": 121165, \"mime_type\": \"image/jpeg\"}]', '{\"youtube_video_url\": {\"value\": \"https://youtu.be/Z6J5HIr2Nyg?list=PL6u82dzQtlfv8fJF3gm42TDHJdtA2NDWT\"}}', '[\"Livewire\", \"Microsoft word\"]', 100, 'public', '70', 'NGN', 'self_monitoring', '[]', 1, NULL, NULL, '2025-06-23 19:10:46', '2025-06-23 19:10:46'),
(9, 1, 3, 5, 'Nihil tenetur saepe ', 'nihil-tenetur-saepe', 'Watch my youtube video', '73440', '7000', '2025-07-26 23:00:00', '[{\"name\": \"advertize.png\", \"path\": \"storage/task-files/6f9BXJeIkSHEma8iT8SKhRBBf2rXAkzHR0TGw1kn.png\", \"size\": 3842, \"mime_type\": \"image/png\"}]', '{\"youtube_video_url\": {\"name\": \"youtube_video_url\", \"type\": \"url\", \"title\": \"Youtube Video Url\", \"value\": \"https://youtu.be/Z6J5HIr2Nyg?list=PL6u82dzQtlfv8fJF3gm42TDHJdtA2NDWT\", \"required\": true}}', '[\"Iure molestias iure\"]', 100, 'public', '70', 'NGN', 'self_monitoring', '[]', 0, NULL, NULL, '2025-06-27 11:40:12', '2025-06-27 11:40:12'),
(10, 1, 3, 5, 'Asperiores quod eos', 'asperiores-quod-eos', 'Watch my youtube video', '37440', '22500', '2025-07-26 23:00:00', '[]', '{\"video_url\": {\"value\": \"https://youtu.be/Z6J5HIr2Nyg?list=PL6u82dzQtlfv8fJF3gm42TDHJdtA2NDWT\"}, \"youtube_video_url\": {\"name\": \"youtube_video_url\", \"type\": \"url\", \"title\": \"Youtube Video Url\", \"value\": \"https://youtu.be/Z6J5HIr2Nyg?list=PL6u82dzQtlfv8fJF3gm42TDHJdtA2NDWT\", \"required\": true}}', '[\"Aliquid\"]', 300, 'public', '75', 'NGN', 'self_monitoring', '[]', 0, NULL, NULL, '2025-06-27 11:54:28', '2025-06-27 11:54:28'),
(11, 1, 4, 9, 'Someone is coming', 'someone-is-coming', 'Post content to your whatsapp status\nSomeone is coming to pick you\n', '4', '10000', '2025-08-08 23:00:00', NULL, '{\"content\": {\"name\": \"content\", \"type\": \"textarea\", \"title\": \"Content\", \"value\": \"Whatsapp Content to post\", \"required\": true}, \"media_file\": {\"name\": \"media_file\", \"type\": \"file\", \"title\": \"Media File\", \"value\": [], \"required\": true}}', '[\"Home Phone\"]', 100, 'public', '100', 'NGN', 'self_monitoring', '[]', 1, NULL, NULL, '2025-08-06 19:11:21', '2025-08-06 19:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `task_hidden`
--

CREATE TABLE `task_hidden` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_hidden`
--

INSERT INTO `task_hidden` (`id`, `task_id`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_promotions`
--

CREATE TABLE `task_promotions` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` enum('featured','urgent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` int NOT NULL DEFAULT '1',
  `start_at` timestamp NULL DEFAULT NULL,
  `cost` int NOT NULL DEFAULT '0',
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_promotions`
--

INSERT INTO `task_promotions` (`id`, `task_id`, `user_id`, `type`, `days`, `start_at`, `cost`, `currency`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'featured', 7, NULL, 441, 'NGN', '2025-06-13 20:23:33', '2025-06-13 20:23:33'),
(2, 2, 1, 'featured', 7, NULL, 441, 'NGN', '2025-06-13 20:24:18', '2025-06-13 20:24:18'),
(3, 3, 1, 'featured', 7, NULL, 441, 'NGN', '2025-06-13 20:24:39', '2025-06-13 20:24:39'),
(4, 4, 1, 'urgent', 1, NULL, 11, 'NGN', '2025-06-14 17:14:15', '2025-06-14 17:14:15'),
(5, 6, 1, 'featured', 3, NULL, 189, 'NGN', '2025-06-17 10:01:22', '2025-06-17 10:01:22'),
(6, 6, 1, 'urgent', 3, NULL, 33, 'NGN', '2025-06-17 10:01:22', '2025-06-17 10:01:22'),
(7, 8, 3, 'featured', 3, NULL, 3000, 'NGN', '2025-06-23 19:10:46', '2025-06-23 19:10:46'),
(8, 8, 3, 'urgent', 1, NULL, 20, 'NGN', '2025-06-23 19:10:46', '2025-06-23 19:10:46'),
(9, 9, 1, 'featured', 1, NULL, 1000, 'NGN', '2025-06-27 11:40:12', '2025-06-27 11:40:12'),
(10, 9, 1, 'urgent', 1, NULL, 20, 'NGN', '2025-06-27 11:40:12', '2025-06-27 11:40:12'),
(11, 10, 1, 'featured', 1, NULL, 1000, 'NGN', '2025-06-27 11:54:28', '2025-06-27 11:54:28'),
(12, 10, 1, 'urgent', 1, NULL, 6000, 'NGN', '2025-06-27 11:54:28', '2025-06-27 11:54:28'),
(13, 11, 1, 'featured', 2, '2025-08-06 19:11:58', 2000, 'NGN', '2025-08-06 19:11:21', '2025-08-06 19:11:58'),
(14, 11, 1, 'urgent', 1, '2025-08-06 19:11:58', 2000, 'NGN', '2025-08-06 19:11:21', '2025-08-06 19:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `task_reports`
--

CREATE TABLE `task_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reason` enum('broken_link','unclear_instructions','takes_longer_than_2_hours','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','reviewed','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_submissions`
--

CREATE TABLE `task_submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `task_worker_id` bigint UNSIGNED NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `disputed_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `submissions` json DEFAULT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_templates`
--

CREATE TABLE `task_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `platform_id` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_fields` json NOT NULL,
  `submission_fields` json NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_templates`
--

INSERT INTO `task_templates` (`id`, `platform_id`, `name`, `description`, `task_fields`, `submission_fields`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Facebook Page Like', 'Follow my facebook page', '[{\"name\": \"page_url\", \"type\": \"url\", \"title\": \"Page URL\", \"options\": null, \"required\": true, \"placeholder\": \"Enter Page url\"}]', '[{\"name\": \"profile_url\", \"type\": \"url\", \"title\": \"Profile Url\", \"options\": null, \"required\": true, \"placeholder\": \"Enter your profile url\"}, {\"name\": \"image_proof\", \"type\": \"file\", \"title\": \"Image Proof\", \"options\": null, \"required\": false, \"placeholder\": \"Upload screenshots of like\"}]', 1, '2025-06-11 14:42:33', '2025-06-11 15:01:15'),
(2, 1, 'Facebook Video Watch', 'Watch my facebook video', '[{\"name\": \"video_url\", \"type\": \"url\", \"title\": \"Video Url\", \"options\": null, \"required\": true, \"placeholder\": \"Enter video url\"}, {\"name\": \"video_minutes\", \"type\": \"number\", \"title\": \"Video Minutes\", \"options\": null, \"required\": false, \"placeholder\": \"Number of watchable minutes\"}]', '[{\"name\": \"profile_name\", \"type\": \"text\", \"title\": \"Profile Name\", \"options\": null, \"required\": true, \"placeholder\": \"Your facebook Profile name\"}, {\"name\": \"facebook_profile_url\", \"type\": \"text\", \"title\": \"Facebook Profile Url\", \"options\": null, \"required\": true, \"placeholder\": \"Your facebook profile url\"}]', 1, '2025-06-16 21:13:07', '2025-06-16 21:13:07'),
(3, 5, 'Youtube Video Watch', 'Watch my youtube video', '[{\"name\": \"youtube_video_url\", \"type\": \"url\", \"title\": \"Youtube Video Url\", \"options\": null, \"required\": true, \"placeholder\": \"Enter video url\"}]', '[{\"name\": \"youtube_profile_link\", \"type\": \"text\", \"title\": \"Youtube Profile Link\", \"options\": null, \"required\": true, \"placeholder\": \"Enter your profile link\"}, {\"name\": \"image_proof_5mins\", \"type\": \"file\", \"title\": \"Image proof 5mins\", \"options\": null, \"required\": true, \"placeholder\": \"Upload video of watch at 5 mins\"}, {\"name\": \"image_proof_10mins\", \"type\": \"file\", \"title\": \"Image proof 10mins\", \"options\": null, \"required\": true, \"placeholder\": \"Upload video of watch at 10mins\"}]', 1, '2025-06-17 12:30:35', '2025-06-18 19:28:41'),
(4, 9, 'Whatsapp Post to Status', 'Post content to your whatsapp status', '[{\"name\": \"content\", \"type\": \"textarea\", \"title\": \"Content\", \"options\": null, \"required\": true, \"placeholder\": \"Content to be posted\"}, {\"name\": \"media_file\", \"type\": \"file\", \"title\": \"Media File\", \"options\": null, \"required\": true, \"placeholder\": \"Image/Video\"}]', '[{\"name\": \"screenshot_of_status_at_11_hours_after_posting\", \"type\": \"file\", \"title\": \"Screenshot of Status at 11 hours after posting\", \"options\": null, \"required\": true, \"placeholder\": null}]', 1, '2025-07-02 18:08:56', '2025-07-02 18:08:56');

-- --------------------------------------------------------

--
-- Table structure for table `task_workers`
--

CREATE TABLE `task_workers` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `saved_at` timestamp NULL DEFAULT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `disputed_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `submissions` json DEFAULT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_workers`
--

INSERT INTO `task_workers` (`id`, `task_id`, `user_id`, `saved_at`, `accepted_at`, `cancelled_at`, `submitted_at`, `paid_at`, `disputed_at`, `resolved_at`, `completed_at`, `submissions`, `review`, `rating`, `created_at`, `updated_at`) VALUES
(1, 5, 3, NULL, '2025-06-16 07:16:41', NULL, '2025-06-16 22:42:13', NULL, NULL, NULL, NULL, '{\"image_proof\": \"storage/submissions/aWPW088Un3Saksy91OLo1Tn15D3Pr5bVpLolRNzr.png\", \"profile_url\": \"https://www.youtube.com/watch\"}', NULL, NULL, '2025-06-16 07:16:41', '2025-06-17 12:07:47'),
(5, 7, 3, NULL, '2025-06-17 12:10:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 12:10:04', '2025-06-17 12:10:04'),
(6, 7, 1, NULL, '2025-06-23 03:05:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 03:05:17', '2025-06-23 03:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `trails`
--

CREATE TABLE `trails` (
  `id` bigint UNSIGNED NOT NULL,
  `trailable_id` bigint UNSIGNED NOT NULL,
  `trailable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `assigned_by` bigint UNSIGNED DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `notification_settings` json DEFAULT NULL,
  `dashboard_view` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tasks',
  `is_banned_from_tasks` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` text COLLATE utf8mb4_unicode_ci,
  `banned_by` bigint UNSIGNED DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `ban_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `country_id`, `state_id`, `city_id`, `address`, `dob`, `gender`, `phone_verified_at`, `email_verified_at`, `password`, `remember_token`, `is_active`, `created_at`, `updated_at`, `two_factor_enabled`, `notification_settings`, `dashboard_view`, `is_banned_from_tasks`, `ban_reason`, `banned_by`, `banned_at`, `ban_expires_at`) VALUES
(1, 'Samuel Margaret', 'samuel-margaret', 'first@gmail.com', NULL, '161', '306', '76851', '21, IREWUNMI BADRU STREET, EBUTE IKORODU', '1988-04-08', 'male', NULL, '2025-07-05 01:12:22', '$2y$12$Br4I2WnvDwfaKVuEOaTZGO6lnZlm55lsgsqEfJPhMhSbeQAwKTJtK', 'o6TymRUtYDCAElbt4IFHbLshxBnpCCicCNfX3biLBbu4bugsK38Geqxj2ZiV', 1, '2025-06-10 21:45:16', '2025-07-26 14:03:49', 0, '{\"worker_email\": {\"new_jobs\": true, \"referral\": true, \"blog_updates\": true, \"task_invitation\": true, \"submission_review\": true, \"settlement_updates\": true, \"withdrawal_payment\": true, \"followed_taskmaster_task\": true}, \"worker_inapp\": {\"new_jobs\": true, \"referral\": true, \"blog_updates\": true, \"task_invitation\": true, \"submission_review\": true, \"settlement_updates\": true, \"withdrawal_payment\": true, \"followed_taskmaster_task\": true}, \"taskmaster_email\": {\"blog_updates\": true, \"job_approval\": true, \"task_started\": true, \"task_submitted\": true}, \"taskmaster_inapp\": {\"blog_updates\": true, \"job_approval\": true, \"task_started\": true, \"task_submitted\": true}}', 'jobs', 0, NULL, NULL, NULL, NULL),
(2, 'Samuel Oluwadamilola', 'samuel-oluwadamilola', 'admin@gmail.com', NULL, '161', '306', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$Br4I2WnvDwfaKVuEOaTZGO6lnZlm55lsgsqEfJPhMhSbeQAwKTJtK', 'owswuEiGcbdHYhpfjv0zuDHhZfWG14QqoM5jtGf7ZY8LsGHqeQEjw57j1jsX', 1, '2025-06-10 21:45:16', '2025-06-10 21:45:16', 0, NULL, 'tasks', 0, NULL, NULL, NULL, NULL),
(3, 'IDERA MAYOWA', 'user404e393e', 'second@gmail.com', NULL, '161', '306', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$dyMUL/vgfjNMfra2xqDFd.6aRPEojrhlwJFhcTC21Zy6sC6pc/nna', 'AZw52EyzOA5MwZA52SMsoTCHZaJMzUzgTNl0JZCeu8YX2NTkn4n2LI3OBwbX', 1, '2025-06-14 23:51:15', '2025-06-14 23:51:15', 0, NULL, 'tasks', 0, NULL, NULL, NULL, NULL),
(4, 'Samuel Margaret', 'user704ed63e', 'reigningkingforever@gmail.com', NULL, '161', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$aZDNxycPU72X5HuzZXzrb.6W.V2/j4Xd6XT4qVp9ri3gzrhBFg0le', NULL, 1, '2025-06-20 15:54:59', '2025-06-20 15:54:59', 0, NULL, 'tasks', 0, NULL, NULL, NULL, NULL),
(5, 'Fourth Man', 'user861703e8', 'fourth@gmail.com', NULL, '161', '306', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$KIOUGUDz4cnSC2IK8gbdNeLm/v.vBXXYdbKas/MmY6lI2ggUb34fq', NULL, 1, '2025-06-20 15:57:11', '2025-06-20 15:57:11', 0, NULL, 'tasks', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_locations`
--

INSERT INTO `user_locations` (`id`, `user_id`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 1, 233, '2025-06-21 19:14:32', '2025-06-21 19:14:32'),
(2, 1, 161, '2025-06-21 19:15:40', '2025-06-21 19:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_verifications`
--

CREATE TABLE `user_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_verifications`
--

INSERT INTO `user_verifications` (`id`, `user_id`, `document_type`, `document_name`, `file_path`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'gov_id', 'national_id', 'verifications/m0GzO1SmDFLYjE1BIIQGK6stpRZdTbkYn4thkOH5.pdf', 'approved', NULL, '2025-06-21 19:04:29', '2025-06-23 01:27:09'),
(2, 3, 'address', 'electricity_bill', 'verifications/92abIh4mkTqQ8LbW6ixmvkVR4hThibjQjxBQA6dU.jpg', 'approved', NULL, '2025-06-23 01:28:08', '2025-06-23 01:30:41'),
(3, 1, 'address', 'electricity_bill', 'verifications/WkVe9YRLeAKi6MlQ1uQ9v0w9M2gzPqSTI50ihYUV.jpg', 'pending', NULL, '2025-07-08 21:51:02', '2025-07-08 21:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_frozen` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `balance`, `currency`, `is_frozen`, `created_at`, `updated_at`) VALUES
(1, 3, '106274.37', 'NGN', 0, NULL, '2025-06-23 00:58:51'),
(2, 3, '40', 'USD', 0, NULL, '2025-06-23 00:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `note` text COLLATE utf8mb4_unicode_ci,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `user_id`, `currency`, `amount`, `payment_method`, `paid_at`, `rejected_at`, `approved_by`, `approved_at`, `reference`, `status`, `note`, `meta`, `created_at`, `updated_at`) VALUES
(1, 3, 'NGN', 10000.00000000, NULL, '2025-06-23 02:46:42', NULL, 2, '2025-06-23 01:45:04', 'WD17506379543', 'paid', NULL, '{\"fee\": 200, \"net_amount\": 9800}', '2025-06-22 23:19:14', '2025-06-23 01:45:04'),
(2, 3, 'NGN', 10000.00000000, NULL, '2025-06-23 02:38:39', NULL, 2, '2025-06-23 01:38:06', 'WD17506391773', 'paid', NULL, '{\"fee\": 150, \"net_amount\": 9850, \"charges_breakdown\": {\"cap\": \"1000\", \"fixed\": \"50\", \"total_fee\": 150, \"percentage\": \"1\", \"percentage_amount\": 100}}', '2025-06-22 23:39:37', '2025-06-23 01:38:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_status_published_at_index` (`status`,`published_at`),
  ADD KEY `blog_posts_user_id_published_at_index` (`user_id`,`published_at`),
  ADD KEY `blog_posts_featured_published_at_index` (`featured`,`published_at`),
  ADD KEY `blog_posts_views_count_index` (`views_count`),
  ADD KEY `blog_posts_created_at_index` (`created_at`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `country_prices`
--
ALTER TABLE `country_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_prices_priceable_type_priceable_id_index` (`priceable_type`,`priceable_id`);

--
-- Indexes for table `country_settings`
--
ALTER TABLE `country_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disputes`
--
ALTER TABLE `disputes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disputes_task_id_foreign` (`task_id`),
  ADD KEY `disputes_user_id_foreign` (`user_id`);

--
-- Indexes for table `dispute_messages`
--
ALTER TABLE `dispute_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dispute_messages_dispute_id_foreign` (`dispute_id`);

--
-- Indexes for table `dispute_trails`
--
ALTER TABLE `dispute_trails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dispute_trails_user_id_foreign` (`user_id`),
  ADD KEY `dispute_trails_dispute_id_foreign` (`dispute_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `exchanges`
--
ALTER TABLE `exchanges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exchanges_user_id_foreign` (`user_id`),
  ADD KEY `exchanges_base_wallet_id_foreign` (`base_wallet_id`),
  ADD KEY `exchanges_target_wallet_id_foreign` (`target_wallet_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_activities`
--
ALTER TABLE `login_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_slug_index` (`slug`),
  ADD KEY `orders_user_id_index` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_orderable_type_orderable_id_index` (`orderable_type`,`orderable_id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_role_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `platform_user`
--
ALTER TABLE `platform_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `platform_user_user_id_foreign` (`user_id`),
  ADD KEY `platform_user_platform_id_foreign` (`platform_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referrals_task_id_foreign` (`task_id`),
  ADD KEY `referrals_referrer_id_foreign` (`referrer_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_user_user_id_role_id_unique` (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_name_unique` (`name`);

--
-- Indexes for table `settlements`
--
ALTER TABLE `settlements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settlements_user_id_foreign` (`user_id`),
  ADD KEY `settlements_task_id_foreign` (`settlementable_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skills_name_unique` (`name`),
  ADD UNIQUE KEY `skills_slug_unique` (`slug`);

--
-- Indexes for table `skill_user`
--
ALTER TABLE `skill_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skill_user_user_id_foreign` (`user_id`),
  ADD KEY `skill_user_skill_id_foreign` (`skill_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`),
  ADD KEY `tasks_template_id_foreign` (`template_id`);

--
-- Indexes for table `task_hidden`
--
ALTER TABLE `task_hidden`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_hidden_task_id_user_id_unique` (`task_id`,`user_id`),
  ADD KEY `task_hidden_user_id_foreign` (`user_id`);

--
-- Indexes for table `task_promotions`
--
ALTER TABLE `task_promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_reports`
--
ALTER TABLE `task_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `task_reports_task_id_user_id_unique` (`task_id`,`user_id`),
  ADD KEY `task_reports_user_id_foreign` (`user_id`),
  ADD KEY `task_reports_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `task_submissions`
--
ALTER TABLE `task_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_submissions_user_id_foreign` (`user_id`),
  ADD KEY `task_submissions_task_id_foreign` (`task_id`),
  ADD KEY `task_submissions_task_worker_id_foreign` (`task_worker_id`);

--
-- Indexes for table `task_templates`
--
ALTER TABLE `task_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_workers`
--
ALTER TABLE `task_workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_workers_task_id_foreign` (`task_id`),
  ADD KEY `task_workers_user_id_foreign` (`user_id`);

--
-- Indexes for table `trails`
--
ALTER TABLE `trails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trails_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_banned_by_foreign` (`banned_by`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_locations_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_verifications`
--
ALTER TABLE `user_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_verifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `withdrawals_reference_unique` (`reference`),
  ADD KEY `withdrawals_approved_by_foreign` (`approved_by`),
  ADD KEY `withdrawals_user_id_status_index` (`user_id`,`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country_prices`
--
ALTER TABLE `country_prices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `country_settings`
--
ALTER TABLE `country_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `disputes`
--
ALTER TABLE `disputes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dispute_messages`
--
ALTER TABLE `dispute_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dispute_trails`
--
ALTER TABLE `dispute_trails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exchanges`
--
ALTER TABLE `exchanges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_activities`
--
ALTER TABLE `login_activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `platform_user`
--
ALTER TABLE `platform_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settlements`
--
ALTER TABLE `settlements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT for table `skill_user`
--
ALTER TABLE `skill_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supports`
--
ALTER TABLE `supports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task_hidden`
--
ALTER TABLE `task_hidden`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_promotions`
--
ALTER TABLE `task_promotions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `task_reports`
--
ALTER TABLE `task_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_submissions`
--
ALTER TABLE `task_submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_templates`
--
ALTER TABLE `task_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task_workers`
--
ALTER TABLE `task_workers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trails`
--
ALTER TABLE `trails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_verifications`
--
ALTER TABLE `user_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disputes`
--
ALTER TABLE `disputes`
  ADD CONSTRAINT `disputes_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disputes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dispute_messages`
--
ALTER TABLE `dispute_messages`
  ADD CONSTRAINT `dispute_messages_dispute_id_foreign` FOREIGN KEY (`dispute_id`) REFERENCES `disputes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dispute_trails`
--
ALTER TABLE `dispute_trails`
  ADD CONSTRAINT `dispute_trails_dispute_id_foreign` FOREIGN KEY (`dispute_id`) REFERENCES `disputes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dispute_trails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exchanges`
--
ALTER TABLE `exchanges`
  ADD CONSTRAINT `exchanges_base_wallet_id_foreign` FOREIGN KEY (`base_wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exchanges_target_wallet_id_foreign` FOREIGN KEY (`target_wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exchanges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_activities`
--
ALTER TABLE `login_activities`
  ADD CONSTRAINT `login_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `platform_user`
--
ALTER TABLE `platform_user`
  ADD CONSTRAINT `platform_user_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `platform_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_referrer_id_foreign` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referrals_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settlements`
--
ALTER TABLE `settlements`
  ADD CONSTRAINT `settlements_task_id_foreign` FOREIGN KEY (`settlementable_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `settlements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skill_user`
--
ALTER TABLE `skill_user`
  ADD CONSTRAINT `skill_user_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `skill_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `task_templates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_hidden`
--
ALTER TABLE `task_hidden`
  ADD CONSTRAINT `task_hidden_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_hidden_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_reports`
--
ALTER TABLE `task_reports`
  ADD CONSTRAINT `task_reports_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `task_reports_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_submissions`
--
ALTER TABLE `task_submissions`
  ADD CONSTRAINT `task_submissions_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_submissions_task_worker_id_foreign` FOREIGN KEY (`task_worker_id`) REFERENCES `task_workers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_workers`
--
ALTER TABLE `task_workers`
  ADD CONSTRAINT `task_workers_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_workers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trails`
--
ALTER TABLE `trails`
  ADD CONSTRAINT `trails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_banned_by_foreign` FOREIGN KEY (`banned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_verifications`
--
ALTER TABLE `user_verifications`
  ADD CONSTRAINT `user_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
