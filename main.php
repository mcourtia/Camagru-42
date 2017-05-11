<?php
$db = new PDO('mysql:host=localhost;dbname=db_camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
session_start();

if ($_SESSION["log"] == 1)
{
	if ($_POST["submit"] == "Envoyer")
	{
		$ext = strtolower(substr(strrchr($_FILES["my_file"]["name"], "."), 1));
		if ($_FILES['my_file']['error'] > 0)
		{
			header("location: badfile.php?er=1");
		}
		else if ($_FILES['my_file']['size'] > 1048576)
		{
			header("location: badfile.php?er=2");
		}
		else if ($ext != "png")
		{
			header("location: badfile.php?er=3");
		}
		else
		{
			$userfile = "tmp/tmp.png";
			move_uploaded_file($_FILES["my_file"]["tmp_name"], $userfile);
		}
	}
	include "includes/header.php";
	if (isset($_POST["img"]))
	{
		if ($_SESSION["actual_img"] != $_POST["img"] || $_POST["submit"] == "Valider ce montage")
		{
			$path = "gallery/tmp.png";
			$req = $db->prepare('INSERT INTO images(path, user_id) VALUES(?, ?)');
			$req->execute(array($path, $_SESSION["user_id"]));
			$res = $db->query('SELECT id FROM images ORDER BY id DESC LIMIT 1');
			while ($img = $res->fetch())
			{
				$id = $img["id"];
			}
			$path = "gallery/".$id.".png";
			$req = $db->prepare('UPDATE images SET path=:path WHERE id like :id');
			$req->bindParam(':path', $path);
			$req->bindParam(':id', $id);
			$req->execute();
			$src = imagecreatefrompng($_POST["obj"]);
			$predest = imagecreatefrompng($_POST["img"]);
			$dest = imagecreatetruecolor(400, 300);
			imagecopyresampled($dest, $predest, 0, 0, 0, 0, 400, 300, imagesx($predest), imagesy($predest));
			imagecopy($dest, $src, 0, 0, 0, 0, 400, 300);
			imagepng($dest, $path);
			$_SESSION["actual_img"] = $_POST["img"];
			unset($_POST["submit"]);
		}
	}
	include "includes/log.php";
	?>
	<br />
	<table>
		<tr>
			<td></td>
			<td id="emptytd"></td>
			<td id="sidegal" align="center"><b>Derniers montages</b><br /><a href="gallery.php"><i><font color="0">Acc&eacuteder &agrave la gallerie</font></i></a></td>
		</tr>
		<tr>
			<td>
				<form method="post" action="main.php" enctype="multipart/form-data">
					<label for="my_file">Pas de webcam ?<br/>Image au format PNG | 1 Mo max</label><br/>
					<input type="file" name="my_file" id="my_file" /><br/>
					<input type="submit" name="submit" value="Envoyer" />
				</form>
				<br/>
				<?php
				if ($_POST["submit"] == "Envoyer")
				{
					?>
					<img width="400" height="300" src="<?php echo $userfile ?>">
					<br/><br/>
					<form method="post" action="main.php">
						<input type="hidden" name="img" value="<?php echo $userfile;?>" />
						<input type="hidden" name="obj" id="valobj" value="img/fire_frame.png" />
						<input class="button" type="submit" name="submit" value="Valider ce montage" />
					<form/>
					<br/>
					<?php
				}
				else
				{?>
					<div><video id="video"></video></div>
					<br /><br />
					<div><button id="startbutton" class="button">Prendre une photo</button></div>
					<br />
					<div style="display:none"><canvas id="canvas"></canvas></div>
				<?php
				}?>
				<br />
				<div id="montgal">
					<div id="mini">
						<a href="img/fire_frame.png" title="Cadre de feu"><img src="img/fire_frame.png" alt="Cadre de feu"></a>
						<a href="img/flower_frame.png" title="Cadre de fleurs"><img src="img/flower_frame.png" alt="Cadre de fleurs"></a>
						<a href="img/hollande.png" title="Hollande"><img src="img/hollande.png" alt="Hollande"></a>
						<a href="img/sabers.png" title="Sabres"><img src="img/sabers.png" alt="Sabres"></a>
				</div>
					<div id="norm">
					<img id="big_pict" src="img/fire_frame.png" alt="Cadre de feu">
					</div>
				</div>
				<?php
				if ($_POST["submit"] == "Envoyer")
				{
					echo "<script type='text/javascript' src='js/selectimg.js'></script>";
				}
				else
				{
					echo "<script type='text/javascript' src='js/selectimg2.js'></script>";
				}
				?>
			</td>
			<td id="emptytd"></td>
			<td id="sidegal">
	<?php
	$res = $db->query('SELECT * FROM images ORDER BY id DESC LIMIT 8');
	foreach ($res->fetchall() as $img)
	{?>
		<img id="sizeside" src="<?php echo $img["path"] ?>">
		<br />
	<?php
	}?>
			</td>
		</tr>
	</table>
	</center>
	<script type="text/javascript" src="js/cam.js"></script>
	<?php
	include "includes/footer.php";
}
else
{
	include "nolog.php";
}
?>
