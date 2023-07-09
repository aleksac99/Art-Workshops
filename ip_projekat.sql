-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 25, 2023 at 06:05 PM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ip_projekat`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '2' COMMENT 'accepted/denied/pending',
  PRIMARY KEY (`id`),
  KEY `application_ibfk_1` (`user_id`),
  KEY `application_ibfk_2` (`workshop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `user_id`, `workshop_id`, `status`) VALUES
(51, 64, 48, 0),
(52, 58, 55, 0),
(53, 59, 55, 0),
(54, 64, 55, 0),
(56, 61, 50, 0),
(58, 59, 50, 1),
(60, 72, 48, 0),
(61, 70, 48, 0),
(62, 69, 48, 0),
(63, 68, 48, 1),
(65, 61, 48, 0),
(66, 64, 58, 2),
(67, 84, 54, 2),
(68, 84, 58, 1),
(69, 84, 49, 2),
(70, 84, 50, 2),
(71, 58, 61, 0),
(72, 69, 61, 2),
(73, 69, 49, 2),
(74, 113, 49, 2),
(75, 114, 49, 2),
(76, 114, 61, 2),
(77, 99, 49, 1),
(78, 98, 49, 2),
(79, 116, 63, 0),
(80, 105, 63, 0),
(81, 61, 64, 2);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `workshop_name` varchar(100) NOT NULL,
  `text` varchar(500) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `workshop_id` (`workshop_name`),
  KEY `comment_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `workshop_name`, `text`, `datetime`) VALUES
(11, 58, 'Dusanova Radionica', 'Dobra ideja!', '2023-01-24 23:39:24'),
(12, 69, 'Aleksina Radionica', 'Sve u svemu 4/5', '2023-01-25 09:27:35'),
(13, 70, 'Aleksina Radionica', 'Zašto?', '2023-01-25 09:28:12'),
(14, 116, 'Feđina Radionica', '3/5 išla bih ponovo', '2023-01-25 18:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `organization_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organization_number` (`organization_number`),
  KEY `organization_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `user_id`, `name`, `address`, `organization_number`) VALUES
(19, 59, 'Anine Čarolije', '14, Koce Kapetana, Cubura, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', '987789'),
(20, 61, 'Duke Studios', '5, Risanska, МЗ Слободан Пенезић-Крцун, Београд (Савски венац), Savski Venac Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', '123213'),
(21, 67, 'Organizacija RTS', 'RTS Gallery, 10, Takovska, Old Town, Stari Grad Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', '132132'),
(22, 71, 'M Org', '20a, Takovska, Old Town, Stari Grad Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', '14752'),
(23, 72, 'Miloševa Org', '20, Novopazarska, Cubura, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', '987123'),
(24, 74, 'Petrova Organizacija', '20, Pozeska, Голф насеље, Михајловац, Београд (Чукарица), Cukarica Urban Municipality, City of Belgrade, Central Serbia, 11000, Serbia', '1111'),
(25, 83, 'Lazareva Organizacija', 'Mirijevski Bulevar, МЗ Филип Вишњић, Palilula, Palilula Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11060, Serbia', '159489'),
(26, 84, 'Aleksandrova Organizacija', 'Marshal Tolbukhin Boulevard, МЗ Икарус, New Belgrade, New Belgrade Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', '032032'),
(28, 97, 'Merkur', 'The Oldest House in Belgrade, 10, Cara Dusana, Dorcol, Old Town, Stari Grad Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', '1234567890'),
(29, 104, 'Feđine Radionice', 'Faculty of Organizational Sciences, 154, Jove Ilica, МЗ Горњи Вождовац, Београд (Вождовац), Vozdovac Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11040, Serbia', '6544566548'),
(30, 112, 'Nasumična organizacija', 'Илије Стреле, Радничко насеље, Leskovac, City of Leskovac, Jablanica Administrative District, Central Serbia, 16000, Serbia', '6549871230');

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

DROP TABLE IF EXISTS `password`;
CREATE TABLE IF NOT EXISTS `password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `temp_password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `password_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '2',
  `user_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone_number`, `status`, `user_type`) VALUES
(15, 'admin', 'admin', 'admin@gmail.com', 'Administrator', 'Admin', '066654654', 0, 2),
(58, 'aleksa', 'aleksa', 'aleksa.cvetanovic99@gmail.com', 'Aleksa', 'Cvetanović', '060987987', 0, 1),
(59, 'ana', 'ana', 'ana@example.com', 'Ana', 'Dimić', '121212121', 0, 1),
(60, 'marko', 'marko', 'marko@example.com', 'Marko', 'Marković', '321123', 1, 0),
(61, 'dusan', 'dusan', 'dusan@example.com', 'Dušan', 'Todorović', '147147', 0, 1),
(64, 'ucesnik', 'ucesnik', 'ucesnik@example.com', 'Učesnikovo Ime', 'Učesnikovo prezime', '32123', 0, 0),
(67, 'nevena', 'nevena', 'nevena@example.com', 'Nevena', 'Nikolić', '165265', 0, 1),
(68, 'jovan', 'jovan', 'jovana@example.com', 'Jovan', 'Jovanović', '132154', 0, 0),
(69, 'goran', 'goran', 'goran@example.com', 'Goran', 'Đoković', '1213121', 0, 0),
(70, 'ivana', 'ivana', 'ivana@example.com', 'Ivana', 'Ivanović', '132756', 0, 0),
(71, 'milica', 'milica', 'milica@example.com', 'Milica', 'Nikolić', '176767', 1, 1),
(72, 'milos', 'milos', 'milos@example.com', 'Miloš', 'Nikolić', '453627', 0, 1),
(73, 'filip', 'filip', 'filip@example.com', 'Filip', 'Filipović', '148259', 1, 0),
(74, 'petar', 'petar', 'petar@example.com', 'Petar', 'Petrović', '456456', 0, 1),
(75, 'kristijan', 'kristijan', 'kristijan@example.com', 'Kristijan', 'Lazarević', '165', 0, 0),
(76, 'luka', 'luka', 'luka@example.com', 'Luka', 'Lazarević', '132462', 0, 1),
(83, 'lazar', 'lazar', 'lazar@example.com', 'Lazar', 'Lazarević', '434343', 0, 1),
(84, 'aleksandar', 'aleksandar', 'aleksandar@example.com', 'Aleksandar', 'Marković', '123123123123', 0, 1),
(91, 'qwe', 'A123123123!', 'qwe@example.com', 'qwe', 'qwe', '062123456', 2, 0),
(92, 'qwe2', 'A123654789!', 'qwe2@example.com', 'qwe2', 'qwe2', '062123456', 2, 0),
(93, 'qwe3', 'A123123123!', 'qwe3@example.com', 'qwe3', 'qwe3', '062123456', 2, 0),
(94, 'qwe4', 'A123123123!', 'qwe4@example.com', 'qwe4', 'qwe4', '0629874565', 2, 1),
(95, 'qwe5', 'A123123123!', 'qwe5@example.com', 'qwe5', 'qwe5', '062123654', 2, 0),
(96, 'qwe6', 'A123123123!', 'qwe6@example.com', 'qwe6', 'qwe6', '0623126456', 2, 0),
(97, 'qwe7', 'A123123123!', 'qwe7@example.com', 'qwe7', 'qwe', '062147852', 0, 1),
(98, 'david', 'david', 'david@example.com', 'David', 'Ljubisavljević', '0629874562', 0, 0),
(99, 'darko', 'darko', 'darko@example.com', 'Darko', 'Marković', '062150250', 0, 0),
(100, 'asd', 'A123123123!', 'asd@example.com', 'asd', 'asd', '123654123', 2, 0),
(101, '456', 'A123123123!', '123@example.com', '456', '456', '321654', 2, 0),
(102, '789', 'A123123123!', '123654@example.com', '789', '789', '062654789', 2, 0),
(103, 'poi', 'A123123123!', 'poi@example.com', 'poi', 'poi', '062321321', 2, 0),
(104, 'fedja', 'fedja', 'fedja@example.com', 'Feđa', 'Mladenović', '062321321', 0, 1),
(105, 'vanja', 'vanja', 'vanja@example.com', 'Vanja', 'Krajinović', '062987987', 0, 0),
(106, 'mina', 'mina', 'mina@example.com', 'Mina', 'Đoković', '060654654', 0, 0),
(107, 'jana', 'jana', 'jana@example.com', 'Jana', 'Janković', '0603213212', 0, 0),
(108, 'gavrilo', 'gavrilo', 'gavrilo@example.com', 'Gavrilo', 'Gavrilović', '060321456', 0, 0),
(109, 'jhgfds', 'A123123123!', 'kjhgfd@example.com', 'jhgfds', 'jhgfds', '064654654', 2, 0),
(110, 'nbvc', 'A123123123!', 'adskjhgfd@example.com', 'mnbvc', 'mnbvc', '060414141', 2, 0),
(111, 'cfr', 'A123123123!', 'qwedsa@example.com', 'cfr', 'cfr', '0600321', 2, 0),
(112, 'lkjhgztr', 'A123123123!', 'oiuztrejhgf@example.com', 'Neko', 'Nepoznat', '06097258', 0, 1),
(113, 'ilija', 'ilija', 'ilija@example.com', 'Ilija', 'Kovačić', '064987987', 0, 0),
(114, 'srdjan', 'srdjan', 'srdjan@example.com', 'Srđan', 'Stevanović', '064654987', 0, 0),
(115, 'marija', 'A123123123!', 'marija@example.com', 'Marija', 'Marković', '065654654', 0, 0),
(116, 'irena', 'A123123123!', 'irena@example.com', 'Irena', 'Marković', '064987987', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `workshop`
--

DROP TABLE IF EXISTS `workshop`;
CREATE TABLE IF NOT EXISTS `workshop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_lat` float NOT NULL,
  `address_long` float NOT NULL,
  `short_description` varchar(100) NOT NULL,
  `long_description` varchar(2000) NOT NULL,
  `max_no_applications` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `workshop`
--

INSERT INTO `workshop` (`id`, `user_id`, `name`, `date`, `address`, `address_lat`, `address_long`, `short_description`, `long_description`, `max_no_applications`, `status`) VALUES
(48, 58, 'Aleksina Radionica', '2022-02-01 12:00:00', 'School of Electrical Engineering, 73, King Alexander Boulevard, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4762, 44.8057, 'Likovna radionica za decu do 12 godina.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor lacus luctus accumsan tortor posuere. Sed tempus urna et pharetra pharetra massa massa. Ut placerat orci nulla pellentesque dignissim. Ultrices dui sapien eget mi proin. Sit amet nulla facilisi morbi tempus iaculis urna id. Sagittis eu volutpat odio facilisis mauris sit amet. Arcu non sodales neque sodales ut etiam sit amet. Ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Lobortis scelerisque fermentum dui faucibus in ornare. Massa sed elementum tempus egestas sed sed risus pretium quam. Faucibus vitae aliquet nec ullamcorper sit amet risus nullam eget. Egestas integer eget aliquet nibh praesent. Vitae nunc sed velit dignissim sodales ut eu sem. Morbi leo urna molestie at elementum eu facilisis sed odio. Ultrices eros in cursus turpis massa tincidunt dui. Lacus viverra vitae congue eu consequat ac felis donec et. Egestas egestas fringilla phasellus faucibus scelerisque. Sit amet est placerat in egestas erat. Nunc mi ipsum faucibus vitae.', 5, 0),
(49, 58, 'Aleksina Radionica', '2023-03-01 13:00:00', '10, Prote Mateje, Cubura, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4681, 44.8028, 'Likovna radionica za decu do 10 godina.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor lacus luctus accumsan tortor posuere. Sed tempus urna et pharetra pharetra massa massa. Ut placerat orci nulla pellentesque dignissim. Ultrices dui sapien eget mi proin. Sit amet nulla facilisi morbi tempus iaculis urna id. Sagittis eu volutpat odio facilisis mauris sit amet. Arcu non sodales neque sodales ut etiam sit amet. Ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Lobortis scelerisque fermentum dui faucibus in ornare. Massa sed elementum tempus egestas sed sed risus pretium quam. Faucibus vitae aliquet nec ullamcorper sit amet risus nullam eget. Egestas integer eget aliquet nibh praesent. Vitae nunc sed velit dignissim sodales ut eu sem. Morbi leo urna molestie at elementum eu facilisis sed odio. Ultrices eros in cursus turpis massa tincidunt dui. Lacus viverra vitae congue eu consequat ac felis donec et. Egestas egestas fringilla phasellus faucibus scelerisque. Sit amet est placerat in egestas erat. Nunc mi ipsum faucibus vitae.', 5, 0),
(50, 58, 'Aleksina Radionica 2', '2023-03-01 22:00:00', '10, Prote Mateje, Cubura, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4681, 44.8028, 'Likovna radionica za decu do 13 godina.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor lacus luctus accumsan tortor posuere. Sed tempus urna et pharetra pharetra massa massa. Ut placerat orci nulla pellentesque dignissim. Ultrices dui sapien eget mi proin. Sit amet nulla facilisi morbi tempus iaculis urna id. Sagittis eu volutpat odio facilisis mauris sit amet. Arcu non sodales neque sodales ut etiam sit amet. Ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Lobortis scelerisque fermentum dui faucibus in ornare. Massa sed elementum tempus egestas sed sed risus pretium quam. Faucibus vitae aliquet nec ullamcorper sit amet risus nullam eget. Egestas integer eget aliquet nibh praesent. Vitae nunc sed velit dignissim sodales ut eu sem. Morbi leo urna molestie at elementum eu facilisis sed odio. Ultrices eros in cursus turpis massa tincidunt dui. Lacus viverra vitae congue eu consequat ac felis donec et. Egestas egestas fringilla phasellus faucibus scelerisque. Sit amet est placerat in egestas erat. Nunc mi ipsum faucibus vitae.', 5, 0),
(51, 58, 'Aleksina Radionica 2', '2023-03-01 12:00:00', '10, Prote Mateje, Cubura, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4681, 44.8028, 'Likovna radionica za decu do 18 godina.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor lacus luctus accumsan tortor posuere. Sed tempus urna et pharetra pharetra massa massa. Ut placerat orci nulla pellentesque dignissim. Ultrices dui sapien eget mi proin. Sit amet nulla facilisi morbi tempus iaculis urna id. Sagittis eu volutpat odio facilisis mauris sit amet. Arcu non sodales neque sodales ut etiam sit amet. Ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Lobortis scelerisque fermentum dui faucibus in ornare. Massa sed elementum tempus egestas sed sed risus pretium quam. Faucibus vitae aliquet nec ullamcorper sit amet risus nullam eget. Egestas integer eget aliquet nibh praesent. Vitae nunc sed velit dignissim sodales ut eu sem. Morbi leo urna molestie at elementum eu facilisis sed odio. Ultrices eros in cursus turpis massa tincidunt dui. Lacus viverra vitae congue eu consequat ac felis donec et. Egestas egestas fringilla phasellus faucibus scelerisque. Sit amet est placerat in egestas erat. Nunc mi ipsum faucibus vitae.', 5, 1),
(52, 64, 'Učesnikova radionica', '2023-10-10 10:10:00', 'LHC, 25, Visnjicka, МЗ Стара Карабурма, Palilula, Palilula Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11060, Serbia', 20.5032, 44.818, 'Ova radionica neće biti odobrena', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 30, 2),
(54, 15, 'Adminova Radionica', '2023-04-01 10:00:00', '20, Husinskih rudara, МЗ Деспот Стефан Лазаревић, Palilula, Palilula Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.5186, 44.8113, 'Radionica koja će biti automatski odobrena jer je organizuje Administrator', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, 0),
(55, 61, 'Dusanova Radionica', '2023-01-01 12:00:00', 'Risanska, МЗ Слободан Пенезић-Крцун, Београд (Савски венац), Savski Venac Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4549, 44.8064, 'Radionica koja je održana u prošlosti', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 20, 0),
(56, 61, 'Dusanova Radionica 2', '2023-01-01 12:00:00', 'Risanska, МЗ Слободан Пенезић-Крцун, Београд (Савски венац), Savski Venac Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4549, 44.8064, 'Radionica 2 koja je održana u prošlosti.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 20, 1),
(58, 61, 'Dusanova Radionica', '2024-01-01 22:00:00', 'Risanska, МЗ Слободан Пенезић-Крцун, Београд (Савски венац), Savski Venac Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4549, 44.8064, 'Zbog velikog interesovanja Novogodišnja radionica se održava još jednom!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 25, 0),
(59, 58, 'Aleksina Radionica', '2023-03-01 12:00:00', '10, Prote Mateje, Cubura, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4681, 44.8028, 'Likovna radionica za decu do 12 godina.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor lacus luctus accumsan tortor posuere. Sed tempus urna et pharetra pharetra massa massa. Ut placerat orci nulla pellentesque dignissim. Ultrices dui sapien eget mi proin. Sit amet nulla facilisi morbi tempus iaculis urna id. Sagittis eu volutpat odio facilisis mauris sit amet. Arcu non sodales neque sodales ut etiam sit amet. Ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Lobortis scelerisque fermentum dui faucibus in ornare. Massa sed elementum tempus egestas sed sed risus pretium quam. Faucibus vitae aliquet nec ullamcorper sit amet risus nullam eget. Egestas integer eget aliquet nibh praesent. Vitae nunc sed velit dignissim sodales ut eu sem. Morbi leo urna molestie at elementum eu facilisis sed odio. Ultrices eros in cursus turpis massa tincidunt dui. Lacus viverra vitae congue eu consequat ac felis donec et. Egestas egestas fringilla phasellus faucibus scelerisque. Sit amet est placerat in egestas erat. Nunc mi ipsum faucibus vitae.', 50, 0),
(60, 58, 'Aleksina Radionica 3', '2023-05-01 12:00:00', '10, Krunska, Vracar, Vracar Urban Municipality, Stari Grad Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4653, 44.8085, 'Likovna radionica za decu do 16 godina.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor lacus luctus accumsan tortor posuere. Sed tempus urna et pharetra pharetra massa massa. Ut placerat orci nulla pellentesque dignissim. Ultrices dui sapien eget mi proin. Sit amet nulla facilisi morbi tempus iaculis urna id. Sagittis eu volutpat odio facilisis mauris sit amet. Arcu non sodales neque sodales ut etiam sit amet. Ultrices gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Lobortis scelerisque fermentum dui faucibus in ornare. Massa sed elementum tempus egestas sed sed risus pretium quam. Faucibus vitae aliquet nec ullamcorper sit amet risus nullam eget. Egestas integer eget aliquet nibh praesent. Vitae nunc sed velit dignissim sodales ut eu sem. Morbi leo urna molestie at elementum eu facilisis sed odio. Ultrices eros in cursus turpis massa tincidunt dui. Lacus viverra vitae congue eu consequat ac felis donec et. Egestas egestas fringilla phasellus faucibus scelerisque. Sit amet est placerat in egestas erat. Nunc mi ipsum faucibus vitae.', 5, 1),
(61, 74, 'Petrova Radionica', '2023-01-26 00:00:00', '20, Краљице Марије, Младеновац (варош), Mladenovac Urban Municipality, City of Belgrade, Central Serbia, 11400, Serbia', 20.696, 44.4419, 'Petrova Radionica je najbolja!', 'Lorem ipsum.', 13, 0),
(62, 83, 'Lakijeve horor priče', '2023-06-10 20:00:00', '10, Miriјevski Boulevard, МЗ Карабурма-Дунав, Palilula, Palilula Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11060, Serbia', 20.5201, 44.8151, 'Horor radionica za decu 16-18 godina.', 'Lorem.', 20, 1),
(63, 104, 'Feđina Radionica', '2022-10-10 12:00:00', '20, Цвијићева, МЗ Надежда Петровић, Palilula, Palilula Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11060, Serbia', 20.4764, 44.8179, 'Kratak opis Feđine Radionice', 'Dugi opis Feđine Radionice', 20, 0),
(64, 104, 'Feđina Radionica', '2023-10-10 12:00:00', '20, Цвијићева, МЗ Надежда Петровић, Palilula, Palilula Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11060, Serbia', 20.4764, 44.8179, 'Kratak opis Feđine Radionice br 2', 'Dugi opis Feđine Radionice br 2', 20, 0),
(65, 104, 'Feđina Radionica2', '2023-10-10 12:00:00', '20, Цвијићева, МЗ Надежда Петровић, Palilula, Palilula Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11060, Serbia', 20.4764, 44.8179, 'Kratak opis Feđine Radionice sa drugim nazivom.', 'Dugi opis Feđine Radionice', 20, 2),
(66, 113, 'Ilijina Radionica', '2023-05-05 17:00:00', 'Tadeusa Koscuska, Dorcol, Old Town, Stari Grad Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4559, 44.8264, 'KO', 'DO', 10, 2),
(67, 76, 'Lukina Radionica', '2023-07-07 14:00:00', 'Baba Visnjina, Cubura, Vracar, Vracar Urban Municipality, Belgrade, City of Belgrade, Central Serbia, 11000, Serbia', 20.4749, 44.802, 'KOLR', 'DOLR', 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `workshop_like`
--

DROP TABLE IF EXISTS `workshop_like`;
CREATE TABLE IF NOT EXISTS `workshop_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `workshop_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_id` (`workshop_name`),
  KEY `workshop_like_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf32;

--
-- Dumping data for table `workshop_like`
--

INSERT INTO `workshop_like` (`id`, `user_id`, `workshop_name`) VALUES
(16, 59, 'Dusanova Radionica'),
(18, 64, 'Aleksina Radionica'),
(19, 72, 'Aleksina Radionica'),
(20, 61, 'Aleksina Radionica'),
(21, 69, 'Aleksina Radionica'),
(22, 70, 'Aleksina Radionica'),
(24, 116, 'Feđina Radionica'),
(26, 58, 'Dusanova Radionica');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password`
--
ALTER TABLE `password`
  ADD CONSTRAINT `password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workshop`
--
ALTER TABLE `workshop`
  ADD CONSTRAINT `workshop_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workshop_like`
--
ALTER TABLE `workshop_like`
  ADD CONSTRAINT `workshop_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
