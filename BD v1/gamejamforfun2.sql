-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2026 at 06:22 PM
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
-- Table structure for table `conteudos_paginas`
--

CREATE TABLE `conteudos_paginas` (
  `id_conteudo` int(11) NOT NULL,
  `chave_slug` varchar(50) NOT NULL,
  `titulo_seccao` varchar(255) DEFAULT NULL,
  `texto_html` text DEFAULT NULL,
  `atualizado_em` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `atualizado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conteudos_paginas`
--

INSERT INTO `conteudos_paginas` (`id_conteudo`, `chave_slug`, `titulo_seccao`, `texto_html`, `atualizado_em`, `atualizado_por`) VALUES
(1, 'titulo_do_index', 'index', ' Game Jam For Fun ', '2026-01-05 18:13:14', 1),
(2, ' subtitulo_do_index', 'subtitulo', 'Já imaginaste criar o teu próprio jogo?', '2026-01-05 18:22:35', 1),
(3, 'subtitulo_do_index', 'subtitulo', 'Queres mostrar o teu talento? Esta é a oportunidade perfeita para ti!!', '2026-01-05 18:22:35', 1),
(4, 'sobrenos_titulo', 'sobre nos title', 'Sobre Nós', '2026-01-05 18:22:35', 1),
(5, 'texto_sobrenos', 'texto ', 'Bem-Vindo á Game Jam For Fun! Somos uma comunidade de Alunos e Professores que gostamos de criação de jogos, aos alunos damos o incentivo da inovação e a criatividade. O nosso objetivo é proporcionar aos participantes um experiência inesquecível. ', '2026-01-05 18:22:35', 1),
(6, 'texto_sobrenos1', 'texto', 'Nesta 2ª Edição, promovemos mais um desafio e conexões entre os participantes de várias escolas. Esperamos que venham fazer parte desta jornada.', '2026-01-05 18:22:35', 1),
(7, 'titulo_ondeestamos', 'titulo', 'Onde Estamos', '2026-01-05 18:22:35', 1),
(8, 'texto_ondeestamos', 'texto', 'Estamos localizados no Agrupamento de Escolas de Albergaria-a-Velha (AEAAV), Portugal, onde é ministrado o curso Técnico de Gestão e Programação de Sistemas Informáticos (TGPSI) com foco em programação e desenvolvimento digital.', '2026-01-05 18:22:35', 1),
(9, 'texto_ondeestamos1', 'texto', 'Os alunos e professores do mesmo criaram este projeto \"Game Jam For Fun\" que é uma iniciativa para promover a criação de jogos e a inovação tecnológica. 🎮', '2026-01-05 18:22:35', 1),
(10, 'titudo_etapas', 'titudo etapas', 'Todas as Etapas🎮 - 2025 ', '2026-01-05 18:22:35', 1),
(11, 'subtitulo_etapas', 'subtitulo', 'Inscrição', '2026-01-05 18:36:07', 1),
(12, 'texto_etapas_inscrições', 'texto', 'Inscrições entre dias 28 de abril a 14 de maio de 2025.', '2026-01-05 18:36:07', 1),
(13, 'texto_etapas_inscrições1', 'texto', 'Primeira fase: Apurar 16 equipas.', '2026-01-05 18:36:07', 1),
(14, 'subtitulo_etapas_dia_um', 'subtitulo', '1º dia', '2026-01-05 18:36:07', 1),
(15, 'texto_etapas_dia_um', 'texto', '18:30 - Receção das equipas;', '2026-01-05 18:36:07', NULL),
(16, 'texto_etapas_dia_um1', 'texto', '19:30 - Abertura com intervenção dos Júris e patrocinadores;', '2026-01-05 18:36:07', 1),
(17, 'texto_etapas_dia_um2', 'texto', 'Divulgação do tema da Game Jam For Fun;', '2026-01-05 18:36:07', 1),
(18, 'texto_etapas_dia_um3', 'texto', 'Início da Criação dos jogos com o Tema proposto.', '2026-01-05 18:36:07', 1),
(19, 'subtitulo_etapas_dia_dois', 'subtitulo', '2º dia', '2026-01-05 18:36:07', 1),
(20, 'texto_etapas_dia_dois', 'texto', 'Continuação da criação dos jogos com tema proposto. ', '2026-01-05 18:36:07', 1),
(21, 'texto_etapas_dia_dois1', 'texto', 'Durante os períodos da manhã e da tarde, a tensão arterial dos participantes será monitorizada pelos alunos do curso de Técnico Auxiliar de Saúde.', '2026-01-05 18:36:07', 1),
(22, 'subtitulo_etapas_dia_tres', 'subtitulo', '3º dia', '2026-01-05 18:36:07', 1),
(23, 'texto_etapas_dia_tres', 'texto', 'Entrega dos jogos desenvolvidos pelas equipas participantes;', '2026-01-05 18:36:07', 1),
(24, 'texto_etapas_dia_tres1', 'texto', 'Receção aos júris e professores;', '2026-01-05 18:36:07', 1),
(25, 'texto_etapas_dia_tres2', 'texto', 'Apresentações e avaliação dos jogos;', '2026-01-05 18:36:07', 1),
(26, 'texto_etapas_dia_tres3', 'texto', 'Divulgação das equipas vencedoras, com atribuição dos 1.º, 2.º e 3.º lugares.', '2026-01-05 18:36:07', 1),
(27, 'patrocinio_titulo', 'titulo', 'Patrocinadores', '2026-01-05 18:36:07', 1),
(28, 'agradecimentos_texto', 'tetxo', 'Agradecemos pelo patrocínio e participação no evento!', '2026-01-05 18:36:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `edicoes`
--

CREATE TABLE `edicoes` (
  `id_edicoes` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `tema` varchar(150) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_por` int(11) NOT NULL,
  `criado_em` datetime NOT NULL,
  `atualizado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inscricao`
--

CREATE TABLE `inscricao` (
  `id_inscricao` int(11) NOT NULL,
  `instituicao` varchar(100) DEFAULT NULL,
  `prof_nome` varchar(100) DEFAULT NULL,
  `email_prof` varchar(100) DEFAULT NULL,
  `plataforma_dev` varchar(100) DEFAULT NULL,
  `linguagem` varchar(45) DEFAULT NULL,
  `num_part` int(11) DEFAULT NULL,
  `criado_em` datetime NOT NULL,
  `validado_por` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Edição1', '/PAP_GAMEJAMFORFUN1/edicao1(1).php', 1, 2, 1),
(4, 'Edição 2', '/PAP_GAMEJAMFORFUN1/edicao2(1).php', 2, 2, 1),
(5, 'Edição 3', '/PAP_GAMEJAMFORFUN1/edicao3(1).php', 3, 2, 1),
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
(2, 1, 'Nova inscrição submetida por mar.', 0, '2026-01-14 17:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `participantes`
--

CREATE TABLE `participantes` (
  `id_participantes` int(11) NOT NULL,
  `inscricao_id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `curso_turma` varchar(100) DEFAULT NULL,
  `observacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patrocinios`
--

CREATE TABLE `patrocinios` (
  `id_patrocinios` int(11) NOT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `link_site` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_por` int(11) NOT NULL,
  `criado_em` datetime NOT NULL,
  `atualizado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'Admin Master', 'admin@gmail.com', '$2y$10$uI389rK55varFmHfdUW5Pu2xbMOXqtrVAktP3/AyPpZ0uhEy6ogQe', 1, '2000-01-27 00:00:00', '2026-01-14 09:53:59', 'img/default.png'),
(5, 'Marilia', 'mari@gmail.com', '$2y$10$mjGwjuOAFkAsCggx7es24eZ8RCxw1Qw9zCWDhKI8GfcPoDJpsqH4u', 2, '2000-01-27 00:00:00', '2026-01-14 09:54:22', 'img/default.png'),
(12, 'Marilia', 'mariliagabryella2008@gmail.com', '$2y$10$Gu6WtnZ/pun/ZhacI2z.MOhAsGZSA/0C1pIlKbPJEValSZ0rCDX7m', 3, '2000-01-27 00:00:00', '2026-01-14 10:45:42', 'img/default.png'),
(16, 'mar', 'bywmarilia14@gmail.com', '$2y$10$QUkDEzE435LaeuTLs/U45eGEvivDTSmXGgK1pUpJqapTpkfzjq32a', 3, '2026-01-14 16:58:39', '2026-01-14 16:56:55', 'uploads/1768410434_RobloxScreenShot20240825_223949293.png');

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
-- Indexes for table `conteudos_paginas`
--
ALTER TABLE `conteudos_paginas`
  ADD PRIMARY KEY (`id_conteudo`),
  ADD UNIQUE KEY `chave_slug` (`chave_slug`),
  ADD KEY `fk_conteudo_user` (`atualizado_por`);

--
-- Indexes for table `edicoes`
--
ALTER TABLE `edicoes`
  ADD PRIMARY KEY (`id_edicoes`),
  ADD KEY `fk_edicoes_utilizador` (`criado_por`);

--
-- Indexes for table `inscricao`
--
ALTER TABLE `inscricao`
  ADD PRIMARY KEY (`id_inscricao`),
  ADD KEY `fk_inscricao_utilizador` (`validado_por`);

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
-- Indexes for table `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id_participantes`),
  ADD KEY `fk_participantes_inscricao` (`inscricao_id`);

--
-- Indexes for table `patrocinios`
--
ALTER TABLE `patrocinios`
  ADD PRIMARY KEY (`id_patrocinios`),
  ADD KEY `fk_patrocinios_utilizador` (`criado_por`);

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
-- AUTO_INCREMENT for table `conteudos_paginas`
--
ALTER TABLE `conteudos_paginas`
  MODIFY `id_conteudo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `edicoes`
--
ALTER TABLE `edicoes`
  MODIFY `id_edicoes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inscricao`
--
ALTER TABLE `inscricao`
  MODIFY `id_inscricao` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id_participantes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patrocinios`
--
ALTER TABLE `patrocinios`
  MODIFY `id_patrocinios` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `conteudos_paginas`
--
ALTER TABLE `conteudos_paginas`
  ADD CONSTRAINT `fk_conteudo_user` FOREIGN KEY (`atualizado_por`) REFERENCES `utilizadores` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `edicoes`
--
ALTER TABLE `edicoes`
  ADD CONSTRAINT `fk_edicoes_utilizador` FOREIGN KEY (`criado_por`) REFERENCES `utilizadores` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `inscricao`
--
ALTER TABLE `inscricao`
  ADD CONSTRAINT `fk_inscricao_utilizador` FOREIGN KEY (`validado_por`) REFERENCES `utilizadores` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Constraints for table `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `fk_participantes_inscricao` FOREIGN KEY (`inscricao_id`) REFERENCES `inscricao` (`id_inscricao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patrocinios`
--
ALTER TABLE `patrocinios`
  ADD CONSTRAINT `fk_patrocinios_utilizador` FOREIGN KEY (`criado_por`) REFERENCES `utilizadores` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `fk_utilizador_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
