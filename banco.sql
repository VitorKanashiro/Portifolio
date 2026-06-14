-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: portfolio
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin@admin.com','$2y$10$j4yKtq0HoO.AR3t7k1sTXeRjJ1HIQEvZpe51IPB0/W0WfF4z7jRDC','2026-05-19 23:29:09');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contato`
--

DROP TABLE IF EXISTS `contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contato`
--

LOCK TABLES `contato` WRITE;
/*!40000 ALTER TABLE `contato` DISABLE KEYS */;
INSERT INTO `contato` VALUES (1,'vitorkgdaiki@gmail.com','(12)99253-0434','Caraguatuba, SP','Estou disponível para novos projetos e oportunidades! Entre em contato e vamos conversar.','2026-05-20 21:55:25');
/*!40000 ALTER TABLE `contato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensagens`
--

DROP TABLE IF EXISTS `mensagens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `assunto` varchar(255) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensagens`
--

LOCK TABLES `mensagens` WRITE;
/*!40000 ALTER TABLE `mensagens` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensagens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL DEFAULT 'Seu Nome',
  `cargo` varchar(100) NOT NULL DEFAULT 'Desenvolvedor Full Stack',
  `frase` text DEFAULT NULL,
  `subtitulo` text DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Vitor Kanashiro','Dev Full Stack','','Sempre em busca de novos desafios, aprendizados e oportunidades para criar soluções que façam a diferença.','https://github.com/VitorKanashiro','https://www.linkedin.com/in/vitorkanashiro/','perfil_1780884985.png','2026-06-08 02:16:25');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projetos`
--

DROP TABLE IF EXISTS `projetos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projetos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tecnologias` varchar(500) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `demo` varchar(255) DEFAULT NULL,
  `destaque` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projetos`
--

LOCK TABLES `projetos` WRITE;
/*!40000 ALTER TABLE `projetos` DISABLE KEYS */;
INSERT INTO `projetos` VALUES (1,'Portfólio Pessoal','Portfólio profissional dinâmico com painel administrativo completo, gerenciamento de projetos, tecnologias e informações pessoais.','PHP, MySQL, Bootstrap 5, JavaScript','proj_6a262d155255e.png','https://github.com/VitorKanashiro/Portifolio#','',1,'2026-05-19 23:04:29','2026-06-08 02:46:45'),(4,'Projeto SGE','Sistema de Gestão Escolar (SGE) desenvolvido para o Instituto Educacional Mundo Encantado, com foco em organização, acessibilidade e modernização da gestão escolar.','PHP, MySQL, Bootstrap 5, JavaScript','proj_6a248fe5678ca.png','https://github.com/Kauecozendei/SGE','',1,'2026-05-20 21:57:56','2026-06-06 21:23:49'),(6,'TaskManager','Meu primeiro sistema web desenvolvido em Java com Spring Boot para gerenciamento de tarefas. Permite criar, listar, atualizar e excluir tarefas (CRUD) por meio de uma API REST, com persistência em banco de dados utilizando Spring Data JPA. Projeto focado em organização, boas práticas e arquitetura em camadas.','Java, Spring Boot, MySQL','','https://github.com/VitorKanashiro/taskmanager','',1,'2026-06-01 23:07:49','2026-06-06 21:21:39');
/*!40000 ALTER TABLE `projetos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `redes_sociais`
--

DROP TABLE IF EXISTS `redes_sociais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `redes_sociais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plataforma` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icone` varchar(100) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `ordem` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redes_sociais`
--

LOCK TABLES `redes_sociais` WRITE;
/*!40000 ALTER TABLE `redes_sociais` DISABLE KEYS */;
INSERT INTO `redes_sociais` VALUES (1,'GitHub','https://github.com/VitorKanashiro','bi-github',1,1,'2026-05-19 23:04:29'),(2,'LinkedIn','https://www.linkedin.com/in/vitorkanashiro/','bi-linkedin',1,2,'2026-05-19 23:04:29'),(3,'Instagram','https://instagram.com','bi-instagram',1,3,'2026-05-19 23:04:29'),(4,'WhatsApp','https://wa.me/12992530434','bi-whatsapp',1,4,'2026-05-19 23:04:29');
/*!40000 ALTER TABLE `redes_sociais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sobre`
--

DROP TABLE IF EXISTS `sobre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sobre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL DEFAULT 'Sobre Mim',
  `descricao` text DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `objetivos` text DEFAULT NULL,
  `experiencia` varchar(50) DEFAULT NULL,
  `projetos_count` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sobre`
--

LOCK TABLES `sobre` WRITE;
/*!40000 ALTER TABLE `sobre` DISABLE KEYS */;
INSERT INTO `sobre` VALUES (1,'Sobre Mim','Sou estudante de Análise e Desenvolvimento de Sistemas na Fatec São Sebastião, com interesse em desenvolvimento back-end e criação de soluções web.','Ao longo da graduação, venho desenvolvendo projetos acadêmicos e pessoais utilizando tecnologias como Java, Spring Boot, PHP, HTML, CSS, JavaScript e bancos de dados. Gosto de transformar ideias em aplicações práticas e estou sempre em busca de novos desafios para evoluir como desenvolvedor.','Busco construir uma carreira sólida na área de desenvolvimento de software, participando de projetos que me permitam aprender, crescer profissionalmente e gerar impacto por meio da tecnologia. Meu foco é desenvolver soluções eficientes, adquirir experiência prática e continuar evoluindo constantemente.','2+','3+','sobre_1780885789.png','2026-06-08 02:29:49');
/*!40000 ALTER TABLE `sobre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tecnologias`
--

DROP TABLE IF EXISTS `tecnologias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tecnologias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT 'Intermediário',
  `nivel_percentual` int(11) DEFAULT 70,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnologias`
--

LOCK TABLES `tecnologias` WRITE;
/*!40000 ALTER TABLE `tecnologias` DISABLE KEYS */;
INSERT INTO `tecnologias` VALUES (1,'HTML5','bi-filetype-html','Avançado',90,'2026-05-19 23:04:29'),(2,'CSS3','bi-filetype-css','Avançado',85,'2026-05-19 23:04:29'),(3,'Bootstrap 5','bi-bootstrap','Avançado',88,'2026-05-19 23:04:29'),(4,'JavaScript','bi-filetype-js','Avançado',0,'2026-05-19 23:04:29'),(5,'PHP','bi-filetype-php','Intermediário',0,'2026-05-19 23:04:29'),(6,'MySQL','bi-database','Intermediário',70,'2026-05-19 23:04:29'),(7,'Git','bi-git','Avançado',82,'2026-05-19 23:04:29'),(8,'Java','bi-filetype-java','Intermediário',65,'2026-05-19 23:04:29');
/*!40000 ALTER TABLE `tecnologias` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-10 17:58:41
