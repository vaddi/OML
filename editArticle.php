<?php
session_start();

if (PHP_VERSION>='5')
 require_once('domxml-php4-to-php5.php');
 
$file = $_REQUEST['file'];

function extractText($array){
	if(count($array) <= 1){
	     $value = "";
		//we only have one tag to process!
		for ($i = 0; $i<count($array); $i++){
			$node = $array[$i];
			$value = $node->get_content();
		}
		return $value;
	} 
	
}	

function split_words($string, $max = 1)
{
    $words = preg_split('/\s/', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    $lines = array();
    $line = '';
    $word = '';
       
    foreach ($words as $k => $word) {
        $length = strlen($line . ' ' . $word);
        if ($length <= $max) {
            $line .= ' ' . $word;
        } else if ($length > $max) {
            if (!empty($line)) $lines[] = trim($line);
            $line = $word;
        } else {
            $lines[] = trim($line) . ' ' . $word;
            $line = '';
        }
    }

    $lines[] = ($line = trim($line)) ? $line : $word;

    return $lines;
} 

if ($_SESSION["login"] != "true"){
	header("Location:login.php");
	$_SESSION["error"] = "<font color=red>Sie haben nicht die erforderlichen Rechte f&uuml;r die Adminseite</font>";
	exit;
}

//pull in the XML file
if ($file == ""){

	echo "<h2>Sie haben kein Buch zum bearbeiten ausgew&auml;hlt!</h2>";
	echo "<a href=\"adminindex.php\">Gehen Sie zur&uuml;ck zur &Uuml;bersicht und w&auml;hlen sie eine Datei</a>";
	exit;
} else {
	$filename = "./xml/".$file;
	$xml = domxml_open_file($filename);
	$root = $xml->root();
	
	$id = str_replace(".xml", "", $file);
	
	$isbn = $root->get_attribute("isbn");
	
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
	$abstract = extractText($abstract_array);
	
	$index_array = $root->get_elements_by_tagname("index");
	$index = extractText($index_array);

	$description_array = $root->get_elements_by_tagname("description");
	$description = extractText($description_array);

	$colophone_array = $root->get_elements_by_tagname("colophone");
	$colophone = extractText($colophone_array);

	$links_array = $root->get_elements_by_tagname("links");
	$links = extractText($links_array);
	
	$version_array = $root->get_elements_by_tagname("version");
	$version = extractText($version_array);
		
	$lent_array = $root->get_elements_by_tagname("lent");
	$lent = extractText($lent_array);
		
	$lent_name_array = $root->get_elements_by_tagname("lent_name");
	$lent_name = extractText($lent_name_array);
		
	$lent_date_array = $root->get_elements_by_tagname("lent_date");
	$lent_date = extractText($lent_date_array);
	
	$statusList = array("true" => "online", "false" => "in bearbeitung");
	$linkList = split_words($links, $max = 1);
	$linksList = count($linkList);
	$lentList = array("true" => "verliehen", "false" => "im Regal");


?>
<!DOCTYPE html>
<html lang="de">
<head>    
<title><?php echo htmlspecialchars($id); ?> bearbeiten</title>    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet" media="screen" />
<script src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
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
     <input name="search" type="text" id="search" placeholder="Suchen">    
     <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <span class="login"><a href="logout.php">logout</a></span>
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

<header style="background:<?php echo $color; ?>;color:#fff;">
  <span class="right" style="margin:-2px 0 0 0;">
    <a href="adminindex.php" class="button">Abbrechen</a>
  </span>
  <h1 style="margin: 10px 5px 5px;"><span style="font-size:<?php echo $cfs; ?>;"><?php echo htmlspecialchars($headline); ?></span> bearbeiten</h1>
</header>


<form name="createArticle" action="updateArticle.php" method="post" id="createArticle">
  <table>
  
    <tr> 
      <td width="135">Buch ID</td>
      <td width="634"> <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>"> <font size="-1">(Keine Freizeichen, Muss einzigartig sein!)</font>
      <input type="hidden" name="oldid" value="<?php echo htmlspecialchars($id); ?>">
      </td>
    </tr>
    
    <tr> 
      <td>ISBN</td>
      <td> <input name="isbn" type="text" id="isbn" value="<?php echo htmlspecialchars($isbn); ?>" size="42"></td>
    </tr>
    
    <tr>
      <td>Status</td>
      <td>
	  <select name="status">
	  <?php
	  	foreach ($statusList as $stat){
			if($stat == $status){
				echo "<option value=\"".$stat."\" selected>$stat";
			} else {
				echo "<option value=\"".$stat."\">$stat";

			}
		}
	  ?>
	  </select>
	  </td>
    </tr>
    
    <tr> 
      <td>&Uuml;berschrift</td>
      <td> <input name="headline" type="text" id="headline" value="<?php echo htmlspecialchars($headline); ?>" size="42"></td>
    </tr>
    
    <tr> 
      <td>Authoren</td>
      <td> <input name="authors" type="text" id="authors" value="<?php echo htmlspecialchars($authors); ?>"size="42"></td>
    </tr>
    
    <tr> 
      <td>Schlagw&ouml;rter</td>
      <td> <input name="keywords" type="text" value="<?php echo htmlspecialchars($keywords); ?>"> 
         <font size="-1">(Separieren Sie durch Kommas)</font>
      </td>
    </tr>
    
    <tr> 
      <td>Farbe </td>
      <td> <span class="cpreview" style="background:<?php echo $color; ?>;" title="<?php echo $color; ?>"></span> <input name="color" type="color" id="color" value="<?php echo htmlspecialchars($color); ?>"size="10" />  </td>
    </tr>
    
    <tr> 
      <td>CFS</td>
      <td> <input name="cfs" type="text" id="cfs" value="<?php echo htmlspecialchars($cfs); ?>" size="10"></td>
    </tr>

    <tr> 
      <td>Bild</td>
      <td> <input name="image" type="text" id="image" value="<?php echo htmlspecialchars($image); ?>" size="42"></td>
    </tr>

    <tr> 
      <td>BBCode kann in Kurzform, Inhalt, Inhaltsverzeichnis und Colophone verwendet werden</td>
      <td>
        <ul>
          <li>1. [b]TEXT[/b] => &lt;b&gt;TEXT&lt;/b&gt;, Alle einfachen HTML-Tags (auch i oder u)</li>
          <li>2. [url=TEXT1]TEXT2[/url] => &lt;a href="TEXT1"&gt;TEXT2&lt;/a&gt;, Textlinks oder URLs</li>
          <li>3. [img]TEXT[/img] => &lt;img src="TEXT" alt="TEXT" /&gt;, Bilder</li>
          <li>4. Alle URL Angaben (http://domain.tld/) werden automatisch in klickbaren Links dargestellt</li>
        </ul>
      </td>
    </tr>
    
    <tr> 
      <td>Kurzform</td>
      <td><textarea name="abstract" cols="60" rows="5" id="abstract"><?php echo htmlspecialchars($abstract); ?></textarea></td>
    </tr>
    
    <tr> 
      <td> Buch Inhalt</td>
      <td> Inhaltsverzeichnis:<br />
          <textarea name="index" cols="60" rows="10" wrap="soft" id="index"><?php echo htmlspecialchars($index); ?></textarea>
        <br />
        Inhalt:<br />
          <textarea name="description" cols="60" rows="10" wrap="soft" id="description" ><?php echo htmlspecialchars($description); ?></textarea>
        <br />
        Colophone:<br />
          <textarea name="colophone" cols="60" rows="10" wrap="soft" id="colophone"><?php echo htmlspecialchars($colophone); ?></textarea>
      </td>
    </tr>
    
    <tr> 
      <td>Links</td>
      <td>
      
      <?php echo "<div id='TextBoxesGroup'>\n";
      $vali = count($linkList);
      foreach ($linkList as $k => $v) {
        if ($k >= "0") {
          $k = $k+1;
        }

	    echo "      <div id='TextBoxDiv".$k."'>\n";
        echo '      <label>#'.$k.' </label><input type="text" name="link[]" id="link'.$k.'" value="'.$v.'" size="40" /><br />'."\n      ";
        echo "</div>\n";
      
        if ($k == $vali) {
          $k = $k+1;
          echo "<script type=\"text/javascript\">var daten = \"".$k."\"</script>\n";  
        }
      
      } 
      echo "      </div>\n"; ?>

      <input type='button' value='Add Button' id='addButton'>
      <input type='button' value='Remove Button' id='removeButton'>
      <input type='button' value='Get TextBox Value' id='getButtonValue'>
      <input type="hidden" name="links" id="links" value="<?php echo htmlspecialchars($linksList); ?>">
      
      </td>
    </tr>
    
    <tr> 
      <td>Version</td>
      <td> <input name="version" type="text" id="version" value="<?php echo htmlspecialchars($version); ?>"size="10"></td>
    </tr> 
    
    <tr> 
      <td>Vergeben</td>
      <td>
      	  <select name="lent">
	  <?php
	  	foreach ($lentList as $k => $lendet){
			if($lendet == $lent){
				echo "<option value=\"".$lendet."\" selected>$lendet";
			} else {
				echo "<option value=\"".$lendet."\">$lendet";

			}
		}
	  ?>
	  </select>
	  </td>
    </tr> 
    
    <tr> 
      <td>An Wen</td>
      <td> <input name="lent_name" type="text" id="lent_name" value="<?php echo htmlspecialchars($lent_name); ?>"size="30"></td>
    </tr> 
    
    <tr> 
      <td>Wann</td>
      <td> <input name="lent_date" type="date" id="lent_date" value="<?php echo htmlspecialchars($lent_date); ?>"size="10"></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr> 
      <td colspan=2> <div align="center"> 
          <input type="submit" name="Add Article" value="Speichern">
          &nbsp; 
          <input name="reset" type="reset" id="reset" value="Alle Felder Zur&uuml;cksetzen">
        </div></td>
    </tr>
    
  </table>
</form>


<div id="article_foot" style="background:<?php echo $color; ?>;color:#fff;">
  <p class="right">
    <a href="adminindex.php" class="button">Abbrechen</a>
  </p>
  <p class="left">raw xml file: <a href="<?php echo $open; ?>"><?php echo $file; ?></a></p>
  <div class="clear"></div>
</div>


</article>
</div>  <!-- close #content --> 

<div class="clear"></div>

<?php include("footer.php"); ?>

</div><!-- close #wrap -->

</body>
</html>
<?php
}//end if-else
?>
