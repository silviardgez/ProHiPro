USE `TEC`;

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
('9', 'UniversityManagement', 'UniversityManagement');


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
('45','9','5');

INSERT INTO `USER` (`login`,`password`,`dni`, `name`,`surname`,`email`,`address`,`telephone`) VALUES
('admin','21232f297a57a5a743894a0e4a801fc3' , '111222333A','Administrador','Administrador', 'admin@admin.com', 'address', '666555444');

INSERT INTO `ROLE` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Role with all permissions'),
(2, 'BasicUser', 'Role with the basic permissions'),
(3, 'Test', 'Role to test');

INSERT INTO `USER_ROLE` (`user_id`,`role_id`) VALUES
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

