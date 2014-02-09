<?php

  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');

  global $dbhandler;

  $result = array( 'adam_uptime' => 0 ,
                   'adam_nbrestart' => 0, 
  	               'adam_uptime_10h' => array() ,
  	               'gateway_uptime' => 0 ,
  	               'gateway_nbrestart' => 0,
  	               'gateway_uptime_10h' => array() ); 

  $time_lim_inf = time() - ( 10 * 3600 );

  $dbh = $dbhandler->query("SELECT * FROM watchdog_stats WHERE tstamp >= '$time_lim_inf' ORDER BY tstamp DESC ;");

  $wd_data = $dbh->fetchAll();

  foreach ( $wd_data as $line ) {

    if ($line['adam_alive'] == 1 ) {
      $result['adam_uptime'] ++;  
    }
    else $result['adam_nbrestart']++;

    if ( $line['gateway_alive'] == 1  ) {
      $result['gateway_uptime']++;
    }
    else $result['gateway_nbrestart']++;
    
    $result['adam_uptime_10h'][] = array ( $line['tstamp'] * 1000, $line['adam_alive'] );
    $result['gateway_uptime_10h'][] = array ( $line['tstamp'] * 1000, $line['gateway_alive'] );

  }

  $result['adam_uptime'] /= count($wd_data);
  $result['gateway_uptime'] /= count($wd_data);



  print json_encode($result);
  
?>
