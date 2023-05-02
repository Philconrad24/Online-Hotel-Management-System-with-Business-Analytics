-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2023 at 09:05 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@reserve.com', 'Pass123_');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `suite` int(11) NOT NULL,
  `roomSelected` int(11) DEFAULT NULL,
  `totalPrice` int(11) NOT NULL,
  `isApproved` tinyint(1) NOT NULL DEFAULT 0,
  `paymentStatus` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `created_by`, `checkin`, `checkout`, `adults`, `children`, `created_on`, `suite`, `roomSelected`, `totalPrice`, `isApproved`, `paymentStatus`) VALUES
(71, 31, '2023-04-01', '2023-04-04', 1, 0, '2023-04-01', 6, 65, 60000, 1, 0),
(82, 103, '2023-04-07', '2023-04-14', 3, 0, '2023-04-06', 6, 59, 140000, 1, 1);

--
-- Triggers `applications`
--
DELIMITER $$
CREATE TRIGGER `tr_create_booking` AFTER UPDATE ON `applications` FOR EACH ROW BEGIN
  IF OLD.paymentStatus = 0 AND NEW.paymentStatus = 1 THEN
    INSERT INTO bookings (application_id, room_id, price)
    SELECT NEW.id, NEW.roomSelected, NEW.totalPrice
    FROM rooms
    WHERE rooms.roomid = NEW.roomSelected;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_set_room_reserved` AFTER INSERT ON `applications` FOR EACH ROW BEGIN
  UPDATE rooms
  SET isReserved = 1
  WHERE roomid = NEW.roomSelected;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_bookings_is_settled` AFTER UPDATE ON `applications` FOR EACH ROW BEGIN
  IF NEW.paymentStatus = true THEN
    UPDATE bookings SET is_settled = true WHERE application_id = NEW.id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `price` int(1) NOT NULL,
  `is_settled` tinyint(1) NOT NULL DEFAULT 0,
  `reference_number` varchar(55) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `application_id`, `room_id`, `price`, `is_settled`, `reference_number`, `is_verified`) VALUES
(45, 82, 59, 140000, 0, 'Z1O254N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `description` varchar(55) NOT NULL,
  `label` char(5) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `description`, `label`, `capacity`, `price`) VALUES
(5, 'Luxury Suite', 'LS', 12, 25000),
(6, 'Family Suite', 'FS', 18, 20000),
(7, 'Premium Suite', 'PS', 8, 29000);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `request_id` int(11) NOT NULL,
  `request_email` varchar(55) NOT NULL,
  `request_reference` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`request_id`, `request_email`, `request_reference`) VALUES
(16, 'jodero380@gmail.com', 'BMIIKZA'),
(17, 'jodero380@gmail.com', 'MAL7817'),
(18, 'jodero380@gmail.com', 'Q1M7K56');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomid` int(11) NOT NULL,
  `name` varchar(55) DEFAULT NULL,
  `number` varchar(55) NOT NULL,
  `category` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `isReserved` tinyint(1) NOT NULL DEFAULT 0,
  `isBooked` tinyint(1) NOT NULL DEFAULT 0,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomid`, `name`, `number`, `category`, `capacity`, `image`, `isReserved`, `isBooked`, `created_on`) VALUES
(18, 'Boasty shark', '11', 5, 1, '/img/6401fbe49f4951.00713921.jpg', 1, 0, '2023-03-03'),
(19, 'Green Leaf', '12', 5, 5, '/img/6401fbfd2b4961.73389606.jpg', 0, 0, '2023-03-03'),
(20, 'Eighty sites', '13', 7, 4, '/img/6401fc18636269.77488336.jpg', 1, 0, '2023-03-03'),
(21, 'Reef village', '14', 5, 7, '/img/6401fe19e3ea46.16076036.jpg', 1, 0, '2023-03-03'),
(22, 'Tropical villa', '15', 6, 9, '/img/6401fe30363ba6.49775317.jpg', 1, 0, '2023-03-03'),
(23, 'Light view', '17', 7, 3, '/img/6401fe45d4c405.47542184.jpg', 1, 0, '2023-03-03'),
(58, 'Sunset Villa', '101', 5, 10, '/img/6401fbe49f4951.00713921.jpg', 1, 0, '2023-04-01'),
(59, 'Beachfront Retreat', '102', 6, 8, '/img/6401fbfd2b4961.73389606.jpg', 1, 0, '2023-04-01'),
(60, 'Mountain View Lodge', '103', 7, 14, '/img/6401fc18636269.77488336.jpg', 0, 0, '2023-04-01'),
(61, 'Coastal Cottage', '104', 5, 12, '/img/6401fe19e3ea46.16076036.jpg', 1, 0, '2023-04-01'),
(62, 'Riverside Manor', '105', 6, 10, '/img/6401fe30363ba6.49775317.jpg', 0, 0, '2023-04-01'),
(63, 'Island Paradise', '106', 7, 16, '/img/6401fbe49f4951.00713921.jpg', 1, 0, '2023-04-01'),
(64, 'Skyline Penthouse', '107', 5, 8, '/img/6401fbfd2b4961.73389606.jpg', 1, 0, '2023-04-01'),
(65, 'Garden View Suite', '108', 6, 6, '/img/6401fc18636269.77488336.jpg', 1, 0, '2023-04-01'),
(66, 'Seaside Bungalow', '109', 7, 14, '/img/6401fe19e3ea46.16076036.jpg', 0, 0, '2023-04-01'),
(67, 'Urban Loft', '110', 5, 6, '/img/6401fe30363ba6.49775317.jpg', 0, 0, '2023-04-01'),
(68, 'Royal Suite', '101', 6, 6, '/img/6401fbe49f4951.00713921.jpg', 1, 0, '2023-04-01'),
(69, 'Garden Suite', '102', 7, 5, '/img/6401fbfd2b4961.73389606.jpg', 0, 0, '2023-04-01'),
(70, 'Poolside Villa', '201', 5, 4, '/img/6401fc18636269.77488336.jpg', 0, 0, '2023-04-01'),
(71, 'Luxury Suite', '202', 6, 6, '/img/6401fe19e3ea46.16076036.jpg', 0, 0, '2023-04-01'),
(72, 'Seaside Villa', '301', 5, 3, '/img/6401fe30363ba6.49775317.jpg', 0, 0, '2023-04-01'),
(73, 'Grand Suite', '302', 6, 6, '/img/6401fbe49f4951.00713921.jpg', 0, 0, '2023-04-01'),
(74, 'Penthouse Suite', '401', 7, 4, '/img/6401fbfd2b4961.73389606.jpg', 0, 0, '2023-04-01'),
(75, 'Beachfront Villa', '402', 5, 5, '/img/6401fc18636269.77488336.jpg', 0, 0, '2023-04-01'),
(76, 'Executive Suite', '501', 6, 5, '/img/6401fe19e3ea46.16076036.jpg', 0, 0, '2023-04-01'),
(77, 'Mountain View Villa', '502', 7, 5, '/img/6401fe30363ba6.49775317.jpg', 0, 0, '2023-04-01'),
(78, 'Upview', '198', 6, 9, '/img/642eed1e434917.56692231.jpg', 0, 0, '2023-04-06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `idNumber` varchar(55) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `idNumber`, `email`, `mobile`, `password`, `is_verified`) VALUES
(31, 'Sasha', 'Brown', '2345', 'sashabrown@yahoo.com', '0729170909', '$2y$10$aMNto43v0VzzhYESPBXKMuzlinQkPIDCTb0wEVse59JPvhRLnsioa', 1),
(32, 'John ', 'Doe', '87899878', 'joedan@gmail.com', '0788909878', '$2y$10$/e2aP2psM58ngunhF7W9MOMIOJetKjdGvhq895lK1DVrnUHvMMBFu', 1),
(33, 'John', 'Doe', '234567', 'email@test.com', '0789898767', '$2y$10$zO0ZvKzlZDouunSMWBdXc.ZH8lgK6cH4w6WGzsr0Fj2yojVicNlG2', 1),
(34, 'Hem', 'Swath', '12342536', 'email1@test.com', '0789878767', '$2y$10$z2NhQY73vHozyy49TClZ5eyu5cVywyABz8Ohtkxw7Ki/zZx8n0CFK', 1),
(35, 'Luigi', 'Rio', '243537', 'email2@test.com', '0789876578', '$2y$10$3/BSUOf8J15F2IkccuyosuHsYPTxspFNVzX8QW9KLQfui5NaUMwkO', 1),
(36, 'James', 'Kant', '567819', 'jameskant@yahoo.com', '0712345678', '$2y$10$yx8w8Vj8usuIdPU4zT/DKucuhg6.WLGQzJW72cKFt.Bg1OcfArQp2', 1),
(37, 'John', 'Smith', '983751', 'johnsmith@gmail.com', '0723456789', '$2y$10$bwzTFdfacmdFpIx1WEvweOKtY.3mwNI14HlruUndacGfNqUybXd5K', 1),
(38, 'Sarah', 'Brown', '246810', 'sarahbrown@yahoo.com', '0733456789', '$2y$10$n7f4Uhim3S9mnWWFN4eB2eGL.D2zj066q4DE6SYV6NlEZTNMdq5wa', 1),
(39, 'Peter', 'Jones', '123456', 'peterjones@hotmail.com', '0712345671', '$2y$10$2fw1hgHRBCwdNE0qUxD85urBvhE/uIXg1ypfYB82z170CmxYEK/tC', 1),
(40, 'Amy', 'Wilson', '789654', 'amywilson@hotmail.com', '0723456782', '$2y$10$aYpY17bd0M9WEJEqzOMJIu7Ey4GZuYgcsHHqWo2pGEuoJ.eRhzP8.', 1),
(41, 'Chris', 'Brown', '354689', 'chrisbrown20@hotmail.com', '0733456739', '$2y$10$ScFij5KRcbKeD8vjullD6.kGCnoDwBKOApxOTlBDCt5HdRRQgYOZO', 1),
(42, 'Emily', 'Rodrigo', '267935', 'emilyrodriguez789@gmail.com', '0712345672', '$2y$10$EifH4qnCOuVUgMWuNz0x0e9kNWv3QD2WaZcYAaeryRjPV64GxjwmK', 1),
(43, 'Michael', 'Shabalala', '837426', 'michaelsullivan@gmail.com', '0723456783', '$2y$10$kFIoompcVIvNNUC2m7NbCuoC0umAexr49DyALLlEcUaKVAlG5DNoG', 1),
(44, 'Jennifer', 'Dacis', '485739', 'Jenniferdavis@yahoo.com', '0733456794', '$2y$10$s8buTjlquWMkmPwW.aI9feqmJUM2gOJV2ilGy.GpEvavZWPwM2gYC', 1),
(45, 'Kevin', 'Miller', '691753', 'Kevinmiller@hotmail.com', '0712345673', '$2y$10$nDcYcSlXyV5x/Za7Y3GEGuBZIcJkBvKilJeAkgf5pY5tLKvayLZUq', 1),
(46, 'Laura', 'Smith', '237846', 'laurasmith7382@yahoo.com', '0723456784', '$2y$10$uVjm2/Xti2rfSRx8H5xQUuKOzaSAWhopSA/Cl4adsqmnyg2A4FMVG', 1),
(47, 'Marj', 'Thompson', '985674', 'Marjthompson@gmail.com', '0733456795', '$2y$10$/wFX41ol8t51Q5KOra0SZuSMjDgWysMrdBLy1cJaHX9lhhV2RLhd.', 1),
(48, 'Caroline', 'Martinez', '365124', 'Carolinemartin098@yahoo.com', '0712345674', '$2y$10$XIw.xnnUKc6SV6GxHRLDWexyzmrU6MbR1f12WSRtZ1RDmGJ0LKO16', 1),
(49, 'Joshua', 'Baker', '784512', 'Joshuabaker@gmail.com', '0723456785', '$2y$10$ZRazzV3LuG1rU4jK2bCUMucfGTotJdrdwWXKKpZznJPS.mjDe4QNa', 1),
(50, 'Elizabeth', 'Jones', '693587', 'Elizabethjones@yahoo.com', '0733456796', '$2y$10$NNPSdmcxs8cVXocZyAWX0eQvofLgAjDsuj23OsBpK338S1sZZ6nrG', 1),
(51, 'Alexander', 'Robinson', '172594', 'Alexanderrobinson509@gmail.com', '0712345675', '$2y$10$s/bSkLnHA/4u7EM4ZrvSEOJTMp1Vdcz8kLnyFYTY4JdAm2BE.TBSm', 1),
(52, 'Olivia', 'Morris', '469823', 'Oliviamorris065@yahoo.com', '0723456786', '$2y$10$QB3UJ72RNjaaLwHG6etrAulMfDeDsTBBwke5Vtdw1BKfEHCXFVpsO', 1),
(53, 'David', 'Hill', '853961', 'Davidhill@hotmail.com', '0733456797', '$2y$10$vv7oxwf8wzQ6LSXdhwHf8O2TaMoIQXW4C6FXQDdfAnIfEmKEzCbDa', 1),
(54, 'Hannah', 'Phillips', '926571', 'hannahphillips@hotmail.com', '0712345676', '$2y$10$olpx3MjTh7AakS/smMab/.9Tv7Pt9psFjJUKtwa2XYNPszetZSoQm', 1),
(55, 'Jason', 'Lee', '345672', 'Jasonlee@gmail.com', '0723456787', '$2y$10$SPMp6QeGB5m3Ndwinm/zIeTnje9yK28m6ycoo0GYXq1VNvqfR8qlm', 1),
(56, 'Christina', 'Brown', '789631', 'Christinabrown@yahoo.com', '0733456798', '$2y$10$5Pv20vpw.LYf10igjXBGQORZEgTZQTNyBBJcsEQhOPptAod8tRYq2', 1),
(57, 'Brian', 'Johnson', '356982', 'Brianjohnson@hotmail.com', '0712345677', '$2y$10$es2Kxe5/qJHjjOjKz2MZWegA8WegMxHvRH2zkjAtrFJt.MPQapJt6', 1),
(58, 'Ashley', 'Jackson', '217835', 'Ashleyjackson8976@yahoo.com', '0723456788', '$2y$10$z6MApPIKyhXneDwO7lTMyuSvpl6zERz87ae3M5qZDjvAeSwfglXkS', 1),
(59, 'Steven', 'Mitchell', '765912', 'Stevenmitchell2473@yahoo.com', '0733456799', '$2y$10$UkVfs3d0WwdT5QwpiG7VouZGK0SZuV0ARf6y9jLEOge6ziU9V1MMi', 1),
(60, 'Amanda', 'Wilson', '765912', 'Amandawilson23@hotmail.com', '0733456799', '$2y$10$9K5O9HWnYSBlw4ggQLsYYeM8Od76MW21SGrOo6EDMp9z/Vn0DcSd2', 1),
(61, 'Matthew', 'Davis', '123846', 'Matthiasdavis34@gmail.com', '0712345680', '$2y$10$GYMr0njy2WjpuuaIca.mPuZW6OIsIO0viAtuiIDka0wBOJwh3neI2', 1),
(62, 'Daniel', 'Thomas', '495618', 'Danielthomas@hotmail.com', '0723456790', '$2y$10$5VRUog4ML9LWq.0oKx.7OuHsgdWtTdmYiU3dsu7GjqW.90.1/CYHm', 1),
(63, 'Samantha', 'Martinez', '372168', 'Samanthamartinez@yahoo.com', '0733456700', '$2y$10$79SPRUQH.QTWp7BfCAmrk.VGjShM7gzhf4WG.XhNGdEMJelqHtkAu', 1),
(64, 'Daniela', 'Thomas', '983746', 'danielathomas@hotmail.com', '0712345681', '$2y$10$yAhKc8QFnh7/R0Yc0EKYHe/FG0fieQYV1UEz21Ybo6sha/aXU6jEi', 1),
(65, 'Lauren', 'Roberts', '651789', 'Laurenroberts92@yahoo.com', '0723456791', '$2y$10$RKDLOF4rJZF4LPQOLy3SzuE25LvkthLl/OAgrOmCk6ciuFNR61ZSG', 1),
(66, 'Nathan', 'Parker', '651789', 'Nathanparker644@yahoo.com', '0723456791', '$2y$10$YGX4z3SCl4kj2hcfUtsqluJsI3Mat8Mj0xwLgjSjd0KiKKlfnmz1W', 1),
(67, 'Jessica', 'Walker', '987654', 'Jessicawalker@hotmail.com', '0733456701', '$2y$10$95eAV5P2rIuIH.G6ClLtzuSzn4taSq.Ly48THni0RG8pvDUWc7zdu', 1),
(68, 'Erico', 'Rodriguez', '456721', 'Ericorodriguez@gmail.com', '0712345682', '$2y$10$ztwsRomsHbc76lnHDbbR7.wICnfugKuEyITlCngMGAQfmbIe4NpLy', 1),
(69, 'Allison', 'White', '783659', 'Allisonwhite@yahoo.com', '0712345682', '$2y$10$FQWjs/ZmBcD0nYTzhG2IV.7sQBWHHlRM0xxoJDXAbfBQNJSPVSzjy', 1),
(70, 'George', 'Collins', '783659', 'Georgecollins@hotmail.com', '0723456792', '$2y$10$Rf4POZGmWfKjgM6a.BllXOZzzmOsFgiy.3CRfAvmGyIOllrVx2rvO', 1),
(71, 'Molly', 'Turnika', '127936', 'Mollyturnika@yahoo.com', '0733456702', '$2y$10$O63umiBg3daHwmEK4YpcouQDAiTgZ5nfWMiDDd1aAihLEITQ1NU7q', 1),
(72, 'Ethan', 'Adamsons', '849651', 'Ethanadamsons@yahoo.com', '0712345683', '$2y$10$RQ7j8G3hT/VTvqYvTj7GwuzO4fiPYajg1/2T4KxySaoqIHwrTY3aC', 1),
(73, 'Layla', 'Mitchell', '937862', 'Laylamitchell78@gmail.com', '0723456793', '$2y$10$ME8AlUXbzmQB1mdPHaIewemULN8FW7qk53zQtfQToX0m0Usj0f.yO', 1),
(74, 'Patrick', 'Wright', '218759', 'Patrickwright@gmail.com', '0733456703', '$2y$10$gfC3lv3N3wwengZgpRU8/.3.tfvULveVwg1EmEYviSsYhBgglgULW', 1),
(75, 'Victoria', 'Jones', '697485', 'Victoriajones@yahoo.com', '0712345684', '$2y$10$rnwhPR6RtVzazof2RsiZme..jnzd2LNH9liVRsdAhA1Z6J9GB8qUy', 1),
(76, 'Nicholas', 'Roberts', '697485', 'Nicholasroberts@hotmail.com', '0712345684', '$2y$10$/25Z8pt.UyytoxA2hGmOGuOBK8AHJ.BkfdhwiX1bbgluEArzbUnEK', 1),
(77, 'Katelyn', 'Scott', '835194', 'Katelynscott97@yahoo.com', '0723456794', '$2y$10$eqFo5.8t2eWTwkCzZ2he3O8xGtTAyECJAJAkfWnacsXcWblP4dbrG', 1),
(78, 'Justin', 'Martin', '297461', 'Justinmartin086@gmail.com', '0733456704', '$2y$10$AlSE/0OcqhpN1.Q8SN5nB./QrHy1D33DVe9JxqolzN6OVu0jCmDrO', 1),
(79, 'Emma', 'Wilson', '674195', 'Emmawilson209@hotmail.com', '0712345685', '$2y$10$u9UHaKOf2hWYR8.YWwcmTOw2btOwp9oxlE.iJ0XmYe7r5QR80CVEy', 1),
(80, 'Robert', 'Garcia', '864297', 'Robertgarcia@gmail.com', '0723456795', '$2y$10$vP8gSRHtAfBnERoQ6jJTouQxyNJn3vDHVSlraMUgIxXRGNvnStqNG', 1),
(81, 'Sarah', 'Taylor', '238965', 'Sarahtaylor@yahoo.com', '0733456705', '$2y$10$LFRKgISHhSWKnTm3clKkxOD3/aP6lWxIogXH9llxWjrd7b/g1lKTK', 1),
(82, 'Thomas', 'Anderson', '971364', 'Thomasanderson@hotmail.com', '0712345686', '$2y$10$6OgyCBieBWlt1tI9dS6gSe8YWdShy/Dr0buD.z9xvvu/ImGNdAAHS', 1),
(83, 'Madison', 'Baker', '846713', 'Madisonbaker927@gmail.com', '0723456796', '$2y$10$ndbINYaRmmLHym3nknBwOetJRoX5A6EtSCEofSGDlF.UbX.O9rnXC', 1),
(84, 'Jacob', 'Johnson-White', '519473', 'Jacobjohnsonwhite@hotmail.com', '0733456706', '$2y$10$kNXQiY83PBr3aOllNroxo.MTVCg.3wyBjPeOOTYTEBLdeu5QfItBO', 1),
(85, 'Ethan', 'Morris', '326795', 'Ethanmorris@gmail.com', '0712345687', '$2y$10$do.c.ETjSN/dYIa850wxjeARGzisGRNgUUeRK/PJ01oOsUMRyX.Ey', 1),
(86, 'Marlon', 'Madiba', '742916', 'Madiba_fan@hotmail.com', '0723456797', '$2y$10$q3iQd22bSWIp703Snfpp4uetDMIV93ZAkxfIp.8ZKC6SH3bf4ILYG', 1),
(87, 'Yvonne', 'Casablanca', '583917', 'Casablancaartist@gmail.com', '0733456707', '$2y$10$yXzR0PaFuK931wWLAoIM4.YTYm1PY/5us5076PVbHeuyr4zdsVL0e', 1),
(88, 'Edwin', 'Okule', '214856', 'lagosenterpreneur@gmail.com', '0712345688', '$2y$10$0Q1GXLyXv/FnUQ55E98aKu7KPBE2UITuAv4GjiajsOANLZigW..ZG', 1),
(89, 'Timothy', 'Okulele', '695732', 'kilimanjarohiker@gmail.com', '0723456798', '$2y$10$Vr7QucOs62D9V483PqlAC.8YQ.aZOgOdGccKXohdVWbKbf3IWNqtC', 1),
(103, 'Ham', 'App', '678765', 'jodero380@gmail.com', '0729170490', '$2y$10$J.hX9OB/0KPMimc2Ib6lvuKwQusGUXTqf4.n5k5fo//itIby9uF.e', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `suite` (`suite`),
  ADD KEY `roomSelected` (`roomSelected`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `application_id` (`application_id`,`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomid`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_3` FOREIGN KEY (`suite`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_4` FOREIGN KEY (`roomSelected`) REFERENCES `rooms` (`roomid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`roomid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
