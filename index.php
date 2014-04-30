<?php
if (PHP_VERSION>='5') require_once('inc/ext/domxml-php4-to-php5/domxml-php4-to-php5.php');
include("inc/functions.php"); 
include("inc/head.php"); 
?>    
   
<body>    

<div id="wrap">

<?php include("inc/header.php") ?>

<div id="content_small">

<article>

<?php include("inc/index_content.php"); ?>

</article>
</div>  <!-- close #content -->   

<nav> 
<ul class="main-nav group">
<?php    

// Wenn noch kein Buch im index link um neues zu erstellen anzeigen
$verzeichnis_raw = './xml/';
$verzeichnis_glob = glob($verzeichnis_raw . '*.xml');
$fileCount = 0;    

if (count($verzeichnis_glob) == $fileCount) {
  echo '<li>'."\n"; 
  echo '  <a href="inc/createArticle.php">'."\n";  
  echo '  <span class="spine_publisher">ORlib</span>'."\n";   
  echo '  <div class="inlinebg" style="background:#BBBBBB;">'."\n";
  echo '    <span class="spine_author">Author</span>'."\n"; 
  echo '    <span class="spine_title">Erstes Buch erstellen</span>'."\n"; 
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
   
 if ((count($verzeichnis_glob) == "1") and ($status != "online")) {
    echo '<li>'."\n"; 
    echo '  <a href="inc/editArticle.php?file=' . $fileraw . '"  class="verliehen">'."\n";  
    echo '  <span class="spine_publisher">ORlib</span>'."\n";   
    echo '  <div class="inlinebg" style="background:' . $color . ';">'."\n";
    echo '    <span class="spine_author">' . $authors . '</span>'."\n"; 
    echo '    <span class="spine_title" style="margin:-7px 0 0 0;line-height:100%;">' . $headline . '<br />'.$status.'</span>'."\n"; 
    echo '  </div>'."\n";
    echo '  <span class="spine_edition">' . $version . '</span>'."\n";
    echo '</a>'."\n";    
    echo '</li>'."\n"; 
 }
   
 if ($status != "online"){    
   continue;    
 }    
 echo '<li>'."\n"; 
 echo '  <a href="inc/showArticle.php?file=' . $fileraw . '"  class="' . $lent . '">'."\n";  
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

<?php include("inc/footer.php") ?>

</div><!-- close #wrap -->
<div class="clear"></div>

</div>
<!-- comment --> 
</body>    
</html>
