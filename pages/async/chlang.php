<?php
  require_once('include/functions.inc.php');
  if (!isset($_REQUEST['lang'])) die('ERROR: No language provided');

  foreach($LANG_LIST as $key => $value) {
    if ($_REQUEST['lang'] == $key) {
      session_start();
      $_SESSION['lang'] = $_REQUEST['lang'];
      die("OK");
    }
  }
  die('ERROR: Choosen Language is not supported');
?>
