<footer>
  <p>
<?php

if (!empty($_REQUEST['file'])) {
  // Wenn ein Dateiname verwendet wird zeige das Datum von diesem    
  echo "Die Datei <b>" . $_REQUEST['file'] . "</b> wurde zuletzt am " . date ("d.m.Y \u\m H:i:s\U\h\\r", filemtime("xml/".$file)) . " bearbeitet.";
} else {
  // Andernfalls 
  $string = $_SERVER["SCRIPT_NAME"];
  $break = Explode('/', $string);
  $dateurl = $break[count($break) - 1]; 

  if ($dateurl == "index.php") {
    // bei der index.php Datei zeigen wir das Datum von dieser
    echo "Diese <b>" . $dateurl . "</b> wurde zuletzt am " . date ("d.m.Y \u\m H:i:s\U\h\\r", filemtime($dateurl)) . " bearbeitet.";
  } else {
    // Auf allen anderen Seiten könnten wir das gleiche machen
//    echo "Diese <b>" . $dateurl . "</b> wurde zuletzt am " . date ("d.m.Y \u\m H:i:s\U\h\\r", filemtime($dateurl)) . " bearbeitet.";

    // Wir zeigen hier jedoch einen default footer
    echo '&copy;'.date("Y").' ORlib - Media Library | <a href="./">OML</a>, Eine virtuelle B&uuml;cherei auf Basis einfacher xml Dateien. ';
  }
}
?>

  </p>
  <div id="hoster">
    <a href="http://www.exigem.com/" title="hosted by exigem"></a>
  </div>
</footer>

