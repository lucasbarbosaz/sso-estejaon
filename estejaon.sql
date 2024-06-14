-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.28-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para sso_db
CREATE DATABASE IF NOT EXISTS `sso_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `sso_db`;

-- Copiando estrutura para tabela sso_db.host
CREATE TABLE IF NOT EXISTS `host` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela sso_db.host: ~0 rows (aproximadamente)
INSERT INTO `host` (`id`, `url`, `created_at`) VALUES
	(1, '127.0.0.2', '2024-06-09 07:29:57'),
	(2, '127.0.0.3', '2024-06-09 18:57:39');

-- Copiando estrutura para tabela sso_db.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_navegador` varchar(50) DEFAULT NULL,
  `dados_ip` text DEFAULT NULL,
  `mensagem` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sso_db.logs: ~0 rows (aproximadamente)
INSERT INTO `logs` (`id`, `ip_navegador`, `dados_ip`, `mensagem`, `created_at`) VALUES
	(1, '::1', '{"status":"success","country":"Canada","countryCode":"CA","region":"QC","regionName":"Quebec","city":"Beauharnois","zip":"J6N","lat":45.3161,"lon":-73.8736,"timezone":"America/Toronto","isp":"OVH SAS","org":"OVH Hosting, Inc","as":"AS16276 OVH SAS","query":"54.39.68.110"}', 'Manipulou a url e tentou redirecionar para: google.com', '2024-06-09 21:02:45'),
	(2, '::1', '{"status":"fail","message":"reserved range","query":"::1"}', 'Manipulou a url e tentou redirecionar para: google.com.br', '2024-06-10 23:08:42');

-- Copiando estrutura para tabela sso_db.recuperasenha
CREATE TABLE IF NOT EXISTS `recuperasenha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `key` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `registro_ip` varchar(255) NOT NULL,
  `ultimo_ip` varchar(255) NOT NULL,
  `ativo` enum('0','1') NOT NULL DEFAULT '0',
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sso_db.recuperasenha: ~5 rows (aproximadamente)
INSERT INTO `recuperasenha` (`id`, `usuario_id`, `key`, `registro_ip`, `ultimo_ip`, `ativo`, `timestamp`) VALUES
	(20, 1, '7c59742bbd8ca62625489df93107aade8fe43cc3', '', '', '1', 1718168443),
	(21, 1, '660eda51a457ecf5bda29b23e2bae5139b51250f', '::1', '::1', '1', 1718174013),
	(22, 1, 'b31564ddb5266ccee4fd5012dc83d25cc634e84b', '::1', '::1', '0', 1718174539),
	(23, 1, 'e010ec77aa5a86f641b80e3f6f7a92cb2ee1b0fa', '::1', '::1', '0', 1718175389),
	(24, 1, '9cbf8ddf0a5b69a14308c3b28cef8bac4de848f9', '::1', '::1', '0', 1718175622),
	(25, 2, '8c28f3e3871a7c70859021384951156cfe360c6f', '::1', '::1', '0', 1718305920);

-- Copiando estrutura para tabela sso_db.token
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `access_token` tinytext NOT NULL,
  `usuario_id` int(9) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela sso_db.token: ~1 rows (aproximadamente)

-- Copiando estrutura para tabela sso_db.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `apelido` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `email_secundario` varchar(150) NOT NULL,
  `telefone` varchar(150) NOT NULL,
  `senha` varchar(150) NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` set('masculino','feminino','nao-binario','outro','prefiro-nao-dizer') NOT NULL DEFAULT '',
  `tipo_pessoa` enum('pf','pj') NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `cnpj` varchar(50) NOT NULL,
  `razao_social` text NOT NULL,
  `descricao_empresa` text NOT NULL,
  `ultimo_ip` varchar(150) NOT NULL,
  `registro_ip` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Copiando dados para a tabela sso_db.usuarios: ~1 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nome`, `apelido`, `email`, `email_secundario`, `telefone`, `senha`, `data_nascimento`, `genero`, `tipo_pessoa`, `cpf`, `cnpj`, `razao_social`, `descricao_empresa`, `ultimo_ip`, `registro_ip`, `created_at`) VALUES
	(2, 'Lucas Barbosa', '', 'lucashp03@gmail.com', '', '11954518251', '$2y$10$8.qXuI7OsnJLqhp30P6qqeapO9Up9gjt4G5xyQyjGiuONTD.uBGT2', '1998-01-23', 'masculino', 'pf', '158.393.224-07', '', '', '', '::1', '::1', '2024-06-13 04:45:17'),
	(3, 'Flavio Lucas', '', 'corplaxus@gmail.com', '', '11954518251', '$2y$10$Sol0mF4JsI3oXdhwdU4c1.djwwUoQne8nEm8HlAOtKPpcgBl7dhKi', '2003-01-23', 'masculino', 'pj', '', '12.528.708/0001-07', '', '', '::1', '::1', '2024-06-13 05:45:39'),
	(4, 'Google Chrome', '', 'chrome@gmail.com', '', '11954518251', '$2y$10$wYekwz30Im5F9BGlWfItPe9jdKJnOySV/TQ.M/pxu6/Mgd9u8t71a', '1998-01-23', 'masculino', 'pj', '', '06.947.283/0001-60', 'GOOGLE INTERNATIONAL LLC', 'Empresa Domiciliada no Exterior', '::1', '::1', '2024-06-13 07:17:19');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
