<?php

if (!empty($_REQUEST['file'])) {
  // Wenn ein Dateiname verwendet wird, zeige den Fileheader    
  echo '
<header>
  <div class="search">
    <form name="search" method="post" action="searchArticles.php">    
      <input name="search" type="text" id="search" placeholder="Suchen">    
      <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <span class="login"><a href="adminindex.php">Admin</a></span>
  </div>
  <div id="headnav"> 
    <h1>ORlib - Media Library | OML</h1> 
  </div>
  <div id="header-time">
    <script type="text/javascript">writeclock() </script> 
  </div>
</header>
  ';
} else {
  // Andernfalls 
  $string = $_SERVER["SCRIPT_NAME"];
  $break = Explode('/', $string);
  $dateurl = $break[count($break) - 1]; 

  if ($dateurl == "index.php") {
    // bei der index.php Datei zeigen wir den Indexheader
    echo '
<header>
  <div class="search">
    <form name="search" method="post" action="inc/searchArticles.php">    
      <input name="search" type="text" id="search" placeholder="Suchen">    
      <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <span class="login"><a href="inc/adminindex.php">Admin</a></span>
  </div>
  <div id="headnav"> 
    <h1>ORlib - Media Library | OML</h1> 
  </div>
  <div id="header-time">
    <script type="text/javascript">writeclock() </script> 
  </div>
</header>
    ';


  } else if ($dateurl == "createArticle.php") {
    echo '
<head>
<title>Neues Buch erstellen</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" type="text/css" rel="stylesheet" media="screen" />
<script src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script src="../js/datum.js" type="text/javascript"></script>
<script type="text/javascript">
if (navigator.userAgent.toLowerCase().indexOf(\'chrome\')!=-1){
  document.write(\'<link rel="stylesheet" type="text/css" href="../css/chrome.css"/>\');
}
</script>
<script>
function isReady(form){
	if(form.id.value == "") {
		alert("Bitte geben Sie eine mindestens eine ID ein!");
		return false;
	}
}
</script>
</head>
    ';
  } else {
    // Auf allen anderen Seiten zeigen wir den Adminheader
    echo '
<header>
  <div class="search">
    <form name="search" method="post" action="searchArticles.php">    
     <input name="search" type="text" id="search" placeholder="Suchen">    
     <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <span class="login"><a href="adminindex.php">Admin</a></span>
  </div>
  <div id="headnav"> 
    <h1>ORlib - Media Library | OML</h1> 
  </div>
  <div id="header-time">
    <script type="text/javascript">writeclock() </script> 
  </div>
</header>
    ';
  }
}
?>

