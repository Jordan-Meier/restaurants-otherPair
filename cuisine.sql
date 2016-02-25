--
-- Database: `cuisine`
--
CREATE DATABASE IF NOT EXISTS `cuisine` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cuisine`;

-- --------------------------------------------------------

--
-- Table structure for table `cuisines`
--

CREATE TABLE `cuisines` (
  `name` varchar(255) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `name` varchar(255) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `cuisine_id` int(11) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_review`
--

CREATE TABLE `restaurant_review` (
  `review` varchar(255) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `res_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuisines`
--
ALTER TABLE `cuisines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `restaurant_review`
--
ALTER TABLE `restaurant_review`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cuisines`
--
ALTER TABLE `cuisines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_review`
--
ALTER TABLE `restaurant_review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
