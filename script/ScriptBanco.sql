-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para vendebem
DROP DATABASE IF EXISTS `vendebem`;
CREATE DATABASE IF NOT EXISTS `vendebem` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `vendebem`;

-- Copiando estrutura para tabela vendebem.carrinho
DROP TABLE IF EXISTS `carrinho`;
CREATE TABLE IF NOT EXISTS `carrinho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.carrinho: ~0 rows (aproximadamente)
DELETE FROM `carrinho`;

-- Copiando estrutura para tabela vendebem.clientes
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `telefone1` varchar(20) DEFAULT NULL,
  `telefone2` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT 'cliente',
  `cadastro_completo` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.clientes: ~5 rows (aproximadamente)
DELETE FROM `clientes`;
INSERT INTO `clientes` (`id`, `cpf`, `nome`, `endereco`, `bairro`, `cidade`, `uf`, `cep`, `telefone1`, `telefone2`, `email`, `senha`, `tipo`, `cadastro_completo`) VALUES
	(1, '11002950899', 'Alexandre Cardoso', 'Avenida dos costas, 750', 'Jd. Residencial Palmeiras', 'Rio Claro', 'SP', '13502-100', '19996240603', '19996240603', 'alexdcbr@gmail.com', '$2y$12$SkzaAZK5u7dHy.iSCeLAgua/EUK5DHlG.ON3AQksCGwTQPiLk.V1a', 'admin', 0),
	(2, '66451291811', 'Evelyn Sophia Araújo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'evelyn.sophia.araujo@com.br', '$2y$12$2Vt6djpbiHr.68T8opJfLO44K17a4o7G0wutnkyFjuVVX6TJtyQui', 'cliente', 0),
	(3, '52522858882', 'Antonio Antonio Bruno Lima', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$NAGcereKCFx3FjuTRMZYhu1Bv2qhwwxhCRymWUuxQVEMXwUiFDeBy', 'cliente', 0),
	(4, '57066542800', 'Bernardo Bryan Antonio Barbosa', 'Avenida 3 JN', NULL, NULL, NULL, NULL, '1927255457', NULL, 'bernardobryanbarbosa@construtoraplaneta.com.br', '$2y$12$9MCipdJVm8hAryJeyXsjR.GdW500PJ/PRvacp08DAIIBw9SYQx/9K', 'cliente', 1),
	(5, '64731115817', 'Thomas Márcio Sales', 'Rua 2 MP', NULL, NULL, NULL, NULL, '1925138037', NULL, 'thomasmarciosales@valeparaibano.com.br', '$2y$12$2g2yam6m7ISI4jc46ZpX2OhqckkBB2qlonLrYJkou2XlaBPNTKLNi', 'cliente', 1);

-- Copiando estrutura para tabela vendebem.fornecedores
DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(18) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `telefone1` varchar(20) DEFAULT NULL,
  `telefone2` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cnpj` (`cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.fornecedores: ~0 rows (aproximadamente)
DELETE FROM `fornecedores`;
INSERT INTO `fornecedores` (`id`, `cnpj`, `nome`, `endereco`, `bairro`, `cidade`, `uf`, `cep`, `telefone1`, `telefone2`, `email`) VALUES
	(1, '33.787.222/0001-55', 'Jennifer e Carolina Telas ME', 'Rua Willy Legner', 'Jardim Temporim', 'Ferraz de Vasconcelos', 'SP', '08544-180', '(11) 2811-2605', '(11) 99263-9669', 'cobranca@jenniferecarolinatelasme.com.br');

-- Copiando estrutura para tabela vendebem.itens_pedido
DROP TABLE IF EXISTS `itens_pedido`;
CREATE TABLE IF NOT EXISTS `itens_pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.itens_pedido: ~0 rows (aproximadamente)
DELETE FROM `itens_pedido`;
INSERT INTO `itens_pedido` (`id`, `pedido_id`, `produto_id`, `quantidade`, `valor`) VALUES
	(1, 1, 2, 1, 560.00);

-- Copiando estrutura para tabela vendebem.itens_venda
DROP TABLE IF EXISTS `itens_venda`;
CREATE TABLE IF NOT EXISTS `itens_venda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `venda_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `venda_id` (`venda_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`id`),
  CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.itens_venda: ~18 rows (aproximadamente)
DELETE FROM `itens_venda`;
INSERT INTO `itens_venda` (`id`, `venda_id`, `produto_id`, `quantidade`, `valor`) VALUES
	(2, 2, 1, 4, 150.00),
	(4, 1, 1, 1, 150.00),
	(5, 4, 1, 2, 150.00),
	(7, 5, 2, 2, 560.00),
	(8, 7, 2, 1, 560.00),
	(9, 8, 2, 1, 109.90),
	(10, 9, 4, 1, 139.04),
	(11, 9, 2, 1, 109.90),
	(12, 10, 2, 1, 109.90),
	(13, 10, 4, 2, 139.04),
	(14, 11, 1, 1, 150.00),
	(15, 11, 4, 1, 139.04),
	(16, 12, 4, 1, 139.04),
	(17, 13, 4, 1, 139.04),
	(18, 13, 1, 1, 150.00),
	(19, 15, 4, 1, 139.04),
	(20, 16, 2, 1, 109.90),
	(21, 16, 4, 1, 139.04);

-- Copiando estrutura para tabela vendebem.pedidos
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fornecedor_id` int DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fornecedor_id` (`fornecedor_id`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.pedidos: ~0 rows (aproximadamente)
DELETE FROM `pedidos`;
INSERT INTO `pedidos` (`id`, `fornecedor_id`, `data`, `usuario`) VALUES
	(1, 1, '2026-04-12 10:56:14', NULL);

-- Copiando estrutura para tabela vendebem.produtos
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nome` varchar(255) NOT NULL,
  `estoque` int DEFAULT '0',
  `estoque_minimo` int DEFAULT '0',
  `estoque_maximo` int DEFAULT '0',
  `valor` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.produtos: ~3 rows (aproximadamente)
DELETE FROM `produtos`;
INSERT INTO `produtos` (`id`, `codigo`, `nome`, `estoque`, `estoque_minimo`, `estoque_maximo`, `valor`, `imagem`) VALUES
	(1, NULL, 'Teste de cadastro1', 1, 0, 0, 150.00, NULL),
	(2, NULL, 'Escova Secadora Mondial ES-02-BI 1200W 3 Níveis de Temperatura Tourmaline Íon', 4, 0, 0, 109.90, '1776006632_Escova_Cabelo.png'),
	(4, NULL, 'Kit Teclado E Mouse Logitech Mk220 Sem Fio Preto Abnt2', 5, 0, 0, 139.04, '1776004788_kit_teclado_mouse.png');

-- Copiando estrutura para tabela vendebem.vendas
DROP TABLE IF EXISTS `vendas`;
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'aberta',
  `pagamento` varchar(50) DEFAULT NULL,
  `status_pagamento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela vendebem.vendas: ~14 rows (aproximadamente)
DELETE FROM `vendas`;
INSERT INTO `vendas` (`id`, `cliente_id`, `data`, `usuario`, `status`, `pagamento`, `status_pagamento`) VALUES
	(1, 1, '2026-04-12 10:56:41', NULL, 'finalizada', NULL, NULL),
	(2, 1, '2026-04-12 10:58:35', NULL, 'finalizada', NULL, NULL),
	(3, 1, '2026-04-12 13:41:58', NULL, 'aberta', NULL, NULL),
	(4, 1, '2026-04-12 13:46:18', NULL, 'finalizada', NULL, NULL),
	(5, 1, '2026-04-12 13:58:43', NULL, 'finalizada', NULL, NULL),
	(6, 1, '2026-04-12 14:20:47', NULL, 'aberta', NULL, NULL),
	(7, 1, '2026-04-12 14:27:12', NULL, 'finalizada', NULL, NULL),
	(8, 1, '2026-04-12 12:18:16', NULL, 'finalizada', NULL, NULL),
	(9, 1, '2026-04-12 12:29:13', NULL, 'finalizada', NULL, NULL),
	(10, 1, '2026-04-12 12:30:30', NULL, 'finalizada', NULL, NULL),
	(11, 1, '2026-04-12 12:43:40', NULL, 'finalizada', NULL, NULL),
	(12, 1, '2026-04-12 12:50:27', NULL, 'finalizada', 'pix', 'aprovado'),
	(13, 1, '2026-04-12 12:50:58', NULL, 'finalizada', 'cartao', 'aprovado'),
	(14, 1, '2026-04-12 15:53:02', NULL, 'aberta', NULL, NULL),
	(15, 1, '2026-04-12 13:01:10', NULL, 'finalizada', 'cartao', 'aprovado'),
	(16, 1, '2026-04-12 15:15:15', NULL, 'finalizada', 'cartao', 'aprovado');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
