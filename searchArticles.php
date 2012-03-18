<?php
session_start();

if (PHP_VERSION>='5')
 require_once('domxml-php4-to-php5.php');

$searchTerm = $_POST['search'];
if (empty($searchTerm)) {
  $searchTerm = "empty";
}
$results = array();

//this is a very simple, potentially very slow search
function extractText($array){
	if(count($array) <= 1){
		//we only have one tag to process!
		$value = "";
		for ($i = 0; $i<count($array); $i++){
			$node = $array[$i];
			$value = $node->get_content();
		}
		return $value;
	} 
	
}	

function trim_text($input, $length, $ellipses = true, $strip_html = true) {
	//strip tags, if desired
	if ($strip_html) {
		$input = strip_tags($input);
	}
 
	//no need to trim, already shorter than trim length
	if (strlen($input) <= $length) {
		return $input;
	}
 
	//find last space within length
	$last_space = strrpos(substr($input, 0, $length), ' ');
	$trimmed_text = substr($input, 0, $last_space);
 
	//add ellipses (...)
	if ($ellipses) {
		$trimmed_text .= '...';
	}
 
	return $trimmed_text;
}

$dh = opendir('./xml/');

while ($file = readdir($dh)){
	if (eregi("^\\.\\.?$", $file)) {
		continue;
	}
	$open = "./xml/".$file;
	$xml = domxml_open_file($open);

	//we need to pull out all the things from this file that we will need to 
	//build our links
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
<!DOCTYPE html>
<html lang="de">
<head>
<title><?php echo $headline; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet" media="screen" />
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $abstract; ?>" />
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
     <input name="search" type="text" id="search" placeholder="Suchwort">    
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

<div id="content">

<article>
<header>
  <span class="right" style="margin:-2px 0 0 0;">
    <a href="index.php" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>
  </span>
  <h1>Suchergebnisse</h1>
</header>

<p>Ihre suche nach: <i style="font-size:14pt;"><?php echo $searchTerm ?></i> erbrachte <i style="font-size:14pt;"><?php echo $results_count ?></i> Treffer</p>

<div id="search_content">
<ul>
<?php
if (count($results)>0){
	foreach ($results as $key => $listing){
        if ($key >= "0") {
          $key = $key +1;
        }

	    echo '<li>';
        echo $key . ".) ";
		echo "<a href=\"showArticle.php?file=".$listing["file"]."\">" . $listing["headline"]."</a> -> \n";
		#$counting = count($key);echo $counting . " ";
#        $counting = count($results);echo $counting . " ";
		echo trim_text($listing["pmain"], 320, $ellipses = true, $strip_html = false);
	    echo '</li>';
	}
} else {

	echo "<p>Leider konnten wir unter dem Suchwort <i>" . $searchTerm . "</i> keinen Treffer landen.</p>";
}
?>
</ul>
</div>

</article>
</div>

<?php include("footer.php") ?>

</body>
</html>
