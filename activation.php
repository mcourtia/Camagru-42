<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$login = $_GET['log'];
$key = $_GET['key'];

$res = $db->query('SELECT login, activkey, active FROM users');
while ($user = $res->fetch())
{
	if ($login == $user["login"])
	{
		$active = $user["active"];
		$keyy = $user["activkey"];
	}
}
if ($active == '1')
{
	$_SESSION["isvalid"] = 1;
}
else
{
	if ($key == $keyy)
	{
		$_SESSION["isvalid"] = 2;
		$req = $db->prepare("UPDATE users SET active = 1 WHERE login like :login");
		$req->bindParam(':login', $login);
		$req->execute();
	}
	else
	{
		$_SESSION["isvalid"] = 3;
	}
}
header("location: index.php");
?>
