SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `cars` (
  `id` int NOT NULL,
  `make` varchar(30) NOT NULL,
  `model` varchar(60) NOT NULL,
  `year` int NOT NULL,
  `body_type` varchar(20) NOT NULL,
  `mileage` int NOT NULL,
  `availability` enum('AVAILABLE','WAITING','RESERVED') NOT NULL DEFAULT 'AVAILABLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `car_id` int NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `status` enum('WAITING','CONFIRMED','CANCELLED','ACTIVE','DONE') NOT NULL DEFAULT 'WAITING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
DELIMITER $$
CREATE TRIGGER `update_car_availability_on_insert` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
	DECLARE waiting_count INT;
    DECLARE active_count INT;
    DECLARE new_status TEXT;
    SET waiting_count = ( SELECT COUNT(*) FROM `reservations` WHERE `car_id`=NEW.car_id AND (`status`='WAITING' OR `status`='CONFIRMED'));
    SET active_count = ( SELECT COUNT(*) FROM `reservations` WHERE `car_id`=NEW.car_id AND (`status`='ACTIVE'));
    IF active_count>0 THEN
    	SET new_status='RESERVED';
    ELSEIF waiting_count>0 THEN
    	SET new_status='WAITING';
    ELSE
    	SET new_status='AVAILABLE';
    END IF;
	UPDATE `cars` SET `availability`=new_status WHERE `id`=NEW.car_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_car_availability_on_update` AFTER UPDATE ON `reservations` FOR EACH ROW BEGIN
	DECLARE waiting_count INT;
    DECLARE active_count INT;
    DECLARE new_status TEXT;
    SET waiting_count = ( SELECT COUNT(*) FROM `reservations` WHERE `car_id`=NEW.car_id AND (`status`='WAITING' OR `status`='CONFIRMED'));
    SET active_count = ( SELECT COUNT(*) FROM `reservations` WHERE `car_id`=NEW.car_id AND (`status`='ACTIVE'));
    IF active_count>0 THEN
    	SET new_status='RESERVED';
    ELSEIF waiting_count>0 THEN
    	SET new_status='WAITING';
    ELSE
    	SET new_status='AVAILABLE';
    END IF;
	UPDATE `cars` SET `availability`=new_status WHERE `id`=NEW.car_id;
END
$$
DELIMITER ;

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `type` enum('ADMIN','MODERATOR','CUSTOMER','BANNED') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'CUSTOMER',
  `email` varchar(120) NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`car_id`),
  ADD KEY `car_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `reservations`
  ADD CONSTRAINT `car_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
