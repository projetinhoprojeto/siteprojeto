CREATE DATABASE  IF NOT EXISTS `meu_banco_de_dados` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `meu_banco_de_dados`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: meu_banco_de_dados
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agendamento`
--

DROP TABLE IF EXISTS `agendamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendamento` (
  `id_usuario` int(11) NOT NULL,
  `id_agendamento` int(11) NOT NULL AUTO_INCREMENT,
  `nomeResponsável` varchar(45) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomePet` varchar(45) NOT NULL,
  `tipoPet` varchar(80) NOT NULL,
  `outroAnimal` varchar(255) DEFAULT NULL,
  `tipoServico` enum('Consulta','Vacinação','Cirurgia','Exame') DEFAULT NULL,
  `subtipo_servico` varchar(200) NOT NULL,
  `dataAgendamento` date NOT NULL,
  `horario` time NOT NULL,
  PRIMARY KEY (`id_agendamento`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendamento`
--

LOCK TABLES `agendamento` WRITE;
/*!40000 ALTER TABLE `agendamento` DISABLE KEYS */;
INSERT INTO `agendamento` VALUES (14,1,'Jair Bolsonaro','(21) 98768-7653','pastelariadoprofeta3@gmail.com','Height','cachorro',NULL,'Cirurgia','Cirurgia Ortopédica (R$ 1000,00)','2024-11-17','16:00:00'),(27,2,'Alberto Felisberto Freire','(21)90239-2103','pastelariadoprofeta11@gmail.com','Height','outro','sapo','Consulta','Consulta Especialista (R$ 200,00)','2024-11-21','08:00:00'),(27,3,'Alberto Felisberto Freire','(21)90239-2103','pastelariadoprofeta11@gmail.com','Ligeirinho','gato',NULL,'Vacinação','Vacina Giárdia (R$ 80,00)','2024-11-17','13:00:00'),(12,4,'Antonio Araujo jr','(21)99732-9845','araujodias@gmail.com','Docinho','cachorro',NULL,'Consulta','Retorno (R$ 100,00)','2024-11-17','08:00:00'),(4,5,'Sofia Rosa Farah ','(81)94309-6435','pastelariadoprofeta@gmail.com','Amora','cachorro',NULL,'Exame','Exame de Urina (R$ 80,00)','2024-11-20','11:00:00'),(25,6,'Nilson Neves Filho','(21)93125-4356','nevesnilson@yahoo.com','Rogeirinho','gato',NULL,'Consulta','Consulta Rotina (R$ 100,00)','2023-11-20','10:00:00'),(14,7,'Jonathan Santos','(21)93204-5811','pastelariadoprofeta3@gmail.com','Height','cachorro',NULL,'Vacinação','Vacina Antirrábica (R$ 70,00)','2024-11-21','13:00:00'),(14,8,'Jonathan Santos','(21)93204-5811','pastelariadoprofeta3@gmail.com','Height','cachorro',NULL,'Consulta','Consulta Especialista (R$ 200,00)','2024-11-15','10:00:00'),(11,9,'Jose de Almeida Silva','(61)93243-2543','josegoias@gmail.com','Amorinha','cachorro',NULL,'Consulta','Consulta Rotina (R$ 100,00)','2024-11-17','08:00:00'),(27,10,'Alberto Felisberto Freire','(21)90239-2103','pastelariadoprofeta11@gmail.com','Height','cachorro',NULL,'Vacinação','Vacina Gripe Canina (R$ 90,00)','2024-11-21','15:00:00'),(23,11,'Rosa Reis Roberts','(21)97868-7699','robertesrrsoares@soares.com.br','Roberta','gato',NULL,'Consulta','Consulta Especialista (R$ 200,00)','2024-11-18','11:00:00'),(28,12,'Carlos Cecilliano','(61)96340-0335','cctropadoc@gmail.com','Fruta','gato',NULL,'Vacinação','Vacina Giárdia (R$ 80,00)','2024-11-27','13:00:00'),(21,13,'Fausto Silva Almeida','(21)93459-3407','maestrodomingo@gmail.comm','Saturno','outro','Papagaio','Cirurgia','Remoção de Tumor (R$ 600,00)','2024-11-27','08:00:00');
/*!40000 ALTER TABLE `agendamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logins`
--

DROP TABLE IF EXISTS `logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logins` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(80) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expiracao` datetime DEFAULT NULL,
  `data_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logins`
--

LOCK TABLES `logins` WRITE;
/*!40000 ALTER TABLE `logins` DISABLE KEYS */;
INSERT INTO `logins` VALUES (43,'pastelariadoprofeta@gmail.com','202411168c1065f3c5e301cb5b511fc60e049a95','2024-11-16 21:29:57','2024-11-16 21:19:56');
/*!40000 ALTER TABLE `logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `genero` enum('M','F','O') NOT NULL,
  `nome_materno` varchar(80) NOT NULL,
  `telefoneCelular` varchar(20) DEFAULT NULL,
  `telefoneFixo` varchar(20) DEFAULT NULL,
  `cep` varchar(9) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `perfil` enum('master','comum') DEFAULT 'comum',
  `fotoperfil` varchar(255) DEFAULT NULL,
  `status_ativo` tinyint(1) DEFAULT 0,
  `ultima_vez_visto` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Fernando Silva Rodrigues','ferandosilva@yahoo.com','2007-02-15','273.807.990-37','M','Lívia Silva Rodrigues','(12)43232-2329','','21041-030','Avenida Londres - Bonsucesso - Rio de Janeiro - RJ','12345678','2024-10-12 22:26:30','comum','IMAGENS/icone6.jpeg',0,NULL),(2,'Antonio augusto da silva barradas','barradasantoniiooo@yahoo.com','1931-02-15','273.807.990-37','M','maria amelia coelho silva','(55)21987-5438','','21041-320','Beco Cartola - Manguinhos - Rio de Janeiro - RJ','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone5.jpeg',0,NULL),(4,'Sofia Rosa Farah ','pastelariadoprofeta@gmail.com','2006-08-10','326.936.270-60','F','Agatha Regina Rosa Farah','(81)94309-6430','(81)2314-0953','73780-970','Avenida Zaida Pinto Boaventura - Centro - Água Fria de Goiás - GO','111111111111','2024-10-12 22:26:30','master','IMAGENS/icone8.jpg',0,'2024-11-16 21:20:00'),(7,'Roberta Gomes da Silva','dasilvarobert@gmail.com','1953-02-14','273.807.990-37','F','Antonela da Rocha Silva','(22)11213-3332','','73780-970','Avenida Zaida Pinto Boaventura - Centro - Água Fria de Goiás - GO','123456543','2024-10-12 22:26:30','comum','IMAGENS/icone7.jpeg',0,NULL),(8,'Ana Roberta Ferreira Prado','ferreiravjp@yahoo.com','1927-08-30','322.315.970-39','F','Rosineide Ferreira Prado','(22)11213-3332','','73780-970','Avenida Zaida Pinto Boaventura - Centro - Água Fria de Goiás - GO','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone7.jpeg',0,NULL),(9,'Ana Roberta Ferreira Prado','ferreiravjp@yahoo.com','1927-08-30','322.315.970-39','F','Rosineide Ferreira Prado','(22)11213-3332','','73780-970','Avenida Zaida Pinto Boaventura - Centro - Água Fria de Goiás - GO','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone7.jpeg',0,NULL),(10,'Rosilene mitome','mitomebarros@zhoo.com','2003-09-27','322.315.970-39','F','anthera dos santos','(43)43242-3324','(55)2198-7543','73780-970','Avenida Zaida Pinto Boaventura - Centro - Água Fria de Goiás - GO','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone5.jpeg',0,'2024-11-16 20:12:32'),(11,'Jose de Almeida Silva','josegoias@gmail.com','1996-07-03','322.315.970-39','M','Júlia Rocha de Almeida','(61)93243-2543','(61)8844-3543','62032-020','Rua Tenente Adão Cordeiro de Almeida - Pedro Mendes - Sobral - CE','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone4.jpeg',0,'2024-11-16 20:09:12'),(12,'Antonio Araujo jr','araujodias@gmail.com','1995-02-11','322.315.970-39','M','Suelli torres ','(21)99732-9845','(21)3249-0872','21071-030','Rua Camobi - Olaria - Rio de Janeiro - RJ','posturado','2024-10-12 22:26:30','comum','IMAGENS/icone4.jpeg',0,'2024-11-16 18:44:31'),(13,'Bruno Fuchs Mello','mellopraiano@gmail.com','1997-01-30','273.807.990-37','M','Laura Fuhs Mello','(21)93429-0585','(71)7391-2343','73780-970','Avenida Zaida Pinto Boaventura - Centro - Água Fria de Goiás - GO','123paz123','2024-10-12 22:26:30','comum','IMAGENS/icone4.jpeg',0,NULL),(14,'Jonathan Santos','pastelariadoprofeta3@gmail.com','1995-05-17','273.807.990-37','O','Giiovana Callerri','(21)93204-5815','','21041-030','Avenida Londres - Bonsucesso - Rio de Janeiro - RJ','111111111111','2024-10-12 22:26:30','comum','IMAGENS/icone3.jpeg',0,'2024-11-16 21:18:37'),(15,'Joao Pedro Alves ','drpedrojoao@gmail.com','2000-07-01','273.807.990-37','M','Bruna Soares Alves ','(11)98282-3942','(11)2343-5355','11030-000','Praça Engenheiro José Rebouças - Ponta da Praia - Santos - SP','santosvila','2024-10-12 22:26:30','comum','IMAGENS/icone3.jpeg',0,NULL),(16,'Ernesto Soares Netto','ernesto12@gmail.com','2003-11-28','273.807.990-37','M','Bruna Soares Alves ','(11)98232-4243','(11)2343-5355','11030-030','Rua Professor Carlos Escobar - Ponta da Praia - Santos - SP','154678930303','2024-10-12 22:26:30','comum','IMAGENS/icone5.jpeg',0,'2024-11-16 21:17:46'),(17,'Roberto da silva jr','robertoba@yahoo.com','1993-03-21','273.807.990-37','M','Carla santos da silva','(21)91232-6789','(21)7689-8068','21070-080','Parque Ari Barroso - Penha Circular - Rio de Janeiro - RJ','aaaaaaaaaaa1','2024-10-12 22:26:30','comum','IMAGENS/icone7.jpeg',0,NULL),(18,'Neilton Luis Flaco de Sousa','flacoco@yahoo.com','1995-02-19','273.807.990-37','M','Anna Carla Flaco de Sousa','(31)93928-4392','(31)3425-4315','36052-110','Rua Augusto Vicente Vieira - Nossa Senhora Aparecida - Juiz de Fora - MG','gerais003','2024-10-12 22:26:30','comum','IMAGENS/icone8.jpeg',0,NULL),(19,'Sofia Barradas Alhais','barradasalvador@gmail.com','1992-05-16','326.936.270-60','F','L. Figueiredo Barradas','(81)93203-4238','','21031-010','Rua Aragarças - Ramos - Rio de Janeiro - RJ','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone5.jpeg',0,NULL),(20,'Sofia Vasconcelhos Santos','santoglauber@yahoo.com','2001-01-21','322.315.970-39','F','Bruna Vasconcelhos','(21)97345-7457','','21070-040','Rua Plínio de Oliveira - Penha - Rio de Janeiro - RJ','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone3.jpeg',0,NULL),(21,'Fausto Silva Almeida','maestrodomingo@gmail.comm','1957-07-20','111.111.111-11','M','Rafaela Silva','(21)93459-3407','(21)3093-4577','21041-030','Avenida Londres - Bonsucesso - Rio de Janeiro - RJ','000000000000','2024-10-12 22:26:30','comum','IMAGENS/icone3.jpeg',0,'2024-11-16 20:46:58'),(22,'Manuella Manella','ramosolariapenha@penharol.com','2003-03-30','213.425.423-45','F','Geovana Manella','(21)92134-2523','','21071-010','Rua Ardiria - Olaria - Rio de Janeiro - RJ','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone2.jpeg',0,NULL),(23,'Rosa Reis Roberts','robertesrrsoares@soares.com.br','1990-11-20','234.352.436-53','F','Rosangela Reis Roberts','(21)97868-7699','','21020-040','Rua Indígena - Penha - Rio de Janeiro - RJ','penharolkk12','2024-10-12 22:26:30','comum','IMAGENS/icone3.jpeg',0,'2024-11-16 20:42:18'),(24,'Silvio Silvano Da Silva Silva','pastelariadoprofeta33@gmail.com','1955-07-31','343.254.654-65','O','Silvia dos Santos Silva ','(21)96455-4665','(21)3453-4568','21051-020','Rua Francisco Medeiros - Higienópolis - Rio de Janeiro - RJ','francisco','2024-10-12 22:26:30','comum','IMAGENS/icone2.jpeg',0,NULL),(25,'Nilson Neves Filho','nevesnilson@yahoo.com','1970-10-10','125.635.789-09','M','Francisca Neves','(21)93125-4356','(21)3568-7567','21072-020','Travessa São Francisco de Paula - Penha - Rio de Janeiro - RJ','penha031','2024-10-12 22:26:30','comum','IMAGENS/icone1.jpeg',1,'2024-11-16 19:16:17'),(27,'Alberto Felisberto Freire','pastelariadoprofeta11@gmail.com','1981-11-11','212.321.332-43','M','Rosangela Prado Felisberto Freire ','(21)90239-2103','','21011-020','Rua da Batata - Penha Circular - Rio de Janeiro - RJ','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone1.jpeg',0,'2024-11-16 21:19:49'),(28,'Carlos Cecilliano','cctropadoc@gmail.com','2005-03-14','134.785.677-55','M','Joana Cecilliano','(61)96340-0335','','98801-048','Rua Quinze de Novembro - Sossego - Santo Ângelo - RS','aaaaaaaaaaaa','2024-10-12 22:26:30','comum','IMAGENS/icone1.jpeg',0,'2024-11-16 20:43:50'),(31,'Ana Beatriz Martins','martinasAna@yahoo.com','2007-10-31','273.292.291-99','F','Oliveira','(21)97946-4949','(12)1946-7644','21041-010','Praça das Nações - Bonsucesso - Rio de Janeiro - RJ','07070707','2024-11-16 18:54:51','master','IMAGENS/icone1.jpeg',0,'2024-11-16 18:54:51'),(32,'Matheus Barradas ','assistentemini@gmail.com','2007-09-03','231.539.395-87','M','Rosi Lameira','(21)94976-4646','','21051-200','Rua Natal do Norte - Del Castilho - Rio de Janeiro - RJ','pastelaria','2024-11-16 21:10:34','master','IMAGENS/icone8.jpeg',0,'2024-11-16 21:23:50'),(33,'Iris Fernandes ','iris@hotmail.com','2003-11-23','492.093.939-22','F','Maria Fernandes','(23)94496-7760','(21)6746-5757','21020-030','Rua Fernandes Pinheiro - Penha - Rio de Janeiro - RJ','05050505','2024-11-16 21:15:17','master','IMAGENS/icone2.jpeg',0,'2024-11-16 21:20:02'),(34,'Nathalia da Silva','nat@hotmail.com','2007-11-30','201.929.383-92','F','Julia da Silva','(21)97946-5451','','23040-200','Rua C - Campo Grande - Rio de Janeiro - RJ','12345678','2024-11-16 21:21:50','master','IMAGENS/icone1.jpeg',0,'2024-11-16 21:21:50');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-16 22:31:18
