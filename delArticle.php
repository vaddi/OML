<?php
session_start();

$file = $_REQUEST['file'];

if ($_SESSION["login"] != "true"){
	header("Location:login.php");
	$_SESSION["error"] = "<font color=red>You don't have privileges to see the admin page.</font>";
	exit;
}
$dir = "./xml/";
$filetoburn = $dir . $file;
unlink($filetoburn);
header("Location: adminindex.php");
?>

