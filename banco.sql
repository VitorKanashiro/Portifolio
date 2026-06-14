
DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin` WRITE;
INSERT INTO `admin` VALUES (1,'admin@admin.com','$2y$10$j4yKtq0HoO.AR3t7k1sTXeRjJ1HIQEvZpe51IPB0/W0WfF4z7jRDC','2026-05-19 23:29:09');

UNLOCK TABLES;

DROP TABLE IF EXISTS `contato`;

CREATE TABLE `contato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contato` WRITE;
INSERT INTO `contato` VALUES (1,'vitorkgdaiki@gmail.com','(12)99253-0434','Caraguatuba, SP','Estou disponível para novos projetos e oportunidades! Entre em contato e vamos conversar.','2026-05-20 21:55:25');

UNLOCK TABLES;

DROP TABLE IF EXISTS `mensagens`;

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

LOCK TABLES `mensagens` WRITE;

UNLOCK TABLES;

DROP TABLE IF EXISTS `perfil`;

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

LOCK TABLES `perfil` WRITE;

INSERT INTO `perfil` VALUES (1,'Vitor Kanashiro','Dev Full Stack','','Sempre em busca de novos desafios, aprendizados e oportunidades para criar soluções que façam a diferença.','https://github.com/VitorKanashiro','https://www.linkedin.com/in/vitorkanashiro/','perfil_1780884985.png','2026-06-08 02:16:25');

UNLOCK TABLES;

DROP TABLE IF EXISTS `projetos`;

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

LOCK TABLES `projetos` WRITE;

INSERT INTO `projetos` VALUES (1,'Portfólio Pessoal','Portfólio profissional dinâmico com painel administrativo completo, gerenciamento de projetos, tecnologias e informações pessoais.','PHP, MySQL, Bootstrap 5, JavaScript','proj_6a262d155255e.png','https://github.com/VitorKanashiro/Portifolio#','',1,'2026-05-19 23:04:29','2026-06-08 02:46:45'),(4,'Projeto SGE','Sistema de Gestão Escolar (SGE) desenvolvido para o Instituto Educacional Mundo Encantado, com foco em organização, acessibilidade e modernização da gestão escolar.','PHP, MySQL, Bootstrap 5, JavaScript','proj_6a248fe5678ca.png','https://github.com/Kauecozendei/SGE','',1,'2026-05-20 21:57:56','2026-06-06 21:23:49'),(6,'TaskManager','Meu primeiro sistema web desenvolvido em Java com Spring Boot para gerenciamento de tarefas. Permite criar, listar, atualizar e excluir tarefas (CRUD) por meio de uma API REST, com persistência em banco de dados utilizando Spring Data JPA. Projeto focado em organização, boas práticas e arquitetura em camadas.','Java, Spring Boot, MySQL','','https://github.com/VitorKanashiro/taskmanager','',1,'2026-06-01 23:07:49','2026-06-06 21:21:39');

UNLOCK TABLES;

DROP TABLE IF EXISTS `redes_sociais`;

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

LOCK TABLES `redes_sociais` WRITE;

INSERT INTO `redes_sociais` VALUES (1,'GitHub','https://github.com/VitorKanashiro','bi-github',1,1,'2026-05-19 23:04:29'),(2,'LinkedIn','https://www.linkedin.com/in/vitorkanashiro/','bi-linkedin',1,2,'2026-05-19 23:04:29'),(3,'Instagram','https://instagram.com','bi-instagram',1,3,'2026-05-19 23:04:29'),(4,'WhatsApp','https://wa.me/12992530434','bi-whatsapp',1,4,'2026-05-19 23:04:29');

UNLOCK TABLES;

DROP TABLE IF EXISTS `sobre`;

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

LOCK TABLES `sobre` WRITE;

INSERT INTO `sobre` VALUES (1,'Sobre Mim','Sou estudante de Análise e Desenvolvimento de Sistemas na Fatec São Sebastião, com interesse em desenvolvimento back-end e criação de soluções web.','Ao longo da graduação, venho desenvolvendo projetos acadêmicos e pessoais utilizando tecnologias como Java, Spring Boot, PHP, HTML, CSS, JavaScript e bancos de dados. Gosto de transformar ideias em aplicações práticas e estou sempre em busca de novos desafios para evoluir como desenvolvedor.','Busco construir uma carreira sólida na área de desenvolvimento de software, participando de projetos que me permitam aprender, crescer profissionalmente e gerar impacto por meio da tecnologia. Meu foco é desenvolver soluções eficientes, adquirir experiência prática e continuar evoluindo constantemente.','2+','3+','sobre_1780885789.png','2026-06-08 02:29:49');

UNLOCK TABLES;

DROP TABLE IF EXISTS `tecnologias`;

CREATE TABLE `tecnologias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT 'Intermediário',
  `nivel_percentual` int(11) DEFAULT 70,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `tecnologias` WRITE;

INSERT INTO `tecnologias` VALUES (1,'HTML5','bi-filetype-html','Avançado',90,'2026-05-19 23:04:29'),(2,'CSS3','bi-filetype-css','Avançado',85,'2026-05-19 23:04:29'),(3,'Bootstrap 5','bi-bootstrap','Avançado',88,'2026-05-19 23:04:29'),(4,'JavaScript','bi-filetype-js','Avançado',0,'2026-05-19 23:04:29'),(5,'PHP','bi-filetype-php','Intermediário',0,'2026-05-19 23:04:29'),(6,'MySQL','bi-database','Intermediário',70,'2026-05-19 23:04:29'),(7,'Git','bi-git','Avançado',82,'2026-05-19 23:04:29'),(8,'Java','bi-filetype-java','Intermediário',65,'2026-05-19 23:04:29');

UNLOCK TABLES;
