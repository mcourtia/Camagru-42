<?php
session_start();
include "includes/header.php";
if ($_SESSION["nolog"] == 1)
{
?>
	<h1>Votre compte n'est pas encore activ&eacute</h1>
<?php
	$_SESSION["nolog"] = 0;
}
if ($_SESSION["nolog"] == 2)
{
?>
	<h1>Mauvais identifiant et/ou mot de passe</h1>
<?php
	$_SESSION["nolog"] = 0;
}
if ($_SESSION["nolog"] == 3)
{
?>
	<h1>Veuillez remplir tous les champs</h1>
<?php
	$_SESSION["nolog"] = 0;
}
if ($_SESSION["iscreate"] == 1)
{
?>
	<h1>Un mail de confirmation vous a &eacutet&eacute envoy&eacute !</h1>
<?php
	$_SESSION["iscreate"] = 0;
}
if ($_SESSION["isvalid"] == 1)
{
?>
	<h1>Votre compte est d&eacutej&agrave actif !</h1>
<?php
	$_SESSION["isvalid"] = 0;
}
if ($_SESSION["isvalid"] == 2)
{
?>
	<h1>Votre compte a bien &eacutet&eacute activ&eacute !<br />Vous pouvez maintenant vous connecter</h1>
<?php
	$_SESSION["isvalid"] = 0;
}
if ($_SESSION["isvalid"] == 3)
{
?>
	<h1>Erreur, votre compte ne peut &ecirctre activ&eacute...</h1>
<?php
	$_SESSION["isvalid"] = 0;
}
if ($_SESSION["reinit"] == 1)
{
?>
	<h1>Un mail de r&eacuteinitialisation vous a &eacutet&eacute envoy&eacute !</h1>
<?php
	$_SESSION["reinit"] = 0;
}
if ($_SESSION["reinit"] == 2)
{
?>
	<h1>R&eacuteinitialisation impossible</h1>
<?php
	$_SESSION["reinit"] = 0;
}
if ($_SESSION["reinit"] == 3)
{
?>
	<h1>Votre mot de passe a &eacutet&eacute r&eacuteinitialis&eacute</h1>
<?php
	$_SESSION["reinit"] = 0;
}
?>

<form action="login.php" method="post">
	Identifiant:&nbsp;&nbsp;&nbsp;&nbsp; <input name="login" />
	<br /><br />
	Mot de passe: <input name="passwd" type="password" />
	<br /><br />
	<input type="submit" name="submit" value="OK" />
	<br /><br />
	Pas de compte ? <a href="create.php">Inscrivez-vous</a>
	<br /><br />
	Mot de passe oubli&eacute ? <a href="checkmail.php">R&eacuteinitialisation</a>
	<br /><br />
<?php
include "includes/footer.php";
?>
