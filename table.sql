CREATE TABLE `wp_neuro_amazon` (
 `first_name` varchar(200) NOT NULL,
 `last_name` varchar(200) NOT NULL,
 `company_name` varchar(400) DEFAULT NULL,
 `email` varchar(200) NOT NULL,
 `phone` varchar(20) NOT NULL,
 `country` varchar(200) DEFAULT NULL,
 `address_1` varchar(200) NOT NULL,
 `address_2` varchar(200) DEFAULT NULL,
 `town_city` varchar(200) NOT NULL,
 `state` varchar(200) NOT NULL,
 `zip_code` varchar(20) NOT NULL,
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(50) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1
