<?php

  require_once('include/functions.inc.php');

  if (!verifyAuth()) die('You are not logged');
  if (!  isset($_REQUEST['tinf']) || ! isset($_REQUEST['tsup']) || ! isset($_REQUEST['indice']) ) die ('missing stats parameter');

  if (isset($_REQUEST['resolution'])) {
    $mean = $_REQUEST['resolution'];
  }
  else $mean = 0;

  if (isset($_REQUEST['time_offset'])) {
    $time_offset = $_REQUEST['time_offset'];
  }

  else $time_offset = 0;

  require_once('backendwrapper.php');

  $result = array();


  $tinf = $_REQUEST['tinf'];
  $tsup = $_REQUEST['tsup'];
  $indice = $_REQUEST['indice'];

  $bw = new backendwrapper();

  $result = $bw->query($indice,$tinf,$tsup,$mean,$time_offset);

  echo json_encode($result)


?>
  