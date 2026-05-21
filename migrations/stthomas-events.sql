-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2026 at 03:59 PM
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
-- Database: `stthomas_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `attempt_limits`
--

CREATE TABLE `attempt_limits` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `attempts_left` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attempt_limits`
--

INSERT INTO `attempt_limits` (`id`, `identifier`, `attempts_left`, `timestamp`) VALUES
(2, '5650f558bf200ddea16f9d3463d7f74b7f383cd0c63084f65202c4cd1178af87d00d8da854ad9d05636f3868e7841a8cc0df', 0, '2026-05-16 22:23:09'),
(3, '52e63d500896dfde8cfc1f6b37b960b5e370ae8e08e787299f098089d20b215e58ef14ec1476665d6c450222301774699c43', 0, '2026-05-16 22:24:59'),
(4, '9107e4df4fb6d92dc23d1190e64516ff29e79038cedbe8997a31261d5fdb3558f293feae5b958c94adf65da1f06bcac134cf', 0, '2026-05-17 16:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `seat` varchar(10) NOT NULL,
  `code_expires_at` datetime NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `session_id`, `event_id`, `seat`, `code_expires_at`, `email_verified`, `timestamp`) VALUES
(68, 52, 1, 'K16', '2026-05-15 16:11:17', 1, '2026-05-15 20:06:18'),
(69, 53, 1, 'B105', '2026-05-15 17:13:11', 1, '2026-05-15 21:08:12'),
(70, 53, 1, 'B106', '2026-05-15 17:13:11', 1, '2026-05-15 21:08:12'),
(132, 71, 1, 'A13', '2026-05-18 17:25:42', 1, '2026-05-18 21:20:43'),
(134, 73, 1, 'E9', '2026-05-18 17:33:03', 1, '2026-05-18 21:28:04'),
(135, 73, 1, 'E11', '2026-05-18 17:33:03', 1, '2026-05-18 21:28:04'),
(136, 73, 1, 'E13', '2026-05-18 17:33:03', 1, '2026-05-18 21:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `booking_sessions`
--

CREATE TABLE `booking_sessions` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` enum('student','teacher','parent','other') NOT NULL,
  `token` varchar(255) NOT NULL,
  `verification_code` int(6) NOT NULL,
  `code_expires_at` datetime NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `reference` varchar(6) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_sessions`
--

INSERT INTO `booking_sessions` (`id`, `event_id`, `name`, `email`, `phone`, `role`, `token`, `verification_code`, `code_expires_at`, `email_verified`, `reference`, `timestamp`) VALUES
(52, 1, 'Flamen Dialis', 'tman9sushi@gmail.com', '(438) 878-6961', 'other', '13fded0ed93bc70f070cf3584d942960d7da1dcfb7e8fc435a4bc54704ab9ffd8505fa9ec16c7e3699d3d87e42380a93c727', 698020, '2026-05-15 16:11:17', 1, 'F7D23T', '2026-05-15 20:06:18'),
(53, 1, 'Rania', 'rabp70707@gmail.com', '(514) 675-8765', 'parent', '0ea2369f8f08f739fbc4bfa81c41fc4f49b8f27c33b1652f764f14521d484cfaebc1b459fc469b986bb1ce38850197c51610', 371489, '2026-05-15 17:13:11', 1, '9NC6ZS', '2026-05-15 21:08:12'),
(71, 1, 'Simon P', 'spapp01@lbpearson.ca', '(342) 342-3423', 'student', 'c3e433db388022314c8ea6479ad91f35ceb2aa3e66eefaffb6a0c1b03e1efa452cb0a5c6d468bece941d8cd928cbe6cc4199', 890120, '2026-05-18 17:25:42', 1, 'S7ZTDX', '2026-05-18 21:20:43'),
(73, 1, 'Simon P', 'si.studios13@gmail.com', '(342) 342-3423', 'parent', 'd95ab4339925900dd312e8091620fbb8296ecdc0443d25c1000db851d88745d1ce3520b8bc3ef7a54f9767f8bbe2a639c494', 764737, '2026-05-18 17:33:03', 1, 'NUG42L', '2026-05-18 21:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`price`)),
  `date` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `price`, `date`, `timestamp`) VALUES
(1, '2026 Variety Show', 'The annual variety The annual variety show at St. Thomas High School. Come see our students perform!', '{\"All\" : 15}', '2026-05-30 18:25:38', '2026-04-24 22:29:02'),
(4, '2026 Variety Show 2', 'The annual variety The annual variety show at St. Thomas High School. Come see our students perform!', '{\"All\" : 15}', '2026-05-30 18:25:38', '2026-04-24 22:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `seat` varchar(10) NOT NULL,
  `expires_at` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `session_id`, `event_id`, `seat`, `expires_at`, `timestamp`) VALUES
(333, 212, 1, 'A17', '2026-05-18 12:55:07', '2026-05-18 16:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_sessions`
--

CREATE TABLE `reservation_sessions` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  `expires_at` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_sessions`
--

INSERT INTO `reservation_sessions` (`id`, `token`, `event_id`, `expires_at`, `timestamp`) VALUES
(212, '003c14ba09795dce3657677c581d440eef7a16a7933b15a3dc3c661b2cbfc4931bdcd8fda47ff63296b3effa28248809843d', 1, '2026-05-18 12:55:07', '2026-05-18 16:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `row_letter` char(1) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `seat_label` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `row_letter`, `seat_number`, `seat_label`) VALUES
(1, 'N', 22, 'N22'),
(2, 'N', 20, 'N20'),
(3, 'N', 18, 'N18'),
(4, 'N', 16, 'N16'),
(5, 'N', 14, 'N14'),
(6, 'N', 12, 'N12'),
(7, 'N', 10, 'N10'),
(8, 'N', 8, 'N8'),
(9, 'N', 6, 'N6'),
(10, 'N', 4, 'N4'),
(11, 'N', 2, 'N2'),
(12, 'N', 1, 'N1'),
(13, 'N', 3, 'N3'),
(14, 'N', 5, 'N5'),
(15, 'N', 7, 'N7'),
(16, 'N', 9, 'N9'),
(17, 'N', 11, 'N11'),
(18, 'N', 13, 'N13'),
(19, 'N', 15, 'N15'),
(20, 'N', 17, 'N17'),
(21, 'N', 19, 'N19'),
(22, 'N', 21, 'N21'),
(23, 'M', 24, 'M24'),
(24, 'M', 22, 'M22'),
(25, 'M', 20, 'M20'),
(26, 'M', 18, 'M18'),
(27, 'M', 16, 'M16'),
(28, 'M', 14, 'M14'),
(29, 'M', 12, 'M12'),
(30, 'M', 10, 'M10'),
(31, 'M', 8, 'M8'),
(32, 'M', 6, 'M6'),
(33, 'M', 4, 'M4'),
(34, 'M', 2, 'M2'),
(35, 'M', 1, 'M1'),
(36, 'M', 3, 'M3'),
(37, 'M', 5, 'M5'),
(38, 'M', 7, 'M7'),
(39, 'M', 9, 'M9'),
(40, 'M', 11, 'M11'),
(41, 'M', 13, 'M13'),
(42, 'M', 15, 'M15'),
(43, 'M', 17, 'M17'),
(44, 'M', 19, 'M19'),
(45, 'M', 21, 'M21'),
(46, 'M', 23, 'M23'),
(47, 'L', 28, 'L28'),
(48, 'L', 26, 'L26'),
(49, 'L', 24, 'L24'),
(50, 'L', 22, 'L22'),
(51, 'L', 20, 'L20'),
(52, 'L', 18, 'L18'),
(53, 'L', 16, 'L16'),
(54, 'L', 14, 'L14'),
(55, 'L', 12, 'L12'),
(56, 'L', 10, 'L10'),
(57, 'L', 8, 'L8'),
(58, 'L', 6, 'L6'),
(59, 'L', 4, 'L4'),
(60, 'L', 2, 'L2'),
(61, 'L', 1, 'L1'),
(62, 'L', 3, 'L3'),
(63, 'L', 5, 'L5'),
(64, 'L', 7, 'L7'),
(65, 'L', 9, 'L9'),
(66, 'L', 11, 'L11'),
(67, 'L', 13, 'L13'),
(68, 'L', 15, 'L15'),
(69, 'L', 17, 'L17'),
(70, 'L', 19, 'L19'),
(71, 'L', 21, 'L21'),
(72, 'L', 23, 'L23'),
(73, 'L', 25, 'L25'),
(74, 'L', 27, 'L27'),
(75, 'K', 30, 'K30'),
(76, 'K', 28, 'K28'),
(77, 'K', 26, 'K26'),
(78, 'K', 24, 'K24'),
(79, 'K', 22, 'K22'),
(80, 'K', 20, 'K20'),
(81, 'K', 18, 'K18'),
(82, 'K', 16, 'K16'),
(83, 'K', 14, 'K14'),
(84, 'K', 12, 'K12'),
(85, 'K', 10, 'K10'),
(86, 'K', 8, 'K8'),
(87, 'K', 6, 'K6'),
(88, 'K', 4, 'K4'),
(89, 'K', 2, 'K2'),
(90, 'K', 1, 'K1'),
(91, 'K', 3, 'K3'),
(92, 'K', 5, 'K5'),
(93, 'K', 7, 'K7'),
(94, 'K', 9, 'K9'),
(95, 'K', 11, 'K11'),
(96, 'K', 13, 'K13'),
(97, 'K', 15, 'K15'),
(98, 'K', 17, 'K17'),
(99, 'K', 19, 'K19'),
(100, 'K', 21, 'K21'),
(101, 'K', 23, 'K23'),
(102, 'K', 25, 'K25'),
(103, 'K', 27, 'K27'),
(104, 'K', 29, 'K29'),
(105, 'J', 32, 'J32'),
(106, 'J', 30, 'J30'),
(107, 'J', 28, 'J28'),
(108, 'J', 26, 'J26'),
(109, 'J', 24, 'J24'),
(110, 'J', 22, 'J22'),
(111, 'J', 20, 'J20'),
(112, 'J', 18, 'J18'),
(113, 'J', 16, 'J16'),
(114, 'J', 14, 'J14'),
(115, 'J', 12, 'J12'),
(116, 'J', 10, 'J10'),
(117, 'J', 8, 'J8'),
(118, 'J', 6, 'J6'),
(119, 'J', 4, 'J4'),
(120, 'J', 2, 'J2'),
(121, 'J', 1, 'J1'),
(122, 'J', 3, 'J3'),
(123, 'J', 5, 'J5'),
(124, 'J', 7, 'J7'),
(125, 'J', 9, 'J9'),
(126, 'J', 11, 'J11'),
(127, 'J', 13, 'J13'),
(128, 'J', 15, 'J15'),
(129, 'J', 17, 'J17'),
(130, 'J', 19, 'J19'),
(131, 'J', 21, 'J21'),
(132, 'J', 23, 'J23'),
(133, 'J', 25, 'J25'),
(134, 'J', 27, 'J27'),
(135, 'J', 29, 'J29'),
(136, 'J', 31, 'J31'),
(137, 'H', 34, 'H34'),
(138, 'H', 32, 'H32'),
(139, 'H', 30, 'H30'),
(140, 'H', 28, 'H28'),
(141, 'H', 26, 'H26'),
(142, 'H', 24, 'H24'),
(143, 'H', 22, 'H22'),
(144, 'H', 20, 'H20'),
(145, 'H', 18, 'H18'),
(146, 'H', 16, 'H16'),
(147, 'H', 14, 'H14'),
(148, 'H', 12, 'H12'),
(149, 'H', 10, 'H10'),
(150, 'H', 8, 'H8'),
(151, 'H', 6, 'H6'),
(152, 'H', 4, 'H4'),
(153, 'H', 2, 'H2'),
(154, 'H', 1, 'H1'),
(155, 'H', 3, 'H3'),
(156, 'H', 5, 'H5'),
(157, 'H', 7, 'H7'),
(158, 'H', 9, 'H9'),
(159, 'H', 11, 'H11'),
(160, 'H', 13, 'H13'),
(161, 'H', 15, 'H15'),
(162, 'H', 17, 'H17'),
(163, 'H', 19, 'H19'),
(164, 'H', 21, 'H21'),
(165, 'H', 23, 'H23'),
(166, 'H', 25, 'H25'),
(167, 'H', 27, 'H27'),
(168, 'H', 29, 'H29'),
(169, 'H', 31, 'H31'),
(170, 'H', 33, 'H33'),
(171, 'G', 22, 'G22'),
(172, 'G', 20, 'G20'),
(173, 'G', 18, 'G18'),
(174, 'G', 16, 'G16'),
(175, 'G', 14, 'G14'),
(176, 'G', 12, 'G12'),
(177, 'G', 10, 'G10'),
(178, 'G', 8, 'G8'),
(179, 'G', 6, 'G6'),
(180, 'G', 4, 'G4'),
(181, 'G', 2, 'G2'),
(182, 'G', 1, 'G1'),
(183, 'G', 3, 'G3'),
(184, 'G', 5, 'G5'),
(185, 'G', 7, 'G7'),
(186, 'G', 9, 'G9'),
(187, 'G', 11, 'G11'),
(188, 'G', 13, 'G13'),
(189, 'G', 15, 'G15'),
(190, 'G', 17, 'G17'),
(191, 'G', 19, 'G19'),
(192, 'G', 21, 'G21'),
(193, 'G', 101, 'G101'),
(194, 'G', 102, 'G102'),
(195, 'G', 103, 'G103'),
(196, 'G', 104, 'G104'),
(197, 'G', 105, 'G105'),
(198, 'G', 106, 'G106'),
(199, 'G', 107, 'G107'),
(200, 'G', 108, 'G108'),
(201, 'G', 109, 'G109'),
(202, 'G', 110, 'G110'),
(203, 'G', 111, 'G111'),
(204, 'G', 112, 'G112'),
(205, 'G', 113, 'G113'),
(206, 'G', 114, 'G114'),
(207, 'G', 115, 'G115'),
(208, 'G', 116, 'G116'),
(209, 'G', 117, 'G117'),
(210, 'G', 118, 'G118'),
(211, 'G', 119, 'G119'),
(212, 'G', 120, 'G120'),
(213, 'F', 20, 'F20'),
(214, 'F', 18, 'F18'),
(215, 'F', 16, 'F16'),
(216, 'F', 14, 'F14'),
(217, 'F', 12, 'F12'),
(218, 'F', 10, 'F10'),
(219, 'F', 8, 'F8'),
(220, 'F', 6, 'F6'),
(221, 'F', 4, 'F4'),
(222, 'F', 2, 'F2'),
(223, 'F', 1, 'F1'),
(224, 'F', 3, 'F3'),
(225, 'F', 5, 'F5'),
(226, 'F', 7, 'F7'),
(227, 'F', 9, 'F9'),
(228, 'F', 11, 'F11'),
(229, 'F', 13, 'F13'),
(230, 'F', 15, 'F15'),
(231, 'F', 17, 'F17'),
(232, 'F', 19, 'F19'),
(233, 'F', 101, 'F101'),
(234, 'F', 102, 'F102'),
(235, 'F', 103, 'F103'),
(236, 'F', 104, 'F104'),
(237, 'F', 105, 'F105'),
(238, 'F', 106, 'F106'),
(239, 'F', 107, 'F107'),
(240, 'F', 108, 'F108'),
(241, 'F', 109, 'F109'),
(242, 'F', 110, 'F110'),
(243, 'F', 111, 'F111'),
(244, 'F', 112, 'F112'),
(245, 'F', 113, 'F113'),
(246, 'F', 114, 'F114'),
(247, 'F', 115, 'F115'),
(248, 'F', 116, 'F116'),
(249, 'F', 117, 'F117'),
(250, 'F', 118, 'F118'),
(251, 'F', 119, 'F119'),
(252, 'E', 20, 'E20'),
(253, 'E', 18, 'E18'),
(254, 'E', 16, 'E16'),
(255, 'E', 14, 'E14'),
(256, 'E', 12, 'E12'),
(257, 'E', 10, 'E10'),
(258, 'E', 8, 'E8'),
(259, 'E', 6, 'E6'),
(260, 'E', 4, 'E4'),
(261, 'E', 2, 'E2'),
(262, 'E', 1, 'E1'),
(263, 'E', 3, 'E3'),
(264, 'E', 5, 'E5'),
(265, 'E', 7, 'E7'),
(266, 'E', 9, 'E9'),
(267, 'E', 11, 'E11'),
(268, 'E', 13, 'E13'),
(269, 'E', 15, 'E15'),
(270, 'E', 17, 'E17'),
(271, 'E', 19, 'E19'),
(272, 'E', 101, 'E101'),
(273, 'E', 102, 'E102'),
(274, 'E', 103, 'E103'),
(275, 'E', 104, 'E104'),
(276, 'E', 105, 'E105'),
(277, 'E', 106, 'E106'),
(278, 'E', 107, 'E107'),
(279, 'E', 108, 'E108'),
(280, 'E', 109, 'E109'),
(281, 'E', 110, 'E110'),
(282, 'E', 111, 'E111'),
(283, 'E', 112, 'E112'),
(284, 'E', 113, 'E113'),
(285, 'E', 114, 'E114'),
(286, 'E', 115, 'E115'),
(287, 'E', 116, 'E116'),
(288, 'E', 117, 'E117'),
(289, 'E', 118, 'E118'),
(290, 'D', 20, 'D20'),
(291, 'D', 18, 'D18'),
(292, 'D', 16, 'D16'),
(293, 'D', 14, 'D14'),
(294, 'D', 12, 'D12'),
(295, 'D', 10, 'D10'),
(296, 'D', 8, 'D8'),
(297, 'D', 6, 'D6'),
(298, 'D', 4, 'D4'),
(299, 'D', 2, 'D2'),
(300, 'D', 1, 'D1'),
(301, 'D', 3, 'D3'),
(302, 'D', 5, 'D5'),
(303, 'D', 7, 'D7'),
(304, 'D', 9, 'D9'),
(305, 'D', 11, 'D11'),
(306, 'D', 13, 'D13'),
(307, 'D', 15, 'D15'),
(308, 'D', 17, 'D17'),
(309, 'D', 19, 'D19'),
(310, 'D', 101, 'D101'),
(311, 'D', 102, 'D102'),
(312, 'D', 103, 'D103'),
(313, 'D', 104, 'D104'),
(314, 'D', 105, 'D105'),
(315, 'D', 106, 'D106'),
(316, 'D', 107, 'D107'),
(317, 'D', 108, 'D108'),
(318, 'D', 109, 'D109'),
(319, 'D', 110, 'D110'),
(320, 'D', 111, 'D111'),
(321, 'D', 112, 'D112'),
(322, 'D', 113, 'D113'),
(323, 'D', 114, 'D114'),
(324, 'D', 115, 'D115'),
(325, 'D', 116, 'D116'),
(326, 'D', 117, 'D117'),
(327, 'C', 20, 'C20'),
(328, 'C', 18, 'C18'),
(329, 'C', 16, 'C16'),
(330, 'C', 14, 'C14'),
(331, 'C', 12, 'C12'),
(332, 'C', 10, 'C10'),
(333, 'C', 8, 'C8'),
(334, 'C', 6, 'C6'),
(335, 'C', 4, 'C4'),
(336, 'C', 2, 'C2'),
(337, 'C', 1, 'C1'),
(338, 'C', 3, 'C3'),
(339, 'C', 5, 'C5'),
(340, 'C', 7, 'C7'),
(341, 'C', 9, 'C9'),
(342, 'C', 11, 'C11'),
(343, 'C', 13, 'C13'),
(344, 'C', 15, 'C15'),
(345, 'C', 17, 'C17'),
(346, 'C', 19, 'C19'),
(347, 'C', 101, 'C101'),
(348, 'C', 102, 'C102'),
(349, 'C', 103, 'C103'),
(350, 'C', 104, 'C104'),
(351, 'C', 105, 'C105'),
(352, 'C', 106, 'C106'),
(353, 'C', 107, 'C107'),
(354, 'C', 108, 'C108'),
(355, 'C', 109, 'C109'),
(356, 'C', 110, 'C110'),
(357, 'C', 111, 'C111'),
(358, 'C', 112, 'C112'),
(359, 'C', 113, 'C113'),
(360, 'C', 114, 'C114'),
(361, 'C', 115, 'C115'),
(362, 'C', 116, 'C116'),
(363, 'B', 20, 'B20'),
(364, 'B', 18, 'B18'),
(365, 'B', 16, 'B16'),
(366, 'B', 14, 'B14'),
(367, 'B', 12, 'B12'),
(368, 'B', 10, 'B10'),
(369, 'B', 8, 'B8'),
(370, 'B', 6, 'B6'),
(371, 'B', 4, 'B4'),
(372, 'B', 2, 'B2'),
(373, 'B', 1, 'B1'),
(374, 'B', 3, 'B3'),
(375, 'B', 5, 'B5'),
(376, 'B', 7, 'B7'),
(377, 'B', 9, 'B9'),
(378, 'B', 11, 'B11'),
(379, 'B', 13, 'B13'),
(380, 'B', 15, 'B15'),
(381, 'B', 17, 'B17'),
(382, 'B', 19, 'B19'),
(383, 'B', 101, 'B101'),
(384, 'B', 102, 'B102'),
(385, 'B', 103, 'B103'),
(386, 'B', 104, 'B104'),
(387, 'B', 105, 'B105'),
(388, 'B', 106, 'B106'),
(389, 'B', 107, 'B107'),
(390, 'B', 108, 'B108'),
(391, 'B', 109, 'B109'),
(392, 'B', 110, 'B110'),
(393, 'B', 111, 'B111'),
(394, 'B', 112, 'B112'),
(395, 'B', 113, 'B113'),
(396, 'B', 114, 'B114'),
(397, 'B', 115, 'B115'),
(398, 'A', 18, 'A18'),
(399, 'A', 16, 'A16'),
(400, 'A', 14, 'A14'),
(401, 'A', 12, 'A12'),
(402, 'A', 10, 'A10'),
(403, 'A', 8, 'A8'),
(404, 'A', 6, 'A6'),
(405, 'A', 4, 'A4'),
(406, 'A', 2, 'A2'),
(407, 'A', 1, 'A1'),
(408, 'A', 3, 'A3'),
(409, 'A', 5, 'A5'),
(410, 'A', 7, 'A7'),
(411, 'A', 9, 'A9'),
(412, 'A', 11, 'A11'),
(413, 'A', 13, 'A13'),
(414, 'A', 15, 'A15'),
(415, 'A', 17, 'A17'),
(416, 'A', 101, 'A101'),
(417, 'A', 102, 'A102'),
(418, 'A', 103, 'A103'),
(419, 'A', 104, 'A104'),
(420, 'A', 105, 'A105'),
(421, 'A', 106, 'A106'),
(422, 'A', 107, 'A107'),
(423, 'A', 108, 'A108'),
(424, 'A', 109, 'A109'),
(425, 'A', 110, 'A110'),
(426, 'A', 111, 'A111'),
(427, 'A', 112, 'A112'),
(428, 'A', 113, 'A113'),
(429, 'A', 114, 'A114');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attempt_limits`
--
ALTER TABLE `attempt_limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `booking_sessions`
--
ALTER TABLE `booking_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `reservation_sessions`
--
ALTER TABLE `reservation_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_sessions_token` (`token`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seat_label` (`seat_label`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attempt_limits`
--
ALTER TABLE `attempt_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `booking_sessions`
--
ALTER TABLE `booking_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT for table `reservation_sessions`
--
ALTER TABLE `reservation_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=430;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bookings_session_id` FOREIGN KEY (`session_id`) REFERENCES `booking_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_sessions`
--
ALTER TABLE `booking_sessions`
  ADD CONSTRAINT `fk_booking_sessions_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reservations_session_id` FOREIGN KEY (`session_id`) REFERENCES `reservation_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation_sessions`
--
ALTER TABLE `reservation_sessions`
  ADD CONSTRAINT `fk_reservation_sessions_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
