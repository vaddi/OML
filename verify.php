<?php
session_start();

$user = 'admin';
$passw = 'insecure';

if (($_POST["username"] == $user) and ($_POST["password"] == $passw)){
	$_SESSION["login"] = "true";
	header("Location:adminindex.php");
	exit;
} else {
	$_SESSION["error"] = "<font color=red>Falsche kombination Benutzername/Passwort, versuchen Sie es bitte noch ein mal.</font>";
	header("Location:login.php");

}

?>
