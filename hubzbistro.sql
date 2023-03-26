-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2023 at 05:43 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hubzbistro`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `dish-category`
--

CREATE TABLE `dish-category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dish-category`
--

INSERT INTO `dish-category` (`id`, `categoryName`) VALUES
(1, 'main-course'),
(2, 'appetizer'),
(3, 'dessert'),
(4, 'salad'),
(5, 'soup'),
(6, 'seafood'),
(7, 'pasta'),
(8, 'soup');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `category`, `price`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Lasagna Pastas', 3, 350, 'Your favorite lasagna ingredients, including pasta, sausage, cheese, and marinara NY sauce, are all included in this pasta dish. Lorem Ipsum. Lorem Ipsum Ipsum Omcm.', 'assets/imgs/thump_1670738480.jpg', '2022-12-03 12:54:17', '2022-12-11 14:01:20'),
(2, 'Ceasar Salad ', 4, 240, 'Crisp romaine lettuce, crunchy croutons, and as much or as little anchovy as you like make up this New York favorite salad.', 'assets/imgs/caesar-salad.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(3, 'Porterhouse/ T-Bone ', 1, 850, 'It offers a delectable combination of rich, delicious New York strip and soft, succulent filet mignon.', 'assets/imgs/porterhouse.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(4, 'Baby Back Ribs', 1, 350, 'The loin muscle meets the backbone high on the hog\'s back, where the baby back ribs, also known as pork back ribs, originate.', 'assets/imgs/baby-backribs.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(5, 'Beef Salpicao', 1, 360, 'Beef Salpicao Tender rib-eye steak chunks that have been perfectly cooked, seasoned with a delectable seasoning sauce, and then covered in butter.', 'assets/imgs/beef-salpicao.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(6, 'Breakfast Burrito ', 1, 230, 'Breakfast burrito filled with crispy potatoes, softly scrambled eggs, creamy avocado, and melty cheddar cheese.', 'assets/imgs/breakfast-burrito.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(7, 'Strawberry Cheesecake ', 3, 180, 'The greatest strawberry topping, created from fresh strawberries and lemon juice, is placed on top of a light and creamy base in this baked strawberry cheesecake.', 'assets/imgs/strawberry-cheesecake.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(8, 'Cream Brulee ', 3, 230, 'French delicacy called creme brûlée is made of a base of rich, creamy custard and a coating of firm caramel on top.', 'assets/imgs/cream-brulee.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(9, 'Grilled Tuna Belly ', 6, 380, 'NY Style Perfectly cooked over hot coals after being marinated in a sweet and savory sauce.', 'assets/imgs/grilled-tuna.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(10, 'Grilled Salmon ', 6, 330, 'NY Salmon that have been expertly grilled are attractively seared but remain juicy and soft in the middle.', 'assets/imgs/grilled-salmon.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(11, 'Prawns Thermidor ', 6, 390, 'In NY A popular meal called \'Prawns Thermidor\' features soft prawn pieces cooked with carrot, celery, button mushrooms, and a creamy mustard sauce.', 'assets/imgs/prawn-thermidor.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(12, 'Pumpkin Soup ', 2, 160, 'it is made with a foundation of savory vegetable broth and sweet cream (Tomato Soup)  and is loaded with a variety of tomatoes, garlic, and NY-originated spices. (Garlic bread)', 'assets/imgs/pumpkin-soup.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(13, 'Baked Mussels ', 2, 270, 'a Tasty New York recipe for baked mussels with oozing cheese and garlic-bechamel sauce', 'assets/imgs/baked-mussel.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(14, 'Nachos Supreme ', 2, 260, 'A typical appetizer of tortilla chips with melted cheese and sliced chile peppers is called \"Bringing Mexico to NY into the Philippines.\"', 'assets/imgs/nachos-supreme.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(15, 'Lasagna Pasta', 3, 233, 'Yes. Very yummy', 'assets/imgs/thump_1678078888.jpeg', '2023-03-06 13:01:28', '2023-03-06 13:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `reservationId` int(11) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `receipt` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `reservationId`, `account_number`, `amount`, `bank`, `branch`, `date`, `receipt`, `created_at`, `updated_at`) VALUES
(16, 33, '09124124124', '270', 'Select Bank:', '2023-03-27', '0000-00-00', 'yes', '2023-03-26', '2023-03-26'),
(17, 33, '09124124124', '270', 'Select Bank:', '2023-03-27', '0000-00-00', 'yes', '2023-03-26', '2023-03-26'),
(18, 33, '09124124124', '270', 'Select Bank:', '2023-03-27', '0000-00-00', 'yes', '2023-03-26', '2023-03-26'),
(19, 38, '09124124124', '270', 'Banco De Oro (BDO)', '2023-03-27', '0000-00-00', 'yes', '2023-03-26', '2023-03-26'),
(20, 38, '09124124124', '270', 'Banco De Oro (BDO)', '2023-03-27', '0000-00-00', 'yes', '2023-03-26', '2023-03-26'),
(21, 38, '09124124124', '270', 'Select Bank:', '2023-03-27', '0000-00-00', 'yes', '2023-03-26', '2023-03-26'),
(22, 38, '09124124124', '270', 'Select Bank:', '2023-03-27', '0000-00-00', 'yes', '2023-03-26', '2023-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `pre_ordered`
--

CREATE TABLE `pre_ordered` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `dishId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pre_ordered`
--

INSERT INTO `pre_ordered` (`id`, `userId`, `dishId`, `quantity`, `isActive`, `created_at`, `updated_at`) VALUES
(14, 2, 13, 2, 1, '2023-03-21 20:39:04', '2023-03-21 20:39:04'),
(15, 2, 14, 1, 0, '2023-03-22 09:38:54', '2023-03-22 09:38:54'),
(17, 2, 11, 1, 0, '2023-03-22 14:31:17', '2023-03-22 14:31:17'),
(19, 2, 1, 3, 0, '2023-03-25 12:11:38', '2023-03-25 12:11:38'),
(20, 2, 4, 2, 0, '2023-03-26 04:34:04', '2023-03-26 04:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `user` int(11) NOT NULL,
  `tableId` int(11) NOT NULL,
  `status` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `date`, `startTime`, `endTime`, `user`, `tableId`, `status`, `created_at`, `updated_at`) VALUES
(29, '2023-03-21', '2023-03-21 09:00:00', '2023-03-21 11:00:00', 2, 1, '3', '2023-03-20 11:48:55', '2023-03-23 12:01:25'),
(30, '2023-03-21', '2023-03-21 09:00:00', '2023-03-21 11:00:00', 3, 2, '0', '2023-03-20 14:08:09', '2023-03-20 14:08:09'),
(31, '2023-03-22', '2023-03-22 09:00:00', '2023-03-22 11:00:00', 2, 1, '3', '2023-03-21 20:25:10', '2023-03-23 12:01:25'),
(32, '2023-03-24', '2023-03-24 09:00:00', '2023-03-24 11:00:00', 2, 1, '3', '2023-03-23 19:01:35', '2023-03-25 21:22:44'),
(33, '2023-03-27', '2023-03-27 09:00:00', '2023-03-27 11:00:00', 2, 11, '4', '2023-03-26 04:25:25', '2023-03-26 05:05:32'),
(34, '2023-03-27', '2023-03-27 09:00:00', '2023-03-27 11:00:00', 2, 4, '0', '2023-03-26 04:27:01', '2023-03-26 04:27:01'),
(35, '2023-03-27', '2023-03-27 09:00:00', '2023-03-27 11:00:00', 2, 9, '0', '2023-03-26 04:28:49', '2023-03-26 04:28:49'),
(36, '2023-03-27', '2023-03-27 09:00:00', '2023-03-27 11:00:00', 2, 5, '0', '2023-03-26 04:28:57', '2023-03-26 04:28:57'),
(37, '2023-03-27', '2023-03-27 09:00:00', '2023-03-27 11:00:00', 2, 7, '0', '2023-03-26 04:29:09', '2023-03-26 04:29:09'),
(38, '2023-03-27', '2023-03-27 09:00:00', '2023-03-27 11:00:00', 2, 10, '4', '2023-03-26 04:32:01', '2023-03-26 05:39:34'),
(39, '2023-03-27', '2023-03-27 09:00:00', '2023-03-27 11:00:00', 2, 8, '3', '2023-03-26 04:33:00', '2023-03-26 06:09:13'),
(40, '2023-03-27', '2023-03-27 11:00:00', '2023-03-27 13:00:00', 2, 11, '3', '2023-03-26 06:08:10', '2023-03-26 06:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `tbl_type` varchar(255) DEFAULT NULL,
  `seats` int(11) NOT NULL,
  `pax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `tbl_type`, `seats`, `pax`) VALUES
(1, 'sm', 4, 4),
(2, 'sm', 4, 4),
(3, 'sm', 4, 4),
(4, 'sm', 4, 4),
(5, 'sm', 4, 4),
(6, 'sm', 4, 4),
(7, 'sm', 4, 4),
(8, 'sm', 4, 4),
(9, 'sm', 4, 4),
(10, 'sm', 4, 4),
(11, 'lg', 28, 28);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `number` varchar(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `number`, `created_at`, `updated_at`) VALUES
(2, 'JOhn Micko', 'Rapanot', 'johnmickooo28@gmail.com', '$2y$10$2WtHGkxs5FaL1pcLCly6D.Wr7zIcodjhlz5E3euYVN7ZLzHmhBs7W', '09194282431', '2023-03-20 11:48:38', '2023-03-20 11:48:38'),
(3, 'JOhn Micko', 'Rapanot', 'pewdiepewdzpewds@gmail.comgas', '$2y$10$a.u.p7TngnNHGMEn7ww0qu/yRlB7c6UprfKeWMdHi/lqrFpOC0nIq', '09194282431', '2023-03-20 14:07:46', '2023-03-20 14:07:46'),
(4, 'JOhn Micko', 'Rapanot', 'pewdiepewdzpewds@gmail.comz', '$2y$10$/LD3tkthPIvJvVloEWBbIOcdRqyYJP0GyJRhly1QgV4.rpqbjaEEW', '09194282431', '2023-03-21 20:18:24', '2023-03-21 20:18:24'),
(5, 'JOhn Micko', 'Rapanot', 'johnmickooo28@gmail.comzzz', '$2y$10$IBRG1jsmrthCOf/i7N/bvuM86cF8jFrvSLUV0NUqfXHY2BcZd6XFe', '09194282431', '2023-03-21 20:19:31', '2023-03-21 20:19:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dish-category`
--
ALTER TABLE `dish-category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservationId` (`reservationId`);

--
-- Indexes for table `pre_ordered`
--
ALTER TABLE `pre_ordered`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dishId` (`dishId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tableId` (`tableId`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dish-category`
--
ALTER TABLE `dish-category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pre_ordered`
--
ALTER TABLE `pre_ordered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`category`) REFERENCES `dish-category` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`reservationId`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `pre_ordered`
--
ALTER TABLE `pre_ordered`
  ADD CONSTRAINT `pre_ordered_ibfk_1` FOREIGN KEY (`dishId`) REFERENCES `dishes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pre_ordered_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`tableId`) REFERENCES `tables` (`id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
