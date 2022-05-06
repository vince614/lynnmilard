SET NAMES utf8mb4;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NULL,
  `last_name` varchar(255) NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth` varchar(30) NULL,
  `age` INT(3) NULL,
  `gender` VARCHAR (30) NULL,
  `avatar` VARCHAR (255) NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `is_admin` smallint (1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;