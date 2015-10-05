<?php

  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');
  require_once('backendwrapper.php');

  if (! isset($_REQUEST['scale']) ) die('Invalid Scale!');

  //fetches historical data from adam backend
  $b = new backendwrapper();

  $scale = $_REQUEST['scale'];
  
  $result = array( 'perf' => array(),
                   'perf_negative' => array() );


  if ($scale == 'day') {

    $cday = gmmktime (0, 0, 0);
    
    for ($i=0;$i<24;$i++) {

      $hourly_pnl = 0;
      $data = $b->query_history($cday,$cday + 3600 );

      foreach ( $data as $d ) {
        $hourly_pnl += $d->pnl;
      }

      if ( $hourly_pnl < 0 ) {
        $result['perf_negative'][] = array( $cday * 1000 , $hourly_pnl );
      }

      else {
        $result['perf'][] = array( $cday * 1000 , $hourly_pnl );
      }
  

      $cday += 3600;

    }
    
  }


  else if ($scale == 'month') {

    $cmonth = gmmktime (0, 0, 0, gmdate("n"), 1);
    $nbdays = date("t");

    for ($i=0;$i< $nbdays; $i++) {

      $daily_pnl = 0;
      $data = $b->query_history($cmonth,$cmonth + 86400 );

      foreach ( $data as $d ) {
        $daily_pnl += $d->pnl;
      }

      if ( $daily_pnl < 0 ) {
        $result['perf_negative'][] = array( $cmonth * 1000 , $daily_pnl );
      }

      else {
        $result['perf'][] = array( $cmonth * 1000 , $daily_pnl );
      }
  

      $cmonth += 86400;

    }
    
  }

  else if ($scale == 'year') {

    $cyear =  gmmktime (0, 0, 0, 1, 1);

    for ($i=0;$i< 52 ; $i++) {

      $weekly_pnl = 0;
      $data = $b->query_history($cyear,$cyear + 7 * 86400 );

      foreach ( $data as $d ) {
        $weekly_pnl += $d->pnl;
      }

      if ( $weekly_pnl < 0 ) {
        $result['perf_negative'][] = array( $cyear * 1000 , $weekly_pnl );
      }

      else {
        $result['perf'][] = array( $cyear * 1000 , $weekly_pnl );
      }

      $cyear += 7 * 86400;

    }
    
  }




  echo json_encode($result);

?>