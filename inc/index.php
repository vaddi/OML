<?php

     // Redirect to Main index, we wont show our PHP-Files
     $hostname = $_SERVER['HTTP_HOST'];
     $path = dirname($_SERVER['PHP_SELF']);

     header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/../index.php');
?>
