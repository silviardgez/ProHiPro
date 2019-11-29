INSERT INTO `ACTION` (`id`, `name`, `description`) VALUES
('1', 'ADD', 'ADD'),
('2', 'DELETE', 'DELETE'),
('3', 'EDIT', 'EDIT'),
('4', 'SHOWCURRENT', 'SHOWCURRENT'),
('5', 'SHOWALL', 'SHOWALL');

INSERT INTO `FUNCTIONALITY` (`id`, `name`, `description`) VALUES
('1', 'UserManagement', 'UserManagement'),
('2', 'RoleManagement', 'RoleManagement'),
('3', 'FunctionalityManagement', 'FunctionalityManagement'),
('4', 'ActionManagement', 'ActionManagement'),
('5', 'PermissionManagement', 'PermissionManagement'),
('6', 'AcademicCourseManagement', 'AcademicCourseManagement'),
('7', 'FuncActionManagement', 'FuncActionManagement'),
('8', 'UserRoleManagement', 'UserRoleManagement'),
('9', 'UniversityManagement', 'UniversityManagement'),
('10', 'CenterManagement', 'CenterManagement'),
('11', 'BuildingManagement', 'BuildingManagement'),
('12', 'SpaceManagement', 'SpaceManagement'),
('13', 'DegreeManagement', 'DegreeManagement'),
('14', 'DepartmentManagement', 'DepartmentManagement'),
('15', 'TeacherManagement', 'TeacherManagement'),
('16', 'SubjectManagement', 'SubjectManagement'),
('17', 'SubjectTeacherManagement', 'SubjectTeacherManagement'),
('18', 'SubjectGroupManagement', 'SubjectGroupManagement'),
('19', 'TutorialManagement', 'TutorialManagement');



INSERT INTO `FUNC_ACTION` (`id`,`functionality_id`, `action_id`) VALUES
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
('45','9','5'),
('46','10','1'),
('47','10','2'),
('48','10','3'),
('49','10','4'),
('50','10','5'),
('51','11','1'),
('52','11','2'),
('53','11','3'),
('54','11','4'),
('55','11','5'),
('56','12','1'),
('57','12','2'),
('58','12','3'),
('59','12','4'),
('60','12','5'),
('61','13','1'),
('62','13','2'),
('63','13','3'),
('64','13','4'),
('65','13','5'),
('66','14','1'),
('67','14','2'),
('68','14','3'),
('69','14','4'),
('70','14','5'),
('71','15','1'),
('72','15','2'),
('73','15','3'),
('74','15','4'),
('75','15','5'),
('76','16','1'),
('77','16','2'),
('78','16','3'),
('79','16','4'),
('80','16','5'),
('81','17','1'),
('82','17','2'),
('83','17','3'),
('84','17','4'),
('85','17','5'),
('86','18','1'),
('87','18','2'),
('88','18','3'),
('89','18','4'),
('90','18','5'),
('91','19','1'),
('92','19','2'),
('93','19','3'),
('94','19','4'),
('95','19','5');

INSERT INTO `USER` (`login`,`password`,`dni`, `name`,`surname`,`email`,`address`,`telephone`) VALUES
('admin','21232f297a57a5a743894a0e4a801fc3' , '11122233P','Administrador','Administrador', 'admin@admin.com', 'address', '666555444'),
('gestuniv','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestUniv','GestUniv', 'GestUniv@GestUniv.com', 'address', '666555444'),
('gestcent','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestCent','GestCent', 'GestCent@GestCent.com', 'address', '666555444'),
('gestbuil','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestBuil','GestBuil', 'GestBuil@GestBuil.com', 'address', '666555444'),
('gestdeg','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestDegree','GestDegree', 'GestDegree@GestDegree.com', 'address', '666555444'),
('gestdep','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestDepartment','GestDepartment', 'GestDepartment@GestDepartment.com', 'address', '666555444'),
('gestsub','21232f297a57a5a743894a0e4a801fc3' , '11122233P','GestSubject','GestSubject', 'GestSubject@GestSubject.com', 'address', '666555444'),
('teacher','21232f297a57a5a743894a0e4a801fc3' , '11122233P','Teacher','Teacher', 'teacher@teacher.com', 'address', '666555444');

INSERT INTO `ROLE` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Role with all permissions'),
(2, 'GestUniv', 'Role with University Owner permissions'),
(3, 'GestCent', 'Role with Center Owner permissions'),
(4, 'GestBuil', 'Role with Building Owner permissions'),
(5, 'GestDegree', 'Role with Degree Owner permissions'),
(6, 'GestDepartment', 'Role with Department Owner permissions'),
(7, 'Teacher', 'Role with Teacher permissions'),
(8, 'BasicUser', 'Role with the basic permissions'),
(9, 'Test', 'Role to test');

INSERT INTO `USER_ROLE` (`user_id`,`role_id`) VALUES
('admin', 1),
('gestuniv', 2),
('gestcent', 3),
('gestbuil', 4),
('gestdeg', 5),
('gestdep', 6),
('gestsub', 7),
('teacher', 7);

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
(1,'45'),
(1,'46'),
(1,'47'),
(1,'48'),
(1,'49'),
(1,'50'),
(1,'51'),
(1,'52'),
(1,'53'),
(1,'54'),
(1,'55'),
(1,'56'),
(1,'57'),
(1,'58'),
(1,'59'),
(1,'60'),
(1,'61'),
(1,'62'),
(1,'63'),
(1,'64'),
(1,'65'),
(1,'66'),
(1,'67'),
(1,'68'),
(1,'69'),
(1,'70'),
(1,'71'),
(1,'72'),
(1,'73'),
(1,'74'),
(1,'75'),
(1,'76'),
(1,'77'),
(1,'78'),
(1,'79'),
(1,'80'),
(1,'81'),
(1,'82'),
(1,'83'),
(1,'84'),
(1,'85'),
(1,'86'),
(1,'87'),
(1,'88'),
(1,'89'),
(1,'90'),
(1,'91'),
(1,'92'),
(1,'93'),
(1,'94'),
(1,'95'),
(2,'46'),
(2,'47'),
(2,'48'),
(2,'49'),
(2,'50'),
(2,'43'),
(2,'44'),
(2,'45'),
(2,'51'),
(2,'54'),
(2,'55'),
(2,'66'),
(2,'67'),
(2,'68'),
(2,'69'),
(2,'70'),
(2,'71'),
(2,'72'),
(2,'73'),
(2,'74'),
(2,'75'),
(3,'49'),
(3,'50'),
(3,'61'),
(3,'62'),
(3,'63'),
(3,'64'),
(3,'65'),
(4,'52'),
(4,'53'),
(4,'54'),
(4,'55'),
(4,'56'),
(4,'57'),
(4,'58'),
(4,'59'),
(4,'60'),
(5,'64'),
(5,'65'),
(6,'71'),
(6,'72'),
(6,'73'),
(6,'74'),
(6,'75'),
(6,'76'),
(6,'77'),
(6,'78'),
(6,'79'),
(6,'80'),
(6,'81'),
(6,'82'),
(6,'83'),
(6,'84'),
(6,'85'),
(7,'78'),
(7,'79'),
(7,'80'),
(7,'85'),
(7,'86'),
(7,'87'),
(7,'88'),
(7,'89'),
(7,'90'),
(7,'91'),
(7,'92'),
(7,'93'),
(7,'94'),
(7,'95');

INSERT INTO `ACADEMIC_COURSE` (`id`, `academic_course_abbr`, `start_year`, `end_year`) VALUES
(1, '18/19', '2018', '2019'),
(2, '19/20', '2019', '2020'),
(3, '20/21', '2020', '2021');