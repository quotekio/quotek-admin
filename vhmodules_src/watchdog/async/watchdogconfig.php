<?php

  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');
  global $dbhandler;

  if (!isset($_REQUEST['action'])) die ('action not provided');

  switch ($_REQUEST['action']) {

    case "enable_adam":
      $dbhandler->query("UPDATE watchdog_cfg set check_adam = 1");
      break;
    case "disable_adam":
      $dbhandler->query("UPDATE watchdog_cfg set check_adam = 0");
      break;
    case "enable_gateway":
      $dbhandler->query("UPDATE watchdog_cfg set check_gateway = 1");
      break;
    case "disable_gateway":
      $dbhandler->query("UPDATE watchdog_cfg set check_gateway = 0");
      break;
      
  }


?>