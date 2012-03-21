<?php

if (!empty($_REQUEST['file'])) {
  
  $filereq = str_replace($r1,$r2,$_REQUEST['file']);
  
  // Wenn ein Dateiname verwendet wird, zeige den Fileheader    
  echo '
<header>
  <div class="search">
    <form name="search" method="post" action="searchArticles.php">    
      <input name="search" type="text" id="search" placeholder="Suchen">    
      <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <a href="adminindex.php" class="button login">Admin</a>
  </div>
  <div id="headnav"> 
    <h1>OML | Online Media Library</h1> 
  </div>
  <div id="header-time">
    <script type="text/javascript">writeclock() </script> 
  </div>
</header>
  ';
} else {
  // Andernfalls 
  $url_raw = str_replace($r1,$r2,$url);

  if ($url == "index.php") {
    // bei der index.php Datei zeigen wir den Indexheader
    echo '
<header>
  <div class="search">
    <form name="search" method="post" action="inc/searchArticles.php">    
      <input name="search" type="text" id="search" placeholder="Suchen">    
      <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <a href="inc/adminindex.php" class="button login">Admin</a>
  </div>
  <div id="headnav"> 
    <h1>OML | Online Media Library</h1> 
  </div>
  <div id="header-time">
    <script type="text/javascript">writeclock() </script> 
  </div>
</header>
    ';


  } else if ($url == "createArticle.php") {
    echo '
<header>
  <div class="search">
    <form name="search" method="post" action="searchArticles.php">    
     <input name="search" type="text" id="search" placeholder="Suchen">    
     <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <a href="adminindex.php" class="button login">Admin</a>
  </div>
  <div id="headnav"> 
    <h1>OML | Online Media Library</h1>  
  </div>

  <div id="header-time">
     <script type="text/javascript">writeclock()</script> 
  </div>

</header>';
  } else if ($url == "adminindex.php") {
    echo '
<header>
  <div class="search">
    <form name="search" method="post" action="searchArticles.php">    
     <input name="search" type="text" id="search" placeholder="Suchen">    
     <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <a href="logout.php" class="button login">Logout</a>
  </div>
  <div id="headnav"> 
    <h1>OML | Online Media Library</h1>  
  </div>

  <div id="header-time">
     <script type="text/javascript">writeclock()</script> 
  </div>

</header>';
  } else {
    // Auf allen anderen Seiten zeigen wir den Adminheader
    echo '
<header>
  <div class="search">
    <form name="search" method="post" action="searchArticles.php">    
     <input name="search" type="text" id="search" placeholder="Suchen">    
     <button name="Search" type="submit" id="Search">Suchen</button>    
    </form>  
    <a href="adminindex.php" class="button login">Admin</a>
  </div>
  <div id="headnav"> 
    <h1>OML | Online Media Library</h1> 
  </div>
  <div id="header-time">
    <script type="text/javascript">writeclock() </script> 
  </div>
</header>
    ';
  }
}
?>

