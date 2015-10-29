/*
 * SQL for timesheet application
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 */

USE TimeSheet;

/* user table */
CREATE TABLE User (
	id INT NOT NULL AUTO_INCREMENT ,
	Email VARCHAR(100) NOT NULL ,
	FirstName VARCHAR(30) NULL DEFAULT NULL ,
	LastName VARCHAR(30) NULL ,
	AccountType INT(10) NOT NULL DEFAULT '0' ,
	Password VARCHAR(150) NULL DEFAULT NULL ,
	Sault VARCHAR(30) NULL DEFAULT NULL ,
	DateAdded DATETIME NULL DEFAULT NULL ,
	LastModified DATETIME NULL DEFAULT NULL ,
	Phone VARCHAR(17) NULL DEFAULT NULL ,
	Active TINYINT(1) NOT NULL DEFAULT '0' ,
	Restriction INT(10) NOT NULL DEFAULT '0' ,
	Online TINYINT(1) NULL DEFAULT '0' ,
	PRIMARY KEY (id),
	UNIQUE (Email)
) ENGINE = InnoDB;
/* end user table */

/* account type table */
CREATE TABLE AccountType (
	id INT NOT NULL AUTO_INCREMENT ,
	Type VARCHAR(30) NULL DEFAULT NULL ,
	Description VARCHAR(200) NOT NULL DEFAULT 'no description' ,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end account type table */

/* office table */
CREATE TABLE Office (
	id INT NOT NULL AUTO_INCREMENT ,
	Name VARCHAR(50) NULL DEFAULT NULL ,
	Description VARCHAR(200) NOT NULL DEFAULT 'no description' ,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end office table */

/* country table */
CREATE TABLE Country (
	id INT NOT NULL AUTO_INCREMENT ,
	Code VARCHAR(3) NULL DEFAULT NULL ,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end country table */

/* client table */
CREATE TABLE Client (
	id INT NOT NULL AUTO_INCREMENT ,
	Name VARCHAR(50) NULL DEFAULT NULL ,
	Country INT(10) NULL DEFAULT NULL ,
	StateOrProv VARCHAR(100) NULL DEFAULT NULL ,
	Zip VARCHAR(8) NULL DEFAULT NULL ,
	Priority INT(10) NULL DEFAULT NULL ,
	Phone VARCHAR(17) NULL DEFAULT NULL ,
	Contact VARCHAR(60) NOT NULL DEFAULT 'no contact person' ,
	StreetAddress VARCHAR(100) NULL DEFAULT NULL ,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end client table











/* country data */
INSERT INTO Country (id, Code) VALUES
(1, 'AD'),
(2, 'AE'),
(3, 'AF'),
(4, 'AG'),
(5, 'AI'),
(6, 'AL'),
(7, 'AM'),
(8, 'AO'),
(9, 'AQ'),
(10, 'AR'),
(11, 'AS'),
(12, 'AT'),
(13, 'AU'),
(14, 'AW'),
(15, 'AZ'),
(16, 'BA'),
(17, 'BB'),
(18, 'BD'),
(19, 'BE'),
(20, 'BF'),
(21, 'BG'),
(22, 'BH'),
(23, 'BI'),
(24, 'BJ'),
(25, 'BM'),
(26, 'BN'),
(27, 'BO'),
(28, 'BQ'),
(29, 'BR'),
(30, 'BS'),
(31, 'BT'),
(32, 'BW'),
(33, 'BY'),
(34, 'BZ'),
(35, 'CA'),
(36, 'CC'),
(37, 'CD'),
(38, 'CF'),
(39, 'CG'),
(40, 'CH'),
(41, 'CI'),
(42, 'CK'),
(43, 'CL'),
(44, 'CM'),
(45, 'CN'),
(46, 'CO'),
(47, 'CR'),
(48, 'CU'),
(49, 'CV'),
(50, 'CX'),
(51, 'CY'),
(52, 'CZ'),
(53, 'DE'),
(54, 'DJ'),
(55, 'DK'),
(56, 'DM'),
(57, 'DO'),
(58, 'DZ'),
(59, 'EC'),
(60, 'EE'),
(61, 'EG'),
(62, 'ER'),
(63, 'ES'),
(64, 'ET'),
(65, 'FI'),
(66, 'FJ'),
(67, 'FK'),
(68, 'FM'),
(69, 'FO'),
(70, 'FR'),
(71, 'GA'),
(72, 'GB'),
(73, 'GD'),
(74, 'GE'),
(75, 'GF'),
(76, 'GG'),
(77, 'GH'),
(78, 'GI'),
(79, 'GL'),
(80, 'GM'),
(81, 'GN'),
(82, 'GP'),
(83, 'GQ'),
(84, 'GR'),
(85, 'GS'),
(86, 'GT'),
(87, 'GU'),
(88, 'GW'),
(89, 'GY'),
(90, 'HK'),
(91, 'HN'),
(92, 'HR'),
(93, 'HT'),
(94, 'HU'),
(95, 'ID'),
(96, 'IE'),
(97, 'IL'),
(98, 'IM'),
(99, 'IN'),
(100, 'IO'),
(101, 'IQ'),
(102, 'IR'),
(103, 'IS'),
(104, 'IT'),
(105, 'JE'),
(106, 'JM'),
(107, 'JO'),
(108, 'JP'),
(109, 'KE'),
(110, 'KG'),
(111, 'KH'),
(112, 'KI'),
(113, 'KM'),
(114, 'KN'),
(115, 'KP'),
(116, 'KR'),
(117, 'KW'),
(118, 'KY'),
(119, 'KZ'),
(120, 'LA'),
(121, 'LB'),
(122, 'LC'),
(123, 'LI'),
(124, 'LK'),
(125, 'LR'),
(126, 'LS'),
(127, 'LT'),
(128, 'LU'),
(129, 'LV'),
(130, 'LY'),
(131, 'MA'),
(132, 'MC'),
(133, 'MD'),
(134, 'ME'),
(135, 'MF'),
(136, 'MG'),
(137, 'MH'),
(138, 'MK'),
(139, 'ML'),
(140, 'MM'),
(141, 'MN'),
(142, 'MO'),
(143, 'MP'),
(144, 'MQ'),
(145, 'MR'),
(146, 'MS'),
(147, 'MT'),
(148, 'MU'),
(149, 'MV'),
(150, 'MW'),
(151, 'MX'),
(152, 'MY'),
(153, 'MZ'),
(154, 'NA'),
(155, 'NC'),
(156, 'NE'),
(157, 'NF'),
(158, 'NG'),
(159, 'NI'),
(160, 'NL'),
(161, 'NO'),
(162, 'NP'),
(163, 'NR'),
(164, 'NU'),
(165, 'NZ'),
(166, 'OM'),
(167, 'PA'),
(168, 'PE'),
(169, 'PF'),
(170, 'PG'),
(171, 'PH'),
(172, 'PK'),
(173, 'PL'),
(174, 'PM'),
(175, 'PN'),
(176, 'PR'),
(177, 'PS'),
(178, 'PT'),
(179, 'PW'),
(180, 'PY'),
(181, 'QA'),
(182, 'RO'),
(183, 'RS'),
(184, 'RU'),
(185, 'RW'),
(186, 'SA'),
(187, 'SB'),
(188, 'SC'),
(189, 'SD'),
(190, 'SE'),
(191, 'SG'),
(192, 'SH'),
(193, 'SI'),
(194, 'SJ'),
(195, 'SK'),
(196, 'SL'),
(197, 'SM'),
(198, 'SN'),
(199, 'SO'),
(200, 'SR'),
(201, 'SS'),
(202, 'SV'),
(203, 'SX'),
(204, 'SY'),
(205, 'SZ'),
(206, 'TC'),
(207, 'TD'),
(208, 'TF'),
(209, 'TG'),
(210, 'TH'),
(211, 'TJ'),
(212, 'TK'),
(213, 'TL'),
(214, 'TM'),
(215, 'TN'),
(216, 'TO'),
(217, 'TR'),
(218, 'TT'),
(219, 'TV'),
(220, 'TW'),
(221, 'TZ'),
(222, 'UA'),
(223, 'UG'),
(224, 'UM'),
(225, 'US'),
(226, 'UY'),
(227, 'UZ'),
(228, 'VA'),
(229, 'VC'),
(230, 'VE'),
(231, 'VG'),
(232, 'VI'),
(233, 'VN'),
(234, 'VU'),
(235, 'WF'),
(236, 'WS'),
(237, 'XK'),
(238, 'YE'),
(239, 'YT'),
(240, 'ZA'),
(241, 'ZM'),
(242, 'ZW');
/* end country data */


/* projectitem table */
CREATE TABLE ProjectItem (
	id INT NOT NULL AUTO_INCREMENT ,
	UserId INT NULL DEFAULT NULL ,
	TimeStamp DATETIME NULL DEFAULT NULL,
	Description VARCHAR(250) NOT NULL DEFAULT 'General Task Description',
	TargetHours FLOAT(10) NULL DEFAULT NULL,
	ActualHours FLOAT(10) NULL DEFAULT NULL,
	IsComplete TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end projectitem table */


/* project table */
CREATE TABLE Project (
	id INT NOT NULL AUTO_INCREMENT ,
	UserId INT NULL DEFAULT NULL ,
	ClientId INT NULL DEFAULT NULL,
	Title VARCHAR(50) NOT NULL DEFAULT 'New Project',
	Description VARCHAR(100) NOT NULL DEFAULT 'General Project Description',
	DateCreated DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end project table */


/* timesheet table */
CREATE TABLE TimeSheet (
	id INT NOT NULL AUTO_INCREMENT ,
	Alias VARCHAR(50) NOT NULL DEFAULT 'New TimeSheet',
	UserId INT NULL DEFAULT NULL,
	PayWeekStart DATE NULL DEFAULT NULL,
	PayWeekEnd DATE NULL DEFAULT NULL,
	IsSubmitted TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end timesheet table */


/* ProjectItemProject table */
CREATE TABLE ProjectItemProject (
	id INT NOT NULL AUTO_INCREMENT ,
	ProjectItemId INT NOT NULL DEFAULT 0,
	ProjectId INT NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end ProjectItemProject table */

/* ProjectTimeSheet table */
CREATE TABLE ProjectTimeSheet (
	id INT NOT NULL AUTO_INCREMENT ,
	ProjectId INT NOT NULL DEFAULT 0,
	TimeSheetId INT NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
/* end ProjectTimeSheet table */
