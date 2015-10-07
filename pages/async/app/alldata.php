<?php

@require_once('include/functions.inc.php');
@require_once('classes/adamctl.php');
@require_once('classes/corecfg.php');
@require_once('classes/brokercfg.php');
@require_once('classes/backtest.php');

$lang = 'en';
selectLanguage();
@require_once("lang/$lang/app.lang.php");

$res = array ('adamstatus' => array(),
	          'adamcorestats' => array(),
	          'adamlastlogs' => array(),
	          'backteststatuses' => array() );

if (!verifyAuth()) die('You are not logged');

/* 
===========
ADAM STATUS
===========
*/

$ac = new adamctl();
$state = $ac->checkStatus($ac->supid);

if ($state == 'on') {

  $acfg = getActiveCfg();
  $brcfg = $acfg->getBroker();
  $state = $brcfg->broker_account_mode;

}


$nr = file_exists('/tmp/adam/needs_restart') ;
$message = $lang_array['app']['adam_mode']["$state"];
$cp_errors = $ac->getCompileErrors();
$res['adamstatus'] = array('state' => $state, 'message' => $message, 'needs_restart' => $nr, 'compile' => $cp_errors );

/* 
==============
ADAM CORESTATS
==============
*/

if ($ac->AEPStartCLient()) {

  $cs_str = $ac->AEPIssueCmd('corestats');
  $cs = json_decode($cs_str);
  $cs->unrealized_pnl = sprintf("%.2f", $cs->unrealized_pnl);

  $res['adamcorestats'] = $cs;
  
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
=================
BACKTEST STATUSES
=================
*/

$res['backteststatuses'] = array();

$btests = getBacktests();
foreach($btests as $bt) {
  $backctl = new backtestctl();
  $backctl->setBacktestID($bt->id);
  
  $state = $backctl->checkStatus($backctl->supid);
  $res['backteststatuses'][] = array('id' => $bt->id , 'state' => $state, 'hasresult' => $bt->hasResult() );
}

echo json_encode($res);

?>

