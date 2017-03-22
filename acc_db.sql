-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 23. Mrz 2017 um 00:52
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `acc_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_acc_accounts`
--

CREATE TABLE IF NOT EXISTS `tbl_acc_accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `balance` int(11) NOT NULL,
  `acc_parent` int(11) NOT NULL,
  `book_parent` varchar(15) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_acc_accounts`
--

INSERT INTO `tbl_acc_accounts` (`id`, `name`, `balance`, `acc_parent`, `book_parent`, `status`) VALUES
(1101, 'Caja y Banco', 0, 1100, 'BG', 1),
(1102, 'Cuentas por Cobrar', 0, 1100, 'BG', 1),
(110101, 'Caja General', 0, 1101, 'BG', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_acc_det_daily`
--

CREATE TABLE IF NOT EXISTS `tbl_acc_det_daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_pda` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit` decimal(10,0) NOT NULL,
  `credit` decimal(10,0) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `tbl_acc_det_daily`
--

INSERT INTO `tbl_acc_det_daily` (`id`, `num_pda`, `account_id`, `debit`, `credit`, `status`) VALUES
(1, 0, 1101, 100, 0, 1),
(2, 0, 1102, 0, 100, 1),
(3, 5, 1101, 100, 0, 1),
(4, 5, 1102, 0, 100, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_acc_head_daily`
--

CREATE TABLE IF NOT EXISTS `tbl_acc_head_daily` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `sum_debit` decimal(10,0) NOT NULL,
  `sum_credit` decimal(10,0) NOT NULL,
  `concept` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `acc_period` varchar(50) NOT NULL,
  `user_create` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_acc_head_daily`
--

INSERT INTO `tbl_acc_head_daily` (`id`, `date`, `sum_debit`, `sum_credit`, `concept`, `status`, `acc_period`, `user_create`) VALUES
(1, '2017-03-22', 1400, 1400, 'por cobro de mensualidad', 1, 'NA', 'NA'),
(2, '2017-03-22', 1500, 1500, 'Depositos varios', 1, 'NA', 'NA'),
(3, '2017-03-22', 100, 100, 'asldkfja sldfksaj df', 1, 'NA', 'NA'),
(4, '2017-03-22', 100, 100, 'asldkfja sldfksaj df', 1, 'NA', 'NA'),
(5, '2017-03-22', 100, 100, 'asdfsadf asdf asd', 1, 'NA', 'NA');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_correlativos`
--

CREATE TABLE IF NOT EXISTS `tbl_correlativos` (
  `id` varchar(15) NOT NULL,
  `num` int(11) NOT NULL,
  `prefix` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbl_correlativos`
--

INSERT INTO `tbl_correlativos` (`id`, `num`, `prefix`, `status`) VALUES
('PDA', 4, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
