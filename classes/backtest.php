<?php

@require_once ('classes/qateobject.php');
@require_once('classes/qatectl.php');
@require_once('include/functions.inc.php');

@require_once('classes/executor.php');

class backtestctl extends qatectl {

  function __construct($backtest) {
 
    global $QATE_TMP;

    $this->mode = 'off';
    $this->backtest = $backtest;

    $btid = $this->backtest->id;
    $this->supid = $this->getPID("$QATE_TMP/backtests/$btid/qate.pid");
   
    if ($this->supid != "none") {
      $this->mode = $this->checkStatus($this->supid);
    }

  }

  function startBT() {

    global $QATE_PATH;
    global $QATE_TMP;
    global $QATE_AEP_PORT;
    global $EXEC_QUEUE_FILE;

    $outp = array();

    $btid = $this->backtest->id;
    $from = $this->backtest->start;
    $strat = $this->backtest->strategy_name;
    $to = $this->backtest->end;

    $poffset = $this->findPorts();
    $port = $QATE_AEP_PORT + $poffset;
    $cfg = "$QATE_TMP/backtests/$btid/qate.conf";
    $btresult_file = "$QATE_TMP/backtests/$btid/results/" . time();

    $cmd = "$QATE_PATH/bin/qate -c ${cfg} --backtest -e --backtest-from ${from} --backtest-to ${to} -p ${port} -s ${strat} --backtest-result ${btresult_file} &";

    if ($this->checkStatus($this->supid) == 'off') {
      
      $ec = new executor($EXEC_QUEUE_FILE);

      //GRUUIIIK HACK: $(expr $! - 1) to retrieve PID !!
      $ec->enqueue("sudo sh -c '$cmd 2>&1 >/dev/null & echo $(expr $! - 1) > $QATE_TMP/backtests/$btid/qate.pid'");

      //writes ws port to be found back.
      file_put_contents("$QATE_TMP/backtests/$btid/qate.aep.port",$port);

      //puts commandline in file, for debug purpose.
      file_put_contents("$QATE_TMP/backtests/$btid/qate.bt.cmd",$cmd);

      echo  "ws://" . $_SERVER['SERVER_NAME'] . ":" . ($port + 1) ;

    }
    else echo "ALREADY RUNNING!";
  }

  function stopBT() {

    global $QATE_TMP;
    if ($this->supid =='none') {
      $this->supid = $this->getPID("$QATE_TMP/backtests/" . $this->backtest_id . "/qate.pid");
    }
    exec("sudo kill " . $this->supid );
    $this->mode = 'off';
  }

  //retrieves websocket when want to reconnect.
  function getWebSocket() {

    global $QATE_TMP;

    $btid = $this->backtest->id;
    $port = file_get_contents("$QATE_TMP/backtests/$btid/qate.aep.port");
         
    if (! is_numeric($port)) return "none";

    return  "ws://" . $_SERVER['SERVER_NAME'] . ":" . ($port + 1) ;

  }

}


class backtest extends qateobject {

  function __construct() {
        
  }

  function delete() {
    global $QATE_TMP;
    if (is_numeric($this->id)) {
      if (is_dir($QATE_TMP . "/backtests/" . $this->id) ) {
        @rmdir_recurse($QATE_TMP . "/backtests/" . $this->id);
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

  }

  function createTree() {
    global $QATE_TMP;
    @mkdir("$QATE_TMP/backtests");
    @mkdir("$QATE_TMP/backtests/" .  $this->id );
    @mkdir("$QATE_TMP/backtests/" . $this->id . "/results");
  }

  function getResult($result) {

    $res_string = "";
    global $QATE_TMP;
    $results_dir = "$QATE_TMP/backtests/" . $this->id . "/results";
    $fh = @fopen($results_dir . "/" . $result,"r");
    if ($fh) {
       while($line = fgets($fh) ) {
         $res_string .= $line;
       }
    }    
    return $res_string;
  }

  function deleteResult($result) {

    global $QATE_TMP;
    $results_dir = "$QATE_TMP/backtests/" . $this->id . "/results";
    if (is_file("$results_dir/$result") ) {
      unlink("$results_dir/$result");   
    }

  }

  function hasResult() {
    if (count($this->getResultsList()) > 0 ) return true;
    return false;
  }

  function getResultsList() {

    global $QATE_TMP;
    $results = array();

    $results_dir = "$QATE_TMP/backtests/" . $this->id . "/results";
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
    global $QATE_TMP;
    $cfgpath = "$QATE_TMP/backtests/" . $this->id . "/qate.conf";

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