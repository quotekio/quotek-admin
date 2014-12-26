<?php

  require_once('include/functions.inc.php');

  if (!verifyAuth()) die('You are not logged');
  if (!  isset($_REQUEST['tinf']) || ! isset($_REQUEST['tsup']) || ! isset($_REQUEST['indice']) ) die ('missing stats parameter');

  require_once('backendwrapper.php');

  $result = 


  $tinf = $_REQUEST['tinf'];
  $tsup = $_REQUEST['tsup'];
  $indice = $_REQUEST['indice'];

  $bw = new backendwrapper();

  
  

  return json_encode($result)


?>
  