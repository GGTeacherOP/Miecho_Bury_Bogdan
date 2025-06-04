-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 04, 2025 at 07:28 PM
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
(1, 'Jan', 'Kowalski', 'jan.kowalski@email.com', 'haslo1234', '123456789', 'klient indywidualny', NULL, NULL, '2023-01-14 10:00:00'),
(2, 'Anna', 'Nowak', 'anna.nowak@email.com', 'haslo1233', '987654321', 'klient indywidualny', NULL, NULL, '2023-02-19 11:30:00'),
(3, 'Piotr', 'Wiśniewski', 'piotr.w@email.com', 'haslo6123', '555111222', 'klient indywidualny', NULL, NULL, '2023-03-09 09:15:00'),
(4, 'Marek', 'Zieliński', 'biuro@zielpol.pl', 'admin12', '601234567', 'firma/hurtownia', 'Hurtownia Zielpol', '1234567890', '2023-04-04 14:20:00'),
(5, 'Katarzyna', 'Wójcik', 'office@elektroplus.com', 'admin41', '605987654', 'firma/hurtownia', 'ElektroPlus Sp. z o.o.', '9876543210', '2023-05-11 16:45:00'),
(6, 'Tomasz', 'Szymański', 'zamowienia@smak.com.pl', 'admin17', '607456789', 'firma/hurtownia', 'Dystrybutor Smak', '1122334455', '2023-06-17 08:30:00'),
(7, 'Agnieszka', 'Dąbrowska', 'rezerwacje@podkogutem.pl', 'resto31', '508123456', 'restauracja', 'Restauracja Pod Kogutem', '5566778899', '2023-07-21 12:00:00'),
(8, 'Robert', 'Kozłowski', 'robert@bistro.pl', 'resto31', '509876543', 'restauracja', 'Bistro U Roberta', '9988776655', '2023-08-14 13:15:00'),
(9, 'Magdalena', 'Jankowska', 'kontakt@slodkikacik.pl', 'resto11', '501234567', 'restauracja', 'Słodki Kącik', '4433221100', '2023-08-31 10:45:00'),
(10, 'Adam', 'Mazur', 'adam.m@email.com', 'haslo1232', '609876543', 'klient indywidualny', NULL, NULL, '2023-10-09 15:30:00'),
(11, 'Ewa', 'Kwiatkowska', 'catering@smacznaewa.pl', 'admin13', '604567890', 'firma/hurtownia', 'Smaczna Ewa Catering', '6677889900', '2023-11-24 11:20:00'),
(12, 'Grzegorz', 'Lewandowski', 'pizza@bellaitalia.pl', 'resto321', '603987654', 'restauracja', 'Bella Italia Pizzeria', '5544332211', '2023-12-04 17:00:00'),
(13, 'Barbara', 'Witkowska', 'barbara.w@email.com', 'haslo12333', '602345678', 'klient indywidualny', NULL, NULL, '2024-01-15 09:45:00'),
(14, 'Michał', 'Kaczmarek', 'michal.k@email.com', 'haslo12321', '606789012', 'klient indywidualny', NULL, NULL, '2024-02-20 14:10:00'),
(15, 'Aleksandra', 'Pawlak', 'dostawy@freshfood.pl', 'admin1111', '608901234', 'firma/hurtownia', 'Fresh Food Sp. z o.o.', '7788990011', '2024-03-05 08:20:00'),
(25, 'Krzysztof', 'Batog', 'Krzysztofsigma@gmail.com', '$2y$10$gnfausKF9egR4r3vBirpru0BrpdDv0TUd70bNHawxA.m5nCSp7eoW', '999222333', '', '', '', '2025-05-15 16:25:38'),
(26, 'Dominus', 'Bogus', 'DominoGamer@gmail.com', '$2y$10$bCfYT2cbhwUKkC2oezyuq.MMNC4pW4S5UekH.LplzGhKtALRrh0Qe', '112334556', '', '', '', '2025-05-15 16:51:46'),
(27, 'Bartosz', 'Dziewit', 'Dziewit@gmail.com', 'Dziewit1337', '000999888', 'firma/hurtownia', 'dziewit sp.zoo', '123', '2025-05-15 17:12:10'),
(28, 'Jan', 'Muszynski', 'Jan@gmail.com', 'Muszynskiessa', '123456789', 'klient indywidualny', NULL, NULL, '2025-05-15 17:30:43'),
(30, 'Bartek', 'Kozioł', 'koziolbartek@gmail.com', 'Bartek1337', '987234675', 'firma/hurtownia', NULL, NULL, '2025-05-15 20:34:15');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kontakty`
--

CREATE TABLE `kontakty` (
  `id` int(11) NOT NULL,
  `klient_id` int(11) DEFAULT NULL,
  `pracownik_id` int(11) DEFAULT NULL,
  `imie` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `temat` enum('zamowienie','reklamacja','wspolpraca','inne') NOT NULL,
  `wiadomosc` varchar(200) NOT NULL,
  `status` enum('nowa','w_trakcie','zamknieta') DEFAULT 'nowa',
  `data_zgloszenia` datetime DEFAULT current_timestamp(),
  `data_zakonczenia` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontakty`
--

INSERT INTO `kontakty` (`id`, `klient_id`, `pracownik_id`, `imie`, `email`, `telefon`, `temat`, `wiadomosc`, `status`, `data_zgloszenia`, `data_zakonczenia`) VALUES
(1, 1, 3, 'Jan Kowalski', 'jan.kowalski@email.com', '123456789', 'zamowienie', 'Chciałbym zamówić 10kg rostbefu wołowego na przyszły tydzień.', 'zamknieta', '2025-05-10 09:15:00', '2025-05-10 14:30:00'),
(2, 4, NULL, 'Marek Zieliński', 'biuro@zielpol.pl', '601234567', 'wspolpraca', 'Interesuje nas stała współpraca hurtowa. Proszę o kontakt w sprawie oferty.', 'w_trakcie', '2025-05-12 11:45:00', NULL),
(3, NULL, NULL, 'Anna Nowak', 'anna.nowak@email.com', '987654321', 'reklamacja', 'W ostatnim zamówieniu mięso było nieświeże. Proszę o wyjaśnienie sytuacji.', 'nowa', '2025-05-15 16:20:00', NULL),
(4, 7, 2, 'Agnieszka Dąbrowska', 'rezerwacje@podkogutem.pl', '508123456', 'zamowienie', 'Pilnie potrzebujemy 20kg mięsa do kebabu na weekend.', 'zamknieta', '2025-05-18 08:30:00', '2025-05-18 10:15:00'),
(5, 12, NULL, 'Grzegorz Lewandowski', 'pizza@bellaitalia.pl', '603987654', 'inne', 'Czy prowadzą Państwo szkolenia z przygotowania mięsa dla restauracji?', 'nowa', '2025-05-20 13:10:00', NULL),
(6, 5, 1, 'Katarzyna Wójcik', 'office@elektroplus.com', '605987654', 'reklamacja', 'Otrzymaliśmy niepełną dostawę w zamówieniu nr 245.', 'w_trakcie', '2025-05-21 10:45:00', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(100) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `stanowisko` varchar(50) NOT NULL,
  `data_zatrudnienia` date NOT NULL,
  `wynagrodzenie` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `imie`, `nazwisko`, `email`, `haslo`, `telefon`, `stanowisko`, `data_zatrudnienia`, `wynagrodzenie`) VALUES
(1, 'Jan', 'Kowalski', 'j.kowalski@meatmasters.pl', 'Jan.123', '501234567', 'Właściciel', '2020-03-15', 8500.00),
(2, 'Anna', 'Nowak', 'a.nowak@meatmasters.pl', 'Anna.123', '502345678', 'Kierownik', '2019-05-12', 8700.00),
(3, 'Piotr', 'Wiśniewski', 'p.wisniewski@meatmasters.pl', 'Piotr.123', '503456789', 'Programista', '2021-06-20', 9500.00),
(4, 'Katarzyna', 'Dąbrowska', 'k.dabrowska@meatmasters.pl', 'Katarzyna.123', '504567890', 'Programista', '2022-01-10', 9200.00),
(5, 'Marek', 'Lewandowski', 'm.lewandowski@meatmasters.pl', 'Marek.123', '505678901', 'Pracownik linii pakowania', '2021-07-15', 4200.00),
(6, 'Agnieszka', 'Wójcik', 'a.wojcik@meatmasters.pl', 'Agnieszka.123', '506789012', 'Pracownik linii pakowania', '2022-04-01', 4100.00),
(7, 'Tomasz', 'Kamiński', 't.kaminski@meatmasters.pl', 'Tomasz.123', '507890123', 'Pracownik linii pakowania', '2020-11-18', 4300.00),
(8, 'Magdalena', 'Zając', 'm.zajac@meatmasters.pl', 'Magdalena.123', '508901234', 'Pracownik linii pakowania', '2021-05-22', 4250.00),
(9, 'Grzegorz', 'Szymański', 'g.szymanski@meatmasters.pl', 'Grzegorz.123', '509012345', 'Pracownik linii pakowania', '2022-03-01', 4150.00),
(10, 'Joanna', 'Woźniak', 'j.wozniak@meatmasters.pl', 'Joanna.123', '511234567', 'Magazynier', '2020-08-10', 4500.00),
(11, 'Robert', 'Kozłowski', 'r.kozlowski@meatmasters.pl', 'Robert.123', '512345678', 'Magazynier', '2021-09-30', 4600.00),
(12, 'Ewa', 'Jankowska', 'e.jankowska@meatmasters.pl', 'Ewa.123', '513456789', 'Magazynier', '2022-07-01', 4550.00),
(13, 'Paweł', 'Mazur', 'p.mazur@meatmasters.pl', 'Paweł.123', '514567890', 'Księgowy', '2020-02-10', 6800.00),
(14, 'Monika', 'Krawczyk', 'm.krawczyk@meatmasters.pl', 'Monika.123', '515678901', 'Specjalista HR', '2021-04-15', 6200.00),
(15, 'Łukasz', 'Jabłoński', 'l.jablonski@meatmasters.pl', 'Łukasz.123', '516789012', 'Logistyk', '2023-01-05', 5800.00);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `pracownicy_widok`
-- (See below for the actual view)
--
CREATE TABLE `pracownicy_widok` (
`id` int(11)
,`imie` varchar(50)
,`nazwisko` varchar(50)
,`email` varchar(100)
,`telefon` varchar(20)
,`stanowisko` varchar(50)
,`data_zatrudnienia` date
,`wynagrodzenie` decimal(10,2)
);

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
-- Zastąpiona struktura widoku `reklamacje_widok`
-- (See below for the actual view)
--
CREATE TABLE `reklamacje_widok` (
`id_reklamacji` int(11)
,`data_zgloszenia` datetime
,`tresc` text
,`status` enum('otwarta','w_trakcie','rozpatrzona','odrzucona')
,`decyzja` text
,`data_rozpatrzenia` datetime
,`klient` varchar(101)
,`id_zamowienia` int(11)
,`pracownik_rozpatrujacy` varchar(101)
);

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
-- Zastąpiona struktura widoku `towary_widok`
-- (See below for the actual view)
--
CREATE TABLE `towary_widok` (
`id` int(11)
,`nazwa` varchar(100)
,`cena_zl_kg` decimal(10,2)
,`czy_wymaga_zapytania` tinyint(1)
,`kategoria` enum('wołowina','wieprzowina','drób','mieszanka')
,`dostepnosc` enum('dostępny','na zamówienie','zapytaj')
,`pracownik_opiekun` varchar(101)
);

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

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `zamowienia_widok`
-- (See below for the actual view)
--
CREATE TABLE `zamowienia_widok` (
`id_zamowienia` int(11)
,`data_zamowienia` datetime
,`klient` varchar(201)
,`firma` varchar(255)
,`nip` varchar(20)
,`adres` varchar(255)
,`telefon` varchar(20)
,`email` varchar(100)
,`asortyment` varchar(255)
,`waga` decimal(10,2)
,`status` enum('oczekujące','w realizacji','wysłane','zrealizowane','anulowane')
,`uwagi` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktura widoku `pracownicy_widok`
--
DROP TABLE IF EXISTS `pracownicy_widok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pracownicy_widok`  AS SELECT `pracownicy`.`id` AS `id`, `pracownicy`.`imie` AS `imie`, `pracownicy`.`nazwisko` AS `nazwisko`, `pracownicy`.`email` AS `email`, `pracownicy`.`telefon` AS `telefon`, `pracownicy`.`stanowisko` AS `stanowisko`, `pracownicy`.`data_zatrudnienia` AS `data_zatrudnienia`, `pracownicy`.`wynagrodzenie` AS `wynagrodzenie` FROM `pracownicy` ;

-- --------------------------------------------------------

--
-- Struktura widoku `reklamacje_widok`
--
DROP TABLE IF EXISTS `reklamacje_widok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reklamacje_widok`  AS SELECT `r`.`id` AS `id_reklamacji`, `r`.`data_zgloszenia` AS `data_zgloszenia`, `r`.`tresc` AS `tresc`, `r`.`status` AS `status`, `r`.`decyzja` AS `decyzja`, `r`.`data_rozpatrzenia` AS `data_rozpatrzenia`, concat(`k`.`imie`,' ',`k`.`nazwisko`) AS `klient`, `z`.`id` AS `id_zamowienia`, concat(`p`.`imie`,' ',`p`.`nazwisko`) AS `pracownik_rozpatrujacy` FROM (((`reklamacje` `r` join `klienci` `k` on(`r`.`klient_id` = `k`.`id`)) join `zamowienia` `z` on(`r`.`zamowienie_id` = `z`.`id`)) left join `pracownicy` `p` on(`r`.`pracownik_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `towary_widok`
--
DROP TABLE IF EXISTS `towary_widok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `towary_widok`  AS SELECT `t`.`id` AS `id`, `t`.`nazwa` AS `nazwa`, `t`.`cena_zl_kg` AS `cena_zl_kg`, `t`.`czy_wymaga_zapytania` AS `czy_wymaga_zapytania`, `t`.`kategoria` AS `kategoria`, `t`.`dostepnosc` AS `dostepnosc`, concat(`p`.`imie`,' ',`p`.`nazwisko`) AS `pracownik_opiekun` FROM (`towary` `t` left join `pracownicy` `p` on(`t`.`pracownik_odpowiedzialny` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `zamowienia_widok`
--
DROP TABLE IF EXISTS `zamowienia_widok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `zamowienia_widok`  AS SELECT `z`.`id` AS `id_zamowienia`, `z`.`data_zamowienia` AS `data_zamowienia`, concat(`z`.`imie`,' ',`z`.`nazwisko`) AS `klient`, `z`.`firma` AS `firma`, `z`.`nip` AS `nip`, `z`.`adres` AS `adres`, `z`.`telefon` AS `telefon`, `z`.`email` AS `email`, `z`.`asortyment` AS `asortyment`, `z`.`waga` AS `waga`, `z`.`status` AS `status`, `z`.`uwagi` AS `uwagi` FROM `zamowienia` AS `z` ;

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
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `typ_konta` (`typ_konta`);

--
-- Indeksy dla tabeli `kontakty`
--
ALTER TABLE `kontakty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `klient_id` (`klient_id`),
  ADD KEY `pracownik_id` (`pracownik_id`);

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
-- AUTO_INCREMENT for table `kontakty`
--
ALTER TABLE `kontakty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `kontakty`
--
ALTER TABLE `kontakty`
  ADD CONSTRAINT `kontakty_ibfk_1` FOREIGN KEY (`klient_id`) REFERENCES `klienci` (`id`),
  ADD CONSTRAINT `kontakty_ibfk_2` FOREIGN KEY (`pracownik_id`) REFERENCES `pracownicy` (`id`);

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
