<?php

require_once('include/functions.inc.php');
if (!verifyAuth()) die('You are not logged');
if (!  isset($_REQUEST['year']) ) die ('missing stats parameter');
require_once('reach.php');
  $r = new reach();

  $data =  $r->getData($_REQUEST['year']);
  echo json_encode($data);


?>