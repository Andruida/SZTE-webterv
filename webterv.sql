SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(320) NOT NULL,
  `name` varchar(300) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `services` bigint(20) NOT NULL,
  `way_of_contact` enum('PERSONAL','TEAMS','MEET') NOT NULL,
  `datetime` datetime NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `projects` (`id`, `name`, `description`) VALUES
(1, 'Echoes of Solitude', 'Egy szólamra épülő, minimalista darab, mely a magány hangjait idézi meg. A zene lassú tempója és az üres terek a hallgatót szólítják meg a saját gondolataikra.'),
(2, 'Dancing with the Moon', 'Egy szólamra épülő, minimalista darab, mely a magány hangjait idézi meg. A zene lassú tempója és az üres terek a hallgatót szólítják meg a saját gondolataikra.'),
(3, 'The Breath of Nature', 'Egy éjszakai tánc, mely a Holddal való társulásban rejlik. A zene magával ragadó ritmusa és a lebegő dallamok az éjszakai égboltot idézik.'),
(4, 'The Path of Destiny', 'Egy utazásra invitáló darab, mely a sors útját jelképezi. A zene dinamikus ritmusa és az erős szólamok a hallgatót a céljuk felé vezetik.'),
(5, 'Whispers of the Forest', 'Egy erdő hangjain alapuló darab, mely a fák susogását és a madarak dalát idézi meg. A zene nyugodt tempója és a finom dallamok a természet nyugalmát tükrözik.'),
(6, 'Dancing on the Moon', 'Egy éjszakai tánc, mely a Holddal való társulásban rejlik. A zene magával ragadó ritmusa és a lebegő dallamok az éjszakai égboltot idézik.'),
(7, 'The Tides of Emotion', 'Egy érzelmi hullámzásokra épülő darab, mely a víz mélységét idézi meg. A zene változatos tempója és a kifejező szólamok a hallgató érzelmi állapotának változásait tükrözik.'),
(8, 'The Heart of the Sun', 'Egy napfényes, energetikus darab, mely a nap erős sugarait idézi meg. A zene pezsdítő ritmusa és a fényes dallamok az életenergiát tükrözik.'),
(9, 'The Symphony of the Stars', 'Egy csillagokra épülő darab, mely a világűr titokzatos zenéjét idézi meg. A zene misztikus tempója és a fényes szólamok a csillagos éjszaka varázslatát tükrözik.'),
(10, 'The Flames of Passion', 'Egy lelkesedést és szenvedélyt tükröző darab, mely a tűz lángjait idézi meg. A zene lendületes tempója és az erős szólamok a hallgató lelkesedését és szenvedélyét tükrözik.'),
(11, 'The Echoes of Time', 'Egy idő inspirált darab, mely a múlt hangjait idézi meg. A zene lassú tempója és a régies szólamok a múlt emlékeit idézik meg a hallgatóban. A darab az idő múlásának és az emlékek őrzésének fontosságát hívja fel.'),
(12, 'It\'s a dog life out', 'Az It\'s a dog life out egy olyan mű, amely a kutyák mindennapi életét mutatja be humoros és érzelmes módon. Azt mutatja meg, hogy mennyi örömöt és nehézséget hozhat a kutyáinkkal való kapcsolat, valamint a kutyák érdekes és szívmelengető történeteit mutatja be.');

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(400) NOT NULL,
  `password` varchar(60) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `introduction` text DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
