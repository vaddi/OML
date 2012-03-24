<?php
/* Script Base by David Zimmerman http://www.dizzysoft.com/

Rebuild by Maik Vattersen http://www.exigem.com/

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
  $text= $doc->createTextNode('RSS 1 Feeds für '.$url_raw);
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
  $text= $doc->createTextNode('RSS 2 Feeds for '.$url_raw);
  $info->appendChild($text);
  $info= $doc->createElement('link');
  $channel->appendChild($info);
  $text= $doc->createTextNode($url_raw);
  $info->appendChild($text);
  $info= $doc->createElement('description');
  $channel->appendChild($info);
  $text= $doc->createTextNode("Der RSS 2 Newsfeed der Online Media Library");
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

  include("ext/feedcreator/feedcreator.class.php");

#  $doc= new DomDocument('1.0', 'UTF-8');
#  $doc->formatOutput = true;

  // create root node
$rss = new UniversalFeedCreator();
#$rss->useCached("false");
$rss->title = "OML Atom News Feed";
$rss->description = "Der Atom Feed der Online Media Library";
$rss->link = $url_raw;
$rss->syndicationURL = $url_raw;

#$image = new FeedImage();
#$image->title = "dailyphp.net logo";
#$image->url = "http://www.dailyphp.net/images/logo.gif";
#$image->link = "http://www.dailyphp.net";
#$image->description = "Feed provided by dailyphp.net. Click to visit.";
#$rss->image = $image;

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
    
    $item = new FeedItem();
    $item->title = $headline;
    $item->link = $url_raw.str_replace("../xml/","inc/showArticle.php?file=",$open);
    $description = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" target=\"_blank\">\\0</a>", $description); # Links klickbar machen
    $item->description = $description;
    $item->descriptionHtmlSyndicated = true;
    $item->date = date('r', filemtime($open));
    $item->source = $url_raw;
    $item->author = $authors;
    
    $rss->addItem($item);
#    
#    $info2 = $doc->createElement('entry');
#    $info->appendChild($info2);

#    $info3 = $doc->createElement('title');
#    $info2->appendChild($info3);
#    $value = $doc->createTextNode($headline);
#    $info3->appendChild($value);

#    $info3 = $doc->createElement('link');
#    $info2->appendChild($info3);
#    $urls = str_replace("../xml/","inc/showArticle.php?file=",$open);
#    $value = $doc->createTextNode($url_raw.$urls);
#    $info3->appendChild($value);

#    $info3 = $doc->createElement('author');
#    $info2->appendChild($info3);

#    $info32 = $doc->createElement('name');
#    $info2->appendChild($info32);
#    $value = $doc->createTextNode($authors);
#    $info32->appendChild($value);

#    $info3->appendChild($info32);


#    $info3 = $doc->createElement('updated');
#    $info2->appendChild($info3);
#    $value = $doc->createTextNode(date('r', filemtime($file)));
#    $info3->appendChild($value);

#    $info3 = $doc->createElement('summary');
#    $info2->appendChild($info3);
#    $value = $doc->createTextNode($description);
#    $info3->appendChild($value);

#    $info2->appendChild($info3);
    
    $fileCount++;

  }

  // close foreach
  // and output as xml
#  $doc = saveFeed("RSS1.0", "news/feed.xml");
if ($_REQUEST['type'] == 'atom') {
	echo $rss->outputFeed("ATOM1.0"); 
	//$feed->saveFeed("ATOM1.0", "news/feed.xml"); 
} else if ($_REQUEST['type'] == 'atom0'){
	echo $rss->outputFeed("ATOM0.3"); 
} else if ($_REQUEST['type'] == 'rss2.0'){
	echo $rss->outputFeed("RSS2.0"); 
}  else  {
	echo $rss->outputFeed("RSS"); 
}
#  echo $rss->outputFeed("ATOM1.0");
  

} 

?>
