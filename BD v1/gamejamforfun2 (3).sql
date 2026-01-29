-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2026 at 07:08 PM
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
-- Table structure for table `conteudo_index`
--

CREATE TABLE `conteudo_index` (
  `id` int(11) NOT NULL,
  `campo` varchar(100) NOT NULL,
  `valor` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conteudo_index`
--

INSERT INTO `conteudo_index` (`id`, `campo`, `valor`) VALUES
(1, 'video_url', 'img/Game jaaam.mp4'),
(2, 'titulo', 'Game Jam For Fun'),
(3, 'subtitulo', 'Já imaginaste criar o teu próprio jogo?'),
(4, 'descricao', 'Queres mostrar o teu talento? Esta é a oportunidade perfeita para ti!!'),
(5, 'logo', 'uploads/1769593615_6979db0fa035d.png'),
(6, 'sobre_titulo', 'Sobre Nós'),
(7, 'sobre_texto1', 'Bem-Vindo à Game Jam For Fun! Somos uma comunidade de Alunos e Professores apaixonados pela criação de jogos.'),
(8, 'sobre_texto2', 'Nesta 2ª Edição, promovemos mais um desafio e conexões entre participantes de várias escolas.'),
(9, 'local_titulo', 'Onde Estamos'),
(10, 'local_texto1', 'Estamos localizados no Agrupamento de Escolas de Albergaria-a-Velha (AEAAV), Portugal.'),
(11, 'local_texto2', 'Os alunos e professores criaram este projeto como iniciativa para promover a criação de jogos.'),
(12, 'etapas_titulo', 'Todas as Etapas 🎮 - 2026'),
(13, 'patrocinadores_titulo', 'Patrocinadores'),
(14, 'patrocinadores_agradecimento', 'Agradecemos pelo patrocínio e participação no evento!');

-- --------------------------------------------------------

--
-- Table structure for table `edicoes`
--

CREATE TABLE `edicoes` (
  `id` int(11) NOT NULL,
  `titulo_pagina` varchar(255) DEFAULT NULL,
  `titulo_evento` varchar(255) DEFAULT NULL,
  `edicao_numero` varchar(50) DEFAULT NULL,
  `data_evento` varchar(255) DEFAULT NULL,
  `tema` varchar(255) DEFAULT NULL,
  `participantes1` varchar(255) DEFAULT NULL,
  `participantes2` varchar(255) DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `descricao` longtext DEFAULT NULL,
  `cronograma` longtext DEFAULT NULL,
  `patrocinadores_titulo` varchar(255) DEFAULT NULL,
  `patrocinadores_agradecimento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edicoes`
--

INSERT INTO `edicoes` (`id`, `titulo_pagina`, `titulo_evento`, `edicao_numero`, `data_evento`, `tema`, `participantes1`, `participantes2`, `local`, `descricao`, `cronograma`, `patrocinadores_titulo`, `patrocinadores_agradecimento`) VALUES
(1, 'GameJamForFun - 1ª Edição', 'Game Jam For Fun', '1ª Edição', '19, 20 e 21 de Abril 2024', 'O tema escolhido deste ano foi \"As Alterações Climáticas\"!!', 'Tivemos 10 equipas!!', 'Tivemos equipas da nossa escola e da escola de Estarreja.', 'Escola Secundária de Albergaria-a-Velha', '<p>A Game Jam 2024 &ndash; AEAAV realizou-se entre 19 e 21 de abril no Agrupamento de Escolas de Albergaria-a-Velha, reunindo 10 equipas e 30 alunos no desenvolvimento de videojogos sobre o tema &ldquo;As altera&ccedil;&otilde;es clim&aacute;ticas&rdquo;. Durante 48 horas, os participantes dedicaram-se &agrave; cria&ccedil;&atilde;o, design e programa&ccedil;&atilde;o dos seus projetos, num ambiente marcado pela coopera&ccedil;&atilde;o e entreajuda.</p>\r\n<p>A iniciativa foi organizada pelos docentes de Inform&aacute;tica, com o apoio dos alunos de TGPSI, que garantiram todas as condi&ccedil;&otilde;es tecnol&oacute;gicas, log&iacute;sticas e de apoio t&eacute;cnico. Outros grupos da escola contribu&iacute;ram igualmente de forma volunt&aacute;ria para o bom funcionamento do evento. No domingo, as equipas apresentaram os seus jogos perante familiares, convidados e um j&uacute;ri independente.</p>\r\n<p><strong>🏆 Vencedores:</strong></p>\r\n<p>🥇 1.&ordm; lugar: RDK (Clim\'Pocalipse) &ndash; Agrupamento de Escolas de Estarreja</p>\r\n<p>🥈 2.&ordm; lugar: NoName (Be the hero) &ndash; Agrupamento de Escolas de Albergaria-a-Velha</p>\r\n<p>🥉 3.&ordm; lugar: The Fingers (Finger Temperature) &ndash; Agrupamento de Escolas de Albergaria-a-Velha</p>\r\n<p>A organiza&ccedil;&atilde;o agradeceu a todos os que contribu&iacute;ram para a realiza&ccedil;&atilde;o do evento, incluindo os patrocinadores, pelo apoio essencial. Foi uma experi&ecirc;ncia enriquecedora e um verdadeiro sucesso!</p>', '<div class=\"timeline\">\r\n<div class=\"timeline-item\">\r\n<div class=\"timeline-date\">Dia 19</div>\r\n<div class=\"timeline-content\">\r\n<h4>18:30 - Abertura</h4>\r\n<p>Rece&ccedil;&atilde;o das equipas</p>\r\n<h4>19:30 - In&iacute;cio da Game Jam</h4>\r\n<p>Apresenta&ccedil;&atilde;o do evento e an&uacute;ncio do tema</p>\r\n</div>\r\n</div>\r\n<div class=\"timeline-item\">\r\n<div class=\"timeline-date\">Dia 20</div>\r\n<div class=\"timeline-content\">\r\n<h4>- All Day - desenvolvimento dos jogos</h4>\r\n<p>Cria&ccedil;&atilde;o dos jogos</p>\r\n<h4>- All Day - Monitoramento da tens&atilde;o arterial</h4>\r\n<p>Durante os per&iacute;odos da manh&atilde; e da tarde, a tens&atilde;o arterial dos participantes ser&aacute; monitorizada pelos alunos do curso de T&eacute;cnico Auxiliar de Sa&uacute;de</p>\r\n</div>\r\n</div>\r\n<div class=\"timeline-item\">\r\n<div class=\"timeline-date\">Dia 21</div>\r\n<div class=\"timeline-content\">\r\n<h4>12:00 - Entrega</h4>\r\n<p>Prazo final para submiss&atilde;o dos jogos</p>\r\n<h4>14:30 - Apresenta&ccedil;&otilde;es</h4>\r\n<p>Apresenta&ccedil;&atilde;o dos jogos desenvolvidos</p>\r\n<h4>17:00 - Divulga&ccedil;&atilde;o dos vencedores</h4>\r\n<p>Premia&ccedil;&atilde;o das equipas vencedoras</p>\r\n</div>\r\n</div>\r\n</div>', 'Patrocinadore', 'Agradecemos pelo patrocínio e participação no evento!'),
(2, 'GameJamForFun - 2ª Edição', 'Game Jam For Fun', '2ª Edição', '23, 24 e 25 de Maio 2025', 'O tema escolhido deste ano foi \"Desliga-te\"!!', 'Tivemos 14 equipas!!', 'Tivemos equipas da nossa escola e de outra escolas de Estarreja e da José Estevão.', 'Escola Secundária de Albergaria-a-Velha', '\r\n<p>\r\nA segunda edição da Game Jam for Fun decorreu entre 23 e 25 de maio, contando com a participação de \r\n14 equipas de várias escolas do distrito, desafiadas a desenvolver um jogo em 48 horas. A sessão de\r\nabertura incluiu intervenções de várias personalidades da área da educação e tecnologia, destacando-se \r\na palestra do engenheiro Manu.\r\n</p>\r\n\r\n<p>\r\nO tema escolhido, “DESLIGA-TE”, promoveu a reflexão sobre o uso excessivo da tecnologia e das redes sociais.\r\nOs jogos apresentados foram avaliados por um júri especializado, composto por representantes do ensino superior,\r\nempresas e entidades do setor.\r\n</p>\r\n\r\n<p><strong>🏆 Vencedores:</strong></p>\r\n\r\n<p>🥇 1.º lugar: Os Guri – Escola Secundária de Albergaria-a-Velha</p>\r\n<p>🥈 2.º lugar: Os Bacanos – Escola Secundária de Estarreja</p>\r\n<p>🥉 3.º lugar: Equipa da Escola Secundária José Estêvão</p>\r\n\r\n<p>\r\nO evento terminou com um lanche-convívio, num clima de celebração e agradecimento. Mais do que jogos, \r\nos participantes criaram memórias, laços e experiências marcantes.\r\n</p>\r\n', '\r\n<div class=\"timeline\">\r\n\r\n    <div class=\"timeline-item\">\r\n        <div class=\"timeline-date\">Dia 23</div>\r\n        <div class=\"timeline-content\">\r\n            <h4>18:30 - Abertura</h4>\r\n            <p>Receção das equipas</p>\r\n            <h4>19:30 - Início da Game Jam</h4>\r\n            <p>Apresentação do evento e anúncio do tema</p>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"timeline-item\">\r\n        <div class=\"timeline-date\">Dia 24</div>\r\n        <div class=\"timeline-content\">\r\n            <h4>- All Day - desenvolvimento dos jogos</h4>\r\n            <p>Criação dos jogos</p>\r\n            <h4>- All Day - Monitoramento da tensão arterial</h4>\r\n            <p>Durante os períodos da manhã e da tarde, a tensão arterial dos \r\n            participantes será monitorizada pelos alunos do curso de Técnico \r\n            Auxiliar de Saúde</p>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"timeline-item\">\r\n        <div class=\"timeline-date\">Dia 25</div>\r\n        <div class=\"timeline-content\">\r\n            <h4>12:00 - Entrega</h4>\r\n            <p>Prazo final para submissão dos jogos</p>\r\n            <h4>14:30 - Palestra</h4>\r\n            <p>Palestra sobre desenvolvimento de jogos</p>\r\n            <h4>15:00 - Apresentações</h4>\r\n            <p>Apresentação dos jogos desenvolvidos</p>\r\n            <h4>18:00 - Divulgação dos vencedoras</h4>\r\n            <p>Premiação das equipas vencedoras</p>\r\n        </div>\r\n    </div>\r\n\r\n</div>\r\n', 'Patrocinadores', 'Agradecemos pelo patrocínio e participação no evento!');

-- --------------------------------------------------------

--
-- Table structure for table `edicoes_carrossel`
--

CREATE TABLE `edicoes_carrossel` (
  `id` int(11) NOT NULL,
  `id_edicao` int(11) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `legenda` varchar(255) DEFAULT NULL,
  `ordem` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edicoes_carrossel`
--

INSERT INTO `edicoes_carrossel` (`id`, `id_edicao`, `imagem`, `legenda`, `ordem`) VALUES
(1, 1, 'uploads/20240419_150940.jpg', NULL, 1),
(2, 1, 'uploads/20240419_182414.jpg', NULL, 2),
(3, 1, 'uploads/20240419_220524.jpg', NULL, 3),
(4, 1, 'uploads/20240421_131030.jpg', NULL, 4),
(5, 2, 'img/6125.jpg', '', 0),
(6, 2, 'img/5971.jpg', '', 0),
(7, 2, 'img/5983.jpg', '', 0),
(8, 2, 'img/5995.jpg', '', 0),
(9, 2, 'img/6006.jpg', '', 0),
(10, 2, 'img/6033.jpg', '', 0),
(11, 2, 'img/6039.jpg', '', 0),
(12, 2, 'img/6109.jpg', '', 0),
(13, 2, 'img/6114.jpg', '', 0),
(14, 2, 'img/6117.jpg', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `edicoes_patrocinadores`
--

CREATE TABLE `edicoes_patrocinadores` (
  `id` int(11) NOT NULL,
  `id_edicao` int(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `ordem` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edicoes_patrocinadores`
--

INSERT INTO `edicoes_patrocinadores` (`id`, `id_edicao`, `logo`, `link`, `ordem`) VALUES
(1, 1, 'img/p2.svg', 'https://reage.pt/', 0),
(2, 1, 'img/p3.png', 'https://jadegroupe.pt/', 0),
(3, 1, 'img/p5.png', 'https://www.facebook.com/resendeseixaspublicidade/', 0),
(4, 1, 'img/p7.png', 'https://www.loja-online.intermarche.pt/', 0),
(5, 1, 'img/p10.png', 'https://www.cm-albergaria.pt/', 0),
(6, 1, 'img/p11.png', 'https://deltacafes.com/', 0),
(8, 2, 'img/p1.png', 'https://www.facebook.com/pampas.pamplina/', 0),
(9, 2, 'img/p2.svg', 'https://reage.pt/', 0),
(10, 2, 'img/p3.png', 'https://jadegroupe.pt/', 0),
(11, 2, 'img/p4.png', 'https://www.facebook.com/fornalha.albergaria/', 0),
(12, 2, 'img/p5.png', 'https://www.facebook.com/resendeseixaspublicidade/', 0),
(13, 2, 'img/p6.png', 'https://www.facebook.com/Papaduxo/?locale=pt_BR', 0),
(14, 2, 'img/p7.png', 'https://www.loja-online.intermarche.pt/', 0),
(15, 2, 'img/p9.png', 'https://www.facebook.com/people/Albamercado-suplda/100063969456853/', 0),
(16, 2, 'img/p10.png', 'https://www.cm-albergaria.pt/', 0),
(17, 2, 'img/p11.png', 'https://deltacafes.com/', 0);

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
(4, 'Admin Master', 'admin@gmail.com', '$2y$10$uI389rK55varFmHfdUW5Pu2xbMOXqtrVAktP3/AyPpZ0uhEy6ogQe', 1, '2026-01-29 15:14:54', '2026-01-14 09:53:59', 'img/default.png'),
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
-- Indexes for table `conteudo_index`
--
ALTER TABLE `conteudo_index`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edicoes`
--
ALTER TABLE `edicoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edicoes_carrossel`
--
ALTER TABLE `edicoes_carrossel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_edicao` (`id_edicao`);

--
-- Indexes for table `edicoes_patrocinadores`
--
ALTER TABLE `edicoes_patrocinadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_edicao` (`id_edicao`);

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
-- AUTO_INCREMENT for table `conteudo_index`
--
ALTER TABLE `conteudo_index`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `edicoes`
--
ALTER TABLE `edicoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `edicoes_carrossel`
--
ALTER TABLE `edicoes_carrossel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `edicoes_patrocinadores`
--
ALTER TABLE `edicoes_patrocinadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- Constraints for table `edicoes_carrossel`
--
ALTER TABLE `edicoes_carrossel`
  ADD CONSTRAINT `edicoes_carrossel_ibfk_1` FOREIGN KEY (`id_edicao`) REFERENCES `edicoes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `edicoes_patrocinadores`
--
ALTER TABLE `edicoes_patrocinadores`
  ADD CONSTRAINT `edicoes_patrocinadores_ibfk_1` FOREIGN KEY (`id_edicao`) REFERENCES `edicoes` (`id`) ON DELETE CASCADE;

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
