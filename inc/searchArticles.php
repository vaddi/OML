<?php
session_start();

if (PHP_VERSION>='5')
 require_once('domxml-php4-to-php5.php');

include("head.php");
include("functions.php");

if (isset($_POST['search']) and (!empty($_POST['search']))) {
  $searchTerm = $_POST['search'];
} else {
  $searchTerm = "empty";
}

$results = array();

$verzeichnis_raw = '../xml/';
$verzeichnis_glob = glob($verzeichnis_raw . '*.xml');

// On Empty Path
if (count($verzeichnis_glob) == "0") {
  $val = "empty";  
} else {
  $val = "";
}

foreach ( $verzeichnis_glob as $key => $file) {

	$open = $verzeichnis_raw.$file;
	$xml = domxml_open_file($open);

	//we need to pull out all the things from this file that we will need to 
	$root = $xml->root();

    $id = $open;

	$stat_array = $root->get_elements_by_tagname("status");
	$status = extractText($stat_array);
	
	$authors_array = $root->get_elements_by_tagname("authors");
	$authors = extractText($authors_array);
	
	$k_array = $root->get_elements_by_tagname("keywords");
	$keywords = extractText($k_array);

	$abstract_array = $root->get_elements_by_tagname("abstract");
	$abstract = extractText($abstract_array);

	$h_array = $root->get_elements_by_tagname("headline");
	$headline = extractText($h_array);
	
	$lead_array = $root->get_elements_by_tagname("index");
	$plead = extractText($lead_array);

	$second_array = $root->get_elements_by_tagname("description");
	$pmain = extractText($second_array);

	$con_array = $root->get_elements_by_tagname("colophone");
	$pcon = extractText($con_array);

	$link_array = $root->get_elements_by_tagname("link");
	$link = extractText($link_array);

	if ($status != "online"){
		continue;
	}
	if (empty($searchTerm)){
		continue;
	}
	if (eregi($searchTerm, $authors) || eregi($searchTerm,$keywords) || eregi($searchTerm,$abstract) || eregi($searchTerm,$headline) || eregi($searchTerm,$plead) || eregi($searchTerm,$pmain) || eregi($searchTerm,$pcon) || eregi($searchTerm,$link)){
		$list['authors'] = $authors;
		$list['keywords'] = $keywords;
		$list['abstract'] = $abstract;
		$list['headline'] = $headline;
		$list['plead'] = $plead;
		$list['pmain'] = $pmain;
		$list['pcon'] = $pcon;
		$list['link'] = $link;
		$list['file'] = $file;
		$results[] = $list;
	}

}

$results_unique = array_unique($results);
$results_count = count($results);

?>

<body>
<div id="wrap">
<?php include("header.php") ?>
<div id="content">

<article>
<header id="header_big">
  <span class="right">
    <a href="../index.php" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>
  </span>
  <h1>Suchergebnisse</h1>
</header>

<?php
if ($searchTerm != "empty") {
  echo '<p>Ihre suche nach: <i style="font-size:14pt;">'.$searchTerm.'</i> erbrachte <i style="font-size:14pt;">'.$results_count.'</i> Treffer</p>';
}

?>
<div id="search_content">
<ul>
<?php

if ($val == "empty") {
  echo 'Es existiert noch keine Datei die durchsucht werden kann. <a href="createArticle.php">Erstellen</a> Sie einfach eine neue.';
} else {
  if (count($results)>0){
	  foreach ($results as $key => $listing){
      if ($key >= "0") {
        $key = $key +1;
      }
	    echo '<li>';
      echo $key . ".) ";
  		echo "<a href=\"showArticle.php?file=".$listing["file"]."\">" . $listing["headline"]."</a> -> \n";
#  		$counting = count($key);echo $counting . " ";
#     $counting = count($results);echo $counting . " ";

      include("bbcode.php");
      $text = preg_replace($bbcode_regex, $bbcode_replace, $listing["pmain"]);
      
  		echo trim_text($text, 320, $ellipses = true, $strip_html = true);
	    echo '</li>';
	  }
  } else {
    if ($searchTerm == "empty") {
	    echo "Leider konnten wir mit einem leeren Suchstring keinen Treffer landen.";
    } else {
	    echo "Leider konnten wir unter dem Suchwort <i>" . $searchTerm . "</i> keinen Treffer landen.";   
    }

  }
}
?>
</ul>
</div>

<div id="article_foot">
  <span class="right">
    <a href="../index.php" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>
  </span>
  <h1>Suchergebnisse</h1>
</div>

</article>
</div>

<?php include("footer.php") ?>

</body>
</html>

