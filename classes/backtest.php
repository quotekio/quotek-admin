<?php

@require_once ('classes/adamobject.php');
@require_once('classes/adamctl.php');
@require_once('include/functions.inc.php');

class backtestctl extends adamctl {

  function __construct() {
    $this->supid = 'none';
    $this->mode = 'off';
  }

  function setBacktestID($backtest_id) {

    global $ADAM_TMP;
    $this->backtest_id = $backtest_id;
    $this->supid = $this->getPID("$ADAM_TMP/backtests/" . $this->backtest_id . "/adam.pid");
   
    if ($this->supid != "none") {
      $this->mode = $this->checkStatus($this->supid);
    }

  }

  function setBTArgs($bt_args) {
    $this->bt_args = $bt_args;
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

  function stopBT() {

    global $ADAM_TMP;
    if ($this->supid =='none') {
      $this->supid = $this->getPID("$ADAM_TMP/backtests/" . $this->backtest_id . "/adam.pid");
    }
    exec("sudo kill " . $this->supid );
    $this->mode = 'off';
  }

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

    parent::save();
    $this->createTree();

    $e_args = array();
    $e_args[] = $this->start;
    $e_args[] = $this->end;

    $bt_values = getCfgValues($this->config_id);
    foreach ($bt_values as $bt_value) {
      $e_args[] = $bt_value->name;
    }

    $e = new backtestctl();
    $e->setBacktestID($this->id);
  }

  function createTree() {
    global $ADAM_TMP;
    @mkdir("$ADAM_TMP/backtests");
    @mkdir("$ADAM_TMP/backtests/" .  $this->id );
    @mkdir("$ADAM_TMP/backtests/" . $this->id . "/results");
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

  function deleteResult($result) {

    global $ADAM_TMP;
    $results_dir = "$ADAM_TMP/backtests/" . $this->id . "/results";
    if (is_file("$results_dir/$result") ) {
      unlink("$results_dir/$result");   
    }

  }

  function hasResult() {
    if (count($this->getResultsList()) > 0 ) return true;
    return false;
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


  function appendGeneticsParams() {
    global $ADAM_TMP;
    $cfgpath = "$ADAM_TMP/backtests/" . $this->id . "/adam.conf";

    $fh = fopen($cfgpath,'a');
    fwrite($fh,"genetics_population = " . $this->genetics_population . "\n" );
    fwrite($fh,"genetics_survivors = " . $this->genetics_survivors . "\n" );
    fwrite($fh,"genetics_converge_thold = " . $this->genetics_converge_thold . "\n" );
    fwrite($fh,"genetics_max_generations = " . $this->genetics_max_generations . "\n" );
    fclose($fh);
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