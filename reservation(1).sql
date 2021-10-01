-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 30. sep 2021 ob 15.56
-- Različica strežnika: 10.4.17-MariaDB
-- Različica PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `reservation`
--

-- --------------------------------------------------------

--
-- Struktura tabele `floors`
--

CREATE TABLE `floors` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `description` text COLLATE utf8_slovenian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Odloži podatke za tabelo `floors`
--

INSERT INTO `floors` (`id`, `number`, `description`) VALUES
(1, 1, 'First floor of building.'),
(2, 2, 'Second floor of building.'),
(3, 3, 'Third floor of building.');

-- --------------------------------------------------------

--
-- Struktura tabele `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_slovenian_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `room_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Odloži podatke za tabelo `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `date`, `end_time`, `room_id`, `user_id`) VALUES
(87, 'Yves', '2021-10-01 08:00:00', '2021-10-01 11:00:00', 1, 24),
(89, 'Yves', '2021-10-04 09:00:00', '2021-10-04 12:00:00', 6, 24),
(90, 'Å½ak', '2021-09-30 17:00:00', '2021-09-30 18:00:00', 1, 2),
(96, 'Piki', '2021-10-11 08:00:00', '2021-10-11 09:00:00', 3, 5),
(98, 'dela', '2021-10-01 17:00:00', '2021-10-01 18:00:00', 1, 5),
(99, 'dela', '2021-10-04 17:00:00', '2021-10-04 18:00:00', 1, 5),
(102, 'Yves', '2021-10-05 15:00:00', '2021-10-05 16:00:00', 6, 24),
(103, 'Yves', '2021-10-05 17:00:00', '2021-10-05 18:00:00', 3, 24);

-- --------------------------------------------------------

--
-- Struktura tabele `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `description` text COLLATE utf8_slovenian_ci DEFAULT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `slika` text COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Odloži podatke za tabelo `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`, `floor_id`, `slika`) VALUES
(1, 'Meeting room', 'test', 1, 'pictures/room_1.jpg'),
(3, 'IT room', NULL, 2, 'pictures/it_room.jpg'),
(5, 'Kitchen', NULL, 3, 'pictures/kitchen.jpg'),
(6, 'Balcony', 'With perfecct view.', 3, 'pictures/balcony.jpg');

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(250) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_slovenian_ci NOT NULL,
  `admin` int(11) DEFAULT NULL,
  `username` varchar(250) COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Odloži podatke za tabelo `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `admin`, `username`) VALUES
(2, 'lubej.zak@gmail.com', '$2y$10$Ea9Wcu3.eVaTiyf4/KZSxeMkMAycikl1r.cwr3NE/lyjrbVHR1GTW', 0, 'Zak'),
(3, 'jadn@fja.sds', '$2y$10$jI0qoyemFY.E1FkWZg8lU.vcHp2YUcGGRvqyei7SW8dltERUKTWka', 0, 'Test'),
(4, 'joan.fa@gam.ad', '$2y$10$LnLoFX.FwN46OUKwG8cpOOVgmNifyvPuAGhMLkbT/Vjuhsc3hOqj2', 0, 'Joan'),
(5, 'piki.je@gmail.com', '$2y$10$351VsfZpkx8okImaXw.jteYOdrfRjGORj.htrpTkQVsHcKgEp9Ehe', 0, 'Piki'),
(6, 'admin.admin@gm.com', '$2y$10$X8p0wPw30tz79i0QbjcMjOAB/kOJosjoljR2OxXWCbskaYVLtCE3m', 1, 'Admin'),
(10, 'sajtl.jan@gmail.com', '$2y$10$RX2/2SlUe8rb2laEp9Gs.OWh5LM2FMD958h.hosFH/R789Lf8vbt2', 0, 'Jan sajtl '),
(18, 'danaj.cebular@gmail.com', '$2y$10$V8H2NgKzds8qx3dfHmldJ.dS.H4jLzEelPs0OS8WWDqUTDufBiOdu', 0, 'Danaj'),
(20, 'test.g@gma.d', '$2y$10$HvPrBnaaDbBcHVfle2Ket.DZRxCmYpKiSj4Uwf0/4HQwqe8HsyEXG', 0, 'Test'),
(21, 'joe.doe@gmail.com', '$2y$10$XjncqohxLOKiFNTeySmQS.Yz6OAk7FK/qyCi5XMJnFARcDeLQfjtK', 0, 'Joe'),
(22, 'urh.rosar@gmail.com', '$2y$10$pXXlbT2jhDG6wR5Z5EuL7emREcihgjJ0OP/EJMyqDpZkrRZJBpZLO', 0, 'Urh'),
(23, 'urh.rosar@gmail.com', '$2y$10$UjFuK55ELb/N.PO3UqPDauZyNnT6dm1EGBRNyBNqTbMHokK75niG.', 0, 'urh'),
(24, 'yves.db@gmail.com', '$2y$10$d6DYOwAGSJjRoCywGxGZV.fAz1uNCPewHC0DMTO55C5uJ0I2IjAD6', 0, 'Yves');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_Relationship2` (`room_id`),
  ADD KEY `IX_Relationship3` (`user_id`);

--
-- Indeksi tabele `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_Relationship1` (`floor_id`);

--
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `floors`
--
ALTER TABLE `floors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT tabele `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT tabele `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `Relationship2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `Relationship3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omejitve za tabelo `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `Relationship1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
