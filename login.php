<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if ($_POST["login"] && $_POST["passwd"] && $_POST["submit"] === "OK")
{
	$res = $db->query('SELECT * FROM users');
	while ($user = $res->fetch())
	{
		$passwd = hash("whirlpool", $_POST["passwd"]);
		if ($user["login"] === $_POST["login"] && $user["passwd"] === $passwd)
		{
			if ($user["active"] == 1)
			{
				$_SESSION["loggued_on_user"] = $user["login"];
				$_SESSION["user_id"] = $user["id"];
				$_SESSION["admin"] = $user["admin"];
				$_SESSION["log"] = 1;
				$verif = 1;
				header ("location: main.php");
			}
			else
			{
				$verif = 2;
			}
		}
	}
	if ($verif != 1)
	{
		if ($verif == 2)
		{
			$_SESSION["nolog"] = 1;
		}
		else
		{
			$_SESSION["nolog"] = 2;
		}
		header ("location: index.php");
	}
}
else
{
	$_SESSION["nolog"] = 3;
	header ("location: index.php");
}

?>
