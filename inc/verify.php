<?php
session_start();

// DE: Bitte Passen Sie diese Variablen an!
// EN: Pleas Change this Variables!

$user = 'admin';
$passw = 'insecure';

// DE: Ab hier nicht weiter verändern
// EN: Dont edit after here

if (($_POST["username"] == $user) and ($_POST["password"] == $passw)){
	$_SESSION["login"] = "true";
	header("Location:adminindex.php");
	exit;
} else {
	$_SESSION["error"] = "<font color=red>Falsche kombination Benutzername/Passwort, versuchen Sie es bitte noch ein mal.</font>";
	header("Location:login.php");

}

?>
