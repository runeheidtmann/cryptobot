-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Vært: mysql88.unoeuro.com
-- Genereringstid: 12. 01 2019 kl. 14:28:36
-- Serverversion: 5.7.24-26-log
-- PHP-version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cryptobot`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `longPermTable`
--

CREATE TABLE `longPermTable` (
  `permission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `longTrades`
--

CREATE TABLE `longTrades` (
  `id` int(11) NOT NULL,
  `time_buy` int(11) NOT NULL,
  `time_sell` int(11) NOT NULL,
  `price_buy` float(11,4) NOT NULL,
  `price_sell` float(11,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `tickerPrices`
--

CREATE TABLE `tickerPrices` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `ticker_price` decimal(11,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `longTrades`
--
ALTER TABLE `longTrades`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `tickerPrices`
--
ALTER TABLE `tickerPrices`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `longTrades`
--
ALTER TABLE `longTrades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `tickerPrices`
--
ALTER TABLE `tickerPrices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
