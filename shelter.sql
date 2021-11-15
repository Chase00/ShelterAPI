-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2021 at 02:51 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shelter`
--

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `animal_ID` int(25) NOT NULL,
  `animal_name` varchar(25) NOT NULL,
  `animal_breed` varchar(40) NOT NULL,
  `animal_cost` decimal(10,0) NOT NULL,
  `adopted_boolean` tinyint(1) NOT NULL,
  `customer_ID` int(25) DEFAULT NULL,
  `animal_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`animal_ID`, `animal_name`, `animal_breed`, `animal_cost`, `adopted_boolean`, `customer_ID`, `animal_type`) VALUES
(1, 'Blaze', 'Bulldog', '100', 1, 1, 'dog'),
(2, 'Milo', 'Ragdoll', '120', 0, NULL, 'cat'),
(3, 'Charlie', 'German Shepherd', '300', 1, 5, 'dog'),
(4, 'Lucy', 'Maine Coon', '240', 1, 4, 'cat'),
(5, 'Max', 'Dobermann', '400', 0, NULL, 'dog'),
(6, 'Bella', 'Persian', '350', 1, 2, 'cat'),
(7, 'Spot', 'Hound', '115', 0, NULL, 'dog');

-- --------------------------------------------------------

--
-- Table structure for table `animalfood`
--

CREATE TABLE `animalfood` (
  `animalFood_ID` int(25) NOT NULL,
  `animalFood_type` varchar(30) NOT NULL,
  `animalFood_description` varchar(200) NOT NULL,
  `animalFood_price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animalfood`
--

INSERT INTO `animalfood` (`animalFood_ID`, `animalFood_type`, `animalFood_description`, `animalFood_price`) VALUES
(1, 'Pedigree', 'Adult Complete Nutrition Roasted Chicken, Rice & Vegetable Flavor Dry Dog Food.', '21.48'),
(2, 'Blue Buffalo', 'Life Protection Formula Adult Chicken & Brown Rice Recipe Dry Dog Food.', '52.89'),
(3, 'Cat Chow', 'Naturals Indoor with Real Chicken & Turkey Dry Cat Food', '16.99'),
(4, 'ORIJEN', 'Original Grain-Free Dry Cat Food.', '28.99'),
(5, 'Iams', 'Adult MiniChunks Small Kibble High Protein Dry Dog Food', '29.99'),
(6, 'American journey', 'Salmon & Sweet Potato Recipe Grain-Free Dry Dog Food.', '44.99');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_ID` int(25) NOT NULL,
  `customer_name` varchar(40) NOT NULL,
  `customer_age` tinyint(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_ID`, `customer_name`, `customer_age`, `customer_phone`) VALUES
(1, 'Bill', 25, '317-444-4444'),
(2, 'Viola', 30, '444-555-5555'),
(3, 'Rick Novak', 23, '333-333-3333'),
(4, 'Susan Conner', 26, '123-123-1234'),
(5, 'Roger Lum', 40, '987-654-3210'),
(6, 'Mason Young', 19, '898-010-2354');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_ID` int(25) NOT NULL,
  `employee_first_name` varchar(20) NOT NULL,
  `employee_last_name` varchar(20) NOT NULL,
  `employee_date_joined` date NOT NULL,
  `position_ID` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_ID`, `employee_first_name`, `employee_last_name`, `employee_date_joined`, `position_ID`) VALUES
(1, 'Joe', 'Angel', '2021-10-01', 1),
(2, 'Chris', 'Oli', '2021-09-10', 2),
(3, 'Ronald', 'Barr', '2021-08-11', 3),
(4, 'Jeff ', 'Johnson', '2021-09-01', 4),
(5, 'Lena', 'Smith', '2021-08-04', 5);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_ID` int(25) NOT NULL,
  `position_title` varchar(30) NOT NULL,
  `position_salary` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_ID`, `position_title`, `position_salary`) VALUES
(1, 'Manager Animal', 72145),
(2, 'Animal Control Director', 67916),
(3, 'Director Animal', 74951),
(4, 'Animal Health Officer', 68113),
(5, 'Director Animal Science', 64925);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`animal_ID`),
  ADD KEY `customer_ID` (`customer_ID`);

--
-- Indexes for table `animalfood`
--
ALTER TABLE `animalfood`
  ADD PRIMARY KEY (`animalFood_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_ID`),
  ADD KEY `position_ID` (`position_ID`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `animal_ID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `animalfood`
--
ALTER TABLE `animalfood`
  MODIFY `animalFood_ID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_ID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`customer_ID`) REFERENCES `customer` (`customer_ID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`position_ID`) REFERENCES `position` (`position_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
