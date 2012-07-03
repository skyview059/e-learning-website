-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2012 at 03:50 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_tracnghiem`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_answers`
--

CREATE TABLE IF NOT EXISTS `db_answers` (
  `answerid` int(10) unsigned NOT NULL DEFAULT '0',
  `questionid` int(10) unsigned NOT NULL DEFAULT '0',
  `answer_text` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_correct` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `answer_percents` float NOT NULL DEFAULT '0',
  `isregexp` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `iscasesensitive` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`questionid`,`answerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `db_answers`
--

INSERT INTO `db_answers` (`answerid`, `questionid`, `answer_text`, `answer_feedback`, `answer_correct`, `answer_percents`, `isregexp`, `iscasesensitive`) VALUES
(1, 1, '1', 'Ä‘Ã¡p Ã¡n 1', 0, 0, 0, 1),
(2, 1, '2', 'Ä‘Ã¡p Ã¡n 2', 1, 100, 0, 1),
(3, 1, '3', 'Ä‘Ã¡p Ã¡n 3', 0, 0, 0, 1),
(1, 2, '1', 'Ä‘Ã¡p Ã¡n 1', 0, 0, 0, 1),
(2, 2, '2', 'Ä‘Ã¡p Ã¡n 2', 0, 0, 0, 1),
(3, 2, '3', 'Ä‘Ã¡p Ã¡n 3', 1, 100, 0, 1),
(1, 3, '5', 'Ä‘Ã¡p Ã¡n 5', 1, 100, 0, 1),
(2, 3, '3', 'Ä‘Ã¡p Ã¡n 4', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_config`
--

CREATE TABLE IF NOT EXISTS `db_config` (
  `configid` int(10) unsigned NOT NULL DEFAULT '0',
  `config_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `config_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`configid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `db_config`
--

INSERT INTO `db_config` (`configid`, `config_name`, `config_value`) VALUES
(1, 'igttimestamp', '1185953317'),
(2, 'igtversion', '2.1.0'),
(3, 'can_register', '1'),
(4, 'reg_intro', ''),
(5, 'reg_username', '4'),
(6, 'reg_password', '4'),
(7, 'reg_email', '4'),
(8, 'reg_firstname', '2'),
(9, 'reg_lastname', '2'),
(10, 'reg_middlename', '0'),
(11, 'reg_address', '0'),
(12, 'reg_city', '0'),
(13, 'reg_state', '0'),
(14, 'reg_zip', '0'),
(15, 'reg_country', '0'),
(16, 'reg_phone', '0'),
(17, 'reg_fax', '0'),
(18, 'reg_mobile', '0'),
(19, 'reg_pager', '0'),
(20, 'reg_ipphone', '0'),
(21, 'reg_webpage', '0'),
(22, 'reg_icq', '0'),
(23, 'reg_msn', '0'),
(24, 'reg_gender', '0'),
(25, 'reg_birthday', '0'),
(26, 'reg_photo', '0'),
(27, 'reg_company', '0'),
(28, 'reg_jobtitle', '0'),
(29, 'reg_department', '0'),
(30, 'reg_office', '0'),
(31, 'reg_caddress', '0'),
(32, 'reg_ccity', '0'),
(33, 'reg_cstate', '0'),
(34, 'reg_czip', '0'),
(35, 'reg_ccountry', '0'),
(36, 'reg_cphone', '0'),
(37, 'reg_cfax', '0'),
(38, 'reg_cmobile', '0'),
(39, 'reg_cpager', '0'),
(40, 'reg_cipphone', '0'),
(41, 'reg_cwebpage', '0'),
(42, 'reg_trainer', '0'),
(43, 'reg_userfield1', '0'),
(44, 'reg_caption_userfield1', ''),
(45, 'reg_userfield2', '0'),
(46, 'reg_caption_userfield2', ''),
(47, 'reg_userfield3', '0'),
(48, 'reg_caption_userfield3', ''),
(49, 'reg_userfield4', '0'),
(50, 'reg_caption_userfield4', ''),
(51, 'list_length', '20'),
(52, 'store_logs', '0'),
(53, 'editor_type', '3'),
(54, 'upon_registration', '0'),
(55, 'reg_title', '0'),
(56, 'reg_aol', '0'),
(57, 'reg_husbandwife', '0'),
(58, 'reg_children', '0'),
(59, 'reg_cphoto', '0'),
(60, 'reg_userfield5', '0'),
(61, 'reg_caption_userfield5', ''),
(62, 'reg_userfield6', '0'),
(63, 'reg_caption_userfield6', ''),
(64, 'reg_userfield7', '0'),
(65, 'reg_caption_userfield7', ''),
(66, 'reg_userfield8', '0'),
(67, 'reg_caption_userfield8', ''),
(68, 'reg_userfield9', '0'),
(69, 'reg_caption_userfield9', ''),
(70, 'reg_userfield10', '0'),
(71, 'reg_caption_userfield10', ''),
(72, 'reg_type_userfield1', '0'),
(73, 'reg_values_userfield1', ''),
(74, 'reg_type_userfield2', '0'),
(75, 'reg_values_userfield2', ''),
(76, 'reg_type_userfield3', '0'),
(77, 'reg_values_userfield3', '0'),
(78, 'reg_type_userfield4', '0'),
(79, 'reg_values_userfield4', ''),
(80, 'reg_type_userfield5', '0'),
(81, 'reg_values_userfield5', ''),
(82, 'reg_type_userfield6', '0'),
(83, 'reg_values_userfield6', ''),
(84, 'reg_type_userfield7', '0'),
(85, 'reg_values_userfield7', ''),
(86, 'reg_type_userfield8', '0'),
(87, 'reg_values_userfield8', ''),
(88, 'reg_type_userfield9', '0'),
(89, 'reg_values_userfield9', ''),
(90, 'reg_type_userfield10', '0'),
(91, 'reg_values_userfield10', ''),
(92, 'default_language', 'en'),
(93, 'version', '23f7dbd2c67658ce8ceffc1ce97bbba2');

-- --------------------------------------------------------

--
-- Table structure for table `db_etemplates`
--

CREATE TABLE IF NOT EXISTS `db_etemplates` (
  `etemplateid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `etemplate_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `etemplate_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `etemplate_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `etemplate_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `etemplate_body` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`etemplateid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

--
-- Dumping data for table `db_etemplates`
--

INSERT INTO `db_etemplates` (`etemplateid`, `etemplate_name`, `etemplate_description`, `etemplate_from`, `etemplate_subject`, `etemplate_body`) VALUES
(1, 'Káº¿ quáº£ Kiá»ƒm tra  (Máº·c Ä‘á»‹nh)', 'Khung máº«u Email káº¿t quáº£ kiá»ƒm tra(Máº·c Ä‘á»‹nh)', 'namnh00903@fpt.edu.vn', '[TÃ¢nPhÃº.Net_Tráº¯cNghiá»‡m]-[VTL_Test] - BÃ¡o cÃ¡o Máº«u', 'ChÃ o [USER_FIRST_NAME],\r\n\r\ná»Ÿ Ä‘Ã¢y nhá»¯ng káº¿t quáº£ tá»« bÃ i kiá»ƒm (cá»§a) cÃ¡c báº¡n:\r\n\r\nTÃªn bÃ i kiá»ƒm: [TEST_NAME]\r\nNgÃ y: [RESULT_DATE]\r\nThá»i gian: [RESULT_TIME_SPENT]\r\nThá»i gian Ä‘Æ°á»£c vÆ°á»£t hÆ¡n: [RESULT_TIME_EXCEEDED]\r\n\r\n[RESULT_DETAILED_1]\r\n\r\nThá»•ng Ä‘iá»ƒm: [RESULT_POINTS_SCORED] / [RESULT_POINTS_POSSIBLE] ([RESULT_PERCENTS]%)\r\nXáº¿p loáº¡i: [RESULT_GRADE]\r\n\r\nThÃ¢n chÃ o,chÃºc báº¡n há»c tá»‘t vÃ  thÃ nh cÃ´ng trong tÆ°Æ¡ng lai !\r\nAdmin: VÅ© Thanh Lai | Email: VuThanhLai@Gmail.Com | Y!M: KiUcTinhYeu_1811 | Site: http://tanphu.net '),
(2, 'TÃ i khoáº£n Ä‘Äƒng kÃ½', 'khung máº«u email TÃ i khoáº£n Ä‘Äƒng kÃ½ ', 'namnh00903@fpt.edu.vn', 'Nhá»¯ng chi tiáº¿t ÄÄƒng kÃ½', 'ChÃ o [USER_FIRST_NAME],\r\n\r\nCáº£m Æ¡n báº¡n Ä‘Äƒng kÃ½ Vá»›i TÃ¢nPhÃº.Net (http://tracnghiem.tanphu.net).\r\n\r\nUsername: [USERNAME]\r\nPassword: [USER_PASSWORD]\r\n\r\nBáº¡n cÃ³ thá»ƒ Ä‘Äƒng nháº­p tá»›i tÃ i khoáº£n (cá»§a) cÃ¡c báº¡n báº¥t ká»³ thá»i gian nÃ o Ä‘áº¿n thÄƒm:\r\n\r\n[[TÃ¢nPhÃº.Net_Tráº¯cNghiá»‡m]-[VTL_Test]_URL]\r\n\r\nThÃ¢n chÃ o,chÃºc báº¡n há»c tá»‘t vÃ  thÃ nh cÃ´ng trong tÆ°Æ¡ng lai !\r\nAdmin: VÅ© Thanh Lai | Email: VuThanhLai@Gmail.Com | Y!M: KiUcTinhYeu_1811 | Site: http://tanphu.net '),
(3, 'Account Sign Up (Email Activation)', 'TÃ i khoáº£n Ä‘Äƒng kÃ½ khung máº«u email', 'namnh00903@fpt.edu.vn', 'Sá»± KÃ­ch hoáº¡t TÃ i khoáº£n', 'ChÃ o [USER_FIRST_NAME],\r\n\r\nCáº£m Æ¡n báº¡n Ä‘Äƒng kÃ½ Vá»›i TÃ¢nPhÃº.Net (http://tracnghiem.tanphu.net).\r\n\r\nUsername: [USERNAME]\r\nPassword: [USER_PASSWORD]\r\n\r\nTiáº¿p theo báº¡n hÃ£y lÃ m nhÆ° sau :\r\n\r\nÄá»ƒ hoÃ n thÃ nh viá»‡c kÃ­ch hoáº¡t tÃ i khoáº£n (cá»§a) cÃ¡c báº¡n, xin kÃ­ch vÃ o má»‘i liÃªn káº¿t sau Ä‘Ã¢y\r\n\r\n[[TÃ¢nPhÃº.Net_Tráº¯cNghiá»‡m]-[VTL_Test]_URL]/account.php?action=activate&userid=[USER_ID]&checkword=[USER_CHECKWORD]\r\n\r\nThÃ¢n chÃ o,chÃºc báº¡n há»c tá»‘t vÃ  thÃ nh cÃ´ng trong tÆ°Æ¡ng lai !\r\nAdmin: VÅ© Thanh Lai | Email: VuThanhLai@Gmail.Com | Y!M: KiUcTinhYeu_1811 | Site: http://tanphu.net '),
(4, 'TÃ i khoáº£n Ä‘Ã£ ÄÆ°á»£c kÃ­ch hoáº¡t', 'Khung máº«u email Ä‘Æ°á»£c kÃ­ch hoáº¡t TÃ i khoáº£n', 'namnh00903@fpt.edu.vn', 'TÃ i khoáº£n ÄÆ°á»£c kÃ­ch hoáº¡t', 'ThÃ¢n máº¿n [USER_FIRST_NAME],\r\n\r\nTÃ i khoáº£n (cá»§a) CÃ¡c báº¡n Ä‘Ã£ Ä‘Æ°á»£c kÃ­ch hoáº¡t má»™t cÃ¡ch thÃ nh cÃ´ng .\r\n\r\nBáº¡n cÃ³ thá»ƒ Ä‘Äƒng nháº­p tá»›i tÃ i khoáº£n (cá»§a) cÃ¡c báº¡n báº¥t ká»³ thá»i gian nÃ o Ä‘áº¿n thÄƒm:\r\n\r\n[[TÃ¢nPhÃº.Net_Tráº¯cNghiá»‡m]-[VTL_Test]_URL]\r\n\r\nThÃ¢n chÃ o,chÃºc báº¡n há»c tá»‘t vÃ  thÃ nh cÃ´ng trong tÆ°Æ¡ng lai !\r\nAdmin: VÅ© Thanh Lai | Email: VuThanhLai@Gmail.Com | Y!M: KiUcTinhYeu_1811 | Site: http://tanphu.net '),
(5, 'TÃ i khoáº£n Ä‘Äƒng kÃ½ ((cho) NgÆ°á»i quáº£n trá»‹)', 'TÃ i khoáº£n Ä‘Äƒng kÃ½ khung máº«u email', 'namnh00903@fpt.edu.vn', 'Nhá»¯ng chi tiáº¿t ÄÄƒng kÃ½ NgÆ°á»i sá»­ dá»¥ng Má»›i', 'ThÃ¢n máº¿n Administrator,\r\n\r\nNhá»¯ng chi tiáº¿t Ä‘Äƒng kÃ½ ngÆ°á»i sá»­ dá»¥ng Má»›i:\r\n\r\nHá» [USER_FIRST_NAME]\r\nTÃªn: [USER_LAST_NAME]\r\nEmail: [USER_EMAIL]\r\nUsername: [USERNAME]\r\nPassword: [USER_PASSWORD]\r\n\r\nThÃ¢n chÃ o,chÃºc báº¡n há»c tá»‘t vÃ  thÃ nh cÃ´ng trong tÆ°Æ¡ng lai !\r\nAdmin: VÅ© Thanh Lai | Email: VuThanhLai@Gmail.Com | Y!M: KiUcTinhYeu_1811 | Site: http://tanphu.net '),
(50, 'KhÃ´i phá»¥c máº­t kháº©u', 'Password recovery email template', 'namnh00903@fpt.edu.vn', 'KhÃ´i phá»¥c máº­t kháº©u', 'Xin chÃ o [USER_FIRST_NAME],\r\n\r\nChÃºng tÃ´i Ä‘Ã£ táº¡o máº­t kháº©u má»›i cho báº¡n.\r\n\r\nUsername: [USERNAME]\r\nMÃ¢t kháº©u má»›i: [USER_PASSWORD]\r\n\r\nThÃ¢n chÃ o,chÃºc báº¡n há»c tá»‘t vÃ  thÃ nh cÃ´ng trong tÆ°Æ¡ng lai !\r\nAdmin: VÅ© Thanh Lai | Email: VuThanhLai@Gmail.Com | Y!M: KiUcTinhYeu_1811 | Site: http://tanphu.net ');

-- --------------------------------------------------------

--
-- Table structure for table `db_groups`
--

CREATE TABLE IF NOT EXISTS `db_groups` (
  `groupid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `access_tests` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `access_testmanager` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_gradingsystems` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_emailtemplates` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_reporttemplates` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_reportsmanager` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_questionbank` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_subjects` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_groups` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_users` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_visitors` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `access_config` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `db_groups`
--

INSERT INTO `db_groups` (`groupid`, `group_name`, `group_description`, `access_tests`, `access_testmanager`, `access_gradingsystems`, `access_emailtemplates`, `access_reporttemplates`, `access_reportsmanager`, `access_questionbank`, `access_subjects`, `access_groups`, `access_users`, `access_visitors`, `access_config`) VALUES
(1, 'Administrators', 'Nhá»¯ng ngÆ°á»i quáº£n trá»‹ cÃ³ sá»± truy nháº­p khÃ´ng giá»›i háº¡n vÃ  Ä‘áº§y Ä‘á»§ (nhÃ³m há»‡ thá»‘ng)', 2, 2, 2, 2, 2, 3, 2, 2, 2, 4, 2, 2),
(2, 'GiÃ¡o viÃªn', 'Nhá»¯ng tháº§y giÃ¡o sá»Ÿ há»¯u Ä‘a sá»‘ quyá»n hÃ nh chÃ­nh vá»›i má»™t sá»‘ sá»± háº¡n cháº¿ ( NhÃ³m há»‡ thá»‘ng)', 2, 2, 2, 2, 2, 3, 2, 2, 1, 3, 1, 1),
(3, 'Thao tÃ¡c viÃªn', 'Nhá»¯ng thÃ nh viÃªn trong nhÃ³m nÃ y Ä‘Æ°á»£c ban quyá»n Ä‘á»ƒ táº¡o ra/ nhá»¯ng cÃ¢u há»i soáº¡n tháº£o (nhÃ³m há»‡ thá»‘ng)', 1, 1, 0, 0, 0, 0, 2, 2, 0, 3, 0, 0),
(19, 'NgÆ°á»i dÃ¹ng', 'Nhá»¯ng ngÆ°á»i sá»­ dá»¥ng bá»‹ ngÄƒn ngá»«a lÃ m sáºµn Ä‘áº¿n tá»« báº¥t ká»³ sá»± thay Ä‘á»•i ngáº«u nhiÃªn hay Ä‘á»‹nh trÆ°á»›c nÃ o (nhÃ³m há»‡ thá»‘ng)', 2, 0, 0, 0, 0, 1, 0, 0, 0, 3, 0, 0),
(20, 'KhÃ¡ch', 'Nhá»¯ng khÃ¡ch cÃ³ cÃ¹ng sá»± truy nháº­p vá»›i nhá»¯ng thÃ nh viÃªn (cá»§a) nhá»¯ng nhÃ³m ngÆ°á»i dÃ¹ng theo máº·c Ä‘á»‹nh (nhÃ³m há»‡ thá»‘ng)', 2, 0, 0, 0, 0, 1, 0, 0, 0, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_groups_resources`
--

CREATE TABLE IF NOT EXISTS `db_groups_resources` (
  `groupid` int(10) unsigned NOT NULL DEFAULT '0',
  `resourceid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`,`resourceid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_groups_tests`
--

CREATE TABLE IF NOT EXISTS `db_groups_tests` (
  `groupid` int(10) unsigned NOT NULL DEFAULT '0',
  `testid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`,`testid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_groups_users`
--

CREATE TABLE IF NOT EXISTS `db_groups_users` (
  `groupid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `db_groups_users`
--

INSERT INTO `db_groups_users` (`groupid`, `userid`) VALUES
(1, 1),
(19, 4),
(20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `db_gscales`
--

CREATE TABLE IF NOT EXISTS `db_gscales` (
  `gscaleid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gscale_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gscale_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`gscaleid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `db_gscales`
--

INSERT INTO `db_gscales` (`gscaleid`, `gscale_name`, `gscale_description`) VALUES
(1, 'A-F Sáº¯p xáº¿p Quy mÃ´ (60% thá»© báº­c chuyá»ƒn qua)', 'A-F grading scale'),
(2, 'Passed/Not Passed Grading Scale', 'Passed/not passed grading scale'),
(3, 'ECTS Grading Scale', 'ECTS (European Credit Transfer System) grading scale'),
(4, 'GPA Grading Scale', 'GPA (Grade Point Average) grading scale'),
(5, '6-Point Grading Scale (Germany)', '6-point grading scale in Germany'),
(6, '5-Point Grading Scale (Central and Eastern Europe)', '5-point grading scale in Central and Eastern Europe');

-- --------------------------------------------------------

--
-- Table structure for table `db_gscales_grades`
--

CREATE TABLE IF NOT EXISTS `db_gscales_grades` (
  `gscaleid` int(10) unsigned NOT NULL DEFAULT '0',
  `gscale_gradeid` int(10) unsigned NOT NULL DEFAULT '0',
  `grade_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `grade_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `grade_feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `grade_from` float NOT NULL DEFAULT '0',
  `grade_to` float NOT NULL DEFAULT '0',
  `isabsolute` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gscaleid`,`gscale_gradeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `db_gscales_grades`
--

INSERT INTO `db_gscales_grades` (`gscaleid`, `gscale_gradeid`, `grade_name`, `grade_description`, `grade_feedback`, `grade_from`, `grade_to`, `isabsolute`) VALUES
(1, 1, 'A', 'Excellent', '', 90, 100, 0),
(1, 2, 'B', 'Good', '', 80, 90, 0),
(1, 3, 'C', 'Fair', '', 70, 80, 0),
(1, 4, 'D', 'Poor', '', 60, 70, 0),
(1, 5, 'F', 'Fail', '', 0, 60, 0),
(2, 1, 'Passed', 'Passed', '', 50, 100, 0),
(2, 2, 'Not Passed', 'Not passed', '', 0, 50, 0),
(3, 1, 'A', 'Excellent (outstanding performance with only minor errors)', '', 95, 100, 0),
(3, 2, 'B', 'Very good (above the average standard but with some errors)', '', 90, 95, 0),
(3, 3, 'C', 'Good (generally sound work with a number of notable errors)', '', 85, 90, 0),
(3, 4, 'D', 'Satisfactory (fair but with significant shortcomings)', '', 80, 85, 0),
(3, 5, 'E', 'Sufficient (performance meets the minimum criteria)', '', 75, 80, 0),
(3, 6, 'FX', 'Fail (some more work required before the credit can be awarded)', '', 65, 75, 0),
(3, 7, 'F', 'Fail (considerable further work is required)', '', 0, 65, 0),
(4, 1, '4', 'Tuyá»‡t vá»i', '', 90, 100, 0),
(4, 2, '3', 'Giá»i', '', 80, 90, 0),
(4, 3, '2', 'Fair', '', 70, 80, 0),
(4, 4, '1', 'Poor', '', 60, 70, 0),
(4, 5, '0', 'Fail', '', 0, 60, 0),
(5, 1, '1', 'Excellent', '', 90, 100, 0),
(5, 2, '2', 'Good', '', 80, 90, 0),
(5, 3, '3', 'Satisfactory', '', 70, 80, 0),
(5, 4, '4', 'Sufficient', '', 60, 70, 0),
(5, 5, '5', 'Unsatisfactory', '', 50, 60, 0),
(5, 6, '6', 'Poor', '', 0, 50, 0),
(6, 1, '5', 'Excellent', '', 90, 100, 0),
(6, 2, '4', 'Good', '', 80, 90, 0),
(6, 3, '3', 'Satisfactory', '', 70, 80, 0),
(6, 4, '2', 'Unsatisfactory', '', 60, 70, 0),
(6, 5, '1', 'Poor', '', 0, 60, 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_questions`
--

CREATE TABLE IF NOT EXISTS `db_questions` (
  `questionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subjectid` int(10) unsigned NOT NULL DEFAULT '1',
  `question_time` int(10) unsigned NOT NULL DEFAULT '0',
  `question_pre` text COLLATE utf8_unicode_ci NOT NULL,
  `question_post` text COLLATE utf8_unicode_ci NOT NULL,
  `question_text` text COLLATE utf8_unicode_ci NOT NULL,
  `question_points` float NOT NULL DEFAULT '1',
  `question_solution` text COLLATE utf8_unicode_ci NOT NULL,
  `question_type` int(10) unsigned NOT NULL DEFAULT '0',
  `question_type2` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `question_shufflea` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`questionid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `db_questions`
--

INSERT INTO `db_questions` (`questionid`, `subjectid`, `question_time`, `question_pre`, `question_post`, `question_text`, `question_points`, `question_solution`, `question_type`, `question_type2`, `question_shufflea`) VALUES
(1, 1, 0, '', '', '<P><STRONG>1 + 1 = ?</STRONG></P>', 1, '', 0, 0, 0),
(2, 1, 0, '', '', '<P><STRONG>2 + 1 = ?</STRONG></P>', 1, '', 0, 0, 2),
(3, 1, 0, '', '', '<P><STRONG>4 + 1 = ?</STRONG></P>', 1, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_resources`
--

CREATE TABLE IF NOT EXISTS `db_resources` (
  `resourceid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resource_testid` int(10) unsigned NOT NULL DEFAULT '0',
  `resource_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `resource_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `resource_url` text COLLATE utf8_unicode_ci NOT NULL,
  `resource_html` text COLLATE utf8_unicode_ci NOT NULL,
  `resource_datestart` int(10) unsigned NOT NULL DEFAULT '0',
  `resource_dateend` int(10) unsigned NOT NULL DEFAULT '0',
  `resource_forall` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `resource_createdate` int(10) unsigned NOT NULL DEFAULT '0',
  `resource_enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`resourceid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `db_results`
--

CREATE TABLE IF NOT EXISTS `db_results` (
  `resultid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `testid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `result_datestart` int(10) unsigned NOT NULL DEFAULT '0',
  `result_timespent` int(10) unsigned NOT NULL DEFAULT '0',
  `result_timeexceeded` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `result_points` float NOT NULL DEFAULT '0',
  `result_pointsmax` float NOT NULL DEFAULT '0',
  `gscaleid` int(10) unsigned NOT NULL DEFAULT '1',
  `gscale_gradeid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`resultid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `db_results`
--

INSERT INTO `db_results` (`resultid`, `testid`, `userid`, `result_datestart`, `result_timespent`, `result_timeexceeded`, `result_points`, `result_pointsmax`, `gscaleid`, `gscale_gradeid`) VALUES
(1, 1, 2, 1341311605, 44, 0, 2, 3, 2, 1),
(2, 1, 2, 1341311955, 278, 0, 3, 3, 1, 1),
(3, 1, 2, 1341312333, 38, 0, 3, 3, 2, 1),
(4, 1, 2, 1341312402, 10, 0, 1, 3, 2, 2),
(5, 1, 2, 1341312437, 49, 0, 2, 3, 2, 1),
(6, 1, 2, 1341312497, 36, 0, 0, 3, 2, 2),
(7, 1, 2, 1341312537, 216, 0, 0, 3, 2, 2),
(8, 1, 2, 1341312786, 66, 0, 1, 3, 2, 2),
(9, 1, 2, 1341312856, 8, 0, 0, 3, 2, 2),
(10, 1, 2, 1341312875, 66, 0, 0, 3, 2, 2),
(11, 1, 2, 1341312944, 13, 0, 3, 3, 2, 1),
(12, 1, 2, 1341313005, 46, 0, 0, 3, 2, 2),
(13, 1, 2, 1341313064, 13, 0, 2, 3, 2, 1),
(14, 1, 2, 1341313239, 30, 0, 1, 3, 2, 2),
(15, 1, 2, 1341313273, 5, 0, 0, 3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `db_results_answers`
--

CREATE TABLE IF NOT EXISTS `db_results_answers` (
  `result_answerid` int(10) unsigned NOT NULL DEFAULT '0',
  `resultid` int(10) unsigned NOT NULL DEFAULT '0',
  `questionid` int(10) unsigned NOT NULL DEFAULT '0',
  `test_questionid` int(10) unsigned NOT NULL DEFAULT '0',
  `result_answer_text` text COLLATE utf8_unicode_ci NOT NULL,
  `result_answer_points` float NOT NULL DEFAULT '0',
  `result_answer_iscorrect` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `result_answer_feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `result_answer_timespent` int(10) unsigned NOT NULL DEFAULT '0',
  `result_answer_timeexceeded` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`resultid`,`result_answerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `db_results_answers`
--

INSERT INTO `db_results_answers` (`result_answerid`, `resultid`, `questionid`, `test_questionid`, `result_answer_text`, `result_answer_points`, `result_answer_iscorrect`, `result_answer_feedback`, `result_answer_timespent`, `result_answer_timeexceeded`) VALUES
(1, 1, 3, 3, '1', 1, 2, '', 0, 0),
(2, 1, 2, 2, '1', 0, 0, '', 0, 0),
(3, 1, 1, 1, '2', 1, 2, '', 0, 0),
(1, 2, 3, 3, '1', 1, 2, '', 0, 0),
(2, 2, 2, 2, '3', 1, 2, '', 0, 0),
(3, 2, 1, 1, '2', 1, 2, '', 0, 0),
(1, 3, 1, 1, '2', 1, 2, '', 0, 0),
(2, 3, 3, 3, '1', 1, 2, '', 0, 0),
(3, 3, 2, 2, '3', 1, 2, '', 0, 0),
(1, 4, 3, 3, '1', 1, 2, '', 4, 0),
(1, 5, 2, 2, '3', 1, 2, '', 0, 0),
(2, 5, 3, 3, '1', 1, 2, '', 0, 0),
(1, 8, 2, 2, '3', 1, 2, '', 4, 0),
(1, 11, 3, 3, '1', 1, 2, '', 7, 0),
(2, 11, 2, 2, '3', 1, 2, '', 2, 0),
(3, 11, 1, 1, '2', 1, 2, '', 3, 0),
(1, 13, 3, 3, '1', 1, 2, '', 2, 0),
(2, 13, 2, 2, '1', 0, 0, '', 7, 0),
(3, 13, 1, 1, '2', 1, 2, '', 2, 0),
(1, 14, 3, 3, '1', 1, 2, '', 2, 0),
(2, 14, 2, 2, '1', 0, 0, '', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_rtemplates`
--

CREATE TABLE IF NOT EXISTS `db_rtemplates` (
  `rtemplateid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rtemplate_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rtemplate_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rtemplate_body` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`rtemplateid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `db_rtemplates`
--

INSERT INTO `db_rtemplates` (`rtemplateid`, `rtemplate_name`, `rtemplate_description`, `rtemplate_body`) VALUES
(1, 'Report Template #1', 'Report template #1', '<h1>[TEST_NAME]</h1>\r\n<p><strong>NgÃ y:</strong> [RESULT_DATE]</p>\r\n<p><strong>TÃªn:</strong> [USER_LAST_NAME]<br>\r\n<strong>Há»</strong> [USER_FIRST_NAME]<br>\r\n<strong>Thá»i gian lÃ m:</strong> [RESULT_TIME_SPENT]<br>\r\n<strong>Äiá»ƒm:</strong> [RESULT_POINTS_SCORED] / [RESULT_POINTS_POSSIBLE] ([RESULT_PERCENTS]%)<br>\r\n<strong>Xáº¿p loáº¡i:</strong> [RESULT_GRADE]</p>\r\n<p><strong>Chi tiáº¿t:</strong><br>[RESULT_DETAILED_1]</p>');

-- --------------------------------------------------------

--
-- Table structure for table `db_subjects`
--

CREATE TABLE IF NOT EXISTS `db_subjects` (
  `subjectid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject_parent_subjectid` int(10) unsigned NOT NULL DEFAULT '0',
  `subject_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`subjectid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `db_subjects`
--

INSERT INTO `db_subjects` (`subjectid`, `subject_parent_subjectid`, `subject_name`, `subject_description`) VALUES
(1, 0, 'ToÃ¡n', 'Äáº¡i sá»‘ + HÃ¬nh há»c'),
(2, 0, 'Anh', ''),
(3, 0, 'Váº­t lÃ½', ''),
(4, 0, 'HÃ³a há»c', '');

-- --------------------------------------------------------

--
-- Table structure for table `db_tests`
--

CREATE TABLE IF NOT EXISTS `db_tests` (
  `testid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subjectid` int(10) unsigned NOT NULL DEFAULT '1',
  `rtemplateid` int(10) unsigned NOT NULL DEFAULT '1',
  `result_etemplateid` int(10) unsigned NOT NULL DEFAULT '0',
  `gscaleid` int(10) unsigned NOT NULL DEFAULT '1',
  `test_type` int(10) unsigned NOT NULL DEFAULT '0',
  `test_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `test_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `test_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `test_instructions` text COLLATE utf8_unicode_ci NOT NULL,
  `test_time` int(10) unsigned NOT NULL DEFAULT '0',
  `test_timeforceout` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_timingq` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_attempts` int(10) unsigned NOT NULL DEFAULT '0',
  `test_shuffleq` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_shufflea` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_sectionstype` int(10) unsigned NOT NULL DEFAULT '0',
  `test_qsperpage` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `test_showqfeedback` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `test_canreview` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_result_showanswers` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_result_showpoints` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `test_result_showgrade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_result_showgradefeedback` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_result_showhtml` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_result_showpdf` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_result_rtemplateid` int(10) unsigned NOT NULL DEFAULT '0',
  `test_reportgradecondition` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_result_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `test_result_emailtouser` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_datestart` int(10) unsigned NOT NULL DEFAULT '0',
  `test_dateend` int(10) unsigned NOT NULL DEFAULT '0',
  `test_prevtestid` int(10) unsigned NOT NULL DEFAULT '0',
  `test_nexttestid` int(10) unsigned NOT NULL DEFAULT '0',
  `test_contentprotection` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_notes` text COLLATE utf8_unicode_ci NOT NULL,
  `test_price` int(10) unsigned NOT NULL DEFAULT '0',
  `test_other_repeatuntilcorrect` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_forall` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `test_createdate` int(10) unsigned NOT NULL DEFAULT '0',
  `test_enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`testid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `db_tests`
--

INSERT INTO `db_tests` (`testid`, `subjectid`, `rtemplateid`, `result_etemplateid`, `gscaleid`, `test_type`, `test_name`, `test_code`, `test_description`, `test_instructions`, `test_time`, `test_timeforceout`, `test_timingq`, `test_attempts`, `test_shuffleq`, `test_shufflea`, `test_sectionstype`, `test_qsperpage`, `test_showqfeedback`, `test_canreview`, `test_result_showanswers`, `test_result_showpoints`, `test_result_showgrade`, `test_result_showgradefeedback`, `test_result_showhtml`, `test_result_showpdf`, `test_result_rtemplateid`, `test_reportgradecondition`, `test_result_email`, `test_result_emailtouser`, `test_datestart`, `test_dateend`, `test_prevtestid`, `test_nexttestid`, `test_contentprotection`, `test_notes`, `test_price`, `test_other_repeatuntilcorrect`, `test_forall`, `test_createdate`, `test_enabled`) VALUES
(1, 1, 1, 0, 2, 0, 'ToÃ¡n lá»›p 1', '[Lá»›p 1] [ToÃ¡n]', 'toÃ¡n lá»›p 1', '<P>kiá»ƒm tra mÃ´n toÃ¡n lá»›p 1</P>', 4500, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, '', 0, 1341311220, 1656930420, 0, 0, 0, '', 0, 0, 1, 1341311275, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_tests_attempts`
--

CREATE TABLE IF NOT EXISTS `db_tests_attempts` (
  `testid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `test_attempt_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`testid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `db_tests_attempts`
--

INSERT INTO `db_tests_attempts` (`testid`, `userid`, `test_attempt_count`) VALUES
(1, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `db_tests_own`
--

CREATE TABLE IF NOT EXISTS `db_tests_own` (
  `testid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `test_own_expiredate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`testid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `db_tests_questions`
--

CREATE TABLE IF NOT EXISTS `db_tests_questions` (
  `test_questionid` int(10) unsigned NOT NULL DEFAULT '0',
  `testid` int(10) unsigned NOT NULL DEFAULT '0',
  `test_sectionid` int(10) unsigned NOT NULL DEFAULT '0',
  `questionid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`testid`,`test_questionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `db_tests_questions`
--

INSERT INTO `db_tests_questions` (`test_questionid`, `testid`, `test_sectionid`, `questionid`) VALUES
(1, 1, 0, 1),
(2, 1, 0, 2),
(3, 1, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `db_users`
--

CREATE TABLE IF NOT EXISTS `db_users` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_passhash` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_checkword` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_middlename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_address` text COLLATE utf8_unicode_ci NOT NULL,
  `user_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_pager` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_ipphone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_webpage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_icq` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_msn` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_aol` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_gender` tinyint(4) NOT NULL DEFAULT '0',
  `user_birthday` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `user_husbandwife` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_children` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_trainer` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_company` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cposition` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_department` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_coffice` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_caddress` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ccity` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cstate` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_czip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_ccountry` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cphone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cfax` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cmobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cpager` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cipphone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cwebpage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_cphoto` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_ufield1` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield2` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield3` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield4` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield5` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield6` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield7` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield8` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield9` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ufield10` text COLLATE utf8_unicode_ci NOT NULL,
  `user_notes` text COLLATE utf8_unicode_ci NOT NULL,
  `user_joindate` int(10) unsigned NOT NULL DEFAULT '0',
  `user_logindate` int(10) unsigned NOT NULL DEFAULT '0',
  `user_expiredate` int(10) unsigned NOT NULL DEFAULT '0',
  `user_enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `db_users`
--

INSERT INTO `db_users` (`userid`, `user_name`, `user_passhash`, `user_checkword`, `user_email`, `user_title`, `user_firstname`, `user_lastname`, `user_middlename`, `user_address`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_fax`, `user_mobile`, `user_pager`, `user_ipphone`, `user_webpage`, `user_icq`, `user_msn`, `user_aol`, `user_gender`, `user_birthday`, `user_husbandwife`, `user_children`, `user_trainer`, `user_photo`, `user_company`, `user_cposition`, `user_department`, `user_coffice`, `user_caddress`, `user_ccity`, `user_cstate`, `user_czip`, `user_ccountry`, `user_cphone`, `user_cfax`, `user_cmobile`, `user_cpager`, `user_cipphone`, `user_cwebpage`, `user_cphoto`, `user_ufield1`, `user_ufield2`, `user_ufield3`, `user_ufield4`, `user_ufield5`, `user_ufield6`, `user_ufield7`, `user_ufield8`, `user_ufield9`, `user_ufield10`, `user_notes`, `user_joindate`, `user_logindate`, `user_expiredate`, `user_enabled`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 'namnh00903@fpt.edu.vn', '', 'Admin', 'User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '1900-01-01 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1341309070, 1341310939, 0, 1),
(2, 'guest', 'e10adc3949ba59abbe56e057f20f883e', '', 'namnh00903@fpt.edu.vn', '', 'KhÃ¡ch', 'User', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '1900-01-01 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1341309070, 1341313677, 0, 1),
(4, 'nam', 'e10adc3949ba59abbe56e057f20f883e', '1jhg2k52', 'bacanhtai@gmail.com', '', 'nam', 'nam', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '1900-01-01 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1341313651, 1341313668, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `db_visitors`
--

CREATE TABLE IF NOT EXISTS `db_visitors` (
  `visitorid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `startdate` int(10) unsigned NOT NULL DEFAULT '0',
  `enddate` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `ip1` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip2` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip3` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ip4` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `host` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `referer` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `useragent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `inurl` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `outurl` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`visitorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
