<?php

  require_once('include/functions.inc.php');

  $lang = 'en';
  selectLanguage();

  require_once("lang/$lang/app.lang.php");
  require_once("classes/user.php");
  require_once("classes/adamctl.php");
  require_once("classes/corecfg.php");
  //require_once("lang/$lang/success.lang.php");

  $ac = new adamctl();

  if (!verifyAuth()) die('You are not logged');

  $u = new user();
  $u->id = $_SESSION['uinfos']['id'];
  $u->load();
  $u->loadPermissions();

  $resp = array("status" => "OK","message" => "");

  if ( $_REQUEST['action'] == 'wsinfo' ) {

    $cfg = getActiveCfg();
    echo json_encode(array("address" => "ws://" . $_SERVER['SERVER_NAME'] . ":" . (  $cfg->aep_listen_port + 1   )) );

  }


  else if ( $_REQUEST['action'] == 'compile'  ) {

    $source = $_REQUEST['source'];

    exportCfg();
    $res = $ac->compile($source);

    if ($res != 0) {
      $resp["status"] = "ERROR";
      $resp["message"] = "COMPILE_ERRORS:" . $ac->getCompileErrors();
    }

    echo json_encode($resp);
    
  }

  else if ( $_REQUEST['action'] == 'qbacktest' ) {

    $source = $_REQUEST['source'];
    $from = $_REQUEST['from'];
    $to = $_REQUEST['to'];
    $cfgid = $_REQUEST['cfg'];

    $res = $ac->qbacktest($source, $cfgid, $from, $to);
    $resp['message'] = $res;

    echo json_encode($resp);

  }


  else if ( $_REQUEST['action'] == 'startReal') {

    if ( $u->checkPermissions(array('start_bot'))  ) {
      exportCfg();
      $ac->startReal();
    }

    else {
      $resp["status"] = "ERROR";
      $resp["message"] ="NO_PERMISSION:start_bot";
    }

    echo json_encode($resp);

  }

  else if ( $_REQUEST['action'] == 'stop') {
    if ( $u->checkPermissions(array('stop_bot'))  ) {
      $ac->stop();
    }
    else {
      $resp["status"] = "ERROR";
      $resp["message"] ="NO_PERMISSION:stop_bot"; 
    }

    echo json_encode($resp);

  }
  
  else if ( $_REQUEST['action'] == 'restart') {
    if ( $u->checkPermissions(array('restart_bot'))  ) {
      $ac->stop();
      exportCfg();
      $ac->startReal();
    }
    else {
      $resp["status"] = "ERROR";
      $resp["message"] ="NO_PERMISSION:restart_bot";
    }

    echo json_encode($resp);
  }
  
  else if ( $_REQUEST['action'] == 'getStatus') {

    $state = $ac->checkStatus($ac->supid);
    $nr = file_exists('/tmp/adam/needs_restart') ;
    $compile_errors = $ac->getCompileErrors();

    $message = $lang_array['app']['adam_mode']["$state"];

    $res = array('state' => $state, 
                'message' => $message, 
                'needs_restart' => $nr, 
                'compile' => $compile_errors );
 
    echo json_encode($res);

  } 
  
  else if ($_REQUEST['action'] == 'getCorestats') {
    
    if ($ac->AEPStartCLient()) {

      $cs_str = $ac->AEPIssueCmd('corestats');
      $cs = json_decode($cs_str);

      $cs->unrealized_pnl  = sprintf("%.2f", $cs->unrealized_pnl);
      echo json_encode($cs);
    }
    else echo "{}";

  }  

  else if ($_REQUEST['action'] == 'getLastLogs') {

    if (isset($_REQUEST['nb_entries']) && is_numeric($_REQUEST['nb_entries'])) {

      if ($ac->AEPStartCLient()) {
        echo $ac->AEPIssueCmd('lastlogs ' . $_REQUEST['nb_entries']);
      }
      else echo "{}";  
    }
  }

  else if ($_REQUEST['action'] == 'getPosList') {
    if ($ac->AEPStartCLient()) {
      echo $ac->AEPIssueCmd('poslist');
    }  
  }

  else if ($_REQUEST['action'] == 'getAlgos') {

    if ($ac->AEPStartCLient()) {

      //here we will round first
      $outp = $ac->AEPIssueCmd('algos');

      
      $aldata = json_decode($outp);
      
      for ($i=0;$i<count($aldata);$i++) {
        $aldata[$i]->pnl =  sprintf("%.2f",$aldata[$i]->pnl) ;
      }

      echo json_encode($aldata); 

    }

    else echo "[]";

  }

  else if ($_REQUEST['action'] == 'getVersion') {
    if ($ac->AEPStartCLient()) {
      echo $ac->AEPIssueCmd('version');
    }
  }
  
  else if ($_REQUEST['action'] == 'closepos')  {
     $dealid = $_REQUEST['dealid'];
     if ($ac->AEPStartCLient()) {
       echo $ac->AEPIssueCmd("order closepos:$dealid");
    }
  }

  else if ($_REQUEST['action'] == 'order') {
    $order = $_REQUEST['order'];
    if ($ac->AEPStartCLient()) {
       echo $ac->AEPIssueCmd("order $order");
    }

  }


?>