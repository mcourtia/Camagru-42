<?php
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
session_start();

if ($_SESSION["log"] == 1)
{
	include "includes/header.php";
	include "includes/log.php";
	echo '<h1>Gallerie</h1>';
	$pictperpage = 9;
	$res = $db->query('SELECT COUNT(*) AS total FROM images');
	$restot = $res->fetch();
	$tot = $restot["total"];
	$nbpages = ceil($tot/$pictperpage);
	if (isset($_GET['page']))
	{
		$pactual = $_GET["page"];
		if ($pactual > $nbpages)
		{
			$pactual = $nbpages;
		}
	}
	else
	{
		$pactual = 1;
	}
	
	$pictpast = ($pactual - 1) * $pictperpage;
	$res = $db->query('SELECT * FROM images ORDER BY id DESC LIMIT '.$pictpast.', '.$pictperpage.'');
	echo '<div id="gal">';
	foreach ($res->fetchall() as $pict)
	{
		echo '<a href="picture.php?img='.$pict["id"].'"><img id="pictgal" src="'.$pict["path"].'"></a>';
	}
	echo '<p align="center">Page : ';
	for ($i = 1; $i <= $nbpages; $i++)
	{
		if ($i == $pactual)
		{
			echo ' [ '.$i.' ] ';
		}
		else
		{
			echo ' <a href="gallery.php?page='.$i.'">'.$i.'</a>';
		}
	}
	echo '</p>';
	echo '</div>';

	include "includes/footer.php";
}
else
{
	include "nolog.php";
}
?>
