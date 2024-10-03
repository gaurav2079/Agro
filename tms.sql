

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";






CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', 'f925916e2754e5e03f75dd58a5733251', '2023-03-11 11:18:49');



CREATE TABLE `tblbooking` (
  `BookingId` int(11) NOT NULL,
  `PackageId` int(11) DEFAULT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `FromDate` varchar(100) DEFAULT NULL,
  `ToDate` varchar(100) DEFAULT NULL,
  `Comment` mediumtext DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `CancelledBy` varchar(5) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblbooking` (`BookingId`, `PackageId`, `UserEmail`, `FromDate`, `ToDate`, `Comment`, `RegDate`, `status`, `CancelledBy`, `UpdationDate`) VALUES
(1, 1, 'test@gmail.com', '2020-07-11', '2020-07-18', 'I want this package.', '2020-07-08 06:38:36', 2, 'u', '2020-07-08 06:53:45');



CREATE TABLE `tblenquiry` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `tblenquiry` (`id`, `FullName`, `EmailId`, `MobileNumber`, `Subject`, `Description`, `PostingDate`, `Status`) VALUES
(4, 'rakshit shetty', 'rajath.g.acahri@gmail.com', '8884926140', 'issue', 'Can\'t book .', '2023-01-17 14:02:09', 1);



CREATE TABLE `tblissues` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `Issue` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminremarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblissues` (`id`, `UserEmail`, `Issue`, `Description`, `PostingDate`, `AdminRemark`, `AdminremarkDate`) VALUES
(1, NULL, NULL, NULL, '2020-07-08 06:33:20', NULL, NULL);



CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT '',
  `detail` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO `tblpages` (`id`, `type`, `detail`) VALUES
(3, 'aboutus', '<div><span style=\"color: rgb(0, 0, 0); font-family: Georgia; font-size: 15px; text-align: justify; font-weight: bold;\">Welcome to Agro Tourism!!!</span></div><span style=\"font-family: &quot;courier new&quot;;\"><span style=\"color: rgb(0, 0, 0); font-size: 15px; text-align: justify;\">Our  Agro-tourism startup located in the rolling hills of the countryside. Our mission is to provide visitors with an authentic and sustainable farming experience that promotes education, community, and environmental stewardship.

Our farm is a working model of regenerative agriculture, featuring a diverse range of crops and livestock raised without harmful chemicals or synthetic inputs. Visitors can participate in a variety of activities, including farm tours, workshops on organic gardening and sustainable farming practices, and farm-to-table dining experiences featuring our farm-fresh produce and meats.

At Green Fields, we believe that agro-tourism has the power to transform our food system by fostering a deeper connection between consumers and their food. By sharing our farming practices and values with our visitors, we hope to inspire a new generation of farmers and conscious eaters.

Whether youre a foodie looking for the freshest ingredients, an educator interested in sustainable agriculture, or a family seeking a fun and educational outing, Green Fields has something for you. We look forward to welcoming you to our farm and sharing the joys of Agro-tourism with you!" </span><span style=\"color: rgb(80, 80, 80); font-size: 13px;\">\</span></span>'),
(11, 'contact', '																				<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Address: Mangaluru</span>');



CREATE TABLE `tbltourpackages` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(200) DEFAULT NULL,
  `PackageType` varchar(150) DEFAULT NULL,
  `PackageLocation` varchar(100) DEFAULT NULL,
  `PackagePrice` int(11) DEFAULT NULL,
  `PackageFetures` varchar(255) DEFAULT NULL,
  `PackageDetails` mediumtext DEFAULT NULL,
  `PackageImage` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `tbltourpackages` (`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackagePrice`, `PackageFetures`, `PackageDetails`, `PackageImage`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Agricultural Workshop', 'Group Package', 'Mangalore', 6000, 'Pickup-Drop Facility, Food ,Accommodation', 'Our agricultural workshop package is designed to provide participants with hands-on learning experiences, expert speakers, and field trips to local farms and research centers. Throughout the workshop, participants will engage in interactive sessions, network with other professionals in the industry, and develop practical skills that can be used in their work.\r\nThe workshop will focus on a variety of topics, such as soil health, crop management, livestock care, and marketing strategies. Participants will have the opportunity to learn about new technologies and innovations in agriculture, such as precision farming and vertical farming, and apply them to their work.\r\nIn addition to hands-on activities and interactive sessions, the workshop will provide participants with educational materials such as handouts and guides to help them continue their learning after the workshop. The workshop is customizable to meet the specific needs of different groups or organizations, such as tailoring the content to focus on specific crops or livestock.', 'pexels-sajal\'s-gallery-7415326.jpg', '2020-07-08 05:21:58', '2023-04-14 19:33:12'),
(2, 'Rural Home Stay Package', 'Family Package', 'Kerala', 10000, 'Free Wi-fi, Free Breakfast, Free Pickup and drop facility ', 'Visit to Fields & Villages | Complimentary services of a Professional Guide ,Rural home stay package offers guests an opportunity to experience the unique culture and lifestyle of rural areas.\r\nThe package includes accommodation in a traditional rural home with modern amenities.\r\nGuests can participate in various activities such as farming, fishing, and cooking local dishes.\r\nThe package allows guests to interact with local communities and learn about their traditions and customs.\r\nRural home stays promote sustainable tourism and support the local economy.\r\nThe package provides an authentic travel experience and a break from the urban lifestyle.\r\nGuests can enjoy the scenic beauty of rural areas and indulge in nature-based activities.\r\nThe package can be customized to meet specific needs and preferences of guests.\r\nRural home stays are suitable for families, solo travelers, and groups.\r\nThe package offers a peaceful and relaxing environment away from the hustle and bustle of city life.', 'pexels-iconcom-733200.jpg', '2020-07-08 05:37:40', '2023-04-14 19:41:14'),
(3, 'Agri-Tour Package For Kids', 'KIds', 'Sonipat', 5000, 'Pickup and drop facility, Food, Professional guide', 'Agricultural tours for kids provide hands-on learning experiences in a fun and engaging way.\r\nThe package includes visits to local farms, orchards, and gardens to learn about farming and cultivation.\r\nKids will learn about the lifecycle of plants and animals, and how they contribute to our food system.\r\nThe package offers opportunities for kids to participate in activities such as harvesting, planting, and feeding animals.\r\nThe tour educates kids about the importance of sustainability and the environment.\r\nThe package includes educational materials to reinforce the learning experience after the tour.\r\nThe tour can be customized to suit different age groups and learning objectives.\r\nThe package helps to develop children\'s appreciation for agriculture and farming.\r\nThe tour promotes healthy eating habits and a connection to nature.\r\nThe package provides a unique and enriching experience for children that they will remember for a long time', 'pexels-quang-nguyen-vinh-6713506.jpg', '2020-07-08 05:41:07', '2023-04-14 19:44:36'),
(4, 'Harvest Festival Package', 'Family & Friends Package', 'Jalandhar', 10000, 'Free pick up and drop facility, Free Stay', 'A harvest festival package celebrates the autumn harvest season and provides a unique cultural experience.\r\nThe package includes farm visits, pumpkin patches, hayrides, and corn mazes for an authentic farm experience.\r\nThe festival package offers a variety of seasonal foods, such as apple cider, pies, and roasted corn.\r\nVisitors can participate in fun and engaging activities like face painting, crafts, and games for all ages.\r\nThe festival offers live music, entertainment, and dancing for a festive atmosphere.\r\nThe package can be customized to cater to different group sizes, ages, and preferences.\r\nThe festival is a great way to support local agriculture and learn about the importance of farming in our communities.\r\nVisitors can purchase locally grown produce, handmade crafts, and artisanal products from vendors at the festival.\r\nThe harvest festival package offers an immersive experience that creates lasting memories for individuals and families.\r\nThe festival package provides a fun and educational way to celebrate the bounties of the harvest season.\r\nI hope this summary meets your requirements. If you have any further questions or concerns, feel free to let me know.', 'india-family-farming-harvesting-crops-concept-56684831.jpg', '2020-07-08 05:45:58', '2023-04-14 19:50:10'),
(5, 'Wine Tasting Tour', 'Single', 'Goa', 4000, 'Pick-Drop Facility, Accommodation', 'The wine tasting package provides an opportunity to discover new wine flavors and learn about the wine-making process. Visitors can enjoy a guided tour of a vineyard or winery, see the vineyards and production facilities, and learn about the history of winemaking. During the tour, visitors can participate in a wine tasting session and learn about the characteristics of different types of wines. The package offers a fun and educational experience for wine lovers and enthusiasts. Visitors can purchase wines from the vineyard or winery to take home with them. The package can be customized to cater to different group sizes and preferences. The wine tasting package promotes responsible wine consumption and highlights the importance of sustainable and ethical winemaking practices. The package can be enjoyed by individuals, couples, or groups of friends and family. The wine tasting package is a great way to connect with nature, learn about local agriculture, and experience the beauty of vineyards and wineries.', 'pexels-cottonbro-studio-5537783.jpg', '2020-07-08 05:49:13', '2023-04-14 19:58:54'),
(6, 'Field to Table Package', 'Group', 'Bhatkal', 10000, 'Free Breakfast, Free Pick up drop facility, Free Accommodation ', 'The \"Field to Table\" package offers an immersive experience in farm-to-table cuisine. Visitors can participate in activities such as harvesting fruits and vegetables, collecting eggs, and feeding livestock. The package also includes cooking classes with local chefs, who teach visitors how to create delicious and healthy meals using fresh, seasonal ingredients. Visitors can enjoy meals made with the ingredients they have harvested, and learn about sustainable farming practices. The package provides a unique opportunity to connect with nature and learn about the food production process. Visitors can enjoy the scenic views and peaceful environment of the farm. The package is suitable for individuals, couples, or families, and can be customized to cater to different preferences and needs. The \"Field to Table\" package promotes healthy eating habits and highlights the importance of sustainable and ethical farming practices.', 'pexels-michael-fischer-614006.jpg', '2020-07-08 05:51:26', '2023-04-14 20:11:05');




CREATE TABLE `tbltourproducts` (
  `ProductId` int(11) NOT NULL,
  `ProductName` varchar(200) DEFAULT NULL,
  `ProductType` varchar(150) DEFAULT NULL,
  `ProductLocation` varchar(100) DEFAULT NULL,
  `ProductPrice` int(11) DEFAULT NULL,
  `ProductFetures` varchar(255) DEFAULT NULL,
  `ProductDetails` mediumtext DEFAULT NULL,
  `ProductImage` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




INSERT INTO `tbltourproducts` (`ProductId`, `ProductName`, `ProductType`, `ProductLocation`, `ProductPrice`, `ProductFetures`, `ProductDetails`, `ProductImage`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Agricultural Workshop', 'Group Package', 'Mangalore', 6000, 'Pickup-Drop Facility, Food ,Accommodation', 'Our agricultural workshop package is designed to provide participants with hands-on learning experiences, expert speakers, and field trips to local farms and research centers. Throughout the workshop, participants will engage in interactive sessions, network with other professionals in the industry, and develop practical skills that can be used in their work.\r\nThe workshop will focus on a variety of topics, such as soil health, crop management, livestock care, and marketing strategies. Participants will have the opportunity to learn about new technologies and innovations in agriculture, such as precision farming and vertical farming, and apply them to their work.\r\nIn addition to hands-on activities and interactive sessions, the workshop will provide participants with educational materials such as handouts and guides to help them continue their learning after the workshop. The workshop is customizable to meet the specific needs of different groups or organizations, such as tailoring the content to focus on specific crops or livestock.', '7.jpg', '2020-07-08 05:21:58', '2023-04-14 19:33:12'),
(2, 'Apple', 'Family Package', 'Kerala', 10000, 'Free Wi-fi, Free Breakfast, Free Pickup and drop facility ', 'Visit to Fields & Villages | Complimentary services of a Professional Guide ,Rural home stay package offers guests an opportunity to experience the unique culture and lifestyle of rural areas.\r\nThe package includes accommodation in a traditional rural home with modern amenities.\r\nGuests can participate in various activities such as farming, fishing, and cooking local dishes.\r\nThe package allows guests to interact with local communities and learn about their traditions and customs.\r\nRural home stays promote sustainable tourism and support the local economy.\r\nThe package provides an authentic travel experience and a break from the urban lifestyle.\r\nGuests can enjoy the scenic beauty of rural areas and indulge in nature-based activities.\r\nThe package can be customized to meet specific needs and preferences of guests.\r\nRural home stays are suitable for families, solo travelers, and groups.\r\nThe package offers a peaceful and relaxing environment away from the hustle and bustle of city life.', 'pexels-iconcom-733200.jpg', '2020-07-08 05:37:40', '2023-04-14 19:41:14'),
(3, 'Agri-Tour Package For Kids', 'KIds', 'Sonipat', 5000, 'Pickup and drop facility, Food, Professional guide', 'Agricultural tours for kids provide hands-on learning experiences in a fun and engaging way.\r\nThe package includes visits to local farms, orchards, and gardens to learn about farming and cultivation.\r\nKids will learn about the lifecycle of plants and animals, and how they contribute to our food system.\r\nThe package offers opportunities for kids to participate in activities such as harvesting, planting, and feeding animals.\r\nThe tour educates kids about the importance of sustainability and the environment.\r\nThe package includes educational materials to reinforce the learning experience after the tour.\r\nThe tour can be customized to suit different age groups and learning objectives.\r\nThe package helps to develop children\'s appreciation for agriculture and farming.\r\nThe tour promotes healthy eating habits and a connection to nature.\r\nThe package provides a unique and enriching experience for children that they will remember for a long time', 'pexels-quang-nguyen-vinh-6713506.jpg', '2020-07-08 05:41:07', '2023-04-14 19:44:36'),
(4, 'Harvest Festival Package', 'Family & Friends Package', 'Jalandhar', 10000, 'Free pick up and drop facility, Free Stay', 'A harvest festival package celebrates the autumn harvest season and provides a unique cultural experience.\r\nThe package includes farm visits, pumpkin patches, hayrides, and corn mazes for an authentic farm experience.\r\nThe festival package offers a variety of seasonal foods, such as apple cider, pies, and roasted corn.\r\nVisitors can participate in fun and engaging activities like face painting, crafts, and games for all ages.\r\nThe festival offers live music, entertainment, and dancing for a festive atmosphere.\r\nThe package can be customized to cater to different group sizes, ages, and preferences.\r\nThe festival is a great way to support local agriculture and learn about the importance of farming in our communities.\r\nVisitors can purchase locally grown produce, handmade crafts, and artisanal products from vendors at the festival.\r\nThe harvest festival package offers an immersive experience that creates lasting memories for individuals and families.\r\nThe festival package provides a fun and educational way to celebrate the bounties of the harvest season.\r\nI hope this summary meets your requirements. If you have any further questions or concerns, feel free to let me know.', 'india-family-farming-harvesting-crops-concept-56684831.jpg', '2020-07-08 05:45:58', '2023-04-14 19:50:10'),
(5, 'Wine Tasting Tour', 'Single', 'Goa', 4000, 'Pick-Drop Facility, Accommodation', 'The wine tasting package provides an opportunity to discover new wine flavors and learn about the wine-making process. Visitors can enjoy a guided tour of a vineyard or winery, see the vineyards and production facilities, and learn about the history of winemaking. During the tour, visitors can participate in a wine tasting session and learn about the characteristics of different types of wines. The package offers a fun and educational experience for wine lovers and enthusiasts. Visitors can purchase wines from the vineyard or winery to take home with them. The package can be customized to cater to different group sizes and preferences. The wine tasting package promotes responsible wine consumption and highlights the importance of sustainable and ethical winemaking practices. The package can be enjoyed by individuals, couples, or groups of friends and family. The wine tasting package is a great way to connect with nature, learn about local agriculture, and experience the beauty of vineyards and wineries.', 'pexels-cottonbro-studio-5537783.jpg', '2020-07-08 05:49:13', '2023-04-14 19:58:54'),
(6, 'Field to Table Package', 'Group', 'Bhatkal', 10000, 'Free Breakfast, Free Pick up drop facility, Free Accommodation ', 'The \"Field to Table\" package offers an immersive experience in farm-to-table cuisine. Visitors can participate in activities such as harvesting fruits and vegetables, collecting eggs, and feeding livestock. The package also includes cooking classes with local chefs, who teach visitors how to create delicious and healthy meals using fresh, seasonal ingredients. Visitors can enjoy meals made with the ingredients they have harvested, and learn about sustainable farming practices. The package provides a unique opportunity to connect with nature and learn about the food production process. Visitors can enjoy the scenic views and peaceful environment of the farm. The package is suitable for individuals, couples, or families, and can be customized to cater to different preferences and needs. The \"Field to Table\" package promotes healthy eating habits and highlights the importance of sustainable and ethical farming practices.', 'pexels-michael-fischer-614006.jpg', '2020-07-08 05:51:26', '2023-04-14 20:11:05');
























CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `EmailId` varchar(70) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `tblusers` (`id`, `FullName`, `MobileNumber`, `EmailId`, `Password`, `RegDate`, `UpdationDate`) VALUES
(1, 'Manju Srivatav', '4456464654', 'manju@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-07-08 06:33:20', NULL);


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`BookingId`);


ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tblissues`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);



ALTER TABLE `tbltourproducts`
  ADD PRIMARY KEY (`ProductId`);



ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`),
  ADD KEY `EmailId_2` (`EmailId`);



ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tblbooking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `tblenquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `tblissues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;



ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;


ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `tbltourproducts`
  MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

