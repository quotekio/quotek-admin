<?php

  require_once('include/functions.inc.php');
  require_once('classes/vstore.php');

  if (!verifyAuth()) die('You are not logged');
  if (!isset($_REQUEST['action'])) die ('no action provided');

  $vs = new vstore();

  switch ($_REQUEST['action']) {

    case "clearAll":
      $vs->clearAll();
      break;

    case "clear":

      if (!isset($_REQUEST['table'])) die ('No table provided');
      $vs->clear($_REQUEST['table']); 
      break;

  }





?>