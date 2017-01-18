# ************************************************************
# Sequel Pro SQL dump
# Versão 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Base de Dados: sms_aste
# Tempo de Geração: 2017-01-18 23:03:01 +0000
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
  `interface` varchar(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_campanha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
  `visualizada` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump da tabela mensagens_campanha
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mensagens_campanha`;

CREATE TABLE `mensagens_campanha` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump da tabela modelo_sms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modelo_sms`;

CREATE TABLE `modelo_sms` (
  `id_modelo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_modelo` varchar(11) DEFAULT NULL,
  `texto` text,
  PRIMARY KEY (`id_modelo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump da tabela usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usuario_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




--
-- Dumping routines (FUNCTION) for database 'sms_aste'
--
DELIMITER ;;

# Dump of FUNCTION regex_replace
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `regex_replace` */;;
/*!50003 SET SESSION SQL_MODE=""*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `regex_replace`(pattern VARCHAR(1000),replacement VARCHAR(1000),original VARCHAR(1000)) RETURNS varchar(1000) CHARSET latin1
    DETERMINISTIC
BEGIN 
 DECLARE temp VARCHAR(1000); 
 DECLARE ch VARCHAR(1); 
 DECLARE i INT;
 SET i = 1;
 SET temp = '';
 IF original REGEXP pattern THEN 
  loop_label: LOOP 
   IF i>CHAR_LENGTH(original) THEN
    LEAVE loop_label;  
   END IF;
   SET ch = SUBSTRING(original,i,1);
   IF NOT ch REGEXP pattern THEN
    SET temp = CONCAT(temp,ch);
   ELSE
    SET temp = CONCAT(temp,replacement);
   END IF;
   SET i=i+1;
  END LOOP;
 ELSE
  SET temp = original;
 END IF;
 RETURN temp;
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
