-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2024 at 06:42 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id19727041_ktcwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `id` int(11) NOT NULL,
  `adminemail` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`id`, `adminemail`, `password`, `create_at`) VALUES
(1, 'adminktc@gmail.com', 'adminktc', '2023-04-02 05:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `banktransfer`
--

CREATE TABLE `banktransfer` (
  `id` int(11) NOT NULL,
  `image_filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `point` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class_name`, `price`, `point`, `file_path`) VALUES
(1, 'Programming Dojo (per session)', '45', 45, 'uploads/programmingdojo.png'),
(2, 'Scratch Game Programming (per session)', '45', 45, 'uploads/scratch.png'),
(3, 'Micro-bit (per session)', '45', 45, 'uploads/microbit.png'),
(4, 'Micro-Bit Junior Learning Kit', '150', 150, 'uploads/microbotkit.jpg'),
(5, 'Japan Language Class (monthly)', '140', 140, 'uploads/japaneselanguage.png'),
(6, 'Japan Language Class (full)', '700', 700, 'uploads/japaneselanguage.png');

-- --------------------------------------------------------

--
-- Table structure for table `classpurchase`
--

CREATE TABLE `classpurchase` (
  `id` int(11) NOT NULL,
  `rec_id` varchar(255) NOT NULL,
  `studentname` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `point` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `image_filename` varchar(255) DEFAULT NULL,
  `total_price` int(11) NOT NULL,
  `total_points` int(11) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Triggers `classpurchase`
--
DELIMITER $$
CREATE TRIGGER `update_total_points_after_classpurchase` AFTER INSERT ON `classpurchase` FOR EACH ROW BEGIN
    UPDATE tbl_member m
    SET m.totalpointpurchase = m.totalpointpurchase + NEW.total_points
    WHERE m.rec_id = NEW.rec_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`first_name`, `last_name`, `gender`, `address`, `email`) VALUES
('assaa', 'asdasda', 'male', 'asdasd', 'asdad');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `discount_percentage`) VALUES
(1, 'COUPON1', '10.00'),
(2, 'SUMMER25', '25.00'),
(3, 'SALE50', '50.00'),
(4, 'WELCOME15', '15.00'),
(5, 'FREESHIP', '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `customerredeem`
--

CREATE TABLE `customerredeem` (
  `rec_id` varchar(255) NOT NULL,
  `gift_name` varchar(255) NOT NULL,
  `redeempoint` int(11) NOT NULL,
  `redeem_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customerredeem`
--

INSERT INTO `customerredeem` (`rec_id`, `gift_name`, `redeempoint`, `redeem_date`) VALUES
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-04 01:15:20'),
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-16 00:45:29'),
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-19 07:04:44'),
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-19 08:37:09'),
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-19 09:10:13'),
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-19 09:12:09'),
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-19 09:12:18'),
('KTC000054', 'KTC BUTTON BADGE', 50, '2024-01-19 09:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `exhibition`
--

CREATE TABLE `exhibition` (
  `id` int(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `point` int(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `exhibition`
--

INSERT INTO `exhibition` (`id`, `country_name`, `price`, `point`, `file_path`) VALUES
(74, 'Malaysian', 15, 15, 'uploads/malaysian.jfif'),
(75, 'Non-Malaysian', 25, 25, 'uploads/japanese.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `exhibition_purchase`
--

CREATE TABLE `exhibition_purchase` (
  `id` int(11) NOT NULL,
  `exhibition_id` int(11) DEFAULT NULL,
  `rec_id` varchar(255) NOT NULL,
  `studentname` varchar(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `point` int(11) NOT NULL,
  `booking_time` time DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL,
  `total_points` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



--
-- Triggers `exhibition_purchase`
--
DELIMITER $$
CREATE TRIGGER `update_total_points_after_exhibition_purchase` AFTER INSERT ON `exhibition_purchase` FOR EACH ROW BEGIN
    UPDATE tbl_member m
    SET m.totalpointpurchase = m.totalpointpurchase + NEW.point
    WHERE m.rec_id = NEW.rec_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `name`, `email`, `age`, `address`) VALUES
(1, 'ada', 'adasd', 21, 'daa');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `file_path`, `image_name`, `image_price`) VALUES
(1, 'uploads/6493ec01d095b_ktcbadge.jpg', 'seua', '123.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `rec_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `downloaded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `rec_id`, `file_name`, `downloaded_at`) VALUES
(1, 0, 'invoice_KTC000041.txt', '2023-08-22 06:56:58'),
(2, 0, NULL, '2023-08-22 07:02:01'),
(3, 0, 'invoice_KTC000041.txt', '2023-08-22 07:05:12'),
(4, 0, 'invoice_KTC000041.txt', '2023-08-22 07:06:14');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_content`
--

CREATE TABLE `invoice_content` (
  `invoice_id` int(11) NOT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice_content`
--

INSERT INTO `invoice_content` (`invoice_id`, `content`) VALUES
(0, 'Invoice Details:\nStudent Name: li\nPayment Method: cash\nProduct Name: Remote Control Car\nQuantity: 1\nPrice: 25\nTotal Price: 25\nProduct Name: Apitor SuperBot (STEM)\nQuantity: 3\nPrice: 350\nTotal Price: 1050\n');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `total_point` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL,
  `rec_id` int(11) NOT NULL,
  `overallPoints` int(11) NOT NULL,
  `redeemPoints` int(11) NOT NULL,
  `redeemedItem` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `rec_id`, `overallPoints`, `redeemPoints`, `redeemedItem`, `created_at`, `updated_at`) VALUES
(4, 0, 5855, 0, '', '2023-12-15 06:33:46', '2023-12-15 06:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_ID` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `point` int(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_ID`, `product_name`, `price`, `point`, `file_path`) VALUES
(1, '01', 'KidzTechCentreButtonBadge', 3, 3, 'uploads/ktcbadge.jpg'),
(2, '02', 'Bionic Worm Crawling Robot', 15, 15, 'uploads/bionicworm.jpg'),
(3, '03', 'Geared Mobile Robot', 18, 18, 'uploads/gearedrobot.jpg'),
(4, '04', 'Cap KidzTechCentre Logo', 20, 20, 'uploads/ktccap.jpg'),
(5, '06', 'Remote Control Car', 25, 25, 'uploads/remotecontrolcar.jpg'),
(6, '07', 'Apitor SuperBot (STEM)', 350, 350, 'uploads/apitor.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `productpurchase`
--

CREATE TABLE `productpurchase` (
  `id` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `studentname` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `point` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_points` int(11) NOT NULL,
  `rec_id` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `image_filename` varchar(255) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Triggers `productpurchase`
--
DELIMITER $$
CREATE TRIGGER `update_total_points_after_productpurchase` AFTER INSERT ON `productpurchase` FOR EACH ROW BEGIN
    UPDATE tbl_member m
    SET m.totalpointpurchase = m.totalpointpurchase + NEW.total_points
    WHERE m.rec_id = NEW.rec_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `programposter`
--

CREATE TABLE `programposter` (
  `id` int(11) NOT NULL,
  `image_filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `programposter`
--

INSERT INTO `programposter` (`id`, `image_filename`) VALUES
(0, 'R2KTCSchoolHolidayProgram.png');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `studentname` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `points` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `total_points` int(11) NOT NULL,
  `rec_id` varchar(255) NOT NULL,
  `image_filename` varchar(255) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `payment_status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL,
  `booking_time` time DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `payment_datetime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `type`, `program`, `studentname`, `price`, `points`, `quantity`, `total_price`, `total_points`, `rec_id`, `image_filename`, `purchase_date`, `bank_name`, `account_number`, `payment_status`, `payment_method`, `booking_time`, `booking_date`, `payment_datetime`) VALUES
(1, 'Exhibition', 'Malaysian', 'Desb', 15.00, 15, 1, 15.00, 15, 'KTC000009', 'uploads/IMG_3A602C392738-1.jpeg', '2024-01-09 01:56:45', 'mak kau hijau', '123456789', 'pending', 'Pay with Bank', '10:36:00', '2024-01-09', '020403'),
(2, 'Exhibition', 'Malaysian', 'Desb', 15.00, 15, 1, 15.00, 15, 'KTC000009', 'uploads/IMG_3A602C392738-1.jpeg', '2024-01-09 01:56:46', 'mak kau hijau', '123456789', 'pending', 'Pay with Bank', '13:52:00', '2024-01-27', '020403');
--
-- Triggers `purchases`
--
DELIMITER $$
CREATE TRIGGER `update_total_points_after_purchase` AFTER INSERT ON `purchases` FOR EACH ROW BEGIN
    -- Add logic to update total points in the member table based on the purchase type
    -- Example: 
    -- UPDATE tbl_member m
    -- SET m.totalpointpurchase = m.totalpointpurchase + NEW.total_points
    -- WHERE m.rec_id = NEW.rec_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `redeemlist`
--

CREATE TABLE `redeemlist` (
  `id` int(11) NOT NULL,
  `redeemname` varchar(255) NOT NULL,
  `redeempoint` int(11) NOT NULL,
  `image_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `redeemlist`
--

INSERT INTO `redeemlist` (`id`, `redeemname`, `redeempoint`, `image_filename`) VALUES
(1, 'KTC BUTTON BADGE', 50, 'ktcbadge.jpg'),
(2, 'Redeem Alamak Japan Online Anime Gift (1 Gift)', 60, 'japan.jpg'),
(3, 'Redeem Alamak Japan Online Anime Gift (2 Gift)', 180, NULL),
(4, 'Redeem Alamak Japan Online Anime Gift (3 Gift)', 300, NULL),
(5, 'Redeem Alamak Japan Online Anime Gift Set', 1000, NULL),
(6, 'Exhibition Admission 1 Hour ', 300, '1-06.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `redeempoint`
--

CREATE TABLE `redeempoint` (
  `email` varchar(255) NOT NULL,
  `point` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `redeempoint`
--

INSERT INTO `redeempoint` (`email`, `point`) VALUES
('1@gmail.com', 15),
('asik@gmail.com', 30);

-- --------------------------------------------------------

--
-- Table structure for table `schoolholidayprogrampurchase`
--

CREATE TABLE `schoolholidayprogrampurchase` (
  `id` int(11) NOT NULL,
  `program_type` int(11) DEFAULT NULL,
  `program_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schoolprogrampurchase`
--

CREATE TABLE `schoolprogrampurchase` (
  `id` int(11) NOT NULL,
  `rec_id` varchar(255) NOT NULL,
  `studentname` varchar(255) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `point` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `total_points` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','complete') NOT NULL DEFAULT 'pending',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Triggers `schoolprogrampurchase`
--
DELIMITER $$
CREATE TRIGGER `update_total_points_after_schoolprogrampurchase` AFTER INSERT ON `schoolprogrampurchase` FOR EACH ROW BEGIN
    UPDATE tbl_member m
    SET m.totalpointpurchase = m.totalpointpurchase + NEW.total_points
    WHERE m.rec_id = NEW.rec_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `emailstudent` varchar(250) NOT NULL,
  `parentname` varchar(250) NOT NULL,
  `studentname` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `schoolname` varchar(250) NOT NULL,
  `birthdate` date NOT NULL,
  `rec_id` varchar(200) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `totalpointpurchase` int(11) DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`id`, `username`, `password`, `email`, `emailstudent`, `parentname`, `studentname`, `address`, `schoolname`, `birthdate`, `rec_id`, `telephone`, `totalpointpurchase`, `create_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, '', 'li', 'si@gmail.com', 'li@gmail.com', 'sii', 'li', 's', 'h', '2009-01-01', 'KTC000041', '0173456895', 0, '2024-01-10 19:41:00', NULL, NULL),
(2, '', 'ktc', 'dreamedge@gmail.com', 'ktc@gmail.com', 'dreamedge', 'ktc', 'dream', 'dream', '2019-01-01', 'KTC000045', '0123434567', 0, '2024-01-10 19:41:13', NULL, NULL),
(3, '', '098765432', 'anjyy@gmail.com', 'anjyy@gmail.com', 'Nenekaaa', 'Bududkwow', 'Kepalakaulahsial.com', 'Smkbas', '4444-04-11', 'KTC000046', '0808050808', 185, '2024-01-10 19:08:36', NULL, NULL);

--
-- Triggers `tbl_member`
--
DELIMITER $$
CREATE TRIGGER `getIDS` BEFORE INSERT ON `tbl_member` FOR EACH ROW BEGIN
     INSERT INTO trigger_ VALUES (NULL);
     SET NEW.rec_id = CONCAT("KTC" , 
LPAD(LAST_INSERT_ID(), 6, "0"));
       END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `trigger_`
--

CREATE TABLE `trigger_` (
  `id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `trigger_`
--

INSERT INTO `trigger_` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(38),
(39),
(40),
(41),
(42),
(44),
(45),
(46),
(47),
(48),
(49),
(50),
(51),
(52),
(53),
(54),
(55),
(56),
(57),
(58),
(59),
(60),
(61),
(62),
(63);

-- --------------------------------------------------------

--
-- Table structure for table `updatesteamprogrampage`
--

CREATE TABLE `updatesteamprogrampage` (
  `id` int(11) NOT NULL,
  `programtype` varchar(255) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `point` int(11) NOT NULL,
  `session` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `updatesteamprogrampage`
--

INSERT INTO `updatesteamprogrampage` (`id`, `programtype`, `program_name`, `price`, `point`, `session`) VALUES
(8, 'School Holiday Program', 'School Holiday Program (1day)', '150', 150, '28 Aug 2023'),
(9, 'School Holiday Program', 'School Holiday Program (2days)', '300', 300, '29 Aug 2023'),
(10, 'School Holiday Program', 'School Holiday Program (3day)', '405', 405, '30 Aug 2023');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classpurchase`
--
ALTER TABLE `classpurchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rec_id` (`rec_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `trigger_`
--
ALTER TABLE `trigger_`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `updatesteamprogrampage`
--
ALTER TABLE `updatesteamprogrampage`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classpurchase`
--
ALTER TABLE `classpurchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trigger_`
--
ALTER TABLE `trigger_`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `updatesteamprogrampage`
--
ALTER TABLE `updatesteamprogrampage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
