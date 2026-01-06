-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Jan-2026 às 20:51
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gamejamforfun2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
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
-- Estrutura da tabela `conteudos_paginas`
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
-- Extraindo dados da tabela `conteudos_paginas`
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
-- Estrutura da tabela `edicoes`
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
-- Estrutura da tabela `inscricao`
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
-- Estrutura da tabela `logs_acoes`
--

CREATE TABLE `logs_acoes` (
  `id_logs_acoes` int(11) NOT NULL,
  `utilizador_id` int(11) NOT NULL,
  `acao` varchar(45) NOT NULL,
  `data_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `menus`
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
-- Extraindo dados da tabela `menus`
--

INSERT INTO `menus` (`id_menu`, `titulo`, `url`, `ordem`, `pai_id`, `ativo`) VALUES
(1, 'Inicio', '/PAP_GAMEJAMFORFUN1/index.php', 1, NULL, 1),
(2, 'Edições', '/PAP_GAMEJAMFORFUN1/index.php', 2, NULL, 1),
(3, 'Edição1', '/PAP_GAMEJAMFORFUN1/edicao1(1).php', 1, 2, 1),
(4, 'Edição 2', '/PAP_GAMEJAMFORFUN1/edicao2(1).php', 2, 2, 1),
(5, 'Edição 3', '/PAP_GAMEJAMFORFUN1/edicao3(1).php', 3, 2, 1),
(6, 'Inscrição ', '/PAP_GAMEJAMFORFUN1/inscrição.php', 3, NULL, 1),
(7, 'Contactos', '/PAP_GAMEJAMFORFUN1/contact.php', 4, NULL, 1),
(8, 'Login', '/PAP_GAMEJAMFORFUN1/login.php', 5, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `participantes`
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
-- Estrutura da tabela `patrocinios`
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
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id_role`, `nome`, `descricao`) VALUES
(1, 'admin', 'Administrador com acesso total ao painel de gestão'),
(2, 'viewer', 'Utilizador comum que pode fazer registo e inscrições');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id_utilizador` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id_utilizador`, `nome`, `email`, `senha_hash`, `role_id`, `ativo`, `criado_em`) VALUES
(1, 'leticia', '12.leticia.rodrigues@gmail.com', '$2y$10$EY6yUkH8qPafKO1ZnR71DuLIlmUpgL/vBekcb6x2v1gHnkVDm6LRS', 1, 1, '2026-01-05 18:42:34');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id_arquivos`),
  ADD KEY `fk_arquivos_utilizador` (`criado_por`);

--
-- Índices para tabela `conteudos_paginas`
--
ALTER TABLE `conteudos_paginas`
  ADD PRIMARY KEY (`id_conteudo`),
  ADD UNIQUE KEY `chave_slug` (`chave_slug`),
  ADD KEY `fk_conteudo_user` (`atualizado_por`);

--
-- Índices para tabela `edicoes`
--
ALTER TABLE `edicoes`
  ADD PRIMARY KEY (`id_edicoes`),
  ADD KEY `fk_edicoes_utilizador` (`criado_por`);

--
-- Índices para tabela `inscricao`
--
ALTER TABLE `inscricao`
  ADD PRIMARY KEY (`id_inscricao`),
  ADD KEY `fk_inscricao_utilizador` (`validado_por`);

--
-- Índices para tabela `logs_acoes`
--
ALTER TABLE `logs_acoes`
  ADD PRIMARY KEY (`id_logs_acoes`),
  ADD KEY `fk_logs_utilizador` (`utilizador_id`);

--
-- Índices para tabela `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_menu_pai` (`pai_id`);

--
-- Índices para tabela `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id_participantes`),
  ADD KEY `fk_participantes_inscricao` (`inscricao_id`);

--
-- Índices para tabela `patrocinios`
--
ALTER TABLE `patrocinios`
  ADD PRIMARY KEY (`id_patrocinios`),
  ADD KEY `fk_patrocinios_utilizador` (`criado_por`);

--
-- Índices para tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id_utilizador`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_utilizador_role` (`role_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id_arquivos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conteudos_paginas`
--
ALTER TABLE `conteudos_paginas`
  MODIFY `id_conteudo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `edicoes`
--
ALTER TABLE `edicoes`
  MODIFY `id_edicoes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `inscricao`
--
ALTER TABLE `inscricao`
  MODIFY `id_inscricao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `logs_acoes`
--
ALTER TABLE `logs_acoes`
  MODIFY `id_logs_acoes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id_participantes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `patrocinios`
--
ALTER TABLE `patrocinios`
  MODIFY `id_patrocinios` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `fk_arquivos_utilizador` FOREIGN KEY (`criado_por`) REFERENCES `utilizadores` (`id_utilizador`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `conteudos_paginas`
--
ALTER TABLE `conteudos_paginas`
  ADD CONSTRAINT `fk_conteudo_user` FOREIGN KEY (`atualizado_por`) REFERENCES `utilizadores` (`id_utilizador`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `edicoes`
--
ALTER TABLE `edicoes`
  ADD CONSTRAINT `fk_edicoes_utilizador` FOREIGN KEY (`criado_por`) REFERENCES `utilizadores` (`id_utilizador`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `inscricao`
--
ALTER TABLE `inscricao`
  ADD CONSTRAINT `fk_inscricao_utilizador` FOREIGN KEY (`validado_por`) REFERENCES `utilizadores` (`id_utilizador`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `logs_acoes`
--
ALTER TABLE `logs_acoes`
  ADD CONSTRAINT `fk_logs_utilizador` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id_utilizador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `fk_menu_pai` FOREIGN KEY (`pai_id`) REFERENCES `menus` (`id_menu`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `participantes`
--
ALTER TABLE `participantes`
  ADD CONSTRAINT `fk_participantes_inscricao` FOREIGN KEY (`inscricao_id`) REFERENCES `inscricao` (`id_inscricao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `patrocinios`
--
ALTER TABLE `patrocinios`
  ADD CONSTRAINT `fk_patrocinios_utilizador` FOREIGN KEY (`criado_por`) REFERENCES `utilizadores` (`id_utilizador`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `fk_utilizador_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
