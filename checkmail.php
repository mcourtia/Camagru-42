<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (isset($_POST["submit"]))
{
	if ($_POST["submit"] === "OK" && $_POST["login"] && $_POST["mail"])
	{
		$res = $db->query('SELECT login, mail, activkey FROM users');
		while ($user = $res->fetch())
		{
			if ($user["mail"] == $_POST["mail"] && $user["login"] == $_POST["login"])
			{
				$verif = 1;
				$key = $user["activkey"];
				$login = $_POST["login"];
			}
		}
		if ($verif == 1)
		{
			$dest = $_POST["mail"];
			$subj = "Reinitialisation du mot de passe";
			$head = "From: reinit@camagru.com";
			$msg = "Bonjour cher utilisateur,\n\nPour reinitialiser votre mot de passe, veuillez cliquer sur le lien\nci dessous ou copier/coller dans votre navigateur.\n\nhttp://localhost:8080/camagru/reinit.php?log=".$login."&key=".$key."\n\n\n-----------------------------------------------------\nCeci est un mail automatique, merci de ne pas y repondre.";
			mail($dest, $subj, $msg, $head);
			$_SESSION["reinit"] = 1;
			header("location: index.php");
		}
		else
		{
			$_SESSION["reinit"] = 2;
			header("location: checkmail.php");
		}
	}
	else
	{
		$_SESSION["reinit"] = 3;
		header("location: checkmail.php");
	}
}

include "includes/header.php";
if ($_SESSION["reinit"] == 2)
{
?>
<h1>L'identifiant et/ou l'email ne sont pas reconnus.</h1>
<?php
$_SESSION["reinit"] = 0;
}
else if ($_SESSION["reinit"] == 3)
{
?>
<h1>Veuillez remplir tous les champs</h1>
<?php
$_SESSION["reinit"] = 0;
}
?>
<form action="checkmail.php" method="post">
	Identifiant: <input name= "login" />
	<br /><br />
	Adresse mail: <input name="mail" />
	<br /><br />
	<input type="submit" name="submit" value="OK" />
	<br /><br />
</form>

<?php
include "includes/footer.php";
?>
