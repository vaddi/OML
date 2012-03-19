<?php

if (!empty($_REQUEST['file'])) {
  // Wenn ein Dateiname verwendet wird, zeige den Fileheader
    echo '<!DOCTYPE html>
<html lang="de">
<head>
<title><?php echo $headline; ?></title>
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
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $name; ?>" />
</head>
    ';
} else {
  // Andernfalls 
  $string = $_SERVER["SCRIPT_NAME"];
  $break = Explode('/', $string);
  $dateurl = $break[count($break) - 1]; 

  if ($dateurl == "index.php") {
    // bei der index.php Datei zeigen wir den Indexheader
    echo '<!DOCTYPE html>
<html lang="de">
<head>    
  <title>ORlib - Media Library | OML</title>    
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
  <title>ORlib - Media Library | OML</title>    
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

