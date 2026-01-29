-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 10:16 AM
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
-- Database: `gamejamforfun2`
--

-- --------------------------------------------------------

--
-- Table structure for table `arquivos`
--

CREATE TABLE `arquivos` (
  `id_arquivos` int(11) NOT NULL,
  `nome_arquivo` varchar(150) DEFAULT NULL,
  `caminho` varchar(255) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `criado_por` int(11) NOT NULL,
  `criado_em` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `resposta` text DEFAULT NULL,
  `data_envio` datetime DEFAULT NULL,
  `data_resposta` datetime DEFAULT NULL,
  `user_id_respondeu` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `nome`, `email`, `mensagem`, `resposta`, `data_envio`, `data_resposta`, `user_id_respondeu`, `user_id`) VALUES
(1, 'Marilia', 'bywmarilia14@gmail.com', 'oiiiiiii', NULL, '2026-01-18 17:21:52', NULL, NULL, NULL),
(2, 'Marilia', 'bywmarilia14@gmail.com', 'oiiiiiii', NULL, '2026-01-18 17:22:19', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inscricoes`
--

CREATE TABLE `inscricoes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `instituicao` varchar(255) NOT NULL,
  `professor` varchar(255) NOT NULL,
  `email_professor` varchar(255) NOT NULL,
  `plataforma` varchar(100) NOT NULL,
  `linguagem` varchar(100) NOT NULL,
  `linguagem_outra` varchar(100) DEFAULT NULL,
  `num_participantes` int(11) NOT NULL,
  `participante1_nome` varchar(255) DEFAULT NULL,
  `participante1_idade` int(11) DEFAULT NULL,
  `participante1_email` varchar(255) DEFAULT NULL,
  `participante1_curso` varchar(255) DEFAULT NULL,
  `participante2_nome` varchar(255) DEFAULT NULL,
  `participante2_idade` int(11) DEFAULT NULL,
  `participante2_email` varchar(255) DEFAULT NULL,
  `participante2_curso` varchar(255) DEFAULT NULL,
  `participante3_nome` varchar(255) DEFAULT NULL,
  `participante3_idade` int(11) DEFAULT NULL,
  `participante3_email` varchar(255) DEFAULT NULL,
  `participante3_curso` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `estado` enum('pendente','aprovado','rejeitado') DEFAULT 'pendente',
  `data_inscricao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inscricoes`
--

INSERT INTO `inscricoes` (`id`, `user_id`, `instituicao`, `professor`, `email_professor`, `plataforma`, `linguagem`, `linguagem_outra`, `num_participantes`, `participante1_nome`, `participante1_idade`, `participante1_email`, `participante1_curso`, `participante2_nome`, `participante2_idade`, `participante2_email`, `participante2_curso`, `participante3_nome`, `participante3_idade`, `participante3_email`, `participante3_curso`, `observacoes`, `estado`, `data_inscricao`) VALUES
(1, 16, 'escala', 'antonio', 'bywmarilia14@gmail.com', 'GameMaker', 'C#', '', 1, '0', 15, 'admin@gmail.com', '', '', 0, '', '0', '', 0, '', '', '', 'pendente', '2026-01-14 17:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `logs_atividade`
--

CREATE TABLE `logs_atividade` (
  `id_log` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `acao` varchar(100) NOT NULL,
  `detalhe` text DEFAULT NULL,
  `data_log` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs_atividade`
--

INSERT INTO `logs_atividade` (`id_log`, `id`, `acao`, `detalhe`, `data_log`) VALUES
(1, 1, 'Criar Admin', 'Criado novo admin: mari@gmail.com', '2026-01-14 09:57:10'),
(2, 1, 'Criar Admin', 'Criado novo admin: admin@gmail.com', '2026-01-14 09:57:20');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ordem` int(11) DEFAULT 0,
  `pai_id` int(11) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id_menu`, `titulo`, `url`, `ordem`, `pai_id`, `ativo`) VALUES
(1, 'Inicio', '/PAP_GAMEJAMFORFUN1/index.php', 1, NULL, 1),
(2, 'Edições', '/PAP_GAMEJAMFORFUN1/index.php', 2, NULL, 1),
(3, 'Edição1', '/PAP_GAMEJAMFORFUN1/edicao1.php', 1, 2, 1),
(4, 'Edição 2', '/PAP_GAMEJAMFORFUN1/edicao2.php', 2, 2, 1),
(5, 'Edição 3', '/PAP_GAMEJAMFORFUN1/edicao3.php', 3, 2, 1),
(6, 'Inscrição ', '/PAP_GAMEJAMFORFUN1/inscricao.php', 3, NULL, 1),
(7, 'Contactos', '/PAP_GAMEJAMFORFUN1/contact.php', 4, NULL, 1),
(8, 'Login', '/PAP_GAMEJAMFORFUN1/login.php', 5, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `data` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notificacoes`
--

INSERT INTO `notificacoes` (`id`, `user_id`, `mensagem`, `lida`, `data`) VALUES
(1, 16, 'A sua inscrição para a Game Jam For Fun 25 foi recebida e está pendente de aprovação.', 1, '2026-01-14 17:19:51'),
(2, 1, 'Nova inscrição submetida por mar.', 0, '2026-01-14 17:19:51'),
(3, 4, 'Novo pedido de contacto de Marilia', 1, '2026-01-18 17:21:53'),
(4, 1, 'Novo pedido de contacto de Marilia', 0, '2026-01-18 17:21:53'),
(5, 5, 'Novo pedido de contacto de Marilia', 1, '2026-01-18 17:21:53'),
(6, 4, 'Novo pedido de contacto de Marilia', 1, '2026-01-18 17:22:19'),
(7, 1, 'Novo pedido de contacto de Marilia', 0, '2026-01-18 17:22:19'),
(8, 5, 'Novo pedido de contacto de Marilia', 1, '2026-01-18 17:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nome`, `descricao`) VALUES
(1, 'adminmaster', 'Administrador com acesso total ao painel de gestão'),
(2, 'admin', 'Administrador '),
(3, 'viewer', 'apenas pode visualizar ');

-- --------------------------------------------------------

--
-- Table structure for table `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `ativo` datetime NOT NULL DEFAULT current_timestamp(),
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `nome`, `email`, `senha_hash`, `role_id`, `ativo`, `criado_em`, `foto`) VALUES
(1, 'leticia', '12.leticia.rodrigues@gmail.com', '$2y$10$EY6yUkH8qPafKO1ZnR71DuLIlmUpgL/vBekcb6x2v1gHnkVDm6LRS', 2, '2000-01-27 00:00:00', '2026-01-05 18:42:34', NULL),
(4, 'Admin Master', 'admin@gmail.com', '$2y$10$uI389rK55varFmHfdUW5Pu2xbMOXqtrVAktP3/AyPpZ0uhEy6ogQe', 1, '2026-01-28 09:02:09', '2026-01-14 09:53:59', 'img/default.png'),
(5, 'Marilia', 'mari@gmail.com', '$2y$10$mjGwjuOAFkAsCggx7es24eZ8RCxw1Qw9zCWDhKI8GfcPoDJpsqH4u', 2, '2026-01-18 17:24:44', '2026-01-14 09:54:22', 'img/default.png'),
(12, 'Marilia', 'mariliagabryella2008@gmail.com', '$2y$10$Gu6WtnZ/pun/ZhacI2z.MOhAsGZSA/0C1pIlKbPJEValSZ0rCDX7m', 3, '2000-01-27 00:00:00', '2026-01-14 10:45:42', 'img/default.png'),
(16, 'mar', 'bywmarilia14@gmail.com', '$2y$10$uHErYARcuNdO4YWfaGWD0eprt2jQkLYjXdQHM.gEd5jWQACXe5KR6', 3, '2026-01-18 17:22:30', '2026-01-14 16:56:55', 'uploads/1768410434_RobloxScreenShot20240825_223949293.png');

-- --------------------------------------------------------

--
-- Table structure for table `verificacoes_email`
--

CREATE TABLE `verificacoes_email` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `token` varchar(255) NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verificacoes_email`
--

INSERT INTO `verificacoes_email` (`id`, `email`, `token`, `criado_em`) VALUES
(1, 'escolaalbergaria@gmail.com', 'f01d3f4213e6b6453e2010d713f002815962cf9ead0b89c1385112093c94cb34', '2026-01-14 10:15:39'),
(3, 'mariliagabryella2008@gmail.com', '39d590d44b73de2b8fb89713f6031ad3703b9e6dc6b243551e227ee9f68f8994', '2026-01-14 10:17:56'),
(4, 'mariliagabryella2008@gmail.com', '33d2c7016266af62cc0973a990ae0f32f527d61cfbd4f091463e96803fcf617b', '2026-01-14 10:42:07'),
(5, 'mariliagabryella2008@gmail.com', '4a54e69fae1a28c13d3f81fdcaebe9774451ece90cf6c6513212df3db3a1e11c', '2026-01-14 10:45:42'),
(11, 'bywmarilia14@gmail.com', '767b1a5bedf7cceca6fe5e654bc5044ee5d5e98825848fb2f5045ebb19be01b1', '2026-01-14 14:04:45'),
(12, 'bywmarilia14@gmail.com', '8ef08774ee78ac7bef797d4456caf6794636471974a502df91619badf91727e9', '2026-01-14 14:05:11'),
(13, 'bywmarilia14@gmail.com', '4c6831f2ad386226f321ba0180e5096bc40189df449febaa16324151d1d4f27e', '2026-01-14 16:39:13'),
(14, 'bywmarilia14@gmail.com', '77b9c384b9ccfaf49c15d947d850efc89b2702747af64fad9b3c7e642e4061f4', '2026-01-14 16:48:19'),
(15, 'bywmarilia14@gmail.com', 'dba6fc809a386d669b8f2837a611b733096fa07558c6fdac705b1c98ba786390', '2026-01-14 16:49:26'),
(16, 'bywmarilia14@gmail.com', '75bc3e6e62b63e76992e9fceb284381152dc172f203ebb7a1746522781c9ad0e', '2026-01-14 16:53:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id_arquivos`),
  ADD KEY `fk_arquivos_utilizador` (`criado_por`);

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `logs_atividade`
--
ALTER TABLE `logs_atividade`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_menu_pai` (`pai_id`);

--
-- Indexes for table `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_utilizador_role` (`role_id`);

--
-- Indexes for table `verificacoes_email`
--
ALTER TABLE `verificacoes_email`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id_arquivos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inscricoes`
--
ALTER TABLE `inscricoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs_atividade`
--
ALTER TABLE `logs_atividade`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `verificacoes_email`
--
ALTER TABLE `verificacoes_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `fk_arquivos_utilizador` FOREIGN KEY (`criado_por`) REFERENCES `utilizadores` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD CONSTRAINT `inscricoes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilizadores` (`id`);

--
-- Constraints for table `logs_atividade`
--
ALTER TABLE `logs_atividade`
  ADD CONSTRAINT `logs_atividade_ibfk_1` FOREIGN KEY (`id`) REFERENCES `utilizadores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `fk_menu_pai` FOREIGN KEY (`pai_id`) REFERENCES `menus` (`id_menu`) ON DELETE CASCADE;

--
-- Constraints for table `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilizadores` (`id`);

--
-- Constraints for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `fk_utilizador_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
