-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autobird`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `name` varchar(30) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`name`, `pass`, `id`) VALUES
('admin', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bid` int(10) NOT NULL,
  `uid` int(11) NOT NULL,
  `pick` varchar(35) NOT NULL,
  `dest` varchar(35) NOT NULL,
  `bdate` date NOT NULL,
  `btime` time(4) NOT NULL,
  `driverId` int(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'booked',
  `pickup_lat` varchar(50) DEFAULT NULL,
  `pickup_lng` varchar(50) DEFAULT NULL,
  `dest_lat` varchar(50) DEFAULT NULL,
  `dest_lng` varchar(50) DEFAULT NULL,
  `eta` int(11) DEFAULT NULL,
  `fare` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bid`, `uid`, `pick`, `dest`, `bdate`, `btime`, `driverId`, `status`, `pickup_lat`, `pickup_lng`, `dest_lat`, `dest_lng`, `eta`, `fare`) VALUES
(205, 7, '1st gate belguam', 'nanawadi', '2025-05-19', '12:00:00.0000', 33, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(214, 9, 'Nanawadi', '1st gate belguam', '2025-05-29', '09:00:00.0000', 36, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(217, 9, 'Nanawadi', 'bogarves', '2025-05-21', '20:00:00.0000', 36, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(235, 7, 'bogarwes', '1st gate belguam', '2025-05-09', '05:00:00.0000', 33, 'Booked', NULL, NULL, NULL, NULL, NULL, NULL),
(244, 12, '1st gate belguam', 'nanawadi', '2025-05-23', '15:00:00.0000', 33, 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL),
(250, 10, '2nd Gate', 'CBT', '2025-07-02', '10:00:00.0000', 37, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(251, 13, 'CBT', '3rd Gate', '2025-07-02', '16:00:00.0000', 36, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(253, 38, '2nd Gate', '1st gate belguam', '2025-07-09', '11:00:00.0000', 19, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(255, 36, 'Nanawadi', 'Tilkwadi', '2025-07-04', '08:30:00.0000', 33, 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL),
(258, 36, '1st gate belguam', 'bogarves', '2025-07-06', '12:00:00.0000', 38, 'booked', NULL, NULL, NULL, NULL, NULL, NULL),
(259, 36, '1st gate belguam', 'bogarves', '2025-07-06', '12:00:00.0000', 33, 'booked', NULL, NULL, NULL, NULL, NULL, NULL),
(260, 36, '1st gate belguam', 'bogarves', '2025-07-06', '12:00:00.0000', 33, 'booked', NULL, NULL, NULL, NULL, NULL, NULL),
(267, 10, '2nd Gate', 'nanawadi', '2025-07-05', '16:00:00.0000', 36, 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL),
(268, 42, '2nd Gate', 'CBT', '2025-07-06', '09:00:00.0000', 36, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(269, 42, '2nd Gate', 'CBT', '2025-07-06', '09:00:00.0000', 36, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(270, 15, 'Nanawadi', '3rd Gate', '2025-07-08', '14:00:00.0000', 36, 'dropped', NULL, NULL, NULL, NULL, NULL, NULL),
(271, 13, 'CBT', 'bogarves', '2025-07-07', '19:00:00.0000', 19, 'booked', NULL, NULL, NULL, NULL, NULL, NULL),
(272, 48, 'Nanawadi', '1st gate belguam', '2025-07-04', '14:00:00.0000', 36, 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL),
(273, 48, 'Nanawadi', 'CBT', '2025-07-18', '09:00:00.0000', 36, 'dropped', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(274, 48, 'madhuvan pg 1st gate', 'bogarves', '2025-07-16', '14:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(275, 48, 'Nanawadi', 'madhuvan pg near 1st gate', '2025-07-16', '18:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(276, 48, '1st gate belguam', 'CBT', '2025-07-16', '17:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(277, 48, '1st gate belguam', 'bogarves', '2025-07-16', '17:15:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(278, 48, 'Nanawadi', 'Tilkwadi', '2025-07-16', '17:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(279, 48, 'Nanawadi', 'Tilkwadi', '2025-07-17', '17:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(280, 48, '1st gate belguam', 'bogarves', '2025-07-16', '17:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(281, 48, 'madhuvan pg 1st gate', 'bogarves', '2025-07-17', '17:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(282, 48, 'madhuvan pg 1st gate', 'bogarves', '2025-07-16', '17:30:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(283, 48, '1st gate belguam', 'CBT', '2025-07-17', '09:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(284, 48, 'Nanawadi', 'Tilkwadi', '2025-07-17', '10:00:00.0000', 36, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(285, 48, 'madhuvan pg 1st gate', 'bogarves', '2025-07-17', '10:00:00.0000', 37, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(286, 48, 'bogarwes', 'CBT', '2025-07-17', '15:00:00.0000', 37, 'cancelled', '15.8381743', '74.4877192', NULL, NULL, NULL, NULL),
(287, 48, 'CBT', 'Tilkwadi', '2025-07-18', '09:00:00.0000', 37, 'cancelled', '15.838156', '74.489917', NULL, NULL, NULL, NULL),
(288, 48, 'CBT', 'bogarves', '2025-07-18', '09:30:00.0000', 41, 'cancelled', '15.838156', '74.489917', NULL, NULL, NULL, NULL),
(289, 48, 'madhuvan pg 1st gate', 'CBT', '2025-07-19', '13:00:00.0000', 37, 'cancelled', '18.5663488', '73.8525184', NULL, NULL, NULL, NULL),
(290, 48, 'Belguam City Bus Station, Belagavi,', 'Angadi Institution of Technology An', '2025-07-20', '08:41:00.0000', 37, 'cancelled', '17.6700736', '75.9010467', NULL, NULL, NULL, NULL),
(291, 48, 'Angadi Institution of Technology An', 'Tilakwadi, Belagavi, Karnataka', '2025-07-21', '09:30:00.0000', 42, 'cancelled', '15.8459912', '74.47448937580785', '15.8368581', '74.5019281', 0, NULL),
(292, 48, 'Madhuvan Girls Hostel, Belagavi, Ka', 'Bogarvase Circle, Belagavi, Karnata', '2025-07-22', '10:00:00.0000', 43, 'cancelled', '15.8431172', '74.5008037', '15.8593095', '74.5080955091064', 0, NULL),
(293, 48, '(Central Bus Stand) CBT, Belagavi, ', 'Bogarvase Circle, Belagavi, Karnata', '2025-07-22', '11:00:00.0000', 37, 'cancelled', '15.8638847', '74.5210605349558', '15.8593095', '74.5080955091064', 0, NULL),
(294, 48, 'Angol, Belagavi, Karnataka', 'Tilakwadi, Belagavi, Karnataka', '2025-07-23', '11:30:00.0000', 41, 'booked', '15.8229951', '74.5030977', '15.8368581', '74.5019281', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fares`
--

CREATE TABLE `fares` (
  `id` int(255) NOT NULL,
  `distance` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fares`
--

INSERT INTO `fares` (`id`, `distance`, `cost`) VALUES
(4, '1KM', '10rs'),
(5, '2KM', '20rs');

-- --------------------------------------------------------

--
-- Table structure for table `garege`
--

CREATE TABLE `garege` (
  `gid` int(10) NOT NULL,
  `gname` varchar(20) NOT NULL,
  `gaddress` varchar(35) NOT NULL,
  `lat` double(10,6) NOT NULL,
  `lng` double(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `garege`
--

INSERT INTO `garege` (`gid`, `gname`, `gaddress`, `lat`, `lng`) VALUES
(1, 'Anam Garege', 'Shivaji Nagar', 15.869534, 74.518911),
(2, 'sangli Auto gar', 'Kudchi Road', 16.814486, 74.539354),
(3, 'Vinay Auto garege', 'Kore Galli Shahapur Belgaum', 15.842250, 74.512920),
(4, 'Renuka Auto Garege', 'Majgaon cross Khanapur rd.udaymbag', 15.838220, 74.496011),
(5, 'Desai auto garege', 'Angol main road bhagyanagar', 15.830037, 74.505011),
(6, 'Pankaj motors', 'Shukrawar Peth tilakwadi', 15.838408, 74.501621),
(7, 'Imran Auto Garege', 'Hindwadi Belgaum', 15.869534, 74.518911),
(8, 'Rehan Auto Garege', 'Mahantesh Nagar Belgaum', 15.874000, 74.529500),
(9, 'Sai Auto Garege', 'Ganeshpur Belgaum', 15.864800, 74.473400),
(10, 'Swara Auto Garege', 'Chavat galli old pb road belgaum', 15.864166, 74.504506),
(11, 'Omshivshankar auto g', 'Sambra Road Maruti Nagar', 15.858040, 74.532182),
(12, 'Raj Auto Garege', 'Mandoli Road ', 15.846539, 74.477989);

-- --------------------------------------------------------

--
-- Table structure for table `kkdriver`
--

CREATE TABLE `kkdriver` (
  `did` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `lno` varchar(20) NOT NULL,
  `phone` int(11) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(16) NOT NULL,
  `status` int(1) NOT NULL,
  `is_assigned` tinyint(4) DEFAULT 0,
  `last_assigned` datetime DEFAULT NULL,
  `total_rides` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kkdriver`
--

INSERT INTO `kkdriver` (`did`, `fname`, `lname`, `email`, `lno`, `phone`, `latitude`, `longitude`, `location_name`, `photo`, `username`, `password`, `status`, `is_assigned`, `last_assigned`, `total_rides`) VALUES
(19, 'jayant', 'kumar', 'jk@gmail.com', 'abf80976', 2147483647, 15.8551, 74.5044, 'CBT', 'hand.jpg', 'jk', '123', 0, 1, '2025-07-02 02:33:24', 4),
(33, 'kishor ', 'patil', 'kp@gmail.com', 'kpatil111', 2147483647, 15.8465, 74.4879, 'RPD College / Tilakwadi', 'tuktuk.jpg', 'kp', '123', 0, 1, '2025-07-02 00:37:23', 5),
(36, 'mahadev', 'patil', 'mp@gmail.com', 'mp1234 ', 2147483647, 15.8575, 74.5081, 'Bogarves / Camp Area', 'tuktuk.jpg', 'mp', '123', 0, 0, '2025-07-16 23:35:41', 20),
(37, 'kanha', 'kumar', 'kk@gmail.com', 'kkumar111', 2147483647, 15.858, 74.5069, 'Gogte Circle', 'tuktuk.jpg', 'kk', '123', 0, 0, '2025-07-20 06:14:13', 11),
(38, 'veda', 'kumar', 'vk@gmail.com', 'vk123', 2147483647, 15.8383, 74.5089, 'Angol', 'tuktuk.jpg', 'vk', '123', 0, 1, '2025-07-02 00:04:57', 3),
(41, 'Sainath', 'Patil', 'sp@gmail.com', 'sp1234', 2147483647, 15.8465, 74.4879, 'RPD College / Tilakwadi', 'hand.jpg', 'sp', '123', 0, 1, '2025-07-20 06:25:48', 2),
(42, 'Nishant', 'Patil', 'np@gmail.com', 'np1234', 2147483647, 15.8465, 74.4879, 'RPD College / Tilakwadi', 'logo.png', 'np', '123', 0, 0, '2025-07-20 05:10:35', 1),
(43, 'Amol', 'Patil', 'ap@gmail.com', 'ap1234', 2147483647, 15.8465, 74.4879, 'RPD College / Tilakwadi', 'traffic.jpg', 'ap', '123', 0, 0, '2025-07-20 05:36:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(10) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `email`, `password`, `phone`, `photo`) VALUES
(1, 'vaishnavi', 'vaishnavi@gmail.com', '9901', '111', '1682661146375-3.jpg'),
(2, 'ankita', 'Ankita@gmail.com', '990', '111', ''),
(3, 'sakshi', 's@gmail.com', '9900', '111', ''),
(4, 'nandini', 'mannurkar', 'nand123', '111', ''),
(5, 'vaishnavi', 'joivaishnavi472@gmai', '2001', '111', '1682661146375-3.jpg'),
(6, 'kishor', 'keshukawale@gmail.co', '123', '778787', '1682661146375-3.jpg'),
(7, 'piya', 'p@gmail.com', '123', '12345', 'logo.png'),
(8, 'diksha', 'd@gmail.com', '123', '12345', 'logo.png'),
(9, 'keshav', 'k@gmail.com', '123', '12345', 'logo.png'),
(10, 'a', 'a@gmail.com', '123', '', ''),
(11, 'mayuri', 'm@gmail.com', '123', '9421656878', 'logo.png'),
(12, 'anu', 'a@gmail.com', '123', '', ''),
(13, 'varsha', 'v@gmail.com', '123', '', ''),
(14, 'sam', 's@gmail.com', '123', '', ''),
(15, 'sonali', 's@gmail.com', '123', '9988665544', ''),
(35, 'q', 'q@gmail.com', '123', '', ''),
(36, 'r', 'r@gmail.com', '123', '', ''),
(38, 't', 't@gmail.com', '123', '', ''),
(42, 'x', 'x@gmail.com', '123', '', ''),
(47, 'P1', 'p@gmail.com', '$2y$10$1PGTNzq4Rx7cm', '9452598525', ''),
(48, 'P1', 'p@gmail.com', '123', '9452598525', 'logo.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `booking_ibfk_2` (`driverId`);

--
-- Indexes for table `fares`
--
ALTER TABLE `fares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `garege`
--
ALTER TABLE `garege`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `kkdriver`
--
ALTER TABLE `kkdriver`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;

--
-- AUTO_INCREMENT for table `fares`
--
ALTER TABLE `fares`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `garege`
--
ALTER TABLE `garege`
  MODIFY `gid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kkdriver`
--
ALTER TABLE `kkdriver`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`driverId`) REFERENCES `kkdriver` (`did`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
