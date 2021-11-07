-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Set-2021 às 01:53
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `is_midia` tinyint(4) DEFAULT NULL,
  `caminho_midia` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensagem` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_envio` datetime DEFAULT NULL,
  `visualizado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `chat`
--

INSERT INTO `chat` (`id_chat`, `id_remetente`, `id_destinatario`, `is_midia`, `caminho_midia`, `mensagem`, `data_envio`, `visualizado`) VALUES
(1, 2, 1, 0, '', 'Salveeee', NULL, 1),
(2, 2, 1, 0, '', 'Aooopaaa', NULL, 1),
(3, 2, 1, 1, './Img/Chat/Media/8cab20e9b282fb6abe98a2b83652058b.webp', '', NULL, 1),
(4, 1, 2, 0, '', 'epaa', NULL, 1),
(5, 1, 2, 0, '', 'Tudo sbem,', NULL, 1),
(6, 2, 1, 0, '', 'Teste', NULL, 1),
(7, 1, 2, 1, './Img/Chat/Media/d53b25200a27de9df1e4f498571ccb8e.webp', '', NULL, 1),
(8, 2, 1, 1, './Img/Chat/Media/c790ca0fb21fad02315bde027b2794c8.webp', '', NULL, 1),
(9, 2, 1, 1, './Img/Chat/Media/f81efb459ef29e950a3e0f3a47578563.webp', '', NULL, 1),
(10, 1, 2, 0, '', 'oieeee', NULL, 1),
(11, 2, 1, 0, '', 'hihihihi', NULL, 1),
(12, 1, 2, 0, '', 'Oieeeeeee', NULL, 1),
(13, 1, 2, 0, '', 'KKKKKKKKKKKKKKKKK', NULL, 1),
(14, 1, 2, 1, './Img/Chat/Media/114d0d1d51e09e60c82bf8222d79cddd.webp', '', NULL, 1),
(15, 2, 1, 0, '', 'Bom dia, tudo bem:', NULL, 1),
(16, 2, 1, 0, '', 'Bom dia tudo bem?', NULL, 1),
(17, 1, 2, 0, '', 'Bom dia, tudo bem e com você?', NULL, 1),
(18, 2, 1, 0, '', 'Tudo bem também', NULL, 1),
(19, 2, 1, 0, '', 'Gostaria de saber quais são os benefícios que você oferece? ', NULL, 1),
(20, 2, 1, 0, '', 'oferece', NULL, 1),
(21, 2, 1, 0, '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', NULL, 1),
(22, 1, 2, 0, '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', NULL, 1),
(23, 1, 2, 0, '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', NULL, 1),
(24, 2, 1, 0, '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', NULL, 1),
(25, 1, 2, 1, './Img/Chat/Media/8a50b602aa79b19775c22d02a290f51f.webp', '', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empregado`
--

CREATE TABLE `empregado` (
  `id_usuario` int(11) NOT NULL,
  `escolaridade` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_atuacao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `empregado`
--

INSERT INTO `empregado` (`id_usuario`, `escolaridade`, `area_atuacao`, `nota`) VALUES
(1, 'Superior - Completo', 'Banco de dados', NULL),
(2, 'Superior - Completo', 'Desenvolvedor Java', '4.2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `empregador`
--

CREATE TABLE `empregador` (
  `id_usuario` int(11) NOT NULL,
  `razao_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnpj` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nota` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `empregador`
--

INSERT INTO `empregador` (`id_usuario`, `razao_social`, `cnpj`, `nota`) VALUES
(1, 'FruitKeep', '22.222.222/2222-22', NULL),
(2, 'oioi', '22.222.222/2222-22', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(11) NOT NULL,
  `endereco` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complemento` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `endereco`, `cep`, `numero`, `complemento`, `estado`, `cidade`) VALUES
(1, 'Avenida Jornalista Maurício Sirotski Sobrinho', '97020-440', '354', 'Apt 701', 'RS', 'Santa Maria'),
(2, 'Avenida Jornalista Maurício Sirotski Sobrinho', '97020-440', '354', 'Ap 701', 'RS', 'Santa Maria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fotoservico`
--

CREATE TABLE `fotoservico` (
  `id_fotoservico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `caminho` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `fotoservico`
--

INSERT INTO `fotoservico` (`id_fotoservico`, `id_servico`, `caminho`) VALUES
(11, 4, 'Img/Servico/8a50b602aa79b19775c22d02a290f51f.webp'),
(12, 4, 'Img/Servico/9aa553551eb6c9834fece89331bd9880.webp');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nota_empregado`
--

CREATE TABLE `nota_empregado` (
  `id_nota_empregado` int(11) NOT NULL,
  `id_empregado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `nota_empregado`
--

INSERT INTO `nota_empregado` (`id_nota_empregado`, `id_empregado`, `id_usuario`, `nota`) VALUES
(1, 1, 1, '5.0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nota_servico`
--

CREATE TABLE `nota_servico` (
  `id_nota_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salario` decimal(7,2) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `status` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendente',
  `motivo` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deletado` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`id_servico`, `nome`, `descricao`, `salario`, `id_endereco`, `id_usuario`, `status`, `motivo`, `deletado`) VALUES
(4, 'Desenvolvedor', 'Desenvolvedor mobile na tecnologia Flutter', '3000.00', 1, 1, 'aceito', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nascimento` date NOT NULL,
  `telefone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL,
  `id_endereco` int(11) NOT NULL,
  `deletado` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `cpf`, `nascimento`, `telefone`, `email`, `senha`, `foto`, `admin`, `id_endereco`, `deletado`) VALUES
(1, 'Daniel Anesi', '038.144.950-55', '1999-03-28', '(55) 98138-4182', 'daniel.o.anesi@gmail.com', '202cb962ac59075b964b07152d234b70', 'Img/Perfil/7d6d9c835ae5d0170406e2999eceebe3.webp', 1, 1, 0),
(2, 'João Paulo', '346.567.445-76', '2021-07-20', '(45) 74575-4754', 'daniel.2017000850@aluno.iffar.edu.br', '202cb962ac59075b964b07152d234b70', 'Img/Perfil/163d8530bf2d27ab510bd41c7717a87b.webp', 0, 2, 0),
(3, 'ff', '463.464.575-47', '2021-08-16', '(46) 74576-5576', 'daniel.anesi@voalle.com.br', '202cb962ac59075b964b07152d234b70', 'Img/Perfil/default.png', 0, 0, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `chat_remetente` (`id_remetente`),
  ADD KEY `chat_destinatario` (`id_destinatario`);

--
-- Índices para tabela `empregado`
--
ALTER TABLE `empregado`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `empregador`
--
ALTER TABLE `empregador`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`);

--
-- Índices para tabela `fotoservico`
--
ALTER TABLE `fotoservico`
  ADD PRIMARY KEY (`id_fotoservico`),
  ADD KEY `fotoservico_servico` (`id_servico`);

--
-- Índices para tabela `nota_empregado`
--
ALTER TABLE `nota_empregado`
  ADD PRIMARY KEY (`id_nota_empregado`),
  ADD KEY `notaEmpregado_empregado` (`id_empregado`),
  ADD KEY `notaEmpregado_usuario` (`id_usuario`);

--
-- Índices para tabela `nota_servico`
--
ALTER TABLE `nota_servico`
  ADD PRIMARY KEY (`id_nota_servico`),
  ADD KEY `notaSservico_servico` (`id_servico`),
  ADD KEY `notaSmpregado_usuario` (`id_usuario`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `kf_servico_endereco` (`id_endereco`),
  ADD KEY `kf_servico_usuario` (`id_usuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `fotoservico`
--
ALTER TABLE `fotoservico`
  MODIFY `id_fotoservico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `nota_empregado`
--
ALTER TABLE `nota_empregado`
  MODIFY `id_nota_empregado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `nota_servico`
--
ALTER TABLE `nota_servico`
  MODIFY `id_nota_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_destinatario` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `chat_remetente` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `empregado`
--
ALTER TABLE `empregado`
  ADD CONSTRAINT `fk_empregado` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `empregador`
--
ALTER TABLE `empregador`
  ADD CONSTRAINT `fk_empregador` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `fotoservico`
--
ALTER TABLE `fotoservico`
  ADD CONSTRAINT `fotoservico_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`);

--
-- Limitadores para a tabela `nota_empregado`
--
ALTER TABLE `nota_empregado`
  ADD CONSTRAINT `notaEmpregado_empregado` FOREIGN KEY (`id_empregado`) REFERENCES `empregado` (`id_usuario`),
  ADD CONSTRAINT `notaEmpregado_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `nota_servico`
--
ALTER TABLE `nota_servico`
  ADD CONSTRAINT `notaSmpregado_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `notaSservico_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`);

--
-- Limitadores para a tabela `servico`
--
ALTER TABLE `servico`
  ADD CONSTRAINT `kf_servico_endereco` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id_endereco`),
  ADD CONSTRAINT `kf_servico_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
