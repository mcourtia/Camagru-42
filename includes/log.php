<?php
session_start();
$login = $_SESSION["loggued_on_user"];
?>

<br />
<div style="font-size:20">Bonjour <b><?php echo $login; ?></b></div>
&nbsp
<a href="logout.php"><img style="width:20px" src="img/logout.png"></a>
<br />
<a href="gestaccount.php"><font color="#58ACFA"><b>G&eacuterer mon compte</b></font></a>
<br />
