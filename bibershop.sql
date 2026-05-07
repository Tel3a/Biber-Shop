-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 29. Mrz 2024 um 17:43
-- Server-Version: 8.0.36-0ubuntu0.22.04.1
-- PHP-Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `Bibershop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur fÃ¼r Tabelle `Produkte`
--

CREATE TABLE `Produkte` (
  `PID` int NOT NULL,
  `PName` varchar(100) NOT NULL,
  `PBeschreibung` varchar(100) NOT NULL,
  `PPreis` int NOT NULL,
  `PBestand` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten fÃ¼r Tabelle `Produkte`
--

INSERT INTO `Produkte` (`PID`, `PName`, `PBeschreibung`, `PPreis`, `PBestand` ) VALUES
(001, 'Kamm', 'Kamm für Biber', 2, 3),
(002, 'Bürste', 'Bürste für Biber', 2, 3),
(003, 'Fellpflege', 'shampoo für Biber', 2, 3),
(004, 'Zahnfeile', 'kommt noch', 2, 3),
(005, 'Regenjacke', 'um ueber Wasser trocken zu bleiben, damit das Fell nicht nass wird', 2, 3),
(006, 'Tauchbrille', 'fuer die kurz- und weitsichtigen Biber', 2, 3);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes fÃ¼r die Tabelle `Produkte`
--
ALTER TABLE `Produkte`
  ADD PRIMARY KEY (`PID`);
-- AUTO_INCREMENT fÃ¼r exportierte Tabellen
--

--
-- AUTO_INCREMENT fÃ¼r Tabelle `Produkte`
--
ALTER TABLE `Produkte`
  MODIFY `PID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

-- Tabelle für Kunden
CREATE TABLE `Kunden`(
  `KID`int NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Passwort` varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Kunden` (`KID`, `Username`, `Passwort`) VALUES
(001, `kunde`, `pwort`)

ALTER TABLE `Kunden`
  ADD PRIMARY KEY (`KID`)


-- Tabelle Bestellungen

CREATE TABLE `Bestellungen`(
  `BID` int NOT NULL,
  `KID` int NOT NULL,
  `BPreis`int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `Bestellungen`
  ADD PRIMARY KEY (`BID`)
  ADD FOREIGN KEY (`KID`)
  

-- Tabelle Warenkorb
CREATE TABLE `KWarenkorb`(
  `WID` int NOT NULL,
  `KID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
  
ALTER TABLE `KWarenkorb`
  ADD PRIMARY KEY (`WID`)
  ADD FOREIGN KEY (`KID`)

-- Tabelle Bestellen
CREATE TABLE `Warenkorbinhalt`(
  `WPosition` int NOT NULL,
  `WID` int NOT NULL,
  `PID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `Warenkorbinhalt`
  ADD PRIMARY KEY (`WPosition`)
  ADD FOREIGN KEY (`WID`)
  ADD FOREIGN KEY (`PID`)


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
