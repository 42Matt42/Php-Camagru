<?php
require_once 'database.php';
// $dbh = "Database Handle"
function setup($dbh,$DB_NAME)
{
	$sql = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME;
	$result = $dbh->exec($sql);
	$sql = "USE ". $DB_NAME;
	$result = $dbh->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `user` (
		`id_user` int(8) NOT NULL,
		`username` varchar(255) NOT NULL,
		`password` varchar(255) NOT NULL,
		`password2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
		`email` varchar(255) NOT NULL,
		`register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`user_group` int(1) NOT NULL DEFAULT '1',
		`key_new_account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
		`mail_new_account` int(1) NOT NULL DEFAULT '0',
		`key_reset` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$result = $dbh->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `picture` (
		`id_picture` int(8) NOT NULL,
		`id_user` int(8) NOT NULL,
		`picture` text NOT NULL,
		`picture_cam` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`picture_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='pictures'";
	$result = $dbh->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `comment` (
		`id_comment` int(11) NOT NULL,
		`id_user` int(8) NOT NULL,
		`id_picture` int(8) NOT NULL,
		`comment` tinytext NOT NULL,
		`comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$result = $dbh->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `love` (
		`id_love` int(11) NOT NULL,
		`id_user` int(8) NOT NULL,
		`id_picture` int(8) NOT NULL,
		`status` tinyint(1) NOT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `user`
	ADD PRIMARY KEY (`id_user`)";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `picture`
	ADD PRIMARY KEY (`id_picture`),
	ADD KEY `c_pictures_id_user` (`id_user`)";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `comment`
	ADD PRIMARY KEY (`id_comment`),
	ADD KEY `c_comments_id_picture` (`id_picture`),
	ADD KEY `c_comment_id_user` (`id_user`)";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `love`
	ADD PRIMARY KEY (`id_love`),
	ADD KEY `c_likes_id_picture` (`id_picture`),
	ADD KEY `c_likes_id_user` (`id_user`)";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `user`
	MODIFY `id_user` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `picture`
	MODIFY `id_picture` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `comment`
	MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `love`
	MODIFY `id_love` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `picture`
	ADD CONSTRAINT `c_pictures_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
  	COMMIT";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `comment`
	ADD CONSTRAINT `c_comment_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `c_comments_id_picture` FOREIGN KEY (`id_picture`) REFERENCES `picture` (`id_picture`) ON DELETE CASCADE ON UPDATE CASCADE";
	$result = $dbh->exec($sql);
	$sql = "ALTER TABLE `love`
	ADD CONSTRAINT `c_likes_id_picture` FOREIGN KEY (`id_picture`) REFERENCES `picture` (`id_picture`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `c_likes_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE";
	$result = $dbh->exec($sql);
	// Admin user creation with 'matt.saubin@gmail.com' / 'root' to log in
	$sql = "INSERT INTO user (username, password, email, mail_new_account) VALUES ('root', '$2y$10$4xq.IN/r2YZrvFrIbZWOheyc5lKX2R54B.7cG0oZu5l.5xcz6UpeC', 'matt.saubin@gmail.com', 1)";
	$result = $dbh->exec($sql);
}
$db = new PDO("mysql:host=$DB_SERVER", $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
setup($db,$DB_NAME);
unlink("../config/setup.php");
echo 'setup completed'.PHP_EOL;
?>
