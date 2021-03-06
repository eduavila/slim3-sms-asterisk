# ************************************************************
# Sequel Pro SQL dump
# Vers�o 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Base de Dados: sms_aste
# Tempo de Gera��o: 2016-12-20 23:32:21 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela campanhas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campanhas`;

CREATE TABLE `campanhas` (
  `id_campanha_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_campanha` varchar(255) DEFAULT NULL,
  `modelo_id` int(11) DEFAULT NULL,
  `texto` text,
  PRIMARY KEY (`id_campanha_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

LOCK TABLES `campanhas` WRITE;
/*!40000 ALTER TABLE `campanhas` DISABLE KEYS */;

INSERT INTO `campanhas` (`id_campanha_id`, `nome_campanha`, `modelo_id`, `texto`)
VALUES
	(1,'teste',NULL,'#NOME# FELIZ NATAL'),
	(2,'teste',NULL,'#NOME# FELIZ NATAL'),
	(3,'teste',NULL,'#NOME# FELIZ NATAL'),
	(4,'teste',NULL,'#NOME# FELIZ NATAL');

/*!40000 ALTER TABLE `campanhas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id_config_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `interface` varchar(255) DEFAULT NULL,
  `qtd_sms_por_dia` int(11) DEFAULT NULL,
  `hora_envio_inicio` time DEFAULT NULL,
  `hora_envio_fim` time DEFAULT NULL,
  PRIMARY KEY (`id_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump da tabela contatos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contatos`;

CREATE TABLE `contatos` (
  `id_contato_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_contato` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `obs` text,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_contato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

LOCK TABLES `contatos` WRITE;
/*!40000 ALTER TABLE `contatos` DISABLE KEYS */;

INSERT INTO `contatos` (`id_contato_id`, `nome_contato`, `numero`, `obs`, `email`)
VALUES
	(1,'Nome muito comprido mesmo muito mesmo mesmo mesmo','+55996376060','asdsadasdasdasdas','teste@teste.com.br'),
	(2,'Teste','+55996376060','asdsadasdasdasdas','teste@teste.com.br'),
	(3,'Teste','+55996376062','asdsadasdasdasdas','teste@teste.com.br');

/*!40000 ALTER TABLE `contatos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela grupo_contatos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grupo_contatos`;

CREATE TABLE `grupo_contatos` (
  `id_grupo_contato_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_grupo_contato_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump da tabela interfaces
# ------------------------------------------------------------

DROP TABLE IF EXISTS `interfaces`;

CREATE TABLE `interfaces` (
  `id_interface_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_interface` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_interface_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

LOCK TABLES `interfaces` WRITE;
/*!40000 ALTER TABLE `interfaces` DISABLE KEYS */;

INSERT INTO `interfaces` (`id_interface_id`, `nome_interface`)
VALUES
	(1,'dongle1'),
	(2,'dongle2'),
	(3,'dongle3'),
	(4,'dongle4');

/*!40000 ALTER TABLE `interfaces` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela mensagens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mensagens`;

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` char(1) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `interface` varchar(10) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `mensagem` varchar(200) DEFAULT NULL,
  `campanha_id` int(11) DEFAULT NULL,
  `tipo_envio` varchar(11) DEFAULT NULL,
  `enviada_em` datetime DEFAULT NULL,
  `queue_status` varchar(200) DEFAULT NULL,
  `queue_error` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

LOCK TABLES `mensagens` WRITE;
/*!40000 ALTER TABLE `mensagens` DISABLE KEYS */;

INSERT INTO `mensagens` (`id`, `status`, `data`, `hora`, `interface`, `numero`, `mensagem`, `campanha_id`, `tipo_envio`, `enviada_em`, `queue_status`, `queue_error`)
VALUES
	(1,'r','2016-08-16','20:34:41','dongle4','+5565996376060','teeste',NULL,'RAPIDA',NULL,NULL,NULL),
	(2,'r','2016-08-16','20:45:14','dongle4','+5565996376060','dGVzdGU=',NULL,'RAPIDA',NULL,NULL,NULL),
	(3,'r','2016-08-16','20:54:46','dongle4','+5565996376060','bw==',NULL,'RAPIDA',NULL,NULL,NULL),
	(4,'r','2016-08-16','20:57:05','dongle4','1515','UHJlIERpYXJpbzogVmMgZW52aW91IHVtIFNNUyBlIGFnb3JhIHRlbSAzMDAgU01TIHAvIFZpdm8sIDE1IFNNUyBwL291dHJhcyBlIG8gRE9CUk8gZGUgaW50ZXJuZXQsIGRlIDE1TUIgcC8gMzBNQiBhdGUgMjNoNTkgcG9yIFICMCw5OQ==',NULL,'RAPIDA',NULL,NULL,NULL),
	(5,'e','0000-00-00','00:00:00','dongle4','+55996376060','hello boy',NULL,'RAPIDA',NULL,NULL,NULL),
	(6,'e','2016-08-16','21:18:56','dongle4','+55996376060','hello boy',NULL,'RAPIDA',NULL,NULL,NULL),
	(7,'e','2016-08-16','21:24:01','dongle4','+55996376060','base64_encode(hello boy)',NULL,'RAPIDA',NULL,NULL,NULL),
	(8,'e','2016-08-16','21:24:42','dongle4','+55996376060','',NULL,'RAPIDA',NULL,NULL,NULL),
	(9,'e','2016-08-16','21:26:27','dongle4','+55996376060','',NULL,'RAPIDA',NULL,NULL,NULL),
	(10,'e','2016-08-16','21:26:40','dongle4','+55996376060','',NULL,'RAPIDA',NULL,NULL,NULL),
	(11,'e','2016-08-16','21:28:27','dongle4','+55996376060','aGVsbG8gYm95Cg==',NULL,'RAPIDA',NULL,NULL,NULL),
	(12,'e','2016-08-16','21:29:34','dongle4','+55996376060','aGVsbG8gYm95Cg==',NULL,'RAPIDA',NULL,NULL,NULL),
	(13,'e','2016-08-16','21:29:46','dongle4','+55996376060','aGVsbG8gYm95IDIwMTYK',NULL,'RAPIDA',NULL,NULL,NULL),
	(14,'e','2016-08-16','21:30:09','dongle2','+55996376060','aGVsbG8gYm95IDIwMTYK',NULL,'RAPIDA',NULL,NULL,NULL),
	(15,'e','2016-08-16','21:31:01','dongle2','+55996376060','aGVsbG8gYm95IDIwMTYK',NULL,'RAPIDA',NULL,NULL,NULL),
	(16,'r','2016-08-16','21:32:24','dongle4','+5565996376060','IG9wYQ==',NULL,'RAPIDA',NULL,NULL,NULL),
	(17,'e','2016-08-16','21:32:36','dongle2','+55996376060','aGVsbG8gYm95IDIwMTYK',NULL,'RAPIDA',NULL,NULL,NULL),
	(18,'e','2016-08-16','21:33:15','dongle4','+55996376060','aGVsbG8gYm95IDIwMTYK',NULL,'RAPIDA',NULL,NULL,NULL),
	(19,'e','2016-08-16','21:33:46','dongle4','+5565996376060','aGVsbG8gYm95IDIwMTYK',NULL,'RAPIDA',NULL,NULL,NULL),
	(20,'e','2016-08-17','08:51:17','dongle4','+5565996376060','aGVsbG8gYm95IDIwMTYK',NULL,'RAPIDA',NULL,NULL,NULL),
	(21,'r','2016-08-17','08:51:20','dongle4','1515','UHJlIERpYXJpbzogVmMgZW52aW91IHVtIFNNUyBlIGFnb3JhIHRlbSAzMDAgU01TIHAvIFZpdm8sIDE1IFNNUyBwL291dHJhcyBlIG8gRE9CUk8gZGUgaW50ZXJuZXQsIGRlIDE1TUIgcC8gMzBNQiBhdGUgMjNoNTkgcG9yIFICMCw5OQ==',NULL,'RAPIDA',NULL,NULL,NULL),
	(24,'e','2016-12-18','23:50:28',NULL,NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(25,'e','2016-12-18','23:51:14',NULL,NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(26,'e','2016-12-18','23:51:33',NULL,NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(27,'e','2016-12-18','23:51:44',NULL,NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(28,'e','2016-12-18','23:53:15',NULL,NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(29,'e','2016-12-18','23:53:45',NULL,NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(30,'e','2016-12-18','23:54:00','dongle2',NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(31,'e','2016-12-18','23:54:10','dongle1',NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(32,'e','2016-12-18','23:54:29','dongle1',NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(33,'e','2016-12-18','23:54:47','dongle1',NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(34,'e','2016-12-18','23:55:11','dongle1',NULL,'',NULL,'RAPIDA',NULL,NULL,NULL),
	(35,'e','2016-12-18','23:56:42','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNk',NULL,'RAPIDA',NULL,NULL,NULL),
	(36,'e','2016-12-18','23:57:03','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNk',NULL,'RAPIDA',NULL,NULL,NULL),
	(37,'e','2016-12-18','23:58:34','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkYXNkYXNkYXNkYXNkYXNk',NULL,'RAPIDA',NULL,NULL,NULL),
	(38,'e','2016-12-18','23:59:00','dongle1','6599463782','YXNkYXNkYXNkYXNhc2Rhc2Q=',NULL,'RAPIDA',NULL,NULL,NULL),
	(39,'e','2016-12-18','23:59:38',NULL,'','',NULL,'RAPIDA',NULL,NULL,NULL),
	(40,'e','2016-12-18','23:59:51',NULL,'','',NULL,'RAPIDA',NULL,NULL,NULL),
	(41,'e','2016-12-19','00:00:01',NULL,'6599463782','YXNkYXNkYXNkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(42,'e','2016-12-19','00:00:36',NULL,'6599463782','YXNkYXNkYXNkYXNkc2Fhc2Rhc2Q=',NULL,'RAPIDA',NULL,NULL,NULL),
	(43,'e','2016-12-19','00:01:39',NULL,'6599463782','YXNkYXNkYXNkYXNkc2Fhc2Rhc2Q=',NULL,'RAPIDA',NULL,NULL,NULL),
	(44,'e','2016-12-19','00:03:18','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(45,'e','2016-12-19','00:11:32','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(46,'e','2016-12-19','00:12:18','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(47,'e','2016-12-19','00:12:41','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(48,'e','2016-12-19','00:12:48','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(49,'e','2016-12-19','00:13:00','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(50,'e','2016-12-19','00:16:39','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(51,'e','2016-12-19','00:17:11','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'CAMPANHA','2016-12-19 21:58:00','ENVIADA',NULL),
	(52,'e','2016-12-19','00:17:46','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'CAMPANHA','2016-12-19 22:02:40','ENVIADA','devices not found'),
	(53,'e','2016-12-19','00:18:36','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'CAMPANHA','2016-12-19 21:58:02','ENVIADA','devices not found'),
	(54,'e','2016-12-19','00:19:45','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'CAMPANHA','2016-12-19 22:02:42','ENVIADA','devices not found'),
	(55,'e','2016-12-19','00:19:56','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(56,'e','2016-12-19','00:20:01','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(57,'e','2016-12-19','00:21:40','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(58,'e','2016-12-19','00:22:05','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(59,'e','2016-12-19','00:23:08','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(60,'e','2016-12-19','00:23:49','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(61,'e','2016-12-19','00:24:02','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(62,'e','2016-12-19','00:24:30','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(63,'e','2016-12-19','00:24:42','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(64,'e','2016-12-19','00:25:02','dongle2','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(65,'e','2016-12-19','00:30:32','dongle2','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(66,'e','2016-12-19','00:32:24','dongle2','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(67,'e','2016-12-19','00:32:46','dongle2','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(68,'e','2016-12-19','00:33:26','dongle2','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(69,'e','2016-12-19','00:34:55','dongle2','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(70,'e','2016-12-19','00:35:08','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(71,'e','2016-12-19','00:35:34','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(72,'e','2016-12-19','00:35:53','dongle1','6599463782','YXNkYXNkYXNkYXNkYXNkYXNkc2Fk',NULL,'RAPIDA',NULL,NULL,NULL),
	(73,'e','2016-12-19','22:49:30','dongle1','6599463782','YXNkZGFzZGFzZA==',NULL,'RAPIDA',NULL,NULL,NULL),
	(74,'e','2016-12-19','22:50:47','dongle1','6599463782','YXNkYXNkYXNkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(75,'e','2016-12-19','22:51:05','dongle1','6599463782','YXNkYXNkYXNkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(76,'e','2016-12-19','22:51:11','dongle1','6599463782','YXNkYXNkYXNkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(77,'e','2016-12-19','22:51:41','dongle1','6599463782','YXNkYXNkYXNkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(78,'e','2016-12-19','22:53:08','dongle1','6599463782','YXNkYXNkYXNkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(79,'e','2016-12-19','23:52:37',NULL,'1515','dGVzdGU=',NULL,'RAPIDA',NULL,NULL,NULL),
	(80,'e','2016-12-19','23:53:53','dongle1','1515','dGVzdGU=',NULL,'RAPIDA',NULL,NULL,NULL),
	(81,'e','2016-12-19','23:57:42','dongle1','659947382','c2Rhc2RzYWRhc2Rhcw==',NULL,'RAPIDA',NULL,NULL,NULL),
	(82,'e','2016-12-20','00:03:26','dongle1','(65)999463782','dGVzdGUgMTIzMjMxMjMxMjMyMQ==',NULL,'RAPIDA',NULL,NULL,NULL),
	(83,'e','2016-12-20','00:08:17','dongle1',NULL,'YXNkYXNkYXNkc2FkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(84,'e','2016-12-20','00:08:44','dongle1',NULL,'dGVzdGUgMTIzMjMxMjMxMjMyMQ==',NULL,'RAPIDA',NULL,NULL,NULL),
	(85,'e','2016-12-20','00:09:30','dongle1','65999463782','YXNkYXNkYXNkc2FkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(86,'e','2016-12-20','00:11:38','dongle1','65999463782','YXNkYXNkYXNkc2FkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(87,'e','2016-12-20','00:11:49','dongle1','65999463782','YXNkYXNkYXNkc2FkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(88,'e','2016-12-20','00:12:00','dongle1','65999463782','YXNkYXNkYXNkc2FkYXM=',NULL,'RAPIDA',NULL,NULL,NULL),
	(89,'e','2016-12-20','00:17:44','dongle1','65999463782','dGVzdGUgMTIzMjMxMjMxMjMyMQ==',NULL,'RAPIDA',NULL,NULL,NULL),
	(90,'e','2016-12-20','00:24:22','dongle1','65999463782','ZXNzZSB0ZXN0ZSBmb2Rhby4uLi4=',NULL,'RAPIDA',NULL,NULL,NULL),
	(91,'e','2016-12-20','00:35:07','dongle1','65999463782','dGVzdGVzZGFzZGFzZGFkc2FkYXMg',NULL,'RAPIDA',NULL,NULL,NULL),
	(92,'e','2016-12-20','20:14:59',NULL,'','',2,'CAMPANHA',NULL,NULL,NULL),
	(93,'e','2016-12-20','20:14:59',NULL,'','',2,'CAMPANHA',NULL,NULL,NULL),
	(94,'e','2016-12-20','20:14:59',NULL,'','',2,'CAMPANHA',NULL,NULL,NULL),
	(95,'e','2016-12-20','20:14:59',NULL,'','',2,'CAMPANHA',NULL,NULL,NULL),
	(96,'e','2016-12-20','20:15:27',NULL,'6599463782','',3,'CAMPANHA',NULL,NULL,NULL),
	(97,'e','2016-12-20','20:15:27',NULL,'6477885848','',3,'CAMPANHA',NULL,NULL,NULL),
	(98,'e','2016-12-20','20:15:27',NULL,'6477388839','',3,'CAMPANHA',NULL,NULL,NULL),
	(99,'e','2016-12-20','20:15:27',NULL,'7488387736','',3,'CAMPANHA',NULL,NULL,NULL),
	(100,'e','2016-12-20','20:15:44',NULL,'6599463782','RWR1YXJkbyBGRUxJWiBOQVRBTA==',4,'CAMPANHA',NULL,NULL,NULL),
	(101,'e','2016-12-20','20:15:44',NULL,'6477885848','Sm9zZSBGRUxJWiBOQVRBTA==',4,'CAMPANHA',NULL,NULL,NULL),
	(102,'e','2016-12-20','20:15:44',NULL,'6477388839','bWFyaWEgRkVMSVogTkFUQUw=',4,'CAMPANHA',NULL,NULL,NULL),
	(103,'e','2016-12-20','20:15:44',NULL,'7488387736','dGVzdGUgRkVMSVogTkFUQUw=',4,'CAMPANHA',NULL,NULL,NULL);

/*!40000 ALTER TABLE `mensagens` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela modelo_sms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modelo_sms`;

CREATE TABLE `modelo_sms` (
  `id_modelo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_modelo` varchar(11) DEFAULT NULL,
  `texto` text,
  PRIMARY KEY (`id_modelo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
