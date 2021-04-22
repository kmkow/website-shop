-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 15 Sty 2020, 01:02
-- Wersja serwera: 10.4.10-MariaDB
-- Wersja PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep_internetowy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adresy_klientow`
--

CREATE TABLE `adresy_klientow` (
  `id_klienta` int(11) NOT NULL,
  `imie` text COLLATE utf8mb4_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8mb4_polish_ci NOT NULL,
  `nrtel` text COLLATE utf8mb4_polish_ci NOT NULL,
  `adres` text COLLATE utf8mb4_polish_ci NOT NULL,
  `kod_pocztowy` text COLLATE utf8mb4_polish_ci NOT NULL,
  `miasto` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `adresy_klientow`
--

INSERT INTO `adresy_klientow` (`id_klienta`, `imie`, `nazwisko`, `nrtel`, `adres`, `kod_pocztowy`, `miasto`) VALUES
(1, 'Konrad', 'Kowalczyk', '782609543', 'Łuczynów', '26-900', 'Kozienice'),
(2, 'Marcin', 'Murawski', '131234123', 'Jakiś', 'Jakiś', 'Jakieś'),
(5, 'Dziki', 'Szczypior', '6969', 'kremówkowa69', '21-37', 'Wadowice');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id_kategoria` int(11) NOT NULL,
  `nazwa_kategorii` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id_kategoria`, `nazwa_kategorii`) VALUES
(1, 'Ubiór'),
(2, 'Użytkowe');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `email_klienta` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `email_klienta`) VALUES
(1, 'notevenone1@gmail.com'),
(2, 'qwe@awa.pl'),
(3, 'qwe@awa.pl'),
(4, 'qwe@awa.pl'),
(5, 'wojtyla2137@o2.pl');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `magazyn`
--

CREATE TABLE `magazyn` (
  `id_produktu` int(11) NOT NULL,
  `ilosc_w_magazynie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `magazyn`
--

INSERT INTO `magazyn` (`id_produktu`, `ilosc_w_magazynie`) VALUES
(1, 16),
(3, 0),
(9, 4),
(10, 117),
(11, 7),
(12, 100),
(13, 47),
(14, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt`
--

CREATE TABLE `produkt` (
  `id_produktu` int(11) NOT NULL,
  `nazwa_produktu` text COLLATE utf8mb4_polish_ci NOT NULL,
  `cena_produktu` float NOT NULL,
  `id_kategoria` int(11) NOT NULL,
  `opis_produktu` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `produkt`
--

INSERT INTO `produkt` (`id_produktu`, `nazwa_produktu`, `cena_produktu`, `id_kategoria`, `opis_produktu`) VALUES
(1, 'Kapcie', 5.99, 1, ' Kapcie - Umożliwiają milsze przemieszczanie się poprzez zimnie podłogi naszego domu.'),
(3, 'Kapelusz', 15.99, 1, ' Stylowe nakrycie głowy'),
(9, 'Zegarek', 109.99, 1, ' Pomiar czasu nigdy nie był prostszy! \r\nWystarczy założyć go na rękę.'),
(10, 'Herbata', 11.99, 2, ' Zestaw ziół potrzebnych do przygotowania naparu o właściwościach zdrowotnych i pobudzających. \"Pijmy złocisty napar, by zapomnieć o zgiełku tego świata\".'),
(11, 'Szalik', 15, 1, ' Chroni szyje przed zimnym wiatrem. Przydaje się w zimowej porze roku'),
(12, 'Krakersy', 4.5, 2, 'Słona przekąska. '),
(13, 'Czapka', 10, 1, 'Chroni głowę przed zimnem. Przydaje się w zimę. '),
(14, 'Ciastka do mleka', 3.99, 2, 'Po zjedzeniu odnawiają zdrowie (5 HP na sekundę)\r\nW połączeniu z mlekiem (15 HP na sekundę) ');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `status_zamowienia`
--

CREATE TABLE `status_zamowienia` (
  `id_statusu` int(11) NOT NULL,
  `nazwa_statusu` text COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `status_zamowienia`
--

INSERT INTO `status_zamowienia` (`id_statusu`, `nazwa_statusu`) VALUES
(1, 'przyjete'),
(2, 'gotowe_do_wysylki'),
(3, 'wyslano');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_zamowienia`
--

CREATE TABLE `szczegoly_zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_produktu` int(11) NOT NULL,
  `ilosc_zamawianego_produktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `szczegoly_zamowienia`
--

INSERT INTO `szczegoly_zamowienia` (`id_zamowienia`, `id_produktu`, `ilosc_zamawianego_produktu`) VALUES
(1, 11, 1),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `laczna_cena` float NOT NULL,
  `data_zlozenia_zamowienia` date NOT NULL,
  `status_zamowienia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`id_zamowienia`, `id_klienta`, `laczna_cena`, `data_zlozenia_zamowienia`, `status_zamowienia`) VALUES
(1, 1, 15, '2020-01-02', 2),
(2, 2, 15.98, '2020-01-02', 1),
(3, 5, 37.97, '2020-01-10', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adresy_klientow`
--
ALTER TABLE `adresy_klientow`
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id_kategoria`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `magazyn`
--
ALTER TABLE `magazyn`
  ADD KEY `id_produktu` (`id_produktu`);

--
-- Indeksy dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`id_produktu`),
  ADD KEY `id_kategoria` (`id_kategoria`);

--
-- Indeksy dla tabeli `status_zamowienia`
--
ALTER TABLE `status_zamowienia`
  ADD PRIMARY KEY (`id_statusu`);

--
-- Indeksy dla tabeli `szczegoly_zamowienia`
--
ALTER TABLE `szczegoly_zamowienia`
  ADD UNIQUE KEY `id_zamowienia` (`id_zamowienia`),
  ADD KEY `id_produktu` (`id_produktu`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `id_klienta` (`id_klienta`),
  ADD KEY `status_zamowienia` (`status_zamowienia`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `produkt`
--
ALTER TABLE `produkt`
  MODIFY `id_produktu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `adresy_klientow`
--
ALTER TABLE `adresy_klientow`
  ADD CONSTRAINT `adresy_klientow_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);

--
-- Ograniczenia dla tabeli `magazyn`
--
ALTER TABLE `magazyn`
  ADD CONSTRAINT `magazyn_ibfk_1` FOREIGN KEY (`id_produktu`) REFERENCES `produkt` (`id_produktu`);

--
-- Ograniczenia dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`id_kategoria`) REFERENCES `kategorie` (`id_kategoria`);

--
-- Ograniczenia dla tabeli `szczegoly_zamowienia`
--
ALTER TABLE `szczegoly_zamowienia`
  ADD CONSTRAINT `szczegoly_zamowienia_ibfk_1` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`),
  ADD CONSTRAINT `szczegoly_zamowienia_ibfk_2` FOREIGN KEY (`id_produktu`) REFERENCES `produkt` (`id_produktu`);

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`status_zamowienia`) REFERENCES `status_zamowienia` (`id_statusu`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
