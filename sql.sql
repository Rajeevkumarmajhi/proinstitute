-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2022 at 06:30 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_type` enum('Student','Teacher','Staff') COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_id` bigint(20) DEFAULT NULL,
  `section_id` bigint(20) DEFAULT NULL,
  `attendance` enum('Present','Absent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `date`, `user_id`, `user_type`, `grade_id`, `section_id`, `attendance`, `created_at`, `updated_at`) VALUES
(1, '2022-03-23', 2, 'Student', 1, 1, 'Present', '2022-03-23 06:29:05', '2022-03-23 06:29:05'),
(2, '2022-03-23', 3, 'Student', 1, 1, 'Absent', '2022-03-23 06:29:05', '2022-03-23 06:29:05'),
(3, '2022-03-23', 4, 'Student', 1, 1, 'Present', '2022-03-23 06:29:05', '2022-03-23 06:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sections` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subjects` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `theory_practical` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `name`, `symbol`, `sections`, `subjects`, `theory_practical`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Class One', '1', '[\"1\",\"2\"]', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', 'No', '2022-03-23 04:55:04', '2022-03-23 04:55:04', NULL),
(2, 'Class Two', '2', '[\"1\",\"2\",\"3\"]', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', 'No', '2022-03-23 05:09:47', '2022-03-23 05:09:47', NULL),
(3, 'Class Three', '3', '[\"1\",\"2\"]', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', 'No', '2022-03-23 06:24:29', '2022-03-23 06:24:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade_sections`
--

CREATE TABLE `grade_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) NOT NULL,
  `section_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_sections`
--

INSERT INTO `grade_sections` (`id`, `grade_id`, `section_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-03-23 04:55:04', '2022-03-23 04:55:04'),
(2, 1, 2, '2022-03-23 04:55:05', '2022-03-23 04:55:05'),
(3, 2, 1, '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(4, 2, 2, '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(5, 2, 3, '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(6, 3, 1, '2022-03-23 06:24:29', '2022-03-23 06:24:29'),
(7, 3, 2, '2022-03-23 06:24:29', '2022-03-23 06:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `grade_subjects`
--

CREATE TABLE `grade_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL,
  `status` enum('Active','Disabled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_subjects`
--

INSERT INTO `grade_subjects` (`id`, `class_id`, `subject_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Active', '2022-03-23 04:55:05', '2022-03-23 04:55:05'),
(2, 1, 2, 'Active', '2022-03-23 04:55:05', '2022-03-23 04:55:05'),
(3, 1, 3, 'Active', '2022-03-23 04:55:05', '2022-03-23 04:55:05'),
(4, 1, 4, 'Active', '2022-03-23 04:55:05', '2022-03-23 04:55:05'),
(5, 1, 5, 'Active', '2022-03-23 04:55:05', '2022-03-23 04:55:05'),
(6, 2, 1, 'Active', '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(7, 2, 2, 'Active', '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(8, 2, 3, 'Active', '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(9, 2, 4, 'Active', '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(10, 2, 5, 'Active', '2022-03-23 05:09:47', '2022-03-23 05:09:47'),
(11, 3, 1, 'Active', '2022-03-23 06:24:29', '2022-03-23 06:24:29'),
(12, 3, 2, 'Active', '2022-03-23 06:24:29', '2022-03-23 06:24:29'),
(13, 3, 3, 'Active', '2022-03-23 06:24:29', '2022-03-23 06:24:29'),
(14, 3, 4, 'Active', '2022-03-23 06:24:29', '2022-03-23 06:24:29'),
(15, 3, 5, 'Active', '2022-03-23 06:24:29', '2022-03-23 06:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(179, '2014_10_12_000000_create_users_table', 1),
(180, '2014_10_12_100000_create_password_resets_table', 1),
(181, '2019_08_19_000000_create_failed_jobs_table', 1),
(182, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(183, '2022_03_21_060916_create_grades_table', 1),
(184, '2022_03_21_061325_create_sections_table', 1),
(185, '2022_03_21_061826_create_notices_table', 1),
(186, '2022_03_21_062257_create_subjects_table', 1),
(187, '2022_03_21_062519_create_grade_subjects_table', 1),
(189, '2022_03_21_153015_create_grade_sections_table', 1),
(190, '2022_03_22_164235_create_terminals_table', 1),
(191, '2022_03_23_071301_create_attendances_table', 1),
(193, '2022_03_21_063243_create_results_table', 2),
(194, '2022_03_24_070118_create_site_settings_table', 3),
(195, '2022_03_24_085223_create_school_assets_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `terminal_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `section_id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL,
  `theory_practical` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `obtained_marks` bigint(20) DEFAULT NULL,
  `theory_obtained_marks` bigint(20) DEFAULT NULL,
  `practical_obtained_marks` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user_id`, `terminal_id`, `class_id`, `section_id`, `subject_id`, `theory_practical`, `obtained_marks`, `theory_obtained_marks`, `practical_obtained_marks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 1, 1, 1, 1, 'No', 50, NULL, NULL, '2022-03-23 06:11:12', '2022-03-23 06:11:12', NULL),
(2, 3, 1, 1, 1, 2, 'No', 60, NULL, NULL, '2022-03-23 06:11:12', '2022-03-23 06:11:12', NULL),
(3, 3, 1, 1, 1, 3, 'No', 70, NULL, NULL, '2022-03-23 06:11:12', '2022-03-23 06:11:12', NULL),
(4, 3, 1, 1, 1, 4, 'No', 60, NULL, NULL, '2022-03-23 06:11:12', '2022-03-23 06:11:12', NULL),
(5, 3, 1, 1, 1, 5, 'No', 80, NULL, NULL, '2022-03-23 06:11:12', '2022-03-23 06:11:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_assets`
--

CREATE TABLE `school_assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_assets`
--

INSERT INTO `school_assets` (`id`, `name`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'Basketball', 6, '2022-03-24 03:54:50', '2022-03-24 05:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'A', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(2, 'B', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(3, 'C', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(4, 'D', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(5, 'E', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `school_name`, `phone`, `logo`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Pro School', '9800930444', '/storage/uploads/logo/1648111463_hhpng.png', 'Biratnagar, Kanchanbari', '2022-03-24 01:42:40', '2022-03-24 02:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theory_practical` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_marks` int(11) DEFAULT NULL,
  `pass_marks` int(11) DEFAULT NULL,
  `theory_full_marks` int(11) DEFAULT NULL,
  `practical_full_marks` int(11) DEFAULT NULL,
  `theory_pass_marks` int(11) DEFAULT NULL,
  `practical_pass_marks` int(11) DEFAULT NULL,
  `optional` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `theory_practical`, `full_marks`, `pass_marks`, `theory_full_marks`, `practical_full_marks`, `theory_pass_marks`, `practical_pass_marks`, `optional`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mathmatics', 'M100', 'No', 100, 40, NULL, NULL, NULL, NULL, 'No', '2022-03-23 04:46:37', '2022-03-23 04:46:37', NULL),
(2, 'Science', 'SC100', 'No', 100, 40, NULL, NULL, NULL, NULL, 'No', '2022-03-23 04:47:03', '2022-03-23 04:47:03', NULL),
(3, 'English', 'EN100', 'No', 100, 40, NULL, NULL, NULL, NULL, 'No', '2022-03-23 04:47:23', '2022-03-23 04:47:23', NULL),
(4, 'Drawing', 'DR100', 'No', 100, 40, NULL, NULL, NULL, NULL, 'No', '2022-03-23 04:47:45', '2022-03-23 04:47:45', NULL),
(5, 'Nepali', 'NP100', 'No', 100, 40, NULL, NULL, NULL, NULL, 'No', '2022-03-23 04:53:07', '2022-03-23 04:53:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terminals`
--

CREATE TABLE `terminals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terminals`
--

INSERT INTO `terminals` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'First Terminal Examination', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(2, 'Second Terminal Examination', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(3, 'Thrid Terminal Examination', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(4, 'Final Terminal Examination', '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','Teacher','Student') COLLATE utf8mb4_unicode_ci NOT NULL,
  `roll_no` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','No Data') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No Data',
  `dob` date DEFAULT NULL,
  `class_id` bigint(20) DEFAULT NULL,
  `section_id` bigint(20) DEFAULT NULL,
  `optional_subjects` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Disabled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `roll_no`, `gender`, `dob`, `class_id`, `section_id`, `optional_subjects`, `email`, `email_verified_at`, `password`, `father_name`, `mother_name`, `address`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'Admin', NULL, 'No Data', NULL, NULL, NULL, NULL, 'admin@gmail.com', NULL, '$2y$10$aSAVBSQmw21Pt3gxazDGz.FY1862m3ew6Le0kj8O1D.cHYgeGWjiq', NULL, NULL, NULL, NULL, 'Active', NULL, '2022-03-23 04:45:19', '2022-03-23 04:45:19', NULL),
(2, 'Liam Weissnat', 'Student', 1, 'Female', '2023-02-01', 1, 1, NULL, NULL, NULL, '$2y$10$KU2JQIYb2AAq7W9o6MwJEe3aLQZqKD8NCgSSY1y3oJnRLKoVeXruK', 'Kole.Schiller36', 'Columbus.Howell61', '55123 Gerhold Isle', '835-089-3120', 'Active', NULL, '2022-03-23 05:21:49', '2022-03-23 05:21:49', NULL),
(3, 'Richmond Kuphal', 'Student', 2, 'Female', '2022-07-20', 1, 1, NULL, NULL, NULL, '$2y$10$JSd8j2aHf6r37z8/y3gPVO70LuGO1jAndnzKrDUqyQMB3JucH6dWC', 'Gracie_Abernathy', 'Davonte95', '95034 Zander Streets', '017-687-2664', 'Active', NULL, '2022-03-23 05:22:10', '2022-03-23 05:22:10', NULL),
(4, 'Loren Altenwerth', 'Student', 3, 'Male', '2022-10-05', 1, 1, NULL, NULL, NULL, '$2y$10$fAFc14iqW01rOdgaspHUyuMUVib1VpwP3kl/EFw3tOSQSxOdEhRAC', 'Raquel51', 'Enid_Brown', '4948 Albert Vista', '740-399-9445', 'Active', NULL, '2022-03-23 05:22:32', '2022-03-23 05:22:32', NULL),
(5, 'Shad Willms', 'Student', 1, 'Male', '2022-03-03', 3, 1, NULL, NULL, NULL, '$2y$10$8s.BBGjf37yKLOwsQ4e3kuHm6O5lGcRIdNzkeS8sphGwG9l1uIA8O', 'Lea.Beer59', 'Meghan13', '48024 Hessel Cove', '663-111-8047', 'Active', NULL, '2022-03-23 06:25:04', '2022-03-23 06:25:04', NULL),
(6, 'Helene Lueilwitz', 'Teacher', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$dDsSo/Hpts8FXiRzdVf4WeTjksrPCkORILedXyruT/yVXtc5ngQdm', NULL, NULL, '924 Jerde Coves', '100-122-4614', 'Active', NULL, '2022-03-23 06:25:43', '2022-03-23 06:25:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_sections`
--
ALTER TABLE `grade_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_subjects`
--
ALTER TABLE `grade_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_assets`
--
ALTER TABLE `school_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terminals`
--
ALTER TABLE `terminals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grade_sections`
--
ALTER TABLE `grade_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grade_subjects`
--
ALTER TABLE `grade_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `school_assets`
--
ALTER TABLE `school_assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `terminals`
--
ALTER TABLE `terminals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
