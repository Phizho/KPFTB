-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2021 at 09:14 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kpftb`
--

-- --------------------------------------------------------

--
-- Table structure for table `lampirans`
--

CREATE TABLE `lampirans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_surat` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lampiran` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_lampiran` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(3, '2021_02_19_073921_create_surats_table', 1),
(4, '2021_02_19_075829_create_lampirans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surats`
--

CREATE TABLE `surats` (
  `nomor_surat` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_surat` enum('Keluar Dekan','Keluar Wakil Dekan','Keluar Kaprodi Magister Bioteknologi','Kerja Sama','Keputusan Dekan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lampirans`
--
ALTER TABLE `lampirans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lampirans_nomor_surat_index` (`nomor_surat`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surats`
--
ALTER TABLE `surats`
  ADD PRIMARY KEY (`nomor_surat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lampirans`
--
ALTER TABLE `lampirans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lampirans`
--
ALTER TABLE `lampirans`
  ADD CONSTRAINT `lampirans_nomor_surat_foreign` FOREIGN KEY (`nomor_surat`) REFERENCES `surats` (`nomor_surat`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
