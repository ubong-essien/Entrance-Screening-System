-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2019 at 11:56 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `putme_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `state_tb`
--

CREATE TABLE `state_tb` (
  `StateID` int(11) NOT NULL,
  `StateName` varchar(100) NOT NULL,
  `StateAbbr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state_tb`
--

INSERT INTO `state_tb` (`StateID`, `StateName`, `StateAbbr`) VALUES
(1, 'ABIA', 'ABI'),
(2, 'ADAMAWA', 'ADA'),
(3, 'AKWA IBOM ', 'AKI'),
(4, 'ANAMBRA', 'ANA'),
(5, 'BAUCHI', 'BAU'),
(6, 'BAYELSA', 'BAY'),
(7, 'BENUE', 'BEN'),
(8, 'BORNO', 'BOR'),
(9, 'CROSS RIVER', 'CRS'),
(10, 'DELTA', 'DEL'),
(11, 'EBONYI', 'EBO'),
(12, 'EDO', 'EDO'),
(13, 'EKITI', 'EKI'),
(14, 'ENUGU', 'ENU'),
(15, 'GOMBE', 'GOM'),
(16, 'IMO', 'IMO'),
(17, 'JIGAWA', 'JIG'),
(18, 'KADUNA', 'KAD'),
(19, 'KANO', 'KAN'),
(20, 'KATSINA', 'KAT'),
(21, 'KEBBI', 'KEB'),
(22, 'KWARA', 'KWA'),
(23, 'LAGOS', 'LAG'),
(24, 'NASSARAWA', 'NAS'),
(25, 'NIGER', 'NIG'),
(26, 'OGUN', 'OGU'),
(27, 'ONDO', 'OND'),
(28, 'OSUN', 'OSU'),
(29, 'OYO', 'OYO'),
(30, 'PLATEAU', 'PLA'),
(31, 'RIVERS', 'RIV'),
(32, 'SOKOTO', 'SOK'),
(33, 'TARABA', 'TAR'),
(34, 'YOBE', 'YOB'),
(35, 'ZAMFARA', 'ZAM'),
(36, 'KOGI', 'KOG'),
(37, 'FCT', 'FCT'),
(38, 'NON-NIGERIAN', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `state_tb`
--
ALTER TABLE `state_tb`
  ADD PRIMARY KEY (`StateID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `state_tb`
--
ALTER TABLE `state_tb`
  MODIFY `StateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
