<?php
require_once("classes/vhuser.php");
require_once("include/functions.inc.php");
require_once("classes/chilimessage.php");

$lang = 'en';
selectLanguage();

$errhandler = new chilierror($lang);


if (!isset($_REQUEST['username'])|| !isset($_REQUEST['password'])) die('ERROR: Missing Login Parameter');

if (!isset($_SESSION)) session_start();
$vu = new vhuser();
if ($vu->auth($_REQUEST['username'],$_REQUEST['password']) >= 0) {
  
  $vu->load();
  //$cu->updateLastLogin();
  $vu->startSession();
  echo "OK";
}
else $errhandler->printm('ERR_INVALID_LOGIN',true); ;
?>
