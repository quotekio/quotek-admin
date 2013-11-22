<?php

  require_once('include/functions.inc.php');

  if (!verifyAuth()) die('You are not logged');
  if (!isset($_REQUEST['graph']) ) die('graph not provided');

  global $dbhandler;

  if ($_REQUEST['graph'] == 'corestats_pnl') {

    $pnl = array();
    $pnl['label'] = "PNL";
    $pnl['data'] = array();
    $pnl['lines'] = array('fill' => false, 'lineWidth' => 2);
    $pnl['color'] = '#779148';

    $stime = time() - 3600;
    $dbh = $dbhandler->query("SELECT t,pnl FROM corestats_history WHERE t > '$stime';");

    while( $ans = $dbh->fetch() ) {
      $pnl['data'][] = array( ($ans['t'] + (2*3600) ) * 1000 , $ans['pnl']  );
    }

    echo json_encode(array($pnl));
  
  }

  else if ($_REQUEST['graph'] == 'corestats_nbpos') {

    $nbpos = array();
    $nbpos['label'] = "NBPOS";
    $nbpos['data'] = array();
    $nbpos['lines'] = array('fill' => false, 'lineWidth' => 2);
    $nbpos['color'] = '#6E97AA';

    $stime = time() - 3600;
    $dbh = $dbhandler->query("SELECT t,nbpos FROM corestats_history WHERE t > '$stime';");

    while( $ans = $dbh->fetch() ) {
      $nbpos['data'][] = array( ($ans['t'] + (2*3600) ) * 1000 , $ans['nbpos']  );
    }

    echo json_encode(array($nbpos));
  
  }





?>