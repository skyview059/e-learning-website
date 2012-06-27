-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2012 at 02:03 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `el`
--

-- --------------------------------------------------------

--
-- Table structure for table `el_classes`
--

CREATE TABLE IF NOT EXISTS `el_classes` (
  `ClassID` int(11) NOT NULL AUTO_INCREMENT,
  `ClassName` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ClassDes` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bảng này gồm các lớp học' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `el_courses`
--

CREATE TABLE IF NOT EXISTS `el_courses` (
  `CourseID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ClassID` int(11) NOT NULL,
  `CourseDes` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CourseID`),
  KEY `ClassID` (`ClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bảng này chứa các môn học ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `el_exams`
--

CREATE TABLE IF NOT EXISTS `el_exams` (
  `ExamID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseID` int(11) NOT NULL,
  `ChapterName` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ExamName` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Difficult` int(11) DEFAULT NULL,
  `NumOfQuestion` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `QuestionIDs` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ExamDes` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ExamID`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bảng này chứa các đề tự luyện được tạo bằng cách lấy ngẫu nhiên các câu hỏi tron' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `el_questions`
--

CREATE TABLE IF NOT EXISTS `el_questions` (
  `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseID` int(11) NOT NULL,
  `ChapterName` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `QuestionContent` varchar(0) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Option1` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Option2` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Option3` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Option4` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Option5` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Option6` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Answer1` int(11) DEFAULT NULL,
  `Answer2` int(11) DEFAULT NULL,
  `Answer3` int(11) DEFAULT NULL,
  `Answer4` int(11) DEFAULT NULL,
  `Answer5` int(11) DEFAULT NULL,
  `Answer6` int(11) DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `MixChoice` int(11) DEFAULT NULL,
  `CaseStudy` varchar(0) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `TheoryID` int(11) DEFAULT NULL,
  PRIMARY KEY (`QuestionID`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tập hợp các bài tập của các môn học' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `el_theories`
--

CREATE TABLE IF NOT EXISTS `el_theories` (
  `TheoryID` int(11) NOT NULL AUTO_INCREMENT,
  `TheoryName` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TheoryContent` varchar(0) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TheoryFilePath` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CourseID` int(11) NOT NULL,
  `Objectives` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`TheoryID`),
  KEY `CourseID` (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bảng này chứa các bài lý thuyết về từng môn học' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `el_courses`
--
ALTER TABLE `el_courses`
  ADD CONSTRAINT `el_courses_ibfk_1` FOREIGN KEY (`ClassID`) REFERENCES `el_classes` (`ClassID`);

--
-- Constraints for table `el_exams`
--
ALTER TABLE `el_exams`
  ADD CONSTRAINT `el_exams_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_exams_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`);

--
-- Constraints for table `el_questions`
--
ALTER TABLE `el_questions`
  ADD CONSTRAINT `el_questions_ibfk_4` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_questions_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_questions_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_questions_ibfk_3` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`);

--
-- Constraints for table `el_theories`
--
ALTER TABLE `el_theories`
  ADD CONSTRAINT `el_theories_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_3` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_4` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_5` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_6` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_7` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_8` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`),
  ADD CONSTRAINT `el_theories_ibfk_9` FOREIGN KEY (`CourseID`) REFERENCES `test`.`el_courses` (`CourseID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
