SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- DATABASE: TEC(TEACHING EXECUTION CONTROL)
--
-- CREATES THE DATABASE DELETING IT IF IT ALREADY EXISTS
--
DROP DATABASE IF EXISTS `TEC`;
CREATE DATABASE `TEC` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
--
-- SELECTS FOR USE
--
USE `TEC`;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `USER`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `USER` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `dni` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `surname` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `address` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `telephone` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`login`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `ROLE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `ROLE` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `description` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `USER_GROUP`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `USER_ROLE` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `user_id` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `role_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`user_id`)
	REFERENCES `USER`(`login`),
  FOREIGN KEY (`role_id`)
	REFERENCES `ROLE`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `USER_ROLE` ADD UNIQUE KEY `uidx` (`user_id`, `role_id`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `FUNCTIONALITY`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `FUNCTIONALITY` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `ACTION`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `ACTION` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `FUNC_ACTION`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `FUNC_ACTION` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `functionality_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `action_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`functionality_id`)
	REFERENCES `FUNCTIONALITY`(`id`),
  FOREIGN KEY (`action_id`)
	REFERENCES `ACTION`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `FUNC_ACTION` ADD UNIQUE KEY `uidx` (`functionality_id`, `action_id`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `PERMISSION`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `PERMISSION` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `role_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `func_action_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`role_id`)
	REFERENCES `ROLE`(`id`),
  FOREIGN KEY (`func_action_id`)
	REFERENCES `FUNC_ACTION`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `PERMISSION` ADD UNIQUE KEY `uidx` (`role_id`, `func_action_id`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `ACADEMIC_COURSE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `ACADEMIC_COURSE` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `academic_course_abbr` varchar(6) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `start_year` int(4) COLLATE latin1_spanish_ci NOT NULL,
  `end_year` int(4) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `UNIVERSITY`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `UNIVERSITY` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `academic_course_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `user_id` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `academic_course_id`),
  FOREIGN KEY (`academic_course_id`)
	REFERENCES `ACADEMIC_COURSE`(`id`),
  FOREIGN KEY (`user_id`)
    REFERENCES `USER`(`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `UNIVERSITY` ADD UNIQUE KEY `uidx` (`academic_course_id`, `name`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `BUILDING`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `BUILDING` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `location` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `user_id` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`Id`),
  FOREIGN KEY (`user_id`)
    REFERENCES `USER`(`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `BUILDING` ADD UNIQUE KEY `uidx` (`location`, `name`, `user_id`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `CENTER`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `CENTER` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `university_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `building_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `user_id` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`university_id`)
	REFERENCES `UNIVERSITY`(`id`),
  FOREIGN KEY (`user_id`)
    REFERENCES `USER`(`login`),
  FOREIGN KEY (`building_id`)
    REFERENCES `BUILDING`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `CENTER` ADD UNIQUE KEY `uidx` (`university_id`, `name`, `user_id`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SPACE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SPACE` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `building_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `capacity` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `office` bit COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `building_id`),
  FOREIGN KEY (`building_id`) 
	REFERENCES `BUILDING`(`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
ALTER TABLE `SPACE` ADD UNIQUE KEY `uidx` (`building_id`, `name`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `DEGREE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `DEGREE` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `center_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `capacity` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `credits` int(3) COLLATE latin1_spanish_ci NOT NULL,
  `user_id` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `center_id`),
  FOREIGN KEY (`center_id`)
	REFERENCES `CENTER`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SUBJECT`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SUBJECT` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `degree_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `degree_id`),
  FOREIGN KEY (`degree_id`)
	REFERENCES `DEGREE`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SUBJECT_GROUP`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SUBJECT_GROUP` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `subject_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`, `subject_id`),
  FOREIGN KEY (`subject_id`)
	REFERENCES `SUBJECT`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `TEACHER`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `TEACHER` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `user_id` varchar(9) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `space_id` int(8) COLLATE latin1_spanish_ci,
  `dedication` varchar(4) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`space_id`)
	REFERENCES `SPACE`(`id`),
  FOREIGN KEY (`user_id`)
	REFERENCES `USER`(`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `TUTORIAL`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `TUTORIAL` (
  `IdTutorial` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `teacher_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `start_date` datetime COLLATE latin1_spanish_ci NOT NULL,
  `end_date` datetime COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdTutorial`, `teacher_id`),
  FOREIGN KEY (`teacher_id`)
	REFERENCES `TEACHER`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `DEPARTMENT`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `DEPARTMENT` (
  `id` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `code` varchar(6) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `teacher_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`teacher_id`)
	REFERENCES `TEACHER`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SCHEDULE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SCHEDULE` (
  `IdSchedule` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `space_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `teacher_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `subject_group_id` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdSchedule`, `space_id`, `teacher_id`, `subject_group_id`),
  FOREIGN KEY (`space_id`)
	REFERENCES `SPACE`(`id`),
  FOREIGN KEY (`teacher_id`)
	REFERENCES `TEACHER`(`id`),
  FOREIGN KEY (`subject_group_id`)
	REFERENCES `SUBJECT_GROUP`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

