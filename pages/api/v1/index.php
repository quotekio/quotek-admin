<?php
require_once(dirname(__FILE__) . 'classes/chiliuser.php') ;
require_once(dirname(__FILE__) . 'include/functions.inc.php');


if (!isset($_REQUEST['action'])) die ('ERROR: action not provided');
$action = $_REQUEST['action'];

switch ($action) {

  case "login":
    if (!(isset($_REQUEST['username'])  && isset($_REQUEST['password']))) die('ERROR: cannot login, missing login or password');

    $cu = new chiliuser();
    if ($cu->auth($_REQUEST['username'],$_REQUEST['password'])<0) die('ERROR: invalid login and/or password');
    $cu->startSession();
    echo "OK";
 
    break;

  case "sendSysProfile":

    


  break;

  case "getLastConfig":
    if (!verifyAuth()) die('ERROR: you are not logged in to use the CC API');
    if (!isset($_REQUEST['module'])) die('ERROR: module name not provided');
  break;

  case "getAPIInfos":
    apiinfos();
  break;

}

?>
