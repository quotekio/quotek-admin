<?php
require_once('include/functions.inc.php');
if (!verifyAuth()) die('You are not logged');

require_once('reach.php');
require_once('backendwrapper.php');

$cur_year = date("Y");
$cur_month = date("M");
$cur_week = date("W");
$cur_day = date("D");

$result = array();

//fetches reach data
$r = new reach();
$reach_raw_data =  $r->getData();

//fetches historical data from adam backend
$b = new backendwrapper();

$hist_month_data = $b->query_history($cur_month,time(0)); 
$hist_week_data = $b->query_history($cur_week,time(0)); 
$hist_day_data = $b->query_history($cur_day,time(0));

//Processes Reach DATA and reformats it.
$reach_data = array('goal_data' => array(), 'perf_data' => array() , 'perf_data_negative' => array() );
foreach($reach_raw_data as $d) {

  $timestamp = gmmktime (0, 0 , 0 , 1 , 4 + 7*($d['week'] - 1), $d['year']);
  $timestamp *= 1000;

  $reach_data['goal_data'][] = array($timestamp, $d['goal']);

  if ($d['performance'] < 0) $reach_data['perf_data_negative'][] = array($timestamp, $d['performance']);
  else if ($d['performance'] == 0) $reach_data['perf_data'][] = array($timestamp, 10 );
  else $reach_data['perf_data'][] = array($timestamp, $d['performance']);

}

//Process history data and reformats it.
foreach($hist_month_data as $hmd) {

  


}




$result['reach'] = $reach_data;
$result['perf'] = $perf_data;

echo json_encode($result);
?>