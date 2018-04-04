
--
-- SHT.GR SCHEMA
-- CREATED BY TASOS PAPALYRAS
--

--
-- OPTIONS
--

CREATE TABLE `options` (
	`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`option` VARCHAR(64) NOT NULL UNIQUE,
	`value` VARCHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO options (option, value)
VALUES
('hash', NULL);