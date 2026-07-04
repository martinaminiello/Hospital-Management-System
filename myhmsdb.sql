-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 16, 2020 at 02:34 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myhmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admintb`
--

CREATE TABLE `admintb` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admintb`
--
INSERT INTO `admintb` (`username`, `password`) VALUES
('admin', '$2y$10$OdynGKMxIW5yrnhzz5CQl.3Pzvt/gYvEnTS6u1w0DcptN2ZO7.i8S');

-- --------------------------------------------------------

--
-- Table structure for table `appointmenttb`
--

CREATE TABLE `appointmenttb` (
  `pid` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `doctor` varchar(30) NOT NULL,
  `docFees` int(5) NOT NULL,
  `appdate` date NOT NULL,
  `apptime` time NOT NULL,
  `userStatus` int(5) NOT NULL,
  `doctorStatus` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointmenttb`
--

INSERT INTO `appointmenttb` (`pid`, `ID`, `fname`, `lname`, `gender`, `email`, `contact`, `doctor`, `docFees`, `appdate`, `apptime`, `userStatus`, `doctorStatus`) VALUES
(4, 1, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-14', '10:00:00', 1, 0),
(4, 2, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '10:00:00', 0, 1),
(4, 3, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Amit', 1000, '2020-02-19', '03:00:00', 0, 1),
(11, 4, 'Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', 'ashok', 500, '2020-02-29', '20:00:00', 1, 1),
(4, 5, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-02-28', '12:00:00', 1, 1),
(4, 6, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '2020-02-26', '15:00:00', 0, 1),
(2, 8, 'Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', 'Ganesh', 550, '2020-03-21', '10:00:00', 1, 1),
(5, 9, 'Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', 'Ganesh', 550, '2020-03-19', '20:00:00', 1, 0),
(4, 10, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Ganesh', 550, '0000-00-00', '14:00:00', 1, 0),
(4, 11, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', 'Dinesh', 700, '2020-03-27', '15:00:00', 1, 1),
(9, 12, 'William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'Kumar', 800, '2020-03-26', '12:00:00', 1, 1),
(9, 13, 'William', 'Blake', 'Male', 'william@gmail.com', '8683619153', 'Tiwary', 450, '2020-03-26', '14:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(30) NOT NULL,
  `email` text NOT NULL,
  `contact` varchar(10) NOT NULL,
  `message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `contact`, `message`) VALUES
('Anu', 'anu@gmail.com', '7896677554', 'Hey Admin'),
(' Viki', 'viki@gmail.com', '9899778865', 'Good Job, Pal'),
('Ananya', 'ananya@gmail.com', '9997888879', 'How can I reach you?'),
('Aakash', 'aakash@gmail.com', '8788979967', 'Love your site'),
('Mani', 'mani@gmail.com', '8977768978', 'Want some coffee?'),
('Karthick', 'karthi@gmail.com', '9898989898', 'Good service'),
('Abbis', 'abbis@gmail.com', '8979776868', 'Love your service'),
('Asiq', 'asiq@gmail.com', '9087897564', 'Love your service. Thank you!'),
('Jane', 'jane@gmail.com', '7869869757', 'I love your service!');

-- --------------------------------------------------------

--
-- Table structure for table `doctb`
--

CREATE TABLE `doctb` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `spec` varchar(50) NOT NULL,
  `docFees` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctb`
--
INSERT INTO `doctb` (`username`, `password`, `email`, `spec`, `docFees`) VALUES
('ashok', '$2y$10$/62EhZIqReZRFR4IjQxlOOtKwgJQuEEeZ/pQ9Vt7wdwO/W3cEYXx6', 'ashok@gmail.com', 'General', 500),
('arun', '$2y$10$.uLBDb9bbUxHv6vA88ursu7NfZ9Ms8PiwGlaL0QTdzEH/4g9p4jB.', 'arun@gmail.com', 'Cardiologist', 600),
('Dinesh', '$2y$10$gJtYBsoN38cLdWS6o5nb0eExdRD86UTjIafKpKd5wmSVe2LlANCGu', 'dinesh@gmail.com', 'General', 700),
('Ganesh', '$2y$10$46yf/H16oj9wUyk.zlPFIeWuSnq/PSuNP5lyTxELFZMAGFJLE4Xlu', 'ganesh@gmail.com', 'Pediatrician', 550),
('Kumar', '$2y$10$Tw0WMIXBXPwO6Q39F2NfBOgK6RXqktJWSaYewAq624TIhF1CJtSky', 'kumar@gmail.com', 'Pediatrician', 800),
('Amit', '$2y$10$j8euwsz2.9jiwKN8N1082.mh6AoW0gv6Z7jf77RZRwvt5biyA6IDK', 'amit@gmail.com', 'Cardiologist', 1000),
('Abbis', '$2y$10$NjLmxv/fjBCSGlyihehKEOEhpVomAMbVfES.kYrbUxPWCrgftKNfi', 'abbis@gmail.com', 'Neurologist', 1500),
('Tiwary', '$2y$10$DnJjDZZ/1z1XgEdwfiU.WuvP4Q1R1tyb4fz3oCFWXJRFWHkX8J.AC', 'tiwary@gmail.com', 'Pediatrician', 450);

-- --------------------------------------------------------

--
-- Table structure for table `patreg`
--

CREATE TABLE `patreg` (
  `pid` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patreg`
--
INSERT INTO `patreg` (`pid`, `fname`, `lname`, `gender`, `email`, `contact`, `password`, `cpassword`) VALUES
(1, 'Ram', 'Kumar', 'Male', 'ram@gmail.com', '9876543210', '$2y$10$wyeq0XLNZYpA0tetue59t.9.8OYwQyIKDV8eI38aXi2QTyIoOh6pC', '$2y$10$wyeq0XLNZYpA0tetue59t.9.8OYwQyIKDV8eI38aXi2QTyIoOh6pC'),
(2, 'Alia', 'Bhatt', 'Female', 'alia@gmail.com', '8976897689', '$2y$10$xkHLoQxyQ57JmywTtUgP0OqVRJj8QCIea8HjrUqNbXSFs0Ekb/Uhu', '$2y$10$xkHLoQxyQ57JmywTtUgP0OqVRJj8QCIea8HjrUqNbXSFs0Ekb/Uhu'),
(3, 'Shahrukh', 'khan', 'Male', 'shahrukh@gmail.com', '8976898463', '$2y$10$CB5rqcbW1TGpOzBweA/oAezSHqF8oirs2StMbAF50CInAjXzEdC56', '$2y$10$CB5rqcbW1TGpOzBweA/oAezSHqF8oirs2StMbAF50CInAjXzEdC56'),
(4, 'Kishan', 'Lal', 'Male', 'kishansmart0@gmail.com', '8838489464', '$2y$10$imPAB/6Gme/qs.addDCJeeUwC90VjZirP5LXfBpEyphlCZhq7i0/K', '$2y$10$imPAB/6Gme/qs.addDCJeeUwC90VjZirP5LXfBpEyphlCZhq7i0/K'),
(5, 'Gautam', 'Shankararam', 'Male', 'gautam@gmail.com', '9070897653', '$2y$10$cy75McreNnnpPLL7seOUlu8On0yHFXqwJUBDjneEnBq3VDCmRIrjy', '$2y$10$cy75McreNnnpPLL7seOUlu8On0yHFXqwJUBDjneEnBq3VDCmRIrjy'),
(6, 'Sushant', 'Singh', 'Male', 'sushant@gmail.com', '9059986865', '$2y$10$7xPk0uSVnri3XSnO2mVQcO98/BNrvFQekD89TS2cxjujqskMrAvFe', '$2y$10$7xPk0uSVnri3XSnO2mVQcO98/BNrvFQekD89TS2cxjujqskMrAvFe'),
(7, 'Nancy', 'Deborah', 'Female', 'nancy@gmail.com', '9128972454', '$2y$10$Nb4H4I5hmpw1SV268CFFbe2qjOtgaZgr62CIonPzGSKZJlgSvHviK', '$2y$10$Nb4H4I5hmpw1SV268CFFbe2qjOtgaZgr62CIonPzGSKZJlgSvHviK'),
(8, 'Kenny', 'Sebastian', 'Male', 'kenny@gmail.com', '9809879868', '$2y$10$NPCH/KiGJZO.YhAwY6Oc5OpOG5Fg1y2mM/M7CNOTBbnEJWe1E7cC.', '$2y$10$NPCH/KiGJZO.YhAwY6Oc5OpOG5Fg1y2mM/M7CNOTBbnEJWe1E7cC.'),
(9, 'William', 'Blake', 'Male', 'william@gmail.com', '8683619153', '$2y$10$RBM12/ipuRFpPMsIMlmotOSILR/shCm5FUBe91M5qehxnu8YT1dLu', '$2y$10$RBM12/ipuRFpPMsIMlmotOSILR/shCm5FUBe91M5qehxnu8YT1dLu'),
(10, 'Peter', 'Norvig', 'Male', 'peter@gmail.com', '9609362815', '$2y$10$m0V.jKcsMbsaa1SVkBPqQeO1G6fimCKOHej.UTad5cfcS.FR.ROfK', '$2y$10$m0V.jKcsMbsaa1SVkBPqQeO1G6fimCKOHej.UTad5cfcS.FR.ROfK'),
(11, 'Shraddha', 'Kapoor', 'Female', 'shraddha@gmail.com', '9768946252', '$2y$10$CgDm3HKXW3KcM1gUmOkkqOJAfEi7UqL4YWSGLz0Cia3o7fjc./pcS', '$2y$10$CgDm3HKXW3KcM1gUmOkkqOJAfEi7UqL4YWSGLz0Cia3o7fjc./pcS');

-- --------------------------------------------------------

--
-- Table structure for table `prestb`
--

CREATE TABLE `prestb` (
  `doctor` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `appdate` date NOT NULL,
  `apptime` time NOT NULL,
  `disease` varchar(250) NOT NULL,
  `allergy` varchar(250) NOT NULL,
  `prescription` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prestb`
--

INSERT INTO `prestb` (`doctor`, `pid`, `ID`, `fname`, `lname`, `appdate`, `apptime`, `disease`, `allergy`, `prescription`) VALUES
('Dinesh', 4, 11, 'Kishan', 'Lal', '2020-03-27', '15:00:00', 'Cough', 'Nothing', 'Just take a teaspoon of Benadryl every night'),
('Ganesh', 2, 8, 'Alia', 'Bhatt', '2020-03-21', '10:00:00', 'Severe Fever', 'Nothing', 'Take bed rest'),
('Kumar', 9, 12, 'William', 'Blake', '2020-03-26', '12:00:00', 'Sever fever', 'nothing', 'Paracetamol -> 1 every morning and night'),
('Tiwary', 9, 13, 'William', 'Blake', '2020-03-26', '14:00:00', 'Cough', 'Skin dryness', 'Intake fruits with more water content');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointmenttb`
--
ALTER TABLE `appointmenttb`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `patreg`
--
ALTER TABLE `patreg`
  ADD PRIMARY KEY (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointmenttb`
--
ALTER TABLE `appointmenttb`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `patreg`
--
ALTER TABLE `patreg`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;