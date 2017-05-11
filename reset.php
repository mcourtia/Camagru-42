<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (isset($_POST["submit"]))
{
	if ($_POST["submit"] == "OK" && $_POST["passwd"])
	{
		if ($_GET['log'] && $_GET['key'])
		{
			$login = $_GET['log'];
			$key = $_GET['key'];
			$res = $db->query('SELECT login, activkey FROM users');
			while ($user = $res->fetch())
			{
				if ($login == $user["login"])
				{
					$keyy = $user["activkey"];
				}
			}
		}
		if ($key == $keyy)
		{
			$mdp = hash("whirlpool", $_POST["passwd"]);
			$req = $db->prepare('UPDATE users SET passwd=:passwd WHERE login like :login');
			$req->bindParam(':passwd', $mdp);
			$req->bindParam(':login', $_GET["log"]);
			$req->execute();
			$_SESSION["reinit"] = 3;
		}
	}
	else
	{
		$_SESSION["reinit"] = 2;
	}
}
else
{
	$_SESSION["reinit"] = 2;
}
header("location: index.php");
