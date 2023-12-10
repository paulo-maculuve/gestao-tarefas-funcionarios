-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 06:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestao_tarefas_funcionario`
--

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `nome_lider` varchar(90) NOT NULL,
  `nome_departamento` varchar(90) NOT NULL,
  `numero_funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`id`, `avatar`, `nome_lider`, `nome_departamento`, `numero_funcionario`) VALUES
(1, '1700059409.', 'Paulo Maculuve', 'Dev Studio', 15),
(11, '1700262909.', 'Arlindo', 'admin de sistem', 10),
(12, '1700293670.', 'Arlindo', 'marketing', 100),

-- --------------------------------------------------------

--
-- Table structure for table `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `departamento` varchar(40) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funcionario`
--

INSERT INTO `funcionario` (`id`, `nome`, `telefone`, `cargo`, `departamento`, `avatar`) VALUES
(1, 'Samuel Jossias', '258845522345', 'diretor pedagogico', 'Dev Studio', '1700585210.avatar4.jpg'),
(8, 'Valdinancio Aurelio', '84556697980', 'docencia', 'Dev Studio', '1700302484.avatar4.jpg'),
(10, 'Ana', '84556697980', 'lider', 'Dev Studio', '1700585143.avatar2.jpg'),
(12, 'Valdinancio', '84556697980', 'Auxiliar', 'Dev Studio', '1700585711.avatar4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `inicio` date NOT NULL,
  `prazo` date NOT NULL,
  `prioridade` varchar(40) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `id_funcionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tarefas`
--

INSERT INTO `tarefas` (`id`, `descricao`, `inicio`, `prazo`, `prioridade`, `estado`, `id_funcionario`) VALUES
(4, 'gerenciamento de um projecto', '2024-05-19', '2025-05-19', 'Urgente', 'Completo', 1),
(5, 'Avaliar o trabalho de estudantes', '2023-11-18', '2024-11-18', 'Urgente', 'Em Progresso', 8),
(8, 'fffff', '0005-05-04', '0045-04-06', 'Baixa', 'Em Progresso', 8);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

-- INSERT INTO `usuarios` (`id`, `nome`, `email`, `password`) VALUES
-- (1, 'Elisabete Chabana', 'elisabete@dev.com', 'fcea920f7412b5da7be0cf42b8c93759'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tarefa_funcionario` (`id_funcionario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `fk_tarefa_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
