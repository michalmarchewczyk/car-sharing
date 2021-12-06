SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db`;

DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars` (
  `id` int NOT NULL,
  `model_id` int NOT NULL,
  `year` int NOT NULL,
  `mileage` int NOT NULL,
  `color` varchar(20) NOT NULL,
  `availability` enum('AVAILABLE','WAITING','RESERVED') NOT NULL DEFAULT 'AVAILABLE',
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `car_models`;
CREATE TABLE `car_models` (
  `id` int NOT NULL,
  `make` varchar(30) NOT NULL,
  `model` varchar(60) NOT NULL,
  `body_type` varchar(20) NOT NULL,
  `number_of_seats` int NOT NULL,
  `power` int NOT NULL,
  `transmission` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE `configuration` (
  `name` varchar(20) NOT NULL,
  `value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `configuration` (`name`, `value`) VALUES
('current_timestamp', 1642610375);

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `car_id` int NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `status` enum('WAITING','CONFIRMED','CANCELLED','ACTIVE','DONE') NOT NULL DEFAULT 'WAITING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
DROP TRIGGER IF EXISTS `update_car_availability_on_insert`;
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
DROP TRIGGER IF EXISTS `update_car_availability_on_update`;
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

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `type` enum('ADMIN','MODERATOR','CUSTOMER','BANNED','WAITING') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'WAITING',
  `email` varchar(120) NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_model` (`model_id`);

ALTER TABLE `car_models`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `configuration`
  ADD PRIMARY KEY (`name`);

ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`car_id`),
  ADD KEY `car_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `car_models`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `cars`
  ADD CONSTRAINT `car_model` FOREIGN KEY (`model_id`) REFERENCES `car_models` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `reservations`
  ADD CONSTRAINT `car_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

DELIMITER $$
DROP EVENT IF EXISTS `reset_timestamp`$$
CREATE DEFINER=`devuser`@`%` EVENT `reset_timestamp` ON SCHEDULE EVERY 1 SECOND STARTS '2021-12-05 20:02:37' ON COMPLETION NOT PRESERVE DISABLE DO UPDATE configuration SET value=UNIX_TIMESTAMP() WHERE name='current_timestamp'$$

DROP EVENT IF EXISTS `skip_backward`$$
CREATE DEFINER=`devuser`@`%` EVENT `skip_backward` ON SCHEDULE EVERY 5 SECOND STARTS '2021-12-05 20:09:26' ON COMPLETION NOT PRESERVE DISABLE DO UPDATE configuration SET value=value-86400 WHERE name='current_timestamp'$$

DROP EVENT IF EXISTS `skip_forward`$$
CREATE DEFINER=`devuser`@`%` EVENT `skip_forward` ON SCHEDULE EVERY 5 SECOND STARTS '2021-12-05 20:08:42' ON COMPLETION NOT PRESERVE DISABLE DO UPDATE configuration SET value=value+86400 WHERE name='current_timestamp'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
