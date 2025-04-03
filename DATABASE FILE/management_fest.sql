-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 05:47 PM
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
-- Database: `management_fest`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_username`, `admin_password`, `created_at`) VALUES
(5, 'admin', '0192023a7bbd73250516f069df18b500', '2025-01-08 15:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `coordinators`
--

CREATE TABLE `coordinators` (
  `cd_id` int(11) NOT NULL,
  `cd_username` varchar(255) NOT NULL,
  `cd_password` varchar(255) NOT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinators`
--

INSERT INTO `coordinators` (`cd_id`, `cd_username`, `cd_password`, `event_id`) VALUES
(37, 'srusti_walzade', 'srusti', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `location`, `event_date`, `event_time`, `image_link`, `description`) VALUES
(2, 'Show Your Talent', 'Seminar Hall , Department of BBA(CA) and BCA', '2025-01-05', '01:00:00', 'https://t3.ftcdn.net/jpg/03/72/07/92/360_F_372079224_I5T312gZKM2elhtwjLPqBLg0xSs2lAgu.jpg', 'It\'s time to showcase your unique talents and shine on stage at the \'Show Your Talent\' competition!\"'),
(3, 'Ad Mad Show ', 'Department of BBA(CA) and BCA', '2025-01-07', '12:00:00', 'https://tse2.mm.bing.net/th?id=OIP.Mtgh67QidwPdl2RiSteqhAAAAA&pid=Api&P=0&h=180', 'Description'),
(4, 'Rangoli Competion', 'At.Department', '2025-01-07', '12:04:00', 'https://img.freepik.com/premium-photo/rangoli-icon-indian-art-festival-decoration-art-logo-illustration_762678-17304.jpg', 'Themes - Recent trend in IT and Management, Role of Social Ethics in Business, AI, Cloud Computing, NEP-2020, Climate change and Global Policy, Human rights in Digital spaces, Life with Social Media'),
(5, 'PPT Competion', 'At.Department', '2025-01-07', '12:12:00', 'https://s3service.hitbullseye.com/s3fs-public/PPT-Presentation-signature.jpg?null', 'Themes - Recent trend in IT and Management, Role of Social Ethics in Business, AI, Cloud Computing, NEP-2020, Climate change and Global Policy, Human rights in Digital spaces, Life with Social Media)'),
(6, 'Innovative Business Ideas Presentation competition (Business Plan)', 'At.Department', '2025-01-07', '12:12:00', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5oxFBZuuztEvG0h7WThj4a8td42vcXuHVHMJJPYae5BQZhjjY3lqyjZMENSNP_gWy7ts&usqp=CAU', 'A coming up with a unique idea that introduces a new way of thinking to the market'),
(7, 'Blind code ', 'At.Computer Lab', '2025-01-08', '12:12:00', 'https://tt19.ritgoa.ac.in/img/portfolio/blind%20coding.png', 'A Path to Success As A Blind Programing'),
(8, 'Poster Making & Presentation', 'At.Department', '2025-01-08', '12:12:00', 'https://static.mygov.in/media/blog/2023/07/1.jpg', 'Themes - Recent trend in IT or Management, AI, Water Management, Importance of Renewable Resources, NEP-2020, Life with Social Media, Plastic Ban, Today\'s youth'),
(9, 'Hire or Fire', 'At.Department', '2025-01-08', '12:12:00', 'https://tse3.mm.bing.net/th?id=OIP.CcjxIeP6hzcuKW-rKBaluAHaEK&pid=Api&P=0&h=180', 'It\'s the smart thing to do and it is a sign of high personal humility'),
(10, 'Best from West', 'At.Department', '2025-01-08', '12:12:00', 'https://media.istockphoto.com/id/1384532150/vector/recycle-symbol-inside-circle-with-leaves-zero-waste-concept.jpg?s=612x612&w=0&k=20&c=lQPT8cj_dpkQBxa1G4Y6RzDz5vLog6OmWERx-vGpF_Y=', 'Crafting is not just about making things, it’s about making memories'),
(11, 'Logo design', 'At.Department', '2025-01-08', '12:12:00', 'https://tse1.mm.bing.net/th?id=OIP.MjUYM-mSokYIEHpqPBq3qgHaEK&pid=Api&P=0&h=180', 'Sketching is almost everything...'),
(12, 'Bollywood Day', 'At.Department', '2025-01-08', '12:12:00', 'https://in.images.search.yahoo.com/images/view;_ylt=Awrx_maxkHVnPpsghf29HAx.;_ylu=c2VjA3NyBHNsawNpbWcEb2lkAzMyMWJjNDE2MDVlMzM2ZjM5MmU1NDgxMWZlYTQ5NzliBGdwb3MDMTEzBGl0A2Jpbmc-?back=https%3A%2F%2Fin.images.search.yahoo.com%2Fsearch%2Fimages%3Fp%3Dbollywood%', 'हसो, जियो, मुस्कुराओ, क्या पता कल हो ना हो!');

-- --------------------------------------------------------

--
-- Table structure for table `event_coordinators`
--

CREATE TABLE `event_coordinators` (
  `id` int(11) NOT NULL,
  `coordinator_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_coordinators`
--

INSERT INTO `event_coordinators` (`id`, `coordinator_id`, `event_id`) VALUES
(35, 37, 2),
(36, 37, 3);

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `registration_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `registration_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`registration_id`, `student_id`, `event_id`, `registration_timestamp`) VALUES
(26, 12, 2, '2025-01-08 16:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `department` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `prn_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `phone`, `department`, `year`, `prn_number`, `password`, `created_at`) VALUES
(12, 'yash katore', 'ybkatore31@gmail.com', '9130843198', 'BBA(CA)', 'TYBBA(CA)', '25101', '$2y$10$Q55X.d1ids4dTDtq5WfD0.ISns7fM.wvUjlFmAmGZWKY3ldZA3bIy', '2025-01-08 16:04:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD PRIMARY KEY (`cd_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_coordinators`
--
ALTER TABLE `event_coordinators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coordinator_id` (`coordinator_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `prn_number` (`prn_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coordinators`
--
ALTER TABLE `coordinators`
  MODIFY `cd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_coordinators`
--
ALTER TABLE `event_coordinators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD CONSTRAINT `coordinators_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `event_coordinators`
--
ALTER TABLE `event_coordinators`
  ADD CONSTRAINT `event_coordinators_ibfk_1` FOREIGN KEY (`coordinator_id`) REFERENCES `coordinators` (`cd_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_coordinators_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
