--
-- RATE LIMITTING
--

CREATE TABLE `rate_limited_ips` (
	`ip` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`blocked` TINYINT(1) NOT NULL DEFAULT 0,
	`tries` INT(1) NOT NULL DEFAULT 1,
	`cooldown` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO rate_limited_ips (ip, cooldown_until)
-- VALUES
-- (inet_aton('127.0.0.1'), NOW() + INTERVAL 5 MINUTE);
