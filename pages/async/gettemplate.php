<?php

  require_once('include/functions.inc.php' );
  $lang = 'en';
  selectLanguage();
  setlocale (LC_TIME, $lang . '_' . strtoupper($lang) . '.UTF-8');
  require_once("lang/$lang/main.lang.php");

  if (!isset($_REQUEST['tpl'])) die ('ERROR:invalid template provided');

  $tpl = $_REQUEST['tpl'] . ".tpl.php";
  $lang_ext = $_REQUEST['tpl'] . ".lang.php";

  include ("lang/$lang/app.lang.php");
  @include("lang/$lang/templates/" . $lang_ext);  
  require_once("templates/" . $tpl);

?>
