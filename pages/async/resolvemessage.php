<?php

require_once('classes/chilimessage.php');
require_once('include/functions.inc.php');

$lang='en';
selectLanguage();

$errhandler = new chilierror($lang);

if (!isset($_REQUEST['id'])) die($errhandler->getMessage('ERR_MISSING_REQDATA',true) );
if (!isset($_REQUEST['type'])) die($errhandler->getMessage('ERR_MISSING_REQDATA',true));

if ($_REQUEST['type'] == 'error') {
  $errhandler->printm($_REQUEST['id']);
}

else if ($_REQUEST['type'] == 'success') {
  $succhandler = new chilisuccess($lang);
  $succhandler->printm($_REQUEST['id']);
}

?>