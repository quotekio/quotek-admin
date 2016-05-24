<?php

  require_once('include/functions.inc.php');
  @require_once('classes/valuecfg.php');
  @require_once('classes/corecfg.php');

  $lang = 'en';
  selectLanguage();

  require_once("lang/$lang/app.lang.php");
  require_once("classes/backtest.php");
  require_once("classes/corecfg.php");


  if (!verifyAuth()) die('You are not logged');  
  if (!isset($_REQUEST['action'])) die('No action provided!');
  
  if (isset($_REQUEST['id'])) {

    $btest = new backtest();
    $btest->id = $_REQUEST['id'];
    $btest->load();
    
    $bctl = new backtestctl($btest);

  }
  
  if ( $_REQUEST['action'] == 'start') {

    if (!is_dir("$QATE_TMP/backtests/" . $btest->id) ) $btest->createTree();

    exportCfg($btest->config_id,$btest->strategy_id,"$QATE_TMP/backtests/" . $btest->id . "/qate.conf", false);

    if ($btest->type == 'genetics') {
      $btest->appendGeneticsParams();
    }

    $bctl->startBT();
  }

  else if ( $_REQUEST['action'] == 'stop') {
    $bctl->stopBT();
  }
  
  else if ( $_REQUEST['action'] == 'restart') {
    $bctl->stopBT();
    exportCfg();
    $bctl->startBT();
  }

  else if ($_REQUEST['action'] == 'getWebSocket') {
    echo $bctl->getWebSocket();
  }
  

  else if ( $_REQUEST['action'] == 'getStatus') {

    $state = $bctl->checkStatus($bctl->supid);
    $message = $lang_array['app']['qate_mode']["$state"];
    $res = array('state' => $state, 'message' => $message);
    echo json_encode($res);
  } 
  
  
  else if ($_REQUEST['action'] == 'getResult') {
    if (!isset($_REQUEST['result'])) die ("No result to return");
    $response = array();
    $response['result'] = $btest->getResult($_REQUEST['result']);
    echo json_encode($response);
  }

  else if ($_REQUEST['action'] == 'deleteResult') {
    if (!isset($_REQUEST['result'])) die ("No result to delete");
    $response = array();
    $btest->deleteResult($_REQUEST['result']);
    echo "OK";
  }

 
  else if ($_REQUEST['action'] == 'getAllStatus') {

    $res = array();
    $btests = getBacktests();
    foreach($btests as $bt) {
      $backctl = new backtestctl($bt);
      
      if ($backctl->checkStatus($backctl->expid) == "real") {
        $state = "preparing";
      }

      else $state = $backctl->checkStatus($backctl->supid);

      $res[] = array('id' => $bt->id , 'state' => $state, 'hasresult' => $bt->hasResult() );

    }
    echo json_encode($res);
  }

?>