<?php

class adamctl {

  function __construct() {
    $this->supid = 'none';
    $this->mode = 'off';

    $this->supid = $this->getPID();

    if ($this->supid != "none") {
      $this->mode = $this->checkStatus($this->supid);
    }  

  }

  function AEPStartCLient($port_offset=0) {
    global $ADAM_AEP_ADDR;
    global $ADAM_AEP_PORT;
    $this->sock = @fsockopen($ADAM_AEP_ADDR,$ADAM_AEP_PORT+$port_offset,$errno,$errstr,3);

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

  function startReal($debug=false) {
    global $ADAM_PATH;
    global $ADAM_TMP;
    $outp = array();

    $pidtries = 10;

    if (!$debug) $cmd = "sudo $ADAM_PATH/bin/adam";
    else $cmd = "sudo screen -d -m -S adamdbg gdb -ex run $ADAM_PATH/bin/adam";

    if (file_exists("$ADAM_TMP/needs_restart")) {
      unlink("$ADAM_TMP/needs_restart");
    }
    if ($this->checkStatus($this->supid) == 'off') {
      
      if (!$debug) exec(sprintf("%s >/dev/null 2>&1 & ", $cmd),$outp);
      else exec($cmd,$outp);

      $this->supid = $this->findRealPID();

      while ($pidtries > 0 && $this->supid == "")  {
        $pidtries--;
        $this->supid = $this->findRealPID();
        sleep(.2);
      }

      $this->setPID($this->supid);

    }
    
    else echo "ALREADY RUNNING!";

  }

  function stop() {
    global $ADAM_PIDFILE;
    exec("sudo kill " . $this->supid );
    $this->mode = 'off';
  }

  function setPID($pid,$pidfile=null) {
    global $ADAM_PIDFILE;
    if ($pidfile == null) {
      $pidfile = $ADAM_PIDFILE; 
    }

    $fh = fopen($pidfile,"w");
    if ($fh) {
      fputs($fh,$pid);
      fclose($fh);
    }

  }


  function findRealPID()  {
    global $ADAM_PATH;
    exec("ps aux|grep $ADAM_PATH|egrep -v '(sudo|gdb|screen|grep)'|awk '{print $2}'",$outp);
    if (count($outp) > 0) return $outp[0];
    else return "";

  }


  function getPID($pid_f=null) {
    global $ADAM_PIDFILE;
    $pid = 'none';
    if ($pid_f == null ) $pidfile = $ADAM_PIDFILE;
    else $pidfile = $pid_f;

    if (file_exists($pidfile)) {
      $fh = fopen($pidfile,"r");
      if (!$fh) return 'none';
      $pid = fgets($fh);
      fclose($fh);
    }
    return $pid;
  }


  function checkStatus($pid) {
    
    if ($pid === 'none') return 'off';
    else {
        $result = shell_exec(sprintf("ps %d", $pid));

          if( count(preg_split("/\n/", $result)) > 2){
            return 'real';
          }
     return 'off';
    }
  }

}?>