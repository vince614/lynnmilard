SET NAMES utf8mb4;

CREATE TABLE `config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL DEFAULT '',
  `value` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `config` WRITE;

INSERT INTO `config` (`id`, `code`, `value`)
VALUES
	(1,'maintenance_mode','0'),
	(2,'unsecure_url','http://localhost/lynnmilard.fr'),
	(3,'secure_url','http://localhost/lynnmilard.fr'),
	(5,'css_version','0'),
	(6,'js_version','0'),
	(7,'grecaptcha_secretkey',NULL),
	(8,'grecaptcha_sitekey',NULL),
	(9,'local_mode','1');

UNLOCK TABLES;