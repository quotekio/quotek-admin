<?php

require_once( dirname(__FILE__) . '/../conf/config.inc.php');
require_once('conf/routingdata.inc.php');
require_once('include/corefct.inc.php');

$corrected_uri = strtolower($_SERVER['REQUEST_URI']);
$corrected_uri  = preg_replace('/\?.*/','',$corrected_uri);
$corrected_uri = str_replace('.php','',$corrected_uri);

if ($corrected_uri != '/') {
  $corrected_uri = rtrim($corrected_uri,'/');
}

$realip = getRealIP();

/* Load Modules */
require_once ('classes/vhmodule.php');
$vhms = loadVHModules();


if (! include('pages/' . $routing[$corrected_uri])) {
  header('HTTP/1.0 404 Not Found');
}

?>
