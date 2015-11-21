<?php
require_once('include/functions.inc.php');
if (!verifyAuth()) die('You are not logged');

require_once('backendwrapper.php');

$cur_year = gmmktime (0, 0, 0, 1, 1);
$cur_month = gmmktime (0, 0, 0, gmdate("n"), 1);
$cur_week = gmmktime (0, 0 , 0 , gmdate("n"), gmdate("j") - gmdate("N") + 1);
$cur_day = gmmktime (0, 0, 0);

$perf_data = array();

$perf_data['trade_ratios'] = array( 'day' => null, 'week' => null, 'month' => null );
$perf_data['trade_pf'] = array( 'day' => 0, 'week' => 0, 'month' => 0 );
$perf_data['trade_mdd'] = array( 'day' => 0, 'week' => 0, 'month' => 0 );


//fetches historical data from adam backend
$b = new backendwrapper();

$hist_month_data = $b->query_history($cur_month,time(0)); 
$hist_week_data = $b->query_history($cur_week,time(0)); 
$hist_day_data = $b->query_history($cur_day,time(0));

//Process history data and reformats it.
$nbwins = 0;
$nbloss = 0;

$sum_gains = 0;
$sum_losses = 0;

$mdd = 0;
$cmin =  10000000000;
$cmax = -10000000000;


foreach($hist_month_data as $hmd) {
  if ($hmd->pnl > 0) { 
    $nbwins++;
    $sum_gains += $hmd->pnl;
  }
  else {
    $nbloss++;
    $sum_losses += $hmd->pnl;
  }

  if ($hmd->pnl > $cmax) { 
    $cmax = $hmd->pnl;
    $cmin = 1000000000;
  }

  if ($hmd->pnl < $cmin) {
    $cmin = $hmd->pnl;
  }

}

if ( $cmax - $cmin > 0 ) $mdd = $cmax - $cmin;
else $mdd = 0; 

$perf_data['trade_ratios']['month'] = array($nbwins, $nbloss);
if ($sum_losses != 0) $perf_data['trade_pf']['month'] = $sum_gains / abs($sum_losses) ;
else $perf_data['trade_pf']['month'] = 0;
$perf_data['trade_mdd']['month'] = $mdd;


$nbwins = 0;
$nbloss = 0;

$sum_gains = 0;
$sum_losses = 0;

$mdd = 0;
$cmin =  10000000000;
$cmax = -10000000000;

foreach($hist_week_data as $hwd) {
  if ($hwd->pnl > 0) { 
    $nbwins++;
    $sum_gains += $hwd->pnl;
  }
  else {
    $nbloss++;
    $sum_losses += $hwd->pnl;
  }

  if ($hwd->pnl > $cmax) { 
    $cmax = $hwd->pnl;
    $cmin = 1000000000;
  }

  if ($hwd->pnl < $cmin) {
    $cmin = $hwd->pnl;
  }

}

if ( $cmax - $cmin > 0 ) $mdd = $cmax - $cmin;
else $mdd = 0; 

$perf_data['trade_ratios']['week'] = array($nbwins, $nbloss);
if ($sum_losses != 0) $perf_data['trade_pf']['week'] = $sum_gains / abs($sum_losses) ;
else $perf_data['trade_pf']['week'] = 0;
$perf_data['trade_mdd']['week'] = $mdd;

$nbwins = 0;
$nbloss = 0;

$sum_gains = 0;
$sum_losses = 0;

$mdd = 0;
$cmin =  10000000000;
$cmax = -10000000000;

foreach($hist_day_data as $hdd) {
  if ($hdd->pnl > 0) { 
    $nbwins++;
    $sum_gains += $hdd->pnl;
  }
  else {
    $nbloss++;
    $sum_losses += $hdd->pnl;
  }
  if ($hdd->pnl > $cmax) { 
    $cmax = $hdd->pnl;
    $cmin = 1000000000;
  }

  if ($hdd->pnl < $cmin) {
    $cmin = $hdd->pnl;
  }
}

if ( $cmax - $cmin > 0 ) $mdd = $cmax - $cmin;
else $mdd = 0; 

$perf_data['trade_ratios']['day'] = array($nbwins, $nbloss);
if ($sum_losses != 0) $perf_data['trade_pf']['day'] = $sum_gains / abs($sum_losses) ;
else $perf_data['trade_pf']['day'] = 0;
$perf_data['trade_mdd']['day'] = $mdd;


//rounding
$perf_data['trade_pf']['day'] =  floatval( sprintf("%.2f",$perf_data['trade_pf']['day'] )) ;
$perf_data['trade_mdd']['day'] = floatval( sprintf("%.2f",$perf_data['trade_mdd']['day'] )) ;

$perf_data['trade_pf']['week'] = floatval( sprintf("%.2f",$perf_data['trade_pf']['week'] )) ;
$perf_data['trade_mdd']['week'] = floatval( sprintf("%.2f",$perf_data['trade_mdd']['week'] )) ;

$perf_data['trade_pf']['month'] = floatval( sprintf("%.2f",$perf_data['trade_pf']['month'] )) ;
$perf_data['trade_mdd']['month'] = floatval( sprintf("%.2f",$perf_data['trade_mdd']['month'] )) ;


echo json_encode($perf_data);
?>