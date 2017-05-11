<?php
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
session_start();

if ($_SESSION["log"] == 1)
{
	$req = $db->prepare('DELETE FROM users WHERE login like :login');
	$req->bindParam(':login', $_SESSION["loggued_on_user"]);
	$req->execute();
	$req = $db->prepare('DELETE FROM images WHERE user_id like :user_id');
	$req->bindParam(':user_id', $_SESSION["user_id"]);
	$req->execute();
	$req = $db->prepare('DELETE FROM comments WHERE user_log like :user_log');
	$req->bindParam(':user_log', $_SESSION["loggued_on_user"]);
	$req->execute();
	$req = $db->prepare('DELETE FROM likes WHERE user_like like :user_like');
	$req->bindParam(':user_like', $_SESSION["loggued_on_user"]);
	$req->execute();
	header("location: logout.php");
}
else
{
	include "nolog.php";
}
