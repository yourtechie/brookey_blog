-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 30, 2021 at 06:25 AM
-- Server version: 5.7.33-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brookey_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(15) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `email`, `phone`, `hash`, `date_created`, `time_created`) VALUES
(1, 'Bukola Ajayi', 'brookey@ajayi.com', 18291920, '$2y$10$f3IDNVeQfMn/DfFC3znJAuFc63DHtnYc3eJgDXpEVPIYLQ5hBWqa.', '2021-07-06', '11:07:24'),
(3, 'Mary Ajayi', 'maryweb.com', 3546789, '$2y$10$KO576ADtopxAPzXXI/sbv.e34OJfqBSNE3rhlndBDI0Wo0AdViDnS', '2021-07-06', '19:59:33'),
(4, 'Lens Sam', 'lens@gmail.com', 3456789, '$2y$10$Gj/7Pr41uJUYD1j0D76pdOSJQEb5pej1CN2wHhlA3RJeqOGipmchS', '2021-07-07', '19:24:28'),
(5, 'Esther Ajayi', 'esttybabe@gmail.com', 123897654, '$2y$10$WBMXYBRXlmywFF/YtvMVveKfAnkAipvoEbDVWAKByEWHgJKyOOO3i', '2021-07-08', '08:37:07'),
(6, 'Bukola', 'brookey@ajayi.com', 6768, '$2y$10$YAQmjIcVZp1WGs32se/zP.Uwx0nUr760MOO7a.1Ti/U40CuF8ijN6', '2021-07-16', '09:09:54');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(50) NOT NULL,
  `category` varchar(20) NOT NULL,
  `body` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `img` varchar(400) DEFAULT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `title`, `author`, `category`, `body`, `created_by`, `img`, `date_created`, `time_created`) VALUES
(5, 'I am so important!', 'Atinuke Ade', '2', 'Life can be so difficult and there are times whereby I just feel like giving up and alas I will always refuse to give in. You wanna know why?\r\n\r\nBecause I am stronger, bigger and better.', 3, NULL, '2021-07-09', '11:56:12'),
(6, 'How Easy Event Hosting Can Get In Nigeria', 'Peter Oyebanji', '1', 'We all know hosting events in Nigeria isn\'t the easiest of things, especially when you\'re a newbie. You worry about things that are absolutely within your control and things that are not within your control. You plan the event and come up with strategies to actualize the plan. And then you have to worry about factors like registration, ticket selling, and venue location. Planning and organization are factors that depend heavily on your effectiveness. However, factors like ease of registration and ticket buying - smooth check-in - and easy access to participants\' data do not. What / who you rely on to handle these activities can make, damage, or perfect your event. \r\n\r\nWhat if everything can be within your control? Imagine planning an event and having 100 percent control over how the event runs. No ticket sellers, no greeters, no intermediaries, just you and the participants. With AttendOut, you can actualize these fantasies. Now, you are probably wondering what AttendOut is and how it relates to this discussion. AttendOut is a secure event management platform with a wide range of services aimed at making your event excellently organized and enjoyable. Think of AttendOut as a platform that carries out all those activities that would have been departmentalized. \r\n\r\nFor instance, let us assume you want to organize an event about fintech in a remote area in Lagos. You already have the event planned and it is now time to worry about selling and managing the event. Here is where AttendOut comes in. AttendOut can take control of over 70 percent of what happens after this. With AttendOut, people can buy tickets to your events before and during the event. When people register for your event, AttendOut provides QR codes to them which means you can scan people into your event in a split second without worry. Since it is in a remote area, some participants may have difficulties getting to the event. AttendOut provides a direction to participants and a map to aid them in getting to the event location. If participants still canâ€™t get to the event location, AttendOut provides a way in which you can easily track participantâ€™s location from your phone. You can receive donations, host giveaways, and even monitor marketers on AttendOut if needed. Managing your event on AttendOut is like having a mobile cryptocurrency wallet. You have total control over your event just like you have total control over your cryptocurrencies. \r\n\r\nNow, that is not all. Data is where AttendOut takes it up a notch. AttendOut knows the importance of data before, during, and after the event. AttendOut uses CSV files to store data in various formats. What does this mean? You will get complete access to participantsâ€™ data and you can store them in any kind of format. This simplifies communication with participants in the sense that you can send messages in bulk about events and other essential issues. You can even keep emailing participants about future events or a service you offer. AttendOut payment is secured by Flutterwave and you can receive payments and donations in several currencies. \r\n\r\nAttendOut can be used by anyone in any way. Whether you are using AttendOut freely or at premium, hosting events get much easier. ', 1, NULL, '2021-07-10', '19:35:07'),
(7, 'Make me a star', 'Adewale Adeshola', '3', 'Why do I desire to be a star?\r\nWhat memories do you think comes along with it?\r\nWho do you wish knew I was a star?\r\nHow did you determine if I would be the best?', 1, NULL, '2021-07-21', '07:22:01'),
(9, 'Make me a star', 'Roname Philips', '2', 'if($type=="image/jpg" || $type==\'image/jpeg\' || $type==\'image/png\' || $type==\'image/gif\') //check file extension', 10, '16270323676.jpg', '2021-07-23', '09:26:07'),
(10, 'I LIKE MISS MARY', 'Roname Philips', '1', '<p>She is a good teacher</p>', 10, NULL, '2021-07-23', '09:32:00'),
(11, 'My Woman', 'Olufemi Samuel', '2', 'I go carry my woman we go fly away.\r\nBecause when money no dey na my woman dey.', 11, '16270432361.jpg', '2021-07-23', '12:27:16'),
(12, 'Money Must Be Made', 'Olufemi Samuel', '1', '                        Here is the success story of my life....\r\nStay tuned, you\'ll hear it soon.                      ', 11, '16270740992.jpg', '2021-07-23', '21:01:39'),
(15, 'Importance of Food', 'Olufemi Samuel', '1', '<p>Food is so important because every cell in the body depends on a continuous supply of calories and nutrients, whether obtained through food, IV nutrients, or tube feedings. Eating and food, however, also have symbolic <strong>meanings associated with love, sensuality, comfort, stress reduction, security, reward, and power</strong>.</p>', 11, '16274692372.jpg', '2021-07-24', '19:30:59'),
(16, 'Never Give Up!', 'BrookeyAjayi', '2', 'No matter what you are going through, never give up on your dreams.', 13, '1627221761Never-Give-Up-On-Your-Dreams1.png', '2021-07-25', '14:02:41'),
(17, 'Motivational Monday', 'Brookey Ajayi', '1', '<p>Itâ€™s the same reason I donâ€™t read books, because books intimidate me and remind me how dumb I am. Why should I waste time getting smarter or making peace with my insecurities, when I can just level the playing field and watch Digimon reruns with my [mentally challenged] cousin? That sounds like a Saturday to me! As Dom Mazzetti so eloquently put it: I donâ€™t want someone to enrich my life, I want someone to reassure me that my shitty life is adequate.</p>', 13, '1627551504math_board_1503009384-700x466-1.jpg', '2021-07-26', '21:26:17'),
(18, 'I Created a Post ', 'Esther Ajayi', '2', '                                                I created a post and now it is missing. How come?                                            ', 15, '1627462592Never-Give-Up-On-Your-Dreams1.png', '2021-07-27', '11:21:30'),
(19, 'Oh! What a Day Today!', 'Bukola Ajayi', '3', '<p>This morning feels so cool</p>\r\n<p>Like the angels moving in the morning</p>\r\n<p>Like dew shows itself to be cool</p>\r\n<p>Like clouds cool the morning</p>                                                                                        ', 1, '1627460574math_board_1503009384-700x466-1.jpg', '2021-07-28', '08:00:49'),
(20, 'Health is Everything', 'Bukola Ajayi', '1', '<h3>Healthy Body Equals Sexy Body</h3><p>Some women underestimate the power of healthy foods to be and remain sexy.</p><p>&nbsp;</p>', 1, '1627464669balance-1080x675.jpg', '2021-07-28', '09:17:47'),
(21, 'Beautiful', 'Brookey Ajayi', '3', '<p>Just acting beautiful like I desire</p><p>No way, but I discover beauty can be expensive</p><p>Some times been beautiful comes from the inside</p><p>But most times money makes it happen.</p>', 13, '1627626274femi.jpeg', '2021-07-29', '09:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_by`, `date_created`, `time_created`) VALUES
(1, 'Articles', 1, '2021-07-07', '19:05:34'),
(2, 'Stories', 3, '2021-07-07', '19:07:28'),
(3, 'Poems', 3, '2021-07-07', '19:11:40'),
(4, 'Lifestyle', 4, '2021-07-07', '19:25:11'),
(5, 'Spiritual', 5, '2021-07-08', '09:50:34'),
(6, 'Lyrics', 3, '2021-07-09', '09:55:52'),
(7, 'Love', 1, '2021-07-15', '12:04:53');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `blog_id` int(11) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `blog_id`, `poster`, `date_created`, `time_created`) VALUES
(1, 'Momma this is real!', 0, 'sam_123', '2021-07-25', '11:38:48'),
(2, 'I don\'t know why people feel expressing themselves this way is cool.', 15, 'sam_123', '2021-07-25', '11:47:40'),
(3, 'Oga, just confess say you like food.', 15, '', '2021-07-25', '12:40:25'),
(4, '@SQlite, you shouldn\'t talk that way to people. That\'s somewhat rude.', 15, '', '2021-07-25', '12:56:05'),
(5, 'Bro, you like money shaa.', 12, '', '2021-07-25', '12:58:00'),
(6, 'Drama is everywhere... Wahala no too much?', 15, 'Brookeycutie', '2021-07-25', '13:19:53'),
(7, 'My sister, this aint true. You love reading. I know you.', 17, 'EsttyBabe', '2021-07-27', '11:22:25'),
(8, 'Congrats, we can all see it.\r\n\r\n', 18, 'sam_123', '2021-07-28', '07:57:45');

-- --------------------------------------------------------

--
-- Table structure for table `dp_image`
--

CREATE TABLE `dp_image` (
  `dp_id` int(10) UNSIGNED NOT NULL,
  `dp_name` varchar(400) NOT NULL,
  `dp_userId` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dp_image`
--

INSERT INTO `dp_image` (`dp_id`, `dp_name`, `dp_userId`, `date_created`, `time_created`) VALUES
(1, '16275465191.jpg', 11, '2021-07-29', '08:15:19'),
(2, '16275472038.jpg', 11, '2021-07-29', '08:26:43'),
(3, '1627547307femi.jpeg', 11, '2021-07-29', '08:28:27'),
(4, '16275502211.jpg', 12, '2021-07-29', '09:17:01'),
(5, '16275502611.jpg', 12, '2021-07-29', '09:17:42'),
(6, '16275512202.jpg', 13, '2021-07-29', '09:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(10) UNSIGNED NOT NULL,
  `bio` text,
  `location` varchar(255) DEFAULT NULL,
  `fb_username` varchar(255) DEFAULT NULL,
  `in_username` varchar(255) DEFAULT NULL,
  `li_username` varchar(255) DEFAULT NULL,
  `profile_owner` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `bio`, `location`, `fb_username`, `in_username`, `li_username`, `profile_owner`, `date_created`, `time_created`) VALUES
(1, '', '', '', '', '', 7, '2021-07-21', '12:08:29'),
(2, 'I am a cool, easy, loving and gentle guy.\r\nIf you love in love with me do not be sorry.', 'Lekki, Lagos', 'sq@fb.com/sqlite', 'sq@insta/dae', 'linked/sq/fe/petrol', 7, '2021-07-21', '12:11:21'),
(3, 'I have a bright future, do you believe?', '', '', '', '', 7, '2021-07-21', '12:19:50'),
(4, 'I am me', 'ajah', '', '', '', 7, '2021-07-21', '13:10:41'),
(5, 'Talk again now', '', '', '', '', 7, '2021-07-21', '13:11:10'),
(6, 'I am a success! Now are everytime!', '', '', '', '', 7, '2021-07-21', '13:15:55'),
(7, 'I am so bright, that\'s why you should watch out for me.', 'Benin City', 'briter@fb.com', 'britergrammer_02', 'briter/linked/kings', 8, '2021-07-21', '18:05:25'),
(8, 'I am so bright, that\'s why you should watch out for me.', 'Benin City', 'briter@fb.com', 'britergrammer_02', 'briter/linked/kings000', 8, '2021-07-21', '18:23:39'),
(9, 'I am a success! Now and everytime!', 'Ado/odo Ota Sango Ogun State', 'sqlite@fblite.com', 'sq@insta/guy.com', 'linkers', 7, '2021-07-22', '07:30:45'),
(10, 'I am photo machine. I can do and will do anything with my camera.', 'Lekki', '@bigsam', '@bigsam', '@bigsam', 11, '2021-07-23', '12:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `user_name`, `hash`, `date_created`, `time_created`) VALUES
(11, 'Olufemi ', 'Samuel', 'sam@gmail.com', '08101963400', 'sam_123', '$2y$10$O85Br6.8N0t.FtATh6R1j.iPfM1RtiLu2wy7Dw.WAgDgdaxhyMh2S', '2021-07-23', '12:11:05'),
(12, 'Osaroname', 'Philips', 'roname@gmail.com', '0909292922', 'Roname_3310', '$2y$10$eeVdMXW7FTPISPcuS4tUfOcygZIrMskz1OI7exeDpWcDg0AUCUoqG', '2021-07-25', '13:17:38'),
(13, 'Brookey', 'Ajayi', 'brookey@gmail.com', '081010100101', 'Brookeycutie', '$2y$10$4LgeS4BrSyNJzis1AepU1OUlI6alY8tLhnt1BwEiKf7fnEru/ZDwO', '2021-07-25', '13:18:48'),
(14, 'Mariam', 'Alima', 'Al@gmail.com', '0897079', 'alima', '$2y$10$FmyfMofegmd/MD859ZRYiOkp4Iwuipsyob0hEmFBbIfarribv6E4S', '2021-07-25', '14:15:46'),
(15, 'Esther ', 'Ajayi', 'esttybabe@gmail.com', '09033234245', 'EsttyBabe', '$2y$10$sKHsNO/uFgen5du3VSjWY.W5hffm5anNEaaa9tcEfGp.gvvMm28TS', '2021-07-26', '21:28:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `dp_image`
--
ALTER TABLE `dp_image`
  ADD PRIMARY KEY (`dp_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `dp_image`
--
ALTER TABLE `dp_image`
  MODIFY `dp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
