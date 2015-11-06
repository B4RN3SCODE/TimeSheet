-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2015 at 04:08 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `TimeSheet`
--

-- --------------------------------------------------------

--
-- Table structure for table `AccountType`
--

CREATE TABLE IF NOT EXISTS `AccountType` (
  `id` int(11) NOT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Description` varchar(200) NOT NULL DEFAULT 'no description'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AccountType`
--

INSERT INTO `AccountType` (`id`, `Type`, `Description`) VALUES
(1, 'Super User', 'Even more privileged than admin'),
(2, 'Admin', 'Administrative privileges ');

-- --------------------------------------------------------

--
-- Table structure for table `Client`
--

CREATE TABLE IF NOT EXISTS `Client` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Country` int(10) DEFAULT NULL,
  `StateOrProv` varchar(100) DEFAULT NULL,
  `Zip` varchar(8) DEFAULT NULL,
  `Priority` int(10) DEFAULT NULL,
  `Phone` varchar(17) DEFAULT NULL,
  `Contact` varchar(60) NOT NULL DEFAULT 'no contact person',
  `StreetAddress` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Client`
--

INSERT INTO `Client` (`id`, `Name`, `Country`, `StateOrProv`, `Zip`, `Priority`, `Phone`, `Contact`, `StreetAddress`) VALUES
(1, 'Test Client', 225, 'California', '92124', 1, '6195773861', 'Tyler Barnes', '11112 Portobelo Drive');

-- --------------------------------------------------------

--
-- Table structure for table `Country`
--

CREATE TABLE IF NOT EXISTS `Country` (
  `id` int(11) NOT NULL,
  `Code` varchar(3) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Country`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `Office`
--

CREATE TABLE IF NOT EXISTS `Office` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Description` varchar(200) NOT NULL DEFAULT 'no description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Project`
--

CREATE TABLE IF NOT EXISTS `Project` (
  `id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `ClientId` int(11) DEFAULT NULL,
  `Title` varchar(50) NOT NULL DEFAULT 'New Project',
  `Description` varchar(100) NOT NULL DEFAULT 'General Project Description',
  `DateCreated` datetime DEFAULT NULL,
  `Rate` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Project`
--

INSERT INTO `Project` (`id`, `UserId`, `ClientId`, `Title`, `Description`, `DateCreated`, `Rate`) VALUES
(1, 1, 1, 'Test Project', 'This project doesn''t really exist', '2015-10-29 11:28:40', 0),
(2, 2, 1, 'Tinkle DN', 'Don''t know don''t care.', '2015-10-31 18:50:44', 50);

-- --------------------------------------------------------

--
-- Table structure for table `ProjectItem`
--

CREATE TABLE IF NOT EXISTS `ProjectItem` (
  `id` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Description` varchar(250) NOT NULL DEFAULT 'General Task Description',
  `Hours` float DEFAULT NULL,
  `Billable` bit(1) NOT NULL DEFAULT b'1',
  `TimeStamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ProjectItemProject`
--

CREATE TABLE IF NOT EXISTS `ProjectItemProject` (
  `id` int(11) NOT NULL,
  `ProjectItemId` int(11) NOT NULL DEFAULT '0',
  `ProjectId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ProjectItemProject`
--

INSERT INTO `ProjectItemProject` (`id`, `ProjectItemId`, `ProjectId`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ProjectTimeSheet`
--

CREATE TABLE IF NOT EXISTS `ProjectTimeSheet` (
  `id` int(11) NOT NULL,
  `ProjectId` int(11) NOT NULL DEFAULT '0',
  `TimeSheetId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ProjectTimeSheet`
--

INSERT INTO `ProjectTimeSheet` (`id`, `ProjectId`, `TimeSheetId`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TimeSheet`
--

CREATE TABLE IF NOT EXISTS `TimeSheet` (
  `id` int(11) NOT NULL,
  `Alias` varchar(50) NOT NULL DEFAULT 'New TimeSheet',
  `UserId` int(11) DEFAULT NULL,
  `PayWeekStart` date DEFAULT NULL,
  `PayWeekEnd` date DEFAULT NULL,
  `IsSubmitted` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TimeSheet`
--

INSERT INTO `TimeSheet` (`id`, `Alias`, `UserId`, CycleStart, CycleEnd, `IsSubmitted`) VALUES
(1, 'Test TimeSheet', 1, '2015-10-25', '2015-11-09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `TimeSheetSettings`
--

CREATE TABLE IF NOT EXISTS `TimeSheetSettings` (
  `userId` int(11) NOT NULL,
  `DefaultClient` int(11) DEFAULT '0',
  `DefaultProject` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TimeSheetSettings`
--

INSERT INTO `TimeSheetSettings` (`userId`, `DefaultClient`, `DefaultProject`) VALUES
(2, 1, -1);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

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

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `Email`, `FirstName`, `LastName`, `AccountType`, `Password`, `DateAdded`, `LastModified`, `Phone`, `Active`, `Restriction`, `Online`) VALUES
(1, 'tbarnes@arbsol.com', 'Tyler', 'Barnes', 1, '$2y$10$pbClvD.OBOoeLBnM5WLhPu3Xhh.7DPHxTRgTKPJOe.XcFiiLt2O1K', '2015-10-08 21:23:51', '2015-10-30 17:19:15', '6195773861', 1, 0, 1),
(2, 'cschaefer@arbsol.com', 'Chris', 'Schaefer', 1, '$2y$10$PtSBL5gNiq.6vC9pRWj5DO4VM80eDjZLmGJSxoqSwZJR4eebmamfe', '2015-10-28 15:04:45', '2015-10-31 22:39:25', '2489829600', 1, 0, 1),
(10, 'spalma@arbsol.com', 'Scott', 'Palma', 1, '$2y$10$lVLA3vKDBMmrqubrogND9u2AoICD0/ItBH1b3rmg/dkiFfEglBFzK', '2015-11-02 13:58:27', '2015-11-02 13:58:27', '6166901728', 1, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AccountType`
--
ALTER TABLE `AccountType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Client`
--
ALTER TABLE `Client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Office`
--
ALTER TABLE `Office`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Project`
--
ALTER TABLE `Project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ProjectItemProject`
--
ALTER TABLE `ProjectItemProject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ProjectTimeSheet`
--
ALTER TABLE `ProjectTimeSheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TimeSheet`
--
ALTER TABLE `TimeSheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TimeSheetSettings`
--
ALTER TABLE `TimeSheetSettings`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AccountType`
--
ALTER TABLE `AccountType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Client`
--
ALTER TABLE `Client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Country`
--
ALTER TABLE `Country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=243;
--
-- AUTO_INCREMENT for table `Office`
--
ALTER TABLE `Office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Project`
--
ALTER TABLE `Project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ProjectItemProject`
--
ALTER TABLE `ProjectItemProject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ProjectTimeSheet`
--
ALTER TABLE `ProjectTimeSheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `TimeSheet`
--
ALTER TABLE `TimeSheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
