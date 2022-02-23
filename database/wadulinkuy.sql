-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 23, 2022 at 01:39 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wadulinkuy`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `comment` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id_comment`, `id_post`, `nama`, `comment`) VALUES
(1, 2, 'hilmi', 0x697961612073617961206a756761206d656e67616c616d692068616c2079616e672073616d61),
(2, 2, 'Bima Setyawan', 0x4b656d6172696e2073617961206b6563656c616b61616e2064696b6172656e616b616e2068616c207465727365627574),
(3, 3, 'R Hilmi', 0x53656d6f6761205365676572612044697065726261696b69),
(4, 2, 'Anang', 0x53656d6f6761204c656b61732044697065726261696b69);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `nama_pengirim` varchar(255) NOT NULL,
  `img` varchar(1000) NOT NULL,
  `section` blob NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id_post`, `title`, `nama_pengirim`, `img`, `section`, `status`) VALUES
(2, 'Lampu Merah Rusak Jl Galunggung', 'rey', 'lampuMerah.jpeg', 0x6c616d7075206d65726168206469206a616c616e2067616c756e6767756e672073756461682033206861726920727573616b2064616e2073656c616c75206d656e696d62756c6b616e206b656d61636574616e20646920706167692068617269, 0),
(3, 'Jalan Semeru berlubang parah', 'haris', 'jalanRusak.jpg', 0x73756461682073617475206d696e676775206c65626968206a616c616e206265726c7562616e6720696e69206d656e6767616e676775207361796120736562616761692070656e67656e646172612073657065646168206d6f746f72, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
