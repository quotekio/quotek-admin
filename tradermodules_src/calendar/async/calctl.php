<?php

require_once('include/functions.inc.php');

if (!verifyAuth()) die('You are not logged');

require_once ("classes/calendar.php");

if (!isset($_REQUEST['action'])) die ('Missing action parameter');

$action = $_REQUEST['action'];

if ( $action == 'fetchcal') {

  $result = array();

  $year = $_REQUEST['year'];
  $week = $_REQUEST['week'];

  $week_ptr_init = new DateTime();
  $week_ptr_init->setISODate($year, $week);
  $week_ptr_init->setTime(0,0);
  
  $week_ptr_end = new DateTime();
  $week_ptr_end->setTimestamp($week_ptr_init->getTimestamp() + (5*86400));

  $result['dates'] = array();
  $result['dates_tstamp'] = array();

  for ($i=0;$i<5;$i++) {

    $week_ptr = new DateTime();
    $week_ptr->setTimestamp( $week_ptr_init->getTimestamp() + $i * 86400 );

    $result['dates'][] = $week_ptr->format('D d/M');
    $result['dates_tstamp'][] = $week_ptr->getTimestamp();

  }

  //fetch events
  $events = getEvents($week_ptr_init->getTimestamp(),$week_ptr_end->getTimestamp());

  $result['events'] = $events;

  echo json_encode($result);

}

else if ($action == 'export') {

  $data = array();
  
  $year = date("Y");
  $week = date("W");
  $cur_day = date("D");

  if ($cur_day == 'Sat' || $cur_day == 'Sun') $week++;

  $week_ptr_init = new DateTime();
  $week_ptr_init->setISODate($year, $week);
  $week_ptr_init->setTime(0,0);
  
  $week_ptr_end = new DateTime();
  $week_ptr_end->setTimestamp($week_ptr_init->getTimestamp() + (5*86400));
  
  //fetch events
  $events = getEvents($week_ptr_init->getTimestamp(),$week_ptr_end->getTimestamp());

  foreach ($events as $ev) {
    if ($ev->linked_value != "None")  {
      $data[] = array("value" =>  $ev->linked_value , "time" => intval($ev->start) );
    }
  }
  file_put_contents("/tmp/adam/edta.events.json", json_encode($data));

}


else if ($action == 'addevent')  {

  if (!isset($_REQUEST['data'])) die('No data provided!');

  $data = json_decode($_REQUEST['data']);
  $evt = new calendar_event();
  $evt->remap($data);
  $evt->save();

}

else if ($action == 'delevent')  {

  if (!isset($_REQUEST['id'])) die('No id provided!');

  $evt = new calendar_event();
  $evt->id = $_REQUEST['id']; 
  $evt->load();
  $evt->delete();
}

?>