-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 11:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamejam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_Admins` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `senha_hash` varchar(255) DEFAULT NULL,
  `tipo_admin` enum('super','editor','visualizador') DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `ativo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arquivos`
--

CREATE TABLE `arquivos` (
  `id_arquivos` int(11) NOT NULL,
  `nome_arquivo` varchar(45) DEFAULT NULL,
  `caminho` varchar(45) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `criado_por` int(11) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `edicoes`
--

CREATE TABLE `edicoes` (
  `id_Edicoes` int(11) NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `tema` varchar(150) DEFAULT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  `criado_por` int(11) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inscricao`
--

CREATE TABLE `inscricao` (
  `idinscricao` int(11) NOT NULL,
  `instituicao` varchar(45) DEFAULT NULL,
  `prof_nome` varchar(45) DEFAULT NULL,
  `email_prof` varchar(45) DEFAULT NULL,
  `plataforma_dev` varchar(45) DEFAULT NULL,
  `linguagem` varchar(45) DEFAULT NULL,
  `num_part` int(11) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `validado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs_acoes`
--

CREATE TABLE `logs_acoes` (
  `id_logs_acoes` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `acao` varchar(45) DEFAULT NULL,
  `data_hora` varchar(45) DEFAULT NULL,
  `logs_acoescol` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participantes`
--

CREATE TABLE `participantes` (
  `idparticipantes` int(11) NOT NULL,
  `inscricao_id` int(11) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `curso_turma` varchar(45) DEFAULT NULL,
  `observacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patrocinio`
--

CREATE TABLE `patrocinio` (
  `idpatrocinios` int(11) NOT NULL,
  `imagem_url` varchar(45) DEFAULT NULL,
  `link_site` varchar(45) DEFAULT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  `criado_por` int(11) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_Admins`);

--
-- Indexes for table `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id_arquivos`),
  ADD KEY `criado_por` (`criado_por`);

--
-- Indexes for table `edicoes`
--
ALTER TABLE `edicoes`
  ADD PRIMARY KEY (`id_Edicoes`),
  ADD KEY `criado_por` (`criado_por`);

--
-- Indexes for table `inscricao`
--
ALTER TABLE `inscricao`
  ADD PRIMARY KEY (`idinscricao`),
  ADD KEY `validado_por` (`validado_por`);

--
-- Indexes for table `logs_acoes`
--
ALTER TABLE `logs_acoes`
  ADD PRIMARY KEY (`id_logs_acoes`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`idparticipantes`),
  ADD KEY `inscricao_id` (`inscricao_id`);

--
-- Indexes for table `patrocinio`
--
ALTER TABLE `patrocinio`
  ADD PRIMARY KEY (`idpatrocinios`),
  ADD KEY `criado_por` (`criado_por`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_Admins` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id_arquivos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edicoes`
--
ALTER TABLE `edicoes`
  MODIFY `id_Edicoes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inscricao`
--
ALTER TABLE `inscricao`
  MODIFY `idinscricao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs_acoes`
--
ALTER TABLE `logs_acoes`
  MODIFY `id_logs_acoes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `participantes`
--
ALTER TABLE `participantes`
  MODIFY `idparticipantes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patrocinio`
--
ALTER TABLE `patrocinio`
  MODIFY `idpatrocinios` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `arquivos_ibfk_1` FOREIGN KEY (`criado_por`) REFERENCES `admins` (`id_Admins`);

--
-- Constraints for table `edicoes`
--
ALTER TABLE `edicoes`
  ADD CONSTRAINT `edicoes_ibfk_1` FOREIGN KEY (`criado_por`) REFERENCES `admins` (`id_Admins`);

--
-- Constraints for table `inscricao`
--
ALTER TABLE `inscricao`
  ADD CONSTRAINT `inscricao_ibfk_1` FOREIGN KEY (`validado_por`) REFERENCES `admins` (`id_Admins`);

--
-- Constraints for table `logs_acoes`
--
ALTER TABLE `logs_acoes`
  ADD CONSTRAINT `logs_acoes_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id_Admins`);

--
-- Constraints for table `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`inscricao_id`) REFERENCES `inscricao` (`idinscricao`);

--
-- Constraints for table `patrocinio`
--
ALTER TABLE `patrocinio`
  ADD CONSTRAINT `patrocinio_ibfk_1` FOREIGN KEY (`criado_por`) REFERENCES `admins` (`id_Admins`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
