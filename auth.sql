CREATE TABLE `client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `password_hash` varchar(60) NOT NULL DEFAULT '',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password_salt` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `client_user_name` (`user_name`)
)
