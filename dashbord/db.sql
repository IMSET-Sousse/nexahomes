USE test_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure for table `admins`

CREATE TABLE `admins` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `isAdmin` BOOLEAN NOT NULL DEFAULT 0,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into the new admins table
INSERT INTO `admins` (`firstName`, `lastName`, `emailAddress`, `pass`, `isAdmin`, `created_at`, `updated_at`) VALUES
('Super', 'Admin', 'admin@gmail.com', 'admin', 0, '2023-11-27 16:24:15.122141', '0000-00-00');
-- Table structure for table `categories`
CREATE TABLE `categories` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `categoryName` varchar(255) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `categories`
INSERT INTO `categories` (`categoryName`, `created_at`, `updated_at`) VALUES
('category-1', '2023-11-28 15:50:56.490888', '0000-00-00'),
('category-2', '2023-11-28 15:51:06.383103', '0000-00-00'),
('category-3', '2023-11-28 15:51:13.546000', '0000-00-00'),
('category-4', '2023-11-28 15:51:20.879156', '0000-00-00'),
('category-5', '2023-11-28 15:51:27.085593', '0000-00-00');

-- Table structure for table `product`
CREATE TABLE `product` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `categoryId` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `product`
INSERT INTO `product` (`categoryId`, `title`, `description`, `thumbnail`, `created_at`, `updated_at`) VALUES
('39', 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry', 'backgroundDefault.jpg', '2023-11-28 15:53:46.580379', '0000-00-00');

-- Table structure for table `contact`
CREATE TABLE `contact` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `message` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `contact`
INSERT INTO `contact` (`message`, `email`, `phoneNumber`, `created_at`, `updated_at`) VALUES
('Sample message', 'sample@email.com', '1234567890', '2023-11-28 16:00:00', '0000-00-00');


-- Create a new comments table
CREATE TABLE `comments` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `comment` text NOT NULL,
  `product_id` int(10) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` date NOT NULL,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create a new ratings table
CREATE TABLE `ratings` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `rating` int(1) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` date NOT NULL,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `product`
ADD COLUMN `price` DECIMAL(10, 2) NOT NULL DEFAULT 0;
