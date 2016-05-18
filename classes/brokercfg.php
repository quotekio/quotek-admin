<?php

require_once('qateobject.php');

class brokercfg extends qateobject {

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
    $this->api_key = $ans['api_key'];
    $this->broker_mode = $ans['broker_mode'];
    $this->broker_account_mode = $ans['broker_account_mode'];


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