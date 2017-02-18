-- phpMyAdmin SQL Dump

-- version 4.6.5.2

-- https://www.phpmyadmin.net/

--

-- Host: 127.0.0.1

-- Generation Time: Feb 18, 2017 at 11:39 PM

-- Server version: 10.1.21-MariaDB

-- PHP Version: 5.6.30

SET

SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET time_zone = "+00:00";





/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;



--

-- Database: `spotifyvotesdb`

--



-- --------------------------------------------------------



--

-- Table structure for table `vote_record`

--

CREATE TABLE `vote_record` (

  `song_id` varchar(250) NOT NULL,

  `playlist_id` varchar(250) NOT NULL,

  `user_id` varchar(250) NOT NULL,

  `decision` int(1) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

