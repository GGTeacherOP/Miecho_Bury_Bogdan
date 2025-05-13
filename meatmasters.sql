-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 11, 2025 at 04:01 PM
-- Generation Time: Maj 13, 2025 at 07:07 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meatmasters`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawy`
--

CREATE TABLE `dostawy` (
  `id` int(11) NOT NULL,
  `data_dostawy` datetime NOT NULL,
  `dostawca` varchar(100) NOT NULL,
  `numer_faktury` varchar(50) NOT NULL,
  `status` enum('oczekiwana','zrealizowana','anulowana') NOT NULL DEFAULT 'oczekiwana',
  `pracownik_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dostawy`
--

INSERT INTO `dostawy` (`id`, `data_dostawy`, `dostawca`, `numer_faktury`, `status`, `pracownik_id`) VALUES
(1, '2025-05-10 08:00:00', 'Mięsny Raj', 'FV/2025/05/001', 'zrealizowana', 10),
(2, '2025-05-12 09:30:00', 'Drób Polski', 'FV/2025/05/002', 'zrealizowana', 11),
(3, '2025-05-15 11:15:00', 'Wołowina Premium', 'FV/2025/05/015', 'oczekiwana', NULL),
(4, '2025-05-18 07:45:00', 'Wieprzowina Lux', 'FV/2025/05/028', 'zrealizowana', 12);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawy_towary`
--

CREATE TABLE `dostawy_towary` (
  `dostawa_id` int(11) NOT NULL,
  `towar_id` int(11) NOT NULL,
  `ilosc_kg` decimal(10,2) NOT NULL,
  `cena_zakupu_zl_kg` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dostawy_towary`
--

INSERT INTO `dostawy_towary` (`dostawa_id`, `towar_id`, `ilosc_kg`, `cena_zakupu_zl_kg`) VALUES
(1, 1, 50.00, 75.00),
(1, 2, 100.00, 22.50),
(1, 4, 30.00, 28.00),
(1, 7, 80.00, 24.00),
(2, 5, 120.00, 18.50),
(2, 8, 90.00, 14.00),
(3, 1, 40.00, 82.00),
(3, 4, 25.00, 35.00),
(4, 2, 60.00, 25.00),
(4, 7, 70.00, 26.50);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `typ_konta` enum('klient indywidualny','firma/hurtownia','restauracja') NOT NULL DEFAULT 'klient indywidualny',
  `nazwa_firmy` varchar(100) DEFAULT NULL,
  `nip` varchar(15) DEFAULT NULL,
  `data_rejestracji` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`id`, `imie`, `nazwisko`, `email`, `haslo`, `telefon`, `typ_konta`, `nazwa_firmy`, `nip`, `data_rejestracji`) VALUES
(1, 'Jan', 'Kowalski', 'jan.kowalski@email.com', 'kowalJ1!', '123456789', 'klient indywidualny', NULL, NULL, '2023-01-14 23:00:00'),
(2, 'Anna', 'Nowak', 'anna.nowak@email.com', 'NowakA2@', '987654321', 'klient indywidualny', NULL, NULL, '2023-02-19 23:00:00'),
(3, 'Piotr', 'Wiśniewski', 'piotr.w@email.com', 'WisniaP3#', '555111222', 'klient indywidualny', NULL, NULL, '2023-03-09 23:00:00'),
(4, 'Marek', 'Zieliński', 'biuro@zielpol.pl', 'ZielM4$', '601234567', 'firma/hurtownia', 'Hurtownia Zielpol', '1234567890', '2023-04-04 22:00:00'),
(5, 'Katarzyna', 'Wójcik', 'office@elektroplus.com', 'Elektro5%', '605987654', 'firma/hurtownia', 'ElektroPlus Sp. z o.o.', '9876543210', '2023-05-11 22:00:00'),
(6, 'Tomasz', 'Szymański', 'zamowienia@smak.com.pl', 'Smak6^', '607456789', 'firma/hurtownia', 'Dystrybutor Smak', '1122334455', '2023-06-17 22:00:00'),
(7, 'Agnieszka', 'Dąbrowska', 'rezerwacje@podkogutem.pl', 'Kogut7&', '508123456', 'restauracja', 'Restauracja Pod Kogutem', '5566778899', '2023-07-21 22:00:00'),
(8, 'Robert', 'Kozłowski', 'robert@bistro.pl', 'Bistro8*', '509876543', 'restauracja', 'Bistro U Roberta', '9988776655', '2023-08-14 22:00:00'),
(9, 'Magdalena', 'Jankowska', 'kontakt@slodkikacik.pl', 'Kawi9(', '501234567', 'restauracja', 'Słodki Kącik', '4433221100', '2023-08-31 22:00:00'),
(10, 'Adam', 'Mazur', 'adam.m@email.com', 'Mazur10)', '609876543', 'klient indywidualny', NULL, NULL, '2023-10-09 22:00:00'),
(11, 'Ewa', 'Kwiatkowska', 'catering@smacznaewa.pl', 'Ewa11_', '604567890', 'firma/hurtownia', 'Smaczna Ewa Catering', '6677889900', '2023-11-24 23:00:00'),
(12, 'Grzegorz', 'Lewandowski', 'pizza@bellaitalia.pl', 'Lewy12=', '603987654', 'restauracja', 'Bella Italia Pizzeria', '5544332211', '2023-12-04 23:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `stanowisko` varchar(50) NOT NULL,
  `data_zatrudnienia` date NOT NULL,
  `wynagrodzenie` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `imie`, `nazwisko`, `email`, `telefon`, `stanowisko`, `data_zatrudnienia`, `wynagrodzenie`) VALUES
(1, 'Jan', 'Kowalski', 'j.kowalski@mięsna.pl', '501234567', 'Kierownik', '2020-03-15', 8500.00),
(2, 'Anna', 'Nowak', 'a.nowak@mięsna.pl', '502345678', 'Kierownik', '2019-05-12', 8700.00),
(3, 'Piotr', 'Wiśniewski', 'p.wisniewski@mięsna.pl', '503456789', 'Programista', '2021-06-20', 9500.00),
(4, 'Katarzyna', 'Dąbrowska', 'k.dabrowska@mięsna.pl', '504567890', 'Programista', '2022-01-10', 9200.00),
(5, 'Marek', 'Lewandowski', 'm.lewandowski@mięsna.pl', '505678901', 'Pracownik linii pakowania', '2021-07-15', 4200.00),
(6, 'Agnieszka', 'Wójcik', 'a.wojcik@mięsna.pl', '506789012', 'Pracownik linii pakowania', '2022-04-01', 4100.00),
(7, 'Tomasz', 'Kamiński', 't.kaminski@mięsna.pl', '507890123', 'Pracownik linii pakowania', '2020-11-18', 4300.00),
(8, 'Magdalena', 'Zając', 'm.zajac@mięsna.pl', '508901234', 'Pracownik linii pakowania', '2021-05-22', 4250.00),
(9, 'Grzegorz', 'Szymański', 'g.szymanski@mięsna.pl', '509012345', 'Pracownik linii pakowania', '2022-03-01', 4150.00),
(10, 'Joanna', 'Woźniak', 'j.wozniak@mięsna.pl', '511234567', 'Magazynier', '2020-08-10', 4500.00),
(11, 'Robert', 'Kozłowski', 'r.kozlowski@mięsna.pl', '512345678', 'Magazynier', '2021-09-30', 4600.00),
(12, 'Ewa', 'Jankowska', 'e.jankowska@mięsna.pl', '513456789', 'Magazynier', '2022-07-01', 4550.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reklamacje`
--

CREATE TABLE `reklamacje` (
  `id` int(11) NOT NULL,
  `zamowienie_id` int(11) NOT NULL,
  `klient_id` int(11) NOT NULL,
  `pracownik_id` int(11) DEFAULT NULL,
  `data_zgloszenia` datetime NOT NULL,
  `tresc` text NOT NULL,
  `status` enum('otwarta','w_trakcie','rozpatrzona','odrzucona') NOT NULL DEFAULT 'otwarta',
  `decyzja` text DEFAULT NULL,
  `data_rozpatrzenia` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reklamacje`
--

INSERT INTO `reklamacje` (`id`, `zamowienie_id`, `klient_id`, `pracownik_id`, `data_zgloszenia`, `tresc`, `status`, `decyzja`, `data_rozpatrzenia`) VALUES
(1, 1, 1, 5, '2025-05-15 14:30:00', 'Otrzymałem rostbef o nieprzyjemnym zapachu, podejrzewam, że był nieświeży', 'rozpatrzona', 'Przyznano reklamację - wysłano nową partię produktu', '2025-05-16 10:00:00'),
(2, 3, 7, NULL, '2025-05-16 09:45:00', 'W zamówieniu brakuje 2kg mięsa do kebabu, a opakowanie było naruszone', 'w_trakcie', NULL, NULL),
(3, 5, 12, 2, '2025-05-17 16:20:00', 'Schab był zbyt tłusty jak na deklarowaną jakość premium', 'odrzucona', 'Produkt spełnia normy jakościowe - reklamacja odrzucona', '2025-05-18 09:15:00'),
(4, 7, 10, NULL, '2025-05-20 11:10:00', 'Filet z kurczaka miał nietypowy kolor i konsystencję', 'otwarta', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `towary`
--

CREATE TABLE `towary` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `cena_zl_kg` decimal(10,2) DEFAULT NULL,
  `czy_wymaga_zapytania` tinyint(1) DEFAULT 0,
  `kategoria` enum('wołowina','wieprzowina','drób','mieszanka') NOT NULL,
  `dostepnosc` enum('dostępny','na zamówienie','zapytaj') DEFAULT 'dostępny',
  `pracownik_odpowiedzialny` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `towary`
--

INSERT INTO `towary` (`id`, `nazwa`, `cena_zl_kg`, `czy_wymaga_zapytania`, `kategoria`, `dostepnosc`, `pracownik_odpowiedzialny`) VALUES
(1, 'Rostbef wołowy', 89.99, 0, 'wołowina', 'dostępny', NULL),
(2, 'Karkówka wieprzowa', 27.99, 0, 'wieprzowina', 'dostępny', NULL),
(3, 'Mieszanka do kebab', NULL, 1, 'mieszanka', 'zapytaj', NULL),
(4, 'Mielonka wołowa', 34.99, 0, 'wołowina', 'dostępny', NULL),
(5, 'Filet z kurczaka', 25.99, 0, 'drób', 'dostępny', NULL),
(6, 'Mięso do kebab drobiowe', NULL, 1, 'drób', 'zapytaj', NULL),
(7, 'Schab wieprzowy', 29.99, 0, 'wieprzowina', 'dostępny', NULL),
(8, 'Udka z kurczaka', 18.99, 0, 'drób', 'dostępny', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `klient_id` int(11) DEFAULT NULL,
  `imie` varchar(100) DEFAULT NULL,
  `nazwisko` varchar(100) DEFAULT NULL,
  `firma` varchar(255) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `adres` varchar(255) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `asortyment` varchar(255) NOT NULL,
  `waga` decimal(10,2) NOT NULL,
  `data_zamowienia` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('oczekujące','w realizacji','wysłane','zrealizowane','anulowane') NOT NULL DEFAULT 'oczekujące',
  `uwagi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`id`, `klient_id`, `imie`, `nazwisko`, `firma`, `nip`, `adres`, `telefon`, `email`, `asortyment`, `waga`, `data_zamowienia`, `status`, `uwagi`) VALUES
(1, 1, 'Jan', 'Kowalski', NULL, NULL, 'ul. Kwiatowa 10, 00-001 Warszawa', '123456789', 'jan.kowalski@email.com', 'Rostbef wołowy; Filet z kurczaka', 5.50, '2025-01-15 10:30:00', 'zrealizowane', 'Proszę o dokładne zapakowanie'),
(2, 4, 'Marek', 'Zieliński', 'Hurtownia Zielpol', '1234567890', 'ul. Handlowa 5, 30-001 Kraków', '601234567', 'biuro@zielpol.pl', 'Karkówka wieprzowa; Schab wieprzowy; Udka z kurczaka', 25.00, '2025-02-20 14:15:00', 'wysłane', 'Dostawa na tydzień przed Wielkanocą'),
(3, 7, 'Agnieszka', 'Dąbrowska', 'Restauracja Pod Kogutem', '5566778899', 'Rynek 12, 50-001 Wrocław', '508123456', 'rezerwacje@podkogutem.pl', 'Mieszanka do kebab; Mięso do kebab drobiowe', 15.00, '2025-03-10 09:45:00', 'w realizacji', 'Pilne - na weekend'),
(4, 2, 'Anna', 'Nowak', NULL, NULL, 'ul. Słoneczna 3, 80-001 Gdańsk', '987654321', 'anna.nowak@email.com', 'Mielonka wołowa; Filet z kurczaka', 8.75, '2025-04-05 16:20:00', 'oczekujące', NULL),
(5, 12, 'Grzegorz', 'Lewandowski', 'Bella Italia Pizzeria', '5544332211', 'ul. Włoska 7, 90-001 Łódź', '603987654', 'pizza@bellaitalia.pl', 'Schab wieprzowy; Udka z kurczaka', 18.50, '2025-05-01 11:10:00', 'oczekujące', 'Proszę o fakturę VAT'),
(6, 5, 'Katarzyna', 'Wójcik', 'ElektroPlus Sp. z o.o.', '9876543210', 'al. Techniczna 15, 40-001 Katowice', '605987654', 'office@elektroplus.com', 'Rostbef wołowy; Karkówka wieprzowa', 12.30, '2025-05-08 13:45:00', 'wysłane', 'Dostawa w godzinach 10-14'),
(7, 10, 'Adam', 'Mazur', NULL, NULL, 'ul. Leśna 8, 60-001 Poznań', '609876543', 'adam.m@email.com', 'Filet z kurczaka; Udka z kurczaka', 6.25, '2025-05-10 17:30:00', 'zrealizowane', 'Preferowana dostawa w piątek'),
(8, 8, 'Robert', 'Kozłowski', 'Bistro U Roberta', '9988776655', 'pl. Centralny 2, 70-001 Szczecin', '509876543', 'robert@bistro.pl', 'Mielonka wołowa; Schab wieprzowy', 10.00, '2025-05-11 10:15:00', 'w realizacji', NULL),
(9, 3, 'Piotr', 'Wiśniewski', NULL, NULL, 'ul. Ogrodowa 4, 20-001 Lublin', '555111222', 'piotr.w@email.com', 'Rostbef wołowy', 3.75, '2025-05-12 08:45:00', 'oczekujące', 'Preferowane mięso z małą ilością tłuszczu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia_towary`
--

CREATE TABLE `zamowienia_towary` (
  `zamowienie_id` int(11) NOT NULL,
  `towar_id` int(11) NOT NULL,
  `ilosc_kg` decimal(10,2) NOT NULL,
  `cena_zl_kg` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia_towary`
--

INSERT INTO `zamowienia_towary` (`zamowienie_id`, `towar_id`, `ilosc_kg`, `cena_zl_kg`) VALUES
(1, 1, 2.50, 89.99),
(1, 5, 1.50, 25.99),
(2, 2, 15.00, 26.50),
(2, 4, 8.00, 32.99),
(2, 7, 12.00, 28.50),
(3, 3, 5.00, 42.00),
(3, 6, 7.00, 34.50),
(3, 8, 10.00, 17.99),
(4, 5, 3.00, 25.99),
(4, 8, 2.00, 18.99),
(5, 1, 5.00, 85.00),
(5, 7, 20.00, 27.50),
(6, 2, 10.00, 27.99),
(6, 4, 5.00, 34.99);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dostawy`
--
ALTER TABLE `dostawy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pracownik_id` (`pracownik_id`);

--
-- Indeksy dla tabeli `dostawy_towary`
--
ALTER TABLE `dostawy_towary`
  ADD PRIMARY KEY (`dostawa_id`,`towar_id`),
  ADD KEY `towar_id` (`towar_id`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `reklamacje`
--
ALTER TABLE `reklamacje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zamowienie_id` (`zamowienie_id`),
  ADD KEY `klient_id` (`klient_id`),
  ADD KEY `pracownik_id` (`pracownik_id`);

--
-- Indeksy dla tabeli `towary`
--
ALTER TABLE `towary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_towary_pracownicy` (`pracownik_odpowiedzialny`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_zamowienia_klienci` (`klient_id`);

--
-- Indeksy dla tabeli `zamowienia_towary`
--
ALTER TABLE `zamowienia_towary`
  ADD PRIMARY KEY (`zamowienie_id`,`towar_id`),
  ADD KEY `towar_id` (`towar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dostawy`
--
ALTER TABLE `dostawy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reklamacje`
--
ALTER TABLE `reklamacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `towary`
--
ALTER TABLE `towary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dostawy`
--
ALTER TABLE `dostawy`
  ADD CONSTRAINT `dostawy_ibfk_1` FOREIGN KEY (`pracownik_id`) REFERENCES `pracownicy` (`id`);

--
-- Constraints for table `dostawy_towary`
--
ALTER TABLE `dostawy_towary`
  ADD CONSTRAINT `dostawy_towary_ibfk_1` FOREIGN KEY (`dostawa_id`) REFERENCES `dostawy` (`id`),
  ADD CONSTRAINT `dostawy_towary_ibfk_2` FOREIGN KEY (`towar_id`) REFERENCES `towary` (`id`);

--
-- Constraints for table `reklamacje`
--
ALTER TABLE `reklamacje`
  ADD CONSTRAINT `reklamacje_ibfk_1` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienia` (`id`),
  ADD CONSTRAINT `reklamacje_ibfk_2` FOREIGN KEY (`klient_id`) REFERENCES `klienci` (`id`),
  ADD CONSTRAINT `reklamacje_ibfk_3` FOREIGN KEY (`pracownik_id`) REFERENCES `pracownicy` (`id`);

--
-- Constraints for table `towary`
--
ALTER TABLE `towary`
  ADD CONSTRAINT `fk_towary_pracownicy` FOREIGN KEY (`pracownik_odpowiedzialny`) REFERENCES `pracownicy` (`id`);

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `fk_zamowienia_klienci` FOREIGN KEY (`klient_id`) REFERENCES `klienci` (`id`),
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`klient_id`) REFERENCES `klienci` (`id`);

--
-- Constraints for table `zamowienia_towary`
--
ALTER TABLE `zamowienia_towary`
  ADD CONSTRAINT `zamowienia_towary_ibfk_1` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienia` (`id`),
  ADD CONSTRAINT `zamowienia_towary_ibfk_2` FOREIGN KEY (`towar_id`) REFERENCES `towary` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
