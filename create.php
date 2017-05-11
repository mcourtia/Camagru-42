<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (isset($_POST["submit"]))
{
	if ($_POST["submit"] === "OK" && $_POST["login"] && $_POST["passwd"] && $_POST["mail"])
	{
		$res = $db->query('SELECT login, passwd FROM users');
		while ($user = $res->fetch())
		{
			if ($user["login"] === $_POST["login"])
			{
				$verif = 1;
				$_SESSION["iscreate"] = 2;
				header("location: create.php");
			}
		}
		if ($verif != 1)
		{
			if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL))
			{
				$_SESSION["iscreate"] = 4;
				header("location: create.php");
			}
			else if (strlen($_POST["passwd"]) < 4)
			{
				$_SESSION["iscreate"] = 5;
				header("location: create.php");
			}
			else
			{
				$mdp = hash("whirlpool", $_POST["passwd"]);
				$req = $db->prepare('INSERT INTO users(login, mail, passwd) VALUES(?, ?, ?)');
				$req->execute(array(htmlspecialchars($_POST["login"]), $_POST["mail"], $mdp));
				$key = uniqid();
				$req = $db->prepare('UPDATE users SET activkey=:key WHERE login like :login');
				$req->bindParam(':key', $key);
				$req->bindParam(':login', $_POST["login"]);
				$req->execute();
				$dest = $_POST["mail"];
				$subj = "Activation de votre compte";
				$head = "From: inscription@camagru.com";
				$msg = "Bienvenue sur Camagru,\n\nPour activer votre compte, veuillez cliquer sur le lien\nci dessous ou copier/coller dans votre navigateur.\n\nhttp://localhost:8080/camagru/activation.php?log=".$_POST["login"]."&key=".$key."\n\n\n---------------------------------------------------------\nCeci est un mail automatique, merci de ne pas y repondre.";
				mail($dest, $subj, $msg, $head);
				$_SESSION["iscreate"] = 1;
				header("location: index.php");
			}
		}
	}
	else
	{
		$_SESSION["iscreate"] = 3;
		header("location: create.php");
	}
}

include "includes/header.php";
if ($_SESSION["iscreate"] == 2)
{
?>
<h1>Identifiant d&eacutej&agrave utilis&eacute, veuillez en choisir un autre</h1>
<?php
}
else if ($_SESSION["iscreate"] == 3)
{
?>
<h1>Veuillez remplir tous les champs</h1>
<?php
}
else if ($_SESSION["iscreate"] == 4)
{
?>
<h1>Adresse email invalide</h1>
<?php
}
else if ($_SESSION["iscreate"] == 5)
{
?>
<h1>Mot de passe trop court</h1>
<?php
}
?>
<form action="create.php" method="post">
	Identifiant:&nbsp;&nbsp;&nbsp;&nbsp; <input name="login" />
	<br /><br />
	Adresse mail: <input name="mail" />
	<br /><br />
	Mot de passe: <input name="passwd" type="password" />
	<br /><br />
	<input type="submit" name="submit" value="OK" />
	<br /><br />
</form>

<?php
include "includes/footer.php";
?>
