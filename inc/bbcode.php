<?php
  // Simple BBCode 
  //
  // include("bbcode.php");
  // $STRING = preg_replace($bbcode_regex, $bbcode_replace,$STRING);
  
  // 0 [url=TEXT1]TEXT2[/url] => <a href=TEXT1>TEXT2</a>    ALL URLs with Textattachment
  // 1 [url]TEXT[/url] => <a href=TEXT>TEXT</a>             All single URLs and Anchors
  // 2 [a=TEXT1]TEXT2[/a] => <a name=TEXT1>TEXT2</a>        All Anchors
  // 3 [img=TEXT1]TEXT2[/img] => <img src=TEXT1 alt=TEXT2 /> All Images
  // 4 [b]TEXT[/b] => <b>TEXT</b>                           ALL other SINGLE Elements (also i and u)
  // 5 [h1]TEXT[/h1] => <h1>TEXT</h1> => <i>TEXT</i>        ALL other DOUBLE NUMBER
  // 6 [quote=TEXT1]TEXT2[/quote] => <quote=TEXT1>TEXT2</quote> ALL other SINGLE Elements with Attribute

  $bbcode_regex = array(
    0 => '/\[url\=(.+?)](.+?)\[\/url\]/s',
    1 => '/\[url\](.+?)\[\/url\]/s',
    2 => '/\[a\=(.+?)](.+?)\[\/a\]/s',
    3 => '/\[img\=(.+?)](.+?)\[\/img\]/s',
    4 => '/\[(.+?)\](.+?)\[\/(.+?)\]/s',
    5 => '/\[(.+?)(.+?)\](.+?)\[\/(.+?)(.+?)\]/s',
    6 => '/\[(.+?)\=(.+?)](.+?)\[\/(.+?)\]/s');
      
  $bbcode_replace = array(
    0 => '<a href="$1">$2</a>',
    1 => '<a href="$1">$1</a>', 
    2 => '<a name="$1">$2</a>',
    3 => '<img src="$1" alt="$2" />',
    4 => '<$1>$2</$1>', 
    5 => '<$1$2>$3</$4$5>', 
    6 => '<$1=$2>$3</$1>');
?>
