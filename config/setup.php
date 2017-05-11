<?php
include "database.php";

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir")
					rmdir($dir."/".$object);
				else
					unlink($dir."/".$object);
			}
		}
	reset($objects);
	rmdir($dir);
	}
}

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("DROP DATABASE IF EXISTS db_camagru");
	$db->exec("CREATE DATABASE db_camagru");
	$sql = file_get_contents('setup_db.sql');
	$db->exec($sql);
	rrmdir('../tmp');
	mkdir('../tmp');
	rrmdir('../gallery');
	mkdir('../gallery');
}
catch (PDOException $e)
{
	echo $e->getMessage();
	die();
}
?>
