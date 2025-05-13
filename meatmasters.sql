-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 11, 2025 at 04:01 PM
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
-- Struktura tabeli dla tabeli `towary`
--

CREATE TABLE `towary` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `cena_zl_kg` decimal(10,2) DEFAULT NULL,
  `czy_wymaga_zapytania` tinyint(1) DEFAULT 0,
  `kategoria` enum('wołowina','wieprzowina','drób','mieszanka') NOT NULL,
  `dostepnosc` enum('dostępny','na zamówienie','zapytaj') DEFAULT 'dostępny'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `towary`
--

INSERT INTO `towary` (`id`, `nazwa`, `cena_zl_kg`, `czy_wymaga_zapytania`, `kategoria`, `dostepnosc`) VALUES
(1, 'Rostbef wołowy', 89.99, 0, 'wołowina', 'dostępny'),
(2, 'Karkówka wieprzowa', 27.99, 0, 'wieprzowina', 'dostępny'),
(3, 'Mieszanka do kebab', NULL, 1, 'mieszanka', 'zapytaj'),
(4, 'Mielonka wołowa', 34.99, 0, 'wołowina', 'dostępny'),
(5, 'Filet z kurczaka', 25.99, 0, 'drób', 'dostępny'),
(6, 'Mięso do kebab drobiowe', NULL, 1, 'drób', 'zapytaj'),
(7, 'Schab wieprzowy', 29.99, 0, 'wieprzowina', 'dostępny'),
(8, 'Udka z kurczaka', 18.99, 0, 'drób', 'dostępny');

--
-- Indeksy dla zrzutów tabel
--

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
-- Indeksy dla tabeli `towary`
--
ALTER TABLE `towary`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `towary`
--
ALTER TABLE `towary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
