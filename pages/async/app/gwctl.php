<?php

  require_once('include/functions.inc.php');

  $lang = 'en';
  selectLanguage();

  require_once("lang/$lang/app.lang.php");
  require_once("classes/brokercfg.php");
  //require_once("lang/$lang/success.lang.php");

  if (!verifyAuth()) die('You are not logged');
  if (!isset($_REQUEST['id']) || !isset($_REQUEST['action'])) {
    die("ERROR: Missing Argument");
  }
  if (!is_numeric($_REQUEST['id'])) die ("ERROR: id is not numeric");

  $gw = new gwctl($_REQUEST['id']);
  
  if ( $_REQUEST['action'] == 'start') {
    $gw->stopGW();
    $gw->startGW();
  }

  else if ( $_REQUEST['action'] == 'stop') {
    $gw->stopGW();
  }
  
  else if ( $_REQUEST['action'] == 'restart') {
    $gw->stopGW();
    $gw->startGW();
  }

  else if ( $_REQUEST['action'] == 'getStatus') {
    $state = $gw->checkStatus();
    //$message = $lang_array['app']['qate_mode']["$state"];
    $res = array('state' => $state);
    echo json_encode($res);
  } 
  
  
  
?>
