<?php
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
session_start();

if ($_SESSION["log"] == 1)
{
	if ($_GET["img_id"])
	{
		$res = $db->query('SELECT id FROM images');
		while ($m = $res->fetch())
		{
			if ($m["id"] == $_GET["img_id"] && $m["user_id"] == $_SESSION["user_id"])
			{
				$verif = 1;
			}
		}
		if ($verif != 1)
		{
			header("location: error.php");
		}
		else
		{
			$req = $db->prepare('DELETE FROM images WHERE id like :id');
			$req->bindParam(':id', $_GET["img_id"]);
			$req->execute();
			unlink("gallery/".$_GET["img_id"].".png");
		}
	}
	include "includes/header.php";
	include "includes/log.php";
	echo "<br/><br/><b>Cliquer sur l'image &agrave supprimer</b><br/><br/>";
	$res = $db->query('SELECT * FROM images ORDER BY id DESC');
	while ($img = $res->fetch())
	{
		if ($img["user_id"] == $_SESSION["user_id"])
		{
			echo "<a href='delimg.php?img_id=".$img["id"]."'><img src='".$img["path"]."'></a><br/><br/>";
		}
	}
	include "includes/footer.php";
}
else
{
	include "nolog.php";
}
