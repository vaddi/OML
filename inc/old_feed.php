<?php
/* Script Base by David Zimmerman http://www.dizzysoft.com/

Rebuild by Maik Vattersen http://www.exigem.com/

Use a cronjob to push logdata from system to file

Please feel free to use as long as you give me credit and understand there is no warranty that comes with this script.
*/

if (PHP_VERSION>='5') require_once('ext/domxml-php4-to-php5/domxml-php4-to-php5.php');
include("functions.php");

//$file = "error.log";
$max = 10; // max number of entries

//$lines= array_reverse(file($file));
//$lines = array_unique($lines);
  
$url= 'http://'.$_SERVER['HTTP_HOST'];
$url.= substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'],'/')+1);
$url_raw = str_replace("inc/","",$url);

include("bbcode.php");

if(isset($_REQUEST['type'])) {
  $request = $_REQUEST['type'];
} else {
  $request = "";
}

//
// RSS v1 
//

if ( eregi("rss",$request) || 
     eregi("RSS",$request) ||
     eregi("rss.xml",$request) || 
     eregi("RSS.xml",$request) || 
     empty($request) ) {

  $doc= new DomDocument('1.0', 'UTF-8');
  $doc->formatOutput = true;

  // create root node
  $root = $doc->createElement('rss');
  $doc->appendChild($root);
  $version = $doc->createAttribute('version');
  $root->appendChild($version);
  $text= $doc->createTextNode('2.0');
  $version->appendChild($text);
  $channel= $doc->createElement('channel');
  $root->appendChild($channel);

  // nodes of channel
  $info= $doc->createElement('title');
  $channel->appendChild($info);
  $text= $doc->createTextNode('RSS Feeds f&uuml;r '.$url_raw);
  $info->appendChild($text);
  $info= $doc->createElement('link');
  $channel->appendChild($info);
  $text= $doc->createTextNode($url_raw);
  $info->appendChild($text);
  $info= $doc->createElement('description');
  $channel->appendChild($info);
  $text= $doc->createTextNode("Der Online Media Library RSS Newsfeed");
  $info->appendChild($text);
  $info= $doc->createElement('lastBuildDate');
  $channel->appendChild($info);
  $text= $doc->createTextNode(Date('r')); // now
  $info->appendChild($text);
  $info= $doc->createElement('language');
  $channel->appendChild($info);
  $text= $doc->createTextNode("de");
  $info->appendChild($text);

  // Elements for this channel
  $verzeichnis_raw = '../xml/';
  $verzeichnis_glob = glob($verzeichnis_raw . '*.xml');
  $fileCount = 0;

  foreach($verzeichnis_glob as $key => $file) {
    
    // Get Info from each file
    $open = $file;    
    $xml = domxml_open_file($open);    
   
    $root = $xml->root();    
 
    $stat_array = $root->get_elements_by_tagname("status");    
    $status = extractText($stat_array);    
 
    $headline_array = $root->get_elements_by_tagname("headline");    
    $headline = extractText($headline_array);
 
    $authors_array = $root->get_elements_by_tagname("authors");    
    $authors = extractText($authors_array);
 
    $version_array = $root->get_elements_by_tagname("version");    
    $version = extractText($version_array); 
 
    $ab_array = $root->get_elements_by_tagname("abstract"); 
    $abstract = extractText($ab_array);
    $abstract = htmlspecialchars("$abstract", ENT_NOQUOTES, "UTF-8"); 
    
    $desc_array = $root->get_elements_by_tagname("description");
    $description = extractText($desc_array);
    $description = preg_replace($bbcode_regex, $bbcode_replace, $description);
    $description = trim_text($description, 320, $ellipses = true, $strip_html = true);
   
    if ($status != "online"){    
      continue;    
    }

    // Create one Item
    $item = $doc->createElement('item');
    $channel->appendChild($item);

    $child = $doc->createElement('title');
    $item->appendChild($child);
    $value = $doc->createTextNode($headline);
    $child->appendChild($value);

    $child = $doc->createElement('description');
    $item->appendChild($child);
    $value = $doc->createTextNode($description);
    $child->appendChild($value);

    $child = $doc->createElement('link');
    $item->appendChild($child);
    $urls = str_replace("../xml/","inc/showArticle.php?file=",$open);
    $value = $doc->createTextNode($url_raw.$urls);
    $child->appendChild($value);

    $child = $doc->createElement('pubDate');
    $item->appendChild($child);
    $value = $doc->createTextNode(date('r', filemtime($file)));
    $child->appendChild($value);

    $child = $doc->createElement('guid');
    $item->appendChild($child);
    $urls = str_replace("../xml/","inc/showArticle.php?file=",$open);
    $value = $doc->createTextNode($url_raw.$urls);
    $child->appendChild($value);

    $fileCount++;
    
  }
  // close foreach
  // and output as xml
  echo $doc->saveXML();
  
} 

//
// RSS v2
//

if (eregi("rss2",$request) || 
    eregi("RSS2",$request) || 
    eregi("rss2.xml",$request) || 
    eregi("RSS2.xml",$request) ) {

  $doc= new DomDocument('1.0', 'UTF-8');
  $doc->formatOutput = true;

  // create root node
  $root = $doc->createElement('rss');
  $doc->appendChild($root);
  $version = $doc->createAttribute('version');
  $root->appendChild($version);
  $text= $doc->createTextNode('2.0');
  $version->appendChild($text);
  $channel= $doc->createElement('channel');
  $root->appendChild($channel);

  // nodes of channel
  $info= $doc->createElement('title');
  $channel->appendChild($info);
  $text= $doc->createTextNode('RSS Feeds for '.$url_raw);
  $info->appendChild($text);
  $info= $doc->createElement('link');
  $channel->appendChild($info);
  $text= $doc->createTextNode($url_raw);
  $info->appendChild($text);
  $info= $doc->createElement('description');
  $channel->appendChild($info);
  $text= $doc->createTextNode("This is the RSS Newsfeed for OML, Online Media Library");
  $info->appendChild($text);
  $info= $doc->createElement('lastBuildDate');
  $channel->appendChild($info);
  $text= $doc->createTextNode(Date('r')); // now
  $info->appendChild($text);

  // Elements for this channel
  $verzeichnis_raw = '../xml/';
  $verzeichnis_glob = glob($verzeichnis_raw . '*.xml');
  $fileCount = 0;

  foreach($verzeichnis_glob as $key => $file) {
  
    // Get Info from each file
    $open = $file;    
    $xml = domxml_open_file($open);    
   
    $root = $xml->root();    
 
    $stat_array = $root->get_elements_by_tagname("status");    
    $status = extractText($stat_array);    
 
    $headline_array = $root->get_elements_by_tagname("headline");    
    $headline = extractText($headline_array);
 
    $authors_array = $root->get_elements_by_tagname("authors");    
    $authors = extractText($authors_array);
 
    $version_array = $root->get_elements_by_tagname("version");    
    $version = extractText($version_array); 
 
    $ab_array = $root->get_elements_by_tagname("abstract"); 
    $abstract = extractText($ab_array);
    $abstract = htmlspecialchars("$abstract", ENT_NOQUOTES, "UTF-8"); 
   
    $desc_array = $root->get_elements_by_tagname("description");
    $description = extractText($desc_array);
    $description = preg_replace($bbcode_regex, $bbcode_replace, $description);
    $description = trim_text($description, 320, $ellipses = true, $strip_html = true);

    if ($status != "online"){    
      continue;    
    }

    // Create one Item
    $item = $doc->createElement('item');
    $channel->appendChild($item);

    $child = $doc->createElement('title');
    $item->appendChild($child);
    $value = $doc->createTextNode($headline);
    $child->appendChild($value);

    $child = $doc->createElement('description');
    $item->appendChild($child);
    $value = $doc->createTextNode($description);
    $child->appendChild($value);

    $child = $doc->createElement('link');
    $item->appendChild($child);
    $urls = str_replace("../xml/","inc/showArticle.php?file=",$open);
    $value = $doc->createTextNode($url_raw.$urls);
    $child->appendChild($value);

    $child = $doc->createElement('pubDate');
    $item->appendChild($child);
    $value = $doc->createTextNode(date('r', filemtime($file)));
    $child->appendChild($value);

    $fileCount++;
    
  }
  // close foreach
  // and output as xml
  echo $doc->saveXML();
  
} 

//
// Atom Feed 
// stil invalid at the time :-/

if (eregi("atom",$request) || 
    eregi("ATOM",$request) || 
    eregi("Atom",$request) || 
    eregi("atom.xml",$request) || 
    eregi("ATOM.xml",$request) || 
    eregi("Atom.xml",$request) ) {

  $doc= new DomDocument('1.0', 'UTF-8');
  $doc->formatOutput = true;

  // create root node
  $root = $doc->createElement('feed');
  $doc->appendChild($root);
  $version = $doc->createAttribute('xml:lang');
  $root->appendChild($version);
  $text= $doc->createTextNode('de-DE');
  $version->appendChild($text);
  $version = $doc->createAttribute('xmlns');
  $root->appendChild($version);
  $text= $doc->createTextNode('http://www.w3.org/2005/Atom');
  $version->appendChild($text);

  // nodes of channel
  $info= $doc->createElement('title');
  $root->appendChild($info);
  $text= $doc->createTextNode('Atom Feed for '.$url_raw);
  $info->appendChild($text);

  $info= $doc->createElement('subtitle');
  $root->appendChild($info);
  $text= $doc->createTextNode("This is the RSS Newsfeed for OML, ORlib Media Library");
  $info->appendChild($text);

  $info= $doc->createElement('link');
  $root->appendChild($info);
  $text= $doc->createTextNode($url);
  $info->appendChild($text);

  $info= $doc->createElement('updated');
  $root->appendChild($info);
  $text= $doc->createTextNode(Date('r')); // now
  $info->appendChild($text);

  $info = $doc->createElement('author');
  $root->appendChild($info);

  $info2= $doc->createElement('name');
  $info->appendChild($info2);
  $text= $doc->createTextNode('Maik Vattersen');
  $info2->appendChild($text);

  $info2= $doc->createElement('email');
  $info->appendChild($info2);
  $text= $doc->createTextNode('m.vattersen@exigem.com');
  $info2->appendChild($text);

  $root->appendChild($info);

  // Elements for this channel
  $verzeichnis_raw = '../xml/';
  $verzeichnis_glob = glob($verzeichnis_raw . '*.xml');
  $fileCount = 0;

  foreach($verzeichnis_glob as $key => $file) {
    // Get Info from each file
    $open = $file;    
    $xml = domxml_open_file($open);    
   
    $root = $xml->root();    
 
    $stat_array = $root->get_elements_by_tagname("status");    
    $status = extractText($stat_array);    
 
    $headline_array = $root->get_elements_by_tagname("headline");    
    $headline = extractText($headline_array);
 
    $authors_array = $root->get_elements_by_tagname("authors");    
    $authors = extractText($authors_array);
 
    $version_array = $root->get_elements_by_tagname("version");    
    $version = extractText($version_array); 
 
    $ab_array = $root->get_elements_by_tagname("abstract"); 
    $abstract = extractText($ab_array);
    $abstract = htmlspecialchars("$abstract", ENT_NOQUOTES, "UTF-8"); 
       
    $desc_array = $root->get_elements_by_tagname("description");
    $description = extractText($desc_array);
    $description = preg_replace($bbcode_regex, $bbcode_replace, $description);
    $description = trim_text($description, 320, $ellipses = true, $strip_html = true);

    if ($status != "online"){    
      continue;    
    }

    // Create Item
    $info2 = $doc->createElement('entry');
    $info->appendChild($info2);

    $info3 = $doc->createElement('title');
    $info2->appendChild($info3);
    $value = $doc->createTextNode($headline);
    $info3->appendChild($value);

    $info3 = $doc->createElement('link');
    $info2->appendChild($info3);
    $urls = str_replace("../xml/","inc/showArticle.php?file=",$open);
    $value = $doc->createTextNode($url_raw.$urls);
    $info3->appendChild($value);

    $info3 = $doc->createElement('author');
    $info2->appendChild($info3);

    $info32 = $doc->createElement('name');
    $info2->appendChild($info32);
    $value = $doc->createTextNode($authors);
    $info32->appendChild($value);

    $info3->appendChild($info32);


    $info3 = $doc->createElement('updated');
    $info2->appendChild($info3);
    $value = $doc->createTextNode(date('r', filemtime($file)));
    $info3->appendChild($value);

    $info3 = $doc->createElement('summary');
    $info2->appendChild($info3);
    $value = $doc->createTextNode($description);
    $info3->appendChild($value);

#    $info2->appendChild($info3);
    
    $fileCount++;

  }

  // close foreach
  // and output as xml
  echo $doc->saveXML();

} 

?>
