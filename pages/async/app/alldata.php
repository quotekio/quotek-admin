<?php

@require_once('include/functions.inc.php');
@require_once('classes/adamctl.php');
@require_once('classes/brokercfg.php');
@require_once('classes/backtest.php');

$lang = 'en';
selectLanguage();
@require_once("lang/$lang/app.lang.php");

$res = array ('adamstatus' => array(),
	          'adamcorestats' => array(),
	          'adamlastlogs' => array(),
	          'gwstatuses' => array(),
	          'backteststatuses' => array() );

if (!verifyAuth()) die('You are not logged');

/* 
===========
ADAM STATUS
===========
*/

$ac = new adamctl();
$state = $ac->checkStatus($ac->supid);
$nr = file_exists('/tmp/adam/needs_restart') ;
$message = $lang_array['app']['adam_mode']["$state"];
$res['adamstatus'] = array('state' => $state, 'message' => $message, 'needs_restart' => $nr );

/* 
==============
ADAM CORESTATS
==============
*/

if ($ac->AEPStartCLient()) {

  $cs_str = $ac->AEPIssueCmd('corestats');
  $cs = json_decode($cs_str);

  if (isset($cs->pnl) ) {
    global $dbhandler;
    $t = time();
    $qstr = sprintf("INSERT INTO corestats_history (t,pnl,nbpos) VALUES ('%d','%f','%d');" , $t,$cs->pnl,$cs->nbpos);
    $dbh = $dbhandler->query($qstr);
    $ans = $dbh->execute();
  }
   $res['adamcorestats'] =  $cs;
  
}

/*
=============
ADAM LASTLOGS
=============
*/

if ($ac->AEPStartCLient()) {
  $cs_str = $ac->AEPIssueCmd('lastlogs 10');
  $cs = json_decode($cs_str);
  $res['adamlastlogs'] = $cs;
}

/*
===========
GW STATUSES
===========
*/

$brokers = getBrokerConfigs();
foreach($brokers as $broker) {
  if ($broker->requiresGW() != "") {
    $gw = new gwctl($broker->id);
    $state = $gw->checkStatus();
    $res['gwstatuses'][] = array('id' => $broker->id ,'state' => $state);
  }
}

/* 
=================
BACKTEST STATUSES
=================
*/

$res['backteststatuses'] = array();

$btests = getBacktests();
foreach($btests as $bt) {
  $backctl = new backtestctl();
  $backctl->setBacktestID($bt->id);
  
  if ($backctl->checkStatus($backctl->expid) == "real") {
    $state = "preparing";
  }
  else $state = $backctl->checkStatus($backctl->supid);
  $res['backteststatuses'][] = array('id' => $bt->id , 'state' => $state, 'hasresult' => $bt->hasResult() );
}

echo json_encode($res);

?>

