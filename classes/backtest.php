<?php

@require_once ('classes/adamobject.php');
@require_once('classes/adamctl.php');
@require_once('include/functions.inc.php');

class backtestctl extends adamctl {

  function __construct() {
    $this->supid = 'none';
    $this->mode = 'off';
    $this->expid = 'none';
  }

  function setBacktestID($backtest_id) {

    global $ADAM_TMP;
    $this->backtest_id = $backtest_id;
    $this->supid = $this->getPID("$ADAM_TMP/backtests/" . $this->backtest_id . "/adam.pid");
    $this->expid = $this->getPID("$ADAM_TMP/backtests/" . $this->backtest_id . "/exporter.pid");
    if ($this->supid != "none") {
      $this->checkStatus($this->supid);
    }

    if ($this->expid != "none") {
      $this->checkStatus($this->expid);
    }
  
  }

  function setBacktestHash($hash) {
    $this->backtest_hash = $hash;
  }

  function setExporterArgs($e_args) {
    $this->e_args = $e_args;
  }

  function setBTArgs($bt_args) {
    $this->bt_args = $bt_args;
  }

  function startExporter() {
    global $ADAM_PATH;
    global $ADAM_TMP;
    global $ADAM_BT_EXPORTS;

    $outp = array();
    $cmd = "sudo $ADAM_PATH/tools/vstore2dump ";

    foreach($this->e_args as $e_arg) {
      $cmd .= "$e_arg ";
    }

    if ($this->checkStatus($this->expid) == 'off') {
      exec(sprintf("%s >/dev/null 2>&1 & " . 'echo $!' , $cmd),$outp);
      $this->expid = $outp[0];
      $this->setPID($this->expid,"$ADAM_TMP/backtests/" . $this->backtest_id . "/exporter.pid");
    }
    else echo "ALREADY RUNNING!";

  }

  function startBT() {
    global $ADAM_PATH;
    global $ADAM_TMP;
    global $ADAM_BT_EXPORTS;

    $outp = array();
    $cmd = "sudo $ADAM_PATH/bin/adam ";

    foreach($this->bt_args as $bt_arg) {
      $cmd .= "$bt_arg ";
    }

    if ($this->checkStatus($this->supid) == 'off') {
      exec(sprintf("%s >/dev/null 2>&1 & " . 'echo $!' , $cmd),$outp);
      $this->supid = $outp[0];
      $this->setPID($this->supid,"$ADAM_TMP/backtests/" . $this->backtest_id . "/adam.pid");
    }
    else echo "ALREADY RUNNING!";
  }

/*
  function checkExporterStatus() {
    if ( )
  }
*/

}




class backtest extends adamobject {

  function __construct() {
        
  }

  function delete() {
    global $ADAM_TMP;
    if (is_numeric($this->id)) {
      if (is_dir($ADAM_TMP . "/backtests/" . $this->id) ) {
        @rmdir_recurse($ADAM_TMP . "/backtests/" . $this->id);
      }
      parent::delete();
    }
  }

  function save() {

    global $ADAM_BT_EXPORTS;

    parent::save();
    $this->createTree();
    $hash = $this->generateDumpSig();

    if (!is_file("$ADAM_BT_EXPORTS/$hash") ) {

       $e_args = array();
       $e_args[] = $this->start;
       $e_args[] = $this->end;
       $e_args[] = $ADAM_BT_EXPORTS . "/" . $hash;

       $bt_values = getCfgValues($this->config_id);
       foreach ($bt_values as $bt_value) {
         $e_args[] = $bt_value->name;
       }

       $e = new backtestctl();
       $e->setBacktestID($this->id);
       $e->setBacktestHash($hash);
       $e->setExporterArgs($e_args);
       $e->startExporter();
    }



  }

  function createTree() {
    global $ADAM_TMP;
    @mkdir("$ADAM_TMP/backtests");
    @mkdir("$ADAM_TMP/backtests/" .  $this->id );
    @mkdir("$ADAM_TMP/backtests/" . $this->id . "/results");
  }

  function generateDumpSig() {
    $bt_values = getCfgValues($this->config_id);
    $hash= $this->start . ":" . $this->end;
    foreach($bt_values as $value) {
      $hash .= ":" . $value->name;
    }
    return sha1($hash);
  }

  function getResult($result) {

    $res_string = "";
    global $ADAM_TMP;
    $results_dir = "$ADAM_TMP/backtests/" . $this->id . "/results";
    $fh = @fopen($results_dir . "/" . $result,"r");
    if ($fh) {
       while($line = fgets($fh) ) {
         $res_string .= $line;
       }
    }    
    return $res_string;
  }

  function getResultsList() {

    global $ADAM_TMP;
    $results = array();

    $results_dir = "$ADAM_TMP/backtests/" . $this->id . "/results";
    $rdir_handler = @opendir($results_dir);

    if ($rdir_handler) {
      while($f = readdir($rdir_handler) ) {
        if ($f != '.' && $f != '..') {
          $results[] = array('tstamp' => $f, 'date' => $f);
        }
      }
    }

    return $results;
  }

}




function getBacktests() {

  global $dbhandler;
  $blist = array();

  $dbh = $dbhandler->query("SELECT id FROM backtest;");

  while($ans = $dbh->fetch()) {

    $b = new backtest();
    $b->id = $ans['id'];
    $b->load();
    $blist[] = $b;
  }
  return $blist;
}

?>

