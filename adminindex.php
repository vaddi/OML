<?php
session_start();

if ($_SESSION["login"] != "true"){
	header("Location:login.php");
	$_SESSION["error"] = "<font color=red>Sie haben nicht die erforderlichen Rechte f&uuml;r die Adminseite</font>";
	exit;
}


if (PHP_VERSION>='5')
 require_once('domxml-php4-to-php5.php');

function extractText($array){    
 if(count($array) <= 1){ 
   $value = "";   
   //we only have one tag to process!    
   for ($i = 0; $i<count($array); $i++){    
     $node = $array[$i];    
     $value = $node->get_content();    
   }    
   return $value;    
 }      
     
} 

?>
<!DOCTYPE html>
<html lang="de">
<head>    
<title>&Uuml;bersicht</title>    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet" media="screen" />
<script src="js/datum.js" type="text/javascript"></script>
<script type="text/javascript">
if (navigator.userAgent.toLowerCase().indexOf('chrome')!=-1){
  document.write('<link rel="stylesheet" type="text/css" href="css/chrome.css"/>');
}
</script>
</head>    
   
<body>    

<div id="wrap">

<header>
  <div class="search">
    <form name="search" method="post" action="searchArticles.php">    
     <input name="search" type="text" id="search" placeholder="Suchen">    
     <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <span class="login"><a href="logout.php">logout</a></span>
  </div>
  <div id="headnav"> 
    <h1>ORlib - Media Library | OML</h1>  
  </div>

  <div id="header-time">
     <script type="text/javascript">writeclock()</script> 
     <noscript><p></p></noscript>
   </div>
   
</header>

<div id="content">

<article>

<header style="background:#bbb;color:#fff;">
  <span class="right" style="margin:-2px 0 0 0;">
    <a href="createArticle.php" class="button">Buch erstellen</a>
    <a href="index.php" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>
  </span>
  <h1>&Uuml;bersicht</h1>
</header>

<div id="search_content">
<ul>
<?php

// Neues Buch erstellen wenn noch keines im index
$verzeichnis_raw = './xml/';
$verzeichnis_glob = glob($verzeichnis_raw . '*.xml');
$dh = $verzeichnis_glob;
if (count($dh) == "0") {
  header("Location:createArticle.php");
} else {
  $dh = opendir($verzeichnis_raw);
}

$fileCount = 1;
while ($file = readdir($dh)){
	if (eregi("^\\.\\.?$", $file)) {
		continue;
	}

 $open = "xml/".$file;    
 $xml = domxml_open_file($open);

 //we need to pull out all the things from this file that we will need to      
 //build our links    
 $root = $xml->root();

 $stat_array = $root->get_elements_by_tagname("status");    
 $status = extractText($stat_array);    
 
 $headline_array = $root->get_elements_by_tagname("headline");    
 $headline = extractText($headline_array);

 $authors_array = $root->get_elements_by_tagname("authors");    
 $authors = extractText($authors_array);
 
 $color_array = $root->get_elements_by_tagname("color");    
 $color = extractText($color_array);   
      
 $version_array = $root->get_elements_by_tagname("version");    
 $version = extractText($version_array); 
 
 $lent_array = $root->get_elements_by_tagname("lent");    
 $lent = extractText($lent_array); 
 
 $ab_array = $root->get_elements_by_tagname("description"); 
 $abstract = extractText($ab_array);
 $abstract = htmlspecialchars("$abstract", ENT_NOQUOTES, "UTF-8"); 
 
 	echo "<li>\n";   
    echo "  <span class='" . $lent . "' style='background:" . $color . ";color:#ffffff;margin:0 0 0 -4px;padding:2px 4px;'>" . $fileCount . ".)</span>&nbsp;\n";
	echo "  <span>";
	echo "    <a href=\"showArticle.php?file=".$file . "\">" . $headline . "</a>";
	echo "  </span>\n";
	echo "  <span>" . $authors . "</span>\n";
	echo "  <span class='right' style='background:" . $color . ";color:#ffffff;margin:0 -4px 0 0;padding:0px 4px;'>";
	echo "    " . $lent . " | ";
	echo "    " . $status . " | ";
	echo "    <a href=\"editArticle.php?file=".$file . "\">edit</a> | ";
	echo "    <a href=\"delArticle.php?file=" .$file . "\">delete</a>";
	echo "  </span>\n";
	echo "</li>\n";
    $fileCount++;
}
?>
</ul>
</div>



</article>
</div>  <!-- close #content --> 

<div class="clear"></div>

<?php include("footer.php"); ?>

</div><!-- close #wrap -->

</body>
</html>
