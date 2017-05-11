<?php
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
session_start();

if ($_SESSION["log"] == 1)
{
	include "includes/header.php";
	include "includes/log.php";?>
	<br/><br/>
	<a href='delimg.php'><font color="0"><b>Supprimer des montages</font></a>
	<br/><br/>
	<a href='delacc.php'><font color="#FF0000">Supprimer mon compte</b></font></a>
	<br/><br/><br/>
	</center>
	<?php
	include "includes/footer.php";
}
else
{
	include "nolog.php";
}
