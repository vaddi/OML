<?php
session_start();

if (PHP_VERSION>='5') require_once('ext/domxml-php4-to-php5/domxml-php4-to-php5.php');

include("head.php");
include("functions.php");

if ($_SESSION["login"] != "true"){
	header("Location:login.php");
	$_SESSION["error"] = "<font color=red>Sie haben nicht die erforderlichen Rechte f&uuml;r die Adminseite</font>";
	exit;
}

$folder = "../xml/";
if (is_writable($folder)) {
  // Alles ok
} else {
  echo 'Im Ordner '.$folder.' kann nicht geschrieben werden';
}

$id = "";
$isbn = "";
$headline = "";
$authors = "";
$keywords = "";
$color = "#BBBBBB";
$cfs = "32pt";
$image = "";
$abstract = "";
$index = "";
$description = "";
$colophone = "";
$link = "";
$links = "1";
$version = "";
$lent = "";
$lent_name = "";
$lent_date = "";

$linkList = split_words($links, $max = 1);
$linksList = count($linkList);
$lentList = array("false" => "im Regal", "true" => "verliehen");

?>

<body>

<div id="wrap">
<?php include("header.php") ?>
<div id="content">

<article>

<header id="header_small" style="background:<?php echo $color; ?>;color:#fff;">
  <span class="right" style="margin:-2px 0 0 0;">
    <a href="adminindex.php" class="button">Abbrechen</a>
  </span>
  <h1>Neues Buch erstellen</h1>
</header>


<form name="createArticle" action="addArticle.php" method="post" onSubmit="return isReady(this)" id="createArticle">
  <table>
    <tr> 
      <td width="135">Buch ID</td>
      <td width="634"> <input name="id" type="text" id="id"> <font size="-1">(Keine Freizeichen, Muss einzigartig sein!)</font></td>
    </tr>

    <tr> 
      <td>ISBN</td>
      <td> <input name="isbn" type="text" id="isbn" value="<?php echo htmlspecialchars($isbn); ?>" size="42"></td>
    </tr>

    <tr>
      <td>Status</td>
      <td>In Progress <input type="hidden" name="status" value="in bearbeitung"></td>
    </tr>
    <tr> 
      <td>&Uuml;berschrift</td>
      <td> <input name="headline" type="text" id="headline" size="42"></td>
    </tr>
    <tr> 
      <td>Authoren</td>
      <td> <input name="authors" type="text" id="authors" value="<?php echo htmlspecialchars($authors); ?>"size="42"></td>
    </tr>
    <tr> 
      <td>Schlagw&ouml;rter</td>
      <td>  
          <input name="keywords" type="text" value="<?php echo htmlspecialchars($keywords); ?>">
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
          <li>2. [a=TEXT1]TEXT2[/a] => &lt;a name="TEXT1"&gt;TEXT2&lt;/a&gt;, Anker</li>
          <li>3. [url]TEXT1[/url] => &lt;a href="TEXT"&gt;TEXT&lt;/a&gt;, einfache URLs</li>
          <li>3. [url=TEXT1]TEXT2[/url] => &lt;a href="TEXT1"&gt;TEXT2&lt;/a&gt;, URLs mit Text</li>
          <li>4. [img]TEXT[/img] => &lt;img src="TEXT" alt="TEXT" /&gt;, Bilder</li>
          <li>5. Alle URL Angaben (http://domain.tld/) werden automatisch in klickbaren Links dargestellt.</li>
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
        echo '      <label>#'.$k.' </label><input type="text" name="link[]" id="link'.$k.'" value="" size="40" /><br />'."\n      ";
        echo "</div>\n";
      
        if ($k == $vali) {
          $k = $k+1;
          echo "      <script type=\"text/javascript\"><!--
              var daten = \"".$k."\";
              </script>\n";  
        }
      
      } 
      echo "      </div>\n"; ?>

      <input type='button' value='Link hinzuf&uuml;gen' id='addButton'>
      <input type='button' value='Link entfernen' id='removeButton'>
<!--      <input type='button' value='Get TextBox Value' id='getButtonValue'>-->
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
          <input type="submit" name="Add Article" value="Buch erstellen">
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
  <p class="left">&nbsp;</p>
  <div class="clear"></div>
</div>


</article>
</div>  <!-- close #content --> 

<?php include("footer.php"); ?>

</div><!-- close #wrap -->
<div class="clear"></div>

</body>
</html>

