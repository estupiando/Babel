-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Fev-2025 às 21:44
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca_virtual`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE `atividades` (
  `ID_Atividade` int(11) NOT NULL,
  `Descricao` text NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Tipo` enum('leitura','envio_mensagem','upload_material','outro') NOT NULL,
  `Data_Atividade` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `ID_Comentario` int(11) NOT NULL,
  `Comentario` text NOT NULL,
  `Data_Comentario` datetime DEFAULT current_timestamp(),
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Material` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `materiais_didaticos`
--

CREATE TABLE `materiais_didaticos` (
  `ID_Material` int(11) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Descricao` text DEFAULT NULL,
  `Data_Upload` datetime DEFAULT current_timestamp(),
  `Tipo` enum('PDF','Vídeo','Áudio','Outro') NOT NULL,
  `Arquivo` varchar(255) NOT NULL,
  `ID_Professor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `ID_Mensagem` int(11) NOT NULL,
  `Mensagem` text NOT NULL,
  `Data_Mensagem` datetime DEFAULT current_timestamp(),
  `ID_Usuario_Envia` int(11) DEFAULT NULL,
  `ID_Usuario_Recebe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `ID_Notificacao` int(11) NOT NULL,
  `Mensagem` text NOT NULL,
  `Data_Envio` datetime DEFAULT current_timestamp(),
  `ID_Usuario` int(11) DEFAULT NULL,
  `Status` enum('lida','não lida') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfis_usuarios`
--

CREATE TABLE `perfis_usuarios` (
  `ID_Perfil` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Foto_Perfil` varchar(255) DEFAULT NULL,
  `Informacoes_Adicionais` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorios`
--

CREATE TABLE `relatorios` (
  `ID_Relatorio` int(11) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Descricao` text DEFAULT NULL,
  `Data_Geracao` datetime DEFAULT current_timestamp(),
  `ID_Administrador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Senha` varchar(255) NOT NULL,
  `Tipo_Usuario` enum('administrador','professor','aluno') NOT NULL,
  `Data_Cadastro` datetime DEFAULT current_timestamp(),
  `Status` enum('ativo','inativo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE notificacoes (
    ID_Notificacao INT AUTO_INCREMENT PRIMARY KEY,
    Mensagem TEXT NOT NULL,
    Data_Envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    ID_Usuario INT NULL,
    Status ENUM('lida', 'não lida') NOT NULL DEFAULT 'não lida',
    FOREIGN KEY (ID_Usuario) REFERENCES usuarios(ID_Usuario) ON DELETE CASCADE
);


--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Nome`, `Email`, `Senha`, `Tipo_Usuario`, `Data_Cadastro`, `Status`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$VgZ2jvADXcok5YsW0qvBluiKuzG9ENobhErzRRxgiTlGCNFnLlFme', 'administrador', '2025-02-19 20:10:50', 'ativo');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`ID_Atividade`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Índices para tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ID_Comentario`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Material` (`ID_Material`);

--
-- Índices para tabela `materiais_didaticos`
--
ALTER TABLE `materiais_didaticos`
  ADD PRIMARY KEY (`ID_Material`),
  ADD KEY `ID_Professor` (`ID_Professor`);

--
-- Índices para tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`ID_Mensagem`),
  ADD KEY `ID_Usuario_Envia` (`ID_Usuario_Envia`),
  ADD KEY `ID_Usuario_Recebe` (`ID_Usuario_Recebe`);

--
-- Índices para tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`ID_Notificacao`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Índices para tabela `perfis_usuarios`
--
ALTER TABLE `perfis_usuarios`
  ADD PRIMARY KEY (`ID_Perfil`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Índices para tabela `relatorios`
--
ALTER TABLE `relatorios`
  ADD PRIMARY KEY (`ID_Relatorio`),
  ADD KEY `ID_Administrador` (`ID_Administrador`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atividades`
--
ALTER TABLE `atividades`
  MODIFY `ID_Atividade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID_Comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materiais_didaticos`
--
ALTER TABLE `materiais_didaticos`
  MODIFY `ID_Material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `ID_Mensagem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `ID_Notificacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perfis_usuarios`
--
ALTER TABLE `perfis_usuarios`
  MODIFY `ID_Perfil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `relatorios`
--
ALTER TABLE `relatorios`
  MODIFY `ID_Relatorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atividades`
--
ALTER TABLE `atividades`
  ADD CONSTRAINT `fk_atividade_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_comentario_material` FOREIGN KEY (`ID_Material`) REFERENCES `materiais_didaticos` (`ID_Material`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentario_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `materiais_didaticos`
--
ALTER TABLE `materiais_didaticos`
  ADD CONSTRAINT `fk_material_professor` FOREIGN KEY (`ID_Professor`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD CONSTRAINT `fk_mensagem_usuario_envia` FOREIGN KEY (`ID_Usuario_Envia`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mensagem_usuario_recebe` FOREIGN KEY (`ID_Usuario_Recebe`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `fk_notificacao_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `perfis_usuarios`
--
ALTER TABLE `perfis_usuarios`
  ADD CONSTRAINT `fk_perfil_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `relatorios`
--
ALTER TABLE `relatorios`
  ADD CONSTRAINT `fk_relatorio_administrador` FOREIGN KEY (`ID_Administrador`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
