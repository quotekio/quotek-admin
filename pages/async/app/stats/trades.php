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
$perf_data['trade_apnls'] = array( 'day' => 0, 'week' => 0, 'month' => 0 );
$perf_data['trade_apnlps'] = array( 'day' => 0, 'week' => 0, 'month' => 0 );


//fetches historical data from adam backend
$b = new backendwrapper();

$hist_month_data = $b->query_history($cur_month,time(0)); 
$hist_week_data = $b->query_history($cur_week,time(0)); 
$hist_day_data = $b->query_history($cur_day,time(0));

//Process history data and reformats it.
$nbwins = 0;
$nbloss = 0;

foreach($hist_month_data as $hmd) {
  if ($hmd->pnl > 0) $nbwins++;
  else $nbloss++;
  $perf_data['trade_apnls']['month'] += $hmd->pnl;
  $perf_data['trade_apnlps']['month'] += $hmd->pnl_peak;
}
$perf_data['trade_ratios']['month'] = array($nbwins, $nbloss);

if (count($hist_month_data) > 0) {
  $perf_data['trade_apnls']['month'] /= count($hist_month_data);
  $perf_data['trade_apnlps']['month'] /= count($hist_month_data);
}

$nbwins = 0;
$nbloss = 0;

foreach($hist_week_data as $hwd) {
  if ($hwd->pnl > 0) $nbwins++;
  else $nbloss++;
  $perf_data['trade_apnls']['week'] += $hwd->pnl;
  $perf_data['trade_apnlps']['week'] += $hwd->pnl_peak;
}
$perf_data['trade_ratios']['week'] = array($nbwins, $nbloss);

if (count($hist_week_data) > 0) {
  $perf_data['trade_apnls']['week'] /= count($hist_week_data);
  $perf_data['trade_apnlps']['week'] /= count($hist_week_data);
}

$nbwins = 0;
$nbloss = 0;

foreach($hist_day_data as $hdd) {
  if ($hdd->pnl > 0) $nbwins++;
  else $nbloss++;
  $perf_data['trade_apnls']['day'] += $hdd->pnl;
  $perf_data['trade_apnlps']['day'] += $hdd->pnl_peak;

}
$perf_data['trade_ratios']['day'] = array($nbwins, $nbloss);

if (count($hist_day_data) > 0) {
  $perf_data['trade_apnls']['day'] /= count($hist_day_data);
  $perf_data['trade_apnlps']['day'] /= count($hist_day_data);
}

echo json_encode($perf_data);
?>