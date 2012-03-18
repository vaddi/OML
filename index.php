<!DOCTYPE html>
<html lang="de">

<?php
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

<head>    
<title>ORlib - Media Library | OML</title>    
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
    <span class="login"><a href="adminindex.php">Admin</a></span>
  </div>
  <div id="headnav"> 
    <h1>ORlib - Media Library | OML</h1> 
  </div>

  <div id="header-time">
     <script type="text/javascript">writeclock()</script> 
     <noscript><p></p></noscript>
   </div>

</header>

<div id="content_small">

<article>

<header>
<h1>Zweck</h1>
</header>
<p>Ziel ist es eine kleine virtuelle B&uuml;cherei als erg&auml;nzendes Material zu seinen B&uuml;chern. So kann man sich Platzsparend Notizen anlegen und in diese mit der Suche auch schnell durchst&ouml;bern. Basierend auf einem <a href="http://www.sitepoint.com/management-system-php/">PHP XML CMS</a> von Tom Myer und einer <a href="http://alexandre.alapetite.fr/doc-alex/domxml-php4-php5/">PHP-Libary</a> von Alexandre Alapetite zur Umwandlung von PHP4 xml Aufrufen in PHP5 sofern der Server PHP5 verwendet.</p>

<header>
<h1>Funktion</h1>
</header>
<p>Basierend auf einer einfachen xml Datei pro Buch, kann man sich z.B. Links, Notizen oder andere Informationen zu seinem Buch anlegen und speichern. Mit Bekannten oder Freunden kann man sich so auf einfachem Wege diese Informationen austauschen und teilen.</p>

<header>
<h1>Verliehen?</h1>
</header>
<p>Eine kleine hilfe f&uuml;r die jenigen die Ihre B&uuml;cher &ouml;fter Verleihen, man kann den Namen und Ausleihdatum als Merkhilfe anlegen bzw. Auslesen. In der Bücherregalansicht sind verliehene B&uuml;cher Transparent hinterlegt, so sieht man auf den ersten Blick wie viele sich noch im eigenen Regal befinden sollten.</p>

</article>
</div>  <!-- close #content -->   

<nav> 
<ul class="main-nav group">
<?php    

// Wenn noch kein Buch im index link um neues zu erstellen anzeigen
$verzeichnis_raw = './xml/';
$verzeichnis = openDir($verzeichnis_raw);  
$verzeichnis_glob = glob($verzeichnis_raw . '*.xml');
$dh = $verzeichnis_glob;
$fileCount = 0;    
if (count($dh) == $fileCount) {
 echo '<li>'."\n"; 
 echo '  <a href="createArticle.php">'."\n";  
 echo '  <span class="spine_publisher">ORlib</span>'."\n";   
 echo '  <div class="inlinebg" style="background:#BBBBBB;">'."\n";
 echo '    <span class="spine_author">Author</span>'."\n"; 
 echo '    <span class="spine_title">Erstellen Sie das erste Buch</span>'."\n"; 
 echo '  </div>'."\n";
 echo '  <span class="spine_edition">v 0.1</span>'."\n";
 echo '</a>'."\n";    
 echo '</li>'."\n"; 
}

foreach($verzeichnis_glob as $key => $file){

 $fileraw = str_replace($verzeichnis_raw, '', $file);
 $open = $file;    
 $xml = domxml_open_file($open);    
   
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
   
   
 if ($status != "online"){    
   continue;    
 }    
 echo '<li>'."\n"; 
 echo '  <a href="showArticle.php?file=' . $fileraw . '"  class="' . $lent . '">'."\n";  
 echo '  <span class="spine_publisher">ORlib</span>'."\n";   
 echo '  <div class="inlinebg" style="background:' . $color . ';">'."\n";
 echo '    <span class="spine_author">' . $authors . '</span>'."\n"; 
 echo '    <span class="spine_title">' . $headline . '</span>'."\n"; 
 echo '  </div>'."\n";
 echo '  <span class="spine_edition">' . $version . '</span>'."\n";
 echo '</a>'."\n";    
 echo '</li>'."\n";    
     
 $fileCount++;    
}    
?>    
 

</ul>
</nav>

<?php include("footer.php") ?>

</div><!-- close #wrap -->
<div class="clear"></div>

</div>
 
</body>    
</html>
