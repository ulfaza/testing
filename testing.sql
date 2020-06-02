-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jun 2020 pada 07.47
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testingiso`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `instansi`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin1\r\n', '', '', 'admin1@gmail.com', '', 'S81pmHbZeGYUvZBTSTxZAJnw7so8DnRyJWidJ2O7wDR9lpuhSkUbokvkEFE6', NULL, NULL),
(2, 'admin2', '', '', 'admin2@gmail.com', '$2y$10$dMg7Zbai6scH6F54JZ9VnOpiiNK51bo2YnN/PrlyuWlaUroOEWXWa', 'tKNkzSfitV5pjRqF9YcIrLUYOiAKLRdKxyndbXyXoViUGSDGTit7nGw0hMjJ', '2020-06-01 21:37:48', '2020-06-01 21:37:48'),
(3, 'admin3', '', '', 'admin3@gmail.com', '$2y$10$EDS4AUZbRjwtzsruE38QZ.XfsLVOkos2pHawiNt//m0qca18VgHFi', 'N5MzPTlf0pq4vdKfjpP9EBZG1LXNwokzdluiGPUQomD5umtA1TfCy06Exgy8', '2020-06-01 21:41:23', '2020-06-01 21:41:23'),
(4, 'admin4', '', '', 'admin4@gmail.com', '$2y$10$.oZENjbmN0BnmhSQ1n75OuNizaHnPkqg5CQyWHJ96jD1VFshXuEwa', 'd6fzOEb3fJakgtDyrQHcy2Q8w7zsV6SRiun7sWvVwldWTNl4Sg4NaKrapW3m', '2020-06-01 21:47:39', '2020-06-01 21:47:39'),
(5, 'admin5', '', '', 'admin5@gmail.com', '$2y$10$sljzYraduOYxS/vNq4BKHOHVsUiUKTimYstLycmEN1YNwm.xcOTXW', 'xzpHuY5bDqKRBFT3fWcQhtas7TLsSduJEAJcowVyYbmzmRYifkB3sdiOxbDT', '2020-06-01 21:50:05', '2020-06-01 21:50:05'),
(6, 'admin6', 'admin', 'ITS', 'admin6@gmail.com', '$2y$10$vOVjuY9hW05x7i8/SWnqy.ayRpztbeGE1zBeDkKMvUE9lVi6K2.Gq', 'V5WlBUrcabxTa6e1aGcwZJnpTvf8EYx8NhpoFGSIyu5g0mWzzEmktJTSc6bZ', '2020-06-01 21:52:17', '2020-06-01 21:52:17'),
(7, 'zzz', 'softwaretester', 'ITS', 'zzz@gmail.com', '$2y$10$MMh1qmoY3ByQtt6SFexYOelawB68DD5oI2Ky.luGFitLLZRsvBF8W', 'Uq7g4boO7fPumiljyfFswL1leqoypFDnGQ4wMxo8980I2AuABtylbEpKhgoA', '2020-06-01 22:40:45', '2020-06-01 22:40:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
