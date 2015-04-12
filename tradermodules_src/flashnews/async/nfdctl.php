<?php
  require_once("processctl.php");
  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');
  if (!isset($_REQUEST['action'])) die('No action provided!');

  $pctl = new processctl('nfd');

  if ($_REQUEST['action'] == 'start') $pctl->start();
  else if ($_REQUEST['action'] == 'stop') $pctl->stop();
  else if ($_REQUEST['action'] == 'restart') $pctl->restart();
  else if ($_REQUEST['action'] == 'status') echo $pctl->mode;  

?>