-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 12:23 PM
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
-- Database: `sql_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminId` int(11) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Mname` varchar(50) DEFAULT NULL,
  `Lname` varchar(50) NOT NULL,
  `Age` int(11) NOT NULL,
  `Birthday` date NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Profilepic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminId`, `Fname`, `Mname`, `Lname`, `Age`, `Birthday`, `Contact`, `Email`, `Address`, `Password`, `Profilepic`, `created_at`) VALUES
(1, 'Ma. Angel Lae', 'B.', 'Capundan', 24, '2006-11-03', '09205693968', 'lae.cpndn@gmail.com', 'Philippines, Metro Manila, Philippines', 'admin', 'ad_image/dm44.png', '2024-11-15 14:21:51'),
(2, 'Ann Jodelyn', 'N.', 'Enaje', 22, '2003-01-05', '09957364082', 'enajeannjodelyn@gmail.com', 'Philippines, Metro Manila, Philippines', '$2y$10$ciAGUq/AyOi7OvmObl4aR..xw46jvcbiFz6IG1afCYw12wT5HNnu2', 'ad_image/dm66.png', '2024-11-15 14:37:48'),
(3, 'Angilyn', 'B.', 'Yagyagan', 22, '2006-11-02', '09057118300', 'angilyn.yagyagan27@gmail.com', 'Philippines, Metro Manila, Philippines', 'admin', 'ad_image/dm11.png', '2024-11-15 14:40:30'),
(4, 'Kate Ashley', 'N.', 'Baat', 0, '2003-01-15', '09816299920', 'Katebaat13@gmail.com', 'Philippines, Metro Manila, Philippines', 'admin', 'ad_image/dm33.png', '2024-11-16 04:39:27'),
(5, 'Luisa', 'P.', 'Lim', 0, '2006-11-14', '09293695617', 'luisalim21@gmail.com', 'Philippines, Metro Manila, Philippines', 'admin', 'ad_image/dm22.png', '2024-11-17 12:42:01'),
(6, 'Kristina Johanne', 'O.', 'Tayuan', 0, '2006-11-07', '09155935767', 'tayuankristina@gmail.com', 'Philippines, Metro Manila, Philippines', '$2y$10$ghWBoy8q45H.Yvqcb95C8Ol3FlpRlQvpkxWMcwdQJOaA37iPRhAgK', 'ad_image/dm55.png', '2024-11-19 08:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Bookid` int(11) NOT NULL,
  `Userid` int(11) DEFAULT NULL,
  `Locationid` int(11) DEFAULT NULL,
  `LocationSpot` varchar(500) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Destination` varchar(255) NOT NULL,
  `SpecialRequest` varchar(500) NOT NULL,
  `Date` datetime NOT NULL,
  `schedule` varchar(50) NOT NULL,
  `Feedback` varchar(500) NOT NULL,
  `Status` enum('Pending','Accepted','Rejected','Done') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Bookid`, `Userid`, `Locationid`, `LocationSpot`, `Fullname`, `Email`, `Destination`, `SpecialRequest`, `Date`, `schedule`, `Feedback`, `Status`, `created_at`) VALUES
(37, 1, 8, '', 'Alberto L. Enano Jr.', 'enanojra@gmail.com', 'Langun-Gobingob Caves', 'dsad', '2024-11-24 20:13:58', '2024-11-29', '', 'Accepted', '2024-11-24 12:13:59'),
(38, 1, 8, '', 'Alberto L. Enano Jr.', 'enanojra@gmail.com', 'Langun-Gobingob Caves', 'dsad', '2024-11-24 20:15:29', '2024-12-05', '', 'Accepted', '2024-11-24 12:15:30'),
(39, 1, 8, '', 'Alberto L. Enano Jr.', 'enanojra@gmail.com', 'Langun-Gobingob Caves', 'dsad', '2024-11-24 20:15:29', '2024-12-05', '', 'Pending', '2024-11-24 12:16:11'),
(40, 1, 13, '', 'Alberto L. Enano Jr.', 'enanojra@gmail.com', 'San Juanico Bridge', 'dsad', '2024-11-24 20:16:00', '2024-11-08', '', 'Pending', '2024-11-24 12:16:29'),
(41, 1, 10, '', 'Alberto L. Enano Jr.', 'enanojra@gmail.com', 'Biri Rock Formations', 'sadsa', '2024-11-24 20:22:03', '2024-12-05', '', 'Pending', '2024-11-24 12:22:03'),
(42, 1, 8, '', 'Alberto L. Enano Jr.', 'enanojra@gmail.com', 'Langun-Gobingob Caves', 'dsad', '0000-00-00 00:00:00', '2024-11-27', '', 'Pending', '2024-11-24 12:23:57'),
(43, 1, 8, '', 'Alberto L. Enano Jr.', 'enanojra@gmail.com', 'Langun-Gobingob Caves', 'dsa', '2024-11-24 20:24:00', '2024-11-08', '', 'Pending', '2024-11-24 12:24:42'),
(45, 1, 9, '', 'Alberto L. Enano Jr.', 'enanojras@gmail.com', 'Ulot River Torpedo', 'asa', '0000-00-00 00:00:00', '2024-12-05', '', 'Pending', '2024-11-24 12:25:47'),
(46, 1, 9, '', 'Alberto L. Enano Jr.', 'enanojras@gmail.com', 'Ulot River Torpedo', 'dsds', '2024-11-24 20:27:19', '2024-11-24', '', 'Pending', '2024-11-24 12:27:20'),
(47, 1, 9, '', 'Alberto L. Enano Jr.', 'enanojras@gmail.com', 'Ulot River Torpedo', 'dsds', '2024-11-24 20:27:19', '2024-11-24', '', 'Pending', '2024-11-24 12:52:31'),
(48, 1, 16, '', 'Alberto L. Enano Jr.', 'enanojras@gmail.com', 'Pinatubo Beach', 'ss', '2024-11-28 20:41:38', '2024-11-23', '', 'Pending', '2024-11-28 12:41:38'),
(49, 1, 7, '', 'Alberto L. Enano Jr.', 'enanojras@gmail.com', 'Sohoton Cave', 'qwwee', '2024-12-06 19:13:34', '2024-12-09', '', 'Pending', '2024-12-06 11:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msgid`, `name`, `email`, `subject`, `message`) VALUES
(5, 'sa', 'a@gmail.com', 'd', 'ds');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `Locationid` int(11) NOT NULL,
  `LocationSpot` varchar(100) NOT NULL,
  `Location` text NOT NULL,
  `Imagespot` varchar(255) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Days` varchar(254) NOT NULL,
  `Person` int(11) NOT NULL,
  `Activity` varchar(255) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Reviews` text DEFAULT NULL,
  `Points` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`Locationid`, `LocationSpot`, `Location`, `Imagespot`, `Price`, `Days`, `Person`, `Activity`, `Description`, `Reviews`, `Points`, `created_at`) VALUES
(7, 'Sohoton Cave', 'Basey, sa Eastern Visayas, Province of Samar, Philippines.', 'spots/5b.jpg', 10000.00, '4', 1, 'surfing', '', NULL, 0, '2024-11-16 10:22:18'),
(8, 'Langun-Gobingob Caves', 'Barangay Sabang, Catbalogan, Province of Samar, Philippines.', '../img/spots/2b.jfif', 6000.00, '3', 5, '', '', NULL, 0, '2024-11-16 11:55:22'),
(9, 'Ulot River Torpedo', 'Barangay Tenani, Paranas (San Jose de Buan), Province of Samar, Philippines.', '../img/spots/3b.jpg', 10000.00, '5', 10, '', '', NULL, 0, '2024-11-16 11:56:55'),
(10, 'Biri Rock Formations', 'Barangay Cagbana, Biri, Province of Northern Samar, Philippines.', '../img/spots/4c.jpg', 10000.00, '5', 10, '', '', NULL, 0, '2024-11-16 11:58:06'),
(11, 'Calicoan Island Surfing', 'Calicoan Island, Guiuan, Province of Eastern Samar, Philippines.', '../img/spots/5b.jpg', 10000.00, '3', 5, '', '', NULL, 0, '2024-11-16 11:59:16'),
(12, 'Marabut Rock Formatio', 'Marabut, Province of Samar, Philippines.', 'spots/6b.jpg', 6000.00, '5', 3, 'wew', '', NULL, 0, '2024-11-16 12:00:40'),
(13, 'San Juanico Bridge', 'San Juanico Strait, situated between the islands of Samar and Leyte in the Philippines.', 'spots/7c.jpg', 5000.00, '1', 5, '', '', NULL, 0, '2024-11-16 12:35:41'),
(14, 'Capul Island Heritage', 'Capul Island, Municipality of Capul, Province of Northern Samar, Philippines.', '../img/spots/8a.jfif', 3000.00, '3', 5, '', '', NULL, 0, '2024-11-16 12:36:58'),
(15, 'Lulugayan Falls', 'Barangay Hinagdanan, San Jorge, Province of Samar, Philippines.', 'spots/9cc.jpg', 10000.00, '3', 5, '', '', NULL, 0, '2024-11-16 12:38:16'),
(16, 'Pinatubo Beach', 'Barangay Pinatubo, San Vicente, Province of Northern Samar, Philippines.', '../img/spots/10c.jpg', 15000.00, '5', 5, '', '', NULL, 0, '2024-11-16 12:39:12');

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `Processid` int(11) NOT NULL,
  `Homeimg` varchar(255) DEFAULT NULL,
  `weltext1` varchar(500) NOT NULL,
  `weltext2` varchar(500) NOT NULL,
  `subtext1` varchar(255) NOT NULL,
  `subtext2` varchar(255) NOT NULL,
  `subtext3` varchar(255) NOT NULL,
  `subtext4` varchar(255) NOT NULL,
  `subtext5` varchar(255) NOT NULL,
  `subtext6` varchar(255) NOT NULL,
  `ourser1` varchar(255) NOT NULL,
  `ourser2` varchar(255) NOT NULL,
  `ourser3` varchar(255) NOT NULL,
  `ourser4` varchar(255) NOT NULL,
  `popdes1` varchar(255) NOT NULL,
  `popdes2` varchar(255) NOT NULL,
  `popdes3` varchar(255) NOT NULL,
  `popdes4` varchar(255) NOT NULL,
  `Choose` varchar(255) NOT NULL,
  `Pay` varchar(255) NOT NULL,
  `Fly` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `process`
--

INSERT INTO `process` (`Processid`, `Homeimg`, `weltext1`, `weltext2`, `subtext1`, `subtext2`, `subtext3`, `subtext4`, `subtext5`, `subtext6`, `ourser1`, `ourser2`, `ourser3`, `ourser4`, `popdes1`, `popdes2`, `popdes3`, `popdes4`, `Choose`, `Pay`, `Fly`) VALUES
(1, 'process/675312b627668_homeimg.jpg', 'We, your friendly and passionate tourist guides, are excited to take you on an unforgettable journey through the heart of our beautiful island. With years of experience and a deep love for our land, we’re dedicated to showcasing Samar’s natural wonders, rich culture, and hidden gems. From majestic caves and breathtaking waterfalls to lush forests and vibrant local traditions, we ensure every tour is filled with adventure, learning, and unforgettable memories.', 'Discover Samar like never before with guides who know every story and every secret of this paradise. We promise to make your experience safe, fun, and full of excitement, as we share the beauty and history of our beloved island. Let us show you the true spirit of Samar and why it’s a destination worth exploring!', 'Fresh Air', 'Perfect for surfing', 'Best place for relaxing', 'Handpicked Hotels', 'Good for any activities', '24/7 Service', 'Explore the captivating beauty of Samar with our tailored tour packages. Whether you’re seeking pristine beaches, historic landmarks, or thrilling adventures, we ensure a memorable and seamless travel experience for every guest.', 'Enjoy a hassle-free stay with our hotel reservation services. We partner with top accommodations in the region to offer you comfort, convenience, and competitive rates, tailored to fit your budget and preferences.', 'Discover Samar like never before with our expert travel guides. From hidden gems to iconic destinations, our knowledgeable guides ensure you experience the best of what the island has to offer.', 'Make your special occasions extraordinary with our professional event management services. From planning to execution, we handle every detail to create unforgettable events, whether it’s a wedding, corporate gathering, or social celebration.', 'process/6753048fbadca_homeimg.jpg', 'process/673c97012f52a_homeimg.jfif', 'process/673c97012fd2b_homeimg.jpg', 'process/673c9701304bf_homeimg.jpg', 'Discover the hidden beauty of Samar – where breathtaking destinations, vibrant culture, and unforgettable adventures await. Choose Samar and let your journey begin!', 'Offers a fast, secure, and hassle-free way to handle your transactions anytime, anywhere. Simplify your payments with just a few clicks and enjoy the convenience you deserve!', 'Offers you the freedom to travel with ease and convenience. Book your flights in just a few clicks and experience seamless journeys to your dream destinations!');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Userid` int(11) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Mname` varchar(50) DEFAULT NULL,
  `Lname` varchar(50) NOT NULL,
  `Birthday` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ContactNo` varchar(20) NOT NULL,
  `Address` text NOT NULL,
  `Profilepic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Userid`, `Fname`, `Mname`, `Lname`, `Birthday`, `Gender`, `Email`, `Password`, `ContactNo`, `Address`, `Profilepic`, `created_at`) VALUES
(1, 'Alberto', 'Lacsarom', 'Enano Jr', '1999-12-05', 'Male', 'admin@gmail.com', '$2y$10$y8HfTm/B2C.7sBqRRxTx4ex9xFbJ8Ew2jGvz7Z.F3F7F3CFdXKdXu', '09123456789', 'wew', 'img/users/photo_2022-12-20_11-58-50.jpg', '2024-11-16 15:24:56'),
(2, 'Admin1', 'Admin1', 'Admin1', '0000-00-00', 'male', 'Admin1@gmail.com', 'admin', '09123456789', '', NULL, '2024-11-17 08:26:41'),
(3, 'Alberto', 'L.', 'Enano Jr', '0000-00-00', '', 'enanojra@gmail.com', '$2y$10$u6ACVB/rHm/IuqGkoItWzuY97AZMVNHa/Plw13ZyPT04DYDCbAWB2', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/6739c56c15bc1.jpg', '2024-11-17 10:29:00'),
(5, 'Alberto1', 'L.', 'Enano Jr', '0000-00-00', '', 'enanojra1@gmail.com', '$2y$10$X5fByMIZ6J9hhIevTBhjl.42dSKiakUjOFQSpd.HIOmIgzlQAbrha', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/6739cabf8997b.jpg', '2024-11-17 10:51:43'),
(6, 'Alberto1', 'L.', 'Enano Jr', '0000-00-00', 'Male', 'enanojra12@gmail.com', '$2y$10$SIPIexdEk5bcG923eXgrj.wOxu3hqx2HEDbTtXs5HAcCYQKdrS1GW', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/6739cb106c3a3.jpg', '2024-11-17 10:53:04'),
(7, 'Alberto1', 'L.', 'Enano Jr', '0000-00-00', 'Male', 'enanojra123@gmail.com', '$2y$10$7SG.kf/nMyS1Ic7hDyuWO.y3seQZYjrWAnozwOwBGuGt9Z5KGnyQ2', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/6739cb4d9ec09.jpg', '2024-11-17 10:54:05'),
(8, 'Alberto1', 'L.', 'Enano Jr', '1999-12-05', 'Male', 'enanojra1234@gmail.com', '$2y$10$lv41x5kevjpJPwu3ixO3PutVGPF5D9LCp567YybNcBXqLjALEijIa', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/6739cc3c7b284.jpg', '2024-11-17 10:58:04'),
(9, 'Ma. Angel Lae', 'B.', 'Capundan', '2006-11-07', 'Female', 'lae.cpndn@gmail.com', '$2y$10$cmnLK9HyM3UUNsVeWy3DdOy2v2NffW3sa0YGu3HA35ZwGpcP4wGry', '09123456789', 'Philippines, Metro Manila, Philippines', 'img/users/673cc0bc1b126.png', '2024-11-19 16:45:48'),
(10, 'Ann Jodelyn', 'N.', 'Enaje', '2006-11-08', 'Female', 'enajeannjodelyn@gmail.com', 'admin', '09957364082', 'Philippines, Metro Manila, Philippines', 'img/users/673cc2af5d4b7.png', '2024-11-19 16:54:07'),
(11, 'Alberto', 'L.', 'Enano Jr', '2006-11-08', 'Male', 'enanojra11@gmail.com', 'admin', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/673d82a251d8b.jpg', '2024-11-20 06:33:06'),
(12, 'Alberto', 'L.', 'Enano Jr', '2006-11-01', 'Male', 'enano@gmail.com', '123', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/673d83e5589c7.jpg', '2024-11-20 06:38:29'),
(13, 'a', 'L.', 'a', '2006-12-06', 'Male', 'a@gmail.com', 'admin', '09709356845', 'Philippines, Caloocan, Metro Manila, Philippines', 'img/users/6756cee8e669b.jpg', '2024-12-09 11:05:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminId`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Bookid`),
  ADD KEY `Userid` (`Userid`),
  ADD KEY `Locationid` (`Locationid`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgid`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`Locationid`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`Processid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Userid`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Bookid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `Locationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `Processid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Userid`) REFERENCES `user` (`Userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Locationid`) REFERENCES `package` (`Locationid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
