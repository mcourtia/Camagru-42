<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if ($_SESSION["log"] == 1)
{
	if ($_GET["img"])
	{
		if ($_GET["like"] == "b")
		{
			$res = $db->query('SELECT * FROM likes');
			while ($like = $res->fetch())
			{
				if ($like["user_like"] == $_SESSION["loggued_on_user"] && $like["img_like"] == $_GET["img"])
				{
					$verif_like = 1;
				}
			}
			if ($verif_like != 1)
			{
				$req = $db->prepare('INSERT INTO likes(user_like, img_like) VALUES(?, ?)');
				$req->execute(array($_SESSION["loggued_on_user"], $_GET["img"]));
			}
		}
		else if ($_GET["like"] == "g")
		{
			$req = $db->prepare('DELETE FROM likes WHERE user_like like :user_like AND img_like like :img_like');
			$req->bindParam(':user_like', $_SESSION["loggued_on_user"]);
			$req->bindParam(':img_like', $_GET["img"]);
			$req->execute();
		}
		if ($_POST["submit"] == "Publier" && $_POST["com"])
		{
			$com = $_POST["com"];
			$user_log = $_SESSION["loggued_on_user"];
			$img_id = $_GET["img"];
			date_default_timezone_set('Europe/Paris');
			$date = date("d/m/Y  H\hi");
			$req = $db->prepare('INSERT INTO comments(com, user_log, img_id, date) VALUES(?, ?, ?, ?)');
			$req->execute(array(htmlspecialchars($com), $user_log, $img_id, $date));
			$res = $db->query('SELECT * FROM images');
			while ($im = $res->fetch())
			{
				if ($im["id"] == $_GET["img"])
				{
					$recup_id = $im["user_id"];
				}
			}
			$res = $db->query('SELECT * FROM users');
			while ($us = $res->fetch())
			{
				if ($us["id"] == $recup_id)
				{
					$dest = $us["mail"];
					$mail_log = $us["login"];
				}
			}
			$subj = "Commentaire sur l'un de vos montages";
			$head = "From: info@camagru.com";
			$msg = "Bonjour ".$mail_log.", nous vous informons qu'un commentaire a ete publier sur l'un de vos montages !\n\n\n-----------------------------------------------------\nCeci est un mail automatique, merci de ne pas y repondre.";
			mail ($dest, $subj, $msg, $head);
		}
		$id = $_GET["img"];
		$res = $db->query('SELECT * FROM images');
		while ($img = $res->fetch())
		{
			if ($img["id"] == $id)
			{
				$user_id = $img["user_id"];
				$path = $img["path"];
				$verif = 1;
			}
		}
		$res = $db->query('SELECT login, id FROM users');
		while ($user = $res->fetch())
		{
			if ($user["id"] == $user_id)
			{
				$logimg = $user["login"];
			}
		}
		if ($verif != 1)
		{
			header("location: error.php");
		}
		else
		{
			include "includes/header.php";
			include "includes/log.php";
			$nb = 0;
			$res = $db->query('SELECT * FROM likes');
			while ($like = $res->fetch())
			{
				if ($like["img_like"] == $_GET["img"])
				{
					$nb++;
				}
				if ($like["img_like"] == $_GET["img"] && $like["user_like"] == $_SESSION["loggued_on_user"])
				{
					$i = 1;
				}
			}
			?>
			<br/>
			<a href="gallery.php"><font color="0"><b>Retour &agrave la galerie</b></font></a>
			<br/>
			<br/>
			<img src=<?php echo $path ?>>
			<br/>
			Auteur: <i><?php echo $logimg ?></i>&nbsp&nbsp&nbsp&nbsp&nbsp
			<?php
			if ($i == 1)
			{
				echo "<a href='picture.php?img=".$_GET['img']."&like=g'><img width='20' src='img/green.png'></a>";
			}
			else
			{
				echo "<a href='picture.php?img=".$_GET['img']."&like=b'><img width='20' src='img/black.png'></a>";
			}
				echo "&nbsp&nbsp".$nb;
			?>
			<br/><br/>
			<div id="com">
				<b>Ajouter un commentaire</b><br/>
				<form action="picture.php?img=<?php echo $_GET["img"] ?>" method="post">
					<textarea name="com" cols="63" rows="5" style="margin-top:10px;margin-bottom:10px;"></textarea><br/>
					<input type="submit" name="submit" value="Publier">
				</form>
				<br/>
				<b>Commentaires</b>
				<br/><br/>
				<?php
				$res = $db->query('SELECT * FROM comments ORDER BY id DESC');
				while ($com = $res->fetch())
				{
					if ($com["img_id"] == $_GET["img"])
					{
						echo "<b>".$com["user_log"]."</b>&nbsp&nbsp&nbsp<i><font size=3>".$com["date"]."</font></i><br/>";
						echo $com["com"]."<br/><br/>";
					}
				}
				?>
			</div>
			</center>
			<br/>
			<?php
			include "includes/footer.php";
		}
	}
	else
	{
		header("location: error.php");
	}
}
else
{
	include "nolog.php";
}
?>
