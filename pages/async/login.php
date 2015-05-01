<?php
require_once('classes/user.php');
require_once('include/functions.inc.php');

$lang = 'en';
selectLanguage();

if (!isset($_REQUEST['username'])|| !isset($_REQUEST['password'])) die('ERROR: Missing Login Parameter');
if (!isset($_SESSION)) session_start();
$u = new user();
$u->loadByUsername($_REQUEST['username']);

if ($u->auth($_REQUEST['password']) == true) {

  $u->updateLastConn();
  $u->startSession();
  echo "OK";
}
else echo "ERROR";
?>
