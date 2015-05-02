<?php

/* New class handling strategies through GIT */

require_once('adamobject.php');

class strategy extends adamobject {

  function __construct() {

  }

  function save() {
    if (isset($this->active)) {
        if ($this->active == 1) {
          global $ADAM_TMP;
          $fh = fopen("$ADAM_TMP/needs_restart","w");
          fwrite($fh, "1");
          fclose($fh);
        }
    }
    parent::save();
  }

  //old way, rewrite with parent::remap();
  function remap($params) {

    if (isset($params->id)) {
      $this->id = $params->id;
      $this->load();
    }

    if (isset($params->created)) {
      $this->created = $params->created;
    }
    else $this->created = time();

    if (isset($params->updated)) {
      $this->updated = $params->updated;
    }
    else $this->updated = time();    

    if (isset($params->author)) {
      $this->author = $params->author;
    }
    else {
      $this->author = "Admin";
    }

    $this->name = $params->name;
    $this->content = $params->content;
    $this->type = $params->type;

  }

  function activate() {
     global $dbhandler;
     $res = $dbhandler->query("UPDATE strategy SET active = 0;");
     $res = $dbhandler->query("UPDATE strategy SET active = 1 WHERE id='" . $this->id . "';");
  }

  function export() {

     global $ADAM_PATH;

     $strat_fname = str_replace(" ","_",$this->name);
     $strat_fname = str_replace("/","_", $strat_fname);
     $strat_fname = str_replace("\\","_", $strat_fname);
     $strat_fname = str_replace("(","_", $strat_fname);
     $strat_fname = str_replace(")","_", $strat_fname);
    
     $fh = fopen($ADAM_PATH . "/strats/" . $strat_fname . ".ts","w");
     fwrite($fh,$this->content);
     fclose($fh);
     return $strat_fname;
  }

}

function getStratsList($type='all') {
    /* Light list  to avoid xfer of 
    large amount of data */
    $slist = getStrategies($type);
    for($i=0;$i<count($slist);$i++ ) {
       $slist[$i]->content = "";
    }
    return $slist;
}

function getStrategies($type='all') {

  global $dbhandler;
  $slist = array();
  $dbh = null;
  if ($type == 'all') {
    $dbh = $dbhandler->query("SELECT id FROM strategy;");
  }
  else {
    $dbh = $dbhandler->query("SELECT id FROM strategy WHERE type= '$type';"); 
  }

  while($ans = $dbh->fetch()) {
    $s = new strategy();
    $s->id = $ans['id'];
    $s->load();
    $slist[] = $s;
  }
  return $slist;
}


function getActiveStrat() {

  global $dbhandler;
  $dbh = $dbhandler->query("SELECT id FROM strategy WHERE active = 1");
  $ans = $dbh->fetch();

  $strat = new strategy();
  $strat->id = $ans['id'];
  $strat->load();
  return $strat;
}


function exportStratModules() {

  global $dbhandler;
  $dbh = $dbhandler->query("SELECT id FROM strategy WHERE type ='module';");
  while($ans = $dbh->fetch()) {
     $strat = new strategy();
     $strat->id = $ans['id'];
     $strat->load();
     $strat->export();
  }
}


?>