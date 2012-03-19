<footer>
  <p>
<?php

$simple_footer = '&copy;'.date("Y").' ORlib - Media Library | <a href="https://github.com/vaddi/OML">OML</a>';

if (!empty($_REQUEST['file'])) {
  // Wenn ein Dateiname verwendet wird zeige das Datum von diesem    
  echo "Die Datei <b>" . $_REQUEST['file'] . "</b> wurde zuletzt am " . date ("d.m.Y \u\m H:i:s\U\h\\r", filemtime("../xml/".$file)) . " bearbeitet.";
} else {
  // Andernfalls 
  $string = $_SERVER["SCRIPT_NAME"];
  $break = Explode('/', $string);
  $dateurl = $break[count($break) - 1]; 

  if ($dateurl == "index.php") {
    // bei der index.php Datei zeigen wir das Datum von dieser
//    echo "Diese <b>" . $dateurl . "</b> wurde zuletzt am " . date ("d.m.Y \u\m H:i:s\U\h\\r", filemtime($dateurl)) . " bearbeitet.";
    echo $simple_footer;
    echo ' | <a href="inc/feed.php?type=rss.xml">RSS</a> | <a href="inc/feed.php?type=atom.xml">Atom</a>';
  } else {
    // Auf allen anderen Seiten könnten wir das gleiche machen
//    echo "Diese <b>" . $dateurl . "</b> wurde zuletzt am " . date ("d.m.Y \u\m H:i:s\U\h\\r", filemtime($dateurl)) . " bearbeitet.";

    // Wir zeigen hier jedoch einen default footer
    echo $simple_footer;
    echo ', Eine virtuelle B&uuml;cherei auf Basis einfacher xml Dateien. ';
  }
}
?>

  </p>
  <div id="hoster">
    <a href="http://www.exigem.com/" title="hosted by exigem"></a>
  </div>
</footer>

