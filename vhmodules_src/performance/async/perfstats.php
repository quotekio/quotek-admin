<?php
require_once('include/functions.inc.php');
if (!verifyAuth()) die('You are not logged');
require_once('reach.php');
require_once('backendwrapper.php');
  $r = new reach();
  $reach_data =  $r->getData(date("Y"));

  

  $stats_data = array('goal_data' => array(), 'perf_data' => array() , 'perf_data_negative' => array() );

  $goal_data = array();
  $perf_data = array();
  
  foreach($data as $d) {

     $timestamp = gmmktime (0, 0 , 0 , 1 , 4 + 7*($d['week'] - 1), $d['year']);
     $timestamp *= 1000;

     $stats_data['goal_data'][] = array($timestamp, $d['goal']);
 
     if ($d['performance'] < 0) $stats_data['perf_data_negative'][] = array($timestamp, $d['performance']);
     else if ($d['performance'] == 0) $stats_data['perf_data'][] = array($timestamp, 10 );
     else $stats_data['perf_data'][] = array($timestamp, $d['performance']);

  }
  echo json_encode($stats_data);
?>