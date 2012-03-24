<?php

$verzeichnis_raw = '../xml/';

// Requests
$id = $_POST['id'];
$isbn = $_POST['isbn'];
$status = $_POST['status'];
$headline = $_POST['headline'];
$authors = $_POST['authors'];
$keywords = $_POST['keywords'];
$color = $_POST['color'];
$cfs = $_POST['cfs'];
$image = $_POST['image'];
$abstract = $_POST['abstract'];
$index = $_POST['index'];
$description = $_POST['description'];
$colophone = $_POST['colophone'];
$link = $_POST['link'];
$links = $_POST['links'];
$version = $_POST['version'];
$lent = $_POST['lent'];
$lent_name = $_POST['lent_name'];
$lent_date = $_POST['lent_date'];

$body = array($index, $description, $colophone);

//stripslashes
$id = stripslashes($id);
$isbn = stripslashes($isbn);
$status = stripslashes($status);
$headline = stripslashes($headline);
$authors = stripslashes($authors);
$keywords = stripslashes($keywords);
$color = stripslashes($color);
$cfs = stripslashes($cfs);
$image = stripslashes($image);
$abstract = stripslashes($abstract);
$index = stripslashes($index);
$description = stripslashes($description);
$colophone = stripslashes($colophone);
$links = stripslashes($links);
$version = stripslashes($version);
$lent = stripslashes($lent);
$lent_name = stripslashes($lent_name);
$lent_date = stripslashes($lent_date);

if (PHP_VERSION>='5') require_once('ext/domxml-php4-to-php5/domxml-php4-to-php5.php');

//create document root
$doc= new DomDocument('1.0', 'UTF-8');
$doc->formatOutput = true;
$root = $doc->createElement("book");
$root = $doc->appendChild($root);

//add ID attribute
//FIRST, let's make sure that the id/filename we use isn't going to overwrite a file!
$verzeichnis_raw = '../xml/';
$verzeichnis_glob = glob($verzeichnis_raw . '*.xml');

foreach ( $verzeichnis_glob as $key => $file) {
	$string = $id . ".xml";
	
	if (eregi($string, $file)){
		$time = date("U"); //number of seconds since unix epoch
		$id = $id . "-" . $time;
	}
}

//add ISBN attribute
$root->setAttribute('isbn', $isbn);

//create status
$stat = $doc->createElement("status");
$stat = $root->appendChild($stat);
$stat_text = $doc->createTextNode($status);
$stat_text = $stat->appendChild($stat_text);

//create headline
$head = $doc->createElement("headline");
$head = $root->appendChild($head);
$htext = $doc->createTextNode($headline);
$htext = $head->appendChild($htext);

//create author names
$aname = $doc->createElement("authors");
$aname = $root->appendChild($aname);
$atext = $doc->createTextNode($authors);
$atext = $aname->appendChild($atext);

//create keywords listing
$keylisting = $doc->createElement("keywords");
$keylisting = $root->appendChild($keylisting);
$ktext = $doc->createTextNode($keywords);
$ktext = $keylisting->appendChild($ktext);

//create color
$mcolor = $doc->createElement("color");
$mcolor = $root->appendChild($mcolor);
$mtext = $doc->createTextNode($color);
$mtext = $mcolor->appendChild($mtext);

//create cfs
$mcfs = $doc->createElement("cfs");
$mcfs = $root->appendChild($mcfs);
$ctext = $doc->createTextNode($cfs);
$ctext = $mcfs->appendChild($ctext);

//create image
$mimage = $doc->createElement("image");
$mimage = $root->appendChild($mimage);
$itext = $doc->createTextNode($image);
$itext = $mimage->appendChild($itext);

//create abstract
$abs = $doc->createElement("abstract");
$abs = $root->appendChild($abs);
$abstext = $doc->createTextNode($abstract);
$abstext = $abs->appendChild($abstext);

//create index
$mindex = $doc->createElement("index");
$mindex = $root->appendChild($mindex);
$indextext = $doc->createTextNode($index);
$indextext = $mindex->appendChild($indextext);

//create description
$mdescription = $doc->createElement("description");
$mdescription = $root->appendChild($mdescription);
$desctext = $doc->createTextNode($description);
$desctext = $mdescription->appendChild($desctext);

//create colophone
$mcolophone = $doc->createElement("colophone");
$mcolophone = $root->appendChild($mcolophone);
$coltext = $doc->createTextNode($colophone);
$coltext = $mcolophone->appendChild($coltext);

//create links and insert single link elements
$mlinks = $doc->createElement("links");
$root->appendChild($mlinks);

foreach ($_POST['link'] as $k => $l) {

  //create single link 
  $mlink = $doc->createElement("link");
  $mlink = $root->appendChild($mlink);
  $linktext = $doc->createTextNode($l);
  $linktext = $mlink->appendChild($linktext);
  
  if ($k < $links) {
    //Close links if there are no more link elements
    $mlinks->appendChild($mlink);
  }
}

//create version
$mversion = $doc->createElement("version");
$mversion = $root->appendChild($mversion);
$versiontext = $doc->createTextNode($version);
$versiontext = $mversion->appendChild($versiontext);

//create lent
$mlent = $doc->createElement("lent");
$mlent = $root->appendChild($mlent);
$ilent = $doc->createTextNode($lent);
$ilent = $mlent->appendChild($ilent);

//create lent_name
$mlent_name = $doc->createElement("lent_name");
$mlent_name = $root->appendChild($mlent_name);
$ilent_name = $doc->createTextNode($lent_name);
$ilent_name = $mlent_name->appendChild($ilent_name);

//create lent_name
$mlent_date = $doc->createElement("lent_date");
$mlent_date = $root->appendChild($mlent_date);
$ilent_date = $doc->createTextNode($lent_date);
$ilent_date = $mlent_date->appendChild($ilent_date);

//write to the file
$filename = $verzeichnis_raw . $id . ".xml";
$doc->save($filename, true);

//send user back to adminindex
header("Location:adminindex.php");
?>
