-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Dez-2019 às 16:37
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cfapi`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `countryflags`
--

CREATE TABLE `countryflags` (
  `id` int(11) NOT NULL,
  `flags` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `who_added` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `time_it_was_added` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registers`
--

CREATE TABLE `registers` (
  `id` int(11) NOT NULL,
  `ZoneID` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `AuthEmail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `AuthKey` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Page` int(11) NOT NULL,
  `IP` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datec` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `countryflags`
--
ALTER TABLE `countryflags`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `registers`
--
ALTER TABLE `registers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `countryflags`
--
ALTER TABLE `countryflags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `registers`
--
ALTER TABLE `registers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
