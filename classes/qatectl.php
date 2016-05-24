<?php

require_once "corecfg.php";
require_once "executor.php";

class qatectl {

  function __construct() {
    $this->supid = 'none';
    $this->mode = 'off';

    $this->supid = $this->getPID();

    if ($this->supid != "none") {
      $this->mode = $this->checkStatus($this->supid);
    }  

  }

  function AEPStartCLient($port_offset=0) {
    global $QATE_AEP_ADDR;
    global $QATE_AEP_PORT;
    $this->sock = @fsockopen($QATE_AEP_ADDR,$QATE_AEP_PORT+$port_offset,$errno,$errstr,3);

    if ( $this->sock) {
        stream_set_blocking($this->sock, true);
        stream_set_timeout($this->sock,1);
    }
    return $this->sock;
  }

  function AEPIssueCmd($cmd) {

    fwrite($this->sock,$cmd . "\r\n");
    $ans = "";
    while( ! strstr($ans,"\r\n\r\n") ) {
      $ans .= fread($this->sock,128);
    }

    fclose($this->sock);
    if ($ans == "") $ans = "{}";
    return $ans;


  }


  function compile($data) {
    
    global $QATE_PATH;
    global $QATE_TMP;
    $outp = array();

    $result = 0;

    $tmp_cpath = "${QATE_TMP}/cenv/";
    file_put_contents("${tmp_cpath}/temp.qs", $data);

    $cmd = "sudo ${QATE_PATH}/bin/qate --compile -x ${tmp_cpath} -s temp.qs";

    exec($cmd,$outp,$result);
    return $result;
    
  }

  //quick backtest for non-saved strats, without saving.
  function qbacktest($data, $cfgid, $from, $to) {

    global $QATE_PATH;
    global $QATE_TMP;
    global $QATE_AEP_PORT;
    global $EXEC_QUEUE_FILE;

    $poffset = $this->findPorts();
    $port = $QATE_AEP_PORT + $poffset;

    $tmp_cpath = "${QATE_TMP}/cenv/";
    file_put_contents("${tmp_cpath}/temp.qs", $data);

    //exports config
    exportCfg($cfgid ,null,"${tmp_cpath}/temp.cfg",false);

    $cmd = "sudo ${QATE_PATH}/bin/qate -c ${tmp_cpath}/temp.cfg --backtest -e --backtest-from ${from} --backtest-to ${to} -p ${port} -x ${tmp_cpath} -s temp.qs &";
    
   
    $ec = new executor($EXEC_QUEUE_FILE);
    $ec->enqueue($cmd);
    
    return  "ws://" . $_SERVER['SERVER_NAME'] . ":" . ($port + 1) ;

  }

  function startReal() {
    global $QATE_PATH;
    global $QATE_TMP;
    $outp = array();

    //$pidtries = 10;

    $cmd = "sudo /etc/init.d/qate start";

    if (file_exists("$QATE_TMP/needs_restart")) {
      unlink("$QATE_TMP/needs_restart");
    }

    if ($this->checkStatus($this->supid) == 'off') {
      
      exec($cmd,$outp);

      /*
      $this->supid = $this->findRealPID();
      while ($pidtries > 0 && $this->supid == "")  {
        $pidtries--;
        $this->supid = $this->findRealPID();
        sleep(.2);
      }
      */

      //$this->setPID($this->supid);

    }
    
    else echo "ALREADY RUNNING!";

  }

  function stop() {
    global $QATE_PIDFILE;
    exec("sudo /etc/init.d/qate stop");
    $this->mode = 'off';
  }

  
  //UNDEPRECATED, still required for backtests.
  function setPID($pid,$pidfile=null) {
    global $QATE_PIDFILE;
    if ($pidfile == null) {
      $pidfile = $QATE_PIDFILE; 
    }

    $fh = fopen($pidfile,"w");
    if ($fh) {
      fputs($fh,$pid);
      fclose($fh);
    }

  }

  function findRealPID()  {
    global $QATE_PATH;
    exec("ps aux|grep $QATE_PATH|egrep -v '(sudo|gdb|screen|grep|php)'|awk '{print $2}'",$outp);
    if (count($outp) > 0) return $outp[0];
    else return "";

  }


  function getPID($pid_f=null) {
    global $QATE_PIDFILE;
    if ($pid_f == null ) $pidfile = $QATE_PIDFILE;
    else $pidfile = $pid_f;
    
    $pid = @file_get_contents($pidfile);
    if ( $pid === false ) return 'none';
    else return $pid;

  }

  function checkStatus($pid) {
    
    if ($pid === 'none') return 'off';
    else {
        $result = shell_exec(sprintf("ps %d", $pid));

          if( count(preg_split("/\n/", $result)) > 2){
            return 'on';
          }
     return 'off';
    }
  }


  //This function finds 2 available ports (AEP + AEP/WS) for backtesting
  function findPorts() {

    global $QATE_AEP_ADDR;
    global $QATE_AEP_PORT;

    for ($offset=1;$offset< 1000;$offset=$offset + 2) {
      $this->sock = @fsockopen($QATE_AEP_ADDR,$QATE_AEP_PORT + $offset,$errno,$errstr,1);
      $this->sock2 = @fsockopen($QATE_AEP_ADDR,$QATE_AEP_PORT + $offset +1 ,$errno,$errstr,1);
      if (! $this->sock && ! $this->sock2 ) return $offset;
    }
  }

  function getCompileErrors() {

    global $QATE_TMP;

    $cp_errors = file_get_contents("$QATE_TMP/compiler.errors.log");
    $cp_errors = trim( str_replace("\n","<br>", $cp_errors) );
    if ($cp_errors === false) $cp_errors = "";
    return $cp_errors;

  }


}?>
