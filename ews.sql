-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2021 at 11:19 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ews`
--

-- --------------------------------------------------------

--
-- Table structure for table `ews_cards`
--

CREATE TABLE `ews_cards` (
  `card_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `card_num` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `cvv` int(11) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `primary_card` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ews_cards`
--

INSERT INTO `ews_cards` (`card_id`, `user_id`, `card_num`, `name`, `type`, `cvv`, `expiry_date`, `primary_card`) VALUES
(1, 'ahmadali123 ', '4101010101010543', 'AHMAD', 'Visa', 323, '2028-11-01 00:00:00', 0),
(2, 'test1234', '4323545665546344', 'MIKA', 'Visa', 423, '2028-12-01 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ews_merchant`
--

CREATE TABLE `ews_merchant` (
  `merchant_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amt_earned` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ews_merchant`
--

INSERT INTO `ews_merchant` (`merchant_id`, `name`, `type`, `account_num`, `email`, `password`, `remember_token`, `total_amt_earned`, `created_at`, `updated_at`) VALUES
('MERC0001', 'Tesco', 'Supermarket', '453453454353454', 'tesco@test.com', '$2y$10$kboHKXR63wDLK0rBX8F5Oe/Gjv4bwK1wNzZeb3CNDYZO6lZyMztEK', '', NULL, NULL, NULL),
('MERC0002', 'Pizza Gerhana', 'Restaurant', '', 'pizza@gerhana.com', '$2y$10$h5MHDEqVI3eA/odwN7NKn.sIAuMdZXRzb7Ns48iXwCJm/MwvUJNne', '', NULL, '2021-10-27 09:50:51', '2021-10-27 09:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `ews_merchant_transaction`
--

CREATE TABLE `ews_merchant_transaction` (
  `merch_trans_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `transaction_amt` double NOT NULL,
  `purchase_item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ews_parent`
--

CREATE TABLE `ews_parent` (
  `parent_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ews_parent`
--

INSERT INTO `ews_parent` (`parent_id`, `name`, `user_id`, `card_number`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('PRT0001', 'Anissa bin Ibrahim', 'ahmadali123 ', '3413131313131', 'anissa@ibrahim.com', '$2y$10$EjSVpPT4JQeELXd6KTBNFe4FKCSX7VT39TH0/sdvOSew/6diYR6a6', '1', '2021-10-27 02:02:44', '2021-10-27 02:02:44'),
('PRT0002', 'Ali bin Abu', 'amirulhaikal123', '', 'ali@abu.com', '$2y$10$WJ2ScvTV53kHXR5F6dT.R.8hSfn5u4YW79PSyS6ONU6gr4oA1.3ma', '', '2021-10-27 09:46:37', '2021-10-27 09:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `ews_pocket`
--

CREATE TABLE `ews_pocket` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pocket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget_amt` double NOT NULL,
  `total_spent_amt` double NOT NULL,
  `merchant_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ews_pocket`
--

INSERT INTO `ews_pocket` (`id`, `pocket_id`, `user_id`, `budget_amt`, `total_spent_amt`, `merchant_type`, `purchase_item_type`, `purchase_item_name`, `created_at`, `updated_at`) VALUES
(2, 'PK0001', 'ahmadali123 ', 300, 0, 'Supermarket', 'Supermarket', 'Supremeo', '2021-10-27 07:14:12', '2021-10-27 07:14:12'),
(3, 'PK0002', 'ahmadali123 ', 100, 0, 'Meals', 'Food & Beverage', 'Meals', '2021-10-27 07:16:08', '2021-10-27 07:16:08'),
(4, 'PK0003', 'ahmadali123 ', 50, 0, 'Candy', 'Food & Beverage', 'Candy Land', '2021-10-28 04:08:29', '2021-10-28 04:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `ews_transaction`
--

CREATE TABLE `ews_transaction` (
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pocket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `merchant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_amt` double NOT NULL,
  `purchase_item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ews_user`
--

CREATE TABLE `ews_user` (
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `card_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ews_user`
--

INSERT INTO `ews_user` (`user_id`, `name`, `age`, `card_number`, `email`, `email_verified_at`, `password`, `parent_code`, `remember_token`, `created_at`, `updated_at`) VALUES
('ahmadali123 ', 'Ahmad Bin Ali', 31, '', 'ahmad@binali.com', '2021-10-04 07:34:33', '$2y$10$EjSVpPT4JQeELXd6KTBNFe4FKCSX7VT39TH0/sdvOSew/6diYR6a6', 'AHMADALI', '1', '2021-10-04 07:34:33', '2021-10-29 02:46:31'),
('amirulhaikal123', 'Amirul Haikal', 31, '', 'amirul@haikal.com', NULL, '$2y$10$GrKXBaRuMJe/GIQBXn7so.8Vj78ah7KHquAEcvW/LMlWmFwz4Scuy', 'PRT-ANPU788HMP', NULL, '2021-10-27 08:50:41', '2021-10-27 08:50:41'),
('super_admin', 'Super Admin', 99, '1', 'admin@paper.com', '2021-09-29 23:29:05', '$2y$10$EjSVpPT4JQeELXd6KTBNFe4FKCSX7VT39TH0/sdvOSew/6diYR6a6', 'none', NULL, '2021-09-29 23:29:05', '2021-09-29 23:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `ews_wallet`
--

CREATE TABLE `ews_wallet` (
  `wallet_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_of_pockets` int(11) NOT NULL,
  `total_amt` double NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ews_wallet`
--

INSERT INTO `ews_wallet` (`wallet_id`, `user_id`, `num_of_pockets`, `total_amt`, `created_at`, `updated_at`) VALUES
('WALLET-ahmadali123 ', 'ahmadali123 ', 0, 374, NULL, NULL);

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2021_09_29_124239_create_user_table', 1),
(5, '2021_09_29_124327_create_wallet_table', 1),
(6, '2021_09_29_124334_create_pocket_table', 1),
(7, '2021_09_29_124634_create_parent_table', 1),
(8, '2021_09_29_124640_create_merchant_table', 1),
(9, '2021_09_29_124649_create_merchant_transaction_table', 1),
(10, '2021_09_29_124654_create_transaction_table', 1);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ews_cards`
--
ALTER TABLE `ews_cards`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ews_merchant`
--
ALTER TABLE `ews_merchant`
  ADD PRIMARY KEY (`merchant_id`);

--
-- Indexes for table `ews_merchant_transaction`
--
ALTER TABLE `ews_merchant_transaction`
  ADD PRIMARY KEY (`merch_trans_id`);

--
-- Indexes for table `ews_parent`
--
ALTER TABLE `ews_parent`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `parent_user_id` (`user_id`);

--
-- Indexes for table `ews_pocket`
--
ALTER TABLE `ews_pocket`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ews_pocket_pocket_id_unique` (`pocket_id`);

--
-- Indexes for table `ews_transaction`
--
ALTER TABLE `ews_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transaction_user_id` (`user_id`),
  ADD KEY `transaction_pocket_id` (`pocket_id`);

--
-- Indexes for table `ews_user`
--
ALTER TABLE `ews_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ews_wallet`
--
ALTER TABLE `ews_wallet`
  ADD PRIMARY KEY (`wallet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ews_cards`
--
ALTER TABLE `ews_cards`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ews_pocket`
--
ALTER TABLE `ews_pocket`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ews_parent`
--
ALTER TABLE `ews_parent`
  ADD CONSTRAINT `parent_user_id` FOREIGN KEY (`user_id`) REFERENCES `ews_user` (`user_id`);

--
-- Constraints for table `ews_transaction`
--
ALTER TABLE `ews_transaction`
  ADD CONSTRAINT `transaction_pocket_id` FOREIGN KEY (`pocket_id`) REFERENCES `ews_pocket` (`pocket_id`),
  ADD CONSTRAINT `transaction_user_id` FOREIGN KEY (`user_id`) REFERENCES `ews_user` (`user_id`);

--
-- Constraints for table `ews_wallet`
--
ALTER TABLE `ews_wallet`
  ADD CONSTRAINT `ews_wallet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ews_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
