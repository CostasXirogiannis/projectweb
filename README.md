# projectweb


Show create for db:

entries 	
CREATE TABLE `entries` (
 `entries_id` int NOT NULL,
 `userId` int NOT NULL,
 `count` int NOT NULL,
 `startedDateTime` varchar(255) NOT NULL,
 `timings` varchar(255) NOT NULL,
 `serverIPAddress` varchar(255) NOT NULL,
 `method` varchar(255) NOT NULL,
 `url` varchar(255) NOT NULL,
 `status` int NOT NULL,
 `statusText` varchar(255) DEFAULT NULL,
 `provider` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`entries_id`,`userId`,`count`),
 KEY `id` (`userId`),
 CONSTRAINT `entries_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

HeadersRequest 	
CREATE TABLE `HeadersRequest` (
 `multivalued` int NOT NULL,
 `entries_id` int NOT NULL,
 `userId` int NOT NULL,
 `count` int NOT NULL,
 `name` varchar(255) NOT NULL,
 `value` varchar(255) NOT NULL,
 PRIMARY KEY (`multivalued`,`entries_id`,`userId`,`count`),
 KEY `entries_id` (`entries_id`,`userId`,`count`),
 CONSTRAINT `HeadersRequest_ibfk_1` FOREIGN KEY (`entries_id`, `userId`, `count`) REFERENCES `entries` (`entries_id`, `userId`, `count`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

HeadersResponse 	
CREATE TABLE `HeadersResponse` (
 `multivalued` int NOT NULL,
 `entries_id` int NOT NULL,
 `userId` int NOT NULL,
 `count` int NOT NULL,
 `name` varchar(255) NOT NULL,
 `value` varchar(255) NOT NULL,
 PRIMARY KEY (`multivalued`,`entries_id`,`userId`,`count`),
 KEY `entries_id` (`entries_id`,`userId`,`count`),
 CONSTRAINT `HeadersResponse_ibfk_1` FOREIGN KEY (`entries_id`, `userId`, `count`) REFERENCES `entries` (`entries_id`, `userId`, `count`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

users 	
CREATE TABLE `users` (
 `id` int NOT NULL AUTO_INCREMENT,
 `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
 `usertype` tinyint(1) DEFAULT '1',
 `uploadCounter` int NOT NULL DEFAULT '0',
 `lastUpload` date DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8
