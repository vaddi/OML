<?php

// Replacement Rules
$r1 = array(".php",".xml");
$r2 = array("","");

$string = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $string);
$url = $break[count($break) - 1];

if ($url == "editArticle.php") {
  $action = "bearbeiten";
} else if ($url == "showArticle.php") {
  $action = "ansehen";
} 

if (!empty($_REQUEST['file'])) {
  
  $filereq = str_replace($r1,$r2,$_REQUEST['file']);

  // Wenn ein Dateiname verwendet wird, zeige den Fileheader
    echo '<!DOCTYPE html>
<html lang="de">
<head>
<title>OML | '.$filereq.' '.$action.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" type="text/css" rel="stylesheet" media="screen" />
<script src="../js/datum.js" type="text/javascript"></script>
<script src="../js/jquery-1.7.1.min.js"></script>
<script src="../js/app.js" type="text/javascript"></script>
<script type="text/javascript">
if (navigator.userAgent.toLowerCase().indexOf(\'chrome\')!=-1){
  document.write(\'<link rel="stylesheet" type="text/css" href="../css/chrome.css"/>\');
}
</script>
<meta name="keywords" content="'.$keywords.'" />
<meta name="description" content="'.$name.'" />
</head>
    ';
} else {
  // Andernfalls 
 
  $url_raw = str_replace($r1,$r2,$url);

  if ($url == "index.php") {
    // bei der index.php Datei zeigen wir den Indexheader
    echo '<!DOCTYPE html>
<html lang="de">
<head>    
  <title>OML | '.$url_raw.'</title>    
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--  <link rel="alternate" type="text/xml" title="RSS .92" href="inc/feed.php" /> -->
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="inc/feed.php?type=rss.xml" />
  <link rel="alternate" type="application/atom+xml" title="Atom 0.3"  href="inc/feed.php?type=atom.xml" />
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen" />
  <script src="js/datum.js" type="text/javascript"></script>
  <script type="text/javascript">
    if (navigator.userAgent.toLowerCase().indexOf(\'chrome\')!=-1){
    document.write(\'<link rel="stylesheet" type="text/css" href="css/chrome.css" />\');
  }
  </script>
</head>
    ';

  } else {
    // Auf allen anderen Seiten zeigen wir den Adminheader
    echo '<!DOCTYPE html>
<html lang="de">
<head>    
  <title>OML | '.$url_raw.'</title>    
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen" />
  <script src="../js/datum.js" type="text/javascript"></script>
  <script type="text/javascript">
    if (navigator.userAgent.toLowerCase().indexOf(\'chrome\')!=-1){
    document.write(\'<link rel="stylesheet" type="text/css" href="../css/chrome.css" />\');
  }
  </script>
</head>
    ';
  }
}
?>

