<?php

function kill_session()
{
$_SESSION = array();
if (isset($_COOKIE[session_name()]))
{
setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
}

     session_start();
     kill_session();

     $hostname = $_SERVER['HTTP_HOST'];
     $path = dirname($_SERVER['PHP_SELF']);

     header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php');
?>
