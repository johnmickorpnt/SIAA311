-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2023 at 11:10 AM
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
(3, 'PORTERHOUSE/ T-BONE ', 1, 850, 'It offers a delectable combination of rich, delicious New York strip and soft, succulent filet mignon.', 'assets/imgs/porterhouse.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(4, 'Baby Back Ribs', 1, 350, 'The loin muscle meets the backbone high on the hog\'s back, where the baby back ribs, also known as pork back ribs, originate.', 'assets/imgs/baby-backribs.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(5, 'BEEF SALPICAO', 1, 360, 'Beef Salpicao Tender rib-eye steak chunks that have been perfectly cooked, seasoned with a delectable seasoning sauce, and then covered in butter.', 'assets/imgs/beef-salpicao.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(6, 'BREAKFAST BURRITO ', 1, 230, 'Breakfast burrito filled with crispy potatoes, softly scrambled eggs, creamy avocado, and melty cheddar cheese.', 'assets/imgs/breakfast-burrito.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(7, 'STRAWBERRY CHEESECAKE ', 3, 180, 'The greatest strawberry topping, created from fresh strawberries and lemon juice, is placed on top of a light and creamy base in this baked strawberry cheesecake.', 'assets/imgs/strawberry-cheesecake.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(8, 'CREAM BRULEE ', 3, 230, 'French delicacy called creme brûlée is made of a base of rich, creamy custard and a coating of firm caramel on top.', 'assets/imgs/cream-brulee.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(9, 'GRILLED TUNA BELLY ', 6, 380, 'NY Style Perfectly cooked over hot coals after being marinated in a sweet and savory sauce.', 'assets/imgs/grilled-tuna.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(10, 'GRILLED SALMON ', 6, 330, 'NY Salmon that have been expertly grilled are attractively seared but remain juicy and soft in the middle.', 'assets/imgs/grilled-salmon.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(11, 'PRAWNS THERMIDOR ', 6, 390, 'In NY A popular meal called \'Prawns Thermidor\' features soft prawn pieces cooked with carrot, celery, button mushrooms, and a creamy mustard sauce.', 'assets/imgs/prawn-thermidor.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(12, 'Pumpkin Soup ', 2, 160, 'it is made with a foundation of savory vegetable broth and sweet cream (Tomato Soup)  and is loaded with a variety of tomatoes, garlic, and NY-originated spices. (Garlic bread)', 'assets/imgs/pumpkin-soup.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(13, 'BAKED MUSSELS ', 2, 270, 'a Tasty New York recipe for baked mussels with oozing cheese and garlic-bechamel sauce', 'assets/imgs/baked-mussel.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(14, 'NACHOS SUPREME ', 2, 260, 'A typical appetizer of tortilla chips with melted cheese and sliced chile peppers is called \"Bringing Mexico to NY into the Philippines.\"', 'assets/imgs/nachos-supreme.jpg', '2022-12-03 12:54:17', '2022-12-03 12:54:17'),
(15, 'Lasagna Pasta', 3, 233, 'Yes. Very yummy', 'assets/imgs/thump_1678078888.jpeg', '2023-03-06 13:01:28', '2023-03-06 13:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `account_number` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `amount` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `bank` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `receipt` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ordered`
--

CREATE TABLE `pre_ordered` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `dishId` int(11) NOT NULL,
  `reservationId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(24, '2023-03-07', '2023-03-07 09:00:00', '2023-03-07 11:00:00', 1, 1, '0', '2023-03-06 13:20:01', '2023-03-06 13:20:01'),
(25, '2023-03-07', '2023-03-07 09:00:00', '2023-03-07 11:00:00', 1, 2, '0', '2023-03-06 13:20:11', '2023-03-06 13:20:11'),
(26, '2023-03-07', '2023-03-07 09:00:00', '2023-03-07 11:00:00', 1, 3, '0', '2023-03-06 13:21:27', '2023-03-06 13:21:27'),
(27, '2023-03-07', '2023-03-07 09:00:00', '2023-03-07 11:00:00', 1, 4, '0', '2023-03-06 13:21:45', '2023-03-06 13:21:45'),
(28, '2023-03-07', '2023-03-07 09:00:00', '2023-03-07 11:00:00', 1, 5, '0', '2023-03-06 14:04:38', '2023-03-06 14:04:38');

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
(1, 'JOhn Micko', 'Rapanot', 'johnmickooo28@gmail.com', '$2y$10$Q1.TkZqz9aXw1sY7uqLEDuIkByNVb1tqbd0pidALsgu2N.13PW02e', '09194282431', '2023-03-03 15:54:20', '2023-03-03 15:54:20');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_ordered`
--
ALTER TABLE `pre_ordered`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dishId` (`dishId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `reservationId` (`reservationId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_ordered`
--
ALTER TABLE `pre_ordered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`category`) REFERENCES `dish-category` (`id`);

--
-- Constraints for table `pre_ordered`
--
ALTER TABLE `pre_ordered`
  ADD CONSTRAINT `pre_ordered_ibfk_1` FOREIGN KEY (`dishId`) REFERENCES `dishes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pre_ordered_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pre_ordered_ibfk_3` FOREIGN KEY (`reservationId`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

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
