-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Jan-2026 às 19:01
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

--
-- Extraindo dados da tabela `arquivos`
--

INSERT INTO `arquivos` (`id_arquivos`, `nome_arquivo`, `caminho`, `tipo`, `criado_por`, `criado_em`) VALUES
(1, 'Regulamento', '/PAP_GAMEJAMFORFUN1/docs/Regulamento.pdf', NULL, 1, '2026-01-10 22:52:19'),
(2, 'Consentimento de participação', '/PAP_GAMEJAMFORFUN1/docs/Declaração de Consentimento e Aceitação de participacaoGJFF.pdf', NULL, 1, '2026-01-10 22:54:25');

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
(28, 'agradecimentos_texto', 'tetxo', 'Agradecemos pelo patrocínio e participação no evento!', '2026-01-05 18:36:07', 1),
(29, 'Titulo-Edicao1', 'titulo', 'Game Jam For Fun', '2026-01-14 17:37:26', 1),
(30, 'Subtitulo-Edicao1', 'subtitulo', '1ª Edição', '2026-01-14 17:37:26', 1),
(31, 'Data-Edicao1', 'data do evento', '19, 20 e 21 de Albril 2024', '2026-01-14 17:38:50', 1),
(32, 'Tema-Edicao1', 'Tema ', 'Tema', '2026-01-14 17:38:50', 1),
(33, 'Descricao_tema_edicao1', 'texto do tema', 'O tema escolhido deste ano foi \"As Alterações climáticas\"!!', '2026-01-18 12:24:22', 1),
(34, 'Participantes-Edicao1', 'Participantes subtitulo', 'Participantes', '2026-01-18 12:24:22', 1),
(35, 'Descricao_participantes_edicao1', 'texto participantes', 'Tivemos 10 equipas!!', '2026-01-18 12:29:11', 1),
(36, 'Descricao1_participantes_edicao1', 'texto', 'Tivemos equipas da nossa escola e da escola de Estarreja.', '2026-01-18 12:29:11', 1),
(37, 'Local-Edicao1', 'subtitulo', 'Local', '2026-01-18 12:29:11', 1),
(38, 'Descricao_local', 'texto', 'Escola Secundária de Albergaria-a-Velha', '2026-01-18 12:29:11', 1),
(39, 'Subtitulo_Sobre_Edicao1', 'subtitulo sobre', 'Sobre', '2026-01-18 12:38:58', 1),
(40, 'Descricao_Sobre_Edicao1', 'texto', 'A Game Jam 2024 – AEAAV realizou-se entre 19 e 21 de abril no Agrupamento de Escolas de Albergaria-a-Velha, reunindo 10 equipas e 30 alunos no desenvolvimento de videojogos sobre o tema “As alterações climáticas”. Durante 48 horas, os participantes dedicaram-se à criação, design e programação dos seus projetos, num ambiente marcado pela cooperação e entreajuda. ', '2026-01-18 12:38:58', 1),
(41, 'Descricao1_Sobre_Edicao1', 'texto', 'A iniciativa foi organizada pelos docentes de Informática, com o apoio dos alunos de TGPSI, que garantiram todas as condições tecnológicas, logísticas e de apoio técnico. Outros grupos da escola contribuíram igualmente de forma voluntária para o bom funcionamento do evento. No domingo, as equipas apresentaram os seus jogos perante familiares, convidados e um júri independente. ', '2026-01-18 12:38:58', 1),
(42, 'Vencedores_Edicao1', 'texto', '🏆 Vencedores:', '2026-01-18 12:38:58', 1),
(43, 'Vencedor1_Edicao1', '1 lugar', '🥇 1.º lugar: RDK(Clim\'Pocalipse) – Agrupamento de Escolas de Estarreja', '2026-01-18 12:38:58', 1),
(44, 'Vencedor2_Edicao1', '2 lugar', '🥈 2.º lugar: NoName (Be the hero) – Agrupamento de Escolas de Albergaria-a-Velha', '2026-01-18 12:38:58', 1),
(45, 'Vencedor3_Edicao1', '3 lugar', '🥉 3.º lugar: The Fingers (Finger Temperature) - Agrupamento de Escolas de Albergaria-a-Velha', '2026-01-18 12:38:58', 1),
(46, 'Descricao2_Sobre_Edicao1', 'texto', 'A organização agradeceu a todos os que contribuíram para a realização do evento, incluindo os patrocinadores, pelo apoio essencial. Foi uma experiência enriquecedora e um verdadeiro sucesso! ', '2026-01-18 12:38:58', 1),
(47, 'Subtitulo_Cronograma_Edicao1', 'subtitulo ', 'Cronograma', '2026-01-18 12:44:21', 1),
(48, 'Dia1_Cronograma_Edicao1', 'data', 'Dia 19', '2026-01-18 12:44:21', 1),
(49, 'Descricao_Dia1_Edicao1', 'texto', '18:30 - Abertura', '2026-01-18 12:44:21', 1),
(50, 'Descricao1_Dia1_Edicao1', 'texto', 'Receção das equipas', '2026-01-18 12:44:21', 1),
(51, 'Descricao2_Dia1_Edicao1', 'texto', '19:30 - Início da Game Jam', '2026-01-18 12:44:21', 1),
(52, 'Descricao3_Dia1_Edicao1', 'texto', 'Apresentação do evento e anúncio do tema', '2026-01-18 12:44:21', 1),
(53, 'Dia2_Cronograma_Edicao1', 'data', 'Dia 20', '2026-01-18 12:51:14', 1),
(54, 'Descricao_Dia2_Edicao1', 'texto', '- All Day - desenvolvimento dos jogos', '2026-01-18 12:51:14', 1),
(55, 'Descricao1_Dia2_Edicao1', 'texto', 'Criação dos jogos', '2026-01-18 12:51:14', 1),
(56, 'Descricao2_Dia2_Edicao1', 'texto', '- All Day - Monitoramento da tensão arterial', '2026-01-18 12:51:14', 1),
(57, 'Descricao3_Dia2_Edicao1', 'texto', 'Durante os períodos da manhã e da tarde, a tensão arterial dos participantes será monitorizada pelos alunos do curso de Técnico Auxiliar de Saúde', '2026-01-18 12:51:14', 1),
(58, 'Dia3_Cronograma_Edicao1', 'data', 'Dia 21', '2026-01-18 12:51:14', 1),
(59, 'Descricao_Dia3_Edicao1', 'texto', '12:00 - Entrega', '2026-01-18 12:51:14', 1),
(60, 'Descricao1_Dia3_Edicao1', 'texto', 'Prazo final para submissão dos jogos', '2026-01-18 12:51:14', 1),
(61, 'Descricao2_Dia3_Edicao1', 'texto', '14:30 - Apresentações', '2026-01-18 12:51:14', 1),
(62, 'Descricao3_Dia3_Edicao1', 'texto', 'Apresentação dos jogos desenvolvidos', '2026-01-18 12:51:14', 1),
(63, 'Descricao4_Dia3_Edicao1', 'texto', '17:00 - Divulgação dos vencedoras', '2026-01-18 12:51:14', 1),
(64, 'Descricao5_Dia3_Edicao1', 'texto', 'Premiação das equipas vencedoras', '2026-01-18 12:51:14', 1),
(65, 'Subtitulo_Patrocinadores_Edicao1', 'patrocinadores', 'Patrocinadores', '2026-01-18 12:51:14', 1),
(66, 'Descricao_Patrocinadores_Edicao1', 'texto', 'Agradecemos pelo patrocínio e participação no evento!', '2026-01-18 12:51:14', 1),
(67, 'Titulo_Edicao2', 'titulo', 'Game Jam For Fun ', '2026-01-18 13:15:15', 1),
(68, 'Subtitulo_Edicao2', '2 edicao', '2ª Edição', '2026-01-18 13:15:15', 1),
(69, 'Data_Edicao2', 'data', '23, 24 e 25 de Maio 2025', '2026-01-18 13:15:15', 1),
(70, 'Tema_Edicao2', 'tema subtitulo', 'Tema', '2026-01-18 13:15:15', 1),
(71, 'Descricao_tema_edicao2', 'texto', 'O tema escolhido deste ano foi \"Desliga-te\"!!', '2026-01-18 13:15:15', 1),
(72, 'Participantes_Edicao2', 'subtitulo', 'Participantes', '2026-01-18 13:15:15', 1),
(73, 'Descricao_participantes_edicao2', 'texto', 'Tivemos 14 equipas!!', '2026-01-18 13:15:15', 1),
(74, 'Descricao1_participantes_edicao2', 'texto', 'Tivemos equipas da nossa escola e de outra escolas de Estarreja e da José Estevão.', '2026-01-18 13:15:15', 1),
(75, 'Local_Edicao2', 'subtitulo', 'Local', '2026-01-18 13:15:15', 1),
(76, 'Descricao_local_Edicao2', 'texto', 'Escola Secundária de Albergaria-a-Velha', '2026-01-18 13:15:15', 1),
(77, 'Subtitulo_Sobre_Edicao2', 'subtitulo', 'Sobre', '2026-01-18 13:15:15', 1),
(78, 'Descricao_Sobre_Edicao2', 'texto', 'A segunda edição da Game Jam for Fun decorreu entre 23 e 25 de maio, contando com a participação de 14 equipas de várias escolas do distrito, desafiadas a desenvolver um jogo em 48 horas. A sessão de abertura incluiu intervenções de várias personalidades da área da educação e tecnologia, destacando-se a palestra do engenheiro Manu. ', '2026-01-18 13:15:15', 1),
(79, 'Descricao1_Sobre_Edicao2', 'texto', 'O tema escolhido, “DESLIGA-TE”, promoveu a reflexão sobre o uso excessivo da tecnologia e das redes sociais. Os jogos apresentados foram avaliados por um júri especializado, composto por representantes do ensino superior, empresas e entidades do setor. ', '2026-01-18 13:15:15', 1),
(80, 'Vencedores_Edicao2', 'texto', '🏆 Vencedores:', '2026-01-18 13:15:15', 1),
(81, 'Vencedor1_Edicao2', 'texto', '🥇 1.º lugar: Os Guri – Escola Secundária de Albergaria-a-Velha', '2026-01-18 13:15:15', 1),
(82, 'Vencedor2_Edicao2', 'texto', '🥈 2.º lugar: Os Bacanos – Escola Secundária de Estarreja', '2026-01-18 13:15:15', 1),
(83, 'Vencedor3_Edicao2', 'texto', '🥉 3.º lugar: Equipa da Escola Secundária José Estêvão', '2026-01-18 13:15:15', 1),
(84, 'Descricao2_Sobre_Edicao2', 'texto', 'O evento terminou com um lanche-convívio, num clima de celebração e agradecimento. Mais do que jogos, os participantes criaram memórias, laços e experiências marcantes. ', '2026-01-18 13:15:15', 1),
(85, 'Subtitulo_Cronograma_Edicao2', 'subtitulo', 'Cronograma', '2026-01-18 13:37:26', 1),
(86, 'Dia1_Cronograma_Edicao2', 'data', 'Dia 23', '2026-01-18 13:37:26', 1),
(87, 'Descricao_Dia1_Edicao2', 'texto', '18:30 - Abertura', '2026-01-18 13:37:26', 1),
(88, 'Descricao1_Dia1_Edicao2', 'texto', 'Receção das equipas', '2026-01-18 13:37:26', 1),
(89, 'Descricao2_Dia1_Edicao2', 'texto', '19:30 - Início da Game Jam', '2026-01-18 13:37:26', 1),
(90, 'Descricao3_Dia1_Edicao2', 'texto', 'Apresentação do evento e anúncio do tema', '2026-01-18 13:37:26', 1),
(91, 'Dia2_Cronograma_Edicao2', 'data', 'Dia 24', '2026-01-18 13:37:26', 1),
(92, 'Descricao_Dia2_Edicao2', 'texto', '- All Day - desenvolvimento dos jogos', '2026-01-18 13:37:26', 1),
(93, 'Descricao1_Dia2_Edicao2', 'texto', 'Criação dos jogos', '2026-01-18 13:37:26', 1),
(94, 'Descricao2_Dia2_Edicao2', 'texto', '- All Day - Monitoramento da tensão arterial', '2026-01-18 13:37:26', 1),
(95, 'Descricao3_Dia2_Edicao2', 'texto', 'Durante os períodos da manhã e da tarde, a tensão arterial dos participantes será monitorizada pelos alunos do curso de Técnico Auxiliar de Saúde', '2026-01-18 13:37:26', 1),
(96, 'Dia3_Cronograma_Edicao2', 'data', 'Dia 25', '2026-01-18 13:37:26', 1),
(97, 'Descricao_Dia3_Edicao2', 'texto', '12:00 - Entrega', '2026-01-18 13:37:26', 1),
(98, 'Descricao1_Dia3_Edicao2', 'texto', 'Prazo final para submissão dos jogos', '2026-01-18 13:37:26', 1),
(99, 'Descricao2_Dia3_Edicao2', 'texto', '14:30 - Palestra', '2026-01-18 13:37:26', 1),
(100, 'Descricao3_Dia3_Edicao2', 'texto', 'Palestra sobre desenvolvimento de jogos', '2026-01-18 13:37:26', 1),
(101, 'Descricao4_Dia3_Edicao2', 'texto', '15:00 - Apresentações', '2026-01-18 13:37:26', 1),
(102, 'Descricao5_Dia3_Edicao2', 'TEXTO', 'Apresentação dos jogos desenvolvidos', '2026-01-18 13:37:26', 1),
(103, 'Descricao6_Dia3_Edicao2', 'texto', '18:00 - Divulgação dos vencedoras', '2026-01-18 13:37:26', 1),
(104, 'Descricao7_Dia3_Edicao2', 'texto', 'Premiação das equipas vencedoras', '2026-01-18 13:37:26', 1),
(105, 'Subtitulo_Patrocinadores_Edicao2', 'subtitulo', 'Patrocinadores', '2026-01-18 13:37:26', 1),
(106, 'Descricao_Patrocinadores_Edicao2', 'agradecimentos', 'Agradecemos pelo patrocínio e participação no evento!', '2026-01-18 13:37:26', 1);

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
(3, 'Edição1', '/PAP_GAMEJAMFORFUN1/edicao1.php', 1, 2, 1),
(4, 'Edição 2', '/PAP_GAMEJAMFORFUN1/edicao2.php', 2, 2, 1),
(5, 'Edição 3', '/PAP_GAMEJAMFORFUN1/edicao3.php', 3, 2, 1),
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

--
-- Extraindo dados da tabela `patrocinios`
--

INSERT INTO `patrocinios` (`id_patrocinios`, `imagem_url`, `link_site`, `ativo`, `criado_por`, `criado_em`, `atualizado_em`) VALUES
(1, 'img/p1.png', 'https://www.facebook.com/pampas.pamplina/', 1, 1, '2026-01-10 22:59:04', NULL);

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
(2, 'Admin Master', 'Pode editar tudo');

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
(1, 'leticia', '12.leticia.rodrigues@gmail.com', '$2y$10$EY6yUkH8qPafKO1ZnR71DuLIlmUpgL/vBekcb6x2v1gHnkVDm6LRS', 1, 1, '2026-01-05 18:42:34'),
(2, 'Marília', 'mariliasilva@gmail.com', '$2y$10$EY6yUkH8qPafKO1ZnR71DuLIlmUpgL/vBekcb6x2v1gHnkVDm6LRS', 1, 1, '2026-01-10 20:58:38'),
(3, 'master', 'master@gmail.com', '$2y$10$EY6yUkH8qPafKO1ZnR71DuLIlmUpgL/vBekcb6x2v1gHnkVDm6LRS', 2, 1, '2026-01-10 21:00:07');

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
  MODIFY `id_arquivos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `conteudos_paginas`
--
ALTER TABLE `conteudos_paginas`
  MODIFY `id_conteudo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

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
  MODIFY `id_patrocinios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
