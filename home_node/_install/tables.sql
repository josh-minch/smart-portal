CREATE DATABASE IF NOT EXISTS portal;

CREATE TABLE IF NOT EXISTS `portal`.`users` (
  `userId` int(11) NOT NULL auto_increment,
  `uUsername` varchar(128) NOT NULL,
  `uPassword` varchar(40) NOT NULL,
  `uSalt` varchar(128) NOT NULL,
  `uActivity` datetime NOT NULL,
  `uCreated` datetime NOT NULL,
  PRIMARY KEY  (`userId`),
  UNIQUE KEY `uUsername` (`uUsername`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 ;

INSERT INTO `portal`.`users` (`userId`, `uUsername`, `uPassword`, `uSalt`, `uActivity`, `uCreated`) VALUES
  ( 1, 'admin', '0f2f6e530950ee0b06b8f6626061fd46f2052ef2', '5a74fe43be5a16.896594115a74fe43be5ab3.002168745a74fe43be5af2.445112055a74fe43be5b10.872343845a74fe43be5b43.008095705a74fe43be5b7', 0, 0);
  
CREATE USER 'portal'@'localhost' IDENTIFIED BY 'portal';
GRANT ALL PRIVILEGES ON portal.* to 'portal'@'localhost';
 