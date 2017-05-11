<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

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
	if ($key == $keyy)
	{
		include "includes/header.php";
		?>
		<form action="reset.php?log=<?php echo $login ?>&key=<?php echo $key ?>" method="post">
			Identifiant: <?php echo $login ?>
			<br /><br />
			Nouveau mot de passe: <input name="passwd" type="password" />
			<br /><br />
			<input type="submit" name="submit" value="OK" />
			<br /><br />
		</form>
		<?php
		include "includes/footer.php";
	}
	else
	{
		$_SESSION["reinit"] = 2;
		header("location: index.php");
	}
}
else
{
	$_SESSION["reinit"] = 2;
	header("location: index.php");
}
?>
