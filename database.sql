-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2018. Máj 08. 01:12
-- Kiszolgáló verziója: 10.1.10-MariaDB
-- PHP verzió: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Adatbázis: `webshippy`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `urlap`
--

CREATE TABLE `urlap` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `drivingLicence` tinyint(1) DEFAULT NULL,
  `hobbiKerekpar` tinyint(1) DEFAULT NULL,
  `hobbiTurazas` tinyint(1) DEFAULT NULL,
  `hobbiHegymaszas` tinyint(1) DEFAULT NULL,
  `hobbiProgramozas` tinyint(1) DEFAULT NULL,
  `hobbiEgyeb` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `urlap`
--

INSERT INTO `urlap` (`id`, `name`, `email`, `phone`, `birthday`, `drivingLicence`, `hobbiKerekpar`, `hobbiTurazas`, `hobbiHegymaszas`, `hobbiProgramozas`, `hobbiEgyeb`) VALUES
(1, 'Teszt Elek', 'tesztelek@gmail.com', '123456789', '1982-01-19', 0, 0, 0, 0, 0, 0),
(35, 'Teszt Béla', 'tesztbela@teszt.hu', '123456789', '2000-01-01', 0, 1, 0, 0, 0, 1),
(36, 'Teszt Irma', 'irma@teszt.hu', '888787778', '1988-03-01', 1, 1, 1, 0, 0, 1),
(37, 'Teszt Zsuzsa', 'zsuzsa@teszt.hu', '', '0000-00-00', 0, 0, 0, 0, 0, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `urlap`
--
ALTER TABLE `urlap`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `urlap`
--
ALTER TABLE `urlap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;