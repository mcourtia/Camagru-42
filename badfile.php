<?php
session_start();

include "includes/header.php";
include "includes/log.php";
if ($_GET["er"] == 1)
{
	echo "<h1>Une erreur est servenue</h1>";
}
else if ($_GET["er"] == 2)
{
	echo "<h1>L'image est trop lourde</h1>";
}
else if ($_GET["er"] == 3)
{
	echo "<h1>Le format de l'image ne convient pas</h1>";
}
echo "<a href='main.php'>Retour</a><br/><br/>";
include "includes/footer.php";
