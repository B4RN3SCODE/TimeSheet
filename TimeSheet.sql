SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `AccountType` (
  `id` int(11) NOT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Description` varchar(200) NOT NULL DEFAULT 'no description'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `AccountType`;
INSERT INTO `AccountType` (`id`, `Type`, `Description`) VALUES
(1, 'Super User', 'Even more privileged than admin'),
(2, 'Admin', 'Administrative privileges ');

CREATE TABLE IF NOT EXISTS `Client` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Country` int(10) DEFAULT NULL,
  `StateOrProv` varchar(100) DEFAULT NULL,
  `Zip` varchar(10) DEFAULT NULL,
  `Priority` int(10) DEFAULT NULL,
  `Phone` varchar(17) DEFAULT NULL,
  `Contact` varchar(60) DEFAULT NULL,
  `StreetAddress` varchar(100) DEFAULT NULL,
  `StreetAddress2` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `Client`;
INSERT INTO `Client` (`id`, `Name`, `Country`, `StateOrProv`, `Zip`, `Priority`, `Phone`, `Contact`, `StreetAddress`, `StreetAddress2`, `City`) VALUES
(1, 'ACG Corporate Disbursements', 225, 'MI', '48121-0360', 1, '313-336-6937', '', 'PO Box 360', '', 'Dearborn'),
(2, 'Agile Technology Architects, LLC', 225, 'WI', '53146', 1, '414-433-4363', 'Jim Oberholtzer', '21305 W. Glengarry RD', '', 'New Berlin'),
(3, 'Al-Par Peat Co', 225, 'MI', '48831', 1, '989 661-7850', 'Shannon', 'Attn: Shannon', '59 Henderson Road', 'Elsie'),
(4, 'American Home Fitness', 225, 'MI', '48313-1141', 1, '586 737-2622', 'Eric Swanson', '44937 Schoenherr Rd', '', 'Sterling Hts'),
(5, 'American Seating', 225, 'MI', '49504', 1, '616-732-6622', 'Luanna Seyfert', 'Lenora Michaud', '401 American Seating Center N W', 'Grand Rapids'),
(6, 'Behler-Young Company', 225, 'MI', '49509', 1, '616-531-4400', 'Scott D - Svc Agreement A/P', 'Attn: Brian Toronyi', '4900 Clyde Park, SW', 'Grand Rapids'),
(7, 'Braxton-Reed, Inc', 225, 'IL', '60056', 1, '847 573-9363-Disc', 'George Stamatoukos', '411 E Business Center Dr', 'Suite 113', 'Mt.Prospect'),
(8, 'Center Manufacturing', 225, 'MI', '49315', 1, '616-878-3324', 'Jim Morris', '990 84th  SW', '', 'Byron Center'),
(9, 'Commercial Appraisal Services, LLC', 225, 'MI', '49505', 1, '616-498-1992', 'Tom Strotenbur', '1345 Monroe NW, Suite 332', '', 'Grand Rapids'),
(10, 'Corvac Composites, LLC', 225, 'MI', '49512', 1, '616-281-4167', 'Toni - Sales Coordinator - Handl', 'Christin Klomparens', '4450 36th St SE', 'Kentwood'),
(11, 'Coveris - Battle Creek', 225, 'MI', '49080', 1, '269-964-1161', 'Todd Maguire', '155 Brook Street', '', 'Battle Creek'),
(12, 'Credentials, Inc.', 225, 'IL', '60093-3083', 1, '847-716-3000', 'Jeffrey Geldermann', '1 Northfield Plaza, Suite 501', '', 'Northfield'),
(13, 'Dave Miedema', 225, 'MI', '49418', 1, '', 'Dave Meidema', '3083 Washington Ave SW', '', 'Grandville'),
(14, 'EPI Printers, Inc.', 225, 'MI', '49015', 1, '269-964-6744', 'Mitch Mauer', 'Accounts Payable', '5350 Dickman Rd W', 'Battle Creek'),
(15, 'ES Financial', 225, 'MI', '49512', 1, '616 942-5555', 'Robin Colles', 'Accounts Payable', '3200 Broardmoor Ave SE', 'Grand Rapids'),
(16, 'Family Christian Stores', 225, 'MI', '49512', 1, '', '', '5300 Patterson S E', '', 'Grand Rapids'),
(17, 'Five Star Real Estate', 225, 'MI', '49504', 1, '616 791-1500', 'Rhonda Farr', '4601 Lake Michigan Drive', '', 'Grand Rapids'),
(18, 'Flex & Gate Seeburn', 225, 'ON', 'L0G 1W0', 1, '905 936-4245', '', 'Division of Ventra Group', '65 Industrial Road', 'Tottenham'),
(19, 'Flex N Gate -  Warren', 225, 'MI', '48091', 1, '586 441-7400', 'Thomas Orr', 'Tom Orr', '5663 East 9 Mile Road', 'Warren'),
(20, 'Flex N Gate -Urbana', 225, 'IL', '61802', 1, '217 255-5023', 'Jeff Cole IT Dept', 'Accounts Payable', '1306 E. University Ave.', 'Urbana'),
(21, 'Franken i Technologies', 225, 'MI', '49333', 1, '', 'Larry Bolhuis', '7220 N Robertson Rd', '', 'Middleville'),
(22, 'FRS, Inc.', 225, 'SC', '29405-8263', 1, '843 723-9806', 'Carl Novit', 'Attn: Accounts Payable', '2695 Azalea Trail Drive, Ste B', 'North Charleston'),
(23, 'G R Housing Commission', 225, 'MI', '49507', 1, '616 262-7023', 'Andy Taylor', '1420 Fuller SE', '', 'Grand Rapids'),
(24, 'Grand Rapids Association of Realtors', 225, 'MI', '49546', 1, '616 241-2461', 'Rich Bauman', '660 Kenmoor S E', '', 'Grand Rapids'),
(25, 'Grand Rapids Label Company', 225, 'MI', '49505', 1, '616 459-8134', 'Peter Vawter', '2351 Oak Industrial Drive NE', '', 'Grand Rapids'),
(26, 'GRASP', 225, 'MI', '49505', 1, '616 819-2061', 'Judy Johnson/Director', 'Judy Johnson', '1720 Plainfield N E', 'Grand Rapids'),
(27, 'H & L Advantage', 225, 'MI', '49418', 1, '616 532-1012', 'Brad Alkema', '3500 Busch Drive', '', 'Grandville'),
(28, 'Hadley Products Corp', 225, 'MI', '49418', 1, '616-530-1717', 'Scott Finkhouse', '2851 Prairie St', '', 'Grandville'),
(29, 'Hadley Transit', 225, 'IN', '46418', 1, '574-266-3700', 'Jim Johnson', '2503 Marina Dr', '', 'Elkhart'),
(30, 'Hastings Manufacturing, Co.', 225, 'MI', '49058', 1, '', '', '325 N Hanover', '', 'Hastings'),
(31, 'Henry A. Fox Sales', 225, 'MI', '49512', 1, '616-949-1210  x10', 'Benjamin Fland - IT Coordinator', 'Accounts Payable', '4494 36th St S E', 'Grand Rapids'),
(32, 'Hines Corporation', 225, 'MI', '49456', 1, '', '', '1218 E. Pontaluna Suite B', '', 'Spring Lake'),
(33, 'Hitachi Cable America Inc', 225, 'FL', '32514', 1, '850-473-4224', 'Ronald Foreman', 'Accounts Payable', '9101 Ely Road', 'Pensacola'),
(34, 'Hope Health', 225, 'MI', '49009', 1, '800-334-4094', 'Megan Haan', '5937 West Main St.', '', 'Kalamazoo'),
(35, 'Hougen Manufacturing, Inc.', 225, 'MI', '48473-7935', 1, '810 635-7111x260', 'Wendy Tift', 'Wendy Tift', '30001 Hougen Drive', 'Swartz Creek'),
(36, 'Howard Miller Clock', 225, 'MI', '49464', 1, '616 772-9131', 'Butch Kraft', '860 E Main', '', 'Zeeland'),
(37, 'Humphrey Products, Inc.', 225, 'MI', '49048', 1, '269-216-5217', 'Patty Billingsley', 'Patty Billingsley', '5070 East N Ave', 'Kalamazoo'),
(38, 'IBM Corporation MN', 225, 'MN', '55901-1406', 1, '', '', 'Attn: Brian L. Warford', '3605 Hwy 52N', 'Rochester'),
(39, 'iIn The Cloud LLC', 225, 'MI', '49333', 1, '', 'Larry Bolhuis', '7220 N Robertson Rd', '', 'Middleville'),
(40, 'Integrated Distribution, Inc.', 225, 'MI', '49321-0347', 1, '647-0612', 'Kris Grace', 'PO Box 347', '', 'Comstock Park'),
(41, 'iTech Solutions Group, LLC', 225, 'CT', '06811', 1, '203 744-7854', 'Pete Massiello', '36 Mill Plain Rd, Suite 3', '', 'Danbury'),
(42, 'J M Wilson Corp', 225, 'MI', '49024', 1, '269 321-4718', 'Tammy Dodd', '8036 Moorsbridge Rd', '', 'Portage'),
(43, 'JB Poindexter & Co.', 225, 'TX', '77002', 1, '', '', 'Philip Stevens, CPSM', 'Strategic Sourcing Manager', 'Houston'),
(44, 'Johnston Boiler', 225, 'MI', '49409', 1, '', '', '300 Pine Street', '', 'Ferrysburg'),
(45, 'Kolene Corp', 225, 'MI', '48223', 1, '313 273-9220', 'Nancy Tolliver', '12890 Westwood ST', '', 'Detroit'),
(46, 'Mahle Engine Components USA', 225, 'MI', '49444', 1, '', 'Jim Toppen', '2020 Sanford St', '', 'Muskegon'),
(47, 'MarkSys', 225, 'MI', '49505', 1, '616-288-9263', '', '1345 Monroe NW, Ste 269', '', 'Grand Rapids'),
(48, 'Master Finish Company', 225, 'MI', '49507-7505', 1, '616-245-1228', 'John Mulde - Eng. Mgr', '2020 Nelson S E', 'P O Box 7505', 'Grand Rapids'),
(49, 'MedData', 225, 'OH', '44141', 1, '', 'Brad Porter', '6880 West Snowville Road, Suite 210', '', 'Brecksville'),
(50, 'Meddirect LLC', 225, 'MI', '49546', 1, '940-0500', '', '3855 Sparks Dr S E', '', 'Grand Rapids'),
(51, 'Michigan Blood', 225, 'MI', '49501-1704', 1, '616 233-8501', 'Doug Klynstra', 'P O Box 1704', '', 'Grand Rapids'),
(52, 'Michigan Wheel Corp', 225, 'MI', '49507', 1, '616 248-5317', 'Micki Rogers', '1501 Buchanan Ave  S W', '', 'Grand Rapids'),
(53, 'National Land Agency, Jamaica', 225, '', '', 1, '', '', '23 1/2 Charles Street', 'Kingston,', 'West Indies'),
(54, 'Nova Wildcat Amerock, LLC', 225, 'NC', '28117-9422', 1, '704-696-5127', '', '116 Exmore Road', '', 'Mooresville'),
(55, 'Novitex', 225, 'MI', '49588', 1, '888 823-7267 ex 2', 'Crystal Grant', 'PO Box 8881006', '', 'Grand Rapids'),
(56, 'Nu-Wool Inc', 225, 'MI', '49428', 1, '616 669-0100', 'Becky - A/P', '2472 Port Sheldon RD', '', 'Jenison'),
(57, 'Ottawa County Central Dispatch', 225, 'MI', '49460', 1, '616 842-2299', 'Joseph LaLonde', '12101 Stanton St.', '', 'West Olive'),
(58, 'Ottawa County MIS', 225, 'MI', '49460', 1, '616 738-4833', 'Mark Krouse', '12220 Fillmore Street Room 320', '', 'West Olive'),
(59, 'Packaging Corp Of America', 225, 'MI', '49634', 1, '231 723-9951', 'Val', '2246 Udell Street', '', 'Filer City'),
(60, 'Per-fit Company', 225, 'MI', '49503', 1, '616 247-6572', 'Scott Overlund', '728 S Division', '', 'Grand Rapids'),
(61, 'Precision Metal Products', 225, 'MI', '49422', 1, '616 392-3109', 'Brain Buchanan', 'Attn: Brian Buchanan', 'PO Box 1047', 'Holland'),
(62, 'PRIME Research', 225, 'MI', '48104', 1, '734-913-0348', 'Timo D. Thomann-Rompf', '309 Maynard Street, Ste 200', '', 'Ann Arbor'),
(63, 'Quality Edge', 225, 'MI', '49544', 1, '616 735-3833', 'Rick Simkins', '2712 Walkent Drive', '', 'Walker'),
(64, 'Richmond Reformed Church', 225, 'MI', '49504', 1, '', '', '1814 Walker NW', '', 'Grand Rapids'),
(65, 'Rietberg', 225, 'MI', '', 1, '616 551-4886', 'Andy Richt Mgr.', '3083 Washington Ave SW', '', 'Grandville'),
(66, 'Sidney State Bank', 225, '', '48885-9701', 1, '', '', '3016 W. Sidney Rd', '', 'Sidney MI'),
(67, 'Signworks', 225, 'MI', '49512', 1, '616-954-2554', '', 'Accounts payable', '4612 44th Street S E', 'Grand Rapids'),
(68, 'Statewide Windows', 225, 'IN', '46515-0987', 1, '', '', 'PO Box 987', '', 'Elkhart'),
(69, 'Suspa Incorporated', 225, 'MI', '49548', 1, '246-5400', 'Larry Brown', '3970 Roger B Chaffee SE', '', 'Grand Rapids'),
(70, 'Teamsters Union Local 406', 225, 'MI', '49426', 1, '', '', '3315 Eastern S E', '', 'Grand Rapids'),
(71, 'Topcraft Metal Products Inc', 225, 'MI', '49426', 1, '669-1790', '', 'Accounts Payable', '5112 40th Ave', 'Hudsonville'),
(72, 'Trelleborg Automotive USA, Inc.', 225, 'MI', '49090', 1, '', '', '400 Aylworth Avenue', '', 'South Haven'),
(73, 'Ventra - Evert LLC', 225, 'MI', '49631', 1, '231-734-9000  x92', 'Mark Apsey MIS Director', 'Attn: Mark Apsey', '601 West 7th Street', 'Evert'),
(74, 'Ventra - Salem', 225, 'OH', '44460', 1, '', '', '800 Pennsylvania Avenue', '', 'Salem'),
(75, 'Ventra Plastics - Spain', 35, 'ON', 'N2R 1G6', 1, '519-895-0290', 'Debbie Herman', 'Attn: Paula Anderson', '675 Trillium Drive', 'Kitchener'),
(76, 'West Michigan Rheumatology', 225, 'MI', '49546', 1, '', 'Mr. Brian Dempkey', '1155 East Paris Ave. SE, Suite 100', '', 'Grand Rapids'),
(77, 'WL Molding Company', 225, 'MI', '49024', 1, '269-327-3075', 'Dave Brightwell', 'Accounts Payable', '8212 Shaver Road', 'Portage'),
(78, 'Wolverine World Wide Inc', 225, 'OR', '97208-4776', 1, '616 863-3890', 'Diane Ten Eyck', 'Attn:  Accounts Payable', 'P.O. Box 4776', 'Portland'),
(80, 'Arbor Solutions', 225, 'MI', '49505', 0, '6164512500', '', '1345 Monroe NW, Suite 309', '', 'Grand Rapids');

CREATE TABLE IF NOT EXISTS `Country` (
  `id` int(11) NOT NULL,
  `Code` varchar(3) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `Country`;
INSERT INTO `Country` (`id`, `Code`) VALUES
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

CREATE TABLE IF NOT EXISTS `LineItem` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ClientId` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `EntryDate` date NOT NULL,
  `Hours` double NOT NULL DEFAULT '0',
  `Travel` double NOT NULL DEFAULT '0',
  `Billable` bit(1) DEFAULT b'1'
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `LineItem`;
INSERT INTO `LineItem` (`id`, `UserId`, `ClientId`, `ProjectId`, `Description`, `EntryDate`, `Hours`, `Travel`, `Billable`) VALUES
(9, 1, 10, 3, 'ASDF', '2015-11-04', 4, 0, b'1'),
(10, 1, 10, 3, 'FDSA', '2015-11-06', 3, 0, b'1'),
(17, 2, 24, 4, 'Upgrading MySQL, Upgrading revslider plugin to version 5.1.2, Updating member search and member detail scripts and displays, CSS changes and minor html markup changes', '2015-11-16', 4, 0, b'1'),
(18, 2, 80, 6, 'Updated summary to only display billing cycles that the user has line entries for. Fixed broken links.', '2015-11-17', 1, 0, b'1'),
(19, 2, 24, 4, 'Creating test Member Search page', '2015-11-17', 1, 0, b'1'),
(20, 2, 28, 5, 'Finding and resolving job running incorrectly for start/end shifts.', '2015-11-17', 2, 0, b'1'),
(21, 2, 24, 4, 'Backing up public site and database, finding and fixing broken images and url''s. (Testimonial image, 57-reasons links) Updated JS to fix #viewonmap toggle issue in Firefox/IE11. Buy/Sell display, determining cause of RPG hard error. Updated header for a more responsive layout.', '2015-11-18', 5, 0, b'1'),
(23, 2, 80, 6, 'Updated current user output spreadsheet for current billing cycle.', '2015-11-18', 1, 0, b'1'),
(24, 2, 28, 7, 'Added Submitted Date to Quote Report.', '2015-11-19', 0.25, 0, b'1'),
(25, 2, 24, 4, 'Home page Buy/Sell modifications and fixing bugs that lock the registration file if a user enters a blank email address or if they enter an email address that already exists in the file.', '2015-11-19', 3, 0, b'1'),
(32, 2, 80, 6, 'Fixed issue with inserting NULL values into LineItem table. Created Admin page and got individual user selection and output of their timesheets for selected cycle.', '2015-11-20', 5.5, 0, b'1'),
(33, 2, 24, 4, 'Google login, found out at IE issue is a Google bug. Updated button to most recent google button.', '2015-11-23', 2.5, 0, b'1'),
(34, 2, 28, 5, 'Updating lead times in Testelk22', '2015-11-24', 0.75, 0, b'1'),
(35, 2, 24, 4, 'Test page for RPG program, homepage design, neighborhood overlays', '2015-12-01', 6, 0, b'1'),
(36, 2, 80, 6, 'TimeSheet application, updating individual user spreadsheet design', '2015-11-23', 5, 0, b'1'),
(37, 2, 80, 6, 'Fixing forms not submitting numbers and validation along with creating all user timesheet script', '2015-11-24', 4, 0, b'1'),
(38, 2, 80, 6, 'Creating client timesheets', '2015-11-24', 3, 0, b'1'),
(39, 2, 24, 4, 'Neighborhood map, nearby searches, places api', '2015-12-02', 6, 0, b'1');

CREATE TABLE IF NOT EXISTS `Office` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Description` varchar(200) NOT NULL DEFAULT 'no description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `Office`;
CREATE TABLE IF NOT EXISTS `Project` (
  `id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `ClientId` int(11) DEFAULT NULL,
  `Title` varchar(50) NOT NULL DEFAULT 'New Project',
  `Description` varchar(100) NOT NULL DEFAULT 'General Project Description',
  `DateCreated` datetime DEFAULT NULL,
  `Rate` int(11) NOT NULL DEFAULT '0',
  `Active` bit(1) DEFAULT b'1',
  `InternalReference` varchar(50) DEFAULT NULL,
  `CustomerReference` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

TRUNCATE TABLE `Project`;
INSERT INTO `Project` (`id`, `UserId`, `ClientId`, `Title`, `Description`, `DateCreated`, `Rate`, `Active`, `InternalReference`, `CustomerReference`) VALUES
(1, 10, 29, 'Create Bin Locations', 'General description of project.', '2015-11-03 21:19:21', 70, b'1', NULL, NULL),
(2, 10, 19, 'Service Parts Expand Date', 'Increase the size of the field on the Service Parts entry screen (FCP018R)', '2015-11-03 21:21:18', 70, b'1', '982', '14696'),
(3, 10, 10, 'Turkish General Ledger Requirements', '', '2015-11-03 21:25:00', 70, b'1', '978', ''),
(4, 11, 24, 'Public Site', 'GRAR''s public website', '2015-11-04 13:16:10', 38, b'1', '', ''),
(5, 2, 28, 'OPIQ', 'General description of project.', '2015-11-05 00:08:08', 38, b'1', NULL, NULL),
(6, 2, 80, 'TimeSheet Application', 'General description of project.', '2015-11-17 15:11:21', 15, b'1', NULL, NULL),
(7, 2, 28, 'SMDB', 'Sales and Marketing Database', '2015-11-19 20:27:07', 38, b'1', '', '');

CREATE TABLE IF NOT EXISTS `ProjectItemProject` (
  `id` int(11) NOT NULL,
  `ProjectItemId` int(11) NOT NULL DEFAULT '0',
  `ProjectId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

TRUNCATE TABLE `ProjectItemProject`;
INSERT INTO `ProjectItemProject` (`id`, `ProjectItemId`, `ProjectId`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

CREATE TABLE IF NOT EXISTS `ProjectTimeSheet` (
  `id` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL DEFAULT '0',
  `TimeSheetId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

TRUNCATE TABLE `ProjectTimeSheet`;
INSERT INTO `ProjectTimeSheet` (`id`, `ProjectId`, `TimeSheetId`) VALUES
(1, 1, 1);

CREATE TABLE IF NOT EXISTS `TimeSheetPeriod` (
  `id` int(11) NOT NULL,
  `CycleStart` date NOT NULL,
  `CycleEnd` date NOT NULL,
  `Processed` bit(1) DEFAULT b'0'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

TRUNCATE TABLE `TimeSheetPeriod`;
INSERT INTO `TimeSheetPeriod` (`id`, `CycleStart`, `CycleEnd`, `Processed`) VALUES
(1, '2015-11-02', '2015-11-15', b'0'),
(3, '2015-10-19', '2015-11-01', b'0'),
(6, '2015-10-05', '2015-10-18', b'0'),
(9, '2015-11-16', '2015-11-29', b'0'),
(10, '2015-11-30', '2015-12-13', b'0');

CREATE TABLE IF NOT EXISTS `TimeSheetSettings` (
  `userId` int(11) NOT NULL,
  `DefaultClient` int(11) DEFAULT '0',
  `DefaultProject` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE TABLE `TimeSheetSettings`;
INSERT INTO `TimeSheetSettings` (`userId`, `DefaultClient`, `DefaultProject`) VALUES
(2, 24, 4);

CREATE TABLE IF NOT EXISTS `TimeSheetSubmit` (
  `UserId` int(11) NOT NULL,
  `PeriodId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE TABLE `TimeSheetSubmit`;
INSERT INTO `TimeSheetSubmit` (`UserId`, `PeriodId`) VALUES
(2, 9);

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `FirstName` varchar(30) DEFAULT NULL,
  `LastName` varchar(30) DEFAULT NULL,
  `AccountType` int(10) NOT NULL DEFAULT '0',
  `Password` varchar(150) DEFAULT NULL,
  `DateAdded` datetime DEFAULT NULL,
  `LastModified` datetime DEFAULT NULL,
  `Phone` varchar(17) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  `Restriction` int(10) NOT NULL DEFAULT '0',
  `Online` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

TRUNCATE TABLE `User`;
INSERT INTO `User` (`id`, `Email`, `FirstName`, `LastName`, `AccountType`, `Password`, `DateAdded`, `LastModified`, `Phone`, `Active`, `Restriction`, `Online`) VALUES
(1, 'tbarnes@arbsol.com', 'Tyler', 'Barnes', 1, '$2y$10$pbClvD.OBOoeLBnM5WLhPu3Xhh.7DPHxTRgTKPJOe.XcFiiLt2O1K', '2015-10-08 21:23:51', '2015-10-30 17:19:15', '6195773861', 1, 0, 1),
(2, 'cschaefer@arbsol.com', 'Christopher', 'Schaefer', 1, '$2y$10$PtSBL5gNiq.6vC9pRWj5DO4VM80eDjZLmGJSxoqSwZJR4eebmamfe', '2015-10-28 15:04:45', '2015-11-20 15:15:54', '2489829600', 1, 0, 0),
(10, 'spalma@arbsol.com', 'Scott', 'Palma', 1, '$2y$10$lVLA3vKDBMmrqubrogND9u2AoICD0/ItBH1b3rmg/dkiFfEglBFzK', '2015-11-02 13:58:27', '2015-11-02 13:58:27', '6166901728', 1, 0, NULL),
(11, 'rpalma@arbsol.com', 'Richie', 'Palma', 1, '$2y$10$dnN0MG7qjMuqKrsOj/DtG.snRT4lRrhbnxSFXerjfq1VwDx1xJNcm', '2015-11-04 14:13:45', '2015-11-07 03:57:35', '', 1, 0, 0);

CREATE TABLE IF NOT EXISTS `UserProjects` (
  `UserId` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE TABLE `UserProjects`;
INSERT INTO `UserProjects` (`UserId`, `ProjectId`) VALUES
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(11, 1),
(11, 2),
(11, 3);


ALTER TABLE `AccountType`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Client`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Country`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `LineItem`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Office`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `Project`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ProjectItemProject`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ProjectTimeSheet`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `TimeSheetPeriod`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `TimeSheetPeriod_CycleStart_uindex` (`CycleStart`),
  ADD UNIQUE KEY `TimeSheetPeriod_CycleEnd_uindex` (`CycleEnd`);

ALTER TABLE `TimeSheetSettings`
  ADD PRIMARY KEY (`userId`);

ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

ALTER TABLE `UserProjects`
  ADD PRIMARY KEY (`UserId`,`ProjectId`);


ALTER TABLE `AccountType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `Client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81;
ALTER TABLE `Country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=243;
ALTER TABLE `LineItem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
ALTER TABLE `Office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `Project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
ALTER TABLE `ProjectItemProject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
ALTER TABLE `ProjectTimeSheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
ALTER TABLE `TimeSheetPeriod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
