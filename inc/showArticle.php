<?php

if (PHP_VERSION>='5') require_once('ext/domxml-php4-to-php5/domxml-php4-to-php5.php');

include("functions.php");

// Die vorletzte und nächste Datei finden als Link verwenden
$file = $_REQUEST['file'];
$verzeichnis_raw = '../xml/';
$verzeichnis_glob = glob($verzeichnis_raw . '*.xml');

foreach ( $verzeichnis_glob as $key => $value) {
  if ($value == $verzeichnis_raw.$file) {
    if ($key < "0") {
      $key = $key +1;
      
    }

    $prev = $key -1;
    $next = $key +1;
       
    foreach ($verzeichnis_glob as $key2 => $value2) {
      # code...
      if ($key2 == $prev) {
          $prev_url = str_replace($verzeichnis_raw, '', $value2);
      } 
      if ($key2 == $next) {
          $next_url = str_replace($verzeichnis_raw, '', $value2);
          //$next_url = $value2;
      }
    }
  }
}

// XML Datei auslesen

$file = $_REQUEST['file'];

if ($file == ""){

	echo "<h2>Sie haben kein Buch zum bearbeiten ausgew&auml;hlt!</h2>";
	echo "<a href=\"adminindex.php\">Gehen Sie zur&uuml;ck zur &Uuml;bersicht und w&auml;hlen sie eine Datei</a>";
	exit;
} else {
	$open = $verzeichnis_raw . $file;
	$xml = domxml_open_file($open);
	$root = $xml->root();
	
	$id = str_replace(".xml", "", $file);
	$isbn = $root->get_attribute("isbn");

	$name_array = $root->get_elements_by_tagname("name");
	$name = extractText($name_array);
	
	$status_array = $root->get_elements_by_tagname("status");
	$status = extractText($status_array);
	
	$headline_array = $root->get_elements_by_tagname("headline");
	$headline = extractText($headline_array);
		
	$authors_array = $root->get_elements_by_tagname("authors");
	$authors = extractText($authors_array);
	
	$keywords_array = $root->get_elements_by_tagname("keywords");
	$keywords = extractText($keywords_array);
	
	$color_array = $root->get_elements_by_tagname("color");
	$color = extractText($color_array);

	$cfs_array = $root->get_elements_by_tagname("cfs");
	$cfs = extractText($cfs_array);

	$image_array = $root->get_elements_by_tagname("image");
	$image = extractText($image_array);
	
	$abstract_array = $root->get_elements_by_tagname("abstract");
	$para["abstract"] = extractText($abstract_array);
	
	$lead_array = $root->get_elements_by_tagname("index");
	$para["index"] = extractText($lead_array);

	$second_array = $root->get_elements_by_tagname("description");
	$para["description"] = extractText($second_array);

	$colophone_array = $root->get_elements_by_tagname("colophone");
	$para["colophone"] = extractText($colophone_array);

	$con_array = $root->get_elements_by_tagname("links");
	$para["links"] = extractText($con_array);

	$version_array = $root->get_elements_by_tagname("version");
	$version = extractText($version_array);

	$lent_array = $root->get_elements_by_tagname("lent");
	$lent = extractText($lent_array);

	$lent_name_array = $root->get_elements_by_tagname("lent_name");
	$lent_name = extractText($lent_name_array);

	$lent_date_array = $root->get_elements_by_tagname("lent_date");
	$lent_date = extractText($lent_date_array);

  $headline = trim_text($headline, 26, $ellipses = false, $strip_html = false);
 
include("head.php");
 
?>

<body>

<div id="wrap">
<?php include("header.php") ?>
<div id="content">

<article>
<header id="header_big" style="background:<?php echo $color; ?>">
  <span class="right">
    <a href="editArticle.php?file=<?php echo $file ?>" class="button">Bearbeiten</a>
    <?php if (!empty($prev_url)) { echo '<a href="showArticle.php?file='. $prev_url .'" class="button" title="Vorheriges Buch">«</a>'; } ?>
    <a href="../index.php" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>
    <?php if (!empty($next_url)) { echo '<a href="showArticle.php?file='. $next_url .'" class="button" title="N&auml;chstes Buch">»</a>'; } ?>
  </span>
  <h1 style="font-size:<?php echo $cfs; ?>;"><?php echo $headline; ?></h1>
</header>

<?php 

if ($lent == "im Regal") {
#nicht verliehen, nicht anzeigen
} else {
echo '<p>Verliehen am ' . $lent_date . ' an ' . $lent_name . '</p>';
}

if (!empty($authors)) {
  echo '<p>Autoren: ' . $authors . '</p>';
}

if (!empty($isbn)) {
  echo '<p>ISBN: ' . $isbn . '</p>';
}

if (!empty($version)) {
  echo '<p>OML Version: ' . $version . '</p>';
}

# index, description, colophone und links anzeigen
foreach ($para as $k => $v){
  $v = htmlspecialchars("$v", ENT_NOQUOTES, "UTF-8");
  $v = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" target=\"_blank\">\\0</a>", $v); # Links klickbar machen
  
  include("bbcode.php");
  $v = preg_replace($bbcode_regex, $bbcode_replace,$v);
   
  $r1 = array("  ","\n");
  $r2 = array("&nbsp; ","<br />");
  $v = str_replace( $r1, $r2, $v );
    
  if (!empty($v)) {
    echo "<div class='para'>".$v."</div>\n";
  }
}
?>

<div id="article_foot" style="background:<?php echo $color; ?>;color:#fff;">
  <p class="right">
    <a href="editArticle.php?file=<?php echo $file ?>" class="button">Bearbeiten</a>
    <?php if (!empty($prev_url)) { echo '<a href="showArticle.php?file='. $prev_url .'" class="button" title="Vorheriges Buch">«</a>'; } ?>
    <a href="../index.php" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>
    <?php if (!empty($next_url)) { echo '<a href="showArticle.php?file='. $next_url .'" class="button" title="N&auml;chstes Buch">»</a>'; } ?>
  </p>
  <p class="left">raw xml file: <a href="<?php echo $open; ?>"><?php echo $file; ?></a></p>
  <div class="clear"></div>
</div>

</article>
</div>





<?php
}

include("footer.php");

?>

</div><!-- close #wrap -->

</body>
</html>
