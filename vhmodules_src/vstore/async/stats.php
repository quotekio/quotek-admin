<?php

  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');
  if (!  isset($_REQUEST['year']) || ! isset($_REQUEST['month']) ) die ('missing stats parameter');
  require_once('vstore.php');
  $vs = new vstore();

  $stats =  $vs->getStats($_REQUEST['year'],$_REQUEST['month']);
  echo json_encode($stats);
?>
