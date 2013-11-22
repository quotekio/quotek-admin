<?php

require_once('adamobject.php');

class valuecfg extends adamobject {
	
  function __construct() {
        
  }

}

function getValueConfigs() {

  global $dbhandler;
  $vconfs = array();

  $dbh = $dbhandler->query("SELECT id FROM valuecfg;");
  while($ans = $dbh->fetch()) {
    $v = new valuecfg();
    $v->id = $ans['id'];
    $v->load();
    $vconfs[] = $v;
  }
  return $vconfs;
}

?>