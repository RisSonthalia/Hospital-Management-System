-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 08:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updationDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `updationDate`) VALUES
(3, 'admin@gmail.com', '9580ab5d9db022c73d6678b07c86c9db', '2024-04-09');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `doctorSpecialization` varchar(255) DEFAULT NULL,
  `doctorId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `consultancyFees` int(11) DEFAULT NULL,
  `appointmentDate` varchar(255) DEFAULT NULL,
  `appointmentTime` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `userStatus` int(11) DEFAULT NULL,
  `doctorStatus` int(11) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `doctorSpecialization`, `doctorId`, `userId`, `consultancyFees`, `appointmentDate`, `appointmentTime`, `postingDate`, `userStatus`, `doctorStatus`, `updationDate`) VALUES
(14, 'Gynecologist/Obstetrician', 12, 8, 400, '2024-04-13', '10:15 AM', '2024-04-10 16:38:44', 1, 1, NULL),
(15, 'Dermatologist', 14, 8, 1000, '2024-04-17', '10:15 PM', '2024-04-10 16:39:12', 1, 1, NULL),
(16, 'Gynecologist/Obstetrician', 12, 11, 400, '2024-04-16', '10:30 PM', '2024-04-10 16:59:43', 1, 1, NULL),
(17, 'Dermatologist', 14, 11, 1000, '2024-04-15', '10:30 PM', '2024-04-10 17:00:24', 1, 1, NULL),
(18, 'Gynecologist/Obstetrician', 12, 8, 400, '2024-04-16', '3:45 PM', '2024-04-15 10:07:56', 1, 1, NULL),
(19, 'Gynecologist/Obstetrician', 12, 8, 400, '2024-04-16', '3:45 PM', '2024-04-16 10:05:56', 1, 1, NULL),
(20, 'Gynecologist/Obstetrician', 12, 17, 400, '2024-04-22', '6:15 PM', '2024-04-16 12:38:10', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `room_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `medication_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `consultation_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date_issued` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_paid` date DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `amount_to_be_paid` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `patient_id`, `room_charge`, `medication_charge`, `consultation_fee`, `total_charge`, `date_issued`, `date_paid`, `status`, `amount_to_be_paid`) VALUES
(38, 8, 2000.00, 3000.00, 5000.00, 10000.00, '2024-04-10 16:53:17', NULL, 'paid', 0.00),
(39, 8, 10000.00, 5000.00, 5000.00, 20000.00, '2024-04-10 16:54:03', NULL, 'paid', 0.00),
(40, 8, 4000.00, 2000.00, 10000.00, 16000.00, '2024-04-10 16:54:24', NULL, 'paid', 0.00),
(41, 8, 2000.00, 3000.00, 5000.00, 10000.00, '2024-04-10 16:54:47', NULL, 'paid', 0.00),
(42, 8, 1000.00, 3000.00, 1000.00, 5000.00, '2024-04-10 16:56:15', NULL, 'paid', 0.00),
(43, 11, 0.00, 300.00, 0.00, 300.00, '2024-04-13 18:19:02', NULL, 'paid', 0.00),
(44, 8, 0.00, 500.00, 0.00, 500.00, '2024-04-14 08:55:17', NULL, 'paid', 0.00),
(45, 8, 1000.00, 4000.00, 5000.00, 10000.00, '2024-04-14 19:04:15', NULL, 'paid', 0.00),
(46, 8, 1000.00, 4000.00, 5000.00, 10000.00, '2024-04-14 19:06:07', NULL, 'paid', 0.00),
(47, 8, 0.00, 0.00, 500.00, 500.00, '2024-04-16 05:44:34', NULL, 'paid', 0.00),
(48, 8, 100.00, 400.00, 500.00, 1000.00, '2024-04-16 11:58:01', NULL, 'paid', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `doctorName` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `docFees` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `docEmail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `specilization`, `doctorName`, `address`, `docFees`, `contactno`, `docEmail`, `password`, `creationDate`, `updationDate`) VALUES
(12, 'Gynecologist/Obstetrician', 'Ramu Sharmah', 'Guwahati', '400', 9807654321, 'ramu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-04-10 16:18:40', NULL),
(13, 'General Physician', 'Ram ', 'Guwahati', '500', 9807654321, 'ram@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-04-10 16:27:39', NULL),
(14, 'Dermatologist', 'Chaman', 'Siliguri', '1000', 9087654321, 'chaman@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-04-10 16:28:39', NULL),
(15, 'Ear-Nose-Throat (Ent) Specialist', 'Naman', 'Ghy', '900', 9807654322, 'naman@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-04-10 16:32:11', NULL),
(16, 'Bones Specialist demo', 'Rakesh', 'Maharastra', '900', 9808654321, 'rakesh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-04-10 16:33:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctorslog`
--

CREATE TABLE `doctorslog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctorslog`
--

INSERT INTO `doctorslog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(64, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:19:54', '10-04-2024 09:52:02 PM', 1),
(65, NULL, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:22:28', NULL, 0),
(66, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:22:37', NULL, 1),
(67, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:39:37', NULL, 1),
(68, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:46:22', NULL, 1),
(69, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:49:43', NULL, 1),
(70, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:57:23', NULL, 1),
(71, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:00:43', NULL, 1),
(72, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:04:17', NULL, 1),
(73, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:16:17', '10-04-2024 10:47:02 PM', 1),
(74, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:30:51', '10-04-2024 11:00:54 PM', 1),
(75, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:55:19', '10-04-2024 11:25:38 PM', 1),
(76, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 18:06:10', '10-04-2024 11:36:21 PM', 1),
(77, NULL, '', 0x3a3a3100000000000000000000000000, '2024-04-13 16:41:23', NULL, 0),
(78, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:39:25', '15-04-2024 01:10:45 AM', 1),
(79, NULL, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:43:05', NULL, 0),
(80, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:43:12', '15-04-2024 01:13:24 AM', 1),
(81, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-15 10:08:22', '15-04-2024 03:39:34 PM', 1),
(82, NULL, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 05:40:19', NULL, 0),
(83, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 05:40:26', '16-04-2024 11:16:07 AM', 1),
(84, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 12:06:42', '16-04-2024 05:44:32 PM', 1),
(85, NULL, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 12:38:41', NULL, 0),
(86, 12, 'ramu@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 12:38:48', '16-04-2024 06:10:37 PM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctorspecilization`
--

CREATE TABLE `doctorspecilization` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctorspecilization`
--

INSERT INTO `doctorspecilization` (`id`, `specilization`, `creationDate`, `updationDate`) VALUES
(14, 'Gynecologist/Obstetrician', '2024-04-10 16:29:53', NULL),
(15, 'General Physician', '2024-04-10 16:30:03', NULL),
(16, 'Dermatologist', '2024-04-10 16:30:18', NULL),
(17, 'Homeopath', '2024-04-10 16:30:32', NULL),
(18, 'Ayurveda', '2024-04-10 16:30:40', NULL),
(19, 'Dentist', '2024-04-10 16:30:47', NULL),
(20, 'Ear-Nose-Throat (Ent) Specialist', '2024-04-10 16:30:55', NULL),
(21, 'Bones Specialist demo', '2024-04-10 16:31:05', NULL),
(22, 'Physician', '2024-04-10 16:31:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drug_category`
--

CREATE TABLE `drug_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drug_category`
--

INSERT INTO `drug_category` (`category_id`, `category_name`) VALUES
(5, 'BP'),
(6, 'Fever'),
(7, 'Cough'),
(8, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `drug_table`
--

CREATE TABLE `drug_table` (
  `drug_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drug_table`
--

INSERT INTO `drug_table` (`drug_id`, `name`, `category_name`, `price`, `description`, `quantity`) VALUES
(1, 'abc', 'BP', 200.00, 'weferfrf', 200),
(2, 'xyz', 'Fever', 100.00, 'ee2f', 20),
(5, 'asdf', 'Cough', 300.00, 'adfqetgw<br />\r\nwfdf<br />\r\nwfqefg<br />\r\nwffqesfvsfvSFFVFSFSV', 100),
(6, 'test', 'test', 200.00, 'testdec', 200),
(7, 'test', 'Cough', 800.00, 'vbn', 900),
(8, 'test2', 'Fever', 22.00, 'edqewr<br />\r\nwrfwrgf<br />\r\nwrfwrgrg<br />\r\nwerf', 100);

-- --------------------------------------------------------

--
-- Table structure for table `laboratorist`
--

CREATE TABLE `laboratorist` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contactno` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` enum('male','female','other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratorist`
--

INSERT INTO `laboratorist` (`id`, `name`, `contactno`, `email`, `password`, `qualification`, `creationDate`, `updationDate`, `gender`) VALUES
(1, 'Rohan', 9087654321, 'rohan@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', NULL, '2024-04-13 16:19:46', '2024-04-13 16:19:46', 'male'),
(4, 'Aman', 9087652341, 'aman@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'Pharmac', '2024-04-13 16:23:04', '2024-04-13 17:08:09', 'male'),
(5, 'Parinit', 8907654321, 'parinit@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'test', '2024-04-13 19:04:18', '2024-04-13 19:04:18', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `pharmacy_id` int(11) NOT NULL,
  `pharmacy_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`pharmacy_id`, `pharmacy_name`, `email`, `password`, `address`, `contact_no`, `creationDate`, `updationDate`) VALUES
(2, 'Pharma 2', 'pharma@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', 'IITG', '9087654323', '2024-04-13 18:41:00', '2024-04-13 18:46:15'),
(3, 'Pharma 1', 'pharmacy@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'IITG hospital', '9087654321', '2024-04-13 19:15:39', '2024-04-13 19:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `RoomId` int(11) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Availability` int(11) DEFAULT NULL,
  `RoomRent` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomId`, `Type`, `Capacity`, `Availability`, `RoomRent`) VALUES
(1, 'Deluxe', 10, 5, 1000.00),
(101, 'Standard', 2, 1, 100.00),
(102, 'Deluxe', 3, 0, 150.00),
(103, 'Suite', 4, 1, 200.00),
(104, 'Economy', 2, 1, 80.00),
(110, 'General', 40, 30, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontactus`
--

CREATE TABLE `tblcontactus` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(12) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `LastupdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `IsRead` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcontactus`
--

INSERT INTO `tblcontactus` (`id`, `fullname`, `email`, `contactno`, `message`, `PostingDate`, `AdminRemark`, `LastupdationDate`, `IsRead`) VALUES
(6, 'qwwsd', 'wdwe@gmail.com', 9087654321, 'wfegfqegqefgf', '2024-04-08 18:49:54', NULL, NULL, NULL),
(7, 'Rishab', 'rishab@gmail.com', 1234567890, 'wdfdfbzcSFgDfv', '2024-04-10 18:07:32', NULL, NULL, NULL),
(9, 'Aman', 'wdwe@gmail.com', 3456789012, 'efeggcegeg grt ghrtghrt hrtgh rtgh', '2024-04-16 12:15:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblmedicalhistory`
--

CREATE TABLE `tblmedicalhistory` (
  `ID` int(10) NOT NULL,
  `PatientID` int(10) DEFAULT NULL,
  `BloodPressure` varchar(200) DEFAULT NULL,
  `BloodSugar` varchar(200) NOT NULL,
  `Weight` varchar(100) DEFAULT NULL,
  `Temperature` varchar(200) DEFAULT NULL,
  `MedicalPres` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblmedicalhistory`
--

INSERT INTO `tblmedicalhistory` (`ID`, `PatientID`, `BloodPressure`, `BloodSugar`, `Weight`, `Temperature`, `MedicalPres`, `CreationDate`) VALUES
(13, 8, '70/110', '89/120', '72', '97deg', '1) Drug 1 - After Food - 1/Day - 10Days<br>1) Drug 2 - After Food - 1/Day - 13Days<br>1) Drug 3 - After Food - 1/Day - 14Days<br>1) Drug 4 - After Food - 1/Day - 15Days<br>1) Drug 5 - After Food - 1/Day - 15Days<br>', '2024-04-10 16:47:57'),
(14, 17, '70', '12', '74', '12', '1)sdfefgeqrg<br>2)wdfefg<br>3)werferfgfetrgqetg', '2024-04-16 12:39:31');

-- --------------------------------------------------------

--
-- Table structure for table `tblpatient`
--

CREATE TABLE `tblpatient` (
  `ID` int(10) NOT NULL,
  `PatientName` varchar(200) DEFAULT NULL,
  `PatientContno` bigint(10) DEFAULT NULL,
  `PatientEmail` varchar(200) DEFAULT NULL,
  `PatientGender` varchar(50) DEFAULT NULL,
  `PatientAdd` mediumtext DEFAULT NULL,
  `PatientAge` int(10) DEFAULT NULL,
  `PatientMedhis` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `RoomId` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `insurance` decimal(10,2) DEFAULT 50000.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpatient`
--

INSERT INTO `tblpatient` (`ID`, `PatientName`, `PatientContno`, `PatientEmail`, `PatientGender`, `PatientAdd`, `PatientAge`, `PatientMedhis`, `CreationDate`, `UpdationDate`, `RoomId`, `password`, `dob`, `city`, `insurance`) VALUES
(8, 'Aman', 9876543244, 'aman@gmail.com', 'male', 'XYZ', 13, NULL, '2024-04-05 17:24:29', '2024-04-16 06:59:35', 101, 'fcea920f7412b5da7be0cf42b8c93759', '2010-06-08', 'abc', 0.00),
(10, 'Raghav', 9807654321, 'raghav@gmail.com', 'male', 'Ghy,Assam', 16, NULL, '2024-04-10 16:34:33', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2008-02-13', 'Ghy', 50000.00),
(11, 'Bonty', 9087612345, 'bonty@gmail.com', 'male', 'Hyderabad', 14, NULL, '2024-04-10 16:35:48', '2024-04-13 18:19:02', NULL, 'e10adc3949ba59abbe56e057f20f883e', '2010-04-02', 'Hyderabad', 49700.00),
(12, 'Raj', 9807612345, 'raj@gmail.com', 'male', 'Uttrakhand', 10, NULL, '2024-04-10 16:36:55', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2013-07-10', 'Uttarakhand', 50000.00),
(13, 'Monty', 9087612345, 'monty@gmail.com', 'male', 'assam', 9, NULL, '2024-04-10 16:38:00', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2015-03-05', 'Ghy', 50000.00),
(14, 'Ansh', 9087654321, 'ansh@gmail.com', 'male', 'Hyderabad', 0, NULL, '2024-04-16 09:16:09', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2024-04-17', 'Hyderabad', 50000.00),
(16, 'Naman', 8907654321, 'naman@gmail.com', 'male', 'Bihar', 0, NULL, '2024-04-16 09:20:45', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2024-04-18', 'Patna', 50000.00),
(17, 'Rishab', 9087654341, 'rishab@gmail.com', 'male', 'Guwahati', 0, NULL, '2024-04-16 12:37:28', '2024-04-16 19:10:50', 1, 'e10adc3949ba59abbe56e057f20f883e', '2024-04-17', 'Guwahati', 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `testreport`
--

CREATE TABLE `testreport` (
  `ReportID` int(11) NOT NULL,
  `TestType` varchar(255) NOT NULL,
  `Result` mediumtext DEFAULT NULL,
  `TestDate` date NOT NULL,
  `Notes` mediumtext DEFAULT NULL,
  `P-ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testreport`
--

INSERT INTO `testreport` (`ReportID`, `TestType`, `Result`, `TestDate`, `Notes`, `P-ID`) VALUES
(4, 'Blood Sugar', '1)Normal<br>2)Normal', '2024-04-11', 'sdfewefqerfqergeqr<br>erfqergfqergqeg<br>qefgqetgqetgqefgqefgqerg<br>egqergqettgqetgqegqetg', 8),
(5, 'X-ray', '1)wfeff<br>2)wdefrf3<br>3)wedeffe<br>', '2024-04-15', '1)qwdwdwdw1erdf<br>2)edqewffrf<br>3)wdfdeferfe2rf<br>4)wferferef<br>', 11),
(7, 'Blood Sugar', 'WDFWRFGWR<br>sffgefgegfg<br>SWFGFAEGGAEG', '2024-04-17', 'asdafaewrfwRGFwrf<br>SFFEFGAEDGFG<br>sffadfgadgfg<br>SFGADGGADGBG', 17);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(72, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:38:16', NULL, 1),
(73, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:45:55', NULL, 1),
(74, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:48:16', NULL, 1),
(75, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:51:11', NULL, 1),
(76, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:55:14', NULL, 1),
(77, 11, 'bonty@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 16:59:29', '10-04-2024 10:30:30 PM', 1),
(78, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:05:27', NULL, 1),
(79, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:17:10', '10-04-2024 10:49:05 PM', 1),
(80, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:30:26', '10-04-2024 11:00:31 PM', 1),
(81, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:55:48', '10-04-2024 11:26:22 PM', 1),
(82, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 17:56:29', '10-04-2024 11:26:37 PM', 1),
(83, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-10 18:06:34', '10-04-2024 11:37:10 PM', 1),
(84, NULL, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 08:56:20', NULL, 0),
(85, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 08:56:26', '14-04-2024 02:28:22 PM', 1),
(86, NULL, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:03:00', NULL, 0),
(87, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:03:06', '15-04-2024 12:33:44 AM', 1),
(88, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:04:28', '15-04-2024 12:34:59 AM', 1),
(89, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:06:20', '15-04-2024 12:38:05 AM', 1),
(90, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:36:51', '15-04-2024 01:09:10 AM', 1),
(91, NULL, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:43:31', NULL, 0),
(92, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-14 19:43:37', '15-04-2024 01:13:57 AM', 1),
(93, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-15 10:06:07', '15-04-2024 03:38:13 PM', 1),
(94, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 06:13:13', '16-04-2024 11:45:36 AM', 1),
(95, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 09:08:37', '16-04-2024 02:40:19 PM', 1),
(96, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 10:05:16', '16-04-2024 03:37:33 PM', 1),
(97, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 11:58:13', '16-04-2024 05:29:07 PM', 1),
(98, 17, 'rishab@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 12:37:41', '16-04-2024 06:08:24 PM', 1),
(99, 8, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 12:43:32', '16-04-2024 06:13:53 PM', 1),
(100, 17, 'rishab@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 12:44:08', '16-04-2024 06:14:27 PM', 1),
(101, 17, 'rishab@gmail.com', 0x3a3a3100000000000000000000000000, '2024-04-16 12:45:08', '16-04-2024 06:15:55 PM', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctorslog`
--
ALTER TABLE `doctorslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drug_category`
--
ALTER TABLE `drug_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `drug_table`
--
ALTER TABLE `drug_table`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indexes for table `laboratorist`
--
ALTER TABLE `laboratorist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`pharmacy_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomId`);

--
-- Indexes for table `tblcontactus`
--
ALTER TABLE `tblcontactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpatient`
--
ALTER TABLE `tblpatient`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PatientEmail` (`PatientEmail`),
  ADD KEY `fk_patient_room` (`RoomId`);

--
-- Indexes for table `testreport`
--
ALTER TABLE `testreport`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `P-ID` (`P-ID`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `doctorslog`
--
ALTER TABLE `doctorslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `drug_category`
--
ALTER TABLE `drug_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `drug_table`
--
ALTER TABLE `drug_table`
  MODIFY `drug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laboratorist`
--
ALTER TABLE `laboratorist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `pharmacy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `tblcontactus`
--
ALTER TABLE `tblcontactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `testreport`
--
ALTER TABLE `testreport`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `tblpatient` (`ID`);

--
-- Constraints for table `tblpatient`
--
ALTER TABLE `tblpatient`
  ADD CONSTRAINT `fk_patient_room` FOREIGN KEY (`RoomId`) REFERENCES `rooms` (`RoomId`);

--
-- Constraints for table `testreport`
--
ALTER TABLE `testreport`
  ADD CONSTRAINT `testreport_ibfk_1` FOREIGN KEY (`P-ID`) REFERENCES `tblpatient` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
