<?php

  require_once('include/functions.inc.php');

  $lang = 'en';
  selectLanguage();

  require_once("lang/$lang/app.lang.php");
  require_once("classes/vhuser.php");
  require_once("classes/adamctl.php");
  require_once("classes/corecfg.php");
  //require_once("lang/$lang/success.lang.php");

  $ac = new adamctl();

  if (!verifyAuth()) die('You are not logged');

  if ( $_REQUEST['action'] == 'startReal') {
    exportCfg();
    $ac->startReal();
  }

  else if ( $_REQUEST['action'] == 'startDebug') {
    exportCfg();
    $ac->startReal($debug = true);
  }
  
  else if ( $_REQUEST['action'] == 'stop') {
    $ac->stop();
  }
  
  else if ( $_REQUEST['action'] == 'restart') {
    $ac->stop();
    exportCfg();
    $ac->startReal();
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

      if (isset($cs->pnl) ) {
        global $dbhandler;
        $t = time();
        $qstr = sprintf("INSERT INTO corestats_history (t,pnl,nbpos) VALUES ('%d','%f','%d');" , $t,$cs->pnl,$cs->nbpos);
        $dbh = $dbhandler->query($qstr);
        $ans = $dbh->execute();
      }
      echo $cs_str;
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