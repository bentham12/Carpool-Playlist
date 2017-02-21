-- phpMyAdmin SQL Dump

-- version 4.6.5.2

-- https://www.phpmyadmin.net/

--

-- Host: 127.0.0.1

-- Generation Time: Feb 21, 2017 at 01:36 AM

-- Server version: 10.1.21-MariaDB

-- PHP Version: 5.6.30


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

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

-- Table structure for table `album`

--

CREATE TABLE `album` (

  `Source` varchar(255) NOT NULL,

  `Name` text NOT NULL

) ENGINE=InnoDB 
DEFAULT CHARSET=latin1;


-- --------------------------------------------------------


--

-- Table structure for table `playlist`

--

CREATE TABLE `playlist` (

  `ID` varchar(40) NOT NULL,

  `Name` varchar(250) NOT NULL,

  `CoverArt` tinytext NOT NULL,

  `Description` tinytext NOT NULL

) ENGINE=InnoDB 
DEFAULT CHARSET=latin1;


-- --------------------------------------------------------


--

-- Table structure for table `playlistsong`

--

CREATE TABLE `playlistsong` (

  `song_id_fk` varchar(255) NOT NULL,

  `playlist_id_fk` varchar(255) NOT NULL,

  `playlist_song_id` varchar(255) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------


--

-- Table structure for table `songs`

--

CREATE TABLE `songs` (

  `ID` varchar(40) NOT NULL,

  `Name` text NOT NULL,

  `AlbumCover` varchar(255) NOT NULL,

  `Artist` text NOT NULL

) ENGINE=InnoDB 
DEFAULT CHARSET=latin1;


-- --------------------------------------------------------


--

-- Table structure for table `vote_record`

--

CREATE TABLE `vote_record` (

  `user_id` varchar(250) NOT NULL,

  `decision` int(1) NOT NULL,

  `playlist_song_id` varchar(255) NOT NULL

) ENGINE=InnoDB 
DEFAULT CHARSET=latin1;


--

-- Indexes for dumped tables

--


--

-- Indexes for table `album`

--
ALTER TABLE `album`

  ADD PRIMARY KEY (`Source`);


--

-- Indexes for table `playlist`

--
ALTER TABLE `playlist`

  ADD PRIMARY KEY (`ID`);


--

-- Indexes for table `playlistsong`

--
ALTER TABLE `playlistsong`

  ADD PRIMARY KEY (`playlist_song_id`),

  ADD KEY `song_id_fk` (`song_id_fk`),

  ADD KEY `playlist_id_fk` (`playlist_id_fk`);


--

-- Indexes for table `songs`

--
ALTER TABLE `songs`

  ADD PRIMARY KEY (`ID`),

  ADD KEY `AlbumCover` (`AlbumCover`);


--

-- Indexes for table `vote_record`

--
ALTER TABLE `vote_record`

  ADD PRIMARY KEY (`playlist_song_id`);


--

-- Constraints for dumped tables

--


--

-- Constraints for table `playlistsong`

--
ALTER TABLE `playlistsong`

  ADD CONSTRAINT `playlistsong_ibfk_1` FOREIGN KEY (`song_id_fk`) REFERENCES `songs` (`ID`),

  ADD CONSTRAINT `playlistsong_ibfk_2` FOREIGN KEY (`playlist_id_fk`) REFERENCES `playlist` (`ID`),

  ADD CONSTRAINT `playlistsong_ibfk_3` FOREIGN KEY (`playlist_song_id`) REFERENCES `vote_record` (`playlist_song_id`);


--

-- Constraints for table `songs`

--
ALTER TABLE `songs`

  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`AlbumCover`) REFERENCES `album` (`Source`);


--

-- Constraints for table `vote_record`

--
ALTER TABLE `vote_record`

  ADD CONSTRAINT `vote_record_ibfk_1` FOREIGN KEY (`playlist_song_id`) REFERENCES `playlistsong` (`playlist_song_id`);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

