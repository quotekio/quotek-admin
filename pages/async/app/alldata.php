<?php

@require_once('include/functions.inc.php');
@require_once('classes/qatectl.php');
@require_once('classes/corecfg.php');
@require_once('classes/brokercfg.php');
@require_once('classes/backtest.php');

$lang = 'en';
selectLanguage();
@require_once("lang/$lang/app.lang.php");

$res = array ('qatestatus' => array(),
	          'qatecorestats' => array(),
	          'qatelastlogs' => array(),
	          'backteststatuses' => array() );

if (!verifyAuth()) die('You are not logged');

/* 
===========
QATE STATUS
===========
*/

$ac = new qatectl();
$state = $ac->checkStatus($ac->supid);

if ($state == 'on') {

  $acfg = getActiveCfg();
  $brcfg = $acfg->getBroker();
  $state = $brcfg->broker_account_mode;

}


$nr = file_exists('/tmp/qate/needs_restart') ;
$message = $lang_array['app']['qate_mode']["$state"];
$cp_errors = $ac->getCompileErrors();
$res['qatestatus'] = array('state' => $state, 'message' => $message, 'needs_restart' => $nr, 'compile' => $cp_errors );


/* 
=================
BACKTEST STATUSES
=================
*/

$res['backteststatuses'] = array();

$btests = getBacktests();
foreach($btests as $bt) {
  $backctl = new backtestctl($bt);
 
  $state = $backctl->checkStatus($backctl->supid);
  $res['backteststatuses'][] = array('id' => $bt->id , 'state' => $state, 'hasresult' => $bt->hasResult() );
}

echo json_encode($res);

?>

