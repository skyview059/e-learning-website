-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 22, 2012 at 04:27 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_e_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `ChapterID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseID` int(11) NOT NULL,
  `ChapterName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ChapterID`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`ChapterID`, `CourseID`, `ChapterName`) VALUES
(1, 1, 'Xác Suất'),
(2, 1, 'Giải Tích'),
(3, 3, 'Present Simple'),
(4, 3, 'Present Continuous'),
(5, 2, 'Danh Từ Chung '),
(6, 5, 'Giữ Gìn Sự Trong Sán');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `ClassID` int(11) NOT NULL AUTO_INCREMENT,
  `ClassName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ClassID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`ClassID`, `ClassName`) VALUES
(1, 'Lớp 10'),
(2, 'Lớp 11'),
(3, 'Lớp 12'),
(4, 'Lớp Ôn Thi');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `CourseID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ClassID` int(11) NOT NULL,
  PRIMARY KEY (`CourseID`),
  KEY `ClassID` (`ClassID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `CourseName`, `ClassID`) VALUES
(1, 'Toán', 1),
(2, 'Văn', 1),
(3, 'Anh', 1),
(4, 'Toán', 2),
(5, 'Văn', 2),
(6, 'Anh', 2);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE IF NOT EXISTS `exams` (
  `ExamID` int(11) NOT NULL AUTO_INCREMENT,
  `ChapterID` int(11) NOT NULL,
  `ExamName` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Difficult` int(11) DEFAULT NULL,
  `NumOfQuestion` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `ExamFIlePath` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ExamID`),
  KEY `exams_ibfk_1` (`ChapterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`ExamID`, `ChapterID`, `ExamName`, `Difficult`, `NumOfQuestion`, `Time`, `ExamFIlePath`) VALUES
(1, 3, 'Đề thi thử môn tiếng Anh lớp 1', 3, 30, 3600, NULL),
(2, 5, 'Những bài văn theo đề thi đại ', 4, 5, 5400, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `ChapterID` int(11) NOT NULL,
  `QuestionContent` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Answer1` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Answer2` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Answer3` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Answer4` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `AnswerKey` int(11) DEFAULT NULL,
  `Difficult` int(11) DEFAULT NULL,
  `MixChoice` int(11) DEFAULT NULL,
  PRIMARY KEY (`QuestionID`),
  KEY `questions_ibfk_1` (`ChapterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionID`, `ChapterID`, `QuestionContent`, `Answer1`, `Answer2`, `Answer3`, `Answer4`, `AnswerKey`, `Difficult`, `MixChoice`) VALUES
(1, 3, 'Life _____ easier thanks to technology', 'is getting', 'gets', 'get', 'are getting', 3, 2, 0),
(2, 3, 'Michael is generally a ____', 'woman''s name', 'surname', 'man''s name', 'family name', 1, 3, 0),
(5, 3, 'He''s her closest friend. He _____her since they were children', 'knew', 'knows', 'has known', 'known', 2, 1, NULL),
(6, 6, 'I''ve looked for my book everywhere, but I still_________it', 'haven''t found', 'have found', 'find', 'didn''t found', 2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `ResultID` int(11) NOT NULL AUTO_INCREMENT,
  `ExamID` int(11) NOT NULL,
  `NumOfExaminee` int(11) DEFAULT NULL,
  PRIMARY KEY (`ResultID`),
  KEY `results_ibfk_1` (`ExamID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`ResultID`, `ExamID`, `NumOfExaminee`) VALUES
(1, 1, 15),
(2, 2, 17);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`) VALUES
(1, 'Administrator'),
(2, 'Mod'),
(3, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `theories`
--

CREATE TABLE IF NOT EXISTS `theories` (
  `TheoryID` int(11) NOT NULL AUTO_INCREMENT,
  `TheoryName` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ChapterID` int(11) NOT NULL,
  `TheoryFilePath` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`TheoryID`),
  KEY `theories_ibfk_2` (`ChapterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `theories`
--

INSERT INTO `theories` (`TheoryID`, `TheoryName`, `ChapterID`, `TheoryFilePath`) VALUES
(1, 'Thuyết Tương Đối Của', 1, NULL),
(2, 'Mây và Gió', 2, NULL),
(3, 'Những Cơn Mưa Chiều ', 5, NULL),
(4, 'Tắt Đèn', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE IF NOT EXISTS `userroles` (
  `UserRoleID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  PRIMARY KEY (`UserRoleID`),
  KEY `userroles_ibfk_1` (`UserID`),
  KEY `userroles_ibfk_3` (`RoleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`UserRoleID`, `UserID`, `RoleID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Emails` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Emails`) VALUES
(1, 'huynt', 'huynt', 'huynt01016@fpt.edu.vn'),
(2, 'hungnt', 'hungnt', 'hungnt00838@fpt.edu.vn'),
(3, 'namnh', 'namnh', 'namnh00903@fpt.edu.vn'),
(4, 'minhnt', 'minhnt', NULL),
(5, 'hieunm', 'hieunm', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`ClassID`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`ClassID`),
  ADD CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`ClassID`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`ChapterID`) REFERENCES `chapters` (`ChapterID`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`ChapterID`) REFERENCES `chapters` (`ChapterID`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`ExamID`) REFERENCES `exams` (`ExamID`);

--
-- Constraints for table `theories`
--
ALTER TABLE `theories`
  ADD CONSTRAINT `theories_ibfk_1` FOREIGN KEY (`ChapterID`) REFERENCES `chapters` (`ChapterID`),
  ADD CONSTRAINT `theories_ibfk_2` FOREIGN KEY (`ChapterID`) REFERENCES `chapters` (`ChapterID`);

--
-- Constraints for table `userroles`
--
ALTER TABLE `userroles`
  ADD CONSTRAINT `userroles_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `userroles_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`),
  ADD CONSTRAINT `userroles_ibfk_3` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
