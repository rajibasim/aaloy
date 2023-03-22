-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2023 at 07:28 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aaloy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(254) NOT NULL,
  `admin_logo` varchar(254) NOT NULL,
  `admin_user_name` varchar(254) NOT NULL,
  `admin_password` varchar(254) NOT NULL,
  `phon_num` varchar(20) NOT NULL,
  `system_ip` varchar(254) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=active , 2= block',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `admin_logo`, `admin_user_name`, `admin_password`, `phon_num`, `system_ip`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, '2018-07-25 12:53:20', '2022-06-11 14:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `car_parking`
--

DROP TABLE IF EXISTS `car_parking`;
CREATE TABLE `car_parking` (
  `id` int(11) NOT NULL,
  `car_parking` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_parking`
--

INSERT INTO `car_parking` (`id`, `car_parking`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Available', 1, 0, NULL, NULL),
(2, 'Not Available', 1, 0, NULL, NULL),
(3, 'Type Cost to Available', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `country_id`, `state_id`, `city`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kolkata1', 1, 0, '2023-03-22 18:08:36', '2023-03-22 18:08:56');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'India', 1, 0, '2023-03-21 18:46:31', '2023-03-21 18:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

DROP TABLE IF EXISTS `floor`;
CREATE TABLE `floor` (
  `id` int(11) NOT NULL,
  `floor` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`id`, `floor`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '1 BHK', 1, 0, NULL, NULL),
(2, '2 BHK', 1, 0, NULL, NULL),
(3, '3 BHK', 1, 0, NULL, NULL),
(4, '4 BHK', 1, 0, NULL, NULL),
(5, '5 BHK', 1, 0, NULL, NULL),
(6, '6 BHK', 1, 0, NULL, NULL),
(7, '7 BHK', 1, 0, NULL, NULL),
(8, '8 BHK', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `furnishing_status`
--

DROP TABLE IF EXISTS `furnishing_status`;
CREATE TABLE `furnishing_status` (
  `id` int(11) NOT NULL,
  `furnishing_status` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `furnishing_status`
--

INSERT INTO `furnishing_status` (`id`, `furnishing_status`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Furnished', 1, 0, NULL, NULL),
(2, 'Semi Furnished', 1, 0, NULL, NULL),
(3, 'Non Furnish', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `country_id`, `state_id`, `city_id`, `location`, `latitude`, `longitude`, `slug`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 'test test', '123.122', '12555', 'test-test', 1, 1, '2023-03-20 18:12:48', '2023-03-20 19:08:54'),
(2, 1, 1, 1, 'New Town', '12', '12345', 'new-town', 1, 0, '2023-03-22 18:21:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positioning_status`
--

DROP TABLE IF EXISTS `positioning_status`;
CREATE TABLE `positioning_status` (
  `id` int(11) NOT NULL,
  `positioning_status` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `positioning_status`
--

INSERT INTO `positioning_status` (`id`, `positioning_status`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Ready to Move', 1, 0, NULL, NULL),
(2, 'Under Construction', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

DROP TABLE IF EXISTS `property_type`;
CREATE TABLE `property_type` (
  `id` int(11) NOT NULL,
  `property_type` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `property_type`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'House/Bungalow', 1, 0, NULL, NULL),
(2, 'Flat', 1, 0, NULL, NULL),
(3, 'Mess/PG', 1, 0, NULL, NULL),
(4, 'Shop', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active , 2 =Inactive , 3= block',
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `country_id`, `state`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Wb', 1, 0, '2023-03-21 19:15:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 => District, 2 => Main, 3 => Sub Seed',
  `districtstore_id` int(11) NOT NULL DEFAULT 0,
  `mainstore_id` int(11) NOT NULL DEFAULT 0,
  `subseedstore_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `incharge` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `designation_id` int(11) DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `password` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active, 2 =Inactive ',
  `verification_code` int(11) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 1,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_parking`
--
ALTER TABLE `car_parking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `furnishing_status`
--
ALTER TABLE `furnishing_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positioning_status`
--
ALTER TABLE `positioning_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_parking`
--
ALTER TABLE `car_parking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `furnishing_status`
--
ALTER TABLE `furnishing_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `positioning_status`
--
ALTER TABLE `positioning_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
