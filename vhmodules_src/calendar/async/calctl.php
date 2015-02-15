<?php

require_once('include/functions.inc.php');
if (!verifyAuth()) die('You are not logged');

include ("classes/calendar.php");

if (!isset($_REQUEST['action'])) die ('Missing action parameter');

$action = $_REQUEST['action'];

if ( $action == 'fetchcal') {

  $result = array();

  $year = $_REQUEST['year'];
  $week = $_REQUEST['week'];

  $week_ptr_init = new DateTime();
  $week_ptr_init->setISODate($year, $week);
  $week_ptr_init->setTime(0,0);

  $result['dates'] = array();
  $result['dates_tstamp'] = array();

  for ($i=0;$i<5;$i++) {

    $week_ptr = new DateTime();
    $week_ptr->setTimestamp( $week_ptr_init->getTimestamp() + $i * 86400 );

    $result['dates'][] = $week_ptr->format('D d/M');
    $result['dates_tstamp'][] = $week_ptr->getTimestamp();

  }

  echo json_encode($result);

}

else if ($action == 'addevent')  {

  



}


?>