<?php
session_start();
?>
<html>
<title>Anmelden</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" type="text/css" rel="stylesheet" media="screen" />
<script src="js/datum.js" type="text/javascript"></script>
<script type="text/javascript">
if (navigator.userAgent.toLowerCase().indexOf('chrome')!=-1){
  document.write('<link rel="stylesheet" type="text/css" href="css/chrome.css"/>');
}
</script>
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


<form name="login" method="post" action="verify.php" id="createArticle">
<table width="290" border="0" align="center" cellpadding="4" cellspacing="1">
    <tr> 
      <td colspan="2"><div align="left">Bitte Anmelden</div> 
      </td>
    </tr>
    <tr> 
      <td colspan="2"><div align="left"> 
          <input name="username" type="text" id="username" placeholder="Benutzername" />
        </div></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="left"> 
          <input name="password" type="password" id="password" placeholder="Passwort" />
        </div></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="left"> 
          <input class="button" type="submit" name="Submit" value="Anmelden" />
           
          <input class="button" type="reset" name="reset" id="reset" value="Zur&uuml;cksetzen" />
        </div></td>
    </tr>

	<tr>
	<td colspan=2 align=center>
	<?php // echo $_SESSION["error"]; ?>
	</td>

  </table>
</form>

<table width="290" border="0" align="center" cellpadding="4" cellspacing="1">
    <tr> 
      <td colspan="2"><div align="center" style="font-size:105%;margin:-10px 0 30px 60px ;"> 
        <a href="index.php" style="text-decoration:none;" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>	
          
        </div>
      </td>
    </tr> 
</table>

</article>
</div>  <!-- close #content --> 

<?php include("footer.php"); ?>

</div><!-- close #wrap -->
<div class="clear"></div>

</body>
</html>
