-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 17/04/2020 às 16:51
-- Versão do servidor: 10.3.22-MariaDB-0+deb10u1
-- Versão do PHP: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mercado2`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_carrinho` (`id_carrinho` INTEGER)  BEGIN

	DELETE FROM vendas WHERE carrinho_id = id_carrinho;
	
	DELETE FROM carrinhos WHERE id = id_carrinho;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_produto` (`cod_produto` INTEGER)  BEGIN

	DELETE FROM produtos WHERE codigo = cod_produto;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_venda` (`id_carrinho` INTEGER, `cod_produto` INTEGER)  BEGIN

	SET @unidades = (SELECT unidades FROM vendas WHERE carrinho_id = id_carrinho AND produto_codigo = cod_produto); 

	UPDATE produtos SET estoque = estoque + @unidades WHERE codigo = cod_produto;
	
	DELETE FROM vendas WHERE carrinho_id = id_carrinho AND produto_codigo = cod_produto;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fechar_carrinho` (`id_carrinho` INTEGER)  BEGIN

	UPDATE carrinhos SET status_carrinho = "Finalizado" WHERE id = id_carrinho;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_mercado` (`par_nome` VARCHAR(50), `par_email` VARCHAR(30), `par_endereco` VARCHAR(100), `par_cnpj` VARCHAR(11), `par_fone` VARCHAR(13), `par_zap` VARCHAR(13), `par_admin_id` INTEGER)  BEGIN

	INSERT INTO estabelecimentos(nome, email, endereco, cnpj, fone, zap, admin_id, dt_criacao, dt_atualizacao)
		VALUES(par_nome, par_email, par_endereco, par_cnpj, par_fone, par_zap, par_admin_id, NOW(), NOW());

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_produto` (`nome_produto` VARCHAR(50), `id_categoria` INTEGER, `preco_custo` DOUBLE, `preco_venda` DOUBLE, `estoque_produto` INTEGER)  BEGIN

	INSERT INTO produtos(nome, categoria_id, pvenda, pcusto, estoque)
			VALUES(nome_produto, id_categoria, preco_venda, preco_custo, estoque_produto);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user` (`par_nome` VARCHAR(100), `par_email` VARCHAR(30), `par_user_name` VARCHAR(30), `par_passwd` VARCHAR(32), `par_fone` VARCHAR(14), `par_zap` VARCHAR(14), `par_tipo_id` INTEGER)  BEGIN

	INSERT INTO users(nome, email, user_name, passwd, fone, zap, tipo_id, dt_criacao, dt_atualizacao)
		VALUES(par_nome, par_email, par_user_name, par_passwd, par_fone, par_zap, par_tipo_id, NOW(), NOW());

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `novo_carrinho` ()  BEGIN

	INSERT INTO carrinhos(status_carrinho, dt_criacao)
		VALUES("Em andamento", NOW());
		
	SET @id_carrinho = (SELECT MAX(id) FROM carrinhos);
	
	SELECT CONCAT("Id do carrinho: ", @id_carrinho) AS MSG;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_venda` (IN `id_carrinho` INT, IN `cod_produto` INT, IN `quantidade` INT)  BEGIN

	SET @carrinho_status = (SELECT status_carrinho FROM carrinhos WHERE id = id_carrinho);
	
	IF(@carrinho_status = "Em andamento")THEN
	
		SET @carrinho_valido = 1;
		
	ELSE
	
		SET @carrinho_valido = 0;
		
		SELECT "Erro, este carrinho já está finalizado!" AS MSG;
		
	END IF;

	SET @produto_estoque = (SELECT estoque FROM produtos WHERE codigo = cod_produto);
		
	IF(quantidade <= @produto_estoque)THEN
		
		SET @quantidade_valida = 1;
		
	ELSE
		
		SET @quantidade_valida = 0;
			
		SELECT "Erro, quantidade maior que o estoque disponível!" AS MSG;
		
	END IF;
	
	IF(@quantidade_valida AND @carrinho_valido)THEN
	
		SET @nome_produto = (SELECT nome FROM produtos WHERE codigo = cod_produto);
	
		SET @venda_id = (SELECT id FROM vendas WHERE produto_nome = @nome_produto AND carrinho_id = id_carrinho);
		
		IF(@venda_id)THEN
		
			UPDATE vendas SET unidades = unidades + quantidade WHERE id = @venda_id;
		
		ELSE
		
			SET @id_categoria = (SELECT categoria_id FROM produtos WHERE codigo = cod_produto);
		
			SET @nome_categoria = (SELECT nome FROM categorias WHERE id = @id_categoria);
		
			SET @pvenda = (SELECT pvenda FROM produtos WHERE codigo = cod_produto);
		
			SET @pcusto = (SELECT pcusto FROM produtos WHERE codigo = cod_produto);
		
			INSERT INTO vendas(produto_codigo, produto_nome, categoria_nome, pvenda, pcusto, unidades, carrinho_id, dt_criacao)
				VALUES(cod_produto, @nome_produto, @nome_categoria, @pvenda, @pcusto, quantidade, id_carrinho, NOW());
					
		END IF;
		
			UPDATE produtos SET estoque = estoque - quantidade WHERE codigo = cod_produto;
		
			SELECT CONCAT("Venda de ", quantidade," unidade(s) do produto ", @nome_produto, " registrada com sucesso!") AS MSG;

	ELSE
	
		SELECT "Erro ao registrar venda!" AS MSG;
	
	END IF; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_produto` (IN `cod_produto` INT, IN `nome_produto` VARCHAR(50), IN `id_categoria` INT, IN `preco_custo` DOUBLE, IN `preco_venda` DOUBLE, IN `estoque_produto` INT)  BEGIN

	UPDATE produtos SET nome = nome_produto, categoria_id = id_categoria, pvenda = preco_venda, pcusto = preco_custo, estoque = estoque_produto WHERE codigo = cod_produto;

END$$

--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `count_produtos` (`id_carrinho` INTEGER) RETURNS INT(11) RETURN (SELECT SUM(unidades) FROM vendas WHERE carrinho_id = id_carrinho)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `status_venda` (`id_carrinho` INTEGER) RETURNS VARCHAR(10) CHARSET utf8 BEGIN

    SET @carrinho_status = (SELECT status_carrinho FROM carrinhos WHERE id = id_carrinho);

    IF(@carrinho_status = "Em andamento")THEN

        SET @retorno = "Não pago";

    END IF;

    IF(@carrinho_status = "Finalizado")THEN

        SET @retorno = "Pago";

    END IF;

    RETURN @retorno;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total` (`id_carrinho` INTEGER) RETURNS DOUBLE BEGIN

	SET @valor_total = (SELECT SUM(unidades * pvenda) FROM vendas WHERE carrinho_id = id_carrinho);

	RETURN @valor_total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinhos`
--

CREATE TABLE `carrinhos` (
  `id` int(11) NOT NULL,
  `status_carrinho` varchar(15) DEFAULT NULL,
  `dt_criacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id`, `status_carrinho`, `dt_criacao`) VALUES
(1, 'Finalizado', '2020-03-05 00:00:00'),
(2, 'Finalizado', '2020-04-04 14:30:00'),
(3, 'Finalizado', '2020-04-13 15:38:09'),
(4, 'Finalizado', '2020-04-13 15:40:03'),
(5, 'Finalizado', '2020-04-13 16:00:21'),
(6, 'Finalizado', '2020-04-13 16:21:23'),
(7, 'Finalizado', '2020-04-13 16:23:37'),
(8, 'Finalizado', '2020-04-13 16:41:11'),
(11, 'Em andamento', '2020-04-13 17:26:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Alimentos'),
(2, 'Bebidas'),
(3, 'Higiene'),
(4, 'Limpeza');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estabelecimentos`
--

CREATE TABLE `estabelecimentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(70) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `fone` varchar(11) DEFAULT NULL,
  `zap` varchar(11) DEFAULT NULL,
  `cnpj` varchar(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `dt_criacao` datetime DEFAULT NULL,
  `dt_atualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `estabelecimentos`
--

INSERT INTO `estabelecimentos` (`id`, `nome`, `email`, `endereco`, `fone`, `zap`, `cnpj`, `admin_id`, `dt_criacao`, `dt_atualizacao`) VALUES
(12, 'Mateus Supermercados', 'mateus04@gmail.com', 'Av Guajajaras , São Cristovão n34', '98932439876', '98988233307', '76790123035', 52, '2020-04-17 16:33:52', '2020-04-17 16:33:52'),
(13, 'Mateus Supermercados', 'mateus09@gmail.com', 'Av Guajajaras , São Cristovão n34', '98932439876', '98988233307', '76790123033', 54, '2020-04-17 16:44:12', '2020-04-17 16:44:12');

-- --------------------------------------------------------

--
-- Estrutura para tabela `niveis`
--

CREATE TABLE `niveis` (
  `id` int(11) NOT NULL,
  `descricao` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `niveis`
--

INSERT INTO `niveis` (`id`, `descricao`) VALUES
(1, 'Root'),
(2, 'Administrador'),
(3, 'Comprador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `pcusto` double DEFAULT NULL,
  `pvenda` double DEFAULT NULL,
  `estoque` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `produtos`
--

INSERT INTO `produtos` (`codigo`, `nome`, `categoria_id`, `pcusto`, `pvenda`, `estoque`) VALUES
(1, 'Margarina', 1, 2, 4.5, 2),
(2, 'Óleo', 1, 1, 2, 0),
(3, 'Creme de Leite', 1, 1.25, 2.75, 0),
(5, 'Extrato de Tomate', 1, 1, 1.75, 0),
(6, 'Refrigerante', 2, 2, 3.75, 44),
(7, 'Água Mineral', 2, 0.9, 2, 1),
(8, 'Cerveja', 2, 2, 5, 11),
(9, 'Suco Pronto', 2, 2, 4.5, 0),
(10, 'Chá Pronto', 2, 1.25, 3, 0),
(11, 'Shampoo', 3, 2, 4.75, 2),
(12, 'Creme Dental', 3, 1, 2, 0),
(13, 'Desodorante', 3, 2.25, 4.5, 10),
(14, 'Sabonete', 3, 0.4, 1.25, 9),
(15, 'Papel Higiênico', 3, 0.5, 1.5, 0),
(16, 'Sabão em Pedra', 4, 0.75, 1.55, 8),
(17, 'Detergente Líquido', 4, 0.8, 1.85, 16),
(18, 'Amaciante', 4, 1.15, 3.25, 4),
(19, 'Água Sanitária', 4, 1, 2.35, 24),
(20, 'Esponja Sintética', 4, 0.5, 1.25, 17),
(21, 'Sardinha em Lata', 1, 1.25, 2.75, 11),
(22, 'Macarrão', 1, 0.8, 1.75, 17),
(23, 'Condicionador', 3, 2.15, 4.75, 25),
(24, 'Nescau', 2, 1, 2, 50),
(25, 'Sabonete Líquido', 3, 1.1, 2.5, 21);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `passwd` varchar(32) DEFAULT NULL,
  `fone` varchar(14) DEFAULT NULL,
  `zap` varchar(14) DEFAULT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `dt_criacao` datetime DEFAULT NULL,
  `dt_atualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `user_name`, `passwd`, `fone`, `zap`, `tipo_id`, `dt_criacao`, `dt_atualizacao`) VALUES
(52, 'Renato Rodrigues', 'rodriguesrenato61@gmail.com', 'rodriguesrenato61', '202cb962ac59075b964b07152d234b70', '98988258639', '98999812283', 2, '2020-04-17 15:33:22', '2020-04-17 15:33:22'),
(53, 'Renato Rodrigues', 'rodriguesrenato80@gmail.com', 'rodriguesrenato61', '202cb962ac59075b964b07152d234b70', '98988258639', '98999812283', 3, '2020-04-17 16:36:12', '2020-04-17 16:36:12'),
(54, 'Renato Rodrigues', 'rodriguesrenato69@gmail.com', 'rodriguesrenato61', '202cb962ac59075b964b07152d234b70', '98988258639', '98999812283', 2, '2020-04-17 16:43:47', '2020-04-17 16:43:47');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `produto_nome` varchar(50) DEFAULT NULL,
  `categoria_nome` varchar(30) DEFAULT NULL,
  `carrinho_id` int(11) DEFAULT NULL,
  `pvenda` double DEFAULT NULL,
  `pcusto` double DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `dt_criacao` datetime DEFAULT NULL,
  `produto_codigo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `vendas`
--

INSERT INTO `vendas` (`id`, `produto_nome`, `categoria_nome`, `carrinho_id`, `pvenda`, `pcusto`, `unidades`, `dt_criacao`, `produto_codigo`) VALUES
(94, 'Suco Pronto', 'Bebidas', 2, 4.5, 2, 2, '2020-04-09 11:01:52', 9),
(95, 'Chá Pronto', 'Bebidas', 2, 3, 1.25, 6, '2020-04-09 11:02:02', 10),
(96, 'Shampoo', 'Higiene', 2, 4.75, 2, 2, '2020-04-09 11:13:00', 11),
(97, 'Creme Dental', 'Higiene', 2, 2, 1, 4, '2020-04-09 11:13:32', 12),
(98, 'Papel Higiênico', 'Higiene', 2, 1.5, 0.5, 1, '2020-04-09 11:20:12', 15),
(99, 'Sabão em Pedra', 'Limpeza', 2, 1.55, 0.75, 2, '2020-04-09 11:56:42', 16),
(100, 'Extrato de Tomate', 'Alimentos', 2, 1.75, 1, 4, '2020-04-09 12:14:23', 5),
(102, 'Sabonete Líquido', 'Higiene', 2, 2.5, 1.1, 2, '2020-04-12 21:12:05', 25),
(103, 'Extrato de Tomate', 'Alimentos', 4, 1.75, 1, 3, '2020-04-13 15:40:15', 5),
(104, 'Suco Pronto', 'Bebidas', 4, 4.5, 2, 4, '2020-04-13 15:40:31', 9),
(105, 'Margarina', 'Alimentos', 4, 4.5, 2, 4, '2020-04-13 15:40:40', 1),
(107, 'Extrato de Tomate', 'Alimentos', 3, 1.75, 1, 2, '2020-04-13 16:13:24', 5),
(108, 'Refrigerante', 'Bebidas', 1, 3.75, 2, 4, '2020-04-13 16:21:09', 6),
(109, 'Extrato de Tomate', 'Alimentos', 6, 1.75, 1, 2, '2020-04-13 16:21:41', 5),
(110, 'Cerveja', 'Bebidas', 6, 5, 2, 3, '2020-04-13 16:21:48', 8),
(111, 'Margarina', 'Alimentos', 6, 4.5, 2, 1, '2020-04-13 16:21:54', 1),
(112, 'Suco Pronto', 'Bebidas', 6, 4.5, 2, 2, '2020-04-13 16:22:11', 9),
(113, 'Creme Dental', 'Higiene', 6, 2, 1, 2, '2020-04-13 16:22:22', 12),
(114, 'Água Mineral', 'Bebidas', 7, 2, 0.9, 1, '2020-04-13 16:24:09', 7),
(115, 'Suco Pronto', 'Bebidas', 7, 4.5, 2, 2, '2020-04-13 16:24:25', 9),
(116, 'Água Mineral', 'Bebidas', 5, 2, 0.9, 2, '2020-04-13 16:41:03', 7),
(117, 'Creme Dental', 'Higiene', 8, 2, 1, 2, '2020-04-13 16:41:25', 12),
(118, 'Suco Pronto', 'Bebidas', 8, 4.5, 2, 2, '2020-04-13 16:45:41', 9),
(119, 'Sabão em Pedra', 'Limpeza', 8, 1.55, 0.75, 4, '2020-04-13 16:45:51', 16),
(120, 'Chá Pronto', 'Bebidas', 8, 3, 1.25, 1, '2020-04-13 16:46:05', 10),
(121, 'Sardinha em Lata', 'Alimentos', 8, 2.75, 1.25, 4, '2020-04-13 16:46:18', 21),
(124, 'Suco Pronto', 'Bebidas', 11, 4.5, 2, 1, '2020-04-13 17:27:27', 9),
(125, 'Sabão em Pedra', 'Limpeza', 11, 1.55, 0.75, 3, '2020-04-13 17:27:36', 16),
(127, 'Desodorante', 'Higiene', 11, 4.5, 2.25, 3, '2020-04-13 17:28:06', 13),
(128, 'Amaciante', 'Limpeza', 11, 3.25, 1.15, 5, '2020-04-13 17:28:19', 18),
(129, 'Sabonete', 'Higiene', 11, 1.25, 0.4, 3, '2020-04-14 13:58:17', 14);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_carrinhos`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_carrinhos` (
`id` int(11)
,`produtos` int(11)
,`status_carrinho` varchar(15)
,`total_compra` double
,`dia` varchar(10)
,`hora` time
,`dt` date
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_mercados`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_mercados` (
`id` int(11)
,`mercado` varchar(70)
,`email` varchar(30)
,`endereco` varchar(100)
,`cnpj` varchar(11)
,`fone` varchar(11)
,`zap` varchar(11)
,`admin_id` int(11)
,`admninistrador` varchar(100)
,`admin` varchar(30)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_produtos`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_produtos` (
`codigo` int(11)
,`produto` varchar(50)
,`categoria_id` int(11)
,`categoria` varchar(30)
,`pcusto` double
,`pvenda` double
,`estoque` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_vendas`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_vendas` (
`id` int(11)
,`codigo` int(11)
,`produto` varchar(50)
,`categoria` varchar(30)
,`carrinho_id` int(11)
,`pvenda` double
,`pcusto` double
,`unidades` int(11)
,`total_custo` double
,`total_venda` double
,`lucro` double
,`venda_status` varchar(10)
,`data_venda` date
,`dia` varchar(10)
,`hora` time
,`dt_criacao` datetime
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_carrinhos`
--
DROP TABLE IF EXISTS `vw_carrinhos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_carrinhos`  AS  select `carrinhos`.`id` AS `id`,`count_produtos`(`carrinhos`.`id`) AS `produtos`,`carrinhos`.`status_carrinho` AS `status_carrinho`,`total`(`carrinhos`.`id`) AS `total_compra`,date_format(`carrinhos`.`dt_criacao`,'%d/%m/%Y') AS `dia`,cast(`carrinhos`.`dt_criacao` as time) AS `hora`,cast(`carrinhos`.`dt_criacao` as date) AS `dt` from `carrinhos` ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_mercados`
--
DROP TABLE IF EXISTS `vw_mercados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_mercados`  AS  select `estabelecimentos`.`id` AS `id`,`estabelecimentos`.`nome` AS `mercado`,`estabelecimentos`.`email` AS `email`,`estabelecimentos`.`endereco` AS `endereco`,`estabelecimentos`.`cnpj` AS `cnpj`,`estabelecimentos`.`fone` AS `fone`,`estabelecimentos`.`zap` AS `zap`,`estabelecimentos`.`admin_id` AS `admin_id`,`users`.`nome` AS `admninistrador`,`users`.`user_name` AS `admin` from (`estabelecimentos` join `users` on(`estabelecimentos`.`admin_id` = `users`.`id`)) ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_produtos`
--
DROP TABLE IF EXISTS `vw_produtos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_produtos`  AS  select `produtos`.`codigo` AS `codigo`,`produtos`.`nome` AS `produto`,`produtos`.`categoria_id` AS `categoria_id`,`categorias`.`nome` AS `categoria`,`produtos`.`pcusto` AS `pcusto`,`produtos`.`pvenda` AS `pvenda`,`produtos`.`estoque` AS `estoque` from (`produtos` join `categorias` on(`produtos`.`categoria_id` = `categorias`.`id`)) ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_vendas`
--
DROP TABLE IF EXISTS `vw_vendas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_vendas`  AS  select `vendas`.`id` AS `id`,`vendas`.`produto_codigo` AS `codigo`,`vendas`.`produto_nome` AS `produto`,`vendas`.`categoria_nome` AS `categoria`,`vendas`.`carrinho_id` AS `carrinho_id`,`vendas`.`pvenda` AS `pvenda`,`vendas`.`pcusto` AS `pcusto`,`vendas`.`unidades` AS `unidades`,`vendas`.`unidades` * `vendas`.`pcusto` AS `total_custo`,`vendas`.`unidades` * `vendas`.`pvenda` AS `total_venda`,`vendas`.`unidades` * `vendas`.`pvenda` - `vendas`.`unidades` * `vendas`.`pcusto` AS `lucro`,`status_venda`(`vendas`.`carrinho_id`) AS `venda_status`,cast(`vendas`.`dt_criacao` as date) AS `data_venda`,date_format(`vendas`.`dt_criacao`,'%d/%m/%Y') AS `dia`,cast(`vendas`.`dt_criacao` as time) AS `hora`,`vendas`.`dt_criacao` AS `dt_criacao` from `vendas` ;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Índices de tabela `niveis`
--
ALTER TABLE `niveis`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de tabela `niveis`
--
ALTER TABLE `niveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  ADD CONSTRAINT `estabelecimentos_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `niveis` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
