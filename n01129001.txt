CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(128) NOT NULL,
  `crypted_password` varchar(128) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `country` varchar(64),
  `province` varchar(64) NOT NULL,
  `city` varchar(128) NOT NULL,
  `age` int(4) unsigned NOT NULL,
  `gender` varchar(32) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users` ADD COLUMN `created_at` datetime NOT NULL;
