<?php

$verzeichnis_raw = '../xml/';

// Requests
$id = $_POST['id'];
$oldid = $_POST['oldid'];
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

if (PHP_VERSION>='5') require_once('ext/domxml-php4-to-php5/domxml-php4-to-php5.php');

//create document root
$doc = domxml_new_doc("1.0", "UTF-8");
$doc->formatOutput = true;
$root = $doc->create_element("book");
$root = $doc->append_child($root);

//add ISBN attribute
$root->set_attribute('isbn', $isbn);

//create status
$stat = $doc->create_element("status");
$stat = $root->append_child($stat);
$stat_text = $doc->create_text_node($status);
$stat_text = $stat->append_child($stat_text);

//create headline
$head = $doc->create_element("headline");
$head = $root->append_child($head);
$htext = $doc->create_text_node($headline);
$htext = $head->append_child($htext);

//create author names
$aname = $doc->create_element("authors");
$aname = $root->append_child($aname);
$atext = $doc->create_text_node($authors);
$atext = $aname->append_child($atext);

//create keywords listing
$keylisting = $doc->create_element("keywords");
$keylisting = $root->append_child($keylisting);
$ktext = $doc->create_text_node($keywords);
$ktext = $keylisting->append_child($ktext);

//create color
$mcolor = $doc->create_element("color");
$mcolor = $root->append_child($mcolor);
$mtext = $doc->create_text_node($color);
$mtext = $mcolor->append_child($mtext);

//create cfs
$mcfs = $doc->create_element("cfs");
$mcfs = $root->append_child($mcfs);
$ctext = $doc->create_text_node($cfs);
$ctext = $mcfs->append_child($ctext);

//create image
$mimage = $doc->create_element("image");
$mimage = $root->append_child($mimage);
$itext = $doc->create_text_node($image);
$itext = $mimage->append_child($itext);

//create abstract
$abs = $doc->create_element("abstract");
$abs = $root->append_child($abs);
$abstext = $doc->create_text_node($abstract);
$abstext = $abs->append_child($abstext);

//create index
$mindex = $doc->create_element("index");
$mindex = $root->append_child($mindex);
$indextext = $doc->create_text_node($index);
$indextext = $mindex->append_child($indextext);

//create description
$mdescription = $doc->create_element("description");
$mdescription = $root->append_child($mdescription);
$desctext = $doc->create_text_node($description);
$desctext = $mdescription->append_child($desctext);

//create colophone
$mcolophone = $doc->create_element("colophone");
$mcolophone = $root->append_child($mcolophone);
$coltext = $doc->create_text_node($colophone);
$coltext = $mcolophone->append_child($coltext);

//create links and insert single link elements
$mlinks = $doc->create_element("links");
$root->append_child($mlinks);

foreach ($_POST['link'] as $k => $l) {

  //create single link 
  $mlink = $doc->create_element("link");
  $mlink = $root->append_child($mlink);
  $linktext = $doc->create_text_node($l);
  $linktext = $mlink->append_child($linktext);
  
  if ($k < $links) {
    //Close links if there are no more link elements
    $mlinks->append_child($mlink);
  }
}

//create version
$mversion = $doc->create_element("version");
$mversion = $root->append_child($mversion);
$versiontext = $doc->create_text_node($version);
$versiontext = $mversion->append_child($versiontext);

//create lent
$mlent = $doc->create_element("lent");
$mlent = $root->append_child($mlent);
$ilent = $doc->create_text_node($lent);
$ilent = $mlent->append_child($ilent);

//create lent_name
$mlent_name = $doc->create_element("lent_name");
$mlent_name = $root->append_child($mlent_name);
$ilent_name = $doc->create_text_node($lent_name);
$ilent_name = $mlent_name->append_child($ilent_name);

//create lent_name
$mlent_date = $doc->create_element("lent_date");
$mlent_date = $root->append_child($mlent_date);
$ilent_date = $doc->create_text_node($lent_date);
$ilent_date = $mlent_date->append_child($ilent_date);

//write to the file, name it by (new) id, first delete existing (old) one
$idval = $id.".xml";
if ( $idval === $oldid ) {
//  echo $idval . " = " . $oldid . "<br>";
  
  $filename = $verzeichnis_raw . $idval;
  unlink($filename);
  $doc->dump_file($filename, false, true);
  
} else {
//  echo $idval . " | " . $oldid . "<br>";
  
  $filename = $verzeichnis_raw . $oldid;
  unlink($filename);
  $filename = $verzeichnis_raw . $idval;
  $doc->dump_file($filename, false, true);
  
}

//send user back to adminindex
header("Location:showArticle.php?file=".$idval);

?>
