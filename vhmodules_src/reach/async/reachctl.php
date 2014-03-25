<?php

require_once('include/functions.inc.php');
if (!verifyAuth()) die('You are not logged');

include ("classes/reach.php");

$r = new reach();

if (!isset($_REQUEST['action'])) die ('Missing action parameter');

switch ($_REQUEST['action']) {

  case "changeGoal":

    if (!isset($_REQUEST['newgoal']) ) die('Missing new goal to setup.');

    $r->changeGoal($_REQUEST['newgoal']);
    break;

}


?>