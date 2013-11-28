<?php

require_once('adamobject.php');


class gwctl {

   function __construct($bid) {

     global $ADAM_TMP;

     $this->brokercfg = new brokercfg();
     $this->brokercfg->id = $bid;
     $this->brokercfg->load();

     $this->pidfile = $ADAM_TMP . "/gw" . $this->brokercfg->id . ".pid";

     $this->pid = 'none';
     $this->status = 'off';

     $this->getPID();

    if ($this->pid != "none") {
      $this->checkStatus();
    }
    
   }

  function checkStatus() {

    if ($this->pid === 'none') return 'off';
    else {
      $result = shell_exec(sprintf("ps %d", $this->pid));
      if( count(preg_split("/\n/", $result)) > 2) {
         $this->mode = 'running';
         return $this->mode;
      }

      $this->pid = null;
      $this->mode = 'off';
      return 'off';

     }
  }

   function getPID() {
     if (file_exists($this->pidfile)) {
      $fh = fopen($this->pidfile,"r");
      if (!$fh) return 'none';
      $this->pid = fgets($fh);
      fclose($fh);
      return $this->pid;
    }
   }

   function setPID() {
     $fh = fopen($this->pidfile,"w");
     if ($fh) {
       fputs($fh,$this->pid);
       fclose($fh);
     }
   }
  

   function getCMD() {
     $this->cmd = "";
     $mod = $this->brokercfg->getBrokerModule();
     $cmd_tpl = $mod['gateway_cmd'];
     $this->cmd = str_replace('%USERNAME%',$this->brokercfg->username,$cmd_tpl);
     $this->cmd = str_replace('%PASSWORD%',$this->brokercfg->password,$this->cmd);
   }

   function startGW() {

    global $ADAM_PATH;
    global $ADAM_TMP;
    $outp = array();

    $this->getCMD();

    $this->cmd = "sudo " . $this->cmd ;
    if ($this->checkStatus() == 'off') {
      exec(sprintf("%s >/dev/null 2>&1 & " . 'echo $!' , $this->cmd),$outp);
      $this->pid = $outp[0];
      $this->setPID();
    }
    else echo "ALREADY RUNNING!";

   }

   function stopGW() {
     exec("sudo kill " . $this->pid );
     exec("sudo pkill -9 igm-launcher");
     exec("sudo pkill -9 phantomjs");
     @unlink($this->pidfile);
     $this->pid = 'none';
     $this->mode = 'off';
   }

}


class brokercfg extends adamobject {

  function __construct() {
        
  }

  function load() {
    global $dbhandler;
    $dbh = $dbhandler->query("SELECT * FROM brokercfg WHERE id= '" . $this->id . "';");
    $ans = $dbh->fetch();

    $this->name = $ans['name'];
    $this->username = $ans['username'];
    $this->password = $ans['password'];
    $this->broker_id = $ans['broker_id'];

  }


  function requiresGW() {
    $bmod = $this->getBrokerModule();
    return $bmod['gateway_cmd'];
  }

  function getBrokerModule() {  
     global $dbhandler;
     $dbh = $dbhandler->query("SELECT * FROM broker WHERE id = '" . $this->broker_id . "';");
     $ans = $dbh->fetch();
     return $ans;
  }
}

function getBrokerModules() {
    $bmodules = array();
    global $dbhandler;
    $dbh = $dbhandler->query("SELECT * FROM broker;");

    while($ans = $dbh->fetch()) {
        $bmodules[] = $ans;
    }
    return $bmodules;
}

function getBrokerConfigs() {

  global $dbhandler;
  $bconfs = array();

  $dbh = $dbhandler->query("SELECT id FROM brokercfg;");

  while($ans = $dbh->fetch()) {

    $b = new brokercfg();
    $b->id = $ans['id'];
    $b->load();
    $bconfs[] = $b;
  }
  return $bconfs;
}

?>