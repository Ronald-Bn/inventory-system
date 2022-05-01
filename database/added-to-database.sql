ALTER TABLE product_list
ADD remarks varchar(255) NOT NULL;

UPDATE `product_list` SET `remarks` = 'Walang level' WHERE `product_list`.`id` = 1;

CREATE TABLE `tblattempts` (
  `id` int(30) NOT NULL,
  `attempts` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tblattempts` (`id`, `attempts`) VALUES
(1, 1);

