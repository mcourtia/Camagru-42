<?php
session_start();

if ($_SESSION["log"] == 1)
{
	header("location: main.php");
}
else
{
	header("location: index.php");
}
