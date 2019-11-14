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
  `IdUniversity` int(8) COLLATE latin1_spanish_ci NOT NULL,  
  `id_academic_course` int(8) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY(`IdUniversity`, `id_academic_course`),
  FOREIGN KEY (`id_academic_course`) 
	REFERENCES `ACADEMICCOURSE`(`id_academic_course`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
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

