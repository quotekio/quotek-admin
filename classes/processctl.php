<?php

class processctl {

  function __construct($pname) {
  	global $SITE_ROOT;
  	global $ADAM_TMP;
    $this->pname = $pname;
    $this->process_path  = $SITE_ROOT . "/../processes/";
    $this->pidfile = $ADAM_TMP . "/" . $pname . ".pid";
    $this->mode = "off";
    $this->pid = $this->getPID();
    if ($this->pid != "none") {
      $this->mode = $this->checkStatus($this->pid);
    }
  }

  function start() {

    $cmd = "php " . $this->process_path . $this->pname . ".php >/dev/null 2>&1 & echo $!";
    
    exec($cmd,$outp);
    $this->pid = $outp;
    file_put_contents($this->pidfile, $this->pid);

  }

  function stop() {
    $cmd = "kill -9 " . $this->pid;
    exec($cmd);
  }

  function restart() {
    $this->stop();
    $this->start();
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

  function getPID($pid_f=null) {

   $pid = 'none';
   if (file_exists($this->pidfile)) {
     $fh = fopen($this->pidfile,"r");
     if (!$fh) return 'none';
     $pid = fgets($fh);
     fclose($fh);
   }
   return $pid;
 }


};


?>