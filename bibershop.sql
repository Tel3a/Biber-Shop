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

CREATE TABLE IF NOT EXISTS `Produkte` (
  `PID` int NOT NULL,
  `PName` varchar(100) NOT NULL,
  `PBeschreibung` varchar(500) NOT NULL,
  `PPreis` int NOT NULL,
  `PBestand` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten fÃ¼r Tabelle `Produkte`
--

INSERT INTO `Produkte` (`PID`, `PName`, `PBeschreibung`, `PPreis`, `PBestand` ) VALUES
(001, ' Kamm-o-Biber™ – Für den perfekten Nage-Scheitel', 'Verabschiede dich von chaotischem Pelz und begrüße den „Ich hab mein Leben im Griff“-Look. Der Kamm-o-Biber™ gleitet sanft durch jedes noch so rebellische Fell und sorgt für aerodynamische Eleganz beim Schwimmen und Nagen. Bonus: erzeugt beim Durchziehen ein befriedigendes knrkrk-Geräusch.', 2, 3),
(002, 'BürstiBiber Deluxe – Flausch auf Industrieniveau', 'Diese Bürste bringt selbst den struppigsten Dammarbeiter zurück in die High-Society des Bibertums. Mit extra robusten Borsten aus… nun ja, wir fragen besser nicht woher. Ideal für Vorher-Nachher-Verwandlungen und spontane Wald-Fotoshootings. Achtung: Kann zu übermäßigem Selbstbewusstsein führen.', 2, 3),
(003, 'FellFix Pro™ – Glanz, der blendet', 'Ein Tropfen FellFix Pro™ und dein Pelz reflektiert mehr Licht als ein frisch polierter See bei Sonnenaufgang. Pflegt, schützt und macht dich zum Gesprächsthema am Flussufer. Enthält die geheime Formel „AquaFlausch+“. Niemand weiß, was drin ist – aber alle sind beeindruckt.', 2, 3),
(004, 'ZahnFeil 3000 – Für den perfekten Biss', 'Nagen ist kein Hobby. Es ist eine Kunst. Mit der ZahnFeil 3000 bringst du deine Schneidezähne auf Präzisionsniveau. Für saubere Schnitte, stilvolles Knabbern und maximale Einschüchterung von rivalisierenden Bibern. Inklusive „Feil wie ein Profi“-Anleitung (besteht hauptsächlich aus: mehr nagen).', 2, 3),
(005, 'Regenjacke Hydrobeaver™ - Weil… mehr Regen geht immer', '„Aber ich bin doch schon nass!“ – Falsch gedacht. Mit der Hydrobeaver™ bleibst du nicht nur trocken, sondern siehst dabei auch noch aus wie ein trendbewusster Wasseringenieur. Winddicht, wasserdicht und dammfest. Perfekt für dramatische Spaziergänge im Dauerregen.', 2, 3),
(006, 'OptiBiber Vision™ – Taucherbrillen für jede Sehschwäche', 'Egal ob du Kurzsicht-Biber bist („Ist das ein Baum oder ein Stock?“) oder Weitsicht-Profi („Ich sehe den Baum schon, bevor er wächst“): OptiBiber Vision™ liefert kristallklare Sicht unter Wasser. Mit Anti-Beschlag-Beschichtung und stylischem „Ich weiß genau, was ich nage“-Look.', 2, 3),
(007, 'NeoNage Suit™ – Der Neoprenanzug für echte Profis', 'Maximale Beweglichkeit, minimale Kälte. Der NeoNage Suit™ hält dich warm, während du elegant durch Seen gleitest und nebenbei Infrastrukturprojekte startest. Sitzt wie eine zweite Haut – nur flauschiger. Für Biber, die auch im Winter keine Pause kennen.', 2, 3),
(008, 'HolzSnack Premium™ – Gourmet für Zwischendurch', 'Nicht jedes Holz ist gleich. HolzSnack Premium™ bietet sorgfältig ausgewählte Hölzer mit feinen Geschmacksnoten von „frisch gefallen“ bis „leicht morsch, aber interessant“. Der perfekte Snack für anspruchsvolle Nager mit Sinn für Qualität.', 2, 3),
(009, 'DammPlaner Pro™ – Bauleitung leicht gemacht', 'Warum improvisieren, wenn man professionell planen kann? DammPlaner Pro™ hilft dir, Strömungen zu analysieren, Holz optimal zu platzieren und deinen Damm architektonisch auf das nächste Level zu heben. Enthält keine Technik – nur extrem gutes Bauchgefühl.', 2, 3),
(010, 'SchwanzPolish Ultra™ – Glanzleistung am Heck', 'SchwanzPolish Ultra™ – Glanzleistung am Heck', 2, 3),
(101, 'Kuschelbiber - Premium-Wärmeservice mit Fellgaratie', 'Wenn dein Tag kälter war als ein Schwarzwaldsee im Februar, kommt der Kuschel-Biber™ ins Spiel. Mit zertifizierter Flauschigkeit (DIN-Norm: sehr weich) und eingebautem Knabber-Charme sorgt er für emotionale Stabilisierung innerhalb von 3–5 Umarmungen. Optional: beruhigendes Nagen an Tischbeinen für ASMR-Fans. Nebenwirkungen können spontane Glücksgefühle und irrationaler Holzbedarf sein.', 2, 3),
(102, 'Babysitterbiber: Kinderbetreuung mit Nagekompetenz', 'Warum einen gewöhnlichen Babysitter buchen, wenn du einen hochmotivierten Biber haben kannst? BabyBiber™ liest Gute-Nacht-Geschichten (hauptsächlich über Dämme), baut in Rekordzeit Spielburgen aus allem, was nicht niet- und nagelfest ist, und sorgt dafür, dass dein Kind nie wieder Angst vor Mathe hat (weil alles zu Holzprojekten wird). Achtung: Möbel können emotional gebunden werden.', 2, 3),
(103, 'Baubiber: wir machen dicht. Wirklich dicht', 'Du brauchst ein Haus? Wir liefern ein ökologisch optimiertes Meisterwerk aus Holz, Schlamm und unerschütterlicher Arbeitsmoral. BauBiber arbeitet rund um die Uhr, kennt keine Bauverzögerungen und akzeptiert als Bezahlung neben Geld auch respektvolles Nicken. USP: Unsere Häuser sind so stabil, dass selbst Nachbarn neidisch nagen würden.', 2, 3),
(104, 'Stalkerbiber: Diskret, flauschig, leicht auffällig', 'Du willst wissen, was dein Nachbar treibt? SpionBiber™ observiert mit maximaler Hingabe und minimaler Tarnung. Dank natürlicher Tarnfarbe „Holzbraun“ fügt er sich perfekt in jede Gartenlandschaft ein. Berichtserstattung erfolgt durch strategisch platzierte Nagespuren und bedeutungsschwere Blicke. Absolute Diskretion – außer wenn jemand Karotten dabei hat.', 2, 3),
(105, ' Don Biberone – Problemlösung auf… kreative Weise', 'Wenn jemand „aus Versehen“ ständig deine Bäume fällt oder dein WLAN klaut, regelt Don Biberone das auf seine ganz eigene, völlig überzeichnete Cartoon-Art. Statt echter Gewalt gibt’s dramatische Showdowns mit intensiven Blickduellen, symbolischem Holzfällen und passiv-aggressiv platzierten Dämmen im Vorgarten. Ergebnis: Respekt, Verwirrung und ein leicht feuchter Rasen.', 2, 3);

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
CREATE TABLE IF NOT EXISTS `Kunden`(
  `KID`int NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Passwort` varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Kunden` (`KID`, `Username`, `Passwort`) VALUES
(001, `kunde`, `pwort`);

ALTER TABLE `Kunden`
  ADD PRIMARY KEY (`KID`);

ALTER TABLE `Kunden`
  MODIFY `KID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

-- Daten für Tabelle `Produkte`

INSERT INTO `kunden`(`KID`, `Username`, `Email`, `Passwort`) VALUES ('0','hallo','hallo@abc.de','hallihallo');
--


-- Tabelle Bestellungen

CREATE TABLE IF NOT EXISTS `Bestellungen`(
  `BID` int NOT NULL,
  `KID` int NOT NULL,
  `BPreis`int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `Bestellungen`
  ADD PRIMARY KEY (`BID`),
  ADD FOREIGN KEY (`KID`);
 
ALTER TABLE `Bestellungen`
  MODIFY `BID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

-- Tabelle Warenkorb
CREATE TABLE IF NOT EXISTS `KWarenkorb`(
  `WID` int NOT NULL,
  `KID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
  
ALTER TABLE `KWarenkorb`
  ADD PRIMARY KEY (`WID`),
  ADD FOREIGN KEY (`KID`);

ALTER TABLE `KWarenkorb`
  MODIFY `WID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
-- Tabelle Bestellen
CREATE TABLE IF NOT EXISTS `Warenkorbinhalt`(
  `WPosition` int NOT NULL,
  `WID` int NOT NULL,
  `PID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `Warenkorbinhalt`
  ADD PRIMARY KEY (`WPosition`),
  ADD FOREIGN KEY (`WID`),
  ADD FOREIGN KEY (`PID`);

ALTER TABLE `Warenkorbinhalt`
  MODIFY `WPosition` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
