-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2024 at 05:48 PM
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
-- Database: `project_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `typeId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `description`, `price`, `image_url`, `typeId`) VALUES
(1, 'เค้กช็อคโกแลต', 'ลิ้มลองรสของเค้กช็อคโกแลตที่อร่อย', 150.00, 'https://via.placeholder.com/300', 1),
(2, 'ครัวซอง', 'บรรยากาศครัวซองที่อบอุ่น', 120.00, 'https://via.placeholder.com/300', 1),
(3, 'ชีสเค้ก', 'สัมผัสรสชาติของบราวนี่และเค้ก', 180.00, 'https://via.placeholder.com/300', 1),
(4, 'เค้กช็อคโกแลต', 'ลิ้มลองรสของเค้กช็อคโกแลตที่อร่อย', 120.00, 'https://via.placeholder.com/300', 1),
(5, 'ชีสเค้ก', 'สัมผัสรสชาติของบราวนี่และเค้ก', 150.00, 'https://via.placeholder.com/300', 1),
(6, 'เค้กฟักทอง', 'บรรยากาศครัวซองที่อบอุ่น', 130.00, 'https://via.placeholder.com/300', 1),
(7, 'เค้กสตรอเบอร์รี่', 'ลิ้มลองรสชาติของสตรอเบอร์รี่', 140.00, 'https://via.placeholder.com/300', 1),
(8, 'เค้กมังกร', 'รสชาติสดใสจากผลไม้มังกร', 160.00, 'https://via.placeholder.com/300', 1),
(9, 'เค้กมอลท์ดาร์ก', 'ความหอมหวานของช็อคโกแลตและเนื้อมอลท์ดาร์ก', 180.00, 'https://via.placeholder.com/300', 1),
(10, 'เค้กมะพร้าว', 'ความหอมหวานของมะพร้าว', 130.00, 'https://via.placeholder.com/300', 1),
(11, 'เค้กมะม่วง', 'รสชาติหอมของมะม่วง', 140.00, 'https://via.placeholder.com/300', 1),
(12, 'เค้กแก้วมังกร', 'ความสดใสจากเนื้อส้มแก้วมังกร', 150.00, 'https://via.placeholder.com/300', 1),
(13, 'เค้กไวท์ช็อคโกแลต', 'รสชาติเข้มข้นของไวท์ช็อคโกแลต', 170.00, 'https://via.placeholder.com/300', 1),
(14, 'กาแฟเย็น', 'กาแฟเย็นที่หอมละมุน', 60.00, 'https://via.placeholder.com/300', 2),
(15, 'ชาเขียวไทยเย็น', 'ชาเขียวไทยเย็นที่เข้มข้น', 50.00, 'https://via.placeholder.com/300', 2),
(16, 'มอคค่า', 'รสชาติหอมของมอคค่า', 70.00, 'https://via.placeholder.com/300', 2),
(17, 'ลาเต้', 'ความเข้มข้นที่เป็นเอกลักษณ์', 80.00, 'https://via.placeholder.com/300', 2),
(18, 'น้ำผึ้งมะนาว', 'ความสดชื่นจากน้ำผึ้งและมะนาว', 65.00, './Images/18.jpg', 2),
(19, 'สมูทตี้', 'ความผสมผสานของผลไม้สด', 75.00, 'https://via.placeholder.com/300', 2),
(20, 'ช็อคโกแลตชิพ ฮันนี่', 'ช็อคโกแลตชิพที่อร่อย', 85.00, './Images/20.jpg', 1),
(21, 'สตรอเบอร์รี่สปาร์คลิ่ง', 'รสชาติหอมของสตรอเบอร์รี่', 90.00, 'https://via.placeholder.com/300', 2),
(22, 'โกโก้เย็น', 'โกโก้เย็นที่เข้มข้น', 75.00, './Images/22.jpg', 2),
(23, 'ชานมไข่มุก', 'ชานมหวานมุกเย็น', 55.00, 'https://via.placeholder.com/300', 2),
(25, 'TestEditห', 'testdite', 100.00, './Images/25.jpg', 1),
(34, 'Test', 'test', 0.00, './Images/34.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menutype`
--

CREATE TABLE `menutype` (
  `typeId` int(11) NOT NULL,
  `typeName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menutype`
--

INSERT INTO `menutype` (`typeId`, `typeName`) VALUES
(1, 'Cake'),
(2, 'Drink');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` text DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `username`, `comment`, `menu_id`, `score`) VALUES
(1, 'user1', 'Good cake!', 1, 4),
(2, 'user2', 'Excellent drink!', 2, 5),
(3, 'user3', 'Nice ambiance', 3, 4),
(4, 'user4', 'Delicious cake', 4, 5),
(5, 'user5', 'Average drink', 5, 3),
(6, 'user6', 'Great place!', 6, 5),
(7, 'user7', 'Tasty cake', 7, 4),
(8, 'user8', 'Awesome drink', 8, 5),
(9, 'user9', 'Cozy atmosphere', 9, 4),
(10, 'user10', 'Yummy cake', 10, 5),
(11, 'user11', 'Great cake!', 11, 4),
(12, 'user12', 'Delicious coffee!', 12, 5),
(13, 'user13', 'Nice atmosphere!', 13, 4),
(14, 'user14', 'Tasty dessert!', 14, 5),
(15, 'user15', 'Loved it!', 15, 4),
(16, 'user16', 'Excellent service!', 16, 5),
(17, 'user17', 'Yummy treats!', 17, 4),
(18, 'user18', 'Wonderful experience!', 18, 5),
(19, 'user19', 'Perfect place!', 19, 4),
(20, 'user20', 'Fantastic menu!', 20, 5),
(21, 'user21', 'Superb desserts!', 21, 4),
(22, 'user22', 'Outstanding coffee!', 22, 5),
(23, 'user23', 'Amazing ambiance!', 23, 4),
(24, 'kajon', 'Comment1', 1, 5),
(25, 'bonya', 'Comment2', 2, 4),
(26, 'boja', 'Comment3', 3, 3),
(27, 'jaidai', 'Comment4', 4, 2),
(28, 'jada', 'Comment5', 5, 1),
(29, 'jene', 'Comment6', 1, 4),
(30, 'suchao', 'Comment7', 2, 3),
(31, 'boomee', 'Comment8', 3, 2),
(32, 'new', 'Comment9', 4, 1),
(33, 'bank', 'Comment10', 5, 5),
(34, 'ทดสอบ', 'ทดสอบ', 6, 4),
(35, 'ทดสอบ', 'ทดสอบ', 14, 4),
(36, 'ทดสอบ', 'ทดสอบ', 8, 4),
(37, 'admin', 'asd', 10, 3),
(39, 'admin', 'Test comment', 12, 4),
(40, 'Kajonsak', 'เป็นเค้กที่อร่อยสุดๆ', 6, 5),
(41, 'name', 'ดีย์', 16, 5),
(42, 'Test', 'comment', 16, 4),
(43, 'tes', 'test', 18, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `sale_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `sale_date`) VALUES
(1, '2022-01-01'),
(2, '2022-01-02'),
(3, '2022-01-03'),
(4, '2022-01-04'),
(5, '2022-01-05'),
(6, '2022-01-06'),
(7, '2022-01-07'),
(8, '2022-01-08'),
(9, '2022-01-09'),
(10, '2022-01-10'),
(11, '2024-01-23'),
(12, '2024-01-23'),
(13, '2024-01-23'),
(14, '2024-01-23'),
(15, '2024-01-23'),
(16, '2024-01-23'),
(17, '2024-01-23'),
(18, '2024-01-23'),
(19, '2024-01-23'),
(20, '2024-01-30'),
(21, '2024-01-30'),
(22, '2024-01-30'),
(23, '2024-01-30'),
(24, '2024-01-30'),
(25, '2024-01-30'),
(26, '2024-01-31'),
(27, '2024-01-31'),
(28, '2024-01-31'),
(29, '2024-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `detail_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`detail_id`, `sale_id`, `menu_id`, `quantity`, `total_price`) VALUES
(1, 1, 1, 2, 100.00),
(2, 1, 3, 1, 50.00),
(3, 2, 2, 3, 150.00),
(4, 2, 4, 1, 75.00),
(5, 3, 1, 1, 50.00),
(6, 3, 2, 2, 100.00),
(7, 4, 3, 2, 100.00),
(8, 4, 4, 1, 50.00),
(9, 5, 1, 3, 150.00),
(10, 5, 2, 1, 50.00),
(11, 12, 22, 1, 75.00),
(12, 12, 16, 2, 140.00),
(13, 12, 18, 1, 65.00),
(14, 12, 8, 3, 480.00),
(15, 12, 14, 1, 60.00),
(16, 14, 8, 1, 160.00),
(17, 14, 19, 1, 75.00),
(18, 17, 6, 1, 130.00),
(19, 18, 6, 1, 130.00),
(20, 19, 6, 4, 520.00),
(21, 24, 8, 1, 160.00),
(22, 25, 8, 3, 480.00),
(23, 26, 18, 3, 195.00),
(24, 27, 18, 2, 130.00),
(25, 28, 20, 2, 170.00),
(26, 29, 20, 1, 85.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `fk_menuType` (`typeId`);

--
-- Indexes for table `menutype`
--
ALTER TABLE `menutype`
  ADD PRIMARY KEY (`typeId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `sale_id` (`sale_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `menutype`
--
ALTER TABLE `menutype`
  MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menuType` FOREIGN KEY (`TypeId`) REFERENCES `menutype` (`typeId`);

--
-- Constraints for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD CONSTRAINT `sales_details_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
