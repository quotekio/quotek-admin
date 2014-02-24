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

    $bctl = new backtestctl();
    $bctl->setBacktestID($btest->id);

    $hash = $btest->generateDumpSig();
    $dumpfile = $ADAM_BT_EXPORTS . "/" . $hash;

    /* Generate Backtest Arguments */
    $bt_args = array();
    $bt_args[] = "-p " . ($ADAM_AEP_PORT + $btest->id );  
    if ($btest->type == 'normal') {
        $bt_args[] = '--backtest';
    }
    else if ($btest->type == 'genetics') {
        $bt_args[] = '--genetics';
    }

    $bt_args[] = '--backtest-dump ' . $dumpfile;
    $bt_args[] = '--backtest-speed ' . $btest->speed;
    $bt_args[] = '--backtest-result ' .  $ADAM_TMP . "/backtests/" .  $btest->id . "/results/" . time() ;
    $bt_args[] = "$ADAM_TMP/backtests/" . $btest->id . "/adam.conf";
    /* */
  }
  
  
  if ( $_REQUEST['action'] == 'start') {

    if (!is_dir("$ADAM_TMP/backtests/" . $btest->id) ) $btest->createTree();

    exportCfg($btest->config_id,$btest->strategy_id,"$ADAM_TMP/backtests/" . $btest->id . "/adam.conf", false);

    if ($btest->type == 'genetics') {
      $btest->appendGeneticsParams();
    }

    $bctl->setBTArgs($bt_args);
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

  else if ( $_REQUEST['action'] == 'getStatus') {

    $state = $bctl->checkStatus($bctl->supid);
    $message = $lang_array['app']['adam_mode']["$state"];
    $res = array('state' => $state, 'message' => $message);
    echo json_encode($res);
  } 
  
  else if ($_REQUEST['action'] == 'getCorestats') {
    
    if ($bctl->AEPStartCLient($btest->id)) {
      $cs_str = $bctl->AEPIssueCmd('corestats');
      echo $cs_str;
    }
    else {
      echo "{}";
    }
  }  

  else if ($_REQUEST['action'] == 'getProgress') {
    
    if ($bctl->AEPStartCLient($btest->id)) {
      $cs_str = $bctl->AEPIssueCmd('btprogress');
      echo $cs_str;
    }
    else echo "{}";
  }  

  else if ($_REQUEST['action'] == 'getLastLogs') {

    if (isset($_REQUEST['nb_entries']) && is_numeric($_REQUEST['nb_entries'])) {

      if ($bctl->AEPStartCLient($btest->id)) {
        echo $bctl->AEPIssueCmd('lastlogs ' . $_REQUEST['nb_entries']);
      }
      else echo "{}";  
    }
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
      $backctl = new backtestctl();
      $backctl->setBacktestID($bt->id);
      
      if ($backctl->checkStatus($backctl->expid) == "real") {
        $state = "preparing";
      }

      else $state = $backctl->checkStatus($backctl->supid);

      $res[] = array('id' => $bt->id , 'state' => $state, 'hasresult' => $bt->hasResult() );
      //echo "SUPID:" . $backctl->supid; 


    }
    echo json_encode($res);
  }

  /*
  else if ($_REQUEST['action'] == 'getPosList') {
    if ($ac->AEPStartCLient()) {
      echo $ac->AEPIssueCmd('poslist');
    }  
  }
  */
?>