<?php
session_start();

include("head.php");
?>




<body>

<div id="wrap">
<?php include("header.php") ?>
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
      <td colspan="2"><div align="left" style="margin:10px 0 0 0;"> 
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
      <td colspan="2"><div align="center" style="font-size:96%;margin:-10px 0 30px 86px ;"> 
        <a href="../index.php" style="text-decoration:none;text-shadow:none" class="button">Zur&uuml;ck zur &Uuml;bersicht</a>	
          
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
