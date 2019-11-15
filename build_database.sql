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
--
-- GIVES PERMISSION OF USE AND DELETES THE USER THAT WE WANT TO CREATE FOR THERE IS
--
GRANT USAGE ON * . * TO `userTEC`@`localhost`;
	DROP USER `userTEC`@`localhost`;
--
-- CREATES THE USER AND GIVES YOU PASSWORD - GIVES PERMIT OF USE AND GIVES PERMITS ON THE DATABASE
--
CREATE USER IF NOT EXISTS `userTEC`@`localhost` IDENTIFIED BY 'passTEC';
GRANT USAGE ON *.* TO `userTEC`@`localhost` REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `TEC`.* TO `userTEC`@`localhost` WITH GRANT OPTION;
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
  `IdRole` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdRole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `USER_GROUP`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `USER_ROLE` (
  `IdUserRole` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdRole` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdUserRole`),
  FOREIGN KEY (`login`)
	REFERENCES `USER`(`login`),
  FOREIGN KEY (`IdRole`)
	REFERENCES `ROLE`(`IdRole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `FUNCTIONALITY`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `FUNCTIONALITY` (
  `IdFunctionality` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY(`IdFunctionality`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `ACTION`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `ACTION` (
  `IdAction` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY(`IdAction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `FUNC_ACTION`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `FUNC_ACTION` (
  `IdFuncAction` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `IdFunctionality` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `IdAction` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdFuncAction`),
  FOREIGN KEY (`IdFunctionality`)
	REFERENCES `FUNCTIONALITY`(`IdFunctionality`),
  FOREIGN KEY (`IdAction`)
	REFERENCES `ACTION`(`IdAction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `PERMISSION`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `PERMISSION` (
  `IdPermission` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `IdRole` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `IdFuncAction` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdPermission`),
  FOREIGN KEY (`IdRole`)
	REFERENCES `ROLE`(`IdRole`),
  FOREIGN KEY (`IdFuncAction`)
	REFERENCES `FUNC_ACTION`(`IdFuncAction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `ACADEMICCOURSE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `ACADEMICCOURSE` (
  `id_academic_course` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `academic_course_abbr` varchar(6) COLLATE latin1_spanish_ci NOT NULL UNIQUE,
  `start_year` int(4) COLLATE latin1_spanish_ci NOT NULL,
  `end_year` int(4) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`id_academic_course`)
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
  PRIMARY KEY(`IdUniversity`, `id_academic_course`),
  FOREIGN KEY (`id_academic_course`)
	REFERENCES `ACADEMICCOURSE`(`id_academic_course`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `UNIVERSITY` ADD UNIQUE KEY `uidx` (`academic_course_id`, `name`);
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `CENTER`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `CENTER` (
  `IdCenter` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdUniversity` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `location` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdCenter`, `IdUniversity`),
  FOREIGN KEY (`IdUniversity`) 
	REFERENCES `UNIVERSITY`(`IdUniversity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `BUILDING`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `BUILDING` (
  `IdBuilding` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdCenter` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdBuilding`, `IdCenter`),
  FOREIGN KEY (`IdCenter`) 
	REFERENCES `CENTER`(`IdCenter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SPACE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SPACE` (
  `IdSpace` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdBuilding` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdSpace`, `IdBuilding`),
  FOREIGN KEY (`IdBuilding`) 
	REFERENCES `BUILDING`(`IdBuilding`)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `DEGREE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `DEGREE` (
  `IdDegree` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdCenter` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdDegree`, `IdCenter`),
  FOREIGN KEY (`IdCenter`) 
	REFERENCES `CENTER`(`IdCenter`)   
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SUBJECT`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SUBJECT` (
  `IdSubject` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdDegree` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdSubject`, `IdDegree`),
  FOREIGN KEY (`IdDegree`) 
	REFERENCES `DEGREE`(`IdDegree`)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SUBJECT_GROUP`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SUBJECT_GROUP` (
  `IdSubjectGroup` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdSubject` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdSubjectGroup`, `IdSubject`),
  FOREIGN KEY (`IdSubject`) 
	REFERENCES `SUBJECT`(`IdSubject`)    
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `TEACHER`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `TEACHER` (
  `IdTeacher` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `dni` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `surname` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `address` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `telephone` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdTeacher`)   
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `TUTORIAL`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `TUTORIAL` (
  `IdTutorial` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,
  `IdTeacher` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `start_date` datetime COLLATE latin1_spanish_ci NOT NULL,
  `end_date` datetime COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdTutorial`, `IdTeacher`),
  FOREIGN KEY (`IdTeacher`) 
	REFERENCES `TEACHER`(`IdTeacher`)      
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `DEPARTMENT`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `DEPARTMENT` (
  `IdDepartment` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdResponsable` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdDepartment`, `IdResponsable`),
  FOREIGN KEY (`IdResponsable`) 
	REFERENCES `TEACHER`(`IdTeacher`)   
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- TABLE STRUCTURE FOR TABLE `SCHEDULE`
-- --------------------------------------------------------
-- --------------------------------------------------------
CREATE TABLE `SCHEDULE` (
  `IdSchedule` int(8) COLLATE latin1_spanish_ci NOT NULL AUTO_INCREMENT,  
  `IdSpace` int(8) COLLATE latin1_spanish_ci NOT NULL,  
  `IdTeacher` int(8) COLLATE latin1_spanish_ci NOT NULL,  
  `IdSubjectGroup` int(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdSchedule`, `IdSpace`, `IdTeacher`, `IdSubjectGroup`),
  FOREIGN KEY (`IdSpace`) 
	REFERENCES `SPACE`(`IdSpace`),
  FOREIGN KEY (`IdTeacher`) 
	REFERENCES `TEACHER`(`IdTeacher`),
  FOREIGN KEY (`IdSubjectGroup`) 
	REFERENCES `SUBJECT_GROUP`(`IdSubjectGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

INSERT INTO `ACTION` (`IdAction`, `name`, `description`) VALUES
('1', 'ADD', 'ADD'),
('2', 'DELETE', 'DELETE'),
('3', 'EDIT', 'EDIT'),
('4', 'SHOWCURRENT', 'SHOWCURRENT'),
('5', 'SHOWALL', 'SHOWALL');

INSERT INTO `FUNCTIONALITY` (`IdFunctionality`, `name`, `description`) VALUES
('1', 'UserManagement', 'UserManagement'),
('2', 'RoleManagement', 'RoleManagement'),
('3', 'FunctionalityManagement', 'FunctionalityManagement'),
('4', 'ActionManagement', 'ActionManagement'),
('5', 'PermissionManagement', 'PermissionManagement'),
('6', 'AcademicCourseManagement', 'AcademicCourseManagement'),
('7', 'FuncActionManagement', 'FuncActionManagement'),
('8', 'UserRoleManagement', 'UserRoleManagement'),
('9', 'UniversityManagement', 'UniversityManagement');


INSERT INTO `FUNC_ACTION` (`IdFuncAction`,`IdFunctionality`, `IdAction`) VALUES
('1','1','1'),
('2','1','2'),
('3','1','3'),
('4','1','4'),
('5','1','5'),
('6','2','1'),
('7','2','2'),
('8','2','3'),
('9','2','4'),
('10','2','5'),
('11','3','1'),
('12','3','2'),
('13','3','3'),
('14','3','4'),
('15','3','5'),
('16','4','1'),
('17','4','2'),
('18','4','3'),
('19','4','4'),
('20','4','5'),
('21','5','1'),
('22','5','2'),
('23','5','3'),
('24','5','4'),
('25','5','5'),
('26','6','1'),
('27','6','2'),
('28','6','3'),
('29','6','4'),
('30','6','5'),
('31','7','1'),
('32','7','2'),
('33','7','3'),
('34','7','4'),
('35','7','5'),
('36','8','1'),
('37','8','2'),
('38','8','3'),
('39','8','4'),
('40','8','5'),
('41','9','1'),
('42','9','2'),
('43','9','3'),
('44','9','4'),
('45','9','5');

INSERT INTO `USER` (`login`,`password`,`dni`, `name`,`surname`,`email`,`address`,`telephone`) VALUES
('admin','21232f297a57a5a743894a0e4a801fc3' , '111222333A','Administrador','Administrador', 'admin@admin.com', 'address', '666555444');

INSERT INTO `ROLE` (`IdRole`, `name`, `description`) VALUES
('1', 'Admin', 'Role with all permissions'),
('2', 'BasicUser', 'Role with the basic permissions'),
('3', 'Test', 'Role to test');

INSERT INTO `USER_ROLE` (`login`,`IdRole`) VALUES
('admin', 1);

INSERT INTO `PERMISSION` (`role_id`,`func_action_id`) VALUES
(1,'1'),
(1,'2'),
(1,'3'),
(1,'4'),
(1,'5'),
(1,'6'),
(1,'7'),
(1,'8'),
(1,'9'),
(1,'10'),
(1,'11'),
(1,'12'),
(1,'13'),
(1,'14'),
(1,'15'),
(1,'16'),
(1,'17'),
(1,'18'),
(1,'19'),
(1,'20'),
(1,'21'),
(1,'22'),
(1,'23'),
(1,'24'),
(1,'25'),
(1,'26'),
(1,'27'),
(1,'28'),
(1,'29'),
(1,'30'),
(1,'31'),
(1,'32'),
(1,'33'),
(1,'34'),
(1,'35'),
(1,'36'),
(1,'37'),
(1,'38'),
(1,'39'),
(1,'40'),
(1,'41'),
(1,'42'),
(1,'43'),
(1,'44'),
(1,'45');

INSERT INTO `ACADEMIC_COURSE` (`id`, `academic_course_abbr`, `start_year`, `end_year`) VALUES
(1, '18/19', '2018', '2019'),
(2, '19/20', '2019', '2020'),
(3, '20/21', '2020', '2021');

