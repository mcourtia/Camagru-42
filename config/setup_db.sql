SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

USE db_camagru;

CREATE TABLE IF NOT EXISTS `comments` (`id` int(11) NOT NULL, `com` varchar(255) NOT NULL, `user_log` varchar(255) NOT NULL, `img_id` int(11) NOT NULL, `date` varchar(255) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `images` (`id` int(11) NOT NULL, `path` varchar(255) NOT NULL, `user_id` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `likes` (`id` int(11) NOT NULL, `img_like` int(11) NOT NULL, `user_like` varchar(255) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (`id` int(11) NOT NULL, `login` varchar(255) NOT NULL, `passwd` varchar(255) NOT NULL, `mail` varchar(255) NOT NULL, `activkey` varchar(32) DEFAULT NULL, `active` int(11) DEFAULT NULL, `admin` int(11) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `login`, `passwd`, `mail`, `activkey`, `active`, `admin`) VALUES (1, 'admin', '6a4e012bd9583858a5a6fa15f58bd86a25af266d3a4344f1ec2018b778f29ba83be86eb45e6dc204e11276f4a99eff4e2144fbe15e756c2c88e999649aae7d94', 'maxcourtiau@gmail.com', '5849e5950b67b', 1, 1);

ALTER TABLE `comments` ADD PRIMARY KEY (`id`);

ALTER TABLE `images` ADD PRIMARY KEY (`id`);

ALTER TABLE `likes` ADD PRIMARY KEY (`id`);

ALTER TABLE `users` ADD PRIMARY KEY (`id`);

ALTER TABLE `comments` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `images` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `likes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
